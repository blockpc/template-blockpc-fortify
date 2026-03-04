<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Permission as ModelsPermission;

final class Permission extends ModelsPermission
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'key',
        'guard_name',
    ];

    /**
     * Filter permissions by search term across name, display_name, description, and key.
     */
    #[Scope]
    public function search(Builder $query, ?string $search): Builder
    {
        if (empty($search)) {
            return $query;
        }

        return $query->whereLike(['name', 'display_name', 'description', 'key'], $search);
    }

    /**
     * Scope a query to only include permissions visible to the current user.
     *
     * If the user does not have the 'sudo' role, exclude the 'super admin' permission.
     */
    #[Scope]
    public function visibleToUser($query): Builder
    {
        return $query->when(auth()->check() && ! auth()->user()->hasRole('sudo'), function ($query) {
            $query->where('name', '!=', 'super admin');
        });
    }
}

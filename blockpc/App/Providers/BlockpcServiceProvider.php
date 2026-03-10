<?php

declare(strict_types=1);

namespace Blockpc\App\Providers;

use Blockpc\App\Commands\SqlWatchCommand;
use Blockpc\App\Commands\SyncPermissionsCommand;
use Blockpc\App\Commands\SyncRolesCommand;
use Blockpc\App\Mixins\Search;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

use function Illuminate\Log\log;

class BlockpcServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(BlockpcAuthServiceProvider::class);
        Builder::mixin(new Search);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerConsoleCommands();

        DB::listen(function ($query) {
            $this->sqlWatch($query);
        });
    }

    /**
     * Register console commands when running in console.
     */
    private function registerConsoleCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SqlWatchCommand::class,
                SyncPermissionsCommand::class,
                SyncRolesCommand::class,
            ]);
        }
    }

    /**
     * Log slow SQL queries matching the watched URL pattern.
     */
    private function sqlWatch(QueryExecuted $query): void
    {
        if ($query->time < 200) {
            return;
        }

        $pattern = Cache::get('sql_watch_url_pattern');
        if (! $pattern) {
            return;
        }

        $path = request()?->path();
        if (! $path || ! Str::is($pattern, $path)) {
            return;
        }

        log()->channel('single')->info('SQL', [
            'sql' => $query->sql,
            'bindings' => $query->bindings,
            'time_ms' => $query->time,
            'url' => request()->fullUrl(),
        ]);
    }
}

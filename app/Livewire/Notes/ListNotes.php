<?php

declare(strict_types=1);

namespace App\Livewire\Notes;

use App\Models\Note;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

final class ListNotes extends Component
{
    public bool $createOpen = false;

    public bool $editOpen = false;

    public ?int $editingId = null;

    public bool $deleteOpen = false;

    public ?int $deletingId = null;

    public string $title = '';

    public string $content = '';

    #[Url(as: 'q')]
    public string $search = '';

    #[Layout('layouts.app')]
    #[Title('Notas')]
    public function render(): View
    {
        return view('livewire.notes.list-notes');
    }

    #[Computed()]
    public function notes(): Collection|SupportCollection
    {
        return Note::query()
            ->forUser(auth()->id())
            ->search($this->search)
            ->latest()
            ->get();
    }

    public function create(): void
    {
        $data = $this->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('notes')->where('author_id', auth()->id())],
            'content' => ['required', 'string'],
        ]);

        $data['author_id'] = auth()->id();

        Note::create($data);

        $this->resetModalsVariables();
    }

    public function openEdit(int $id): void
    {
        $note = Note::query()
            ->forUser(auth()->id())
            ->findOrFail($id);

        $this->editingId = $note->id;
        $this->title = $note->title;
        $this->content = $note->content;
        $this->editOpen = true;
    }

    public function update(): void
    {
        $data = $this->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('notes')->where('author_id', auth()->id())->ignore($this->editingId)],
            'content' => ['required', 'string'],
        ]);

        $note = Note::query()
            ->forUser(auth()->id())
            ->findOrFail($this->editingId);
        $note->update($data);

        $this->resetModalsVariables();
    }

    public function openDelete(int $id): void
    {
        $note = Note::query()
            ->forUser(auth()->id())
            ->findOrFail($id);

        $this->deletingId = $note->id;
        $this->deleteOpen = true;
    }

    public function destroy(): void
    {
        Note::query()
            ->forUser(auth()->id())
            ->findOrFail($this->deletingId)
            ->delete();

        $this->reset(['deletingId']);
        $this->resetModalsVariables();
    }

    private function resetModalsVariables(): void
    {
        $this->reset(['title', 'content', 'editingId', 'deletingId', 'createOpen', 'editOpen', 'deleteOpen']);
    }
}

<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontend')]
class Home extends Component
{
    public function render(): View
    {
        return view('livewire.home');
    }
}

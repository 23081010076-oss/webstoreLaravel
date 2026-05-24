<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class Page extends Component
{
    #[Title('Page')]
    public function render()
    {
        return view('livewire.page');
    }
}

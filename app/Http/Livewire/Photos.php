<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Photos extends Component
{
    public $photos = [];

    public function render()
    {
        return view('livewire.photos');
    }
}

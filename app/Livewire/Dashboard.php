<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Topic;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function render()
    {
        $topic = Topic::count();

        return view('livewire.dashboard', [
            'topic' => $topic
        ]);
    }
}

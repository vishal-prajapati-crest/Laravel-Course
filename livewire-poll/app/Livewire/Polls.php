<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Poll;
use Livewire\Component;

class Polls extends Component
{
    public $polls;

    protected $listeners = [
        'pollCreated' => 'render'
    ];
    public function render()
    {
        $this->polls = Poll::with('options.votes')->latest()->get();

        return view('livewire.polls');
    }

    public function vote($optionId)
    {
        $option = Option::findOrFail($optionId);
        $option->votes()->create();
    }
}

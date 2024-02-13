<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use App\Models\Poll;
use Livewire\Component;

class CreatePoll extends Component
{
    #[validate]
    public $title;
    public $options = [''];

    public function rules()
    {
        return [
        'title' => 'required|min:3|max:255',
        'options' => 'required|array|min:1|max:10',
        'options.*' => 'required|min:1|max:255'
        ];
    }

    //custom message for option
    protected $messages = [
        'options.*' => "The Option Can't be empty."
    ];

    public function render()
    {
        return view('livewire.create-poll');
    }

    public function addOption(){
        $this->options[] = '';
    }

    public function removeOption($index){
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function createPoll(){

        $this->validate();

       Poll::create([
            'title' => $this->title
        ])->options()->createMany(
                collect($this->options)
                    ->map(fn ($option) => ['name' => $option])
                    ->all()
        );

        // foreach($this->options as $optionName){

        //     $poll->options()->create(['name' => $optionName]);
        // }

        // $this->title = '';
        // $this->options = [''];

        $this->reset(['title','options']);
        $this->dispatch('pollCreated');
    }

}



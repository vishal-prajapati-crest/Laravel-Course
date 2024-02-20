<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RadioGroup extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public array $options
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.radio-group');
    }

    public function optionsWithLabel(): array
    {
        // it will return labeled array with same as value if the array is list i.e. ['a','x',...] then ['a'=>'a','x'=>'x',....] if already atrribute array then simple return it
        return array_is_list($this->options) ? array_combine($this->options,$this->options) : $this->options;
    }
}

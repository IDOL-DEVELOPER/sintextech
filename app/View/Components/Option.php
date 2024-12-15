<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Option extends Component
{
    public $value;
    public $text;
    public $selected;
    public $disabled;
    public function __construct($value = "", $text = "", $selected = "", $disabled = "")
    {
        $this->value = $value;
        $this->selected = $selected;
        $this->disabled = $disabled;
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.option');
    }
}

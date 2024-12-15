<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public $type;
    public $label;
    public $name;
    public $id;

    public $extendClass;
    public $labelextendClass;
    public $old;
    public $disabled;
    public $value;
    public $required;

    public $attr;
    public $extraClass;
    public $placeholder;


    public function __construct($type, $label, $name = '', $id = '', $extendClass = '', $old = '', $labelextendClass = '', $disabled = '', $value = '', $required = '', $attr = '', $extraClass = '', $placeholder = '')
    {
        $this->type = $type;
        $this->label = $label;
        $this->name = $name;
        $this->id = $id;
        $this->extendClass = $extendClass;
        $this->old = $old;
        $this->labelextendClass = $labelextendClass;
        $this->disabled = $disabled;
        $this->value = $value;
        $this->required = $required;
        $this->attr = $attr;
        $this->extraClass = $extraClass;
        $this->placeholder = $placeholder;
    }


    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}

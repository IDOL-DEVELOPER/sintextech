<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    public $id;
    public $name;
    public $class;
    public $cols;
    public $rows;
    public $placeholder;


    public $label;
    public $extendClass;
    public $labelextendClass;
    public $old;
    public $disabled;
    public $value;
    public $required;

    public $attr;
    public $extraClass;

    public function __construct($id, $label, $old = "", $disabled = "", $value = "", $attr = "", $extraClass = "", $name = "", $class = "", $cols = "", $rows = "", $placeholder = "", $required = "", $extendClass = "", $labelextendClass = "", )
    {
        $this->id = $id;
        $this->name = $name;
        $this->class = $class;
        $this->placeholder = $placeholder;
        $this->cols = (int) $cols;
        $this->rows = (int) $rows;
        $this->label = $label;
        $this->name = $name;
        $this->extendClass = $extendClass;
        $this->old = $old;
        $this->labelextendClass = $labelextendClass;
        $this->disabled = $disabled;
        $this->value = $value;
        $this->required = $required;
        $this->attr = $attr;
        $this->extraClass = $extraClass;
        ;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.textarea');
    }
}

<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputFile extends Component
{

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
    public $fn;
    public $src;
    public $classPreview;
    public $multiple;

    public $fileName;


    public function __construct($classPreview = "", $src = "", $fn = "", $label = "", $name = '', $id = '', $extendClass = '', $old = '', $labelextendClass = '', $disabled = '', $value = '', $required = '', $attr = '', $extraClass = '', $placeholder = '', $multiple = '', $fileName = '')
    {
        $this->fn = $fn;
        $this->src = $src;
        $this->classPreview = $classPreview;
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
        $this->multiple = $multiple;
        $this->fileName = $fileName;
    }



    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input-file');
    }
}

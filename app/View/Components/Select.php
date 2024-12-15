<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public $class;
    public $id;
    public $extraClass;
    public $label;
    public $required;
    public $name;
    public $attr;
    public function __construct($id, $label, $class = "", $extraClass = "", $required = "", $name = "", $attr = "")
    {
        $this->id = $id;
        $this->class = $class;
        $this->label = $label;
        $this->name = $name;
        $this->required = $required;
        $this->extraClass = $extraClass;
        $this->attr = $attr;
    }

    public function render(): View|Closure|string
    {
        return view('components.select');
    }
}

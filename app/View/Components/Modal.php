<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{

    public $id;
    public $title;
    public $icon;
    public $class;
    public $btnName;
    public $btnClass;
    public $attr;
    public $validNot;
    public $classFooter;


    public function __construct($id, $title, $btnName = "", $icon = "", $attr = "", $class = "", $btnClass = "", $validNot = "", $classFooter = "")
    {
        $this->id = $id;
        $this->title = $title;
        $this->btnName = $btnName;
        $this->btnClass = $btnClass;
        $this->icon = $icon;
        $this->attr = $attr;
        $this->class = $class;
        $this->validNot = $validNot;
        $this->classFooter = $classFooter;
    }

    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}

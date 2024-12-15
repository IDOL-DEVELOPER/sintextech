<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubmitBtn extends Component
{
    public $btnName;

    public $class;
    public $validNot;
    public function __construct($btnName = "", $class = "", $validNot = "")
    {
        $this->btnName = $btnName;
        $this->class = $class;
        $this->validNot = $validNot;
    }

    public function render(): View|Closure|string
    {
        return view('components.submit-btn');
    }
}

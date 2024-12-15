<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddBtn extends Component
{
    public $href;
    public $attr;
    public function __construct($href = "", $attr = "")
    {
        $this->attr = $attr;
        $this->href = $href;
    }

    public function render(): View|Closure|string
    {
        return view('components.add-btn');
    }
}

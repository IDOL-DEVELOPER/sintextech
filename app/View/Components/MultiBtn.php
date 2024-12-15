<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MultiBtn extends Component
{
    public $icon;
    public $attr;
    public $href;
    public $color;
    public $target;
    public $class;
    public function __construct($icon = "", $attr = "", $href = "", $color = "", $target = "",$class="")
    {
        $this->attr = $attr;
        $this->icon = $icon;
        $this->href = $href;
        $this->color = $color;
        $this->target = $target;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.multi-btn');
    }
}

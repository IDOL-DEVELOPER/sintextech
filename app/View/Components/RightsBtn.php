<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RightsBtn extends Component
{
    public $attr;
    public $href;
    public function __construct($attr = "", $href = "")
    {
        $this->attr = $attr;
        $this->href = $href;
    }

    public function render(): View|Closure|string
    {
        return view('components.rights-btn');
    }
}

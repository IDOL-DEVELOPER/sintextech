<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteBtn extends Component
{
    public $attr;
    public $extra;
    public function __construct($attr = "", $extra = "")
    {
        $this->attr = $attr;
        $this->extra = $extra;
    }
    public function render(): View|Closure|string
    {
        return view('components.delete-btn');
    }
}

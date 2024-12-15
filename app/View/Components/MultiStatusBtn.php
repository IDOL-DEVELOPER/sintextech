<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MultiStatusBtn extends Component
{

    public $text;
    public $attr;
    public $status;
    public $icon;
    public $href;
    public $target;

    public function __construct($text = "", $status, $attr = "", $icon = "", $href = "", $target = "")
    {
        $this->text = $text;
        $this->status = $status;
        $this->attr = $attr;
        $this->icon = $icon;
        $this->href = $href;
        $this->target = $target;
    }
    public function render(): View|Closure|string
    {
        return view('components.multi-status-btn');
    }
}

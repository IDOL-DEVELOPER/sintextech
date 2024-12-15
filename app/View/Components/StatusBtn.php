<?php
namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatusBtn extends Component
{
    public $text;
    public $attr;
    public $st;

    public function __construct($text = "", $st = "", $attr = "")
    {
        $this->text = $text;
        $this->st = $st;
        $this->attr = $attr;
    }
    public function render(): View|Closure|string
    {
        return view('components.status-btn');
    }
}

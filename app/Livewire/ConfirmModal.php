<?php

namespace App\Livewire;

use Livewire\Component;

class ConfirmModal extends Component
{
    public $showModal = false;
    public $message = 'Realted Data Effect You Delete?';

    public $id = "";

    public $action = "";
    public $route = "";
    protected $listeners = ['showModal'];
    public function showModal($data)
    {
        $this->showModal = true;
        $this->id = $data["id"];
        $this->route = $data["route"];
        $this->action = "delete";

    }
    public function cancel()
    {
        $this->showModal = false;
        $this->id = "";
        $this->route = "";
        $this->action = "";
    }
    public function render()
    {
        return view('livewire.confirm-modal');
    }
}

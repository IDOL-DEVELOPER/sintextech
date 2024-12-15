<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Redirect;

class SuccessHandler
{
    protected $action;
    protected $route;

    public function __construct($action)
    {
        $this->action = strtolower($action);
    }

    public function getMessage()
    {
        switch ($this->action) {
            case 'create':
                return 'Record Added Successfully';
            case 'update':
                return 'Record Updated Successfully';
            case 'delete':
                return 'Record Deleted Successfully';
            default:
                return $this->action ?? 'Operation Successful';
        }
    }

    public function redirect($route)
    {
        $this->route = $route;
        return $this; // Allow chaining
    }

    public function execute()
    {
        if ($this->route) {
            return Redirect::route($this->route)->with('success', $this->getMessage());
        }

        return Redirect::back()->with('success', [$this->getMessage()]);
    }
}

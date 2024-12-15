<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class LoginForm extends Component
{
    public $selectedOption = 'admin';  // Default selected option
    public $email = true;              // Default visibility for email field
    public $password = true;           // Default visibility for password field
    public $fnid = false;              // Default visibility for franchise ID field
    public $empid = false;             // Default visibility for employee ID field
    public $fadmin = false;            // Default visibility for franchise admin ID field
    public $sales = false;             // Default visibility for sales coordinator ID field

    protected $rules = [
        'selectedOption' => 'required|in:admin,franchise,franchise_admin,franchise_employee,salesco'
    ];

    public function mount()
    {
        // Retrieve session data for selectedOption if available
        if (Session::has('loginType')) {
            $this->selectedOption = Session::get('loginType');
            $this->updateFieldVisibility($this->selectedOption);
        }
    }

    public function updatedSelectedOption($value)
    {
        // Update session data when selectedOption changes
        Session::put('loginType', $value);

        // Reset visibility for all fields
        $this->resetFieldsVisibility();

        // Set visibility based on selected option
        $this->updateFieldVisibility($value);
    }

    protected function updateFieldVisibility($value)
    {
        switch ($value) {
            case 'admin':
                $this->email = true;
                $this->password = true;
                break;
            case 'franchise':
                $this->email = true;
                $this->password = true;
                $this->fnid = true;
                break;
            case 'franchise_admin':
                $this->email = true;
                $this->password = true;
                $this->fadmin = true;
                break;
            case 'franchise_employee':
                $this->email = true;
                $this->password = true;
                $this->empid = true;
                break;
            case 'salesco':
                $this->email = true;
                $this->password = true;
                $this->sales = true;
                break;
        }
    }

    protected function resetFieldsVisibility()
    {
        // Reset all fields to their default visibility
        $this->email = false;
        $this->password = false;
        $this->fnid = false;
        $this->empid = false;
        $this->fadmin = false;
        $this->sales = false;
    }

    public function render()
    {
        return view('livewire.login-form');
    }
}

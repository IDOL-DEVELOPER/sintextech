<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DashController extends Controller
{
   public function view(){
    return view('admin.dashboard.view');
   }
}

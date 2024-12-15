<?php

namespace App\Http\Controllers\menus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MenuController extends Controller
{
   public function view(){
    session()->put('referring_route', request()->route()->getName());
    return view('admin.menu.view');
   }
}

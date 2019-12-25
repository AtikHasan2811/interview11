<?php

namespace Bulkly\Http\Controllers;

use Illuminate\Http\Request;

class newMenuController extends Controller
{
    public function index(){
       return view('admin.layouts.newMenu');
    }
}

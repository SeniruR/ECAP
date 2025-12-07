<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Show the admin index page which includes the legacy dashboard partial
        return view('admin.index');
    }
}

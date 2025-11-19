<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard if the authenticated user is an admin.
     */
    public function index()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            return redirect()->route('login');
        }

        return view('index');
    }
}



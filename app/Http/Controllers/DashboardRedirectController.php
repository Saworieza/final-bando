<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardRedirectController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            return view('admin.dashboard');
        } elseif ($user->hasRole('Seller')) {
            return view('seller.dashboard');
        } elseif ($user->hasRole('Buyer')) {
            return view('buyer.dashboard');
        } elseif ($user->hasRole('Support Agent')) {
            return view('support.dashboard');
        } else {
            abort(403, 'Unauthorized.');
        }
    }
}


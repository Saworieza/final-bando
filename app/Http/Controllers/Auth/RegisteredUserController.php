<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NewUserPendingApproval;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle registration.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['nullable', 'in:Seller,Support Agent'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign selected or default role
        if ($request->role === 'Seller') {
            $user->assignRole('Pending Seller');
        } elseif ($request->role === 'Support Agent') {
            $user->assignRole('Pending Support');
        } else {
            $user->assignRole('Buyer');
        }

        event(new Registered($user));

        // Notify admins if approval is required
        if ($user->hasAnyRole(['Pending Seller', 'Pending Support'])) {
            $admins = User::role('Admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewUserPendingApproval($user));
            }
        }

        // Auto-login only if Buyer
        if ($user->hasRole('Buyer')) {
            Auth::login($user);
            return redirect(route('dashboard'));
        }

        return redirect()->route('pending.approval');
    }
}

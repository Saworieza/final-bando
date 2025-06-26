<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class AdminUserApprovalController extends Controller
{
    public function update(Request $request, User $user)
    {
        $request->validate([
            'new_role' => ['required', 'in:Seller,Support Agent,Buyer'],
        ]);

        $oldRole = $user->getRoleNames()->first();
        $newRole = $request->new_role;

        // Only update if role actually changes
        if ($oldRole !== $newRole) {
            $user->syncRoles([$newRole]);

            // Optional: log or notify
            Log::info("Admin {$request->user()->email} changed role of {$user->email} from {$oldRole} to {$newRole}");

            // Optional: notify the user
            // $user->notify(new YourRoleApprovedNotification($newRole));
        }

        return Redirect::back()->with('status', "User role updated to '{$newRole}'.");
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Restaurant;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function appoint(Request $request, Restaurant $restaurant, User $user)
    {
        if(Gate::allows('manage', $restaurant)) {
            $employee = $user->employee;
            $role = $request->role;
            if(!$employee) {
                $newEmployee = $restaurant->employees()->create(['user_id' => $user->id]);
                $newEmployee->roles()->attach($role);
                return response()->json(['message' => 'employee recruited']);
            }
            if(!$employee->roles->contains($role)) {
                $employee->roles()->attach($role);
                return response()->json(['message' => 'role appointed']);
            }
            return response()->json(['message' => 'employee already had this role']);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function dismiss(Request $request, Restaurant $restaurant, User $user)
    {
        if(Gate::allows('manage', $restaurant)) {
            $employee = $user->employee;
            $role = $request->role;
            if($employee) {
                if($employee->roles->contains($role)) {
                    $employee->roles()->detach($role);
                    return response()->json(['message' => 'role discharged']);
                }
            }
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function notifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications;
        return response()->json(['notifications' => $notifications]);
    }

    public function unreadNotifications()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications;
        return response()->json(['notifications' => $notifications]);
    }

    public function markAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        return response()->json(['notifications' => 'read']);;
    }
}

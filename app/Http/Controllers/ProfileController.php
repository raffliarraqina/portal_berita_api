<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function editPassword()
    {
        return view('admin.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required|string',
            'password'         => 'required|min:8|string',
            'confirmation_password' => 'required|min:8|string'
        ]);

        $currentPasswordStatus = Hash::check($request->current_password, auth()->user()->password);
        if ($currentPasswordStatus) {
            if ($request->password == $request->confirmation_password) {
                $user = User::find(Auth::user()->id);
                $user->password = Hash::make($request->password);
                $user->save();
                return redirect()->back()->with([Alert::success('Success', 'Password Changed Successfully')]);
            } else {
                return redirect()->back()->with([Alert::error('Error', 'Password not same')]);
            } 
        } else {
            return redirect()->back()->with([Alert::error('Error', 'Wrong Password')]);
        }
    }
}

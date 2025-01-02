<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        $user = auth()->user();
        if ($user) {
            $user->update($request->all());
            return back()->withStatus(__('Profile successfully updated.'));
        } else {
            return redirect()->route('login')->withErrors(['You need to login to update your profile.']);
        }
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        $user = auth()->user();
        if ($user) {
            $user->update(['password' => Hash::make($request->get('password'))]);
            return back()->withPasswordStatus(__('Password successfully updated.'));
        } else {
            return redirect()->route('login')->withErrors(['You need to login to update your password.']);
        }
    }
}

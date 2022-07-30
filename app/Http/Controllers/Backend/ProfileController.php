<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\backend\ChangePasswordRequest;
use App\Http\Requests\backend\ProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //updating the uer profile information

    public function update(ProfileRequest $request)
    {
        auth()->user()->update($request->only('name', 'email'));

        if ($request->input('password')) {
            auth()->user()->update([
                'password' => bcrypt($request->input('password'))
            ]);
        }

        return redirect()->route('profile')->with('message', 'Data Saved Successfully');
    }

    //changeing user password
    public function changePassword(ChangePasswordRequest $request)
    {
        if ($request->input('password')) {
            auth()->user()->update([
                'password' => bcrypt($request->input('password'))
            ]);
        }

        return redirect()->route('profile')->with('message', 'Data Saved Successfully');
    }
}

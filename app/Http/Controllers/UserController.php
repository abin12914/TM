<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    /**
     * Return view for user profile
     */
    public function profileView()
    {
        return view('user.profile');
    }

    /**
     * action for user profile update
     */
    public function profileUpdate(ProfileUpdateRequest $request, UserRepository $userRepo)
    {
        $flag = $userRepo->updateProfile($request);

        if($flag['flag']) {
            return redirect()->back()->with("message", "Successfully Updated!")->with("alert-class", "alert-success");
        }
        return redirect()->back()->with("message", "Invalid Password!")->with("alert-class", "alert-danger");
    }
}

<?php

namespace App\Repositories;

use App\Models\User;
use Auth;
use Hash;

class UserRepository
{
    /**
     * Action for updating user profile
     */
    public function updateProfile($request)
    {
        $destination    = '/images/user/'; // image file upload path
        $fileName       = "";
        
        $userName           = $request->get('user_name');
        $name               = $request->get('name');
        $phone              = $request->get('phone');
        $currentPassword    = $request->get('old_password');
        $password           = $request->get('password');

        if(Hash::check($currentPassword, Auth::User()->password)) {
            //upload image
            if ($request->hasFile('image_file')) {
                $file       = $request->file('image_file');
                $extension  = $file->getClientOriginalExtension(); // getting image extension
                $fileName   = $name.'_'.time().'.'.$extension; // renaming image
                $file->move(public_path().$destination, $fileName); // uploading file to given path
                $fileName   = $destination.$fileName;//file name for saving to db
            }

            $user = Auth::User();
            if(!empty($userName)) {
                $user->user_name    = $userName;
            }
            if(!empty($name)) {
                $user->name         = $name;
            }
            if(!empty($phone)) {
                $user->phone        = $phone;
            }
            if(!empty($password)) {
                $user->password     = Hash::make($password);
            }
            if(!empty($fileName)) {
                $user->image        = $fileName;
            }
            
            if($user->save()) {
                return [
                    'flag'  => true,
                ];
            }
        }
        return [
            'flag'  => false
        ];
    }

    /**
     * return user.
     */
    public function getAccount($id)
    {
        $account = Account::with('employee')->where('status', 1)->where('id', $id)->first();

        if(empty($account) || empty($account->id)) {
            $account = [];
        }

        return $account;
    }
}

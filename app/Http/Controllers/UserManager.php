<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserManager extends Controller
{
    public function __construct()
    {
    }
    public function loginCheckCredential(Request $request)
    {

        $user = User::where([
            ['email', $request->email],
        ])->get()->first();
        if(isset($user))
        {
            if(Hash::check($request->password,$user->password))
            {
                Session::put("admin",$user);
                return redirect('/admin/dashboard');
            }
            else
            {
                return back()->with("invalid credentials","Password is incorrect");
            }
        }
        else
        {
            return back()->with("invalid credentials","Email is incorrect");
        }
    }
    public function registerUser(Request $request)
    {
        $user = new User();

        $user->name = $request->Name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->companyname    = $request->companyname;
        $user->country = $request->country;
        $user->password = $request->password;

        $user->save();

        return redirect('/admin/dashboard');
    }
}

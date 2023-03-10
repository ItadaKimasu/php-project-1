<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function forgot() {
        return view('auth.forgot-password');
    }

    public function reset() {
        return view('auth.reset-password');
    }

    //handle register user ajax request
    public function saveUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20',
            'email' => 'required|email|unique:users|max:100',
            'password' => 'required|min:6|max:50',
            'cpassword' => 'required|min:6|same:password'
        ], [
            'cpassword.same' => 'Password did not match',
            'cpassword.required' => 'Confirm password is required!'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->getMessageBag()
            ]);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
               'status' => 200,
               'message' => 'Registered successfully!'
            ]);
        };
    }
}

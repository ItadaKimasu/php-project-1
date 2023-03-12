<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
            'name' => 'required|max:40',
            'email' => 'required|email|unique:users|max:50',
            'password' => 'required|min:6|max:50',
            'cpassword' => 'required|min:6|same:password'
        ], [
            'name.required' => 'Username is required.',
            'name.max' => 'Must not be exceed 40 characters.',

            'email.required' => 'Email is required.',
            'email.unique' => 'Email already exists.',
            'email.max' => 'Must not be exceed 50 characters.',

            'password.required' => 'Password is required.',
            'password.min' => 'Must be at least 6 characters.',
            'password.max' => 'Must not be exceed 50 characters.',

            'cpassword.required' => 'Confirm password is required.',
            'cpassword.min' => 'Must be at least 6 characters.',
            'cpassword.same' => 'Password did not match.'
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


    //handle login user ajax request
    public function loginUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:40',
            'password' => 'required|min:6|max:50',
        ], [
            'name.required' => 'Username is required.',
            'name.max' => 'Must not be exceed 40 characters.',

            'password.required' => 'Password is required.',
            'password.min' => 'Must be at least 6 characters.',
            'password.max' => 'Must not be exceed 50 characters.',
        ]);


        if ($validator->fails()) {  
            return response()->json([
                'status' => 400,
                'message' => $validator->getMessageBag()
            ]);
        } else {
            $user = User::where('name', $request->name) -> first();
            
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $request->session()->put('loggedInUser', $user->id); //key & id
                    return response()->json([
                        'status' => 200,
                        'message' => 'Logged in successfully!'
                    ]);
                } else {
                    return response()->json([
                        'status' => 401,
                        'message' => 'Username or Password is incorrect!'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => 'User not found!'
                ]);
            }
        };
    }


    //profile page
    public function profile() {
        $data = ['userInfo' => DB::table('users')->where('id', session('loggedInUser'))->first()];

        return view('auth.profile', $data);
    }


    //logout method
    public function logout() {
        if (session()->has('loggedInUser')) {
            session()->pull('loggedInUser');
            return redirect('/');
        }
    }


    //update user profile image
    public function profileImageUpdate(Request $request) {
        // print_r($_FILES);
        // print_r($_POST);

        $user_id = $request->user_id;
        $user = User::find($user_id);

        // print_r($user_id);

        
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images/', $fileName);

            if ($user->picture) {
                Storage::delete('public/images/' . $user->picture);
            }
        }

        User::where('id', $user_id)->update([
            'picture' => $fileName
        ]);

        

        // print_r($fileName);


        return response()->json([
            'status' => 200,
            'message' => 'Profile image updated successfully!'
        ]);
    }

    public function profileUpdate(Request $request) {
        User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'phone' => $request->phone
        ]);

        return response()->json([
           'status' => 200,
           'message' => 'Profile updated successfully!'
        ]);
    }
}

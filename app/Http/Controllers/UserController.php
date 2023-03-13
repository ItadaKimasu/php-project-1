<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // public $email = "aa@aa";

    // public function myAction() {
    //     $userControllerInstance = new UserController();
    //     return view('my-view', ['userControllerInstance' => $userControllerInstance]);
    // }
    
    public function index() {
        return view('auth.login');
    }

    public function forgot() {
        if (session()->has('loggedInUser')) {
            return redirect('/profile');
        } else {
            return view('auth.forgot-password');
        }
    }

    public function reset() {
        $emailReset = "";
        // $emailReset = $this->email;
        if (session()->has('loggedInUser')) {
            return redirect('/profile');
        } else {
            // print_r($emailReset);
            return view('auth.reset-password', ['email' => $emailReset]);
        }
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


    // handle forgot password request
    public function forgotPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:50',
        ], [
            'email.required' => 'Email is required.',
            'email.max' => 'Must not be exceed 50 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json([
               'status' => 400,
               'message' => $validator->getMessageBag()
            ]);
        } else {
            $token = Str::uuid();
            $user = DB::table('users')->where('email', $request->email) -> first();
            $details = [
                'body' => route('reset', ['email' => $request->email, 'token' => $token])
            ];

            if ($user) {
                User::where('email', $request->email)->update([
                    'token' => $token,
                    'token_expires' => Carbon::now()->addMinutes(10)->toDateTimeString() //expire link reset password
                ]);

                // Mail::to($request->email)->send(new ForgotPassword($details));
                return response()->json([
                    // $this->saveEmailForgot($request->email),
                   'status' => 200,
                   'message' => 'Send link to reset password successfully!',

                ]);
            } else {
                return response()->json([
                   'status' => 401,
                   'message' => 'Email not found!'
                ]);
            }
        }
    }

    // public function saveEmailForgot($email) {
    //     $this->email = $email;
    // }

    public function resetPassword(Request $request) {
        // print_r($_POST);
        
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|max:50',
            'cpassword' => 'required|min:6|same:password',
        ], [
            'password.required' => 'Password is required.',
            'password.min' => 'Must be at least 6 characters.',
            'password.max' => 'Must not be exceed 50 characters.',

            'cpassword.required' => 'Confirm password is required.',
            'cpassword.min' => 'Must be at least 6 characters.',
            'cpassword.same' => 'Password did not match.',
        ]);

        if ($validator->fails()) {
            return response()->json([
               'status' => 400,
               'message' => $validator->getMessageBag()
            ]);
        } else {
            // $user = DB::table('users')->where('email', $request->email) -> first();
            $user = true;

            if ($user) {
                // User::where('email', $request->email)->update([
                //     'password' => Hash::make($request->password),
                // ]);

                return response()->json([
                   'status' => 200,
                   'message' => 'New password updated!&nbsp;&nbsp;<a href="/">LOGIN</a>'
                ]);
            } else {
                return response()->json([
                   'status' => 401,
                   'message' => 'Reset link expired! Request for a new reset password link!'
                ]);
            }
        }
    }
}

@extends('layouts.main-login')
@section('title', "Reset Password")
    
@section('content')

    <div class="main_container">
        <div class="forms_container">
            <div class="signin_signup div_forgot">

                <form action="#" method="POST" class="reset_form">
                    @csrf
                    <h2 class="h2_title">Reset Password</h2>

                    <div class="mb-3 text-secondary">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        You need to change your password.
                    </div>
                    
                    <div class="input_field">
                        <i class="fas fa-lock"></i>
                        <input 
                            type = "password" 
                            name = "password"
                            id = "password"
                            placeholder = "Password" 
                        />
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="input_field">
                        <i class="fas fa-lock"></i>
                        <input 
                            type = "password" 
                            name = "cpassword"
                            id = "cpassword"
                            placeholder = "Confirm Password" 
                        />
                        <div class="invalid-feedback"></div>
                    </div>

                    <input 
                        type="submit" 
                        value="SUBMIT" 
                        id="reset_btn"
                        class="input_btn" 
                    />
                    
                </form>

            </div>
        </div>
        

        <div class="panels_container">

            <div class="container_panel left_panel">
                <div class="panel_content">
                    <h3 class="h3_panel">Back to Login Page ?</h3>
                    
                    <button 
                        class="input_btn input_transparent" 
                        id="go_back_btn"
                        onclick="redirectHome()">
                        GO BACK
                    </button>
                </div>
                <img src="/images/forgotcat.svg" class="panel_image" alt="" />
            </div>

        </div>
    </div>

@endsection
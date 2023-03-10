@extends('layouts.app')
@section('title', "Forgot Password")
    
@section('content')

    <div class="main_container">
        <div class="forms_container">
            <div class="signin_signup div_forgot">

                <form action="#" method="POST" class="forgot_form">
                    @csrf
                    <h2 class="h2_title">Forgot Your Password?</h2>
                    
                    <div class="mb-3 text-secondary">
                        Enter your e-mail address and we will send you a link to reset your password.
                    </div>
                    <div class="input_field">
                        <i class="fas fa-user"></i>
                        <input 
                            type = "email" 
                            name = "email"
                            id = "email"
                            placeholder = "Email" 
                        />
                        <div class="invalid-feedback"></div>
                    </div>

                    <input 
                        type = "submit" 
                        value = "CONTINUE" 
                        id="forgot_btn"
                        class = "input_btn" 
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

            
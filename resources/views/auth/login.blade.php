@extends('layouts.main-login')
@section('title', "Sign in to Cunnyyy")
    
@section('content')

    <div class="main_container">
        <div class="forms_container">
            <div class="signin_signup">


                <form action="#" method="POST" class="sign_in_form">
                    @csrf

                    <div id="login_alert"></div>
                    <h2 class="h2_title">Sign in</h2>
                    <div class="input_field form-control">
                        <i class="fas fa-user"></i>
                        <input 
                            type = "text" 
                            name = "name"
                            id = "name"
                            placeholder = "Username" 
                        />
                    </div>
                    <div class="input_field form-control">
                        <i class="fas fa-lock"></i>
                        <input 
                            type = "password" 
                            name = "password"
                            id = "password"
                            placeholder = "Password" 
                        />
                    </div>
                    <div class="mb-1">
                        <a href="/forgot-password" class="text-decoration-none">Forgot password?</a>
                    </div>

                    <input 
                        type = "submit" 
                        value = "LOG IN" 
                        id="login_btn"
                        class = "input_btn" 
                    />
                    <p class="social_text">Or sign in with social platforms</p>
                    <div class="social_media">
                        <a href="#" class="social_icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social_icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social_icon">
                            <i class="fab fa-google"></i>
                        </a>
                    </div>
                </form>



                <form action="#" method="POST" class="sign_up_form">
                    @csrf

                    <div id="show_success_alert"></div>
                    <h2 class="h2_title">Sign up</h2>
                    <div class="input_field form-control">
                        <i class="fas fa-user"></i>
                        <input 
                            type = "text" 
                            name = "name"
                            id = "name"
                            placeholder = "Username" 
                        />
                    </div>
                    <div class="input_field form-control">
                        <i class="fas fa-envelope"></i>
                        <input 
                            type="email" 
                            name="email"
                            id="email"
                            placeholder="Email" 
                        />
                    </div>
                    <div class="input_field form-control">
                        <i class="fas fa-lock"></i>
                        <input 
                            type = "password" 
                            name = "password"
                            id = "password"
                            placeholder = "Password" 
                        />
                    </div>
                    <div class="input_field form-control">
                        <i class="fas fa-lock"></i>
                        <input 
                            type = "password" 
                            name = "cpassword"
                            id = "cpassword"
                            placeholder = "Confirm Password" 
                        />
                    </div>

                    <input 
                        type="submit" 
                        value="SIGN UP" 
                        id="signup_btn"
                        class="input_btn" 
                    />
                    
                </form>


            </div>
        </div>

        <div class="panels_container">
            <div class="container_panel left_panel">
                <div class="panel_content">
                    <h3 class="h3_panel">New here ?</h3>
                    <p class="p_panel">
                        Sign up and discover great amount of content
                    </p>
                    <button class="input_btn input_transparent" id="sign_up_btn">
                        SIGN UP
                    </button>
                </div>
                <img src="/images/welcome.svg" class="panel_image" alt="" />
            </div>


            <div class="container_panel right_panel">
                <div class="panel_content">
                    <h3 class="h3_panel">Welcome back !</h3>
                    <p class="p_panel">
                        To keep connected with us please log in
                        <br />with your personal info
                    </p>
                    <button class="input_btn input_transparent" id="sign_in_btn">
                        SIGN IN
                    </button>
                </div>
                <img src="/images/welcomeback.svg" class="panel_image" alt="" />
            </div>
        </div>
    </div>


@endsection



@section('scripts')
{{-- Script to switch between 2 form submission --}}
<script>
    
    const sign_in_btn = document.querySelector("#sign_in_btn");
    const sign_up_btn = document.querySelector("#sign_up_btn");
    const container = document.querySelector(".main_container");
    const sign_in_form = document.querySelector(".sign_in_form");
    const sign_up_form = document.querySelector(".sign_up_form");
    const sign_in_HTML = sign_in_form.innerHTML;
    const sign_up_HTML = sign_up_form.innerHTML;
    sign_up_form.innerHTML = "";

    sign_up_btn.addEventListener("click", () => {
        container.classList.add("sign_up_mode");
        setTimeout(() => {
            if (!sign_up_form.innerHTML) {
                sign_up_form.innerHTML = sign_up_HTML;
            }
            sign_in_form.innerHTML = "";
        }, 1000);
            
    });

    sign_in_btn.addEventListener("click", () => {
        container.classList.remove("sign_up_mode");
        setTimeout(() => {
            if (!sign_in_form.innerHTML) {
                sign_in_form.innerHTML = sign_in_HTML;
            }
            sign_up_form.innerHTML = "";
        }, 1000);
            
    });
    
</script>
{{-- end Script to switch between 2 form submission --}}

{{-- Script adjustments for Sign In Form --}}
<script>
    
    $(function () {
        $(".sign_in_form").submit(function(e) {
            e.preventDefault();
            $("#login_btn").val("Please wait...");

            $.ajax({
                url: '{{ route('auth.login') }}',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (res) {
                    console.log(res);

                    if (res.status == 400) {
                        if(res.message.name) {
                            showError('name', res.message.name[0], '')
                        } else {
                            showError('name', '', 'Username');
                        }


                        if(res.message.password) {
                            showError('password', res.message.password[0], '')
                        } else {
                            showError('password', '', 'Password');
                        }

                        $("#login_btn").val("LOG IN");
                    } else if(res.status == 401) {
                        $("#login_alert").html(showMessage('danger', res.message));
                        removeValidationClasses(".sign_in_form");
                        $("#login_btn").val("LOG IN");
                    } else {
                        if (res.status == 200 && res.message == 'Logged in successfully!') {
                            window.location = '{{ route('profile') }}';
                        }
                    }

                }
            });
        });
    });
    
</script>
{{-- end Script adjustments for Sign In Form   --}}


{{-- Script adjustments for Sign Up Form --}}
<script>




</script>
{{-- end Script adjustments for Sign Up Form   --}}
    
@endsection
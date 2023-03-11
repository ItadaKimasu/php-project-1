@extends('layouts.app')
@section('title', "Sign in to Cunnyyy")
    
@section('content')

    <div class="main_container">
        <div class="forms_container">
            <div class="signin_signup">


                <form action="#" method="POST" class="sign_in_form">
                    @csrf
                    <h2 class="h2_title">Sign in</h2>
                    <div class="input_field">
                        <i class="fas fa-user"></i>
                        <input 
                            type = "text" 
                            name = "name"
                            id = "name"
                            placeholder = "Username" 
                        />
                        <div class="invalid-feedback"></div>
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

<script>
    const sign_in_btn = document.querySelector("#sign_in_btn");
    const sign_up_btn = document.querySelector("#sign_up_btn");
    const container = document.querySelector(".main_container");
    const sign_in_form = document.querySelector(".sign_in_form");
    const sign_up_form = document.querySelector(".sign_up_form");
    const sign_in_HTML = sign_in_form.innerHTML;
    const sign_up_HTML = sign_up_form.innerHTML;

    sign_up_btn.addEventListener("click", () => {
        container.classList.add("sign_up_mode");
        if (sign_up_form.innerHTML) {
            sign_up_form.innerHTML = sign_up_HTML;
        }
        sign_in_form.innerHTML = "";
    });

    sign_in_btn.addEventListener("click", () => {
        container.classList.remove("sign_up_mode");
        if (sign_in_form.innerHTML) {
            sign_in_form.innerHTML = sign_in_HTML;
        }
        sign_up_form.innerHTML = "";
    });


    $(function () {
        $(".sign_up_form").submit(function(e) {
            e.preventDefault();
            $("#signup_btn").val("Please wait...");

            $.ajax({
                url: '{{ route('auth.register') }}',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (res) {

                    if(res.status == 400) {
                        console.log(res);
                        showError('name', res.message.name);
                        showError('email', res.message.email);
                        showError('password', res.message.password);
                        showError('cpassword', res.message.cpassword);
                        $("#signup_btn").val("SIGN UP");
                    } else if(res.status == 200) {
                        console.log(res);
                        $("#show_success_alert").html(showMessage('success', res.message));
                        $(".sign_up_form")[0].reset();
                        removeValidationClasses(".sign_up_form");
                        $("#signup_btn").val("SIGN UP");
                    }

                }
            });
        });
    })
</script>
    
@endsection
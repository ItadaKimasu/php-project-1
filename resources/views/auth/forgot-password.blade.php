@extends('layouts.main-login')
@section('title', "Forgot Password")
    
@section('content')

    <div class="main_container">
        <div class="forms_container">
            <div class="signin_signup div_forgot">

                <form action="#" method="POST" class="forgot_form">
                    @csrf

                    <div id="forgot_alert"></div>
                    <h2 class="h2_title">Forgot Your Password?</h2>
                    
                    <div class="mb-3 text-secondary">
                        Enter your e-mail address and we will send you a link to reset your password.
                    </div>
                    <div class="input_field form-control">
                        <i class="fas fa-user"></i>
                        <input 
                            type = "email" 
                            name = "email"
                            id = "email"
                            placeholder = "Email" 
                        />
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

@section('scripts')
<script>
    $(function() {
        $(".forgot_form").submit(function(e) {
            e.preventDefault();
            $("#forgot_btn").val('Please wait...');
            $.ajax({
                url: '{{ route('auth.forgot') }}',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res) {
                    console.log(res);
                    if (res.status == 400) {
                        if(res.message.email) {
                            showError('email', res.message.email[0], '')
                        } else {
                            showError('email', '', 'Email');
                        }

                        $("#forgot_btn").val("CONTINUE");
                    } else if(res.status == 401) {
                        $("#forgot_alert").html(showMessage('danger', res.message));
                        removeValidationClasses(".forgot_form");
                        $("#forgot_btn").val("CONTINUE");
                    } else {
                        $("#forgot_alert").html(showMessage('success', res.message));
                        $(".forgot_form")[0].reset();
                        removeValidationClasses(".forgot_form");
                        $("#forgot_btn").val("CONTINUE");
                        window.location = '{{ route('reset') }}';
                    }
                }
            });
        });
    });
</script>


@endsection
            
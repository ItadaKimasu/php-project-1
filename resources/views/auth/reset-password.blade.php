@extends('layouts.main-login')
@section('title', "Reset Password")
    
@section('content')


<div class="main_container">
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="z-index: 10;">
        <strong>This feature on this page is not yet complete! Features may not work correctly!</strong>
    </div>;
    <div class="forms_container">
            <div class="signin_signup div_forgot">


                <form action="#" method="POST" class="reset_form">
                    @csrf

                    {{-- <input type="hidden" name="email" id="user_email" value="{{ $emailReset }}"> --}}
                    {{-- <div class="input_field form-control" style="visibility: hidden">
                        <i class="fas fa-lock"></i>
                        <input 
                            type = "email" 
                            name = "email"
                            id = "email"
                            placeholder = "Email" 
                            value="{{ $userControllerInstance->email }}"
                        disabled>
                    </div> --}}

                    <div id="reset_alert"></div>
                    <h2 class="h2_title">Reset Password</h2>

                    <div class="mb-3 text-secondary">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        You need to change your password.
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

@section('scripts')


<script>
    $(function() {
        $(".reset_form").submit(function(e) {
            e.preventDefault();
            $("#reset_btn").val('Please wait...');
            $.ajax({
                url: '{{ route('auth.reset') }}',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res) {
                    console.log(res);
                    if (res.status == 400) {
                        if(res.message.password) {
                            showError('password', res.message.password[0], '')
                        } else {
                            showError('password', '', 'Password');
                        }

                        if(res.message.cpassword) {
                            showError('cpassword', res.message.cpassword[0], '')
                        } else {
                            showError('cpassword', '', 'Confirm Password');
                        }

                        $("#reset_btn").val("SUBMIT");
                    } else if(res.status == 401) {
                        $("#reset_alert").html(showMessage('danger', res.message));
                        removeValidationClasses(".reset_form");
                        $("#reset_btn").val("SUBMIT");
                    } else {
                        $("#reset_alert").html(showMessage('success', res.message));
                        $(".reset_form")[0].reset();
                        removeValidationClasses(".reset_form");
                        $("#reset_btn").val("SUBMIT");
                    }
                }
            });
        });
    });


</script>


@endsection
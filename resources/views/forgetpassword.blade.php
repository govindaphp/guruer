@extends('front.layouts.layout')

@section('content')
<div class="titlebar">
    <div class="container browse-title">
        <div class="row title-content">
            <h1 class="text-white">Forget Password</h1>
        </div>
    </div>
</div>

<div class="elite-register elite-login">
    <div class="container loginadj">
        <div class="login-content">
            <div class="login-image">
                <img class="register-img" src="{{ url('public/front_assets/images/form-img.jpg') }}" alt="Register Image">
            </div>

            <div class="login-form">
                <div class="signup-inner-content">
                    
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif





                    <div class="form-register form-login">
                        <h5>Forgot Password</h5>
                        <p></p>

                        <form id="forget_form" class="pt-3" method="POST" action="{{ route('password.email') }}">
                            {!! csrf_field() !!}
                            
                            <div class="form-group">
                                <input type="email" class="form-control" id="email_id" placeholder="Enter Your Email" name="email_id" maxlength="60" required />
                            </div>
                            <div class="mt-5 d-grid gap-2">
                                <input type="submit" value="Submit" class="btn btn-block btn-lg font-weight-medium auth-form-btn" /> 
                            <p class="already-account">
                                Already have an account? <a href="{{ url('login') }}">Login</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /*
    $('#exampleInputPassword2').on('input', function () {
        const password = $('#exampleInputPassword1').val();
        const confirmPassword = $(this).val();
        const errorMessage = $('#error_password');

        if (password !== confirmPassword) {
            errorMessage.show(); // Show error message
        } else {
            errorMessage.hide(); // Hide error message
        }
    });
    */

$(document).ready(function () {
  $("#forget_form").validate({
    onfocusout: function (element) { 
      $(element).valid();
    },

    rules: {
      email_id: { required: true },
    },

    messages: {
      email_id: { required: "Email ID is Required" },
    },

    submitHandler: function (form) {
      // for demo

      form.submit();
    },
  });
});



</script>
@endsection

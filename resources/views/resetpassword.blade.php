@extends('front.layouts.layout')

@section('content')
<div class="titlebar">
    <div class="container browse-title">
        <div class="row title-content">
            <h1 class="text-white">Reset Password</h1>
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
                    <!-- @if(session()->has("success"))
                        <div class="alert alert-success" role="alert">
                            <strong>{{ session()->get("success") }}</strong>
                        </div>
                    @elseif(session()->has("error"))
                        <div class="alert alert-warning" role="alert">
                            <strong>{{ session()->get("error") }}</strong>
                        </div>
                    @endif -->


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
                        <h5>Reset Password</h5>
                        <p></p>

                        <form id="forget_form" class="pt-3" method="POST" action="{{ route('password.update') }}">
                            {!! csrf_field() !!}
                            
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ old('email', $email) }}">


                            <div class="form-group">
                                <input  class="form-control" id="password" type="password" name="password" placeholder="New Password"  maxlength="60" required />
                            </div>
                            <div class="form-group">
                                <input  class="form-control" id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password"  maxlength="60" required />
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


<!-- Include Client-Side Validation -->
<script>
    document.getElementById('forget_form').addEventListener('submit', function (e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password-confirm').value;

        if (password.length < 8) {
            alert('Password must be at least 8 characters long.');
            e.preventDefault();
        } else if (password !== confirmPassword) {
            alert('Passwords do not match.');
            e.preventDefault();
        }
    });
</script>
@endsection

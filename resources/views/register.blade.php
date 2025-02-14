@extends('front.layouts.layout')

@section('content')<div class="titlebar">		<div class="container browse-title">			<div class="row title-content">				<h1 class="text-white">Register</h1>			</div>		</div>	</div>	<div class="elite-register elite-login">
	<div class="container loginadj">            <div class="login-content">                <div class="login-image">                    <img class="register-img" src="{{ url('public/front_assets/images/form-img.jpg') }}" alt="login Image">                </div>                <div class="login-form register-log-form">                    <div class="signup-inner-content">                    @if(session()->has("success"))                    <div class="alert alert-success" role="alert">                        <strong>{{ session()->get("success") }} </strong>                    </div>                    @elseif(session()->has("error"))                    <div class="alert alert-warning" role="alert">                        <strong>{{ session()->get("error") }} </strong>                    </div>                    @endif                        <div class="form-register form-login register-login">                            <h5>Register a new account</h5>                            <p></p>                            <form class="pt-3" method="POST" action="{{route('signup')}}">                            {!! csrf_field() !!}                            
        
    <div class="form-group"><input type="text" class="form-control" id="exampleInputUsername1" placeholder="First Name" name="first_name" maxlength="15" required oninput="validateInput(this)" />


    <div class="form-group"><input type="text" class="form-control" id="exampleInputUsername2" placeholder="Last Name" name="last_name" maxlength="15" required oninput="validateInput(this)" /></div>


</div>                            <div class="form-group">                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" name="email_id" maxlength="60" required/>                            </div>                            <div class="form-group">                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" maxlength="60" required/>                            </div>                            <div class="form-group">                                <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Confirm Password" name="password_confirmation" maxlength="60" required/>                                <p id="error_password" style="color:red; display:none;">Password and Confirm Password do not match!</p>                            </div>                            <div class="form-group user-type">                                <select name="user_type" id="" class="form-select" required>                                    <option value="">Chose User Type</option>                                    <option value="1">User</option>                                    <option value="2">Merchent(Guru)</option>                                </select>                            </div>                            <div class="form-group">                                <input type="text" class="form-control" id="exampleInputNumber1" placeholder="Mobile Number" name="number_field"  maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required/>                            </div>                            <!--div-- class="form-check">                                <label class="form-check-label text-muted"> <input type="checkbox" class="form-check-input" name="terms" />Remember me <i class="input-helper"></i></label>                            </!--div-->                            <div class="mt-5 d-grid gap-2">                                <input type="submit" value="Sign Up" class="btn btn-block btn-lg font-weight-medium auth-form-btn" />                            </div>                            <p class="already-account">Already have an account? <a href="{{ url('login') }}">Log-In</a></p>                            </form>                        </div>                    </div>                </div>            </div>        </div>		</div>      
        <script>
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
        </script>

        <script>
        function validateInput(input) {
            // Remove non-alphabetic characters (including numbers)
            input.value = input.value.replace(/[^a-zA-Z ]/g, '');

            // Optionally, you can show an error message if the length exceeds 15 characters.
            if (input.value.length > 15) {
                input.value = input.value.slice(0, 15); // Ensure the value is cut off at 15 characters
            }
        }
        </script>

        @endsection
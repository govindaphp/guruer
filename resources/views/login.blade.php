@extends('front.layouts.layout')
@section('content')
	<div class="titlebar">
		<div class="container browse-title">
			<div class="row title-content">
				<h1 class="text-white">Login</h1>
			</div>
		</div>
	</div>
    <div class="elite-register elite-login">
		<div class="container loginadj">
            <div class="login-content">
                <div class="login-image">
                    <img class="login-img" src="{{ url('public/front_assets/images/form-img.jpg') }}" alt="login Image">
                </div>
                <div class="login-form">
                    <div class="form-register form-login">
					@if (session('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                        <h5>Welcome back</h5>
                        <p>Please log in to your account</p>
                        <form class="pt-3" action="{{ route('customerlogin')}}" method="POST">
                            {!! csrf_field() !!}
                                <div class="form-group">
                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email or phone number" name="email" maxlength="60" required/>					
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" maxlength="60" required/>
                                </div>
                                <div class="reset-pass">
                                    <a href="{{ url('showLinkRequestForm') }}">Forgot Password?</a> 
                                </div>
                                <div class="mt-4 mb-3 d-grid gap-2 login-submit_btn">
                                    <input type="submit" value="Sign In" class="btn btn-block btn-lg font-weight-medium auth-form-btn" />
                                </div>
                                <p class="already-account">Don't have an account yet? <a href="{{ url('register') }}">Sign Up</a></p>
                                <div class="three-btn">
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
        </div>
        @endsection
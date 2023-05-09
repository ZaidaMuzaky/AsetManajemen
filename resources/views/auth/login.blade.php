@extends('layouts.appLogin')
@section('logincontainer')
<form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
	@csrf
	<div class="wrap-input100 validate-input m-b-26" data-validate="Email">
		<span class="label-input100">Username</span>
		<input class="input100 @error('nama') is-invalid @enderror" type="text" name="nama" placeholder="Enter username">
		<span class="focus-input100"></span>
		@error('nama')
		<span class="invalid-feedback text-danger" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>

	<div class="wrap-input100 validate-input m-b-18" data-validate="Password is required">
		<span class="label-input100">Password</span>
		<input class="input100 @error('password') is-invalid @enderror" type="password" name="password" placeholder="Enter password">
		<span class="focus-input100"></span>
		@error('password')
		<span class="invalid-feedback text-danger" role="alert">
			<strong>{{ $message }}</strong>
		</span>
		@enderror
	</div>

	<div class="flex-sb-m w-full p-b-30">
		<div class="contact100-form-checkbox">
			<input class="input-checkbox100" id="remember" type="checkbox" name="remember">
			<label class="label-checkbox100" for="remember">
				Remember me
			</label>
		</div>

		@if (Route::has('password.request'))
		<a class="btn btn-link" href="{{ route('forget.password.get') }}">
			{{ __('Forgot Your Password?') }}
		</a>
		@endif
	</div>

	<div class="container-login100-form-btn">
		<button class="login100-form-btn">
			Login
		</button>
	</div>
</form>
@endsection
@extends('layouts.public')
@section('content')
<div id="sign-up" class="auth-form tab-pane fade show active  form-validation">
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="text-center mb-4">
            <h3 class="text-center mb-2 text-black">Sign In</h3>
            <!-- <span>Your Social Campaigns</span> -->
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label mb-2 fs-13 label-color font-w500">Email address</label>
            <input id="exampleFormControlInput1" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="hello@example.com" autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label mb-2 fs-13 label-color font-w500">Password</label>
            <input id="exampleFormControlInput2" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <!-- <a href="javascript:void(0);" class="text-primary float-end mb-4">Forgot Password ?</a> -->
        <button class="btn btn-block btn-primary">Sign In</button>

    </form>
    <div class="new-account mt-3 text-center">
        <!-- <p class="font-w500">Already have an account? <a class="text-primary" href="#sign-in" data-toggle="tab">Sign in</a></p> -->
    </div>
</div>
@endsection

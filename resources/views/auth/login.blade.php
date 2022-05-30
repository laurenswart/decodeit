@extends('layouts.guest')

@section('content')
    
    <div class="container padder">    
        <!--form -->
        <div class="guest-form layer-1 light-card">
            
            <h1>Login</h1>
            
            <form method="POST" action="{{ route('login') }}">
            @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ old('email') ?? '' }}" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required autocomplete="current-password">
                </div>

                <button type="submit" class="myButton">Log in</button>
                <!-- Validation Errors -->
                @if($errors->any())
                    <div class="error-msg m-3">
                        These credentials do not match any of our records.
                    </div>
                @endif
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <a href="{{ route('register') }}">Not registered yet ?</a>
            </form>
        </div>
    </div>
@endsection

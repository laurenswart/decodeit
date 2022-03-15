<x-guest-layout>
    
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
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
                
                <button type="submit" class="btn myButton">Log in</button>
                <!-- Validation Errors -->
            <x-auth-validation-errors class="mt-4" :errors="$errors" />
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <a href="{{ route('register') }}">Not registered yet ?</a>
            </form>
        </div>
    </div>
</x-guest-layout>

<x-guest-layout>
    <div class="container padder">    
        <!--form -->
        <div class="guest-form layer-1 light-card">
            
            <h1>Reset my Password</h1>
             <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <div class="mb-4 text-sm text-gray-600">
                {{ __('Forgot your password? No problem. Let us know your email address and we will email you a password reset link.') }}
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ old('email') ?? '' }}" required autofocus>
                </div>
                <button type="submit" class="myButton">Email me a link</button>
            </form>
        </div>
    </div>
</x-guest-layout>

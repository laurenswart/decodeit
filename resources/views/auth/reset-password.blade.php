<x-guest-layout>
    <div class="container padder">    
        <!--form -->
        <div class="guest-form layer-1 light-card">
            
            <h1>Reset my Password</h1>
           

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ old('email', $request->email) ?? '' }}" required autofocus>
                    </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password">Confirm</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
                </div>

                 <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <button type="submit" class="myButton">Reset Password</button>

            </form>
        </div>
    </div>
</x-guest-layout>

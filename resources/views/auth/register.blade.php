<x-guest-layout>
    <div class="container padder">    
        <div class="guest-form  layer-1 light-card">
            <h1>Register</h1>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="d-flex flex-column flex-md-row">
                    <div class="form-group">
                        <label for="firstname">Firstname</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Enter firstname" value="{{ old('firstname') ?? '' }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Lastname</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Enter lastname" :value="{{ old('lastname') ?? '' }}" required >
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value=" {{ old('email') ?? '' }}" required >
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label for="password-conf">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation-conf" placeholder="Enter confirmation" name="password_confirmation" required>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="isTeacher" name="isTeacher">
                    <label class="form-check-label" for="isTeacher">I'm a teacher</label>
                </div>
                <button type="submit" class="btn myButton">Register</button>
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                <a href="{{ route('login') }}">Already registered ?</a>
            </form>
        </div>
    </div>
</x-guest-layout>

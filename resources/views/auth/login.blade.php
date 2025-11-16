<x-guest-layout>
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-2" style="color: #3d3d6b; font-size: 1.75rem;">Welcome Back</h2>
        <p class="text-muted mb-0">Sign in to access your Renovation Defenders account</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold" style="color: #3d3d6b;">Email Address</label>
            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="your@email.com" style="border-color: #dee2e6; border-radius: 0.5rem;">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold" style="color: #3d3d6b;">Password</label>
            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password" style="border-color: #dee2e6; border-radius: 0.5rem;">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me" style="color: #6c757d;">
                    Remember me
                </label>
            </div>

            @if (Route::has('password.request'))
                <a class="text-decoration-none" href="{{ route('password.request') }}" style="color: #17a2b8; font-weight: 500;">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-lg" style="background-color: #3d3d6b; border-color: #3d3d6b; color: white; border-radius: 0.5rem; font-weight: 600; padding: 0.75rem;">
                Sign In
            </button>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <p class="mb-0" style="color: #6c757d;">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: #17a2b8;">
                    Create Account
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>

<x-guest-layout>
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-2" style="color: #3d3d6b; font-size: 1.75rem;">Create Account</h2>
        <p class="text-muted mb-0">Join Renovation Defenders today</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold" style="color: #3d3d6b;">Full Name</label>
            <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe" style="border-color: #dee2e6; border-radius: 0.5rem;">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold" style="color: #3d3d6b;">Email Address</label>
            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="your@email.com" style="border-color: #dee2e6; border-radius: 0.5rem;">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold" style="color: #3d3d6b;">Password</label>
            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Create a strong password" style="border-color: #dee2e6; border-radius: 0.5rem;">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-semibold" style="color: #3d3d6b;">Confirm Password</label>
            <input id="password_confirmation" type="password" class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" style="border-color: #dee2e6; border-radius: 0.5rem;">
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Register Button -->
        <div class="d-grid mb-4 mt-4">
            <button type="submit" class="btn btn-lg" style="background-color: #3d3d6b; border-color: #3d3d6b; color: white; border-radius: 0.5rem; font-weight: 600; padding: 0.75rem;">
                Create Account
            </button>
        </div>

        <!-- Login Link -->
        <div class="text-center">
            <p class="mb-0" style="color: #6c757d;">
                Already have an account?
                <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #17a2b8;">
                    Sign In
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>

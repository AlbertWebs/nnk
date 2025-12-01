@extends('layouts.app')

@section('content')
<style>
    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
        padding: 2rem 1rem;
    }
    
    .login-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        opacity: 0.3;
    }
    
    .login-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        padding: 3rem;
        width: 100%;
        max-width: 450px;
        position: relative;
        z-index: 1;
        animation: slideUp 0.5s ease-out;
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .login-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    
    .brand-logo {
        width: 60px;
        height: 60px;
        margin: 0 auto 1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .login-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }
    
    .login-header p {
        color: #718096;
        font-size: 0.95rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        display: block;
    }
    
    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fff;
        width: 100%;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }
    
    .form-control::placeholder {
        color: #a0aec0;
    }
    
    .btn-login {
        width: 100%;
        padding: 0.875rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        cursor: pointer;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }
    
    .btn-login:active {
        transform: translateY(0);
    }
    
    .form-check {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .form-check-input {
        width: 18px;
        height: 18px;
        margin-right: 0.5rem;
        cursor: pointer;
        border: 2px solid #cbd5e0;
        border-radius: 4px;
    }
    
    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }
    
    .form-check-label {
        color: #4a5568;
        font-size: 0.9rem;
        cursor: pointer;
        margin: 0;
    }
    
    .forgot-password {
        text-align: center;
        margin-top: 1.5rem;
    }
    
    .forgot-password a {
        color: #667eea;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }
    
    .forgot-password a:hover {
        color: #764ba2;
        text-decoration: underline;
    }
    
    .invalid-feedback {
        display: block;
        color: #e53e3e;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    .form-control.is-invalid {
        border-color: #e53e3e;
    }
    
    @media (max-width: 576px) {
        .login-card {
            padding: 2rem 1.5rem;
            margin: 1rem;
        }
        
        .login-header h1 {
            font-size: 1.75rem;
        }
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="brand-logo">
                {{ strtoupper(substr(config('app.name', 'NNK'), 0, 2)) }}
            </div>
            <h1>Welcome Back</h1>
            <p>Sign in to your account to continue</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <button type="submit" class="btn btn-login">
                {{ __('Sign In') }}
            </button>

            @if (Route::has('password.request'))
                <div class="forgot-password">
                    <a href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection

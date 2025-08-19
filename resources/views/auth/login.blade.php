@extends('layouts.app')

@section('title', 'Login - TicketHub')

@section('styles')
<style>
    .auth-container {
        display: flex;
        min-height: 80vh;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
    }
    
    .auth-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 450px;
        padding: 40px;
    }
    
    .auth-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .auth-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 10px;
    }
    
    .auth-subtitle {
        color: var(--gray);
        font-size: 16px;
    }
    
    .auth-form .form-group {
        margin-bottom: 20px;
    }
    
    .auth-form label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--dark);
    }
    
    .auth-form .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s;
    }
    
    .auth-form .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    
    .remember-forgot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .remember-me {
        display: flex;
        align-items: center;
    }
    
    .remember-me input {
        margin-right: 8px;
    }
    
    .forgot-password {
        color: var(--primary);
        text-decoration: none;
        font-size: 14px;
    }
    
    .forgot-password:hover {
        text-decoration: underline;
    }
    
    .auth-btn {
        width: 100%;
        padding: 12px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.3s;
    }
    
    .auth-btn:hover {
        background: var(--primary-dark);
    }
    
    .auth-footer {
        text-align: center;
        margin-top: 30px;
        color: var(--gray);
    }
    
    .auth-footer a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }
    
    .auth-footer a:hover {
        text-decoration: underline;
    }
    
    .social-login {
        margin-top: 25px;
        text-align: center;
    }
    
    .social-divider {
        display: flex;
        align-items: center;
        margin: 25px 0;
        color: var(--gray);
    }
    
    .social-divider::before,
    .social-divider::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #e5e7eb;
    }
    
    .social-divider span {
        padding: 0 15px;
        font-size: 14px;
    }
    
    .social-buttons {
        display: flex;
        gap: 15px;
    }
    
    .social-btn {
        flex: 1;
        padding: 10px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.3s;
    }
    
    .social-btn:hover {
        background: #f9fafb;
    }
    
    .social-btn img {
        width: 20px;
        height: 20px;
    }
    
    @media (max-width: 576px) {
        .auth-card {
            padding: 30px 20px;
        }
        
        .remember-forgot {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .social-buttons {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Sign in to your account to continue</p>
        </div>
        
        <form class="auth-form" method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email">
                
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="remember-forgot">
                <div class="remember-me">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Remember me</label>
                </div>
                
                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        Forgot Password?
                    </a>
                @endif
            </div>
            
            <button type="submit" class="auth-btn">Sign In</button>
        </form>
        
        <div class="social-divider">
            <span>Or continue with</span>
        </div>
        
        <div class="social-login">
            <div class="social-buttons">
                <button type="button" class="social-btn">
                    <i class="fab fa-google" style="color: #DB4437;"></i>
                </button>
                <button type="button" class="social-btn">
                    <i class="fab fa-facebook-f" style="color: #4267B2;"></i>
                </button>
                <button type="button" class="social-btn">
                    <i class="fab fa-twitter" style="color: #1DA1F2;"></i>
                </button>
            </div>
        </div>
        
        <div class="auth-footer">
            <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
        </div>
    </div>
</div>
@endsection
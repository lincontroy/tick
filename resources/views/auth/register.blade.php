@extends('layouts.app')

@section('title', 'Register - TicketHub')

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
        max-width: 500px;
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
    
    .form-row {
        display: flex;
        gap: 15px;
    }
    
    .form-row .form-group {
        flex: 1;
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
    
    .terms-text {
        margin-top: 20px;
        font-size: 14px;
        color: var(--gray);
        text-align: center;
    }
    
    .terms-text a {
        color: var(--primary);
        text-decoration: none;
    }
    
    .terms-text a:hover {
        text-decoration: underline;
    }
    
    @media (max-width: 576px) {
        .auth-card {
            padding: 30px 20px;
        }
        
        .form-row {
            flex-direction: column;
            gap: 0;
        }
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle">Join us to discover amazing events</p>
        </div>
        
        <form class="auth-form" method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="given-name" autofocus placeholder="Enter your first name">
                    
                    @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name" placeholder="Enter your last name">
                    
                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email">
                
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="tel" placeholder="e.g., 254712345678">
                
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Create a password">
                    
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password-confirm">Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                </div>
            </div>
            
            <button type="submit" class="auth-btn">Create Account</button>
        </form>
        
        <div class="terms-text">
            <p>By creating an account, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>
        </div>
        
        <div class="auth-footer">
            <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password strength indicator (optional enhancement)
        const passwordInput = document.getElementById('password');
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                const strengthIndicator = document.getElementById('password-strength');
                
                if (!strengthIndicator) {
                    // Create strength indicator if it doesn't exist
                    const indicator = document.createElement('div');
                    indicator.id = 'password-strength';
                    indicator.style.marginTop = '8px';
                    indicator.style.fontSize = '14px';
                    this.parentNode.appendChild(indicator);
                }
                
                // Check password strength
                const strength = checkPasswordStrength(password);
                const indicator = document.getElementById('password-strength');
                
                switch(strength) {
                    case 0:
                    case 1:
                        indicator.innerHTML = 'Password strength: <span style="color: #ef4444;">Weak</span>';
                        break;
                    case 2:
                        indicator.innerHTML = 'Password strength: <span style="color: #f59e0b;">Medium</span>';
                        break;
                    case 3:
                    case 4:
                        indicator.innerHTML = 'Password strength: <span style="color: #10b981;">Strong</span>';
                        break;
                }
            });
        }
        
        function checkPasswordStrength(password) {
            let strength = 0;
            
            // Length check
            if (password.length >= 8) strength++;
            
            // Contains both lower and uppercase characters
            if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength++;
            
            // Contains numbers
            if (password.match(/([0-9])/)) strength++;
            
            // Contains special characters
            if (password.match(/([!,@,#,$,%,^,&,*,?,_,~])/)) strength++;
            
            return strength;
        }
    });
</script>
@endsection
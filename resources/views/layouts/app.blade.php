<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TicketCraft - Event Ticketing Platform')</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #10b981;
            --dark: #1f2937;
            --light: #f9fafb;
            --gray: #9ca3af;
            --danger: #ef4444;
            --success: #10b981;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            background-color: #f5f7fa;
            line-height: 1.6;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header Styles */
        header {
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }
        
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .logo i {
            margin-right: 10px;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
        }
        
        .nav-links li {
            margin-left: 30px;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: var(--primary);
        }
        
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            font-size: 16px;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }
        
        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }
        
        /* Main Content */
        main {
            min-height: calc(100vh - 200px);
            padding: 40px 0;
        }
        
        /* Alert Styles */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }
        
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }
        
        .alert-error {
            background-color: #fee2e2;
            color: #b91c1c;
            border-left: 4px solid #ef4444;
        }
        
        .alert i {
            margin-right: 10px;
        }
        
        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-column h3 {
            font-size: 20px;
            margin-bottom: 20px;
            position: relative;
        }
        
        .footer-column h3:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -10px;
            width: 40px;
            height: 3px;
            background: var(--primary);
        }
        
        .footer-column p {
            margin-bottom: 20px;
            opacity: 0.8;
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: white;
            opacity: 0.8;
            text-decoration: none;
            transition: opacity 0.3s;
        }
        
        .footer-links a:hover {
            opacity: 1;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
        }
        
        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .social-links a:hover {
            background: var(--primary);
        }
        
        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.7;
        }
        
        /* Responsive Styles */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="{{ route('home') }}" class="logo">
                    <i class="fas fa-ticket-alt"></i>
                    TicketCraft
                </a>
                <ul class="nav-links">
                    <li><a href="{{ route('events.index') }}">Events</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                    
                    @auth
                    <li><a href="{{ route('home') }}">Dashboard</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                        </form>
                    </li>
                    @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
                
                @auth
                <span class="text-dark">Welcome, {{ Auth::user()->name }}</span>
                @else
                <a href="{{ route('login') }}" class="btn btn-primary">Sign In</a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <div class="container">
            <!-- Alert Messages -->
            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
            @endif
            
            @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
            @endif
            
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>About TicketCraft</h3>
                    <p>TicketCraft is Kenya's premier event ticketing platform, connecting event organizers with attendees through a seamless booking experience.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('events.index') }}">Browse Events</a></li>
                        <li><a href="#">Create Event</a></li>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">FAQs</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt"></i> Nairobi, Kenya</li>
                        <li><i class="fas fa-phone"></i> +254 700 123456</li>
                        <li><i class="fas fa-envelope"></i> info@TicketCraft.co.ke</li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2023 TicketCraft. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Basic JavaScript functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Close alert messages
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 600);
                }, 5000);
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>
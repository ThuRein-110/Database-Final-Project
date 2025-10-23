<?php
session_start();
if(!isset($_SESSION["user"])){
    header ("Location:./Login&Reg/login.php");
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: white;
        }

        .dashboard-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            padding: 3rem;
            width: 100%;
            max-width: 600px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dashboard-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1e3c72, #2a5298, #1e3c72);
            border-radius: 20px 20px 0 0;
        }

        .welcome-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        h1 {
            color: #1e3c72;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .welcome-text {
            color: #2a5298;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            font-weight: 500;
        }

        .user-info {
            background: rgba(30, 60, 114, 0.1);
            padding: 1.5rem;
            border-radius: 15px;
            margin: 2rem 0;
            border: 2px solid rgba(30, 60, 114, 0.2);
        }

        .user-info h3 {
            color: #1e3c72;
            margin-bottom: 1rem;
        }

        .user-details {
            color: #2a5298;
            font-size: 1.1rem;
        }

        .btn-logout {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(30, 60, 114, 0.4);
        }

        .btn-logout:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(30, 60, 114, 0.6);
            color: white;
            background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin: 2rem 0;
        }

        .feature-item {
            background: rgba(42, 82, 152, 0.1);
            padding: 1rem;
            border-radius: 10px;
            color: #1e3c72;

            border: 1px solid rgba(42, 82, 152, 0.2);
            transition: transform 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 2rem;
                margin: 1rem;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .welcome-icon {
                font-size: 3rem;
            }
        }

        @media (max-width: 480px) {
            .dashboard-container {
                padding: 1.5rem;
            }
            
            h1 {
                font-size: 1.8rem;
            }
            
            .welcome-text {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container position-relative">
        <!-- Welcome Icon -->
        <div class="welcome-icon">
            <i class="fas fa-shield-check"></i>
        </div>
        
        <!-- Title -->
        <h1>Welcome to Dashboard</h1>
        <p class="welcome-text">You have successfully logged in to your secure area</p>
        
        <!-- User Information -->
        <div class="user-info">
            <h3><i class="fas fa-user-circle me-2"></i>User Information</h3>
            <div class="user-details">
                <p><strong>Status:</strong> Verified User</p>
                <p><strong>Session:</strong> Active</p>
                <p><strong>Last Login:</strong> Just now</p>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon">🔒</div>
                <h5>Secure Access</h5>
                <small>Protected area with encryption</small>
            </div>
            <div class="feature-item">
                <div class="feature-icon">⚡</div>
                <h5>Fast Performance</h5>
                <small>Optimized for best experience</small>
            </div>
            <div class="feature-item">
                <div class="feature-icon">📱</div>
                <h5>Mobile Ready</h5>
                <small>Responsive on all devices</small>
            </div>
            <div class="feature-item">
                <div class="feature-icon">🌐</div>
                <h5>Online 24/7</h5>
                <small>Always available for you</small>
            </div>
        </div>

        <!-- Logout Button -->
        <a href="../LOGINWITHPHP/Login&Reg/logout.php" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
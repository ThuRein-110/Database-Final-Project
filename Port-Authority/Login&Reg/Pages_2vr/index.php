<?php
session_start();

if(!isset($_SESSION["user"])){
    header("Location: ../login.php"); // adjust if needed
    exit;
}

// Correct path to database.php
$databasePath = __DIR__ . "/../../database.php";

if(!file_exists($databasePath)){
    die("Database file not found at: $databasePath");
}

require_once $databasePath;



session_start();
include "../../database.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $passport_number = $_POST['passport_number'];
    $visa_type = $_POST['visa_type'];
    $status = $_POST['status'];

    // Insert record using prepared statement
    $stmt = $conn->prepare("INSERT INTO visa_applications (full_name, passport_number, visa_type, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $full_name, $passport_number, $visa_type, $status);
    if ($stmt->execute()) {
        $message = "Visa application added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Glass - Neural Interface Design</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="templatemo-neural-style.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">



<!--

TemplateMo 597 Neural Glass

https://templatemo.com/tm-597-neural-glass

-->
    <style>
       
    </style>
</head>
<body>
    <!-- Epic Neural Background -->
    <div class="neural-background"></div>
    
    <!-- Floating Geometric Shapes -->
    <div class="geometric-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- Neural Network Lines -->
    <div class="neural-lines">
        <div class="neural-line"></div>
        <div class="neural-line"></div>
        <div class="neural-line"></div>
    </div>

    <!-- Header -->
    <header class="glass">
        <nav>
            <a href="#home" class="logo">
                <svg class="logo-icon" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#e0a3ff"/>
                            <stop offset="50%" style="stop-color:#ff69b4"/>
                            <stop offset="100%" style="stop-color:#9370db"/>
                        </linearGradient>
                    </defs>
                    <circle cx="50" cy="30" r="8" fill="url(#logoGradient)" opacity="0.8">
                        <animate attributeName="opacity" values="0.8;1;0.8" dur="2s" repeatCount="indefinite"/>
                    </circle>
                    <circle cx="30" cy="60" r="6" fill="url(#logoGradient)" opacity="0.6">
                        <animate attributeName="opacity" values="0.6;1;0.6" dur="2.5s" repeatCount="indefinite"/>
                    </circle>
                    <circle cx="70" cy="65" r="7" fill="url(#logoGradient)" opacity="0.7">
                        <animate attributeName="opacity" values="0.7;1;0.7" dur="1.8s" repeatCount="indefinite"/>
                    </circle>
                    <line x1="50" y1="30" x2="30" y2="60" stroke="url(#logoGradient)" stroke-width="2" opacity="0.6">
                        <animate attributeName="opacity" values="0.6;1;0.6" dur="3s" repeatCount="indefinite"/>
                    </line>
                    <line x1="50" y1="30" x2="70" y2="65" stroke="url(#logoGradient)" stroke-width="2" opacity="0.6">
                        <animate attributeName="opacity" values="0.6;1;0.6" dur="2.2s" repeatCount="indefinite"/>
                    </line>
                    <line x1="30" y1="60" x2="70" y2="65" stroke="url(#logoGradient)" stroke-width="2" opacity="0.6">
                        <animate attributeName="opacity" values="0.6;1;0.6" dur="2.8s" repeatCount="indefinite"/>
                    </line>
                </svg>
                Immegration
            </a>
            <ul class="nav-links">
                <li><a href="#features">Home</a></li>
                <li><a href="#showcase">Announancement</a></li>
                <li><a href="#timeline">Documentation</a></li>
                <li><a href="#contact" >Visa Application</a></li>
                <li><a href="../logout.php">Logouts</a></li>
</ul>
            </ul>
            <div class="mobile-menu-toggle">
                <div class="hamburger-line"></div>
                <div class="hamburger-line"></div>
                <div class="hamburger-line"></div>
            </div>
        </nav>
        <div class="mobile-nav">
            <a href="#features">Home</a>
            <a href="#showcase">Announancement</a>
            <a href="#timeline">Documentation</a>
            <a href="#contact">Visa Application</a>
           <a href="../logout.php">Logouts</a>
        </div>
    </header>

    <!-- Section 1: Hero -->
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-subtitle">Welcome to the Immegration</div>
            <h1>Online Booking Is Available Now</h1>
            
            <div class="hero-description">
                <p>
                    I don't know what to write here. Please help me to write something.
            </p>
            </div>

            <div class="hero-stats">
                <div class="hero-stat">
                    <span class="hero-stat-number">90 Days</span>
                    <span class="hero-stat-label">Report System</span>
                </div>
                <div class="hero-stat">
                    <span class="hero-stat-number">TM30</span>
                    <span class="hero-stat-label"> Online</span>
                </div>
                <div class="hero-stat">
                    <span class="hero-stat-number">Online</span>
                    <span class="hero-stat-label">Booking</span>
                </div>
                <div class="hero-stat">
                    <span class="hero-stat-number">24/7</span>
                    <span class="hero-stat-label">Neural Access</span>
                </div>
            </div>
            
            <div class="cta-buttons">
                <a href="#features" class="cta-button">Home</a>
                <a href="#showcase" class="cta-button secondary">Explore Announancement</a>
            </div>
        </div>
    </section>

    <!-- Section 2: Diagonal Features -->
    <section class="features" id="features">
        <div class="features-container">
            <h2 class="section-title">QUANTUM CAPABILITIES</h2>
            <div class="diagonal-grid">
                <div class="feature-row">
                    <div class="feature-content glass">
                        <div class="feature-icon">🧠</div>
                        <h3>Neural Processing</h3>
                        <p>Advanced AI-driven interfaces that adapt to your consciousness patterns, creating personalized digital experiences that evolve with your neural pathways.</p>
                    </div>
                    <div class="feature-visual glass"></div>
                </div>
                
                <div class="feature-row">
                    <div class="feature-content glass">
                        <div class="feature-icon">⚡</div>
                        <h3>Quantum Speed</h3>
                        <p>Instantaneous data processing through quantum tunneling algorithms, delivering response times that exist outside conventional spacetime constraints.</p>
                    </div>
                    <div class="feature-visual glass"></div>
                </div>
                
                <div class="feature-row">
                    <div class="feature-content glass">
                        <div class="feature-icon">🌐</div>
                        <h3>Dimensional Sync</h3>
                        <p>Seamless synchronization across multiple reality layers, ensuring your digital presence remains consistent throughout parallel dimensions.</p>
                    </div>
                    <div class="feature-visual glass"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 3: Hexagonal Showcase -->
    <section class="showcase" id="showcase">
        <h2 class="section-title">MATRIX PROTOCOLS</h2>
        <div class="hexagon-container">
            <div class="hexagon">
                <div class="hexagon-inner glass">
                    <div class="hexagon-icon">🔮</div>
                    <h4>Holographic UI</h4>
                    <p>3D interfaces projected into reality space</p>
                </div>
            </div>
            <div class="hexagon">
                <div class="hexagon-inner glass">
                    <div class="hexagon-icon">🛡️</div>
                    <h4>Quantum Security</h4>
                    <p>Unbreakable encryption protocols</p>
                </div>
            </div>
            <div class="hexagon">
                <div class="hexagon-inner glass">
                    <div class="hexagon-icon">🚀</div>
                    <h4>Warp Navigation</h4>
                    <p>Instant travel between data nodes</p>
                </div>
            </div>
            <div class="hexagon">
                <div class="hexagon-inner glass">
                    <div class="hexagon-icon">💎</div>
                    <h4>Crystal Storage</h4>
                    <p>Infinite capacity data crystals</p>
                </div>
            </div>
            <div class="hexagon">
                <div class="hexagon-inner glass">
                    <div class="hexagon-icon">🎯</div>
                    <h4>Neural Targeting</h4>
                    <p>Thought-based interaction systems</p>
                </div>
            </div>
            <div class="hexagon">
                <div class="hexagon-inner glass">
                    <div class="hexagon-icon">⭐</div>
                    <h4>Stellar Network</h4>
                    <p>Galactic-scale connectivity matrix</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: Timeline -->
    <section class="timeline" id="timeline">
        <h2 class="section-title">EVOLUTION TIMELINE</h2>
        <div class="timeline-container">
            <div class="timeline-line"></div>
            
            <div class="timeline-item">
                <div class="timeline-content glass">
                    <div class="timeline-year">2024</div>
                    <h4>Genesis Protocol</h4>
                    <p>NeuralGlass is a cutting-edge cyberpunk glassmorphism HTML template featuring a striking purple, pink, and green color palette with futuristic neural network aesthetics.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-content glass">
                    <div class="timeline-year">2025</div>
                    <h4>Matrix Integration</h4>
                    <p>Built with pure HTML/CSS and vanilla JavaScript, it offers smooth scrolling, mobile-responsive navigation with hamburger menu, parallax effects, and dynamic visual elements that respond to user interaction.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-content glass">
                    <div class="timeline-year">2026</div>
                    <h4>Quantum Leap</h4>
                    <p>This HTML CSS template is brought to you by TemplateMo website. Perfect for tech startups, AI companies, gaming platforms, or any project requiring a bold, futuristic web presence.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-content glass">
                    <div class="timeline-year">2027</div>
                    <h4>Neural Singularity</h4>
                    <p>Human consciousness successfully merges with AI systems, creating hybrid intelligences that transcend biological limitations.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
        </div>
    </section>

    <!-- Section 5: Contact -->
<section class="" id="contact">
 <div class="container">
    <h1>Visa Application Form</h1>
    <?php if($message) echo "<p style='text-align:center;color:green;'>$message</p>"; ?>
    <form method="POST" class="form">
        <label>Full Name</label>
        <input type="text" name="full_name" required>
        <label>Passport Number</label>
        <input type="text" name="passport_number" required>
        <label>Visa Type</label>
        <select name="visa_type" required>
            <option value="Tourist_visa">Tourist Visa (TR)</option>
            <option value="Free_entry">Free Entry</option>
            <option value="transit">Visa On Transit</option>
            <option value="business">Business Visa (BR)</option>
            <option value="student">Student Visa (SR)</option>
            <option value="work">Work Visa (WR)</option>
            <option value="diplomatic">Diplomatic Visa (DR)</option>
            <option value="official">Official Visa (OR)</option>
            <option value="medical">Medical Visa (MR)</option>
            <option value="journalist">Journalist Visa (JR)</option>
            <option value="research">Research Visa (RR)</option>
            <option value="cultural">Cultural Visa (CR)</option>
            <option value="family">Family Visa (FR)</option>
            <option value="retirement">Retirement Visa</option>
            <option value="permanent">Permanent Resident Visa (PR)</option>
            <option value="nonImmigrant">Non-Immigrant Visa (NR)</option>

        </select>
        <label>Status</label>
        <select name="status" required>
            <option value="Pending">Pending</option>
        </select>
        <button type="submit">Add Application</button>
        <a href="index.php" class="back-btn" >Back</a>

    </form>
</div>
        
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-links">
                <a href="#features">Neural Networks</a>
                <a href="#showcase">Matrix Protocols</a>
                <a href="#timeline">Evolution</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Documentation</a>
                <!-- Add external links -->
    			<a href="https://github.com/yourproject" target="_blank" rel="noopener">GitHub</a>
            </div>
            <div class="footer-copyright">
                <p>&copy; 2025 NeuralGlass Interface. All quantum rights reserved across dimensions.</p>
            </div>
            <div class="footer-design">
                Design: <a href="https://templatemo.com" target="_blank" rel="nofollow noopener">TemplateMo</a> | 
                Enhanced by Neural AI Systems | 
                <a href="#">Quantum Framework</a>
            </div>
        </div>
    </footer>
<script src="templatemo-neural-scripts.js"></script>
</body>
</html>

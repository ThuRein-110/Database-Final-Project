<?php
session_start();

// Check login
if (!isset($_SESSION["user"])) {
    header("Location: ../login.php");
    exit();
}

// Database connection
$databasePath = __DIR__ . "/../../../database.php";
if (!file_exists($databasePath)) {
    die("Database file not found at: $databasePath");
}
require_once $databasePath;

$message = "";

// Debug connection
if (!$conn) {
    die("❌ Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $passport_number = $_POST['passport_number'];
    $visa_type = $_POST['visa_type'];
    $status = $_POST['status'];

    // Insert into visa_applications
    $query = "INSERT INTO visa_applications (full_name, passport_number, visa_type, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("❌ Prepare failed: " . $conn->error . "<br>Query: " . $query);
    }

    $stmt->bind_param("ssss", $full_name, $passport_number, $visa_type, $status);

    if ($stmt->execute()) {
        $visa_id = $conn->insert_id;

        
        // 🟡 Handle document upload
        if (isset($_FILES['document_file']) && $_FILES['document_file']['error'] === UPLOAD_ERR_OK) {
            $fileTmp = $_FILES['document_file']['tmp_name'];
            $fileName = basename($_FILES['document_file']['name']);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            // Create subfolder uploads/PASSPORT_FULLNAME/
            $safeFolder = preg_replace('/[^A-Za-z0-9_\-]/', '_', $passport_number . "_" . $full_name);
            $uploadDir = __DIR__ . "/uploads/" . $safeFolder . "/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $newFileName = uniqid() . "_" . $fileName;
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmp, $uploadPath)) {
                $stmt2 = $conn->prepare("INSERT INTO document (visa_id, document_name) VALUES (?, ?)");
                if ($stmt2) {
                    $stmt2->bind_param("is", $visa_id, $newFileName);
                    $stmt2->execute();
                } else {
                    die("❌ Document insert failed: " . $conn->error);
                }
            } else {
                die("❌ File move failed.");
            }
        }

        header("Location: index.php?success=1");
        exit();
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
                            <stop offset="0%" style="stop-color:#1e3c72"/>
                            <stop offset="50%" style="stop-color:#1e3c72"/>
                            <stop offset="100%" style="stop-color:#1e3c72"/>
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
                Immigration
            </a>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#showcase">Announcement</a></li>
                <li><a href="#timeline">Documentation</a></li>
                <li><a href="#contact">Visa Application</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
            <div class="mobile-menu-toggle">
                <div class="hamburger-line"></div>
                <div class="hamburger-line"></div>
                <div class="hamburger-line"></div>
            </div>
        </nav>
        <div class="mobile-nav">
            <a href="#home">Home</a>
            <a href="#showcase">Announcement</a>
            <a href="#timeline">Documentation</a>
            <a href="#contact">Visa Application</a>
            <a href="../logout.php">Logout</a>
        </div>
    </header>

    <!-- Section 1: Hero -->
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-subtitle">Welcome to the Immigration</div>
            <h1>Online Booking Is Available Now</h1>
            
            <div class="hero-description">
                <p>
                    Streamline your immigration process with our advanced online system. Fast, secure, and convenient visa applications and services.
                </p>
            </div>

            <div class="hero-stats">
                <div class="hero-stat">
                    <span class="hero-stat-number">90 Days</span>
                    <span class="hero-stat-label">Report System</span>
                </div>
                <div class="hero-stat">
                    <span class="hero-stat-number">TM30</span>
                    <span class="hero-stat-label">Online</span>
                </div>
                <div class="hero-stat">
                    <span class="hero-stat-number">Online</span>
                    <span class="hero-stat-label">Booking</span>
                </div>
                <div class="hero-stat">
                    <span class="hero-stat-number">24/7</span>
                    <span class="hero-stat-label">Online Access</span>
                </div>
            </div>
            
            <div class="cta-buttons">
                <a href="#features" class="cta-button">Home</a>
                <a href="#showcase" class="cta-button secondary">Explore Announcement</a>
            </div>
        </div>
    </section>
	
	            <!-- Added Image under CTA buttons -->
            <div style="margin-top: 3rem; text-align: center;">
                <img src="images/Thai1.jpg" 
                     alt="Immigration Services" 
                     style="max-width: 600px; width: 100%; height: auto; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
            </div>

    <!-- Section 2: Diagonal Features -->
	 

    <!-- Section 3: Hexagonal Showcase -->
    <section class="showcase" id="showcase">
        <h2 class="section-title">IMMIGRATION SERVICES</h2>
        <div class="hexagon-container">
            <div class="hexagon">
                <div class="hexagon-inner glass">
                    
                    <h4>Visa Types</h4>
                    <p>Various visa categories available</p>
                </div>
            </div>
            <div class="hexagon">
                <div class="hexagon-inner glass">
                    
                    <h4>Security</h4>
                    <p>Secure application processing</p>
                </div>
            </div>
            <div class="hexagon">
                <div class="hexagon-inner glass">
                    
                    <h4>Support</h4>
                    <p>24/7 customer support</p>
                </div>
            </div>
        </div>
    </section>
           

    <!-- Section 4: Timeline -->
    <section class="timeline" id="timeline">
        <h2 class="section-title">PROCESS TIMELINE</h2>
        <div class="timeline-container">
            <div class="timeline-line"></div>
            
            <div class="timeline-item">
                <div class="timeline-content glass">
                    <div class="timeline-year">Step 1</div>
                    <h4>Application</h4>
                    <p>Submit your complete visa application with all required documents through our secure online portal.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-content glass">
                    <div class="timeline-year">Step 2</div>
                    <h4>Document Review</h4>
                    <p>Our immigration officers carefully review your application and documents for completeness and accuracy.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-content glass">
                    <div class="timeline-year">Step 3</div>
                    <h4>Processing</h4>
                    <p>Your application enters the processing phase with regular status updates available through your account.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-content glass">
                    <div class="timeline-year">Step 4</div>
                    <h4>Approval</h4>
                    <p>Receive your visa decision and follow the instructions for next steps in the immigration process.</p>
                </div>
                <div class="timeline-dot"></div>
            </div>
        </div>
    </section>

   <!-- Section 5: Contact -->
<section id="contact">
  <div class="container">
    <h1>Visa Application Form</h1>
    <?php if ($message) echo "<p style='text-align:center;color:green;'>$message</p>"; ?>
    <form method="POST" enctype="multipart/form-data" class="form">
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

      <!-- 📎 Upload Document -->
      <label>Upload Document (PDF or Image)</label>
      <input type="file" name="document_file" accept=".pdf,.jpg,.jpeg,.png" required>

      <button type="submit" name="submit">Add Application</button>
      <a href="index.php" class="back-btn">Back</a>
    </form>
  </div>
</section>


    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-links">
                <a href="#features">Immigration Services</a>
                <a href="#showcase">Announcements</a>
                <a href="#timeline">Process Guide</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Documentation</a>
                <a href="https://github.com/yourproject" target="_blank" rel="noopener">Support</a>
            </div>
        </div>
    </footer>
    <script src="templatemo-neural-scripts.js"></script>
</body>
</html>
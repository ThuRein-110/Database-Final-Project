<?php
session_start();
if(isset($_SESSION["user"])){
    header ("Location:../welcome.php");
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Column Account</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./style_reg.css">
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <h1>Column</h1>
        </div>
        
        <h2 class="form-title">Create new account</h2>
        <p class="form-subtitle">Join Column today and get started</p>
        
        <?php
        if (isset($_POST['submit'])) {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $repeat_password = $_POST['repeat_password'];
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $errors = array();

            if (empty($fullname) || empty($email) || empty($password) || empty($repeat_password)) {
                $errors[] = "All fields are required";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email is not valid";
            }
            if (strlen($password) < 8) {
                $errors[] = "Password must be at least 8 characters long";
            }
            if ($password !== $repeat_password) {
                $errors[] = "Password does not match";
            }
            require_once "./../database.php";

            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($conn,$sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount > 0) {
                array_push($errors, "Email already exists");
            }
            // Show errors
            if (!empty($errors)) {
                foreach ($errors as $err) {
                    echo "<div class='alert alert-danger'>$err</div>";
                }
            } else {
                
                $sql = "INSERT  INTO users(full_name, email, password) VALUES(?,?,?) ";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if($prepareStmt){
                    mysqli_stmt_bind_param($stmt,"sss",$fullname,$email,$password_hash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>You are registered successfully.</div>";
                } else {
                    die("Something went wrong");
                }
            }

        }
        ?>

        <form action="../Login&Reg/reg.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full name" value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" id="password" required>
                <button type="button" class="password-toggle" id="togglePassword">
                    <i class="far fa-eye"></i>
                </button>
                <div class="password-strength" id="passwordStrength"></div>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password" id="repeatPassword" required>
                <button type="button" class="password-toggle" id="toggleRepeatPassword">
                    <i class="far fa-eye"></i>
                </button>
                <div id="passwordMatch" style="font-size: 0.85rem; margin-top: 5px; display: none;"></div>
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Create Account" name="submit">
            </div>
        </form>
        
        <div class="links">
            <p>Already have an account? <a href="../Login&Reg/login.php">Sign in</a></p>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Toggle repeat password visibility
        document.getElementById('toggleRepeatPassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('repeatPassword');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthIndicator = document.getElementById('passwordStrength');
            
            if (password.length === 0) {
                strengthIndicator.style.display = 'none';
                return;
            }
            
            strengthIndicator.style.display = 'block';
            
            // Simple password strength algorithm
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            if (strength < 2) {
                strengthIndicator.textContent = 'Weak password';
                strengthIndicator.className = 'password-strength weak';
            } else if (strength < 4) {
                strengthIndicator.textContent = 'Medium password';
                strengthIndicator.className = 'password-strength medium';
            } else {
                strengthIndicator.textContent = 'Strong password';
                strengthIndicator.className = 'password-strength strong';
            }
        });
        
        // Password match indicator
        document.getElementById('repeatPassword').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const repeatPassword = this.value;
            const matchIndicator = document.getElementById('passwordMatch');
            
            if (repeatPassword.length === 0) {
                matchIndicator.style.display = 'none';
                return;
            }
            
            matchIndicator.style.display = 'block';
            
            if (password === repeatPassword) {
                matchIndicator.textContent = 'Passwords match';
                matchIndicator.style.color = 'var(--success-color)';
            } else {
                matchIndicator.textContent = 'Passwords do not match';
                matchIndicator.style.color = 'var(--error-color)';
            }
        });
    </script>
</body>
</html>
<?php
session_start();
if(isset($_SESSION["user"])){
    header ("Location: Pages_2vr/index.php");
    exit();
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in to Column</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1>Immegration</h1>
        </div>
        
        <h2 class="form-title">Sign in</h2>
        <p class="form-subtitle">Enter your credentials to access your account</p>
        
        <?php
        if(isset($_POST["login"])){
            $email = $_POST["email"];
            $password = $_POST["password"];
            require_once "../../database.php";
            $sql = "SELECT * FROM users WHERE email ='$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if($user){
                if(password_verify($password, $user["password"])){
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("Location: ./Pages_2vr/index.php");
                    die();
                } else{
                    echo "<div class='alert alert-danger'>Password is incorrect</div>";
                }
            } else{
                echo "<div class='alert alert-danger'>User not found</div>";
            }
            $errors = array();
        }
        ?>
        
        <form action="../Login&Reg/login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <input type="password" placeholder="Enter Password" name="password" class="form-control" id="password" required>
                <button type="button" class="password-toggle" id="togglePassword">
                    <i class="far fa-eye"></i>
                </button>
            </div>
            
            <div class="form-btn">
                <input type="submit" name="login" class="btn btn-primary" value="Sign in">
            </div>
        </form>
        
        <div class="links">
            <p><a href="#">Forgot your password?</a></p>
            <p>Don't have a Immegration account? <a href="../Login&Reg/reg.php">Create new account</a></p>
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
    </script>
</body>
</html>
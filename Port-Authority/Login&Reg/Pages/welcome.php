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
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome to the protected area!</h1>
    <p>You have successfully logged in.</p>
    <a href="../LOGINWITHPHP/Login&Reg/logout.php" class="btn btn-danger">Logout</a>
</body>
</html>
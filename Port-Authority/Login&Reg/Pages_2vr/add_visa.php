<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


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
    <title>Add Visa Application</title>
    <link rel="stylesheet" href="/DATABASETESTING/Port-Authority/admin_panel/dashboard.css">
</head>
<body>
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
        <a href="index.php" class="back-btn" style="margin-top: 10px;padding: 8px 15px;background: #4CAF50;color: white;border: none;border-radius: 4px;cursor: pointer;width:8%">Back</a>

    </form>
</div>
</body>
</html>

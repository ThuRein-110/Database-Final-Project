<?php
session_start();
include "../../database.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: dashboard.php");
    exit();
}

$message = "";

// Fetch current record
$stmt = $conn->prepare("SELECT * FROM visa_applications WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    header("Location: dashboard.php");
    exit();
}

// Update record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $passport_number = $_POST['passport_number'];
    $visa_type = $_POST['visa_type'];
    $status = $_POST['status'];

    $update = $conn->prepare("UPDATE visa_applications SET full_name=?, passport_number=?, visa_type=?, status=? WHERE id=?");
    $update->bind_param("ssssi", $full_name, $passport_number, $visa_type, $status, $id);
    if ($update->execute()) {
        $message = "Visa application updated successfully!";
        $row = ['full_name'=>$full_name, 'passport_number'=>$passport_number, 'visa_type'=>$visa_type, 'status'=>$status];
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
    <title>Edit Visa Application</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<div class="container">
    <h1>Edit Visa Application</h1>
    <?php if($message) echo "<p style='text-align:center;color:green;'>$message</p>"; ?>
    <form method="POST" class="form">
        <label>Full Name</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($row['full_name']) ?>" required>
        <label>Passport Number</label>
        <input type="text" name="passport_number" value="<?= htmlspecialchars($row['passport_number']) ?>" required>
        <label>Visa Type</label>
        <input type="text" name="visa_type" value="<?= htmlspecialchars($row['visa_type']) ?>" required>
        <label>Status</label>
        <select name="status" required>
            <option value="Pending" <?= $row['status']=='Pending'?'selected':'' ?>>Pending</option>
            <option value="Approved" <?= $row['status']=='Approved'?'selected':'' ?>>Approved</option>
            <option value="Rejected" <?= $row['status']=='Rejected'?'selected':'' ?>>Rejected</option>
        </select>
        <button type="submit">Update Application</button>
        <a href="dashboard.php" class="editBtn">Back</a>
    </form>
</div>
</body>
</html>

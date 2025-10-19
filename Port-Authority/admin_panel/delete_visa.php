<?php
session_start();
include "./../database.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM visa_applications WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: dashboard.php");
exit();

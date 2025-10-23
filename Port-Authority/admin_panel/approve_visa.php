<?php
session_start();
include "../../database.php";

if (!isset($_SESSION['admin'])) {
    header("Location: ./login_admin.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'];

    if (in_array($status, ['Approved', 'Rejected'])) {
        // 1️⃣ Update visa application status
        $stmt = $conn->prepare("UPDATE visa_applications SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();

        // 2️⃣ Get application info
        $fetch_stmt = $conn->prepare("SELECT full_name, passport_number FROM visa_applications WHERE id = ?");
        $fetch_stmt->bind_param("i", $id);
        $fetch_stmt->execute();
        $result = $fetch_stmt->get_result();
        $app = $result->fetch_assoc();
        $fetch_stmt->close();

        // 3️⃣ Log approval in Approval table (only for Approved)
        if ($status === 'Approved' && $app) {
            $user_name = $app['full_name'];
            $passport_num = $app['passport_number'];
            $admin_id = $_SESSION['admin']; // Make sure this holds Admin_ID or name
            $date = date("Y-m-d H:i:s");

            // Prevent duplicate approval entries
            $check_stmt = $conn->prepare("SELECT * FROM Approval WHERE Passport_num = ?");
            $check_stmt->bind_param("s", $passport_num);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows === 0) {
                $insert_stmt = $conn->prepare("INSERT INTO Approval (User_name, Admin_ID, Passport_num, Date) VALUES (?, ?, ?, ?)");
                $insert_stmt->bind_param("ssss", $user_name, $admin_id, $passport_num, $date);
                $insert_stmt->execute();
                $insert_stmt->close();
            }
            $check_stmt->close();
        }

        $stmt->close();
    }
}

header("Location: dashboard.php");
exit();
?>

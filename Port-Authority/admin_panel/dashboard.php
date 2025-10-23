<?php
session_start();
include "../../database.php";

if (!isset($_SESSION['admin'])) {
    header("Location: ./login_admin.php");
    exit();
}

$search = "";
$searchParam = "%";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $searchParam = "%$search%";

    $stmt = $conn->prepare("SELECT * FROM visa_applications WHERE full_name LIKE ? OR passport_number LIKE ? OR visa_type LIKE ? OR status LIKE ?");
    $stmt->bind_param("ssss", $searchParam, $searchParam, $searchParam, $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM visa_applications");
}

// Pie chart: visa_type counts
$visa_stmt = $conn->prepare("SELECT visa_type, COUNT(*) as total FROM visa_applications WHERE full_name LIKE ? OR passport_number LIKE ? OR visa_type LIKE ? OR status LIKE ? GROUP BY visa_type");
$visa_stmt->bind_param("ssss", $searchParam, $searchParam, $searchParam, $searchParam);
$visa_stmt->execute();
$visa_result = $visa_stmt->get_result();

$visa_labels = [];
$visa_totals = [];
while ($row = $visa_result->fetch_assoc()) {
    $visa_labels[] = $row['visa_type'];
    $visa_totals[] = (int)$row['total'];
}

// Column chart: status counts
$status_stmt = $conn->prepare("SELECT status, COUNT(*) as total FROM visa_applications WHERE full_name LIKE ? OR passport_number LIKE ? OR visa_type LIKE ? OR status LIKE ? GROUP BY status");
$status_stmt->bind_param("ssss", $searchParam, $searchParam, $searchParam, $searchParam);
$status_stmt->execute();
$status_result = $status_stmt->get_result();

$status_labels = [];
$status_totals = [];
while ($row = $status_result->fetch_assoc()) {
    $status_labels[] = $row['status'];
    $status_totals[] = (int)$row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visa Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container">
    <h1>Visa Application Dashboard</h1>

    <form method="GET" class="search-bar">
        <input type="text" name="search" placeholder="Search by name, passport, visa type or status" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
        <a href="dashboard.php" class="reset">Reset</a>
        <a href="login_admin.php" class="reset_logout">Logout</a>
    </form>
<div class="table-responsive">
    <table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Passport</th>
            <th>Visa Type</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['passport_number']) ?></td>
                    <td><?= htmlspecialchars($row['visa_type']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td>
                        <?php if ($row['status'] === 'Pending'): ?>
                            <a href="approve_visa.php?id=<?= $row['id'] ?>&status=Approved" class="approve-btn" onclick="return confirm('Approve this application?')">Approve</a>
                            <a href="approve_visa.php?id=<?= $row['id'] ?>&status=Rejected" class="reject-btn" onclick="return confirm('Reject this application?')">Reject</a>
                        <?php else: ?>
                            <span class="status-label"><?= htmlspecialchars($row['status']) ?></span>
                        <?php endif; ?>

                        <a href="edit_visa.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                        <a href="delete_visa.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete this record?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">No records found</td></tr>
        <?php endif; ?>
    </table>
</div>
</div>

<div class="chart-card">
    <div class="chart-left"><canvas id="pieChart"></canvas></div>
    <div class="chart-center">
        <h3>Chart Summary</h3>
        <p>This pie chart shows the distribution of visa types. The bar chart shows totals per status.</p>
    </div>
    <div class="chart-right"><canvas id="barChart"></canvas></div>
</div>

<script>
    // Pie chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: <?= json_encode($visa_labels); ?>,
            datasets: [{
                label: 'Visa Type Distribution',
                data: <?= json_encode($visa_totals); ?>,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#6BCB77', '#FFD93D']
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

    // Bar chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($status_labels); ?>,
            datasets: [{
                label: 'Applications',
                data: <?= json_encode($status_totals); ?>,
                backgroundColor: 'rgba(54,162,235,0.8)'
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
</script>

<style>
/* Button styling */
.approve-btn {
    background-color: #28a745;
    color: white;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 4px;
}
.reject-btn {
    background-color: #dc3545;
    color: white;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 4px;
}
.approve-btn:hover, .reject-btn:hover { opacity: 0.9; }

.status-label {
    padding: 5px 10px;
    border-radius: 4px;
    background-color: #6c757d;
    color: #fff;
    font-weight: bold;
}
</style>

</body>
</html>

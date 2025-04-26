<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style/dashboard_style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<header class="topbar">
    <div class="logo">EVENT ADMIN PORTAL</div>
    <nav>
        <a href="#">Home</a>
        <a href="#">Contact Us</a>
        <a href="#">About Us</a>
        <div class="admin-info">
            <i class="icon-calendar"></i>
            <i class="icon-bell"></i>
            <span><?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>
</header>

<aside class="sidebar">
    <div class="toggle-btn">&#9776;</div>
    <ul>
        <li class="active">Dashboard</li>
        <li>User Management</li>
        <li>Event Monitoring</li>
        <li>Support Ticket</li>
        <li>Budget Analytics</li>
    </ul>
</aside>

<main class="content">
    <h1>Dashboard</h1>
    <p>Welcome back! Here's what's happening today.</p>

    <div class="cards">
        <div class="card">
            <h3>Events</h3>
            <p>3 <span class="positive">+1%</span></p>
            <small>1 new today</small>
        </div>
        <div class="card">
            <h3>Budget</h3>
            <p>₱ 20,000.00 <span class="positive">+2%</span></p>
            <small>1 this month</small>
        </div>
        <div class="card">
            <h3>Active Users</h3>
            <p>6 <span class="positive">+1%</span></p>
            <small>2 online now</small>
        </div>
        <div class="card">
            <h3>Support Ticket</h3>
            <p>1 <span class="negative">-2%</span></p>
            <small>1 unresolved</small>
        </div>
    </div>

    <div class="charts">
        <canvas id="eventsChart" width="400" height="200"></canvas>

        <div class="calendar">
            <h3>APRIL 2025</h3>
            <img src="calendar_image.png" alt="Calendar" width="300">
            <div class="legend">
                <span class="green"></span> Available Schedule
                <span class="red"></span> Not Available
                <span class="orange"></span> Pending
            </div>
        </div>
    </div>

</main>

<script>
const ctx = document.getElementById('eventsChart').getContext('2d');
const eventsChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr'],
        datasets: [{
            label: 'Number of Events',
            data: [4, 3, 9, 1, 2, 4, 2],
            backgroundColor: 'blue'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>

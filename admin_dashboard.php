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
</head>
<body>

  <h1>Welcome, Admin: <?php echo htmlspecialchars($_SESSION['admin_username']); ?></h1>
  <p>This is the admin dashboard.</p>
  <a href="logout.php">Logout</a>

</body>
</html>

<?php
session_start();
if (!isset($_SESSION['client_logged_in'])) {
  header('Location: login.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Client Dashboard</title>
</head>
<body>

  <h1>Welcome, Client: <?php echo htmlspecialchars($_SESSION['client_email']); ?></h1>
  <p>This is the client dashboard.</p>
  <a href="logout.php">Logout</a>

</body>
</html>

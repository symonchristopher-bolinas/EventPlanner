<?php
session_start();

// Include database connection
$servername = "localhost";
$username = "root";  // Your MySQL username
$password = "";      // Your MySQL password
$dbname = "eventplanner"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data when POST request is made
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $confirm_email = $_POST['confirm_email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $organization = $_POST['organization'];
    $department = $_POST['department'];

    // Check if email matches confirm_email
    if ($email !== $confirm_email) {
        header("Location: login.php?error=Emails do not match");
        exit();
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        header("Location: login.php?error=Passwords do not match");
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email_query = "SELECT * FROM client_account WHERE clientemail = ?";
    $stmt = $conn->prepare($check_email_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists, redirect with an error
        header("Location: login.php?error=Email already registered");
        exit();
    }

    // Prepare SQL query to insert new user into `client_account` table
    $sql = "INSERT INTO client_account (clientemail, clientpassword, organization, department) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $email, $hashed_password, $organization, $department);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to login page with success message
        header("Location: login.php?success=Registration successful! Please log in.");
        exit();
    } else {
        // Error occurred during insertion
        header("Location: login.php?error=Error occurred during registration");
        exit();
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>

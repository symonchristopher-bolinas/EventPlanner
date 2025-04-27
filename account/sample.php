<?php
session_start();

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

// If already logged in, redirect
if (isset($_SESSION['admin_logged_in']) || isset($_SESSION['client_logged_in'])) {
    header('Location: ../index.php');
    exit();
}

// ===============================
// Configuration
// ===============================
$gmail_user = 'dimolmakapal@gmail.com';
$gmail_password = 'event_planner2025';
$site_url = 'http://localhost/email_verification/email_verify.php';
// ===============================

// Initialize variables
$step = 'signup'; // default step
$error_message = '';
$email = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['signup'])) {
        // Sign up form submitted
        $email = $_POST['email'];
        $confirm_email = $_POST['confirm_email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $organization = $_POST['organization'];
        $department = $_POST['department'];

        // Validation
        if ($email !== $confirm_email) {
            $error_message = "Emails do not match.";
        } elseif ($password !== $confirm_password) {
            $error_message = "Passwords do not match.";
        } else {
            // Proceed with sending verification code
            $verification_code = rand(100000, 999999);

            if (!is_dir('codes')) {
                mkdir('codes');
            }

            file_put_contents("codes/{$email}.txt", $verification_code);

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = $gmail_user;
                $mail->Password = $gmail_password;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom($gmail_user, 'Event Sync Verification');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Your Email Verification Code';
                $mail->Body = "Hello, your verification code is: <b>$verification_code</b>";

                $mail->send();

                $step = 'verify'; // Go to verification step

            } catch (Exception $e) {
                $error_message = "Verification email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    } elseif (isset($_POST['verify_code'])) {
        // Verification form submitted
        $email = $_POST['email'];
        $input_code = $_POST['verify_code'];

        if (file_exists("codes/{$email}.txt")) {
            $saved_code = file_get_contents("codes/{$email}.txt");

            if ($input_code == $saved_code) {
                unlink("codes/{$email}.txt"); // Delete code after success

                // You can also save user details to DB here...

                // Redirect to login page
                header('Location: login.php');
                exit();
            } else {
                $error_message = "Invalid verification code.";
                $step = 'verify';
            }
        } else {
            $error_message = "No verification code found. Please sign up again.";
            $step = 'signup';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Event Sync - Sign Up</title>
  <style>
    /* CSS Styles mo */
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      height: 100vh;
    }
    .left-panel {
      background: linear-gradient(to right, #0b0b3b, #3a3a52);
      color: white;
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 2rem;
    }
    .left-panel img {
      width: 200px;
      margin-bottom: 2rem;
    }
    .left-panel h1 {
      font-weight: bold;
    }
    .left-panel h1 span {
      color: #1e4dd8;
    }
    .signup-form-container {
      background: #ffffff;
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      position: relative;
    }
    .form-box {
      width: 100%;
      max-width: 400px;
    }
    .form-box h2 {
      text-align: center;
      margin-bottom: 20px;
      font-weight: bold;
    }
    form input, form select {
      width: 100%;
      padding: 12px 15px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 16px;
    }
    .terms {
      margin-top: 10px;
      font-size: 14px;
    }
    .terms input {
      margin-right: 5px;
    }
    .terms a {
      color: #1e4dd8;
      text-decoration: none;
    }
    .signup-button {
      width: 100%;
      background-color: #004080;
      color: white;
      padding: 12px;
      font-size: 18px;
      border: none;
      border-radius: 12px;
      margin-top: 20px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .signup-button:hover {
      background-color: #003366;
    }
    .close-button {
      position: absolute;
      top: 20px;
      right: 30px;
      font-size: 30px;
      text-decoration: none;
      color: black;
    }
    .error {
      color: red;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="left-panel">
  <img src="../images/logo.png" alt="University Logo">
  <h1>EVENT <span>SYNC</span></h1>
</div>

<div class="signup-form-container">
  <a href="login.php" class="close-button">&times;</a>
  <div class="form-box">

    <?php if (!empty($error_message)): ?>
      <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <?php if ($step == 'signup'): ?>
      <h2>Sign Up</h2>
      <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="email" name="confirm_email" placeholder="Confirm Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>

        <select name="organization" required>
          <option value="">Select Organization</option>
          <option value="Org1">Organization 1</option>
          <option value="Org2">Organization 2</option>
          <option value="Org3">Organization 3</option>
        </select>

        <select name="department" required>
          <option value="">*Please Select Department*</option>
          <option value="Dept1">Department 1</option>
          <option value="Dept2">Department 2</option>
          <option value="Dept3">Department 3</option>
        </select>

        <div class="terms">
          <input type="checkbox" required> By creating an account, you agree to our <a href="#">Terms</a>.
        </div>

        <button type="submit" name="signup" class="signup-button">SIGN UP</button>
      </form>

    <?php elseif ($step == 'verify'): ?>
      <h2>Email Verification</h2>
      <form method="POST" action="">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <input type="text" name="verify_code" placeholder="Enter Verification Code" required>
        <button type="submit" name="verify_code" class="signup-button">Verify Code</button>
      </form>
    <?php endif; ?>

  </div>
</div>

</body>
</html>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Require PHPMailer autoload (use composer for PHPMailer)
require 'vendor/autoload.php';

// ===============================
// Configuration
// ===============================
// Replace with your Gmail address and the App Password you generated.
$gmail_user = 'dimolmakapal@gmail.com';      // <-- Replace with your Gmail address
$gmail_password = 'yxcp towl ksjd ylcp';     // <-- Replace with your Gmail App Password
$site_url = 'http://localhost/email_verification/email_verify.php'; // <-- Adjust if live
// ===============================

// Simplified PHPMailer Test
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';          // Gmail's SMTP server
    $mail->SMTPAuth = true;                  // Enables SMTP authentication
    $mail->Username = $gmail_user;           // Your Gmail address
    $mail->Password = $gmail_password;       // Your App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Recommended encryption
    $mail->Port = 587;                       // Port for TLS

    // Email content setup
    $mail->setFrom($gmail_user, 'Email Verification');
    $mail->addAddress('recipient@example.com');  // Replace with a valid email for testing

    $mail->Subject = 'Test Email';
    $mail->Body    = 'This is a test email to verify your Gmail SMTP connection.';

    // Try to send the email
    $mail->send();
    echo 'Message has been sent successfully';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

// ===============================
// Rest of your code (Email Verification)
// ===============================

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $verification_code = rand(100000, 999999);  // Generate 6-digit code

    // Create a 'codes' directory to store verification codes
    if (!is_dir('codes')) {
        mkdir('codes');
    }

    // Save the code in a text file (one file per email)
    file_put_contents("codes/{$email}.txt", $verification_code);

    // PHPMailer setup to send email
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Gmail's SMTP server
        $mail->SMTPAuth = true;  // Enables SMTP authentication
        $mail->Username = $gmail_user;  // Your Gmail address
        $mail->Password = $gmail_password;  // Your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Recommended encryption
        $mail->Port = 587;  // Port for TLS

        // Email content setup
        $mail->setFrom($gmail_user, 'Email Verification');
        $mail->addAddress($email);  // Send the verification code to this email address
        $mail->isHTML(true);
        $mail->Subject = 'Your Email Verification Code';
        $mail->Body    = "Hello, your verification code is: <b>$verification_code</b>";

        // Try to send the email
        $mail->send();
        echo "<h3>Verification code sent to <b>$email</b>!</h3>";
        echo "<p>Please check your email for the code.</p>";

        // Form to enter verification code
        echo "<form method='POST' action=''>
                <label for='code'>Enter Verification Code:</label>
                <input type='text' name='code' required>
                <input type='hidden' name='email' value='$email'>
                <button type='submit'>Verify Code</button>
              </form>";
        exit;

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Verify Code: When user enters the code to verify
if (isset($_POST['code'])) {
    $email = $_POST['email'];
    $input_code = $_POST['code'];

    // Check if the verification code file exists for the email
    if (file_exists("codes/{$email}.txt")) {
        $saved_code = file_get_contents("codes/{$email}.txt");

        if ($input_code == $saved_code) {
            echo "<h2>Email <b>$email</b> has been successfully verified!</h2>";
            unlink("codes/{$email}.txt");  // Delete code file after successful verification
        } else {
            echo "<h2>Invalid verification code. Please try again.</h2>";
        }
    } else {
        echo "<h2>No verification code found for this email. Please request a new code.</h2>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <h2>Enter Your Email to Receive a Verification Code</h2>
    <form method="POST" action="">
        Email: <input type="email" name="email" required>
        <button type="submit">Send Verification Code</button>
    </form>
</body>
</html>

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - Event Admin Portal</title>
    <link rel="stylesheet" href="style/adminstyle.css"> <!-- Link to your CSS -->
</head>
<body>
    <header class="navbar">
        <div class="logo">EVENT <span style="color: black;">ADMIN</span> PORTAL</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="contactus.php" class="active">Contact Us</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <?php if (isset($_SESSION['client_logged_in'])): ?>
                    <li><i class="fa fa-calendar"></i></li>
                    <li><i class="fa fa-bell"></i></li>
                    <li><i class="fa fa-user"></i> <?php echo htmlspecialchars($_SESSION['client_email']); ?></li>
                <?php else: ?>
                    <li><a href="account/login.php">Sign In</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <section class="contact-section">
        <h1 class="section-title">CONTACT US</h1>
        <div class="contact-cards">
            <div class="contact-card">
                <img src="images/phone-icon.png" alt="Phone Icon" style="width: 100px;">
                <h2>Call us directly at</h2>
                <p style="font-size: 24px; font-weight: bold; color: #003399;">+0912345678</p>
            </div>
            <div class="contact-card">
                <img src="images/chat-icon.png" alt="Chat Icon" style="width: 100px;">
                <h2>Chat with our team</h2>
                <a href="#" class="chat-button">CHAT WITH TEAM</a>
            </div>
        </div>

        <div class="help-section">
            <h2>How can we help?</h2>
            <p>Our service team is available 7 days a week:<br>
                Monday - Sunday | 8:00 AM to 5:00 PM</p>
            <p>
                <a href="tel:0987654321">0987654321</a> / 
                <a href="tel:09123456789">09123456789</a> | 
                <a href="mailto:ask@eventplaner.ph">ask@eventplaner.ph</a>
            </p>
        </div>
    </section>

</body>
</html>

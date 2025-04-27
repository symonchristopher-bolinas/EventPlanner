<?php
session_start();

if (isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_dashboard.php');
    exit();
}

if (isset($_SESSION['client_logged_in'])) {
    header('Location: client_dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Event Sync - Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="../style/account.css">
</head>

<body>

  <div class="left-section">
    <img src="your_logo_path.png" alt="University Logo">
    <h1>EVENT <span style="color:#0d6efd;">SYNC</span></h1>
  </div>

  <div class="right-section">
    <a href="../index.php" class="close-button">&times;</a>
    <div class="form-box">
      <h2>SIGN IN</h2>
      <?php if (isset($_GET['error'])): ?>
        <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
      <?php endif; ?>
      <form method="POST" action="process_login.php">
        <input type="text" name="username" placeholder="Email" required>

        <div class="password-wrapper">
          <input type="password" name="password" id="password" placeholder="Password" required>
          <i class="fa-solid fa-eye toggle-password" id="togglePassword" onclick="togglePassword()"></i>
        </div>

        <div class="links">
          <a href="#">forgot password</a>
          <a href="javascript:void(0);" id="signUpBtn">don't have an account</a>
        </div>

        <button type="submit">SIGN IN</button>
      </form>
    </div>
  </div>

  <!-- Modal Sign Up -->
  <div id="signUpModal" class="modal">
    <div class="modal-content">
      <span class="close" id="closeModal">&times;</span>
      <h2>Sign Up</h2>

      <form method="POST" action="process_signup.php">
        <input type="email" name="email" placeholder="Email" required>
        <input type="email" name="confirm_email" placeholder="Confirm Email" required>

        <div class="password-wrapper">
          <input type="password" name="password" id="signup_password" placeholder="Password" required>
          <span class="toggle-password" onclick="toggleSignupPassword()">👁️</span>
        </div>

        <div class="password-wrapper">
          <input type="password" name="confirm_password" id="signup_confirm_password" placeholder="Confirm Password" required>
          <span class="toggle-password" onclick="toggleSignupConfirmPassword()">👁️</span>
        </div>

        <select name="organization" required>
          <option value="">Select Organization</option>
          <option value="Org1">Organization 1</option>
          <option value="Org2">Organization 2</option>
          <option value="Org3">Organization 3</option>
        </select>

        <select name="department" required>
          <option value="">Select Department</option>
          <option value="Dept1">Department 1</option>
          <option value="Dept2">Department 2</option>
          <option value="Dept3">Department 3</option>
        </select>

        <button type="submit">Sign Up</button>
      </form>
    </div>
  </div>

  <script>
    // Toggle Login Password
    function togglePassword() {
      var passwordInput = document.getElementById("password");
      var toggleIcon = document.getElementById("togglePassword");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
      }
    }


    // Toggle Sign Up Passwords
    function toggleSignupPassword() {
      var passwordInput = document.getElementById("signup_password");
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
      } else {
        passwordInput.type = "password";
      }
    }

    function toggleSignupConfirmPassword() {
      var passwordInput = document.getElementById("signup_confirm_password");
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
      } else {
        passwordInput.type = "password";
      }
    }

    // Modal Open/Close
    var modal = document.getElementById("signUpModal");
    var btn = document.getElementById("signUpBtn");
    var closeBtn = document.getElementById("closeModal");

    btn.onclick = function() {
      modal.style.display = "block";
    }

    closeBtn.onclick = function() {
      modal.style.display = "none";
    }

    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>

</body>
</html>

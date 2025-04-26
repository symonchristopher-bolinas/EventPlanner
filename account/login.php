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
  <title>Login</title>
  <style>
    body { display: flex; justify-content: center; align-items: center; height: 100vh; background: #f0f0f0; margin: 0; }
    .login-box { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0px 0px 10px #ccc; width: 300px; text-align: center; }
    input { width: 100%; padding: 0.5rem; margin: 0.5rem 0; }
    button { width: 100%; padding: 0.5rem; margin-top: 0.5rem; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
    .modal { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.4); padding-top: 60px; }
    .modal-content { background-color: #fff; padding: 20px; border: 1px solid #888; width: 50%; margin: auto; }
    .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; }
    .close:hover, .close:focus { color: black; text-decoration: none; cursor: pointer; }
    select { width: 100%; padding: 0.5rem; margin: 0.5rem 0; }
    .error { color: red; font-size: 14px; }
  </style>
</head>
<body>

  <div class="login-box">
    <h2>Login</h2>
    <?php if (isset($_GET['error'])): ?>
      <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <form method="POST" action="process_login.php">
      <input type="text" name="username" placeholder="Username or Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>


    <p>Not registered? <a href="javascript:void(0);" id="signUpBtn">Sign Up</a></p>
  </div>

  <!-- The Sign Up Modal -->
  <div id="signUpModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Sign Up</h2>
      
      <!-- Display errors here -->
      <?php if (isset($_GET['error'])): ?>
        <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
      <?php endif; ?>
      
      <form method="POST" action="process_signup.php">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="email" name="confirm_email" placeholder="Confirm Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
        
        <!-- Dropdown for Organization -->
        <select name="organization" required>
          <option value="">Select Organization</option>
          <option value="Org1">Organization 1</option>
          <option value="Org2">Organization 2</option>
          <option value="Org3">Organization 3</option>
        </select><br>
        
        <!-- Dropdown for Department -->
        <select name="department" required>
          <option value="">Select Department</option>
          <option value="Dept1">Department 1</option>
          <option value="Dept2">Department 2</option>
          <option value="Dept3">Department 3</option>
        </select><br>
        
        <button type="submit">Sign Up</button>
      </form>
    </div>
  </div>

  <script>
    // Get the modal
    var modal = document.getElementById("signUpModal");

    // Get the button that opens the modal
    var btn = document.getElementById("signUpBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
      modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>

</body>
</html>

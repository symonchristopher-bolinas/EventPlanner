<?php
session_start();
require_once(//"dbname");

$message = "sample message";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST ["USERNAME"];
  $password = $_POST ["PASSWORD"];

  $sql = "SELECT * FROM //table_name WHERE username='$username' AND password ='$password'";
  $result =  $conn->query($sql);

if ($result -> num_rows == 1){
  $_SESSION["admin"] = $username;
  $message = "Login Successful!";

}else{
  $message = "Invalid username or password";

  }
}
?>


//html
<!DOCTYPE html>
<html>
  <head>
      <title>Admin Login</title>
      <link rel="stylesheet" href="adminstyle.css">
  </head>

  <body>
    <div class= login-container>
      <h2>Admin Login</h2>
      <form method ="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type ="submit">Login</button>
      </form>  

<?php
  if($message):
 ?>      
     <div class="message">
        <?php echo $message; ?>
     </div> 
    <?php endif; ?>
    </div>
  </body>
  
</html>


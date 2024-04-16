<?php
include "connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="./css/login.css" />
</head>

<body>
  <div class="login-container">
    <div class="login-box">
      <h1>Login</h1>
      <form action="index.php" method="POST">
        <div class="input-group">
          <label for="email"><i class="fas fa-user"></i> Email </label>
          <input type="text" id="username" name="email" required />
        </div>
        <div class="input-group">
          <label for="password"><i class="fas fa-lock"></i> Password</label>
          <input type="password" id="password" name="password" required />
        </div>
        <button type="submit" name="ok">
          <i class="fas fa-sign-in-alt"></i>Login
        </button>
        <p>Don't have an account? <a href="signup.php">SignUp</a></p>
      </form>
    </div>
    <?php
    if (isset($_POST['ok'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $sel = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");
      if (mysqli_num_rows($sel) == 0) {
        echo "<h3 style='color: red'>Invalid Email or Password</h3>";
      } else {
        $data = mysqli_fetch_array($sel);
        if (password_verify($password, $data['password'])) {
          session_start();
          $_SESSION['user_id'] = $data['User_Id'];
          $_SESSION['type'] = $data['type'];
          switch ($data['type']) {
            case 'director':
              header('location: directorDash.php');
              break;
            case 'trainer':
              header('location: trainer.php');
              break;
            case 'student':
              header('location: students.php');
              break;
            default:
              echo "<h3 style='color: red'>Invalid User Type</h3>";
              break;
          }
        } else {
          echo "<h3 style='color: red'>Incorrect email or password</h3>";
        }
      }
    }

    ?>
  </div>
</body>

</html>
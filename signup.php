<?php
include "connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up</title>
  <link rel="stylesheet" href="./css/signup-styles.css" />
  <style>
    select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      margin-bottom: 10px;
    }

    .hidden {
      display: none;
    }
  </style>
</head>

<body>
  <div class="signup-container">
    <h1>Create an Account</h1>
    <form action="signup.php" method="POST">
      <div class="form-group">
        <select id="userType" name="type" onchange="toggleAdditionalFields()">
          <option value="">Select User Type</option>
          <option value="student">Student</option>
          <option value="trainer">Trainer</option>
          <option value="director">Director</option>
        </select>
      </div>
      <div class="form-group" id="regNumberGroup">
        <label for="reg_number">Reg Number</label>
        <input type="text" id="reg_number" name="reg_number" />
      </div>
      <div class="form-group" id="phoneNumberGroup" class="hidden">
        <label for="phone_number">Phone Number</label>
        <input type="text" id="phone_number" name="phone_number" pattern="^(078|072|073|079)\d{7}$" />
      </div>
      <div class="form-group" id="emailGroup" class="hidden">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />
      </div>
      <div class="form-group">
        <label for="confirmPassword">Confirm Password</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required />
      </div>
      <button type="submit" name="regist">Sign Up</button>
    </form>
    <p>Already have an account? <a href="index.php">Log In</a></p>

    <?php
    if (isset($_POST['regist'])) {
      $number = mysqli_real_escape_string($con, $_POST['phone_number']);
      $reg_nummber = mysqli_real_escape_string($con, $_POST['reg_number']);
      $email = mysqli_real_escape_string($con, $_POST['email']);
      $reg_nummber = mysqli_real_escape_string($con, $_POST['reg_number']);
      $type =  mysqli_real_escape_string($con, $_POST['type']);
      $password = mysqli_real_escape_string($con, $_POST['password']);
      $confirmPassword = mysqli_real_escape_string($con, $_POST['confirmPassword']);
      $phone_number = '+25' . $number;
      echo $phone_number;
      $hashed = password_hash($password, PASSWORD_DEFAULT);
      $sel = mysqli_query($con, "SELECT * FrOM users where Email = '$email'");

      if (mysqli_num_rows($sel) > 0) {
        echo "<h3 style ='color: red'>Email Is already Registered</h3>";
        return false;
      }
      if ($type == 'director') {
        $sql = "INSERT INTO users (email,password,type)VALUES('$email','$hashed','$type')";
        $result = mysqli_query($con, $sql);
        if ($result) {
          echo "<script>
              alert('Account Created successfully');
              window.location.href = 'index.php';
            </script>";
        } else {
          echo "Error: " . $sql . "<br>" . $con->error;
        }
      }

      if ($type == 'trainer') {
        $sql = "INSERT INTO users (email,phone,password,type)VALUES('$email','$phone_number','$hashed','$type')";
        $result = mysqli_query($con, $sql);
        if ($result) {
          echo "<script>
              alert('Account Created successfully');
              window.location.href = 'index.php';
            </script>";
        } else {
          echo "Error: " . $sql . "<br>" . $con->error;
        }
      }
      if ($type == 'student') {
        $sql = "INSERT INTO users (email,reg_Number,password,type)VALUES('$email','$reg_nummber','$hashed','$type')";
        $result = mysqli_query($con, $sql);
        if ($result) {
          echo "<script>
              alert('Account Created successfully');
              window.location.href = 'index.php';
            </script>";
        } else {
          echo "Error: " . $sql . "<br>" . $con->error;
        }
      }
    }
    ?>
  </div>
  <script>
    function toggleAdditionalFields() {
      var userType = document.getElementById("userType").value;
      var regNumberGroup = document.getElementById("regNumberGroup");
      var phoneNumberGroup = document.getElementById("phoneNumberGroup");
      // var emailGroup = document.getElementById("emailGroup");

      if (userType === "student") {
        regNumberGroup.classList.remove("hidden");
        phoneNumberGroup.classList.add("hidden");
        // emailGroup.classList.add("hidden");
      } else if (userType === "trainer" || userType === "Director") {
        phoneNumberGroup.classList.remove("hidden");
        regNumberGroup.classList.add("hidden");
        // emailGroup.classList.add("hidden");
      } else {
        // Reset form to default state if no valid user type is selected
        regNumberGroup.classList.add("hidden");
        phoneNumberGroup.classList.add("hidden");
        // emailGroup.classList.add("hidden");
      }
    }
  </script>
</body>

</html>
<?php
include 'session.php';
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Change Password</title>
  <link rel="stylesheet" href="./css/password-change-styles.css" />
</head>

<body>
  <div class="password-change-container">
    <h1>Change Your Password</h1>
    <form action="studentSettings.php" method="POST">
      <div class="form-group">
        <label for="currentPassword">Current Password</label>
        <input type="password" id="currentPassword" name="currentPassword" required />
      </div>
      <div class="form-group">
        <label for="newPassword">New Password</label>
        <input type="password" id="newPassword" name="newPassword" required />
      </div>
      <div class="form-group">
        <label for="confirmNewPassword">Confirm New Password</label>
        <input type="password" id="confirmNewPassword" name="confirmNewPassword" required />
      </div>
      <button type="submit" name="ok">Change Password</button>
    </form>
    <?php
    if (isset($_POST['ok'])) {
      // Get form data
      $currentPassword = $_POST['currentPassword'];
      $newPassword = $_POST['newPassword'];
      $confirmPassword = $_POST['confirmNewPassword'];

      // Get user ID from session
      $userId = $_SESSION['user_id'];

      // Validate current password
      $sql = "SELECT Password FROM users WHERE User_Id =?";
      $stmt = $con->prepare($sql);
      $stmt->bind_param('i', $userId);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['Password'];
        if (password_verify($currentPassword, $hashedPassword)) {
          // Current password is correct, proceed to update password
          if ($newPassword === $confirmPassword) {
            // Hash the new password
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            // Update user's password in the database
            $updateSql = "UPDATE users SET Password = ? WHERE User_Id = ?";
            $updateStmt = $con->prepare($updateSql);
            $updateStmt->bind_param('si', $hashedNewPassword, $userId);
            if ($updateStmt->execute()) {
              // Password updated successfully
              echo '<script>alert("Password Changed successfully.");
                    window.location.href = "students.php";
              </script>';
            } else {
              echo '<p class = "cp">Failed to update password. Please try again later.</p>';
            }
          } else {
            echo '<p class = "cp">Password mismatch.</p>';
          }
        } else {
          echo '<p class = "cp">Password is incorrect. Please try again.</p>';
        }
      } else {
        echo '<p class = "cp">User not found.</p>';
      }
    }
    ?>
  </div>
</body>

</html>
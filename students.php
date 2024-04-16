<?php
include 'studentSession.php';
include 'connection.php';
$Id = $_SESSION['user_id'];
$sel = mysqli_query($con, "SELECT * FROM users WHERE User_Id = '$Id'");
$row = mysqli_fetch_array($sel);
$regNumber = $row['reg_Number'];
$modi = mysqli_query($con, "SELECT DISTINCT module_name FROM attendence WHERE reg_Number = '$regNumber'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Check Attendance</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="./css/check.css" />
  <!-- <link rel="stylesheet" href="./css/form-styles.css" /> -->
  <!-- <link rel="stylesheet" href="./css/attendance.css" /> -->
  <style>
    .form-group input[type='text'] {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border-radius: 4px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    .attendance-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .attendance-table th,
    .attendance-table td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    .attendance-table th {
      background-color: #f5f5f5;
    }
  </style>
</head>

<body>
  <div class="dashboard-container">
    <div class="dashboard">
      <h1>Student</h1>
      <ul>
        <li>
          <a href="studentSettings.php"><i class="fas fa-key"></i> Change Password</a>
        </li>
        <li>
          <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
      </ul>
    </div>
    <div class="content">

      <h2>Check Attendance</h2>
      <form action="students.php" method="POST">
        <label for="moduleSelect">Select Module:</label>
        <select id="moduleSelect" name="module">
          <option>Choose The Module</option>
          <?php
          while ($data = mysqli_fetch_array($modi)) {
          ?>
            <option value="<?php echo $data['module_name']; ?>"><?php echo $data['module_name']; ?></option>
          <?php
          }
          ?>
        </select><br>
        <button type="submit" name="ok">
          <i class="fas fa-search"></i> Check Your Attendance Marks
        </button>
      </form>
      <?php
      if (isset($_POST['ok'])) {
        $module = $_POST['module'];
        $fetch = mysqli_query($con, "SELECT reg_Number, Names, module_name,marks from attendence where reg_Number ='$regNumber' and module_name ='$module' ");
        if (mysqli_num_rows($fetch) == 0) {
          echo "<h3>Your are not on Attendence List</h3>";
        } else {
      ?>
          <table class="attendance-table">
            <thead>
              <tr>
                <th>Student Name</th>
                <th>Reg Number</th>
                <th>Module</th>
                <th>Attendance (%)</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($row = mysqli_fetch_array($fetch)) {
              ?>
                <tr>
                  <td><?php echo $row['Names']; ?></td>
                  <td><?php echo $row['reg_Number']; ?></td>
                  <td><?php echo $row['module_name']; ?></td>
                  <td><?php echo $row['marks'] . "%"; ?></td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>

      <?php
        }
      }

      ?>


      <tr>
        </table>
        <!-- </div> -->
    </div>
  </div>

  <script src="check-attendance.js"></script>
</body>

</html>
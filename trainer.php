<?php
include 'trainerSession.php';
include 'connection.php';
$Id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Check Attendance</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="./css/form-styles.css" />
  <link rel="stylesheet" href="./css/check.css" />
  <style>
    .form-group input[type='text'] {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border-radius: 4px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }
  </style>
</head>

<body>
  <div class="dashboard-container">
    <div class="dashboard">
      <h1>Trainer</h1>
      <ul>
        <li>
          <a href="trainerSettings.php"><i class="fas fa-key"></i> Change Password</a>
        </li>
        <li>
          <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
      </ul>
    </div>
    <div class="content">
      <h2>upload Attendance</h2>
      <form action="trainer.php" method="post" enctype="multipart/form-data">
        <!-- <div class="form-group">
          <label for="moduleCode">Module Name:</label>
          <input type="text" name="module">
        </div> -->
        <div class="form-group">
          <label for="attendanceFile">Attendance File:</label>
          <input type="file" id="attendanceFile" name="File" accept=".csv, .xls, .xlsx" required />
        </div>
        <button type="submit" name="ok">
          <i class="fas fa-cloud-upload-alt"></i> Upload
        </button>
      </form>
    </div>
  </div>
  <?php
  include "connection.php";

  if (isset($_POST['ok'])) {
    $sel = mysqli_query($con, "SELECT phone from users where User_Id = '$Id'");
    $data = mysqli_fetch_array($sel);
    $phone = $data['phone'];
    // $module = $_POST["module"];
    if ($_FILES["File"]["type"] == "text/csv") {
      $file_name = $_FILES["File"]["name"];
      $file_tmp = $_FILES["File"]["tmp_name"];
      $file_size = $_FILES["File"]["size"];
      $file_tmp = $_FILES["File"]["tmp_name"];
      $file_size = $_FILES["File"]["size"];
      if ($file_size > 0) {
        // Move the uploaded file to a directory on the server
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($file_name);
        move_uploaded_file($file_tmp, $target_file);

        // Open the uploaded CSV file for reading
        $file = fopen($target_file, "r");
        $row_count = 0;
        // Read and insert data from CSV file into database
        while (($column = fgetcsv($file, 10000, ",")) !== false) {
          $reg_Number = mysqli_real_escape_string($con, $column[0]);
          $Names = mysqli_real_escape_string($con, $column[1]);
          $module_name = mysqli_real_escape_string($con, $column[2]);
          $total_hours = mysqli_real_escape_string($con, $column[3]);
          $status = mysqli_real_escape_string($con, $column[4]);
          $sql = "INSERT INTO attendence (reg_Number, Names, module_name, total_hours, marks,trainerNumber) 
                          VALUES ('$reg_Number', '$Names', '$module_name', '$total_hours', '$status','$phone')";

          $result = mysqli_query($con, $sql);

          if ($result) {
            $checker = 1;
          } else {
            $checker = 0;
          }
        }
        if ($result) {
          echo
          "
			<script>
			alert('Succesfully Uploaded');
			document.location.href = '';
			</script>
			";
        }
      }
    } elseif ($_FILES["File"]["type"] == "application/vnd.ms-excel" || $_FILES["File"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
      $fileName = $_FILES["File"]["name"];
      $fileExtension = explode('.', $fileName);
      $fileExtension = strtolower(end($fileExtension));
      $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

      $targetDirectory = "uploads/" . $newFileName;
      move_uploaded_file($_FILES['File']['tmp_name'], $targetDirectory);

      error_reporting(0);
      ini_set('display_errors', 0);

      require 'ExcelReader/excel_reader2.php';
      require 'ExcelReader/SpreadsheetReader.php';

      $reader = new SpreadsheetReader($targetDirectory);
      foreach ($reader as $key => $row) {
        $reg_Number = $row[0];
        $Name = $row[1];
        $module_Name = $row[2];
        $total_hours = $row[3];
        $marks = $row[4];
        mysqli_query($con, "INSERT INTO attendence (reg_Number, Names, module_name,trainerNumber,total_hours, marks)
			VALUES('$reg_Number','$Name', '$module_Name','$phone','$total_hours','$marks')");
      }
      echo
      "
			<script>
			alert('Succesfully Uploaded');
			document.location.href = '';
			</script>
			";
    } else {
      echo
      "
			<script>
			alert('File Not Supported');
			document.location.href = '';
			</script>
			";
    }
  }
  ?>
</body>

</html>
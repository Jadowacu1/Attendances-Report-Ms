<?php
include 'directorSession.php';
include 'connection.php';
$Id = $_SESSION['user_id'];
$sel = mysqli_query($con, "SELECT DISTINCT module_name FROM attendence");

// $phone = $fone['trainerNumber'];

// echo $phone;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Check Attendance</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="./css/check.css" />
  <style>
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
      <h1>Director</h1>
      <ul>
        <li>
          <a href="directorSettings.php"><i class="fas fa-key"></i> Change Password</a>
        </li>
        <li>
          <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
      </ul>
    </div>
    <div class="content">
      <h2>View Attendance</h2>
      <form id="attendanceForm" action="directorDash.php" method="POST">
        <label for="moduleSelect">Select Module:</label>
        <select id="moduleSelect" name="moduleSelect">
          <option>Choose The Module</option>
          <?php
          while ($data = mysqli_fetch_array($sel)) {
          ?>
            <option value="<?php echo $data['module_name']; ?>"><?php echo $data['module_name']; ?></option>
          <?php
          }
          ?>
        </select>
        <button type="submit" name="ok">
          <i class="fas fa-search"></i> View Attendance
        </button>
        <!-- <div class="confirm-section"> -->
        <button class="confirm-button" name='confirm'>Confirm Attendance</button>

      </form>
      <?php
      if (isset($_POST['ok'])) {
        $module = $_POST['moduleSelect'];
        $_SESSION['mod'] = $module;
        // echo $phone;
        $selectMod = mysqli_query($con, "SELECT * FROM attendence WHERE module_name = '$module'");
        $row = mysqli_fetch_row($selectMod);
        // $phone = $row['trainerNumber'];
        if (mysqli_num_rows($selectMod) < 0) {
        } else {
      ?>

          <table class="attendance-table">
            <thead>
              <tr>
                <th>Student Name</th>
                <th>Reg Number</th>
                <th>Module</th>
                <th>Credits</th>
                <th>Attendance (%)</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($row = mysqli_fetch_array($selectMod)) {
              ?>
                <tr>
                  <td><?php echo $row['Names']; ?></td>
                  <td><?php echo $row['reg_Number']; ?></td>
                  <td><?php echo $row['module_name']; ?></td>
                  <td><?php echo $row['total_hours']; ?></td>
                  <td><?php echo $row['marks'] . "%"; ?></td>
                </tr>
                <?php
                ?>

          <?php
              }
            }
          }

          ?>


    </div>
    <?php
    if (isset($_POST['confirm'])) {
      $mod = $_SESSION['mod'];
      $selPhone = mysqli_query($con, "SELECT DISTINCT  trainerNumber FROM attendence where module_name = '$mod'");
      $fone = mysqli_fetch_array($selPhone);
      $phoneNumber = $fone['trainerNumber'];
      // Replace these credentials with your ClickSend API username and API key
      $username = 'jadomyvalue@gmail.com';
      $apiKey = '089DDFF0-FF1F-933E-E1F6-41B2E439AA6C';

      // ClickSend API endpoint for sending SMS
      $endpoint = 'https://rest.clicksend.com/v3/sms/send';

      // Recipient's phone number (in international format, e.g., '+1234567890')
      $to = $phoneNumber;

      // Message content
      $message = 'The Attendence for ' . $mod . ' is confirmed By Director of quality assurance';

      // Prepare request parameters
      $params = [
        'messages' => [
          [
            'to' => $to,
            'body' => $message
          ]
        ]
      ];

      // Initialize cURL session
      $curl = curl_init($endpoint);

      // Set cURL options for POST request
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
      curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode("$username:$apiKey")
      ]);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

      // Execute cURL session
      $response = curl_exec($curl);

      // Check for cURL errors
      if (curl_errno($curl)) {
        echo 'Error: ' . curl_error($curl);
      } else {
        // Decode JSON response
        $responseData = json_decode($response, true);

        // Check response status
        if (isset($responseData['data']['success']) && $responseData['data']['success']) {
          echo "SMS message sent successfully.";
        } else {
          echo "confirmed";
        }
      }

      // Close cURL session
      curl_close($curl);
    }
    ?>
  </div>

  <script src="check-attendance.js"></script>
</body>

</html>
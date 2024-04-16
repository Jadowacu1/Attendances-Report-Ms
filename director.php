<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Attendance</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link rel="stylesheet" href="./css/attendance.css" />
  </head>
  <body>
    <div class="dashboard-container">
      <div class="dashboard">
        <h1>View Attendance</h1>
        <table class="attendance-table">
          <thead>
            <tr>
              <th>Student Name</th>
              <th>Module</th>
              <th>Attendance (%)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>John Doe</td>
              <td>Mathematics</td>
              <td>85%</td>
            </tr>
            <tr>
              <td>Jane Smith</td>
              <td>Physics</td>
              <td>92%</td>
            </tr>
            <!-- Add more rows for other students and modules -->
          </tbody>
        </table>
        <div class="confirm-section">
          <button class="confirm-button">Confirm Attendance</button>
        </div>
      </div>
    </div>
  </body>
</html>

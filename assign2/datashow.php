<!DOCTYPE html>
<html lang="en" data-theme="<?php echo isset($_GET['theme']) ? $_GET['theme'] : "white"; ?>">

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="Assignment 2" />
  <meta name="keywords" content="Advance Web Development" />
  <meta name="author" content="Tri Trung Ton">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
  <link rel="stylesheet" href="style.css">
  <title>Assignment 2</title>
</head>

<body class="container">
  <div class="hero">
    <nav class="container-fluid">
      <ul>
        <li><strong>My Friend</strong></li>
      </ul>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="signup.php">Sign Up</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="datashow.php">Data Show</a></li>
      </ul>
    </nav>
  </div>
  <h1>Friend System</h1>
  <?php
  // SQL queries to select data from friends and myfriends tables
  require_once("settings.php");
  $conn = mysqli_connect($host, $user, $pswd, $dbnm) or die("Failed to connect to server: " . mysqli_connect_error());
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql_friends = "SELECT * FROM friends";
  $sql_myfriends = "SELECT * FROM myfriends";

  $result_friends = $conn->query($sql_friends);
  $result_myfriends = $conn->query($sql_myfriends);
  ?>
  <div class="content">
    <div class="box2">
      <?php
      // Display data from the friends table
      echo "<h2>friends Table</h2>";
      if (!$result_friends) {
        echo "<font color = red><p>Cannot find table friends</font></p>";
      } else {
        if ($result_friends->num_rows > 0) {
          echo "<table border='1'><tr><th>ID</th><th>Profile Name</th><th>Email</th><th>Password</th></tr>";
          while ($row = $result_friends->fetch_assoc()) {
            echo "<tr><td>" . $row["friend_id"] . "</td><td>" . $row["profile_name"] . "</td><td>" . $row["friend_email"] . "</td><td>" . $row["password"] . "</td></tr>";
          }
          echo "</table>";
          echo "<font color = red><p>Reminder: This Data Show page created for testing purposes</font></p>";
        } else {
          echo "<font color = red><p>No records found in the Friends table.</font></p>";
        }
      }
      ?>
      <?php
      // Display data from the myfriends table
      echo "<h2>myfriends Table</h2>";
      if (!$result_friends) {
        echo "<font color = red><p>Cannot find table myfriends</font></p>";
      } else {
        if ($result_myfriends->num_rows > 0) {
          echo "<table border='1'><tr><th>friend_id1</th><th>friend_id2</th></tr>";
          while ($row = $result_myfriends->fetch_assoc()) {
            echo "<tr><td>" . $row["friend_id1"] . "</td><td>" . $row["friend_id2"] . "</td></tr>";
          }
          echo "</table>";
          echo "<font color = red><p>Reminder: This Data Show page created for testing purposes</font></p>";
        } else {
          echo "<font color = red><p>No records found in the MyFriends table.</font></p>";
        }
      }
      $conn->close(); // Close the database connection
      ?>
    </div>
  </div>
</body>

</html>
<!-- Assignment 2
Name: Tri Trung Ton
Student ID: 103808977 -->
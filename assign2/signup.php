<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo isset($_GET['theme']) ? $_GET['theme'] : "white"; ?>">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Assignment 2" />
    <meta name="keywords" content="Advance Web Development" />
    <meta name="author" content="Tri Trung Ton">
    <title>Assign2 - Sign Up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="container">
    <?php session_start(); ?>
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
    <div class="content">
        <div class="banner">
            <h1>My Friend System</h1>
            <h2>Registration Page</h2>
        </div>
        <form class="content" action="signup.php" method="post">
            <div id="text">
                <!-- Position -->
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>"><br>

                <!-- title  -->
                <label for=" profile_name">Profile Name:</label>
                <input type="text" id="profile_name" name="profile_name" value="<?php echo isset($_POST["profile_name"]) ? $_POST["profile_name"] : ''; ?>"><br>

                <!-- description -->
                <label for=" password">Password:</label>
                <input type="text" id="password" name="password"><br>

                <!-- Closing Date -->
                <label for="confirm_password">Confirm Password:</label>
                <input type="text" id="confirm_password" name="confirm_password"><br>
            </div>

            <!-- submit, reset  -->
            <input type="submit" name="register" value="Register">
            <input type="reset" value="Clear">

            <!-- link to return to homepage (index.html) -->
            <p>All fields are required. <a href="index.php">Return to Home Page</a></p>
        </form>
    </div>
    <?php
    require_once("settings.php");
    $conn = mysqli_connect($host, $user, $pswd, $dbnm) or die("Failed to connect to server: " . mysqli_connect_error());
    if (isset($_POST["register"])) {
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        // Validate and sanitize user inputs
        $valid = true;
        if (empty($_POST["email"])) {
            echo "<div class ='content'><font color='red'>Email is required!</font></div>";
            $valid = false;
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<div class ='content'><font color='red'>$email is not a valid email address!</font></div>";
                $valid = false;
            }
            // Check if email already exists
            $query = "SELECT * FROM friends WHERE friend_email = '$email'";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                echo "<div class ='content'><font color='red'>Email already registered!</font></div>";
                $valid = false;
            }
        }
        // Profile Name
        if (empty($_POST["profile_name"])) {
            echo "<div class ='content'><font color='red'>Profile Name is required!</font></div>";
            $valid = false;
        } else {
            $profile_name = test_input($_POST["profile_name"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/", $profile_name)) {
                echo "<div class ='content'><font color='red'>Only letters and white space allowed for Profile Name!</font></div>";
                $valid = false;
            }
        }
        // Password
        if (empty($_POST["password"])) {
            echo "<div class ='content'><font color='red'>Password is required!</font></div>";
            $valid = false;
        } else {
            $password = test_input($_POST["password"]);
            if (!preg_match('/^[a-zA-Z0-9]+$/', $password)) {
                echo "<div class ='content'><font color='red'>Only letters and numbers allowed for Password!</font></div>";
                $valid = false;
            }
        }
        // Confirm Password
        if (empty($_POST["confirm_password"])) {
            echo "<div class ='content'><font color='red'>Please confirm your password!</font></div>";
            $valid = false;
        } else {
            $confirm_password = test_input($_POST["confirm_password"]);
            if (!preg_match('/^[a-zA-Z0-9]+$/', $confirm_password)) {
                echo "<div class ='content'><font color='red'>Only letters and numbers allowed for Confirm Password!</font></div>";
                $valid = false;
            } else if ($password !== $confirm_password) {
                echo "<div class ='content'><font color='red'>Password does not match!</font></div>";
                $valid = false;
            }
        }
        if ($valid) { // If inputs are valid, query the database for signup.
            $date = date('Y-m-d'); //set as current date 
            $query = "INSERT INTO friends(friend_email, `password`, profile_name, date_started, num_of_friends) VALUES ('$email', '$password','$profile_name','$date',0)"; //insert query
            if ($conn->query($query) === TRUE) { //check if query execute successfully
                $_SESSION['logged_in'] = 1; //assign if user login successfully
                echo "<div class ='content'><font color='green'>Register Successfully</font></div>";
                $query = "SELECT friend_id FROM friends WHERE friend_email = '$email'";
                $result = mysqli_query($conn, $query);
                if ($result && mysqli_num_rows($result) > 0) {
                    $fid = $result->fetch_assoc();
                    $_SESSION['user'] = $fid["friend_id"];
                    $_SESSION['name'] = $profile_name;
                    $_SESSION['friends'] = 0;
                } else {
                    echo "Failed to fetch user ID.";
                }
            } else {
                echo "Error adding: " . $query . "<br>" . $conn->error;
            }
        }
    }
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>

</html>


<!-- Assignment 2
Name: Tri Trung Ton
Student ID: 103808977 -->
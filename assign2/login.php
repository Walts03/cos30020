<?php ob_start(); ?> <!-- Start output buffering. This is used to capture output before sending it to the browser. -->
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo isset($_GET['theme']) ? $_GET['theme'] : "white"; ?>">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Assignment 2" />
    <meta name="keywords" content="Advance Web Development" />
    <meta name="author" content="Tri Trung Ton">
    <title>Assign2 - Log In</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="container">
    <?php session_start(); ?>
    <!-- Start a PHP session for storing session variables. -->
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
            <h2>Log In Page</h2>
        </div>
        <form class="content" action="login.php" method="post">
            <!-- Create a login form with email and password fields. -->
            <div id="text">
                <!-- Position -->
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>"><br>

                <!-- description -->
                <label for=" password">Password:</label>
                <input type="text" id="password" name="password" value="<?php echo isset($_POST["password"]) ? $_POST["password"] : ''; ?>"><br>

            </div>

            <!-- submit, reset  -->
            <input type="submit" name="login" value="Log In">

            <!-- link to return to homepage (index.html) -->
            <p>All fields are required. <a href="index.php">Return to Home Page</a></p>
        </form>
        <?php
        // Include database settings and establish a database connection.
        require_once("settings.php");
        $conn = mysqli_connect($host, $user, $pswd, $dbnm) or die("Failed to connect to server: " . mysqli_connect_error());

        if (isset($_POST["login"])) {
            // Check if the login form was submitted.
            // Validate and sanitize user inputs.
            $valid = true;

            if (empty($_POST["email"])) {
                echo "<div class='content'><font color='red'>Please insert Email !</font></div>";
                $valid = false;
            } else {
                $email = test_input($_POST["email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<div class='content'><font color='red'>$email is not a valid email address!</font></div>";
                    $valid = false;
                }

                $queryEmail = "SELECT * FROM friends WHERE friend_email = '$email'";
                $resultEmail = mysqli_query($conn, $queryEmail);

                //check if query execute sucessfully
                if (mysqli_num_rows($resultEmail) == 0) {
                    $valid = false;
                    echo "<font color='red'>Invalid Email</font>";
                }

                if (empty($_POST["password"])) {
                    echo "<div class='content'><font color='red'>Password is required!</font></div>";
                    $valid = false;
                } else {
                    $password = test_input($_POST["password"]);
                    $queryPass = "SELECT * FROM friends WHERE `password` = '$password'";
                    $resultPass = mysqli_query($conn, $queryPass);

                    if (mysqli_num_rows($resultPass) == 0) {
                        $valid = false;
                        echo "</font>Invalid Password</font>";
                    }
                }

                if ($valid) { // If inputs are valid, query the database for login.
                    $query = "SELECT * FROM `friends` WHERE friend_email = '$email' AND `password` = '$password'";
                    $result = mysqli_query($conn, $query) or die("Something went wrong.");

                    if (mysqli_num_rows($result) !== 0) { // If login is successful, set session variables and redirect to friendlist.php.
                        $_SESSION['logged_in'] = 1;
                        $query = "SELECT friend_id, profile_name, num_of_friends FROM friends WHERE friend_email = '$email'";
                        $result = mysqli_query($conn, $query) or die("Something went wrong.");
                        $row = mysqli_fetch_assoc($result);
                        $_SESSION['user'] = $row['friend_id'];
                        $_SESSION['name'] = $row['profile_name'];
                        $_SESSION['friends'] = $row['num_of_friends'];
                        header("Location: friendlist.php");
                        exit();
                    } else {
                        echo "</font>Invalid Email or Password</font>";
                    }
                }
            }
        }
        // Function to sanitize input
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>
    </div>
</body>

</html>


<!-- Assignment 2
Name: Tri Trung Ton
Student ID: 103808977 -->
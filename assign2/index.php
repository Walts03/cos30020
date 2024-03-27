<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo isset($_GET['theme']) ? $_GET['theme'] : "white"; ?>">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Assignment 2" />
    <meta name="keywords" content="Advance Web Development" />
    <meta name="author" content="Tri Trung Ton">
    <title>Assign2 - Index</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="style.css">
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
    <div class="content">
        <h1>My Friend System</h1>
        <p> Name: Tri Trung Ton<br>
            Student ID: 103808977<br>
            Email: <a href="mailto: 103808977@student.swin.edu.au">103808977@student.swin.edu.au</a>
        </p>
        <p>
            I declare that this assignment is my individual work.
            I have not worked collaboratively, nor have I copied from any other student's work or from any other source. </p>
        <p>
            <b>Please Execute Query before testing anything. Thank you !</b>
        </p>

        <div style=" display: flex; justify-content: space-between">
            <form class="button" action='' method='POST'>
                <input type='submit' name='submit' value="Execute Query" />
            </form>
            <form class="button" action='' method='POST'>
                <input type='submit' name='drop' value="Drop Table" />
            </form>
        </div>

        <div class="pagination" style="display: flex; justify-content: space-between;">
            <p><a href="signup.php">Sign Up</a></p>
            <p><a href="login.php">Log In</a></p>
            <p><a href="about.php">About</a></p>
        </div>

        <?php
        // Check if Execute Query button submit or not
        if (isset($_POST['submit'])) {
            require_once('settings.php'); // Include the settings.php file to get database connection parameters
            $conn = mysqli_connect($host, $user, $pswd, $dbnm); // Connect to the database
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            } else {
                echo "<p><font color='green'>Connected successfully</font><p>";
                //table friends
                $query = "CREATE TABLE IF NOT EXISTS friends(
                        friend_id INT NOT NULL AUTO_INCREMENT,
                        friend_email varchar(50) NOT NULL,
                        `password` varchar(20) NOT NULL,
                        profile_name varchar(30) NOT NULL,
                        date_started date NOT NULL,
                        num_of_friends int UNSIGNED, 
                        PRIMARY KEY  (friend_id) 
                    )"; // Create the 'friends' table if it doesn't exist
                if ($conn->query($query) === TRUE) {
                    echo "<p><font color='green'>Table friends created successfully</font></p>";
                } else {
                    echo "Error creating table: " . $conn->error;
                }
                // Populate tables with test data
                $date = date("Y-m-d");
                $data = [
                    ['trungton@gmail.com', '123abc', 'Trung', $date, 3],
                    ['khanhtrangpham@gmail.com', '234zyz', 'Trang', $date, 2],
                    ['dangkhanhtoannguyen@gmail.com', '567abc', 'Toan', $date, 2],
                    ['leminhvu@gmail.com', '123abc', 'Kodo', $date, 2],
                    ['thinhathavu@gmail.com', '123abc', 'Rika', $date, 2],
                    ['maianh@gmail.com', '123abc', 'Mai Anh', $date, 2],
                    ['tech@bit.sm', '345xyz', 'Tech', $date, 2],
                    ['hok@uni.au', '123abc', 'Hokussai', $date, 2],
                    ['hoang@captain.ge', '567zxc', 'Hoang', $date, 2],
                    ['ducthinhnguyen@test.test', '123abc123', 'Oivia', $date, 2],
                ]; // Populate the 'friends' table with test data

                $values = [];
                foreach ($data as $row) {
                    $values[] = "('" . implode("', '", $row) . "')";
                }

                $query = "INSERT INTO friends (friend_email, `password`, profile_name, date_started, num_of_friends) VALUES " . implode(", ", $values);
                if ($conn->query($query) === TRUE) {
                    $records = count($data);
                } else {
                    echo "Error: " . $query . "<br>" . $conn->error;
                }

                echo "<p><font color='green'>Added $records records to friends table.</font></p>";

                // Create the 'myfriends' table if it doesn't exist
                $query = "CREATE TABLE IF NOT EXISTS myfriends(
                friend_id1 INT NOT NULL,
                friend_id2 INT NOT NULL
            )";
                if ($conn->query($query) === TRUE) {
                    echo "<p><font color='green'>Table myfriends created successfully</font><p>";
                } else {
                    echo "Error creating table: " . $conn->error;
                }
                // Populate the 'myfriends' table with test data
                $data = [
                    [1, 2],
                    [1, 3],
                    [2, 4],
                    [2, 5],
                    [3, 6],
                    [3, 7],
                    [4, 8],
                    [5, 9],
                    [5, 10],
                    [6, 10],
                    [6, 9],
                    [7, 8],
                    [7, 10],
                    [8, 6],
                    [8, 5],
                    [9, 4],
                    [9, 3],
                    [10, 2],
                    [10, 1],
                    [1, 8],
                ];

                $values = [];
                foreach ($data as $row) {
                    $values[] = "('" . implode("', '", $row) . "')";
                }

                $query = "INSERT INTO myfriends (friend_id1, friend_id2) VALUES " . implode(", ", $values);
                if ($conn->query($query) === TRUE) {
                    $records = count($data);
                } else {
                    echo "Error: " . $query . "<br>" . $conn->error;
                }
            }
            mysqli_close($conn);
        }
        // Drop the 'friends' and 'myfriends' tables
        if (isset($_POST['drop'])) {
            require_once('settings.php');
            $conn = mysqli_connect($host, $user, $pswd, $dbnm);
            $query = "DROP TABLE friends, myfriends;";
            if ($conn->query($query) === TRUE) {
                echo "<p><font color='green'>Successfully Delete table friends, myfriends</font></p>";
            } else {
                echo "<font color = red><p>Error delete table: friends, myfriends </font></p>" . $conn->error;
            }
            mysqli_close($conn);
        }

        ?>
    </div>
</body>

</html>
<!-- Assignment 2
Name: Tri Trung Ton
Student ID: 103808977 -->
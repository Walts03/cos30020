<?php ob_start(); ?> <!-- Start output buffering. This is used to capture output before sending it to the browser. -->
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo isset($_GET['theme']) ? $_GET['theme'] : "white"; ?>">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Assignment 2" />
    <meta name="keywords" content="Advance Web Development" />
    <meta name="author" content="Tri Trung Ton">
    <title>Assign2 - Friend List</title>
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
    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) : ?>
        <div class="content">
            <div class="banner">
                <h1>My Friend System</h1>
                <h2><?php echo $_SESSION['name']; ?> Friend List Page</h2>
                <h2>Total number of friends is <?php echo $_SESSION['friends']; ?></h2>
            </div>
            <article width='50%' style="padding: 0">
                <table role="grid" width='50%'>
                    <tbody>
                        <?php
                        require_once("settings.php"); // Connect to the database using settings.php configuration.

                        $conn = mysqli_connect($host, $user, $pswd, $dbnm) or die("Failed to connect to server: " . mysqli_connect_error());
                        $userID = $_SESSION['user']; // Get the user's ID from the session.
                        $query = "SELECT * FROM friends WHERE friends.friend_id IN (SELECT myfriends.friend_id2 FROM myfriends WHERE myfriends.friend_id1 = $userID)"; // Query to select friends of the user.

                        $result = mysqli_query($conn, $query) or die("Something went wrong."); // Execute the query and handle any errors.
                        if (mysqli_num_rows($result) > 0) { // Check if there are friends to display.
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['profile_name'] . "</td>";
                                echo '<td width="50px">
                                <form action="friendlist.php" method="POST"  style="margin: 0; padding: .25em .75em">
                                <input name="id" value="' . $row['friend_id'] . '" hidden="hidden"></input>
                                <button type="submit" name="unfriend" style="margin: 0">Unfriend</button>
                                </form>
                                </td>';
                                echo "</tr>";
                            }
                        }
                        if (isset($_POST["unfriend"])) { // Handle the unfriend action if submitted.
                            $targetID = $_POST["id"];
                            $query = "DELETE FROM myfriends WHERE friend_id1 = $userID AND friend_id2 = $targetID";
                            if ($conn->query($query) === TRUE) { // The friend was successfully unfriended.
                            } else {
                                echo "Error: " . $query . "<br>" . $conn->error;
                            }
                            $query = "UPDATE friends SET num_of_friends =  num_of_friends - 1 WHERE friend_id = $userID"; // Update the number of friends for the user.
                            if ($conn->query($query) === TRUE) { // The friend count was updated successfully.

                            } else {
                                echo "Error: " . $query . "<br>" . $conn->error;
                            }
                            $query = "SELECT num_of_friends FROM friends WHERE friend_id = '$userID'"; // Query to retrieve the updated number of friends for the user.

                            $result = mysqli_query($conn, $query) or die("Something went wrong.");
                            $num = $result->fetch_assoc();
                            $_SESSION['friends'] = $num['num_of_friends'];
                            header("Refresh:0"); // Refresh the page to reflect the changes.
                        }
                        ?>
                    </tbody>
                </table>
            </article>
            <!-- link to return to homepage (index.html) -->
            <div class="pagination" style="display: flex; justify-content: space-between;">
                <p><a href="logout.php">Log Out</a></p>
                <p><a href="friendadd.php">Add Friend</a></p>
            </div>
        </div>
    <?php elseif ($_SESSION['logged_in'] == 0) : header('Location: login.php'); ?>
        <!-- If the user is not logged in, redirect to the login page. -->
    <?php endif; ?>
</body>

</html>


<!-- Assignment 2
Name: Tri Trung Ton
Student ID: 103808977 -->
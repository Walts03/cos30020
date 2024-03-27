<?php session_start(); // Start a new PHP session to store user data
ob_start(); // Start output buffering to capture output before sending it to the browser 
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo isset($_GET['theme']) ? $_GET['theme'] : "white"; ?>">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Assignment 2" />
    <meta name="keywords" content="Advance Web Development" />
    <meta name="author" content="Tri Trung Ton">
    <title>Assign2 - Add Friend</title>
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
    <?php if ($_SESSION['logged_in'] == 1) : // Check if the user is logged in
    ?>
        <div class="banner">
            <h1>My Friend System</h1>
            <?php
            $friends = $_SESSION['friends']; // Retrieve the user's friend count from the session
            echo "<h3>" . $_SESSION['name'] . "'s Friend List</h3>";  // Display the user's name and friend count
            echo "<h5>Total Number of Friends is " . $friends . ".</h5>";
            ?>
        </div>

        <div class="content">
            <!-- Provide links to log out and view the friend list -->
            <div class="pagination" style="display: flex; justify-content: space-between;">
                <p><a href="logout.php">Log Out</a></p>
                <p><a href="friendlist.php">Friend List</a></p>
            </div>
            <article width='50%' style="margin: 0">
                <table class="styled-table">
                    <tbody>
                        <?php
                        // database configuration
                        include_once("settings.php");
                        $conn = @mysqli_connect($host, $user, $pswd, $dbnm) or die("Failed to connect to server"); // Establish a database connection
                        $userID = $_SESSION['user']; // Get the user's ID from the session
                        $recordsPerPage = 5; // Number of records to display per page
                        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Current page number (default: 1)
                        $startFrom = ($page - 1) * $recordsPerPage; // Calculate the starting point for the query

                        $query = "SELECT f.*, 
                                (SELECT COUNT(*) FROM myfriends mf1
                                JOIN myfriends mf2 ON mf1.friend_id2 = mf2.friend_id2
                                WHERE mf1.friend_id1 = $userID 
                                AND mf2.friend_id1 = f.friend_id) as mutualCount FROM friends f WHERE f.friend_id NOT IN (SELECT myfriends.friend_id2 FROM `myfriends` WHERE myfriends.friend_id1 = $userID) AND f.friend_id != $userID LIMIT $startFrom, $recordsPerPage";
                        // retrieves information about users friends, count the mutual friend with each friend, excluding the login user, with pagination implemented

                        $result = mysqli_query($conn, $query) or die("Something when wrong."); // Execute the query
                        if (mysqli_num_rows($result) > 0) { // Check if there are rows in the result
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['profile_name'] . "</td>";
                                echo "<td>Mutual Friends: " . $row['mutualCount'] . "</td>";
                                echo '<td width="20%">
                                <form action="friendadd.php" method="POST"  style="margin: 0; padding: .25em .75em">
                                <input name="id" value="' . $row['friend_id'] . '" hidden="hidden">
                                </input>
                                <button type="submit" name="addfriend" style="margin: 0">Add friend</button>
                                </form>
                                </td>';
                                echo "</tr>";
                            }
                        }
                        // Check if the "Add Friend" form is submitted
                        if (isset($_POST["addfriend"])) {
                            $targetID = $_POST['id'];
                            $query = "INSERT INTO myfriends (friend_id1, friend_id2) VALUES ($userID, $targetID)"; // Query to insert a new record into the "myfriends" table
                            if ($conn->query($query) === TRUE) { // Friend added successfully
                            } else {
                                echo "Error: " . $query . "<br>" . $conn->error;
                            }
                            $query = "UPDATE friends SET num_of_friends = cast(num_of_friends + 1 as signed) WHERE friend_id = $userID"; // Update the number of friends for the logged-in user
                            if ($conn->query($query) === TRUE) { // Friend count updated successfully
                            } else {
                                echo "Error: " . $query . "<br>" . $conn->error;
                            }
                            // Retrieve the updated friend count
                            $query = "SELECT num_of_friends FROM friends WHERE friend_id = '$userID'";
                            $result = mysqli_query($conn, $query) or die("Soething went wrong.");
                            $num = $result->fetch_assoc();
                            // Update the friend count in the session
                            $_SESSION['friends'] = $num['num_of_friends'];
                            // Refresh the page to reflect the changes
                            header("Refresh:0");
                        }
                        // Query to count the total number of friends
                        $query = "SELECT COUNT(*) as total FROM friends WHERE friend_id NOT IN (SELECT myfriends.friend_id2 FROM `myfriends` WHERE myfriends.friend_id1 = $userID) AND friend_id != $userID";
                        $result = mysqli_query($conn, $query) or die("Something went wrong.");  // Execute the query to get the total number of records
                        $totalRecords = mysqli_fetch_assoc($result)['total']; // Get the total number of records from the result
                        $totalPages = ceil($totalRecords / $recordsPerPage); // Calculate the total number of pages needed for pagination
                        ?>
                    </tbody>
                </table>

                <?php
                // Display pagination links
                echo "<div class='pagination'>";
                if ($page > 1) {
                    echo "<p><a href='friendadd.php?page=" . ($page - 1) . "'>&laquo; Previous</a></p>";
                }
                if ($page < $totalPages) {
                    echo "<p><a href='friendadd.php?page=" . ($page + 1) . "'>Next &raquo;</a></p>";
                }
                echo "</div>";
                ?>
            </article>
        <?php
    // Check if the user is not logged in and redirect to the login page
    elseif ($_SESSION['logged_in'] == 0) : header('Location: login.php'); ?>
        <?php endif; ?>
</body>

</html>
<!-- Assignment 2
Name: Tri Trung Ton
Student ID: 103808977 -->
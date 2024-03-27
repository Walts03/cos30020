<!DOCTYPE html>
<html lang="en" data-theme="<?php echo isset($_GET['theme']) ? $_GET['theme'] : "white"; ?>">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Assignment 2" />
    <meta name="keywords" content="Advance Web Development" />
    <meta name="author" content="Tri Trung Ton">
    <title>Assignment 2</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<!-- information, answer question part -->

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
    <p><b>Question: </b></p>
    <ul>
        <li>What tasks you have not attempted or not completed?</li>
        <li>What special features have you done, or attempted, in creating the site that we should know about?</li>
        <li>Which parts did you have trouble with?</li>
        <li>What would you like to do better next time?</li>
        <li>What additional features did you add to the assignment? (if any)
        </li>
    </ul>
    <p><b>Answer: </b></p>
    <ul>
        <li>I have fully completed all the tasks and extra challenge for this assignement.
        </li>

        <li>I have complete the Part 4: Extra Challenge part. Add Friend page (addfriend.php) now will have more feature. The page can only limit to 5 records per pages, and will have pagination function implemented to display more record. The table that show record will also display mutual friend count for each record. </li>

        <li>I'm having some trouble with the query on Part 4: Extra Challenge, how to find the mutual friend but I have find the way to solve my problem. I'm also trouble on finding way to create connection through every file without calling it multiple time, I have make a disscussion about it on canvas and find the solution.</li>

        <li>I would like to make my code cleaner, compact and manageable through the time. And I also would like to improve UI for my product.</li>

        <li>For index.php page, there are 2 button for execute query to create table and insert test data, other one is drop table, these button are made the query for adding and creating test date execute once, make the tester easier to control and prevent bug for the system. Next, on the navigation bar, there is a pages called Data Show (datashow.php), this page make for testing purpose which will show all the data in both table so the tester don't have to go to MariaDB mysql to check. </li>
    </ul>
    <p><b>Screenshot of discussion response </b></p>
    <img src="images/discussion.png" alt="discussion">
    <br><br>
    <p><a href="index.php">Return to Home Page</a></p>
    <p><a href="friendadd.php">Go to Add Friends</a></p>
    <p><a href="friendlist.php">Go to Friend List</a></p>
    </div>

</body>

</html>
<!-- Assignment 2
Name: Tri Trung Ton
Student ID: 103808977 -->
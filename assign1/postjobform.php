<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Assignment 1" />
    <meta name="keywords" content="Web Programming" />
    <title>Assignment 1</title>
    <style>
        <?php include 'style.css'; ?>
    </style>
</head>

<body>
    <div class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a class="active" href="postjobform.php">Job Post</a></li>
            <li><a href="searchjobform.php">Job Search</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="datashow.php">Data Show</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="banner">
            <h1>Job Vacancy Posting System</h1>
        </div>
        <form action="postjobprocess.php" method="post">
            <div id="text">
                <!-- Position -->
                <label for="id">Position ID:</label>
                <input type="text" id="id" name="id"><br>

                <!-- title  -->
                <label for="title">Title:</label>
                <input type="text" id="title" name="title"><br>

                <!-- description -->
                <div class="formfield">
                    <label for="description" id="des">Description:</label>
                    <textarea id="description" name="description" rows="4" cols="30"></textarea><br>
                </div>

                <!-- Closing Date -->
                <label for="clo_Date">Closing Date:</label>
                <input type="text" id="clo_Date" name="clo_Date" value="<?php echo date('d/m/Y') ?>">
            </div>

            <!-- Position -->
            <label>Position:</label>
            <input type="radio" id="position" name="position" value="full">
            <label for="part">Full Time</label>
            <input type="radio" id="position" name="position" value="part">
            <label for="part">Part Time</label>

            <!-- Contract  -->
            <p>Contract:
                <input type="radio" id="contract" name="contract" value="on_going">
                <label for="on_going">On-going</label>
                <input type="radio" id="contract" name="contract" value="fixed">
                <label for="fixed">Fixed Term</label>
            </p>

            <!-- Application type -->
            <p>Application by:
                <input type="checkbox" id="app_Type1" name="app_Type1" value="post">
                <label for="post">Post </label>
                <input type="checkbox" id="app_Type2" name="app_Type2" value="mail">
                <label for="mail">Mail</label>
            </p>

            <!-- location -->
            <label for="location">Location:</label>
            <select name="location" id="location">
                <option disabled selected value> --- </option>
                <option value="ACT">ACT</option>
                <option value="NSW">NSW</option>
                <option value="NT">NT</option>
                <option value="QLD">QLD</option>
                <option value="SA">SA</option>
                <option value="TAS">TAS</option>
                <option value="VIC">VIC</option>
                <option value="WA">WA</option>
            </select><br><br>

            <!-- submit, reset  -->
            <input type="submit" value="Post">
            <input type="reset" value="Reset">

            <!-- link to return to homepage (index.html) -->
            <p>All fields are required. <a href="index.php">Return to Home Page</a></p>
        </form>
    </div>

</body>

</html>
<!-- Assignment 1
Name: Tri Trung Ton
Student ID: 103808977 -->
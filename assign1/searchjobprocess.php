<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
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
    <?php
    umask(0007); //set permission
    $error = 0; //error message
    //set value to empty
    $titleSearch = "";
    $positionSearch = "";
    $contractSearch = "";
    $app_TypeSearch1 = "";
    $app_TypeSearch2 = "";
    $locationSearch = "";

    if (isset($_GET["title"]) && empty($_GET["title"])) { //isset title input and if not empty
        echo "<p id='err'>Please enter a title input before searching</p>";
        $error = 1; //if false, error message
    } else {
        $titleSearch = stripslashes($_GET["title"]);
    }
    if (isset($_GET["position"]) && !empty($_GET["position"])) { //isset position input and if not empty
        $positionSearch = $_GET["position"];
    }
    if (isset($_GET["contract"]) && !empty($_GET["contract"])) { //isset contract input and if not empty
        $contractSearch = $_GET["contract"];
    }
    if (isset($_GET["app_Type1"]) && !empty($_GET["app_Type2"])) { //isset application 1 (value = post) input and if not empty
        $app_TypeSearch1 = $_GET["app_Type1"];
    }
    if (isset($_GET["app_Type2"]) && !empty($_GET["app_Type2"])) { //isset application 2 (value = mail)input and if not empty
        $app_TypeSearch2 = $_GET["app_Type2"];
    }
    if (isset($_GET["location"]) && !empty($_GET["location"])) { //isset location input and if not empty
        $locationSearch = $_GET["location"];
    }

    if ($error == 0) { //when error is == 0, there are no errors and all inputs are validated
        $dateData = array();
        $filename = "../../data/jobposts/jobs.txt"; //Gets file path.      
        $dir = "../../data/jobposts"; //Gets directory path.               
        if (file_exists($filename)) { //checks if file exists
            $handle = fopen($filename, "r"); //open file read mode
            echo "<h1>Job Vacancy Information</h1>";
            $search = false;

            while (!feof($handle)) { //if not end of file
                $onedata = fgets($handle); // read a line from the text file
                if ($onedata != "") { //if str not empty, execute
                    $data = explode("\t", $onedata); //turn string that has been read from file to array 
                    //data[1]: JobTitle, data[2]: Description, data[3]: Closing Date, 
                    //data[4]: Position, data[5]: Contract, data[6] + data[7]: application
                    //data[8]: location
                    $datenow = date("d/m/y"); //variable for today's date
                    if ($data[3] >= $datenow) { //checks if closing date haven't expired
                        $titleMatches = strpos(strtolower($data[1]), strtolower($titleSearch)) !== false; //checks if title matches title data array
                        $positionMatches = empty($positionSearch) || $data[4] === $positionSearch; //position match with user input
                        $contractMatches = empty($contractSearch) || $data[5] === $contractSearch; //contract match with user input
                        $appType1Matches = empty($app_TypeSearch1) || $data[6] === $app_TypeSearch1; //checks application1 by post,
                        $appType2Matches = empty($app_TypeSearch2) || $data[7] === $app_TypeSearch2; //checks application2 by post,
                        $locationMatches = empty($locationSearch) || preg_replace("@\n@", "", $data[8]) === $locationSearch; //checks location

                        if ($titleMatches && $positionMatches && $contractMatches && $appType1Matches && $appType2Matches && $locationMatches) {
                            $search = true; //if search is found, return search results
                            echo "<strong>Job Title: </strong>" . $data[1] . "</br>";
                            echo "<strong>Description: </strong>" . $data[2] . "</br>";
                            echo "<strong>Closing Date: </strong>" . $data[3] . "</br>";
                            echo "<strong>Position: </strong>" . $data[4] . "</br>";
                            echo "<strong>Contract: </strong>" . $data[5] . "</br>";
                            echo "<strong>Application by: </strong>" . $data[6] . " | " . $data[7] . "</br>";
                            echo "<strong>Location: </strong>" . $data[8] . "</br>";
                            echo "<hr>";
                        }
                    }
                }
            }
            fclose($handle); // close file
            if ($search == false) { //if the string search is not found, execute 
                echo "<p id='err'>Search failed! Job Title not found </p>";
                echo "<p>Return to <a href=\"index.php\"> Home Page</a>";
                echo "<p>Go to <a href=\"searchjobform.php\">Search Job Vacancy</a></p>";
            } else {
                echo "<p>Return to <a href=\"index.php\"> Home Page</a>";
                echo "<p>Back to <a href=\"searchjobform.php\">Search Job Vacancy</a></p>";
            }
        }
    } else { //if file does not exist; error message
        echo "<p>Return to <a href=\"index.php\"> Home Page</a>";
        echo "<p>Go to <a href=\"searchjobform.php\">Search Job Vacancy</a></p>";
    }

    ?>
</body>

</html>
<!-- Assignment 1
Name: Tri Trung Ton
Student ID: 103808977 -->
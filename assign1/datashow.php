<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="Assignment 1" />
  <meta name="keywords" content="Web Programming" />
  <style>
    <?php include 'style.css'; ?>
  </style>
  <title>Assignment 1</title>
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
  <h1>Job Vacancy Posting System</h1>
  <?php // read the comments for hints on how to answer each item
  $filename = "../../data/jobposts/jobs.txt"; // assumes php file is inside lab05 
  $handle = fopen($filename, "r"); // open the file in append mode
  while (!feof($handle)) { // loop while not end of file
    $onedata = fgets($handle); // read a line from the text file
    if ($onedata != "") { //if array not empty, execute
      $data = explode("\t", $onedata);
      echo "<table id='datashow'>
            <tr>
              <th>Position ID</th>
              <th>Job Title</th>
              <th>Description</th>
              <th>Closing Date</th>
              <th>Position</th>
              <th>Contract</th>
              <th>Application Type</th>
              <th>location</th>
            </tr>
            <tr>
              <td>$data[0]</td>
              <td>$data[1]</td>
              <td>$data[2]</td>
              <td>$data[3]</td>
              <td>$data[4]</td>
              <td>$data[5]</td>
              <td>$data[6] + $data[7]</td>
              <td>$data[8]</td>
            </tr>
          </table>"; // generate HTML output of the data
    }
  }
  echo "<p>data[0]: Position ID, data[1]: JobTitle, data[2]: Description, data[3]: Closing Date, data[4]: Position, data[5]: Contract, data[6] + data[7]: application, data[8]: location</p>";
  fclose($handle); // close the text file
  echo "<p>Return to <a href=\"index.php\"> Home Page</a>";
  echo "<p>Go to <a href=\"searchjobform.php\">Search Job Vacancy</a></p>";
  ?>

</body>

</html>
<!-- Assignment 1
Name: Tri Trung Ton
Student ID: 103808977 -->
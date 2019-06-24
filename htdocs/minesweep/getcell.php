<?php
session_start();
if ($_GET['query'] == "1" ) {
  $x = $_GET['x'];
  $y = $_GET['y'];
  if($_SESSION['mines'][$x][$y] != 0) {
    $_SESSION['clickedValues'][$x][$y] = $_SESSION['mines'][$x][$y];
  }
  else {
    $_SESSION['clickedValues'][$x][$y] = -2;
  }
  echo $_SESSION['mines'][$x][$y];
}
else if ($_GET['query'] == "2") {
  $x = $_GET['x'];
  $y = $_GET['y'];
  $_SESSION['clickedValues'][$x][$y] = -3;
}
else if ($_GET['query'] == "3") {
  $x = $_GET['x'];
  $y = $_GET['y'];
  $_SESSION['clickedValues'][$x][$y] = 0;
}
else if ($_GET['query'] == "4") {
  $_SESSION['boardSet'] = false;
  $servername = "sql108.epizy.com";
  $username = "epiz_23868829";
  $password = "6hnqPSeeD";
  $dbname = "epiz_23868829_3750stoor";
  $conn=mysqli_connect($servername, $username, $password, $dbname);

  if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
  }
  $user = $_SESSION['user'];
  $score = $_GET['finalScore'];

  $query = "INSERT INTO MinesweepScores(User, Score)
              VALUES('$user', '$score')";
  $result = $conn->query($query);
}
else if($_GET['query'] == "5") {
  $_SESSION['currTime'] = $_GET['currTime'];
}
else if($_GET['query'] == "6") {
  $js_mines = json_encode($_SESSION['mines']);
  echo $js_mines;
  $_SESSION['boardSet'] = false;
}
?>

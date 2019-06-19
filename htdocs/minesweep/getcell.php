<?php
session_start();
if ($_GET['query'] == "1" ) {
  $x = $_GET['x'];
  $y = $_GET['y'];
  $_SESSION['clickOrFlag'][$x][$y] = 1;
  echo $_SESSION['mines'][$x][$y];
}
else if ($_GET['query'] == "2") {
  $x = $_GET['x'];
  $y = $_GET['y'];
  $_SESSION['clickOrFlag'][$x][$y] = 2;
}
else if ($_GET['query'] == "3") {
  $x = $_GET['x'];
  $y = $_GET['y'];
  $_SESSION['clickOrFlag'][$x][$y] = 0;
}
?>

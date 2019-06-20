<?php
session_start();
if ($_GET['query'] == "1" ) {
  $x = $_GET['x'];
  $y = $_GET['y'];
  $_SESSION['clickOrFlag'][$x][$y] = 1;
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
}
?>

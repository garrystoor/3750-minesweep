<?php
  session_start();

  session_destroy();
  header("Location: http://3750stoor.epizy.com/minesweep/login.php");
 ?>

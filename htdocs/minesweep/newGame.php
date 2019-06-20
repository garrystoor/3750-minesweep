<?php
	session_start();
	$_SESSION['boardSet'] = false;
	header("Location: http://3750stoor.epizy.com/minesweep/login.php");
?>
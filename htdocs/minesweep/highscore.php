<?php
  session_start();
	$servername = "sql108.epizy.com";
	$username = "epiz_23868829";
	$password = "6hnqPSeeD";
	$dbname = "epiz_23868829_3750stoor";

	$conn=mysqli_connect($servername, $username, $password, $dbname);

	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}

	$rank = 0;

	$query = "SELECT User, Score FROM MinesweepScores ORDER BY Score";
	$result = $conn->query($query);
	$count = 1;
	echo "High Scores<br><pre>Rank | Score | Name<br>";
	if ($result->num_rows > 0)
	{
		while ($row = $result->fetch_assoc())
		{
			if($count <= 10){
				if($count == 10){
          if($row["Score"] > 99){
            echo $count . "   | " . $row["Score"] . "   | " . $row["User"] . "<br>";
          }
					else if($row["Score"] > 9){
						echo $count . "   | " . $row["Score"] . "    | " . $row["User"] . "<br>";
					}
					else{
						echo $count . "   | " . $row["Score"] . "     | " . $row["User"] . "<br>";
					}
				}else{
          if($row["Score"] > 99){
            echo $count . "    | " . $row["Score"] . "   | " . $row["User"] . "<br>";
          }
					else if($row["Score"] > 9){
						echo $count . "    | " . $row["Score"] . "    | " . $row["User"] . "<br>";
					}
					else{
						echo $count . "    | " . $row["Score"] . "     | " . $row["User"] . "<br>";
					}
				}
				$count = $count + 1;
			}
			else{
				$count = $count + 1;
			}
		}
		echo "</pre>";
	}
	else
	{
		echo "Got nothing";
	}

	mysqli_close($con);
  if($_SESSION['user'] == null){
    ?>
    <form action="login.php">
    	<input type="submit" value="Back to Login">
    </form>
    <?php
  }
  else{
    ?>
    <form action="newGame.php">
      <input type="submit" value="New Game">
    </form>
	<?php
		if($_SESSION['boardSet'] == true){ ?>
		<form action="minesweeper.php">
			<input type="submit" value="Continue">
		</form>
	<?php } ?>
    <form action="logout.php">
     <input type="submit" value="Logout">
   </form>
  <?php
  }
  ?>

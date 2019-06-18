<html>
	<body>
<?php
	session_start();

	//check if user is already logged in
	if($_SESSION['user'] != null){
		header("Location: http://3750stoor.epizy.com/minesweep/minesweeper.php");
	}
	?>

	<script type="text/javascript">
		//import sha-256 script
		var imported = document.createElement('script');
		imported.src = './sha256.js';
		document.head.appendChild(imported);
		//create function that runs on button click
		function userLogin(usr, psswd){
			//make sure length of username is more than 0
			if(usr.length == 0){
				usr = "-1";
			}
			//make sure password length is more than 0
			if(psswd.length == 0){
				psswd = "-1";
			}
			//hash given password
			var hash = sha256(psswd);
			for(var i = 0; i < 10; i++){
				hash = sha256(hash);
			}
			//open sub-page to verify information
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET", "login.php?submit=1&user="+usr+"&pass=" + hash, true);
			xmlhttp.send();
			setTimeout(function(){window.location.href = 'http://3750stoor.epizy.com/minesweep/login.php?submit=1'}, 500);
		}

		</script>
		<h1>MINESWEEPER</h1>
		<p>
		<form>
			Username: <input id="user" type="text" autofocus>
			<br><br>
			Password: <input id="password" type="password">
			<br><br>
			<input type="button" value="Login" name="login" onclick="userLogin(user.value, password.value)">
		</form>
		<form action="http://3750stoor.epizy.com/minesweep/createUser.php" method="get">
			<input type="submit" value="New User" name="newUser">
		</form>
		</p>


<?php
	$servername = "sql108.epizy.com";
	$username = "epiz_23868829";
	$password = "6hnqPSeeD";
	$dbname = "epiz_23868829_3750stoor";
	$conn=mysqli_connect($servername, $username, $password, $dbname);

	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}

	if ($_GET['submit'] == "1" ) {
		if($_GET['user'] != "-1"){
			$user=$_GET['user'];
			$query = "SELECT Password, Salt FROM MinesweepUsers WHERE Username='$user'";
			$result = $conn->query($query);
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					$toHash = $_GET['pass'] . "" . $row['Salt'];
					for($i = 0; $i < 10; $i++){
						$pass = hash('sha256', $toHash);
						$toHash = $pass . "" . $row['Salt'];
					}
					if($row['Password'] == $pass){
						$_SESSION['user'] = $_GET['user'];
					}
					else{
						?>
							<p>Bad username or password</p>
						<?php
					}
				}
			}
			else{
				?>
					<p>Bad username or password</p>
				<?php
			}

			mysqli_close($con);
		}
		else{
			?>
				<p>Bad username or password</p>
			<?php
		}
	}

 ?>
 <form action="highscore.php">
	 <input type="submit" value="To Highscores">
 </form>
 	</body>
</html>

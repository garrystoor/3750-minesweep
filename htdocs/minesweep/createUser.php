

<html>
	<body>
<?php
	session_start();

	if($_SESSION['user'] != null){
		header("Location: http://3750stoor.epizy.com/minesweep/minesweeper.php");
	}
	?>

	<script type="text/javascript">
		var imported = document.createElement('script');
		imported.src = './sha256.js';
		document.head.appendChild(imported);
		function userLogin(usr, psswd, pass){
			//Database data types Salt, Username, Password
			if(psswd !== pass || pass === "" || psswd === ""){
				window.location.href = 'http://3750stoor.epizy.com/minesweep/createUser.php?submit=1&user='+usr+'&pass=';
			}
			else{
				var hash = sha256(psswd);
				for(var i = 0; i < 10; i++){
					hash = sha256(hash);
				}

				window.location.href = 'http://3750stoor.epizy.com/minesweep/createUser.php?submit=1&user='+usr+'&pass='+hash
			}
		}

		</script>
		<h1>Create an account</h1>
		<p>
		<form>
		Username: <input id="user" type="text" autofocus>
		<br><br>
		Password: <input id="password" type="password">
		<br><br>
		Confirm Password: <input id="password2" type="password">
		<br><br>
			<input type="button" value="Create" name="login" onclick="userLogin(user.value, password.value, password2.value)">
		</form>
		<form action="http://3750stoor.epizy.com/minesweep/login.php" method="get">
			<input type="submit" value="Back to Login" name="login">
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
		if($_GET['user'] != ""){
			if($_GET['pass'] != ""){
				$user=$_GET['user'];
				$query = "SELECT Username FROM MinesweepUsers WHERE Username='$user'";
				$result = $conn->query($query);
				if($result->num_rows == 1){
					while($row = $result->fetch_assoc()){
						if($row['Username'] == $_GET['user']){
							?>
								<p>Username already exists</p>
							<?php
						}
					}
				}
				else{
					//insert username into table
					$query = "INSERT INTO MinesweepUsers (Username, Password) VALUES ('$user', NULL)";
					$result = $conn->query($query);
					//get salt attached to username
					$query = "SELECT Salt FROM MinesweepUsers WHERE Username='$user'";
					$result = $conn->query($query);
					$row = $result->fetch_assoc();
					//hash password with salt
					$toHash = $_GET['pass'] . "" . $row['Salt'];
					for($i = 0; $i < 10; $i++){
						$pass = hash('sha256', $toHash);
						$toHash = $pass . "" . $row['Salt'];
					}
					//insert password into database
					$query = "UPDATE MinesweepUsers SET Password='$pass' WHERE Username='$user'";
					$result = $conn->query($query);
					//auto-login user with username
					$_SESSION['user'] = $user;
					header("Location: http://3750stoor.epizy.com/minesweep/minesweeper.php");
				}
			}
			else{
				?>
					<p>Password and Confirm Password field do not match or are blank</p>
				<?php
			}

			mysqli_close($con);
		}
		else{
			?>
				<p>Username field was blank</p>
			<?php
		}
	}
 ?>

 	</body>
</html>

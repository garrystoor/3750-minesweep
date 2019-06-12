<html>
	<body>
<?php
	session_start();

	if($_SESSION['user'] != null){
		header("Location: http://3750stoor.epizy.com/minesweep/minesweeper.php");
	}
	?>

	<script type="text/javascript">
	require(['./sha256.js'], function(sha256) {
	// ...
	});
	function userLogin(usr, psswd, pass){
		//Database data types Salt, Username, Password
			if(psswd != pass){
				setTimeout(function(){window.location.href = 'http://3750stoor.epizy.com/minesweep/createUser.php?submit=1&fail=noMatch'}, 500);
			}
			if(pass == "" || psswd == ""){
				setTimeout(function(){window.location.href = 'http://3750stoor.epizy.com/minesweep/createUser.php?submit=1&user='+usr+'&pass='}, 500);
			}
			//var hash = sha256.create();
			//hash.update(pssed);
			//pass = sha256(psswd);
			
			setTimeout(function(){window.location.href = 'http://3750stoor.epizy.com/minesweep/createUser.php?submit=1&user='+usr+'&pass='+hash}, 500);
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
		<input type="button" value="Login" name="login" onclick="userLogin(user.value, password.value, password2.value)">
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
	
	if($_GET['fail'] == "noMatch"){
		?>
			<p>Password and confirm password need to match</p>
		<?php
	}
	else{
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
						echo $_GET['pass'];
						echo hash('sha256', $_GET['pass']);
						//works in php
					}
				}
				else{
					?>
						<p>Password or Confirm Password field was blank</p>
					<?php
				}
			}
			else{
				?>
					<p>Username field was blank</p>
				<?php
			}
			
		}
	}
 ?>
 	</body>
</html>


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



	if ($_GET['submit'] == "1" ) {
		if($_GET['user'] != "-1"){
			$query = "SELECT Username FROM MinesweepUsers WHERE Username = " + $_GET['user'];
			if($_GET['user'] == $conn->query($query)){
				echo "Wow that actually worked";
			}
			if($_GET['pass'] != "-1"){

			}
		}
		else{
			echo "No Username Found\n";
		}
		if($_GET['pass'] == "-1"){
			echo "No Password found\n";
		}
	}
	else { ?>
<html>
	<body>
	<script>
	function userLogin(usr, psswd){
		//Database data types Salt, Username, Password
			if(usr.length == 0){
				usr = "-1";
			}
			if(psswd.length == 0){
				psswd = "-1";
			}
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange= function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("txtHint").innerHTML = this.responseText;
				}
			};
			xmlhttp.open("GET", "login.php?submit=1&user="+usr+"&pass=" + psswd, true);
			xmlhttp.send();
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
		<br>
		<input type="button" value="New User" name="newUser" onclick="">
		</form>
		<p><span id="txtHint"></span></p>
		</p>
	</body>
</html>

<?php } ?>

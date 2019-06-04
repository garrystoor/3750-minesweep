<?php
	if ($_GET['user'] != null) {
		if($_GET['pass'])echo $_GET['user'];
		//Open mySQL connection
		//Do query based on what is in $_GET['value']
		//Return/echo query results as HTML
	}
	else { ?>
<html>
	<body>
	<script>
	function getHint(str) {
		if (str.length == 0) {
			return;
		}
		else {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange= function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("txtHint").innerHTML = this.responseText;
				}
			};
			xmlhttp.open("GET", "login.php?query=1&value=" + str, true);
			xmlhttp.send();
		}
	}
	function userLogin(usr, psswd){
		//Database data types Salt, Username, Password
		if (usr.length == 0 || psswd.length == 0) {
			return;
		}
		else {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange= function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("txtHint").innerHTML = this.responseText;
				}
			};
			xmlhttp.open("GET", "login.php?user="+usr+"&pass=" + psswd, true);
			xmlhttp.send();
		}
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

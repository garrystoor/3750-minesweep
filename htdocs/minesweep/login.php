<?php
	if ($_GET['submit'] == "1" ) {
		//Open mySQL connection
		//Do query based on what is in $_GET['value']
		//Return/echo query results as HTML
		if($_GET['user'] != "-1"){
			if($_GET['pass'] != "-1"){
				//check database against username and password
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

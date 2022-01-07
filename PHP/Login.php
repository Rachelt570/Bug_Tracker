<?php

echo 
'
	<form id = "Login-Form" action = "Scripts/PHP/Signin.inc.php" method = "post" >
	<label for = "Username"> Username </label>
	<input type="text" name="LoginUsername"> 
	<label for = "Password"> Password </label>
	<input type="Password" name = "LoginPassword"> 
	<input type = "Submit" name = "LoginSubmit" value = "Sign-In"> 
	</form>

	<p> Do not have any account? </p>
	<a href = "Signup.php"> Signup</a>
';
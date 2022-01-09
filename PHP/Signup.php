<?php
echo '
	<form id = "signupForm" action = "Scripts/PHP/Signup.inc.php" method = "post">
		<label for ="Username"> Username </label>
		<input type="text" id = "Username" name="Username">
		<label for = "Email"> Email </label>
		<input type="email" name = "Email">
		<label for = "Password"> Password </label>
		<input type="Password" name = "Password">
		<label for = "PasswordConfirm"> Confirm Password </label>
		<input type = "Password" name = "PasswordConfirm">
		<input type = "Submit" name = "SubmitSignup" value = "Signup">

	</form>
';
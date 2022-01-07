<?php

	if(!isset($_SESSION["UID"]))
		{
			require_once "Login.php";
		}
	else 
		{
			echo 
			
			' 

			<nav>
				<img class = "ProfilePicture" src = "Profiles/' . $_SESSION["Username"] .'/Profile.jpg"> 
				<a href = "Settings.php"> Settings </a>
				<a href = "Messages.php"> Messages </a>
				<a href = "Teams.php"> Teams </a>
				<a href = "Friends.php"> Friends </a>
			</nav>
			';


			require_once "Logout.php";

		}
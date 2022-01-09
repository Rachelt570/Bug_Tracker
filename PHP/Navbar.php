<?php

	if(!isset($_SESSION["UID"]))
		{
			require_once "Login.php";
		}
	else 
		{
			echo 
			
			' 
			<link rel = "stylesheet" href = "Styles/navbar.css">
			<nav>
				<a href = "Index.php"> <h2> Bug Tracker </h2> </a>
				<ul id = "NavbarLinks"> 
					<li> <a href = "Settings.php"> Settings </a> </li>
					<li> <a href = "Messages.php"> Messages </a> </li>
					<li> <a href = "Teams.php"> Teams </a> </li> 
					<li> <a href = "Friends.php"> Friends </a> <li>
					<li> <form id = "SignoutForm" method = "POST" action = "Scripts/PHP/Signout.inc.php"> <input type = "Submit" value = "Logout"> </input> </form> </li>


				</ul>
				';	
	
				echo ' 

			</nav>
			';



		}
<?php

	echo '
		<script src = "Scripts/JS/listFriendRequests.js"> </script>

		<h3> Add friend </h3>
		<form id = "AddFriend" method = "POST" action = "Scripts/PHP/FriendManagement.inc.php"> 
			<label for = "AddFriendSearchValue" name = "AddFriendSearchValue"> Enter Username </label>
			<input type = "search" name = AddFriendSearchValue>
			<input type = "submit" value = "Send Request">
		</form>          


		<ul id = "FriendRequests">
		

		</ul>                                                                           
		<ul id = "FriendsList"> 
			<li> Example friend </li>
			<li> Example friend two </li>
			<li> Example friend three </li>
		</ul>
	';
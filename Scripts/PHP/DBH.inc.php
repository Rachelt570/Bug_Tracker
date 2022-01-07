<?php

$Conn = new mysqli("localhost", "root", "", "bugtracker");

if ($Conn -> connect_errno)
{
	echo "Failed to connect  " . $Conn -> connect_error;
	exit();
}


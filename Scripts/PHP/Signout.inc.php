<?php
require_once "Globals.inc.php";
session_start();
session_unset();
session_destroy();
header("Location: ".$WEBSITE_HOST."/Index.php?signout=Success");
exit();
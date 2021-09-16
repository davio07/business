<?php

$head =
<<<eol
	<head>
		<title>business manager </title>
		<link rel="stylesheet" href="style.scss">
		<link rel="icon" href="logo.png">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
eol;

define("HEADER","
	<header>
		<div>Business Manager</div>
	</header>
	");
	
define("NAV",'
	<nav>
		<a href="?clientele">Show Clients</a>
		<a href="?budget">My Budget</a>
		<a href="?goals">My Goals</a>
		<a href="?business">Progress and Articles For Me</a>
		<a href="?account">Account Settings</a>
	</nav>
	');
	
define("SCRIPT",'
	<script type="text/javascript" src="script.js"></script>
	');
	
$footer = "
	<div>This is the footer</div>
	";
	
?>

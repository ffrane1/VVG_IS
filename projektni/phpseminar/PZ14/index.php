<?php

	# Stop Hacking attempt
	define('__APP__', TRUE);
	
	# Start session
    session_start();
	
	# Database connection
	include ("dbconn.php");
	
	# Variables MUST BE INTEGERS
    if(isset($_GET['menu'])) { $menu   = (int)$_GET['menu']; }
	if(isset($_GET['action'])) { $action   = (int)$_GET['action']; }
	
	# Variables MUST BE STRINGS A-Z
    if(!isset($_POST['_action_']))  { $_POST['_action_'] = FALSE;  }
	
	if (!isset($menu)) { $menu = 1; }
	
	# Classes & Functions
    include_once("functions.php");

print '
<!DOCTYPE html>
<html>
	<head>
		<title>PHP Web programiranje - Naslovna</title>
		<!-- META -->
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="vjezba" />
		<meta name="keywords" content="uvod, HTML" />
		<meta name="author" content="Filip Franetic">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- CSS -->
		<link rel="stylesheet" href="style.css">
		<link href="https://fonts.googleapis.com/css?family=Spicy+Rice" rel="stylesheet">
	</head>
<body>
	<header>
		<div'; if ($menu > 1) { print ' class="head_img"'; } else { print ' class="head_img"'; }  print '></div>
		<nav>';
			include("menu.php");
			print '
		</nav>
	</header>
	<main>';
	
	if (isset($_SESSION['message'])) {
		print $_SESSION['message'];
		unset($_SESSION['message']);
	}
	
	# Pocetna
	if (!isset($menu) || $menu == 1) { include("pocetna.php"); }
	
	# Ponuda
	else if ($menu == 2) { include("ponuda.php"); }
	
	# Outlet
	else if ($menu == 3) { include("outlet.php"); }
	
	# Prijava
	else if ($menu == 9) { include("pretraga.php"); }

	# FAQ
	else if ($menu == 4) { include("faq.php"); }
	
	# O nama
	else if ($menu == 5) { include("onama.php"); }
	
	# Registracija
	else if ($menu == 6) { include("registracija.php"); }
	
	# Prijava
	else if ($menu == 7) { include("prijava.php"); }
	
	# Admin webpage
	else if ($menu == 8) { include("admin.php"); }
	
	print '
	</main>
	<footer>
		<p>Copyright &copy; ' . date("Y") . ' <p> Filip Franetić <a href="https://github.com/ffrane1/VVG_IS"><img src="./../images/GitHub-Mark-Light-32px.png" title="Github" alt="Github"></a></p>
	</footer>
</body>
</html>';
?>

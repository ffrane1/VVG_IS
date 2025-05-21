<?php 
	if ($_SESSION['valid'] == 'true') {
		if (!isset($action)) { $action = 1; }
		print '
		<h1>Administracija</h1>
		<div id="admin">
			<ul>
				<li><a href="index.php?menu=8&amp;action=1">Korisnici</a></li>
				<li><a href="index.php?menu=8&amp;action=2">Ponude</a></li>
			</ul>';
			# Admin Users
			if ($action == 1) { include("admin/korisnici.php"); }
			
			# Admin News
			else if ($action == 2) { include("admin/ponude.php"); }
		print '
		</div>';
	}
	else {
		$_SESSION['message'] = '<p>Molim da se registrirate!</p>';
		header("Location: index.php?menu=6");
	}
?>
<?php 
	print '
	<ul>
		<li><a href="index.php?menu=1">Početna</a></li>
		<li><a href="index.php?menu=2">Ponuda</a></li>
		<li><a href="index.php?menu=3">Outlet</a></li>
		<li><a href="index.php?menu=9">Pretraga</a></li>
		<li><a href="index.php?menu=4">FAQ</a></li>
		<li><a href="index.php?menu=5">O nama</a></li>';
		if (!isset($_SESSION['user']['valid']) || $_SESSION['user']['valid'] == 'false') {
			print '
			<li><a href="index.php?menu=6">Registracija</a></li>
			<li><a href="index.php?menu=7">Prijava</a></li>';
		}
		else if ($_SESSION['user']['valid'] == 'true') {
			print '
			<li><a href="index.php?menu=8">Administracija</a></li>
			<li><a href="odjava.php">Odjava</a></li>';
		}
		print '
	</ul>';
?>
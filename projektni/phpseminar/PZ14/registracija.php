<?php 
	print '
	<h1>Registracija</h1>
	<div id="register">';
	
	if ($_POST['_action_'] == FALSE) {
		print '
		<form action="" id="registration_form" name="registration_form" method="POST">
			<input type="hidden" id="_action_" name="_action_" value="TRUE">
			
			<label for="fname">Ime *</label>
			<input type="text" id="fname" name="ime" placeholder="Ime.." required>

			<label for="lname">Prezime *</label>
			<input type="text" id="lname" name="prezime" placeholder="Prezime.." required>
				
			<label for="email">E-mail *</label>
			<input type="email" id="email" name="email" placeholder="e-mail.." required>
			
			<label for="kor_ime">Username * <small></small></label>
			<input type="text" id="kor_ime" name="kor_ime" pattern=".{5,10}" placeholder="username.." required><br>
			
									
			<label for="lozinka">Lozinka *</label>
			<input type="lozinka" id="lozinka" name="lozinka" pattern=".{4,}" required>

			<label for="drzava">Država</label>
			<select name="drzava" id="drzava">
				<option value="">molimo odaberite</option>';
				#Select all countries from database webprog, table countries
				$query  = "SELECT * FROM drzave";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '<option value="' . $row['sifra_drzave'] . '">' . $row['ime_drzave'] . '</option>';
				}
			print '
			</select>

			<input type="submit" value="Predaj">
		</form>';
	}
	else if ($_POST['_action_'] == TRUE) {
		
		$query  = "SELECT * FROM korisnici";
		$query .= " WHERE email='" .  $_POST['email'] . "'";
		$query .= " OR kor_ime='" .  $_POST['kor_ime'] . "'";
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
		//if ($row['email'] == '' || $row['kor_ime'] == '') {
		//if (is_null($row['email']) || is_null($row['kor_ime'])) {
		if (is_null($row)) {
			# password_hash https://secure.php.net/manual/en/function.lozinka-hash.php
			# password_hash() creates a new lozinka hash using a strong one-way hashing algorithm
			$pass_hash = password_hash($_POST['lozinka'], PASSWORD_DEFAULT, ['cost' => 12]);
			
			$query  = "INSERT INTO korisnici (ime, prezime, email, kor_ime, lozinka, drzava)";
			$query .= " VALUES ('" . $_POST['ime'] . "', '" . $_POST['prezime'] . "', '" . $_POST['email'] . "', '" . $_POST['kor_ime'] . "', '" . $pass_hash . "', '" . $_POST['drzava'] . "')";
			$result = @mysqli_query($MySQL, $query);
			
			# ucfirst() — Make a string's first character uppercase
			# strtolower() - Make a string lowercase
			echo '<p>' . ucfirst(strtolower($_POST['ime'])) . ' ' .  ucfirst(strtolower($_POST['prezime'])) . ', hvala na registraciji </p>
			<hr>';
		}
		else {
			echo '<p>Korisnik sa ovim korisnickim imenom ili email adresom vec postoji!</p>';
		}
	}
	print '
	</div>';
?>



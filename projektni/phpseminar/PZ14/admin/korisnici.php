<?php 
	
	# Update user profile
	if (isset($_POST['edit']) && $_POST['_action_'] == 'TRUE') {
		$query  = "UPDATE korisnici SET ime='" . $_POST['ime'] . "', prezime='" . $_POST['prezime'] . "', email='" . $_POST['email'] . "', kor_ime='" . $_POST['kor_ime'] . "', drzava='" . $_POST['drzava'] . "', arhiviran='" . $_POST['arhiviran'] . "'";
        $query .= " WHERE id=" . (int)$_POST['edit'];
        $query .= " LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
		# Close MySQL connection
		@mysqli_close($MySQL);
		
		$_SESSION['message'] = '<p>Uspješna izmjena korisničkih podataka!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=1");
	}
	# End update user profile
	
	# Delete user profile
	if (isset($_GET['delete']) && $_GET['delete'] != '') {
	
		$query  = "DELETE FROM korisnici";
		$query .= " WHERE id=".(int)$_GET['delete'];
		$query .= " LIMIT 1";
		$result = @mysqli_query($MySQL, $query);

		$_SESSION['message'] = '<p>Korisnik uspješno obrisan!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=1");
	}
	# End delete user profile
	
	
	#Show user info
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$query  = "SELECT * FROM korisnici";
		$query .= " WHERE id=".$_GET['id'];
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		print '
		<h2>Korisnici</h2>
		<p><b>Ime:</b> ' . $row['ime'] . '</p>
		<p><b>Prezime:</b> ' . $row['prezime'] . '</p>
		<p><b>Korisničko ime:</b> ' . $row['kor_ime'] . '</p>';
		$_query  = "SELECT * FROM drzave";
		$_query .= " WHERE sifra_drzave='" . $row['drzava'] . "'";
		$_result = @mysqli_query($MySQL, $_query);
		$_row = @mysqli_fetch_array($_result);
		print '
		<p><b>Država:</b> ' .$_row['ime_drzave'] . '</p>
		<p><b>Datum:</b> ' . $row['d_rodenja'] . '</p>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Povratak</a></p>';
	}
	#Edit user profile
	else if (isset($_GET['edit']) && $_GET['edit'] != '') {
		$query  = "SELECT * FROM korisnici";
		$query .= " WHERE id=".$_GET['edit'];
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		$checked_archive = false;
		
		print '
		<h2>Editiranje korisnika</h2>
		<form action="" id="registration_form" name="registration_form" method="POST">
			<input type="hidden" id="_action_" name="_action_" value="TRUE">
			<input type="hidden" id="edit" name="edit" value="' . $_GET['edit'] . '">
			
			<label for="fname">Ime *</label>
			<input type="text" id="fname" name="ime" value="' . $row['ime'] . '" placeholder="Vaše ime.." required>

			<label for="lname">Prezime *</label>
			<input type="text" id="lname" name="prezime" value="' . $row['prezime'] . '" placeholder="Vaše prezime.." required>
				
			<label for="email">Vaš E-mail *</label>
			<input type="email" id="email" name="email"  value="' . $row['email'] . '" placeholder="Vaš e-mail.." required>
			
			<label for="kor_ime">Korisničko ime *<small>(najmanje 5, a najvise 10 znakova)</small></label>
			<input type="text" id="kor_ime" name="kor_ime" value="' . $row['kor_ime'] . '" pattern=".{5,10}" placeholder="Korisničko ime.." required><br>
			
			<label for="drzava">Country</label>
			<select name="drzava" id="drzava">
				<option value="">molimo odaberite</option>';
				#Select all drzave from database webprog, table drzave
				$_query  = "SELECT * FROM drzave";
				$_result = @mysqli_query($MySQL, $_query);
				while($_row = @mysqli_fetch_array($_result)) {
					print '<option value="' . $_row['sifra_drzave'] . '"';
					if ($row['drzava'] == $_row['sifra_drzave']) { print ' selected'; }
					print '>' . $_row['ime_drzave'] . '</option>';
				}
			print '
			</select>
			
			<label for="arhiviran">Arkiviraj:</label><br />
            <input type="radio" name="arhiviran" value="DA"'; if($row['arhiviran'] == 'DA') { echo ' checked="checked"'; $checked_archive = true; } echo ' /> DA &nbsp;&nbsp;
			<input type="radio" name="arhiviran" value="NE"'; if($checked_archive == false) { echo ' checked="checked"'; } echo ' /> NE
			
			<hr>
			
			<input type="submit" value="Predaj">
		</form>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Povratak</a></p>';
	}
	else {
		print '
		<h2>Lista korisnika</h2>
		<div id="korisnici">
			<table>
				<thead>
					<tr>
						<th width="16"></th>
						<th width="16"></th>
						<th width="16"></th>
						<th>Ime</th>
						<th>Prezime</th>
						<th>E mail</th>
						<th>Država</th>
						<th width="16"></th>
					</tr>
				</thead>
				<tbody>';
				$query  = "SELECT * FROM korisnici";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;id=' .$row['id']. '"><img src="../images/user.png" alt="user"></a></td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;edit=' .$row['id']. '"><img src="../images/edit.png" alt="uredi"></a></td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;delete=' .$row['id']. '"><img src="../images/delete.png" alt="obriši"></a></td>
						<td><strong>' . $row['ime'] . '</strong></td>
						<td><strong>' . $row['prezime'] . '</strong></td>
						<td>' . $row['email'] . '</td>
						<td>';
							$_query  = "SELECT * FROM drzave";
							$_query .= " WHERE sifra_drzave='" . $row['drzava'] . "'";
							$_result = @mysqli_query($MySQL, $_query);
							$_row = @mysqli_fetch_array($_result, MYSQLI_ASSOC);
							print $_row['ime_drzave'] . '
						</td>
						<td>';
							if ($row['arhiviran'] == 'DA') { print '<img src="../images/inactive.png" alt="" title="" />'; }
                            else if ($row['arhiviran'] == 'NE') { print '<img src="../images/active.png" alt="" title="" />'; }
						print '
						</td>
					</tr>';
				}
			print '
				</tbody>
			</table>
		</div>';
	}
	
	# Close MySQL connection
	@mysqli_close($MySQL);
?>
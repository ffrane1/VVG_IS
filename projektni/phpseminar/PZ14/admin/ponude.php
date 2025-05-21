<?php 
	
	#Dodaj proizvod
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'add_proizvodi') {
		$_SESSION['message'] = '';
		# htmlspecialchars — Convert special characters to HTML entities
		# http://php.net/manual/en/function.htmlspecialchars.php
		$query  = "INSERT INTO proizvodi (naslov, opis, arhiviran)";
		$query .= " VALUES ('" . htmlspecialchars($_POST['naslov'], ENT_QUOTES) . "', '" . htmlspecialchars($_POST['opis'], ENT_QUOTES) . "', '" . $_POST['arhiviran'] . "')";
		$result = @mysqli_query($MySQL, $query);
		
		$ID = mysqli_insert_id($MySQL);
		
		# slika
        if($_FILES['slika']['error'] == UPLOAD_ERR_OK && $_FILES['slika']['name'] != "") {
                
			# strtolower - Returns string with all alphabetic characters converted to lowercase. 
			# strrchr - Find the last occurrence of a character in a string
			$ext = strtolower(strrchr($_FILES['slika']['name'], "."));
			
            $_slika = $ID . '-' . rand(1,100) . $ext;
			copy($_FILES['slika']['tmp_name'], "proizvodi/".$_slika);
			
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') { # test if format is slika
				$_query  = "UPDATE proizvodi SET slika='" . $_slika . "'";
				$_query .= " WHERE id=" . $ID . " LIMIT 1";
				$_result = @mysqli_query($MySQL, $_query);
				$_SESSION['message'] .= '<p>Uspješno ste dodali sliku.</p>';
			}
        }
		
		
		$_SESSION['message'] .= '<p>Uspješno dodan proizvod!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}
	
	# Update proizvodi
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'edit_proizvodi') {
		$query  = "UPDATE proizvodi SET naslov='" . htmlspecialchars($_POST['naslov'], ENT_QUOTES) . "', opis='" . htmlspecialchars($_POST['opis'], ENT_QUOTES) . "', arhiviran='" . $_POST['arhiviran'] . "'";
        $query .= " WHERE id=" . (int)$_POST['edit'];
        $query .= " LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
		
		# slika
        if($_FILES['slika']['error'] == UPLOAD_ERR_OK && $_FILES['slika']['name'] != "") {
                
			# strtolower - Returns string with all alphabetic characters converted to lowercase. 
			# strrchr - Find the last occurrence of a character in a string
			$ext = strtolower(strrchr($_FILES['slika']['name'], "."));
            
			$_slika = (int)$_POST['edit'] . '-' . rand(1,100) . $ext;
			copy($_FILES['slika']['tmp_name'], "proizvodi/".$_slika);
			
			
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') { # test if format is slika
				$_query  = "UPDATE proizvodi SET slika='" . $_slika . "'";
				$_query .= " WHERE id=" . (int)$_POST['edit'] . " LIMIT 1";
				$_result = @mysqli_query($MySQL, $_query);
				$_SESSION['message'] .= '<p>Uspješno ste dodali sliku.</p>';
			}
        }
		
		$_SESSION['message'] = '<p>Uspješno ste dodali proizvod!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}
	# End update proizvodi
	
	# Delete proizvodi
	if (isset($_GET['delete']) && $_GET['delete'] != '') {
		
		# Delete slika
        $query  = "SELECT slika FROM proizvodi";
        $query .= " WHERE id=".(int)$_GET['delete']." LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
        $row = @mysqli_fetch_array($result);
        @unlink("proizvodi/".$row['slika']); 
		
		# Delete proizvodi
		$query  = "DELETE FROM proizvodi";
		$query .= " WHERE id=".(int)$_GET['delete'];
		$query .= " LIMIT 1";
		$result = @mysqli_query($MySQL, $query);

		$_SESSION['message'] = '<p>Uspješno ste obrisali proizvod!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}
	# End delete proizvodi
	
	
	#Prikaži proizvode
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$query  = "SELECT * FROM proizvodi";
		$query .= " WHERE id=".$_GET['id'];
		#$query .= " ORDER BY datum DESC";
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		print '
		<h2>Pregled proizvoda</h2>
		<div class="proizvodi">
			<img src="proizvodi/' . $row['slika'] . '" alt="' . $row['naslov'] . '" naslov="' . $row['naslov'] . '">
			<h2>' . $row['naslov'] . '</h2>
			' . $row['opis'] . '
			<time datetime="' . $row['datum'] . '</time>
			<hr>
		</div>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Povratak</a></p>';
	}
	
	#Dodaj proizvod
	else if (isset($_GET['add']) && $_GET['add'] != '') {
		
		print '
		<h2>Dodaj proizvod</h2>
		<form action="" id="proizvodi_form" name="proizvodi_form" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="_action_" name="_action_" value="add_proizvodi">
			
			<label for="naslov">Naslov *</label>
			<input type="text" id="naslov" name="naslov" placeholder="Naslov.." required>

			<label for="opis">Opis *</label>
			<textarea id="opis" name="opis" placeholder="Opis proizvoda.." required></textarea>
				
			<label for="slika">Slika</label>
			<input type="file" id="slika" name="slika">
						
			<label for="arhiviran">Arhiviran:</label><br />
            <input type="radio" name="arhiviran" value="DA"> DA &nbsp;&nbsp;
			<input type="radio" name="arhiviran" value="NE" checked> NE
			
			<hr>
			
			<input type="submit" value="Predaj">
		</form>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Povratak</a></p>';
	}
	#Editiraj proizvodi
	else if (isset($_GET['edit']) && $_GET['edit'] != '') {
		$query  = "SELECT * FROM proizvodi";
		$query .= " WHERE id=".$_GET['edit'];
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		$checked_arhiviran = false;

		print '
		<h2>Uredi proizvod</h2>
		<form action="" id="proizvodi_form_edit" name="proizvodi_form_edit" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="_action_" name="_action_" value="edit_proizvodi">
			<input type="hidden" id="edit" name="edit" value="' . $row['id'] . '">
			
			<label for="naslov">Naslov *</label>
			<input type="text" id="naslov" name="naslov" value="' . $row['naslov'] . '" placeholder="Naslov.." required>

			<label for="opis">Opis *</label>
			<textarea id="opis" name="opis" placeholder="Opis proizvoda.." required>' . $row['opis'] . '</textarea>
				
			<label for="slika">Slika</label>
			<input type="file" id="slika" name="slika">
						
			<label for="arhiviran">Arhiviran:</label><br />
            <input type="radio" name="arhiviran" value="DA"'; if($row['arhiviran'] == 'DA') { echo ' checked="checked"'; $checked_arhiviran = true; } echo ' /> DA &nbsp;&nbsp;
			<input type="radio" name="arhiviran" value="NE"'; if($checked_arhiviran == false) { echo ' checked="checked"'; } echo ' /> NE
			
			<hr>
			
			<input type="submit" value="Predaj">
		</form>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Povratak</a></p>';
	}
	else {
		print '
		<h2>Proizvodi</h2>
		<div id="proizvodi">
			<table>
				<thead>
					<tr>
						<th width="16"></th>
						<th width="16"></th>
						<th width="16"></th>
						<th>Naslov</th>
						<th>Opis</th>
						<th>Datum</th>
						<th width="16"></th>
					</tr>
				</thead>
				<tbody>';
				$query  = "SELECT * FROM proizvodi";
				$query .= " ORDER BY datum DESC";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;id=' .$row['id']. '"><img src="../images/user.png" alt="user"></a></td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;edit=' .$row['id']. '"><img src="../images/edit.png" alt="uredi"></a></td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;delete=' .$row['id']. '"><img src="../images/delete.png" alt="obriši"></a></td>
						<td>' . $row['naslov'] . '</td>
						<td>';
						if(strlen($row['opis']) > 160) {
                            echo substr(strip_tags($row['opis']), 0, 160).'...';
                        } else {
                            echo strip_tags($row['opis']);
                        }
						print '
						</td>
						<td>' . $row['datum'] . '</td>
						<td>';
							if ($row['arhiviran'] == 'DA') { print '<img src="../images/inactive.png" alt="" naslov="" />'; }
                            else if ($row['arhiviran'] == 'NE') { print '<img src="../images/active.png" alt="" naslov="" />'; }
						print '
						</td>
					</tr>';
				}
			print '
				</tbody>
			</table>
			<a href="index.php?menu=' . $menu . '&amp;action=' . $action . '&amp;add=true" class="AddLink">Dodaj proizvod</a>
		</div>';
	}
	
	# Close MySQL connection
	@mysqli_close($MySQL);
?>
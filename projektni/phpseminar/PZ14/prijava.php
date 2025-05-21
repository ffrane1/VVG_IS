<?php
    print '

    <h1>Prijava</h1>
    <div id="prijava">';

    if ($_POST['_action_'] == FALSE) {
        print '

        <form action="" name="myForm" id="myForm" method="POST">
            <input type="hidden" id="_action_" name="_action_" value="TRUE">

            <label for="kor_ime">Korisničko ime:*</label>
            <input type="text" id="kor_ime" name="kor_ime" value="" pattern=".{5,10}" required>
            
            <label for="lozinka">Lozinka:*</label>
            <input type="password" id="lozinka" name="lozinka" value="" pattern=".{4,}" required>
            
            <input type="submit" value="Prijava">
        </form>';
    } else if ($_POST['_action_'] == TRUE) {
        // Redirect logic here
		//header("Location: index.php?menu=8");

		$query  = "SELECT * FROM korisnici";
		$query .= " WHERE kor_ime='" . $_POST['kor_ime'] . "'";
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);

		if (password_verify($_POST['lozinka'], $row['lozinka'])) {
			//$_SESSION['user']['valid'] = 'true';
			//$_SESSION['user']['id'] = $row['id'];
			//$_SESSION['user']['firstname'] = $row['ime'];
			//$_SESSION['user']['lastname'] = $row['prezime'];
			$_SESSION['valid'] = 'true';
			$_SESSION['id'] = $row['id'];
			$_SESSION['firstname'] = $row['ime'];
			$_SESSION['lastname'] = $row['prezime'];
			//$_SESSION['message'] = '<p>Dobrodošli, ' . $_SESSION['user']['ime'] . ' ' . $_SESSION['user']['prezime'] . '</p>';
			$_SESSION['message'] = '<p>Dobrodošli, ' . $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . '</p>';
			
			// Redirect to admin website
			header("Location: index.php?menu=8");
		}

		// If invalid credentials
		else {
			unset($_SESSION['user']);
			//$_SESSION['message'] = '<p>Upisali ste krivo korisničko ime ili lozinku!' . $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] . '</p>';
			$_SESSION['message'] = '<p>Upisali ste krivo korisničko ime ili lozinku!' . $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . '</p>';
			header("Location: index.php?menu=7");
		}
    }

    print '

    </div>';
?>

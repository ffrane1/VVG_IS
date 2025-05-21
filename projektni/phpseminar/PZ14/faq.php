<?php 
	print '
	<h1>FAQ</h1>
		<div id="faq">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2780.6333225351955!2d16.015785715924288!3d45.81860147910671!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4765d7c7c54294cd%3A0x141ee8b4a96f7e8e!2sMaksimir!5e0!3m2!1shr!2shr!4v1547575814302" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
			<form action="" id="contact_form" name="contact_form" method="POST">
				<label for="fname">Ime *</label>
				<input type="text" id="ime" name="ime" placeholder="Vaše ime.." required>

				<label for="lname">Prezime *</label>
				<input type="text" id="prezime" name="prezime" placeholder="Vaše prezime.." required>
				
				<label for="lname">E-mail *</label>
				<input type="email" id="email" name="email" placeholder="Vaš e-mail.." required>

				<label for="drzava">Država</label>
				<select id="drzava" name="drzava">
				  <option value="">Odaberite</option>
				  <option value="BIH">Bosna i Hercegovina</option>
				  <option value="HR" selected>Hrvatska</option>
				  <option value="LU">Luksembourg</option>
				  <option value="HU">Mađarska</option>
				</select>

				<label for="subject">Komentar</label>
				<textarea id="komentar" name="komentar" placeholder="Vaš komentar.." style="height:200px"></textarea>

				<input type="submit" value="Predaj">
			</form>
		</div>'
?>
<?php
print '
		<h1>FAQ</h1>
		<div id="faq">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2780.6333225351955!2d16.015785715924288!3d45.81860147910671!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4765d7c7c54294cd%3A0x141ee8b4a96f7e8e!2sMaksimir!5e0!3m2!1shr!2shr!4v1547575814302" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
			
				<p style="text-align:center; padding: 10px; background-color: #d7d6d6;border-radius: 5px;">We recieved your question. We will answer within 24 hours.</p>';
				$EmailHeaders  = "MIME-Version: 1.0\r\n";
				$EmailHeaders .= "Content-type: text/html; charset=utf-8\r\n";
				$EmailHeaders .= "From: <ffranetic@tgmail.com>\r\n";
				$EmailHeaders .= "Reply-To:<ffranetic@gmail.com>\r\n";
				$EmailHeaders .= "X-Mailer: PHP/".phpversion();
				$EmailSubject = 'Mail sa PHPWEB-a';
				$EmailBody  = '
				<html>
				<head>
				   <title>'.$EmailSubject.'</title>
				   <style>
					body {
					  background-color: #ffffff;
						font-family: Arial, Helvetica, sans-serif;
						font-size: 16px;
						padding: 0px;
						margin: 0px auto;
						width: 500px;
						color: #000000;
					}
					p {
						font-size: 14px;
					}
					a {
						color: #00bad6;
						text-decoration: underline;
						font-size: 14px;
					}
					
				   </style>
				   </head>
				<body>
					<p>Ime: ' . $_POST['ime'] . '</p>
					<p>Prezime: ' . $_POST['prezime'] . '</p>
					<p>E-mail: <a href="mailto:' . $_POST['email'] . '">' . $_POST['email'] . '</a></p>
					<p>Država: ' . $_POST['drzava'] . '</p>
					<p>Predmet: ' . $_POST['predmet'] . '</p>
				</body>
				</html>';
				print '
				<p>Ime: ' . $_POST['ime'] . '</p>
				<p>Prezime: ' . $_POST['prezime'] . '</p>
				<p>E-mail: ' . $_POST['email'] . '</p>
				<p>Država: ' . $_POST['drzava'] . '</p>
				<p>Predmet: ' . $_POST['predmet'] . '</p>';
				mail($_POST['email'], $EmailSubject, $EmailBody, $EmailHeaders);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Sign Guestbook</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>

	<?php 

	if (isset($_POST['submit'])) {
		$Name = stripslashes($_POST['name']);
		$Email = stripslashes($_POST['email']);

		$Name = str_replace("~", "-", $Name);
		$Email = str_replace("~", "-", $Email);
		$MessageRecord = "$Name~$Email\n";
		$MessageFile = fopen("Guestbook/messages.txt", "ab");
		if ($MessageFile === FALSE)
			echo "There was an error saving your entry.\n";
		else {
			fwrite($MessageFile, $MessageRecord);
			fclose($MessageFile);
			echo "Thank you for signing the Guest Book!\n";
		} 
	}

	?>

	<h1>Thank you for sign our awesome guestbook</h1>
	<hr />
	<form action="sign-book.php" method="POST">
		<span style="font-weight:bold">Name:</span>
		<input type="text" name="name" />
		<span style="font-weight:bold">Email:</span>
		<input type="text" name="email" /><br /><br />
		<input type="submit" name="submit" value="Sign Guest Book" />
		<input type="reset" name="reset" value="Reset Form" />
	</form>

	<hr />
	<p>
		<a href="index.php">View previous guests</a>
	</p>

</body>
</html>

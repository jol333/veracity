<html>
<head>
	<title>Veracity - Get social media RSS feeds!</title>
	<link rel="stylesheet" type="text/css" href="design.css">
</head>
<body>

	<img src="logoweb.png" alt="Veracity Logo" title="Veracity">
	<form action="index.php" method="post" class="form-wrapper cf" >
		<input type="text" id="fburl" name="fburl" placeholder="Enter URL here..." required />
		<button type="submit" name="submit">SUBMIT</button>
	</form>

<?php
if (!empty($_POST))
{
	echo "I got it:";
	echo $_REQUEST['fburl'];
}
?>

</body>
</html>
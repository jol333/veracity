<html>
<head>
	<title>Veracity - Get social media RSS feeds!</title>
	<link rel="stylesheet" type="text/css" href="design.css">
</head>
<body>

	<img src="logoweb.png" alt="Veracity Logo" title="Veracity">
	<form action="index.php" method="post" class="form-wrapper cf" >
		<input type="text" id="fburl" name="fburl" placeholder="Enter URL here..." required />
		<button type="submit" name="submit">GET RSS!</button>
	</form>

<?php
$flag=0;
if (!empty($_POST))
{
	$newurl=str_replace("http://", "", $_REQUEST['fburl']);
	$newurl=str_replace("https://", "", $newurl);
	
	if(filter_var("http://".$newurl,FILTER_VALIDATE_URL))
	{
		if(strstr($newurl,"fb.com/")||strstr($newurl, "facebook.com/")||strstr($newurl, "fb.me/"))
			$flag=1;
		else
		{
			$flag=0;
			echo '<FONT FACE="Monospace" COLOR="red"><B>';
			echo "Invalid URL!";
			echo "</B></FONT>";
		}
	}
	else
	{
			$flag=0;
			echo '<FONT FACE="Monospace" COLOR="red"><B>';
			echo "Invalid URL!";
			echo "</B></FONT>";
	}

	if($flag==1)
	{
		$urlslice=explode("/", $newurl);
		$pagename=explode("?",$urlslice[1]);
		$data=@file_get_contents("http://graph.facebook.com/".$pagename[0]);
		
		$pageid=array();
		if(preg_match('/^.*"id":"([0-9]+)"/', $data,$pageid))
		{
			$atom="http://www.facebook.com/feeds/page.php?format=atom10&id=".$pageid[1];
			$rss20="http://www.facebook.com/feeds/page.php?format=rss20&id=".$pageid[1];
			echo '<div class="rssfeed">';
			echo "<U>ATOM</U><BR><a href=".$atom.">".$atom."</a><br><br>";
			echo "<U>RSS 2.0</U><BR><a href=".$rss20.">".$rss20."</a>";
			echo '</div>';
		}
		else
		{
			echo '<FONT FACE="Monospace" COLOR="red"><B>';
			echo "RSS feed not found!";
			echo "</B></FONT>";
		}
	}
}
?>

</body>
</html>
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
		elseif (strstr($newurl, "youtube.com/"))
			$flag=2;
		elseif(strstr($newurl,"wikipedia.org/"))
			$flag=3;
		else
		{
			$flag=0;
			echo '<FONT FACE="Monospace" size=11px COLOR="red"><B>';
			echo "Given URL not supported.!";
			echo "</B></FONT>";
		}
	}
	else
	{
			$flag=0;
			echo '<FONT FACE="Monospace" size=11px COLOR="red"><B>';
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
			echo '<FONT FACE="Monospace" size=11px COLOR="red"><B>';
			echo "RSS feed not found!";
			echo "</B></FONT>";
		}
	}
	elseif ($flag==2)
	{
		$urlslice=explode("/", $newurl);
		if(count($urlslice)>2)
		{
			$pagename=explode("?",$urlslice[2]);
			$rss20="http://gdata.youtube.com/feeds/api/users/".$pagename[0]."/uploads";
			echo '<div class="rssfeed">';
			echo "<a href=".$rss20.">".$rss20."</a></div>";
		}
		else
		{
			echo '<FONT FACE="Monospace" size=11px COLOR="red"><B>';
			echo "RSS feed not found!";
			echo "</B></FONT>";
		}
	}
	elseif ($flag==3)
	{
		$urlslice=explode("/", $newurl);
		if(count($urlslice)>2)
		{
			$pagename=explode("#",$urlslice[2]);
			$atom="http://en.wikipedia.org/w/index.php?action=history&feed=atom&title=".$pagename[0];
			echo '<div class="rssfeed">';
			echo "<a href=".$atom.">".$atom."</a></div>";
		}
		else
		{
			echo '<FONT FACE="Monospace" size=11px COLOR="red"><B>';
			echo "RSS feed not found!";
			echo "</B></FONT>";
		}
	}
}
?>

</body>
</html>
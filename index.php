<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<title>毛钱笔记</title>
</head>
<body>
	<?php
		header("Content-type: text/html; charset=utf-8"); 
		$files = scandir("./");
		$filter_array = array(".","..","index.php",".svn");
		$vsfiles = array_diff($files,$filter_array);
		foreach ($vsfiles as $key => $file) {
			echo "<a href='http://".$_SERVER['HTTP_HOST']."/".$file."'>".$file."</a><br>";
		}
	?>
</body>
</html>
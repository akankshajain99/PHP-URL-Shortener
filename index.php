<?php
	// Run the connection here   
	$dbc = mysqli_connect("localhost","root","", "projects") or die ("could not connect to mysql");  
	$get_url = '';
	$short_url = '';
	$l = '';
	$err = '';
	if (isset($_POST['btn_submit'])) {
		
		$long_url = $_POST['long_url'];

		$short_url = substr(md5(time()), 0, 8);

		$sql = "INSERT into url_shortner (long_url, short_url) VALUES('$long_url', '$short_url')";
		$query = mysqli_query($dbc, $sql);

		if($query){
			$server = $_SERVER['SERVER_NAME'];
			$request_uri = $_SERVER['REQUEST_URI'];

			$get_url = $server.$request_uri.$short_url;
		}else{
			
			$err = "Error";
		}

		


	}elseif (isset($_GET)) {

		foreach ($_GET as $key => $value) {
			$l = mysqli_escape_string($dbc, $key);
			$l = str_replace('/','',$l);
		}

		$sql = "SELECT * from url_shortner where short_url = '$l' ";
		$query = mysqli_query($dbc, $sql);

		$rows = mysqli_num_rows($query);

		if($rows>0){
			$data = mysqli_fetch_assoc($query);
			$long_url = $data['long_url'];

			// Redirect browser
			header("Location: $long_url");
			
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>URL Shortener</title>
</head>
<body>
	<div class="main">
		<div class="container">
			<h1>URL Shortener PHP</h1>
			<form method="post" action="">
				<input type="text" name="long_url" class="" />
				<button type="submit" name="btn_submit">Short Url</button>
			</form>

			<div>
				<a href="<?=$short_url?>" target="_blank"><?=$get_url?></a>
				
				<p><?=$err;?></p>
			</div>
			
		</div>
		
	</div>
</body>
</html>
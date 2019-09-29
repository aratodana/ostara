<!DOCTYPE html>
<html>
<head>
	<title>Főoldal</title>
	<link rel="stylesheet" type="text/css" href="css/mainTheme.css">
	<?php
		require_once("essential/session_starter.php");
		require_once('packages/registerSystem/registerSystem.php');
		$registerSystem = new registerSystem();
		$registerSystem->head();
		if($registerSystem->isLoggedIn()) 	header('Location: index.php');
		$registerSystem->getIncludes();			
	?>
</head>
<body>
	<?php
			echo $registerSystem->getRegisterForm();
			echo $registerSystem->getLoginForm();
	?>

		<h1>Project Ostara: 0.0.0.5</h1>
		<p>Pre pre pre alpha prototype 0.0.0.0.0.0.0.1</p>
		<p>De tényleg, nincs még kész, csak saját felelőségre használd, vagy még úgy se!</p>
</body>
</html>
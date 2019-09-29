<!DOCTYPE html>
<html>
<head>
	<title>Főoldal</title>
	<?php
	
		require_once('essential/bootstrapIncludes.php');
		require_once('packages/registerSystem/registerSystem.php');
		$registerSystem = new registerSystem();
		//$registerSystem->head();
		if(!$registerSystem->isLoggedIn()) header('Location: login.php');

		require_once('packages/masterSystem/masterSystem.php');
		$masterSystem = new masterSystem();
		$masterSystem->getIncludes();

		require_once('packages/observerSystem/observerSystem.php');
		$observerSystem = new observerSystem();
		echo $observerSystem->beginObserving();

	?>
	<link rel="stylesheet" type="text/css" href="css/mainTheme.css">
</head>
<body>
	<?php
		echo $masterSystem->getMainTestContainerBar();
		echo $masterSystem->getFootControllBar();
		//echo $masterSystem->getURLs();
	?>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<title>Színteszt</title>
	<a href='index.php'>Vissza</a>
	<link rel="stylesheet" type="text/css" href="css/mainTheme.css">
	<?php
		require_once("packages/colorTestSystem/colorTestSystem.php");
		$colorTestSystem = new colorTestSystem();
		$colorTestSystem->getIncludes(false);
		echo $colorTestSystem->getRobots();

		require_once("packages/observerSystem/observerSystem.php");
		$observerSystem = new observerSystem();
		echo $observerSystem->beginObserving();
	?>
</head>
<body>
	<div id='colorTestSystem_testContainer' class='card'>
		<?php
			echo $colorTestSystem->getForm();
		?>
	</div>
</body>
</html>
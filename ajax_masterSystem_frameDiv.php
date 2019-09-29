
	<?php
		require_once('packages/registerSystem/registerSystem.php');
		$registerSystem = new registerSystem();
		//$registerSystem->head();
		if(!$registerSystem->isLoggedIn()) header('Location: login.php');

		require_once('packages/masterSystem/masterSystem.php');
		$masterSystem = new masterSystem();
		//$masterSystem->getIncludes();

		require_once('essential/bootstrapIncludes.php');
	?>

	<?php
		echo $masterSystem->getAjaxFrameDiv();
	?>
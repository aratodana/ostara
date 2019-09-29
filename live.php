<!DOCTYPE html>
<html>
<head>
	<title>Live</title>
	<?php
		require_once('packages/registerSystem/registerSystem.php');
		$registerSystem = new registerSystem();
		//$registerSystem->head();
		if(!$registerSystem->isLoggedIn()) header('Location: login.php');
	    require_once('packages/liveQuerySystem/liveQuerySystem.php');
        $liveQuerySystem = new liveQuerySystem();
	    echo $liveQuerySystem->getIncludes();   
	?>
</head>
<body>
    <?php
        echo $liveQuerySystem->getForm();
        echo $liveQuerySystem->getMainDiv();
    
    ?>
</body>
</html>
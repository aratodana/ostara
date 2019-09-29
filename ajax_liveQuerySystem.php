<?php
    require_once('packages/liveQuerySystem/liveQuerySystem.php');
    $liveQuerySystem = new liveQuerySystem();
    echo $liveQuerySystem->getQueryData();
?>
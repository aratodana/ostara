<?php
	require_once("./essential/antiHackingSystem.php");
	require_once("./essential/connector.php");
	require_once('packages/chatSystem_2/chatSystem.php');
	require_once("essential/session_starter.php");

	$chatSystem = new chatSystem();
	echo $chatSystem->getUnreadMessages();
?>
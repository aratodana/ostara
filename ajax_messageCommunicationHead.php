<?php
	require_once("./essential/antiHackingSystem.php");
	require_once("./essential/connector.php");
	require_once('packages/chatSystem/chatSystem.php');
	
	if(!isset($_GET['chatSystem_chatRoomNumber'])) die();
	else 											$chatSystem_roomNumber = $_GET['chatSystem_chatRoomNumber'];

	$chatSystem = new chatSystem($chatSystem_roomNumber);
	

	if(isset($_GET['chatSystem_getLastInsertedId']))
	{
		echo $chatSystem->getLastInsertedId();
	}

	if(isset($_GET['chatSystem_sendMessage']))
	{
		if(!isset($_GET['chatSystem_messageText']) or !isset($_GET['chatSystem_messageSender'])) die();
		$tmp_messageText = 	$_GET['chatSystem_messageText'];
		$tmp_messageSender = $_GET['chatSystem_messageSender'];
		$chatSystem->sendMessage($tmp_messageSender, $tmp_messageText);
	}
?>
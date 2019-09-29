<?php

require_once("./essential/connector.php");
require_once("essential/session_starter.php");

class observerSystem
{
		private $conn_public;

		public function __construct()
		{
			$this->conn_public = connector::getConnect();
		}

		public function beginObserving()
		{
			return "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script><script type='text/javascript' src='packages/observerSystem/javascript/observerSystem.js'></script>";
		}

		public function communicationHead()
		{
			require_once("./essential/connector.php");
			require_once("essential/session_starter.php");

			if(
				!isset($_SESSION['userId']) or
				!isset($_SESSION['roomNumber']) or
				!isset($_GET['observerSystem_itemId']) or
				!isset($_GET['observerSystem_itemValue']) or
				!isset($_GET['observerSystem_triggerMode']) or
				!isset($_GET['observerSystem_itemPlaceHolder']) or
				!isset($_GET['observerSystem_seconds'])
			) die('ERROR');

			$userId = $_SESSION['userId'];
			$roomId = $_SESSION['roomNumber'];
			$input_ItemId = $_GET['observerSystem_itemId'];
			$input_ItemValue = $_GET['observerSystem_itemValue'];
			$input_eventType = $_GET['observerSystem_triggerMode'];
			$input_ItemPlaceHolder = $_GET['observerSystem_itemPlaceHolder'];
			$seconds = $_GET['observerSystem_seconds'];



			$sql = "INSERT INTO `ADATGYUJTES` (userId, roomId, eventType, itemId, itemVal, itemPlaceHolder, feladatId, ido)
				VALUES ($userId, $roomId, '$input_eventType', '$input_ItemId', '$input_ItemValue', '$input_ItemPlaceHolder', NULL, $seconds);";
			$result = $this->conn_public->query($sql);
		}
}


?>
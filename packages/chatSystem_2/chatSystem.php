<?php
	require_once("./essential/antiHackingSystem.php");
	require_once("./essential/connector.php");
	require_once("essential/session_starter.php");
/*
This script created by Arató Dániel
Version: 1.0.0.0
=============================================================================================================
 ______     __  __     ______     ______   ______     __  __     ______     ______   ______     __    __    
/\  ___\   /\ \_\ \   /\  __ \   /\__  _\ /\  ___\   /\ \_\ \   /\  ___\   /\__  _\ /\  ___\   /\ "-./  \   
\ \ \____  \ \  __ \  \ \  __ \  \/_/\ \/ \ \___  \  \ \____ \  \ \___  \  \/_/\ \/ \ \  __\   \ \ \-./\ \  
 \ \_____\  \ \_\ \_\  \ \_\ \_\    \ \_\  \/\_____\  \/\_____\  \/\_____\    \ \_\  \ \_____\  \ \_\ \ \_\ 
  \/_____/   \/_/\/_/   \/_/\/_/     \/_/   \/_____/   \/_____/   \/_____/     \/_/   \/_____/   \/_/  \/_/ 
                                                                                                            
=============================================================================================================
	Simple chatprogram, using async technologie.

	Require includes:
		- php_back_sites/antiHackingSystem.php
		- php_back_sites/connector.php
		- site_parts/session_starter-php

	Require session varibles:
		- roomNumber:	int, the id of the chatRoom
		- userId:		int, the id of the user

=============================================================================================================
	Public members:

	Public Functions:
		- getChatBody()					-	Gets the body of the chat
		- getIncludes()					-	c
		- getInitMessages()				-	returs all the messages in the chatroom as string
		- getUnreadMessages()			-	returns all unread messages in the chatroom as string
		- sendMessage($textOfMessage)	-	sends a specific message, and saves it in the database

	Private Members:
		connection $conn_public: 	database connection

	Private Functions:
		
=============================================================================================================
*/

	class chatSystem
	{
		private $conn_public;

		public function __construct($tmpRoomNumber = -1)
		{
			$this->conn_public = connector::getConnect();
			if($tmpRoomNumber != -1) 	$_SESSION['roomNumber'] = $tmpRoomNumber;
		}

		public function getChatBody()
		{
			$tmpMessages = $this->getInitMessages();
			return "	<div id='chatSystem_MainContainer' class='card'>
							<div id='chatSystem_AjaxForLoad' class='card-body'>	
									<ul class='list-group'>
										$tmpMessages
									</ul>
							</div>
							<div id='chatSystem_FormBar' class='card-header'>
								<div id='chatSystem_emojiInserterBar'>
									<p class='chatSystem_emojiForInsertTheMessage'>🙂</p>
									<p class='chatSystem_emojiForInsertTheMessage'>😀</p>
									<p class='chatSystem_emojiForInsertTheMessage'>😉</p>
									<p class='chatSystem_emojiForInsertTheMessage'>😞</p>
									<p class='chatSystem_emojiForInsertTheMessage'>😰</p>
									<p class='chatSystem_emojiForInsertTheMessage'>😲</p>
									<p class='chatSystem_emojiForInsertTheMessage'>😛</p>
								</div>
								<div class='card_1'>
									<input type='text' name='chatSystem_MessageInput' class='form-control observerSystem_observedItem' id='chatSystem_MessageInput' placeholder='Írd ide az üzeneted..'>
								</div>
							</div>
						</div>";
		}

		public function getIncludes($scriptsOn = true)
		{
			require_once('essential/bootstrapIncludes.php');

			if($scriptsOn)	echo "<script type='text/javascript' src='packages/chatSystem_2/javascript/chatSystem_messageLoader.js'></script>";
			echo "<link rel='stylesheet' type='text/css' href='packages/chatSystem_2/css/chatSystem.css'>";
		}

		public function getInitMessages()
		{
			$tmp_chatRoomNumber = $_SESSION['roomNumber'];
			$sql = "SELECT * FROM CHAT INNER JOIN REGISZTRACIOS_KODOK ON REGISZTRACIOS_KODOK.FELHASZNALO = CHAT.felado INNER JOIN FELHASZNALO ON REGISZTRACIOS_KODOK.FELHASZNALO=FELHASZNALO.ID WHERE CHAT.SZOBA = $tmp_chatRoomNumber ORDER BY CHAT.ID ASC";
			//echo $sql;
			$result = $this->conn_public->query($sql);
			if(!$result)	return "";
			$s = ""; //ß"<a>További üzenetek betöltése</a><br>";
			//$s = '<link rel="stylesheet" type="text/css" href="packages/chatSystem_2/css/chatSystem.css">';

			if($result->num_rows > 0)
			{
				$lastId;
				while($row = $result->fetch_assoc())
				{
					if($row['felado'] != $_SESSION['userId'])	$senderTag = '';
					else 									$senderTag = 'list-group-item-info';
					$s .= "<li class='list-group-item $senderTag chatSystem_chatMessage'>" . $row['REGKOD'] ."[" .$row['ARCHETIPUS'] . "]: " .   $row['uzenet'] . "</li>";
					$lastId = $row['id'];
				}
				$_SESSION['chatSystem_lastLoadedId'] =  $lastId;
			}
			else
			{
				$_SESSION['chatSystem_lastLoadedId'] =  0;
			}
			return $s;
		}

		public function getUnreadMessages()
		{
			$tmp_chatRoomNumber = $_SESSION['roomNumber'];
			$tmp_lastLoadedId = $_SESSION['chatSystem_lastLoadedId'];
			$sql = "SELECT * FROM CHAT INNER JOIN REGISZTRACIOS_KODOK ON REGISZTRACIOS_KODOK.FELHASZNALO = CHAT.felado INNER JOIN FELHASZNALO ON REGISZTRACIOS_KODOK.FELHASZNALO=FELHASZNALO.ID WHERE CHAT.SZOBA = $tmp_chatRoomNumber AND CHAT.ID > $tmp_lastLoadedId ORDER BY CHAT.ID ASC";
			
			$result = $this->conn_public->query($sql);
			if(!$result)	return "";
			$s = "";
			if($result->num_rows > 0)
			{
				$lastId;
				while($row = $result->fetch_assoc())
				{
					if($row['felado'] != $_SESSION['userId'])	$senderTag = '';
					else 									$senderTag = 'list-group-item-info';
					$s .=  "<li class='list-group-item $senderTag chatSystem_chatMessage'>" .  $row['REGKOD'] ."[" .$row['ARCHETIPUS'] . "]: " .   $row['uzenet'] . "</li>";
					$lastId = $row['id'];
				}
				$_SESSION['chatSystem_lastLoadedId'] =  $lastId;
			}
			return $s;
			
		}

		public function sendMessage($textOfMessage)
		{
			$textOfMessage = antiHackingSystem::testString($textOfMessage);
			$senderOfMessage = $_SESSION['userId'];
			$roomNumber = $_SESSION['roomNumber'];
			$sql = "INSERT INTO CHAT (szoba, felado, uzenet) VALUES ($roomNumber,$senderOfMessage,'$textOfMessage');";
			$result = $this->conn_public->query($sql);
		}

	}

?>
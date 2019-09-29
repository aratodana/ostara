<?php

require_once("./essential/connector.php");
require_once("essential/session_starter.php");

class masterSystem
{
		private $conn_public;
		private $testNumber;

		public function __construct()
		{
			$this->conn_public = connector::getConnect();
			if(!isset($_GET['masterSystem_testNumber'])) $this->testNumber = 0;
			else 							$this->testNumber = $_GET['masterSystem_testNumber'];
		}

		public function getIncludes()
		{
			require_once('essential/bootstrapIncludes.php');
			echo "<link rel='stylesheet' href='packages/masterSystem/css/masterSystem.css'>";
			//echo "<script src='packages/masterSystem/javascript/masterSystem.js'></script>";
		}


		public function getMainTestContainerBar()
		{
			$userSession = $_SESSION['userSession'];
			$testNumber = $this->testNumber;
			
			$sql = "SELECT * FROM MUNKAMENET INNER JOIN SZOBA ON MUNKAMENET.SZOBA=SZOBA.ID WHERE MUNKAMENET.ID = $userSession ORDER BY MUNKAMENET.SORSZAM, SZOBA.SORSZAM LIMIT 1 OFFSET $testNumber;";
			$result = $this->conn_public->query($sql);
			
			if(!$result)
			{
				die('Adatbázishiba: 1');
			}

			if($result->num_rows <= 0)
			{
				require_once('packages/registerSystem/registerSystem.php');
				$registerSystem = new registerSystem();
				$registerSystem->doLogOut();
			}

			$row = $result->fetch_assoc();
			$tmpContentOfTest = "";
			if($row['ONLINE'])
			{

				if($row['FELADAT_1'] != '')
				{
					require_once('packages/colorTestSystem/colorTestSystem.php');
					$colorTestId = antiHackingSystem::testString($row['FELADAT_1']);
					$colorTestSystem = new colorTestSystem($colorTestId);
					$colorTestSystem->getIncludes();
					echo $colorTestSystem->getRobots();
					$_GET['colorTestSystem_testId'] = 1;
					$tmpContentOfTest = $colorTestSystem->getForm();
				}
				elseif($row['FELADAT_2'] != '')
				{
					$tmpContentOfTest = "<div class='card card-to-center'><p>Feladat_2: " . $_GET['masterSystem_feladat_2'] . "</p><br><p>Sajnos ez a funkció még nem elérhető</p></div>";
				}
				elseif($row['KOZTES'] != '')
				{
					require_once("packages/introSystem/introSystem.php");
					$introId = antiHackingSystem::testString($row['KOZTES']);

					$introSystem = new introSystem($introId);
					$introSystem->getIncludes();
					$tmpContentOfTest = $introSystem->getHTML();
				}
				else
				{
					$tmpContentOfTest = "";
					//die('hiba, nincs cél beállítva');
				}


				if($row['CHAT'])
				{
					require_once('packages/chatSystem_2/chatSystem.php');
					$chatId = antiHackingSystem::testString($row['CHAT'] != '');
					$chatSystem = new chatSystem($chatId);
					$chatSystem->getIncludes();
					$tmpChat = $chatSystem->getChatBody();
					$tmpContentOfTest =  "
						<div id='masterSystem_ajaxFrameDiv_split_1'>
							$tmpChat
						</div>
						<div id='masterSystem_ajaxFrameDiv_split_2'>
							$tmpContentOfTest
						</div>
					";
				}
				else
				{
					$tmpContentOfTest = "<div id='masterSystem_ajaxFrameDiv_full'>
								$tmpContentOfTest
							</div>";
				}

			}
			else
			{
					require_once("packages/introSystem/introSystem.php");
					$introId = antiHackingSystem::testString($row['KOZTES']);

					$introSystem = new introSystem(0);
					$introSystem->getIncludes();
					$tmpContentOfTest = $introSystem->getHTML();
			}



			return "<div id='masterSystem_mainTestContainerBar'>$tmpContentOfTest</div>";
		}

		public function getFootControllBar()
		{
			$url = 'index.php?masterSystem_testNumber=' . ($this->testNumber + 1); 
			return "<div id='masterSystem_footControllerBar'>
							<a href='$url' id='masterSystem_footControllerBar_button' class='btn btn-success btn-lg observerSystem_observedItem'>Tovább</a>
					</div>";
		}
}

?>
<?php
	require_once("./essential/antiHackingSystem.php");
	require_once("./essential/connector.php");
	require_once("essential/session_starter.php");

	class colorTestSystem
	{
		private $conn_public;
		private $testId;

		public function __construct($tmpTestId = -1)
		{
			$this->conn_public = connector::getConnect();
			if($tmpTestId == -1)
			{
				if(isset($_GET['colorTestSystem_testId'])) $this->testId = $_GET['colorTestSystem_testId'];
			}
			else
			{
				$this->testId = $tmpTestId;
			}
		
		}

		public function getIncludes($scriptsOn = true)
		{
			require_once('essential/bootstrapIncludes.php');
			echo '  <link rel="stylesheet" type="text/css" href="packages/colorTestSystem/css/colorTestSystem.css">';
			if($scriptsOn) echo '<script src="packages/colorTestSystem/javascript/colorTestSystem.js"></script>';
			echo "<script>colorTestSystem_timeCounter = 0; var colorTestSystem_testId = $this->testId</script>";
		}

		public function getRobots()
		{
			if($this->testId == -1) die('Nincs id beállítva');
			$s = "";
			$feladatId = $this->testId;
			$sql = "SELECT ROBOT.IDO, ROBOT.ERTEK, ROBOT.ARCHETIPUS FROM ROBOT WHERE FELADAT_ID = $feladatId;";
			$result = $this->conn_public->query($sql);
			if(!$result) return "<script>var colorTestSystem_robotList = []; console.log('ismeretlen adatbázishiba')</script>";
			if($result->num_rows == 0) return "<script>var colorTestSystem_robotList = []; console.log('nincs robot ehhez a feladathoz')</script>";
			
			$robotContainerMatrix = array();
			while($row = $result->fetch_assoc())
			{
				$robotTime = $row['IDO'];
				$robotValue = $row['ERTEK'];
				$robotArchetype = $row['ARCHETIPUS'];
				$tmpArrayOfBots = array($robotTime, $robotValue, $robotArchetype);
				array_push($robotContainerMatrix, $tmpArrayOfBots);
			}

			$s = "<script>var colorTestSystem_robotList = " . json_encode($robotContainerMatrix) . "</script>";

			return $s;
		}

		public function catchData_ajaxHead()
		{
			if(!isset($_GET['colorTestSytem_testId']) || !isset($_GET['colorTestSystem_time']) || !isset($_GET['colorTestSystem_newTestValue']))	die('nem megfelelő get adatok');
			$userId = $_SESSION['userId'];
			$testId = $_GET['colorTestSytem_testId'];
			$timeOfChange = $_GET['colorTestSystem_time'];
			$newTestValue = $_GET['colorTestSystem_newTestValue'];

			$sql = "INSERT INTO VALASZ (FELADAT, FELHASZNALO, VALASZTOTT, IDO) VALUES ($testId, $userId, $newTestValue, $timeOfChange);";
			$result = $this->conn_public->query($sql);
			if(!$result) die("Hibakód: 4");

		}

		public function getForm()
		{
			if($this->testId == -1) die('Nincs id beállítva');
			$sql = "";
			$tmpId = $this->testId;
			$sql = "SELECT * FROM FELADAT_1 WHERE ID = $this->testId;";

			//echo $sql;
			$result = $this->conn_public->query($sql);
			if(!$result) die("Hibakód: 1");
			if($result->num_rows != 1) die("Hibakód: 2");
			$row = $result->fetch_assoc();
			$image = $row['KEP'];


				return "
				<div class='card card-to-center'><div id='colorTestSystem_Question'>
				<h2>
				Értékeld 1-től 5-ig, hogy mennyire találod fényesnek az adott színt?
				</h2>
				</div>
				<div id='colorTestSystem_colorBox' style='background-image: url(images/testImages/$image)'></div>
				<div id='colorTestSystem_controllContainer'>
					<div id='colorTestSystem_controllContainer_pictures'>
					</div>
					<div id='colorTestSystem_controllContainer_form'>
						<form>
							<label for='colorTestSystem_volume'>1</label>
							<input type='range' id='colorTestSystem_volume' class='observerSystem_observedItem' name='colorTestSystem_volume' min='1' max='5'>
				        	<label for='colorTestSystem_volume'>5</label>
				        </form>
				        <div>Ide jön a dodo által kért emlékeztető mondat majd</div>
				  
					</div></div>
				</div>";
		}
	}
?>
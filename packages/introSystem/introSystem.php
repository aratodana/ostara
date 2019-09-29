<?php

require_once("./essential/connector.php");
require_once("essential/session_starter.php");

class introSystem
{
		private $conn_public;
		private $introId;

		public function __construct($tmpIntroId = -1)
		{
			$this->conn_public = connector::getConnect();
			if($tmpIntroId == -1)
			{
				if(!isset($_GET['introSystem_textId'])) die('hibas get adatok');
				else $this->introId = $_GET['introSystem_textId'];
			}
			else
			{
				$this->introId = $tmpIntroId;
			}
		}

		public function getIncludes()
		{
			require_once('essential/bootstrapIncludes.php');
		}

		public function getHTML()
		{
			$textId = $this->introId;
			$sql = "SELECT * FROM KOZTES WHERE ID= $textId";
			
			$result = $this->conn_public->query($sql);
			if (!$result) die('Adatbázishiba: 1');
			if($result->num_rows != 1) die('Adatbázishiba: 2');

			$row = $result->fetch_assoc();

			$textOfSite = "<h2>" . $row['CIM'] . "</h2><br>";
			$textOfSite .= "<p>" . $row['SZOVEG'] . "</p>";


			return "<div class='card card-to-center'>
						$textOfSite
					</div>";
		}
}

?>
<?php
	require_once("./essential/connector.php");
	class dataOutSystem
	{
		private $conn_public;
		private $html;

		public function __construct()
		{
			$this->conn_public = connector::getConnect();
			$this->html = false;
		}


		public function getUserDatas()
		{	
			$sql = "SELECT * FROM FELHASZNALO INNER JOIN REGISZTRACIOS_KODOK ON REGISZTRACIOS_KODOK.FELHASZNALO = FELHASZNALO.ID ORDER BY FELHASZNALO.ID";
			$result = $this->conn_public->query($sql);
			if(!$result)	return "Adatbázishiba: 1";

			return $this->printTable($result);
		}

		public function getTestDatas()
		{	
			$sql = "SELECT * FROM MUNKAMENET INNER JOIN SZOBA ON MUNKAMENET.SZOBA = SZOBA.ID";
			$result = $this->conn_public->query($sql);
			if(!$result)	return "Adatbázishiba: 2";

			return $this->printTable($result);
		}

		public function getIntro()
		{	
			$sql = "SELECT * FROM KOZTES";
			$result = $this->conn_public->query($sql);
			if(!$result)	return "Adatbázishiba: 3";

			return $this->printTable($result);
		}

		public function getColorTest()
		{	
			$sql = "SELECT * FROM FELADAT_1 INNER JOIN ROBOT ON FELADAT_1.ID = ROBOT.FELADAT_ID";
			$result = $this->conn_public->query($sql);
			if(!$result)	return "Adatbázishiba: 4";

			return $this->printTable($result);
		}

		public function getChatDatas($live = false)
		{	
		    if($live) 			$tmp = "ORDER BY ID DESC LIMIT 10;";
			else                $tmp = "";
			$sql = "SELECT * FROM CHAT $tmp;";
			$result = $this->conn_public->query($sql);
			if(!$result)	return "Adatbázishiba: 5";

			return $this->printTable($result);
		}

		public function getAnwserDatas($live = false)
		{	
		    if($live) 			$tmp = "LIMIT 10;";
			else                $tmp = "";
			$sql = "SELECT * FROM VALASZ ORDER BY FELADAT DESC, IDO ASC $tmp;";
			$result = $this->conn_public->query($sql);
			if(!$result)	return "Adatbázishiba: 6";

			return $this->printTable($result);
		}

		public function getObservedDatas($live = false)
		{	
		    if($live) 			$tmp = "ORDER BY ID DESC LIMIT 10;";
			else                $tmp = "";
			$sql = "SELECT * FROM ADATGYUJTES $tmp;";
			$result = $this->conn_public->query($sql);
			if(!$result)	return "Adatbázishiba: 7";

			return $this->printTable($result);
		}
		
		public function getSQLQueryDatas($select)
		{
		    $sql = $select;
			$result = $this->conn_public->query($sql);
			if(!$result)	return "Adatbázishiba: 7";

			return $this->printTable($result);
		}


		private function printTable($result)
		{
		    if($result->num_rows == 0) return "<table><tr><td>Ez a tábla üres</td></tr></table>";
			$s = "";
			if($this->html) $s = "<table>";

			//Add table header
			if($this->html) $s .= "<tr>";

			$row = $result->fetch_assoc();
			$columns[] = array_keys($row);

			foreach($columns[0] as $value)
			{
				if($this->html) $s .= "<th>"; 
				$s .= $value;
				if($this->html) $s .= "</th>";
				else            $s .= ";";
			}

			if($this->html) $s .= "</tr>";
			else $s.= "<br>"; 

			//Add content
			do{
				if($this->html) $s .= "<tr>";
				foreach($columns[0] as $value)
				{
					if($this->html) $s .= "<td>";
					$s .= $row[$value];
					if($this->html) $s .= "</td>";
					else            $s .= ";";
				}
				if($this->html) $s .= "</tr>";
				else $s.= "<br>"; 
			}while($row = $result->fetch_assoc());

			if($this->html) $s .= "</table>";
			return $s;
		}

	}


?>
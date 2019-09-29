<?php
	require_once("./essential/antiHackingSystem.php");
	require_once("./essential/connector.php");
	require_once("essential/session_starter.php");

	class liveQuerySystem
	{
		private $conn_public;

		public function __construct()
		{
			$this->conn_public = connector::getConnect();
		}
		
		public function getIncludes($scriptsOn = true)
		{
			require_once('essential/bootstrapIncludes.php');
			echo "<script src='packages/liveQuerySystem/javascript/liveQuerySystem.js'></script>";
			echo "<link rel='stylesheet' type='text/css' href='packages/liveQuerySystem/css/liveQuerySystem.css'>";
		}
		
		public function getMainDiv()
		{
		    $tmp = $this->getQueryData();
		    return "<div id='liveQuerySystem_mainDiv'>$tmp</div>";
		}

        public function getQueryData()
        {
            require_once('packages/dataOutSystem/dataOutSystem.php');
    		$dataOutSystem = new dataOutSystem();
    		
    		$s = "";
    		
    		$s .= $dataOutSystem->getUserDatas();
    		//$s .= $dataOutSystem->getTestDatas();
    		//$s .= $dataOutSystem->getColorTest();
    		$s .= $dataOutSystem->getChatDatas(true);
    		$s .= $dataOutSystem->getAnwserDatas(true);
    		$s .= $dataOutSystem->getObservedDatas(true);
    		if(isset($_GET['liveQuerySystem_select']))  $_SESSION['liveQuerySystem_select'] = $_GET['liveQuerySystem_select'];
    		if(isset($_SESSION['liveQuerySystem_select']) and $_SESSION['liveQuerySystem_select']!= '') $s .= $dataOutSystem->getSQLQueryDatas($_SESSION['liveQuerySystem_select']);
    		return $s;
        }
        
        public function getForm()
        {
            $s = "  <div id='liveQuerySystem_footer'>
                        <form method='get'>
                            <input type='text' placeholder='sqlQuery' name='liveQuerySystem_select'>
                        </form>
                    </div>";
            return $s;
        }
	    
}
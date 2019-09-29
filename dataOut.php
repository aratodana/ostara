<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
	/*
		require_once('packages/dataOutSystem/dataOutSystem.php');
		$dataOutSystem = new dataOutSystem();
		echo $dataOutSystem->getUserDatas();
		echo $dataOutSystem->getTestDatas();
		echo $dataOutSystem->getColorTest();
		//echo $dataOutSystem->getIntro();
		echo $dataOutSystem->getChatDatas();
		echo $dataOutSystem->getAnwserDatas();
		echo $dataOutSystem->getObservedDatas();
	*/
	//=========================================
	/*
	require_once('packages/dataOutSystem/dataOutSystem.php');
    $dataOutSystem = new dataOutSystem();
    $s = "";
    $s .= "<h1>ADATGYUJTES</h1>";
    $s .= $dataOutSystem->getSQLQueryDatas("SELECT * FROM ADATGYUJTES;");
    $s .= "<h1>ADMIN</h1>";
    $s .= $dataOutSystem->getSQLQueryDatas("SELECT * FROM ADMIN;");
    $s .= "<h1>CHAT</h1>";
    $s .= $dataOutSystem->getSQLQueryDatas("SELECT * FROM CHAT;");
    $s .= "<h1>FELADAT_1</h1>";
    $s .= $dataOutSystem->getSQLQueryDatas("SELECT * FROM FELADAT_1;");
    $s .= "<h1>FELHASZNALO</h1>";
    $s .= $dataOutSystem->getSQLQueryDatas("SELECT * FROM FELHASZNALO;");
    $s .= "<h1>KOZTES</h1>";
    $s .= $dataOutSystem->getSQLQueryDatas("SELECT * FROM KOZTES;");
    $s .= "<h1>MUNKAMENET</h1>";
    $s .= $dataOutSystem->getSQLQueryDatas("SELECT * FROM MUNKAMENET;");
    $s .= "<h1>REGISZTRACIOS_KODOK</h1>";
    $s .= $dataOutSystem->getSQLQueryDatas("SELECT * FROM REGISZTRACIOS_KODOK;");
    $s .= "<h1>ROBOT</h1>";
    $s .= $dataOutSystem->getSQLQueryDatas("SELECT * FROM ROBOT;");
    $s .= "<h1>SZOBA</h1>";
    $s .= $dataOutSystem->getSQLQueryDatas("SELECT * FROM SZOBA;");
    $s .= "<h1>VALASZ</h1>";
    $s .= $dataOutSystem->getSQLQueryDatas("SELECT * FROM VALASZ;");
    $s .= "<h1>VÁLTOZÁSOK KERESÉSE</h1>";
    $s .= $dataOutSystem->getSQLQueryDatas("SELECT FELADAT_1.SZOBA, FELADAT_1.ID, REGISZTRACIOS_KODOK.USER_SESSION, REGISZTRACIOS_KODOK.REGKOD, FELHASZNALO.NEV, FELHASZNALO.KOR, FELHASZNALO.ISKOLA, FELHASZNALO.NEME, FELADAT_1.SZOVEG, FELADAT_1.KEP, VALASZ.VALASZTOTT, VALASZ.IDO FROM VALASZ INNER JOIN REGISZTRACIOS_KODOK ON REGISZTRACIOS_KODOK.FELHASZNALO = VALASZ.FELHASZNALO INNER JOIN FELADAT_1 ON FELADAT_1.ID = VALASZ.FELADAT INNER JOIN FELHASZNALO ON FELHASZNALO.ID = VALASZ.FELHASZNALO ORDER BY VALASZ.FELHASZNALO, FELADAT_1.KEP, VALASZ.IDO, FELADAT_1.SZOBA;");
    echo $s
	*/
	?>
</body>
</html>
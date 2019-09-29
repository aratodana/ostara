<?php
	require_once("./essential/antiHackingSystem.php");
	require_once("./essential/connector.php");
	require_once("essential/session_starter.php");
/*
This script created by Arató Dániel
Version: 1.0.0.0
=============================================================================================================
 ______    ______   _______    ________  ______   _________  ______   ______    ______   __  __   ______   _________  ______   ___ __ __     
/_____/\  /_____/\ /______/\  /_______/\/_____/\ /________/\/_____/\ /_____/\  /_____/\ /_/\/_/\ /_____/\ /________/\/_____/\ /__//_//_/\    
\:::_ \ \ \::::_\/_\::::__\/__\__.::._\/\::::_\/_\__.::.__\/\::::_\/_\:::_ \ \ \::::_\/_\ \ \ \ \\::::_\/_\__.::.__\/\::::_\/_\::\| \| \ \   
 \:(_) ) )_\:\/___/\\:\ /____/\  \::\ \  \:\/___/\  \::\ \   \:\/___/\\:(_) ) )_\:\/___/\\:\_\ \ \\:\/___/\  \::\ \   \:\/___/\\:.      \ \  
  \: __ `\ \\::___\/_\:\\_  _\/  _\::\ \__\_::._\:\  \::\ \   \::___\/_\: __ `\ \\_::._\:\\::::_\/ \_::._\:\  \::\ \   \::___\/_\:.\-/\  \ \ 
   \ \ `\ \ \\:\____/\\:\_\ \ \ /__\::\__/\ /____\:\  \::\ \   \:\____/\\ \ `\ \ \ /____\:\ \::\ \   /____\:\  \::\ \   \:\____/\\. \  \  \ \
    \_\/ \_\/ \_____\/ \_____\/ \________\/ \_____\/   \__\/    \_____\/ \_\/ \_\/ \_____\/  \__\/   \_____\/   \__\/    \_____\/ \__\/ \__\/                                                                                                                                                                                                      
=============================================================================================================
	Simple script gives choice to register using a RegistrationCode, and gives back an user and a roomId
	It also manages the login ant the logout functions

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
		- getIncludes()			-	prints the require icludes
		- head()				-	manages the actions, and runs the required script
		- getRegisterForm()		-	returns the register form as string

	Private Members:
		connection $conn_public: 	database connection

	Private Functions:
		- doRegister()			-	makes the register using the serverSide plsql procedure
		- doLogOut()			-	unsets the sessionvaribles, and logs you out

=============================================================================================================
*/
	class registerSystem
	{
		private $conn_public;
		private $error_report;

		public function __construct()
		{
			$this->conn_public = connector::getConnect();
			$this->error_report = "";
		}

		public function getIncludes()
		{
			require_once('essential/bootstrapIncludes.php');
			echo "<link rel='stylesheet' href='packages/registerSystem/css/registerSystem.css'>";
			echo "<script src='packages/registerSystem/javascript/form_confirm.js'></script>";
		}

		public function head()
		{
			if(isset($_POST['registerSystem_form_submit']))		$this->doRegister();
			if(isset($_POST['registerSystem_form_loginSubmit']))		$this->doLogIn();
			if(isset($_GET['registerSystem_doLogOut']))			$this->doLogOut();
		}

		private function doRegister()
		{
			if(!isset($_POST['registerSystem_registerCode']) or !isset($_POST['registerSystem_fullName']) or !isset($_POST['registerSystem_scoolName']) or !isset($_POST['registerSystem_age']) or !isset($_POST['registerSystem_sex'])) {
				$this->addError("Adatmezők üresek");
			};
			$regCode = antiHackingSystem::testString($_POST['registerSystem_registerCode']);
			$fullName = antiHackingSystem::testString($_POST['registerSystem_fullName']);
			$scool = antiHackingSystem::testString($_POST['registerSystem_scoolName']);
			$age = antiHackingSystem::testString($_POST['registerSystem_age']);
			$sex = antiHackingSystem::testString($_POST['registerSystem_sex']);

			$sql = "call doTheUserRegistration('$regCode', '$fullName', $age, '$scool', '$sex');";
			//echo $sql;
			$result = $this->conn_public->query($sql);
			if (!$result)
				{
				    echo $sql;
					$this->addError('Adatbázishiba');
					return false;
				}
			if($result->num_rows == 1)
			{
				$row = $result->fetch_assoc();
				if($row['ID'] != -1)
				{
					$_SESSION['userId'] = $row['ID'];
					$_SESSION['userSession'] = $row['USER_SESSION'];
				}
				else
				{
						$this->addError("Sajnos ez a kód már használatban van");
						return false;
				}
			}
			else
			{
				$this->addError("Adatbázishiba");
				return false;
			}
		}

		public function getRegisterForm()
		{
			return "<div id='registerSystem_registerForm' class='card'>
			<h1>Regisztráció</h1>
			<div id='registerSystem_registerForm_returnText'><ul>$this->error_report</ul></div>
						<form action='' onsubmit='return validateRegisterForm()' method='post'>
							<input type='text' placeholder='Teljes név' name='registerSystem_fullName' id='registerSystem_fullName' class='form-control'>
							<input type='text' placeholder='Kor' name='registerSystem_age' id='registerSystem_age' class='form-control'>
							<input type='text' placeholder='Iskola' name='registerSystem_scoolName' id='registerSystem_scoolName' class='form-control'>
							<input type='text' placeholder='Regisztrációs kód' id='registerSystem_registerCode' name='registerSystem_registerCode' class='form-control'>
							<select name='registerSystem_sex' id='registerSystem_sex' class='form-control'>
								<option value='ferfi'>Férfi</option>
								<option value='no'>Nő</option>
							</select>
							<input type='submit' name='registerSystem_form_submit' value='Indítás' class='form-control'>
						</form>
					</div>";
		}

		public function doLogOut()
		{
			unset($_SESSION['userSession']);
			unset($_SESSION['userId']);
			header('Location: login.php');
		}

		public function isLoggedIn()
		{
			return isset($_SESSION['userSession']) and isset($_SESSION['userId']);
		}

		public function getLoginForm()
		{
			//Beta version
			return "<div id='registerSystem_registerForm' class='card'>
						<h1>Bejelentkezés</h1>
						<p>Only beta</p>
						<div id='registerSystem_loginForm_returnText'><ul>$this->error_report</ul></div>
						<form action='' onsubmit='return validateLoginForm()'method='post'>
							<input type='text' placeholder='Regisztrációs kód' name='registerSystem_registerCode' id='registerSystem_login_registerCode' class='form-control'>
								<input type='password' placeholder='Admin kód' name='registerSystem_adminCode' id='registerSystem_login_adminCode' class='form-control'>
							<input type='submit' name='registerSystem_form_loginSubmit' value='Bejelentkezés' class='form-control'>
						</form>
					</div>";
		}

		private function doLogIn()
		{
			if(!isset($_POST['registerSystem_registerCode']) OR !isset($_POST['registerSystem_adminCode']))
			{
				$this->addError("Adatmezők üresek"); return false;
			}
			$regCode = antiHackingSystem::testString($_POST['registerSystem_registerCode']);
			$fullName = antiHackingSystem::testString($_POST['registerSystem_adminCode']);
			if($fullName=="")
				{
					$this->addError("hiányzó név");
					return false;
				}
			if($regCode=="")
				{
					$this->addError("hiányzó adminkód");
					return false;
				}
			$sql = "call doTheUserLogin('$regCode', '$fullName');";
			//echo $sql;
			 
			//echo $sql;
			$result = $this->conn_public->query($sql);
			if(!$result)
				{
					$this->addError('Adatbázishiba');
					return false;
				}
			if($result->num_rows == 1)
			{
				$row = $result->fetch_assoc();
				if($row['ID'] != -1)
				{
					$_SESSION['userId'] = $row['ID'];
					$_SESSION['userSession'] = $row['USER_SESSION'];
				}
				else
				{
					$this->addError("Sajnos ez a kód már használatban van");
					return false;
				}
			}
			else
			{
				$this->addError('Nincs ilyen regisztrációs kód aktiválva');
				return false;
			}

		}

		private function addError($errorMessage)
		{
			$this->error_report .= "<li>$errorMessage</li>";
		}

	}

?>

	function validateRegisterForm()
	{
		
			var s = "<ul>";
			if(document.getElementById("registerSystem_fullName").value == "")	{
				//$("#registerSystem_fullName").addClass()
				s+= "<li>Teljes név nem lehet üres</li>";
			}
			if(isNaN(document.getElementById("registerSystem_age").value))	{
				//$("#registerSystem_fullName").addClass()
				s+= "<li>Ennek számnak kell lennie</li>";
			}
			if(document.getElementById("registerSystem_scoolName").value == "")	{
				//$("#registerSystem_fullName").addClass()
				s+= "<li>Iskola neve nem lehet üres</li>";
			}
			if(document.getElementById("registerSystem_registerCode").value == "")	{
				//$("#registerSystem_fullName").addClass()
				s+= "<li>Regisztrációs kód nélkül nem léphetsz be</li>";
			}
		
			s += "</ul>";
			document.getElementById('registerSystem_registerForm_returnText').innerHTML = s;
			if(s=="<ul></ul>") 	return true;
			else 				return false;

	}

	function validateLoginForm()
	{
		var s = "<ul>";
		if(document.getElementById("registerSystem_login_registerCode").value == "")	{
			//$("#registerSystem_fullName").addClass()
			s+= "<li>Regisztrációs kód kötelező</li>";
		}
		if(document.getElementById("registerSystem_login_adminCode").value == "")	{
			//$("#registerSystem_fullName").addClass()
			s+= "<li>Admin szükséges a további használathoz</li>";
		}
	
		s += "</ul>";
		document.getElementById('registerSystem_loginForm_returnText').innerHTML = s;
		if(s=="<ul></ul>") 	return true;
		else 				return false;
	}
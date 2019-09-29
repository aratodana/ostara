var mastersSystem_indexOfTest = 0;

function loadNext()
{
	if(mastersSystem_indexOfTest != masterSystem_listOfUrls.length-1)

	mastersSystem_indexOfTest++;
	{
		var tmpURL = masterSystem_listOfUrls[mastersSystem_indexOfTest];
		$("#masterSystem_mainTestContainerBar").load(tmpURL);
		console.log(mastersSystem_indexOfTest / masterSystem_listOfUrls.length * 100);
	}
}



$(document).ready(function(){

	if(mastersSystem_indexOfTest == 0)
	{
		var tmpURL = masterSystem_listOfUrls[0];
		$("#masterSystem_mainTestContainerBar").load(tmpURL);
	}

	$("#masterSystem_footControllerBar_button").click(function() {
 		 loadNext();
	});
});
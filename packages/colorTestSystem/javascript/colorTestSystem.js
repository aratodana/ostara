var colorTestSystem_timeCounter = 0;
var colorTestSystem_testId = 1;
var colorTestSystem_robotList = [
								//	[2, 1, '🤓'],
								//	[4, 2, '🙂'],
								//	[6, 3, '🤓'],
								//	[7, 4, '🙂'],
								//	[8, 5, '🙂']
								];
								//Idő - érték - archetipus
								//Legyen idő szerint rendezve		

function colorTestSystem_mainLoop(feladatId)
{
	colorTestSystem_timeCounter++;
	console.log(colorTestSystem_timeCounter);
	colorTestSystem_addToBar();

	return setTimeout(colorTestSystem_mainLoop, 1000);
}

function colorTestSystem_addToBar()
{
	var s = "";
	for(var i = 0; i < colorTestSystem_robotList.length; i++)
	{
		if(colorTestSystem_robotList[i][0] == colorTestSystem_timeCounter)
		{
			var marginLeft = ((colorTestSystem_robotList[i][1] - 1) * 25);
			s += "<div class='colorTestSystem_picture card' style='margin-left: " + marginLeft +"%'>" + colorTestSystem_robotList[i][2] + "</div>";
			document.getElementById("colorTestSystem_controllContainer_pictures").innerHTML += s;
		}
	}
}

function colorTestSystem_sendAnwser()
{
	var volumeCurrentValue = document.getElementById("colorTestSystem_volume").value;
	var url = "ajax_colorTestSystem_communicationHead.php?colorTestSytem_testId=" + colorTestSystem_testId + "&colorTestSystem_time=" + colorTestSystem_timeCounter + "&colorTestSystem_newTestValue=" + volumeCurrentValue;
	console.log(url);
	$.ajax({url: url });
}


$(document).ready(function(){
	colorTestSystem_mainLoop();

	$( "#colorTestSystem_volume" ).change(function() {
	  colorTestSystem_sendAnwser();
	});
});
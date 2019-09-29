var liveQuerySystem_counter = 0;

function liveQuerySystem_mainLoop()
{
    console.log(liveQuerySystem_counter);
    liveQuerySystem_counter++;
	$("#liveQuerySystem_mainDiv").load( "ajax_liveQuerySystem.php" );
	return setTimeout(liveQuerySystem_mainLoop, 10000);
}


$(document).ready(function(){
	liveQuerySystem_mainLoop();
});
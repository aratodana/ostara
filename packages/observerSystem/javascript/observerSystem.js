var observerSystem_secondCounter = 0;

function observerSystem_InkrementSeconds()
{
	observerSystem_secondCounter++;
	//console.log(observerSystem_secondCounter);
	setTimeout(observerSystem_InkrementSeconds, 1000);
}

$(document).ready(function() {
	 $( ".observerSystem_observedItem" ).click(function(){
	  //alert($(this).attr('id') + " " + $(this).val());
	  var observerSystem_triggerMode = 'click';
	  observerSystem_sendData(observerSystem_triggerMode, this);
	});

	$( ".observerSystem_observedItem" ).mouseover(function(){
	  //alert($(this).attr('id') + " " + $(this).val());
	  var observerSystem_triggerMode = 'onmouseover';
	  observerSystem_sendData(observerSystem_triggerMode, this);
	});
	observerSystem_InkrementSeconds();

});

function observerSystem_sendData(observerSystem_triggerMode, observerSystem_inputField)
{
	var observerSystem_itemId = $(observerSystem_inputField).attr('id');
	var observerSystem_itemValue = $(observerSystem_inputField).val();
	if(observerSystem_itemValue=='') observerSystem_itemValue='undefined'
	var observerSystem_itemPlaceHolder = $(observerSystem_inputField).attr('placeholder');
	var sumOfTextEndOfURL = "observerSystem_triggerMode=" + observerSystem_triggerMode + "&observerSystem_itemId=" + observerSystem_itemId + "&observerSystem_itemValue=" +  observerSystem_itemValue  + "&observerSystem_itemPlaceHolder=" +  observerSystem_itemPlaceHolder + "&observerSystem_seconds="+observerSystem_secondCounter;
	$.ajax({url: "ajax_observerSystem_communicationHead.php?" + sumOfTextEndOfURL });
}
/*
This script created by Arató Dániel
Version: 1.0.0.0
=============================================================================================================
 ______     __  __     ______     ______   ______     __  __     ______     ______   ______     __    __    
/\  ___\   /\ \_\ \   /\  __ \   /\__  _\ /\  ___\   /\ \_\ \   /\  ___\   /\__  _\ /\  ___\   /\ "-./  \   
\ \ \____  \ \  __ \  \ \  __ \  \/_/\ \/ \ \___  \  \ \____ \  \ \___  \  \/_/\ \/ \ \  __\   \ \ \-./\ \  
 \ \_____\  \ \_\ \_\  \ \_\ \_\    \ \_\  \/\_____\  \/\_____\  \/\_____\    \ \_\  \ \_____\  \ \_\ \ \_\ 
  \/_____/   \/_/\/_/   \/_/\/_/     \/_/   \/_____/   \/_____/   \/_____/     \/_/   \/_____/   \/_/  \/_/ 
                                                                                                            
=============================================================================================================
	Simple chatprogram, using async technologie.
=============================================================================================================

	Functions:
		- chatSystem_refressChat()							-		call chatSystem_loadMessages() in evry second
		- chatSystem_loadMessages()							-		async function loads the unread messages using ajax_message.php
		- chatSystem_sendMessage(chatSystem_roomNumber)		- 		sends the data for the ajax_chatSystemCommunicationHead.php using GET as async technolgie

		
=============================================================================================================
*/

var chatSystem_queryCounter = 0;

function chatSystem_refressChat()
{
	if(document.getElementById("chatSystem_AjaxForLoad") == null) return false;
	chatSystem_queryCounter++;
	chatSystem_loadMessages();
	setTimeout(chatSystem_refressChat, 1000);
}

function chatSystem_loadMessages()
{
	$.ajax({url: "ajax_message.php", success: function(result){
		document.getElementById("chatSystem_AjaxForLoad").innerHTML += result;// + document.getElementById("chatSystem_AjaxForLoad").innerHTML;
		if(result!='')		chatSystem_jumpToBottomOfDiv();
	}});
}

function chatSystem_sendMessage(chatSystem_roomNumber)
{
	var message = $('#chatSystem_MessageInput').val();
	if(message !="")
	{
		document.getElementById('chatSystem_MessageInput').value = '';
		$.ajax({url: "ajax_chatSystemCommunicationHead.php?textOfMessage=" + message });	
	}
}


function chatSystem_jumpToBottomOfDiv()
{
	var wtf    = $('#chatSystem_AjaxForLoad');
  	var height = wtf[0].scrollHeight;
  	wtf.scrollTop(height);
}

function chatSystem_replaceEmojiInText()
{
	var tmpText = document.getElementById('chatSystem_MessageInput').value;
	var emojis = [
					[':)', '🙂'],
					[':D', '😀'],
					[';)', '😉'],
					[':(', '😞'],
					[':\'(', '😰'],
					[':O', '😲'],
					[':P', '😛'],
					['#', '']
				];
	for(var i = 0; i < emojis.length; i++)
	{
		tmpText = tmpText.replace(emojis[i][0], emojis[i][1]);
	}
	document.getElementById('chatSystem_MessageInput').value = tmpText;
	console.log(tmpText);
}

$(document).ready(function(){

	chatSystem_jumpToBottomOfDiv();
	chatSystem_refressChat();

   
   $('input').bind("enterKey",function(e){
     chatSystem_replaceEmojiInText();
     chatSystem_sendMessage(1);
   });

    $('input').bind("spaceBar",function(e){
     chatSystem_replaceEmojiInText();
   });

   $('input').keyup(function(e){
     if(e.keyCode == 13)
     {
        $(this).trigger("enterKey");
     }
     if(e.keyCode == 32)
     {
        $(this).trigger("spaceBar");
     }
   });

	$( "p.chatSystem_emojiForInsertTheMessage" ).click(function() {
	  var tmp_containerOfEmoji = $( this ).html();
	  document.getElementById('chatSystem_MessageInput').value += tmp_containerOfEmoji;
	  $("#chatSystem_MessageInput").focus();
	});

});


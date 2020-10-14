<?php
session_start();


if(isset($_POST['ajaxsend']) && $_POST['ajaxsend']==true){
	// Code to save and send chat
	$chat = fopen("chatdata.txt", "a");
	$data="<li>".$_SESSION['email']. " <span style='color:#fff' > "  . $_POST['chat'] . "</span></li> <br>";
	fwrite($chat,$data);
	fclose($chat);

	$chat = fopen("chatdata.txt", "r");
	echo fread($chat,filesize("chatdata.txt"));
	fclose($chat);
} else if(isset($_POST['ajaxget']) && $_POST['ajaxget']==true){
	// Code to send chat history to the user
	$chat = fopen("chatdata.txt", "r");
	echo fread($chat,filesize("chatdata.txt"));
	fclose($chat);
} else if(isset($_POST['ajaxclear']) && $_POST['ajaxclear']==true){
	// Code to clear chat history
	$chat = fopen("chatdata.txt", "w");
	$data="<b>".$_SESSION['email'].'</b> cleared chat<br>';
	fwrite($chat,$data);
	fclose($chat);
}


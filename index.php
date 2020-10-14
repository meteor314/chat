<?php
session_start();
//Create a session of username and logging in the user to the chat room
if(isset($_SESSION['email'])){
	$_SESSION['email']=$_SESSION['email'];
} else 
	header("Location:login.php");

?>
<html>
<head>
	<title>Title Here</title>
	<script type="text/javascript" src="js/jquery-1.10.2.min.js" ></script>
  <script type="text/javascript" src="js/pubnub-3.7.13.min.js" ></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class='header' align='center'>
	<h1 style='color:#fff'>
		Cours
		<?php // Adding the logout link only for logged in users  ?>
		<?php if(isset($_SESSION['userName'])) { ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; Welcome 
			<?php echo $_SESSION['userName'] ?><a class='logout' href="?logout"> Logout</a>

		<?php } ?>
	</h1>
	<a href="log-out.php" class='btn btn-danger'>Se déconnecter</a>

</div>

<div class='main'>
<?php //Check if the user is logged in or not ?>
<?php if(isset($_SESSION['email'])) { ?>
<div id='result' class="chat-thread">
</div>

<div class='chatcontrols'>
	<form method="post" onsubmit="return submitchat();" class='chat-window'>
	<input type='text' name='chat' id='chatbox' autocomplete="off" required placeholder="ENTER CHAT HERE" class='chat-window-message'/>
</form>

<script>
// Javascript function to submit new chat entered by user
function submitchat(){
		if($('#chat').val()=='' || $('#chatbox').val()==' ') return false;
		$.ajax({
			url:'chat.php',
			data:{chat:$('#chatbox').val(),ajaxsend:true},
			method:'post',
			success:function(data){
				$('#result').html(data); // Get the chat records and add it to result div
				$('#chatbox').val(''); //Clear chat box after successful submition

				document.getElementById('result').scrollTop=document.getElementById('result').scrollHeight; // Bring the scrollbar to bottom of the chat resultbox in case of long chatbox
			}
		})
		return false;
};

// Function to continously check the some has submitted any new chat
setInterval(function(){
	$.ajax({
			url:'chat.php',
			data:{ajaxget:true},
			method:'post',
			success:function(data){
				$('#result').html(data);
			}

	})

}
,1000000);


// Function to chat history
$(document).ready(function(){
	$('#clear').click(function(){
		if(!confirm('Are you sure you want to clear chat?'))
			return false;
		$.ajax({
			url:'chat.php',
			data:{userName:"<?php echo $_SESSION['email'] ?>",ajaxclear:true},
			method:'post',
			success:function(data){
				$('#result').html(data);
			}
		})
	})
})
</script>
<?php } else { ?>
<div class='userscreen'>
	<form method="post">
		<input type='text' class='input-user' required placeholder="ENTER YOUR Email HERE" name='useName' />
		<input type='submit' class='btn btn-user' value='START CHAT' />
	</form>
</div>
<?php } ?>

</div>
</div>
<script>
  <?php
  $count = 0;
$myFile = "chatdata.txt";
$fh = fopen($myFile, 'r');
while(!feof($fh)){
    $fr = fread($fh, 8192);
    $count += substr_count($fr, 'br');
}
fclose($fh);
?>
  setInterval(function()
{
  <?php

  $count2 = 0;
$myFile = "chatdata.txt";
$fh = fopen($myFile, 'r');
while(!feof($fh)){
    $fr = fread($fh, 8192);
    $count2 += substr_count($fr, 'br');
}
fclose($fh);
  if($count2<$count) {
    ?>
    alert("under construction");
  
<?php } ?>

}, 3000);
</script>
</body>
<style>
.sidenav {
    height: 500px;
    width: 200px;
    position: fixed;
	z-index: 1;
    top:20%;
    right: 10%;	
    background-color: #111;
    overflow-x: hidden;
    padding-top: 20px;
}

.sidenav a {
    padding: 6px 8px 6px 16px;
    text-decoration: none;
    font-size: 10px;
    color: #818181;
    display: block;
}

.sidenav a:hover {
    color: #f1f1f1;
    font-size: 10px;
}
.sidenav form {
    padding: 6px 8px 6px 16px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
}



/* chat design */
@import "https://fonts.googleapis.com/css?family=Noto+Sans";
body {
  padding: 0;
  margin: 0;
  background: -moz-linear-gradient(-45deg, #183850 0, #183850 25%, #192C46 50%, #22254C 75%, #22254C 100%);
  background: -webkit-linear-gradient(-45deg, #183850 0, #183850 25%, #192C46 50%, #22254C 75%, #22254C 100%);
  background-repeat: no-repeat;
  background-attachment: fixed;
}

::-webkit-scrollbar {
  width: 10px;
}

::-webkit-scrollbar-track {
  border-radius: 10px;
  background-color: rgba(25, 147, 147, 0.1);
}

::-webkit-scrollbar-thumb {
  border-radius: 10px;
  background-color: rgba(25, 147, 147, 0.2);
}

.chat-thread {
  margin: 24px auto 0 auto;
  padding: 0 20px 0 0;
  list-style: none;
  overflow-y: scroll;
  overflow-x: hidden;
}

.chat-thread li {
  position: relative;
  clear: both;
  display: inline-block;
  padding: 16px 40px 16px 20px;
  margin: 0 0 20px 0;
  font: 16px/20px 'Noto Sans', sans-serif;
  border-radius: 10px;
  background-color: rgba(25, 147, 147, 0.2);
}

/* Chat - Avatar */
.chat-thread li:before {
  position: absolute;
  top: 0;
  width: 50px;
  height: 50px;
  border-radius: 50px;
  content: '';
}

/* Chat - Speech Bubble Arrow */
.chat-thread li:after {
  position: absolute;
  top: 15px;
  content: '';
  width: 0;
  height: 0;
  border-top: 15px solid rgba(25, 147, 147, 0.2);
}

.chat-thread li:nth-child(odd) {
  animation: show-chat-odd 0.15s 1 ease-in;
  -moz-animation: show-chat-odd 0.15s 1 ease-in;
  -webkit-animation: show-chat-odd 0.15s 1 ease-in;
  float: right;
  margin-right: 80px;
  color: #0AD5C1;
}

.chat-thread li:nth-child(odd):before {
  right: -80px;
  background-image: url(https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse1.mm.bing.net%2Fth%3Fid%3DOIP.15jfYD9IrqzZqih3ssoYCAHaI4%26pid%3DApi&f=1);
}

.chat-thread li:nth-child(odd):after {
  border-right: 15px solid transparent;
  right: -15px;
}

.chat-thread li:nth-child(even) {
  animation: show-chat-even 0.15s 1 ease-in;
  -moz-animation: show-chat-even 0.15s 1 ease-in;
  -webkit-animation: show-chat-even 0.15s 1 ease-in;
  float: left;
  margin-left: 80px;
  color: #0EC879;
}

.chat-thread li:nth-child(even):before {
  left: -80px;
  background-image: url(https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse1.mm.bing.net%2Fth%3Fid%3DOIP.rilYlEnpfu77JCvEU6lL9wHaFi%26pid%3DApi&f=1);
}

.chat-thread li:nth-child(even):after {
  border-left: 15px solid transparent;
  left: -15px;
}

.chat-window {
  position: fixed;
  bottom: 18px;
}

.chat-window-message {
  width: 100%;
  height: 48px;
  font: 32px/48px 'Noto Sans', sans-serif;
  background: none;
  color: #0AD5C1;
  border: 0;
  border-bottom: 1px solid rgba(25, 147, 147, 0.2);
  outline: none;
}

/* Small screens */
@media all and (max-width: 767px) {
  .chat-thread {
    width: 90%;
    height: 260px;
  }

  .chat-window {
    left: 5%;
    width: 90%;
  }
}
/* Medium and large screens */
@media all and (min-width: 768px) {
  .chat-thread {
    width: 50%;
    height: 320px;
  }

  .chat-window {
    left: 25%;
    width: 50%;
  }
}
@keyframes show-chat-even {
  0% {
    margin-left: -480px;
  }
  100% {
    margin-left: 0;
  }
}
@-moz-keyframes show-chat-even {
  0% {
    margin-left: -480px;
  }
  100% {
    margin-left: 0;
  }
}
@-webkit-keyframes show-chat-even {
  0% {
    margin-left: -480px;
  }
  100% {
    margin-left: 0;
  }
}
@keyframes show-chat-odd {
  0% {
    margin-right: -480px;
  }
  100% {
    margin-right: 0;
  }
}
@-moz-keyframes show-chat-odd {
  0% {
    margin-right: -480px;
  }
  100% {
    margin-right: 0;
  }
}
@-webkit-keyframes show-chat-odd {
  0% {
    margin-right: -480px;
  }
  100% {
    margin-right: 0;
  }
}


</style>
<div class="sidenav">
  <form action="upload.php" method="post" enctype="multipart/form-data">
    Upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload" name="submit">
</form>
<?php
$files = scandir('./uploads');
sort($files); // this does the sorting
foreach($files as $file){
   echo'<a href="uploads/'.$file.'"><br>'.$file.'</a>';
}
?>

</div>


</html>
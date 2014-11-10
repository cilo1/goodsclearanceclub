<?php
session_start();
//include function class
require_once("function.class.php");

//create class object
$func = new func_class();

	if(isset($_SESSION['broker_id'])){
		$brokerID =  $_SESSION['broker_id'];		
		//$account = $func->checkInput($_GET["account"]);		
	}else{
		header("Location: broker_login.php");
	}

//define variables and set value to empty
$email=$title=$msg="";
$email_error=$title_error=$msg_error="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(empty($_POST["email"])){
			$email_error = "<span class='error'>Email is required!</span>";
		}elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
			$email_error = "<span class='error'>Invalid email format</span>"; 
		}else{
			$email=$func->checkInput($_POST["email"]);
		}
		
		if(empty($_POST["title"])){
			$title_error = "<span class='error'>title is required!</span>";
		}elseif(!preg_match("/^[a-zA-Z ]*$/",$_POST["title"])){
			$title_error = "<span class='error'>Only letters and white space allowed</span>";
		}else{			
			$title=$func->checkInput($_POST["title"]);
		}
		
		if(empty($_POST["msg"])){
			$msg_error = "<span class='error'>message is required!</span>";
		}else{			
			$msg=$func->checkInput($_POST["msg"]);
		}
		
		if(empty($email_error) && empty($title_error) && empty($msg_error)){
			
			if($func->submitEnquiry($email, $title, $msg) == true){
				$message = "<span id='success'>Enquiry successfully sent, we will get back to you on your email address!</span><p></p>";
			}
		}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Goods clearance club | customs clearance service</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>
<div class="wrapper">
	
	<header>
		<div id="logo"><img src="img/logo.png"/></div>
		<div id="navbar">
			<ul>
				
			</ul>
		</div>
		<div id="enquiry">
			<a href="broker_enquiry.php">Make Quick Enquiry</a>
		</div>
		<div class="clear"></div>
	</header>
	
	<div class="main_content">
		<div id="mini_menu">
			<ul>
				<li id="backtoprofile"> <a href="brokerageAccount.php">&laquo;Back to my profile</a></li>				
			</ul>
			
		</div>
		<div id="enquiry_form">
			<h2>Make Quick Enquiry</h2>
			<?php echo $message;?>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				<?php  echo $email_error;?>
				<div>Your Email: <input name="email" type="text" value="<?php echo $_SESSION['email'];?>" /></div>
				<?php  echo $title_error;?>
				<div>Title:<input name="title" type="text" /></div>
				<?php  echo $msg_error;?>
				<div>Message:<textArea name="msg" cols="20" rows="5" ></textArea></div>
				<div><input name="submit" type="submit" value="Send"/></div>
			</form>
		</div>
		<div class="clear"></div>
	</div>
	
	<footer>
		<div>&copy; Goods Clearance Club 2014</div>
		<div>Developed and maintained by <a href="http://trascope.com/" target="_blank">trascope solutions</a></div>		
	</footer>
	
</div>

</body>

</html>

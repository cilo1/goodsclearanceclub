<?php 
//include function class
require_once("function.class.php");

//create class object
$func = new func_class();

//define variables and set value to empty
$email=$pwd="";
$email_error=$pwd_error="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(empty($_POST["email"])){
			$email_error = "<span class='error'>Email is required!</span>";
		}elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
			$email_error = "<span class='error'>Invalid email format</span>"; 
		}else{
			$email=$func->checkInput($_POST["email"]);
		}
		
		if(empty($_POST["pwd"])){
			$pwd_error = "<span class='error'>Password is required!</span>";
		}elseif(strlen($_POST["pwd"]) < 4){
			$pwd_error = "<span class='error'>Password length should be more than 4 characters!</span>";
		}else{
			$pwd=$_POST["pwd"];
		}
		
		if(!empty($email) && !empty($pwd)){
			$func->login_user($email,$pwd);
			$message="<div id='message_display'>It seems you do not have an account with us. <a href='signup.php'>Sign up</a> to create an account</div>";
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
				<li><a href="index.php"><img src="img/png/home63.png" id="icons"/>&nbsp;HOME</a></li>
				<li><a href="about.php"><img src="img/png/creative4.png" id="icons"/>&nbsp;WHAT IS <span style="color:#f8323b;">GCC</span>?</a></li>
				<li><a href="contactus.php"><img src="img/png/telephone38.png" id="icons"/>&nbsp;CONTACT US</a></li>
			</ul>
		</div>
		<div id="enquiry">
			<a href="enquiry.php">Make Quick Enquiry</a>
		</div>
		<div class="clear"></div>
	</header>
	
	<div class="main_content">
		<div class="content_top">
		<div id="main_banner">
			<img src="img/shoppingbanner.png"/>			
		</div>
		<div id="login"> 
			<h4>Membership login</h4><?php echo $message;?>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
					<?php echo $email_error;?>
					<div><input name="email" type="text" placeholder="Your email address" /></div>
					<?php echo $pwd_error;?>
					<div><input name="pwd" type="password" placeholder="Your password"/></div>
					<div><input name="submit" type="submit" value="Login"  id="loginBtn"/></div>
				</form>
				<div id="signup_sect">
				<p>To join the club just sign up below</p>
				<div id="signup">
					<a href="signup.php">Sign up</a>
				</div>
				</div>
		</div>		
		<div class="clear"></div>
		<div id="how"><a href="howitworks.php">How Goods Clearance club works, and how brokers compete for business. Read more..</a></div>		
		</div>
		<div class="content_bottom">
			<div id="member"> <a href="freemembershipinfo.php">Free <br/> Membership &raquo;</a></div>
			<div id="brokery"><a href="brokerage.php"> Brokerage bids <br/>& accounts &raquo;</a></div>			
			<div id="import"><a href="importservices.php"> Import <br/>Services &raquo;</a></div>			
			<div id="group"><a href="gcc_conception.php"> GCC<br/>Conception &raquo;</a></div>
			<div class="clear"></div>			
		</div>
		
	</div>
	
	<footer>
		<div>&copy; Goods Clearance Club 2014</div>
		<div>Developed and maintained by <a href="http://trascope.com/" target="_blank">trascope solutions</a></div>		
	</footer>
	
</div>

</body>

</html>

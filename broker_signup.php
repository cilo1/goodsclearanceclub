<?php
//include function class
require_once("function.class.php");

//create class object
$func = new func_class();

//define variables and set value to empty
	$companyName=$companyPerson=$phone=$address=$zip=$email=$website=$pwd=$pwd2=$chbx=$termsStatus="";
	$companyName_error=$companyPerson_error=$phone_error=$address_error=$zip_error=$email_error=$website_error=$pwd_error=$pwd2_error=$chbx_error="";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		if(empty($_POST["companyName"])){
			$companyName_error = "Company name is required!";
		}elseif(!preg_match("/^[a-zA-Z ]*$/",$_POST["companyName"])){
			$companyName_error = "Only letters and white space allowed";
		}else{			
			$companyName=$func->checkInput($_POST["companyName"]);
		}
		
		if(empty($_POST["companyPerson"])){
			$companyPerson_error = "Company contact person is required!";
		}elseif(!preg_match("/^[a-zA-Z ]*$/",$_POST["companyName"])){
			$companyPerson_error = "Only letters and white space allowed";
		}else{			
			$companyPerson=$func->checkInput($_POST["companyPerson"]);
		}
		
		if(empty($_POST["phone"])){
			$phone_error = "Phone number is required!";
		}elseif(! preg_match('/^0\d{9}$/', $_POST["phone"]) && strlen($_POST["phone"]) == 10){
			$phone_error = "Phone number should be 10 digits and no letters allowed!";
		}else{
			$phone=$func->checkInput($_POST["phone"]);
		}
		
		if(empty($_POST["address"])){
			$address_error = "Address is required!";
		}elseif(!preg_match("/^\s*[a-z0-9\s]+$/i",$_POST["address"])){
			$address_error = "Only letters and numbers are allowed!";
		}else{			
			$address = $func->checkInput($_POST["address"]);
		}
		
		if(empty($_POST["zip"])){
			$zip_error = "Zip code is required!";
		}else{			
			$zip = $func->checkInput($_POST["zip"]);
		}
		
		if(empty($_POST["email"])){
			$email_error = "Email is required!";
		}elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
			$email_error = "Invalid email format"; 
		}elseif($func->checkIFEmailExist($_POST["email"]) == true){
			$email_error = "The email is already in use";
		}else{
			$email=$func->checkInput($_POST["email"]);
		}
		
		if (empty($_POST["website"])) {
			$website = "none";
		}elseif (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST["website"])){
			$website_error = "website URL is invalid!";
		}else{
			$website = $func->checkInput($_POST["website"]);
		}
		
		if(empty($_POST["pwd"])){
			$pwd_error = "Password is required!";
		}elseif(strlen($_POST["pwd"]) < 4){
			$pwd_error = "Password length should be more than 4 characters!";
		}elseif($_POST["pwd"] != $_POST["pwd2"]){
			$pwd2_error = "Your passwords do not match!";			
		}else{
			$pwd=$_POST["pwd"];
		}
		
		if(isset($_POST['chckbx'])){			
			$termsStatus = "ok";
		}else{
			$chbx_error = "Read terms and conditions before signingup!";
		}
		
		if(empty($companyName_error) && empty($companyPerson_error)  && empty($phone_error) && empty($address_error) && empty($zip_error) && empty($email_error) && empty($website_error) && empty($pwd_error) && !empty($termsStatus)){
			$userID = $func->addBroker($companyName,$companyPerson, $phone, $address, $zip, $email,$website, $pwd, $termsStatus);
			
			if($userID > 0){
				session_start();
				$_SESSION['email'] = $email;				
				$_SESSION['broker_id'] = $userID;				
				$_SESSION['company_name'] = $companyName;
				header("Location: brokerageAccount.php?account=newAccount");
			}else{
				$message="<div id='message_display'>Your account was not created. Click <a href=''>registration failed</a> to contact the admin.</div>";
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
				<li><a href="index.php"><img src="img/png/home63.png" id="icons"/>&nbsp;HOME</a></li>
				<li><a href=""><img src="img/png/creative4.png" id="icons"/>&nbsp;WHAT IS <span style="color:#f8323b;">GCC</span>?</a></li>
				<li><a href=""><img src="img/png/telephone38.png" id="icons"/>&nbsp;CONTACT US</a></li>
			</ul>
		</div>
		<div id="enquiry">
			<a href="">Make Quick Enquiry</a>
		</div>
		<div class="clear"></div>
	</header>
	
	<div class="main_content">
		<div id="mini_menu">
			<ul>
				<li id="how1"> <a href="howitworks.php">How Goods Clearance club works? how brokers compete for business?&raquo;</a></li>
				<li id="member1"> <a href="freemembershipinfo.php">Free Membership &raquo;</a></li>
				<li id="brokery1"><a href="brokerage.php"> Brokerage bids & accounts &raquo;</a></li>			
				<li id="import1"><a href=""> Import Services &raquo;</a></li>			
				<li id="group1"><a href="gcc_conception.php"> GCC Conception &raquo;</a></li>
			</ul>
			
		</div>
		<div id="broker_det">
			<h2>Broker Signup:</h2>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				<span>All the fields with * are required!</span>
				<span class="error"><?php echo $companyName_error;?></span>
				<div><input name="companyName" type="text" placeholder="*Company name"></div>
				<span class="error"><?php echo $companyPerson_error;?></span>
				<div><input name="companyPerson" type="text" placeholder="*Company contact person"></div>
				<span class="error"><?php echo $phone_error;?></span>
				<div><input name="phone" type="text" placeholder="*Phone"></div>
				<span class="error"><?php echo $address_error;?></span>
				<div><input name="address" type="text" placeholder="*Office Address"></div>
				<span class="error"><?php echo $zip_error;?></span>
				<div><input name="zip" type="text" placeholder="*Postal / Zip code"></div>
				<span class="error"><?php echo $email_error;?></span>
				<div><input name="email" type="text" placeholder="*Email"></div>
				<span class="error"><?php echo $website_error;?></span>
				<div><input name="website" type="text" placeholder="Company website (optional), format www.example.com/"></div>
				<span class="error"><?php echo $pwd_error;?></span>
				<div><input name="pwd" type="password" placeholder="*Password"></div>
				<span class="error"><?php echo $pwd2_error;?></span>
				<div><input name="pwd2" type="password" placeholder="*Confirm password"></div>
				<span class="error"><?php echo $chbx_error;?></span>
				<div><input name="chckbx" type="checkbox" id="checkbox"> <a href="">I have read and understood broker's terms and conditions</a></div>				
				<div><input name="submit" value="SignUp" type="submit" id="agent_loginBtn"></div>
			</form>
			<p>If you already have a broker account, you can <a href="broker_login.php">Login</a> here!</p>
		</div>
		<div class="clear"></div>
	</div>
	
	<footer>
		<div>&copy; Goods Clearance Club 2014</div>
		<div>Developed and maintained by <a href="http://www.trascope.com/" target="_blank">trascope solutions</a></div>		
	</footer>
	
</div>

</body>

</html>

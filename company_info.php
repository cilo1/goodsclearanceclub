<?php
session_start();

//include function class
require_once("function.class.php");

//create class object
$func = new func_class();
	
	if(isset($_SESSION['company_name'])){
		$company = $_SESSION['company_name'];
		$brokerID =  $_SESSION['broker_id'];		
	}else{
		header("Location: broker_login.php");
	}	
	
	if($func->getCompanyDetails($brokerID) == false){
		header("Location: index.php");
	}else{
		$row = $func->getCompanyDetails($brokerID);
		$companyName = $row['company_name'];
		$person = $row['contact_person'];
		$companyLogo = $row['company_logo'];
		$phone = $row['phone'];
		$address = $row['address'];
		$zip = $row['zip'];
		$email = $row['email'];
		$website = $row['website'];
	}
	
	if(isset($_POST['submit'])){
	
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
		
		$broker = $func->checkInput($_POST["broker"]);
		
		if(empty($companyName_error) && empty($companyPerson_error)  && empty($phone_error) && empty($address_error) && empty($zip_error) && empty($email_error) && empty($website_error)){
			
			if($func->updateBrokerCompanyInfoData($broker,$companyName,$companyPerson,$phone,$address,$zip,$email,$website) == true){
				header("Location: companyInfo.php?1");
			}
		}
	}
	
	if(!empty($account) && !empty($user)){
		$message = "<div class='welcome_note'>Hi <span style='text-transform:capitalize;'>".$company."</span> &nbsp;<img src='img/png/emoticon.png' id='icons'/>,<br/> Goods Clearance Club team are happy to have you on board as the #1 member.
		Kindly click the activation link sent to your email to activate your account. Otherwise let us know what you think of the club to make 
		your experience even better!</div>";
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Goods clearance club | customs clearance service</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/design.css">
</head>

<body>
<div class="wrapper">
	
	<header>
		<div id="logo"><img src="img/logo.png"/></div>
		<div id="navbar">
			
		</div>
		<div id="enquiry">
			<a href="broker_enquiry.php">Make Quick Enquiry</a>
		</div>		
		<div class="clear"></div>
	</header>
	
	<div class="main_content">
		<div id="welcome"><?php echo $message;?></div>
		<div id="profile_menu">	
			<div id="home_nav"><img src="img/png/home78.png"/> <a href="brokerageAccount.php">Home</a></div>	
			<div id="brokerlogout"> <a href="broker_logout.php">&rarrb; Logout</a></div>
			<div id="brokerprofile"><a href="companyInfo.php">&hercon; <?php echo $company;?></a></div>
			
		</div>		
		<div class="clear"></div>
		<div id="profile_content">
			<div id="side_bar">
				<ul>
					<li><a href="companyprofile.php">Company profile &raquo;</a><br/><img src="img/png/globe.png" id="icons"/> Clearance number, contacts, Bio, services and rates</li>					
					<li><a href="broker_faqs.php">Frequently asked questions&raquo;</a><br/><img src="img/png/help.png" id="icons"/> FAQs</li>
				</ul>
			</div>		
			<div id="profile_view">
				<div id="top_view">
					<div id="breadcrum">Home &rsaquo;<span id="current"> Company profile</span></div>										
					<div id="bidstatus">Bid status:<span> Available</span></div>
					<div class="clear"></div>					
				</div>			
				<div class="thecompany">
				<h3><?php echo $company;?> company profile</h3>	
					<div id="companyInfo">					
						<div id="companyDisplayd">
						<h4>Company Logo:</h4>
						<?php 
						if(!empty($companyLogo)){
						echo "<img src='company_logos/".$companyLogo."'/>";
						}else{
						echo "<span>Upload company logo!</span>";
						}
						?>
						</div>
						<div id="companyDisplayd">
						<h4>Company contact person:</h4>
						<?php 
						echo $person;?>
						</div>	
						<div id="companyDisplayd">
						<h4>Phone or telephone:</h4>
						<?php 
						echo $phone;?>
						</div>						
						<div id="companyDisplayd">
						<h4>Address & zip code:</h4>
						<?php 
						echo $address."-".$zip;?>
						</div>
						<div id="companyDisplayd">
						<h4>Email address:</h4>
						<?php 
						echo $email;?>
						</div>	
						<div id="companyDisplayd">
						<h4>Company website:</h4>
						<?php 
						echo $website;?>
						</div>	
					</div>
					<div id="company_edit">					
							
							<fieldset>
								<form method="post" action="uploadcompanylogo.php" enctype="multipart/form-data">
								<legend>Upload company logo</legend>
								<input name="file" type="file" accept="image"/>
									<div><input name="submit" type="submit" value="Upload logo" id="addprof"/></div>
								</form>
								
							</fieldset>							
							
							<fieldset>							
							<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<legend>Edit profile details</legend>
							<span class="success"><?php echo $msg;?></span>
								<input name="broker" type="hidden" value="<?php echo $brokerID;?>" />								
								<div>Company name:</div><div><input name="companyName" type="text" value="<?php echo $companyName;?>" />
								<span class="error"><?php echo $companyName_error;?></span>	
								</div>															
								<div>Company contact person:</div><div><input name="companyPerson" type="text" value="<?php echo $person;?>" />
								<span class="error"><?php echo $companyPerson_error;?></span>
								</div>								
								<div>Phone:</div><div><input name="phone" type="text" value="<?php echo $phone;?>" />
								<span class="error"><?php echo $phone_error;?></span>
								</div>								
								<div>Address:</div><div><input name="address" type="text" value="<?php echo $address;?>" />
								<span class="error"><?php echo $address_error;?></span>
								</div>								
								<div>Zip:</div><div><input name="zip" type="text" value="<?php echo $zip;?>" />
								<span class="error"><?php echo $zip_error;?></span>
								</div>								
								<div>Email:</div><div><input name="email" type="text" value="<?php echo $email;?>" />
								<span class="error"><?php echo $email_error;?></span>
								</div>								
								<div>Website:</div><div><input name="website" type="text" value="<?php echo $website;?>" />
								<span class="error"><?php echo $website_error;?></span>
								</div>
								<div><input name="submit" type="submit" value="Edit profile" id="addprof"/></div>
							</form>
							</fieldset>					
						
					</div>
				</div>
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

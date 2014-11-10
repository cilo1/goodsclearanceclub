<?php
session_start();

//include function class
require_once("function.class.php");

//create class object
$func = new func_class();
	
	if(isset($_SESSION['company_name'])){
		$company = $_SESSION['company_name'];
		$account = $func->checkInput($_GET["account"]);	
		$brokerID =  $_SESSION['broker_id'];		
	}else{
		header("Location: broker_login.php");
	}
	
	
	if(!empty($account) && !empty($company)){
		$message = "<div class='welcome_note'>Welcome <span style='text-transform:capitalize;'>".$company."</span> &nbsp;<img src='img/png/emoticon.png' id='icons'/>,<br/> Goods Clearance Club team are happy to have you on board.
		Kindly click the activation link sent to your email to activate your company account!</div>";
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
					<div id="breadcrum">Home &rsaquo;<span id="current"> Service overview</span></div>										
					<div id="bidstatus">Bid status:<span> <?php echo $func->checkBidStatus();?></span></div>
					<div class="clear"></div>					
				</div>					
								
				<div id="broker_home">
					<h3>Service overview</h3>				
					<div>
						<h4>Membership</h4>
						<p>Goods clearance club is a goods clearance club with a number of members who would like to work with your company.
						The broker membership is free and your company will only incur costs when bidding and after you sign a contract with us.
						</p>
						<p>
						For membership you will only have access to editing your company data and access to the bidding portfolio. We encourage you to take part
						in the bidding process to try win the GCC contract.
						</p>
					</div>
					<div>
						<h4>Bidding for service</h4>
						<p>
						For your company to bid for the GCC service, you must ensure you have entered the required company details in your company profile. In addition,
						the bidding process must be open. The process opens up after every 12 months. The selection process is deemed fair as it is decided by all club members.
						<p>Note: For your company to bid, it will be charged a small fee in order for it to be listed.</p>
						</p>
					</div>
					<div>
						<h4>Winning bidder</h4>
						<p>
						The ultimate winner of the contract will be contacted through email at the end of the bidding processes. The companies that fail to qualify, will also be contacted and notified.
						The winner get the opportunity to interact with the club members in forums and address their issues.
						</p>
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

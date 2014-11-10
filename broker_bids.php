<?php
session_start();

//include function class
require_once("function.class.php");

//create class object
$func = new func_class();
	
	if(isset($_SESSION['user'])){
		$user = $_SESSION['user'];
		$account = $func->checkInput($_GET["account"]);		
	}else{
		header("Location: index.php");
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
		<div id="enquiry">
			<a href="">Make Quick Enquiry</a>
		</div>		
		<div class="clear"></div>
	</header>
	
	<div class="main_content">
		<div id="welcome"><?php echo $message;?></div>
		<div id="profile_menu">	
			<div id="home_nav"> <a href="membership.php">&larrb; Home</a></div>	
			<div id="logout"> <a href="logout.php">&rarrb; Logout</a></div>
			<div id="profile"><a href="personalinfo.php">&hercon; <?php echo $user;?></a></div>	
			<div id="prof_img"><img src="profile_img/<?php echo $func->getProfileImg($_SESSION['user_id']);?>"></div>
		</div>			
		<div class="clear"></div>
		<div id="profile_content">
			<div id="side_bar">
				<ul>
					<li><a href="membership.php">Forum &raquo;</a><br/> <img src="img/png/forum.png" id="icons"/> Share your GCC experience & evaluate broker service!</li>
					<li><a href="current_broker.php">Current Broker &raquo;</a><br/><img src="img/png/setting.png" id="icons"/> The customs brokerage company currently contracted by the club.</li>
					<li><a href="broker_bids.php">Broker Bids &raquo;</a><br/><img src="img/png/check34.png" id="icons"/>Be part of broker selection process.</li>
					<li><a href="faq_help.php">Frequently asked questions &raquo;</a><br/><img src="img/png/help.png" id="icons"/> FAQs</li>
				</ul>
			</div>		
			<div id="profile_view">
				<div id="top_view">
					<div id="breadcrum">Home &rsaquo;<span id="current"> Broker bids</span></div>
						
<div class="clear"></div>					
				</div>					
				<h2>Broker bids:<span>Be part of broker selection process</span></h2>
					<div id="listed_companies">
						<div id="comapanyOnList">
							<img src="broker_img/pcbltd-logo.gif"/>
							<div id="broker_name">Pacific Customs Brokers</div>
							<div id="voteLink"><a href="">click to vote/review</a></div>							
						</div>					
						
						<div id="comapanyOnList">
							<img src="broker_img/ccb.gif"/>
							<div id="broker_name">Calgary Customs Brokers</div>
							<div id="voteLink"><a href="">click to vote/review</a></div>							
						</div>
						
						<div id="comapanyOnList">
							<img src="broker_img/ccb_logo.jpg"/>
							<div id="broker_name">Canadian Customs Brokers</div>
							<div id="voteLink"><a href="">click to vote/review</a></div>							
						</div>
						<div class="clear"></div>
					</div>	
					
				<div class="clear"></div>
			</div>
		<div class="clear"></div>			
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

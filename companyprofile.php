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
	
	if($func->getCompanyDetails($brokerID) == false){
		header("Location: index.php");
	}else{
		$row = $func->getCompanyDetails($brokerID);		
		$companyInfoID = $row['company_info_id'];
		$companyName = $row['company_name'];
		$person = $row['contact_person'];
		$companyLogo = $row['company_logo'];
		$phone = $row['phone'];
		$address = $row['address'];
		$zip = $row['zip'];
		$email = $row['email'];
		$website = $row['website'];
	}
	
	
	
	//if(!empty($account) && !empty($user)){
		$message = "<div class='welcome_note'> To be able to compete for the club's bids, you are required to fill your company profile data. 
		This improve your chances of winning the bids!</div>";
	//}
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
		<div id="welcome">
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
					<div id="breadcrum">Home &rsaquo; <span id="current">Company profile</span></div>										
					<div id="bidstatus">Bid status:<span> Available</span></div>
					<div id="company_addBtn"><a href="addcompanyprofile.php">
					<?php
						if($func->checkIfcompanyInfo($brokerID) > 0){
							echo "Edit company info";
						}else{
							echo "Add company info".$companyInfoID;
						}
					?>
					</a></div>
					<div class="clear"></div>					
				</div>			
								
				<div class="thecompany">
					<div id="company_header">
						<div id="company_logo">
						<?php 
						if(!empty($companyLogo)){
						echo "<img src='company_logos/".$companyLogo."'/>";
						}else{
						echo "<span>Logo required!</span>";
						}
						?>
						</div>	
						<div id="company_contacts"><?php echo"
							<p>Company Contact Person: $person,</p>
							<p>Phone: $phone,
							Address: $address,
							Website: $website,			
							</p>					
						";?>
						</div>	
					</div>
					<div id="company_details">
					
						<?php 
						
						if($func->getCompanyInfo($_SESSION['broker_id']) == false){
						?>
						<div id="company_data">
							<h4>Broker clearance number</h4>
							<p>
							<span>*Clearance number required!</span>
							</p>
						</div>
						<div id="company_data">
							<h4>Company bio</h4>
							<p>
								<span>*Company bio required!</span>
							</p>
						</div>	
						<div id="company_data">
							<h4>Services</h4>
							<p>
								<span>*Specify your services!</span>
							</p>
						</div>
						<div id="company_data">
							<h4>Rates</h4>
							<p>
								<span>*Rates are required!</span>
							</p>
						</div>
						<?php 
								}else{							
								$row2 = $func->getCompanyInfo($brokerID);
								echo "
								
									<div id='company_data'>
										<h4>Broker clearance number</h4>
										<p>
										".$row2['clearance_number']."
										</p>
									</div>
									<div id='company_data'>
										<h4>Company bio</h4>
										<p>
										 ".$row2['bio']."
										</p>
									</div>	
									<div id='company_data'>
										<h4>Services</h4>
										<p>
										 <ol>";
										$data = $func->stringIntoListArray($row2['services']);
										foreach($data as $k){
											echo "<li>".$k."</li>";
										}
									echo "</ol>
										</p>
									</div>
									<div id='company_data'>
										<h4>Rates</h4>
										<p>
										 	 <ol>";
										$data = $func->stringIntoListArray($row2['rates']);
										foreach($data as $k){
											echo "<li>".$k."</li>";
										}
									echo "</ol>
										</p>
									</div>
								";
								
								if($func->checkIfcompanyInfo($brokerID)> 0 && $func->checkBidStatus() == "Opened"){
									
									echo "
									<div id='company_data'>
									<h4>Submit company bid</h4>
									<div id='submit_bid_btn'><a href=''>Submit Company Bid</a></div>
									</div>
									";
								}
								
							}
						?>
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

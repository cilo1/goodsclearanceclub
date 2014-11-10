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

	$cl_number=$co_bio=$co_service=$co_rates="";
	$cl_number_error=$co_bio_error=$co_service_error=$co_rates_error=$message = "";
	
	if(isset($_POST['submit'])){
		
		if(empty($_POST["cl_number"])){
			$cl_number_error = "<span class='error'>Clearance number is required!</span>";
		}elseif(!is_numeric($_POST["cl_number"])){
			$cl_number_error = "<span class='error'>no letters and white space allowed</span>";
		}else{			
			$cl_number=$func->checkInput($_POST["cl_number"]);
		}
		
		if(empty($_POST["co_bio"])){
			$co_bio_error = "<span class='error'>Company bio is required!</span>";
		}else{			
			$co_bio=$func->checkInput($_POST["co_bio"]);
		}
		
		if(empty($_POST["co_service"])){
			$co_service_error = "<span class='error'>Services are required!</span>";
		}else{			
			$co_service=$func->checkInput($_POST["co_service"]);
		}
		
		if(empty($_POST["co_rates"])){
			$co_rates_error = "<span class='error'>Rates are required!</span>";
		}else{			
			$co_rates=$func->checkInput($_POST["co_rates"]);
		}
		
		if(empty($cl_number_error) && empty($co_bio_error) && empty($co_service_error) && empty($co_rates_error)){
		
			if($func->addCompanyProfileInfo($_SESSION['broker_id'],$cl_number,$co_bio,$co_service,$co_rates) == true){
				$message = "<span class='success'>Company data updated successfully!</span>";
			}else{
				$message = "<span class='error'>Process failed, data was not added!</span>";
			}		
			
		}
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
					<div id="breadcrum">Home &rsaquo;<span id="current"> add Company info</span></div>										
					<div id="bidstatus">Bid status:<span> Available</span></div>
					<div id="company_addBtn"><a href="companyprofile.php">Company profile</a></div>
					<div class="clear"></div>					
				</div>			
				<?php	
				if($func->checkIfcompanyInfo($brokerID) > 0){
					$row2 = $func->getCompanyInfo($brokerID);
				?>
				<div id="companyprof">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
							<fieldset>
								<legend><?php echo $company;?> company profile</legend>
								<?php echo $cl_number_error;?>
								<div>Clearance number:<input name="cl_number" type="text" value="<?php echo $row2['clearance_number'];?>"/></div>	
								<?php echo $co_bio_error;?>
								<div>Company bio:<textarea name="co_bio" cols="20" rows="10" placeholder="Write your company bio"><?php echo $row2['bio'];?></textarea></div>
								<?php echo $co_service_error;?>
								<div>Your services:<span>*separate each service with # i.e. cargo tracking# warehousing etc..</span>
								<textarea name="co_service" cols="20" rows="10" placeholder="Include your services"><?php echo $row2['services'];?></textarea></div>
								<?php echo $co_rates_error;?>
								<div>Your company rates:<span>*separate each range of rates with # i.e $1-$20 = $5# $21-$50 = 10$# $51 - above = 10%</span>
								<textarea name="co_rates" cols="20" rows="10" placeholder="Your customs clearance rates"><?php echo $row2['rates'];?></textarea></div>								
								<div><input name="submit" type="submit" value="Edit profile" id="addprof"/></div>
							</fieldset>							
						</form>
				</div>
				<?php
				}else{
				?>
				<div id="companyprof">
					<h3></h3>	
						<?php echo $message;?>
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
							<fieldset>
								<legend><?php echo $company;?> company profile</legend>
								<?php echo $cl_number_error;?>
								<div><input name="cl_number" type="text" placeholder="Company clearance number"/></div>	
								<?php echo $co_bio_error;?>
								<div><textarea name="co_bio" cols="20" rows="10" placeholder="Write your company bio"></textarea></div>
								<?php echo $co_service_error;?>
								<div><span>*separate each service with # i.e. cargo tracking# warehousing etc..</span>
								<textarea name="co_service" cols="20" rows="10" placeholder="Include your services"></textarea></div>
								<?php echo $co_rates_error;?>
								<div><span>*separate each range of rates with # i.e $1-$20 = $5# $21-$50 = 10$# $51 - above = 10%</span>
								<textarea name="co_rates" cols="20" rows="10" placeholder="Your customs clearance rates"></textarea></div>								
								<div><input name="submit" type="submit" value="Add profile" id="addprof"/></div>
							</fieldset>							
						</form>
				</div>
				<?php } ?>
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

<?php
class func_class{
	function __construct(){
			
			$this->connect();
	}
		
	function connect(){
			error_reporting(E_ALL ^ E_NOTICE);
			$con = @mysql_connect("localhost", "root", "")or die("Cannot connect to server".mysql_error());			
			mysql_select_db("goodclearanceclub", $con) or die("Cannot find the db ".mysql_error());
	}
	 
	function getCity($cityID){
		$sql="SELECT * FROM city WHERE city_id='$cityID'";
		$query = mysql_query($sql)or die(mysql_error());
		
		$count = mysql_num_rows($query);
		if($count == 1){
			$row = mysql_fetch_array($query);
			return $row['city_name'].", ".$row['city_area'];
		}else{
			return false;
		}
	}
	 
	function checkBidStatus(){
		$sql="SELECT status FROM bid_status";			
		$query = mysql_query($sql)or die(mysql_error());
		$row = mysql_fetch_array($query);
		
		if($row[0] == 0){
			return "Closed";
		}else{
			return "Opened";
		}
	}
	
	function checkInput($data){
		$data = trim($data);//remove white spaces		
		$data = stripslashes($data);//remove slashes
		$data = htmlspecialchars($data);//remove any kind of special characters
		$data = mysql_real_escape_string($data);
		return $data;
	}
	
	function checkIFEmailExist($email){
		$sql="SELECT * FROM users WHERE email = '$email'";			
		$query = mysql_query($sql)or die(mysql_error());
		if(mysql_num_rows($query) != 0){
			return true;
		}			
	}
	
	function checkIfEmailChangedExists($userID, $email){
		
		if($this->checkIFEmailExist($email) == true){
			
			$sql = "SELECT email FROM users WHERE user_id='$userID'";
			$query = mysql_query($sql) or die(mysql_error());
			
			if(mysql_num_rows($query) != 0){
				return false;
			}else{
				return true;
			}
		}
	}
	
	function addUser($fname, $sname, $email, $pwd, $loc){
		$sql = "INSERT INTO users (fname,sname,email,password,location,dateTime) VALUES('$fname','$sname', '$email', '$pwd','$loc',NOW())";			
		mysql_query($sql)or die(mysql_error());
		return mysql_insert_id();
	}
	
	function addBroker($companyName,$companyPerson, $phone, $address, $zip, $email, $website, $pwd, $termsStatus){
		$sql = "INSERT INTO brokers (company_name, contact_person, phone, address, zip, email,website, password, terms, status) VALUES('$companyName','$companyPerson','$phone', '$address', '$zip', '$email','$website', '$pwd', '$termsStatus','0')";			
		mysql_query($sql)or die(mysql_error());
		return mysql_insert_id();
	} 
	
	function login_user($email,$pwd){
		$sql="SELECT * FROM users WHERE email='$email' AND password='$pwd' AND status='1'";
		$query = mysql_query($sql)or die(mysql_error());
			
		$count = mysql_num_rows($query);
			
		if($count == 1){
				
			$row = mysql_fetch_array($query);
				
			session_start();
				
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['user'] = $row['fname']." ".$row['sname'];
			
			header("Location: membership.php");				
		}else{
			return false;
		}
		
	}
	
	function login_broker($email,$pwd){
		$sql="SELECT * FROM brokers WHERE email='$email' AND password='$pwd'";
		$query = mysql_query($sql)or die(mysql_error());
			
		$count = mysql_num_rows($query);
			
		if($count == 1){
				
			$row = mysql_fetch_array($query);
				
			session_start();
				
			$_SESSION['broker_id'] = $row['broker_id'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['company_name'] = $row['company_name'];
			
			header("Location: brokerageAccount.php");				
		}else{
			return false;
		}
		
	}
	
	function submitEnquiry($email, $title, $msg){
		$sql = "INSERT INTO enquiry(sender_email, title, message, dateTime) VALUES('$email','$title','$msg',NOW())";
		return $this->queryMysql($sql);
	}
	
	function getUserDetails($userID){
		$sql="SELECT * FROM users WHERE user_id='$userID'";
		$query = mysql_query($sql)or die(mysql_error());
		
		$count = mysql_num_rows($query);
		if($count == 1){
			return mysql_fetch_array($query);
		}else{
			return false;
		}
	}
	
	function getCompanyDetails($brokerID){
		$sql="SELECT * FROM brokers WHERE broker_id='$brokerID'";
		$query = mysql_query($sql)or die(mysql_error());
		
		$count = mysql_num_rows($query);
		if($count == 1){
			return mysql_fetch_array($query);
		}else{
			return false;
		}
	}
	
	function getCompanyInfo($brokerID){
		$sql="SELECT * FROM company_info WHERE broker_id='$brokerID'";
		$query = mysql_query($sql)or die(mysql_error());
		
		$count = mysql_num_rows($query);
		if($count == 1){
			return mysql_fetch_array($query);
		}else{
			return false;
		}
	}
	function checkIfcompanyInfo($brokerID){
		$sql="SELECT * FROM company_info WHERE broker_id='$brokerID'";
		$query = mysql_query($sql)or die(mysql_error());
		
		return mysql_num_rows($query);
	}
	
	function addCompanyProfileInfo($broker_id,$clearance_number,$company_bio,$company_service,$company_rates){
	
		$company_bio = addslashes($company_bio);
		$company_service = addslashes($company_service);
		$company_rates = addslashes($company_rates);
		
		$sql = "INSERT INTO company_info(broker_id,clearance_number,bio,services,rates) VALUES('$broker_id','$clearance_number','$company_bio','$company_service','$company_rates')";
		
		return $this->queryMysql($sql);
	}
	
	function checkIfAnonymous($userID){
		if(!is_numeric($userID)){
			return true;
		}
	}
	function getUser($userID){
		if($this->checkIfAnonymous($userID) == true){
			return "Anonymous";
		}
		$sql="SELECT * FROM users WHERE user_id='$userID'";
		$query = mysql_query($sql)or die(mysql_error());		
		$count = mysql_num_rows($query);
		
		if($count > 0){
			$row = mysql_fetch_array($query);
			
			return "<span id='userName'>".$row['fname']." ".$row['sname']."</span>";
		}else{
			return "Anonymous";
		}
				
	}
	
	function stringIntoListArray($string){
		return explode('#',$string);		
	}
	
	function getProfileImg($userID){
		$sql="SELECT * FROM users WHERE user_id='$userID'";
		$query = mysql_query($sql)or die(mysql_error());		
		//$count = mysql_num_rows($query);
		$row = mysql_fetch_array($query);
		if($row['prof_img'] == ""){
			
			return "user_icon.jpg";
		}else{			
			return $row['prof_img'];
		}
	}
	function getCompanyProfileImg($brokerID){
		$sql="SELECT * FROM brokers WHERE broker_id='$brokerID'";
		$query = mysql_query($sql)or die(mysql_error());		
		$count = mysql_num_rows($query);
		
		if($count == 1){
			$row = mysql_fetch_array($query);
			//return $row['prof_img'];
		}else{
			return "company_icon.jpg";
		}
	}
	
	function updateProfileImg($userID,$newfilename){
		$sql="UPDATE users SET prof_img = '$newfilename' WHERE user_id='$userID'";
		$query = mysql_query($sql)or die(mysql_error());
		
		if(mysql_affected_rows() == 1){
			return true;
		}else{
			return false;
		}
	}
	function updateCompanyLogo($brokerID,$newfilename){
		$sql="UPDATE brokers SET company_logo = '$newfilename' WHERE broker_id='$brokerID'";
		$query = mysql_query($sql)or die(mysql_error());
		
		if(mysql_affected_rows() == 1){
			return true;
		}else{
			return false;
		}
	}
	
	function updateProfileData($userID,$fn,$sn,$email,$loc){
		$sql="UPDATE users SET fname = '$fn', sname='$sn', email='$email', location='$loc' WHERE user_id='$userID'";
		$query = mysql_query($sql)or die(mysql_error());
		
		if(mysql_affected_rows() == 1){
			return true;
		}else{
			return false;
		}
	}
	
	function updateBrokerCompanyInfoData($brokerID,$companyName,$companyPerson,$phone,$address,$zip,$email,$website){
		$sql="UPDATE brokers SET company_name = '$companyName', contact_person='$companyPerson', phone='$phone', address='$address', zip='$zip', email='$email', website='$website' WHERE broker_id='$brokerID'";
		$query = mysql_query($sql)or die(mysql_error());
		
		if(mysql_affected_rows() == 1){
			return true;
		}else{
			return false;
		}
	}
	
	function postToForum($postedby, $comment){
		$sql = "INSERT INTO comments(postedby,comment, dateTime) VALUES('$postedby', '$comment',NOW())";
		return $this->queryMysql($sql);
	}
	
	function logout(){
		// Initialize the session.
		// If you are using session_name("something"), don't forget it now!
		session_start();

		// Unset all of the session variables.
		$_SESSION = array();

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
			if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
			);
			}

		// Finally, destroy the session.
		session_destroy();
	}
	
	function queryMysql($sql){			
		$query = mysql_query($sql)or die(mysql_error());
		
		if(mysql_affected_rows() == 1){
			return true;
		}else{
			return false;
		}			
	}
	
	function getCommentDetails($commentID){
		$sql = "SELECT * FROM comments WHERE comment_id = '$commentID'";
		$query = mysql_query($sql)or die(mysql_error());
			
		$count = mysql_num_rows($query);
		
		if($count > 0){
			return mysql_fetch_array($query);
		}
	}

	function postReply($userID,$commentID,$reply){
		$sql = "INSERT INTO replies(comment_id, user_id, reply, dateTime) VALUES('$commentID','$userID','$reply',Now())";
		
		return $this->queryMysql($sql);
	}
	
	function getTotalComments($commentID){
		$sql = "SELECT * FROM replies WHERE comment_id = '$commentID'";
		$query = mysql_query($sql)or die(mysql_error());
			
		return mysql_num_rows($query);
	}	
	
	function getTotalMembers(){
		$sql = "SELECT * FROM users";
		$query = mysql_query($sql) or die(mysql_error());
			
		return mysql_num_rows($query);
	}
	
	function getTotalActiveMembers(){
		$sql = "SELECT * FROM users WHERE status = '1'";
		$query = mysql_query($sql) or die(mysql_error());
			
		return mysql_num_rows($query);
	}
	
	function getTotalNotActiveMembers(){
		$sql = "SELECT * FROM users WHERE status = '0'";
		$query = mysql_query($sql) or die(mysql_error());
			
		return mysql_num_rows($query);
	}
	
	function getTotalBrokers(){
		$sql = "SELECT * FROM brokers";
		$query = mysql_query($sql) or die(mysql_error());
			
		return mysql_num_rows($query);
	}
	
	function getTotalEnquiries(){
		$sql = "SELECT * FROM enquiry";
		$query = mysql_query($sql) or die(mysql_error());
			
		return mysql_num_rows($query);
	}

	function deactivateAccount($userID,$userEmail,$reason,$other_reason){
		
		$sql = "INSERT INTO deactivated(userEmail, reason, other_reason, dateTime) VALUES('$userEmail','$reason','$other_reason',NOW())";
		$delete_sql = "DELETE FROM users WHERE user_id='$userID'";
		
		if($this->queryMysql($sql) == true){
			
			$query = mysql_query($delete_sql)or die(mysql_error());
		
			if(mysql_affected_rows() == 1){
				return true;
			}else{
				return false;
			}
		}
	}
	
	function enquiryReplyStatus($status){
		if($status == '0'){
			return "<span id='status'>No reply</span>";
		}else{
			return "<span id='status'>Replied</span>";
		}
	}
	
	function sendEnquiryReply($enqID,$msg){
		
		$sql = "INSERT INTO enquiry_replies(enquiry_id, enquiry_reply, dateTime) VALUES('$enqID','$msg',Now())";
		
		if($this->queryMysql($sql) == true){
			return $this->updateReplyStatus($enqID);
		}
	}
	
	function updateReplyStatus($enqID){
		
		$sql="UPDATE enquiry SET reply_status = '1' WHERE enquiry_id='$enqID'";
		$query = mysql_query($sql)or die(mysql_error());
		
		if(mysql_affected_rows() == 1){
			return true;
		}else{
			return false;
		}
	}
	
	function getSpecificEnquiryData($enqID){
		$sql = "SELECT * FROM enquiry WHERE enquiry_id = '$enqID'";
		$query = mysql_query($sql)or die(mysql_error());
			
		$count = mysql_num_rows($query);
		
		if($count > 0){
			return mysql_fetch_array($query);
		}
	}
	
}
?>

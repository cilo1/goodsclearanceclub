<?php
	//include function class
	require_once("function.class.php");

	//create class object
	$func = new func_class();
	
	$func->logout();
	
	header("Location: broker_login.php");
?>

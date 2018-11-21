<?php session_start(); ?>
<?php
	unset($_SESSION['username']);
	if($_SESSION['username'] != null)
	{
		echo "10";//logout fail
	}
	
?>
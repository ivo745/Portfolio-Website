<?php
	define("SCRIPT_ERROR", "Error occured at line %d, in script %s.");
	define("USER_EXISTS", "User with account name '%s' already exists.");
	define("INPUT_INVALID", "Invalid username '%s' and password '%s'.");
	define("PASSWORD_MISSMATCH", "Password does not match that of account '%s'.");
	define("USER_INVALID", "No account found with username '%s'.");
	define("DB_FAILED_CONNECT", "Database could not establish connection.");
	define("INVALID_IMAGE_TYPE", "Invalid image type '%s'.");
	define("INVALID_UPLOAD_INPUT", "Invalid upload input '%s'.");
	
	function ReportError($errormsg, $arg1, $arg2)
	{
		echo sprintf($errormsg, $arg1, $arg2);
		exit;
	}
?>
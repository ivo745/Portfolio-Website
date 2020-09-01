<?php
	/* Initialize the session */
	session_start();
	
	/* Unset the variables stored in session */
	unset($_SESSION['SESS_USER_ID']);
	unset($_SESSION['SESS_USERNAME']);
	unset($_SESSION['SESS_PASSWORD']);
	
	/* Dealocate session handler */
	session_destroy();
	
	/* Release session data write lock */
	session_write_close();
	
	/* Load home page to prevent showing logout page */
	header('Location: home.php');
?>
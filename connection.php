<?php
	include_once 'ini/db_ini.php';
	include 'ini/error_reporting.php';

	/* Initialize database connection handle */
	$db = mysqli_init();
	
	/* Set database connection SSL parameters*/
	$db->ssl_set('C:/mysqlCerts/client-key.pem', 'C:/mysqlCerts/client-cert.pem', 'C:/mysqlCerts/ca-cert.pem', NULL, NULL);
	
	/* Establish secure connection to database */
	$db->real_connect(HOST, USERNAME, PASSWORD, DATABASE, PORT, NULL, MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);
	
	if (!$db)
	{
		ReportError(DB_FAILED_CONNECT, null, null);
	}
?>
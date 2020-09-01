<?php
	//ob_start(null, 4096);
	session_start();

	function mime2ext($mime)
	{
		$mime_map = [
			'image/gif'       					=> '.gif',
			'image/jpeg'      					=> '.jpeg',
			'image/pjpeg'     					=> '.jpeg',
			'image/png'       					=> '.png',
			'image/x-png'     					=> '.png',
		];
	
		if (isset($mime_map[$mime])) {
			return $mime_map[$mime];
		}
		return false;
	}

	if (isset($_SESSION['SESS_USER_ID'])) {
		if ($_SESSION['SESS_DEVICE_ID'] != $_COOKIE['deviceid']) {
			echo "Unable to authenticate, missing cookie.";
			return;
		}
		$dom = new DomDocument('1.0', 'UTF-8');
		$dom->load('uploads/'.$_SESSION['SESS_USER_ID'].'/filename.xml');
		$root = $dom->documentElement;
		if ($root->nodeName == 'root' && $root->firstChild != null) {
			echo $dom->saveXML();
		}
	}
	else {
		echo "Form empty.";
	}
?>
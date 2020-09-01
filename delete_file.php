<?php
	session_start();
	if ($_SESSION['SESS_DEVICE_ID'] != $_COOKIE["deviceid"]) {
		echo "Unable to authenticate, missing cookie.";
		return;
	}
	if ($_SESSION['SESS_LOCK_BIT'] == 1 || $_SESSION['SESS_LOCK_BIT'] !== 0) {
		return;
	}

	require('connection.php');
	$name = basename($_REQUEST['name']);
	unset($_REQUEST['name']);
	
	if (!$name) {
		$name = $_POST['file_name'];
	}
	
	$uploaddir = 'uploads/'.$_SESSION['SESS_USER_ID'].'/';
	$thumbnail = substr_replace($name, 'c', strrpos($name, '.'), 0);
	
	// Declare query
	$stmt = $db->prepare('DELETE FROM data.uploads WHERE user_id = ? AND name = ? LIMIT 1');
	$escaped_name = $db->real_escape_string($name);
	if ($stmt &&
		$stmt->bind_param('is', $_SESSION['SESS_USER_ID'], $escaped_name) &&
		$stmt->execute() &&
		$stmt->affected_rows == 1) {
			$dom = new DomDocument('1.0', 'UTF-8');
			$filename = $uploaddir.'/filename.xml';
			$dom->load($filename);
			foreach ($dom->getElementsByTagName('div') as $href) {
				if ($href->getAttribute('id') == $name) {
					$href->parentNode->removeChild($href);
				}
			}

			$dom->saveXML();
			$dom->save($filename);
			unlink($uploaddir.$name);
			unlink($uploaddir.$thumbnail);
			unset($_POST['file_name']);
			// Terminate statement handle
	}
	else {
		echo "Error.";
	}
	$stmt->close();
?>
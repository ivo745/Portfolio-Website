<?php
	if (isset($_POST['username'], $_POST['password'], $_POST['deviceid'], ))
	{
		require('connection.php');
		
		// Sanitize and validate the data passed in
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
		$deviceid = filter_input(INPUT_POST, 'deviceid', FILTER_SANITIZE_STRING);

		$username = $db->real_escape_string($username);
		$password = $db->real_escape_string($password);
		$deviceid = $db->real_escape_string($deviceid);

		// Prepare query
		$stmt = $db->prepare('SELECT id, device_id, lock_flag, username, password FROM account_information WHERE username = ? LIMIT 1');
		// Check if account exists
		if ($stmt &&
			$stmt->bind_param('s', $username) &&
			$stmt->execute() &&
			$stmt->store_result() &&
			$stmt->bind_result($db_userid, $db_deviceid, $db_lock_flag, $db_username, $db_password) &&
			$stmt->fetch()) {
				
			// Check if password matches
			if (password_verify($password, $db_password))
			{
				$riskylogin = false;
				$lockflag = 1;

				// Account ownership check
				if ($db_deviceid != $deviceid) {
					$stmt = $db->prepare('UPDATE account_information SET device_id = ?, lock_flag = ? WHERE username = ?');
					if ($stmt &&
						$stmt->bind_param('sss', $deviceid, $lockflag, $username) &&
						$stmt->execute()) {
						$riskylogin = true;
					}
					else {
						echo "error";
						return;
					}
					//echo "Please confirm this is your account. dbid: ".$db_deviceid." id: ".$deviceid;
				}
				session_start();
				session_regenerate_id();
				$_SESSION['SESS_USER_ID'] = $db_userid;
				$_SESSION['SESS_USER_NAME'] = $db_username;
				$_SESSION['SESS_LOCK_BIT'] = $db_lock_flag;
				$_SESSION['SESS_DEVICE_ID'] = $deviceid;
				if ($riskylogin) {
					//header('location: mail_notify_security.php');
				}
				else {
					$structure = 'uploads/'.$_SESSION['SESS_USER_ID'];
					if (!file_exists($structure)) {
						mkdir($structure, 0777, true);
					}
					header('location: home.php');
				}
				session_write_close();
				$stmt->close();
			}
			else {
				echo "Wrong password entered.";
			}
		}
		else {
			echo "Could not find account.";
		}
	}
	else {
		echo "Form empty.";
	}
?>
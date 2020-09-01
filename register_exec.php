<?php
	if (isset($_POST['username'], $_POST['password'], $_POST['deviceid']))
	{
		require('connection.php');
		
		// Sanitize and validate the data passed in
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
		$deviceid = $_POST['deviceid'];

		$username = $db->real_escape_string($username);
		$password = $db->real_escape_string($password);
		
	    if (ctype_alnum($username))
		{
			if (in_array(strlen($username), range(6,32)) && in_array(strlen($password), range(6,32)))
			{
				// Lets add the new user to the database
				$password = password_hash($password, PASSWORD_BCRYPT);
				$stmt = $db->prepare('INSERT INTO account_information (device_id, username, password) VALUES (?, ?, ?)');
				
				/* Create account  */
				if ($stmt &&
					$stmt->bind_param('sss', $deviceid, $username, $password) &&
					$stmt->execute()) {
					session_write_close();
					header('home.php');
					$stmt->close();
				}
				else {
					echo "Error creating account, username '".$username."' already taken.";
				}
			}
			else {
				echo "The username and password have to be between 6 and 32 characters.\n";
			}
		}
		else {
			echo "The string $username does not consist of all letters or digits.\n";
		}
	}
	else {
		echo "Form empty.";
	}
?>
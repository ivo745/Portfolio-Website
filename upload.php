<?php
	if (empty($_SESSION['SESS_USER_ID']) || empty($_POST['upload']) || empty($_FILES['upload']) || $_FILES['upload']['error'] > 0)
	{
		return;
	}

	if (filesize($_FILES['upload']['tmp_name']) >= 5245330){
		return;
	}

	/* Initialize the session */
	session_start();

	function make_thumbnail($img, $max_width)
	{
		$width = imagesx($img);
		$height = imagesy($img);
		
		if (is_null($width) || is_null($height)) {
			return false;
		}
		if ($width > $max_width) {
			if ($width < $max_width) {
				$newwidth = $width;
			}
			else {
				$newwidth = $max_width;	
			}
			$divisor = $width / $newwidth;
			$newheight = floor($height / $divisor);
		}
		else {
			$newwidth = $width;
			$newheight = $height;
		}
		
		// Create a new temporary image.
		$tmpimg = imagecreatetruecolor($newwidth, $newheight);
		
		imagealphablending($tmpimg, false);
		imagesavealpha($tmpimg, true);
		
		// Copy and resize old image into new image.
		imagecopyresampled($tmpimg, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		
		return $tmpimg;
	}

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
	
	function requires_rotation($path)
	{
		if (function_exists('exif_read_data') && $path != null) {
			@$exif = exif_read_data($path);

			if ($exif && is_array($exif)) {
				$exif = array_change_key_case($exif, CASE_LOWER);
				if (array_key_exists('orientation', $exif)) {
					return $exif['orientation'];
				}
			}
		}
		return false;
	}

	function rotate_image($image, $orientation)
	{
		if ($image != null && $orientation != null) {
			switch($orientation) {
				case 8:
					$image = imagerotate($image,90,0);
					break;
				case 3:
					$image = imagerotate($image,180,0);
					break;
				case 6:
					$image = imagerotate($image,-90,0);
					break;
				default:
					break;
			}
			return $image;
		}
		return false;
	}

	/* Compress uploaded image before storing */
    function compress_image($path, $name, $quality)
	{
		// Create temporary image
		if ($path != null && $name != null && $quality != null) {
			$info = getimagesize($path);
	
			$thumb_dest = substr_replace($name, 'c', strrpos($name, '.'), 0);

            switch ($info['mime']) {
                //if is JPG and siblings
                case 'image/jpeg':
                case 'image/pjpeg':
					//Create a new jpg image
					$image = imagecreatefromjpeg($path);
					if ($rotation = requires_rotation($path)) {
						$image = rotate_image($image, $rotation);
					}
					if ($thumbnail = make_thumbnail($image, 430)) {
						imagejpeg($image, $name, $quality);
						imagejpeg($thumbnail, $thumb_dest, $quality);
						imagedestroy($image);
						imagedestroy($thumbnail);
					}
                    break;
                //if is PNG and siblings
                case 'image/png':
                case 'image/x-png':
					$image = imagecreatefrompng($path);
					if ($rotation = requires_rotation($path)) {
						$image = rotate_image($image, $rotation);
					}
					if ($thumbnail = make_thumbnail($image, 430)) {
						imagepng($image, $name, 8);
						imagepng($thumbnail, $thumb_dest, 8);
						imagedestroy($image);
						imagedestroy($thumbnail);
					}
                    break;
                // if is GIF
				case 'image/gif':
					$image = imagecreatefromgif($path);
					if ($rotation = requires_rotation($path)) {
						$image = rotate_image($image, $rotation);
					}
					if ($thumbnail = make_thumbnail($image, 430)) {
						imagegif($image, $name, $quality);
						imagegif($thumbnail, $thumb_dest, $quality);
						imagedestroy($image);
						imagedestroy($thumbnail);
					}
					break;
				default:
					break;
			}
			/*
			Fix rotation of image
			Create a thumbnail with suffix c
			Add the thumbnail and image to file system
			clean up
			*/
			return true;
		}
		return false;
    }

	/* Generates random filename and extension */
	function tempnam_sfx($path, $suffix)
	{
		do {
			$file = $path.mt_rand(111111111111,999999999999).$suffix;
			$fp = @fopen($file, 'x');
		}
		while(!$fp);
	
		fclose($fp);
		return $file;
	}

	function upload_image($userid, $tempname, $oriname, $mime)
	{
		/* Load external code to establish connection */
		require('connection.php');

		/* Declare query */
		$stmt = $db->prepare('INSERT INTO uploads (user_id, name, original_name, mime_type) VALUES (?, ?, ?, ?)');

		if ($stmt &&
			$stmt->bind_param('isss', $userid, $tempname, $oriname, $mime) &&
			$stmt->execute()) {
			//header('Location: portfolio.php');
			$stmt->close();
			return true;
		}
		return false;
	}

	try {
		$success = false;
		/*
		Create extension based on type property of the file
		Generate a random name for the file
		Compress the file and save it
		Upload the data
		*/
		if ($extension = mime2ext($_FILES['upload']['type'])) {
			if ($rand_name = tempnam_sfx('uploads/'.$_SESSION['SESS_USER_ID'].'/', $extension)) {
				$_SESSION['file_name'] = basename($rand_name);
				if (compress_image($_FILES['upload']['tmp_name'], $rand_name, 80)) {
					if (upload_image($_SESSION['SESS_USER_ID'], basename($rand_name), '', $_FILES['upload']['type'])) {
						$success = true;
					}
					else {
						unlink($rand_name);
						unlink(substr_replace($rand_name, 'c', strrpos($rand_name, '.'), 0));
						echo "Failed to upload image.";
					}
				}
				else {
					unlink($rand_name);
					unlink(substr_replace($rand_name, 'c', strrpos($rand_name, '.'), 0));
					echo "failed to compress image."."\n".$_FILES['upload']['tmp_name']."\n".$rand_name;
					print_r($_FILES);
					print(basename($rand_name));
				}
			}
			else {
				echo "Failed to open file.";
			}
		}
		else {
			echo "Invalid upload type.";
		}
	}
	catch (Exception $ex) {
		return $ex->getMessage();
	}
?>
<?php
    header('location: home.php');
    require('connection.php');
    require_once('geo\geoip2.phar');
    session_start();

    use GeoIp2\Database\Reader;

    $reader = new Reader('geo\GeoLite2-City.mmdb');
    $record = $reader->city('80.101.92.106');
    //$record = $reader->city($_SERVER['REMOTE_ADDR']);

	$stmt = $db->prepare('SELECT email FROM account_information WHERE username = ? AND device_id = ? LIMIT 1');
    $name = $_SESSION['SESS_USER_NAME'];
    $deviceid = $_COOKIE['deviceid'];
    
	/* Check if account exists */
	if ($stmt &&
		$stmt->bind_param('ss', $name, $deviceid) &&
		$stmt->execute() &&
		$stmt->store_result() &&
		$stmt->bind_result($db_email) &&
        $stmt->fetch()) {
            
        $to = $db_email;
        $subject = "Your Portfolio-account successful login";
        $message = '
        <div class="rps_bef3">
        <div style="background-color: rgb(238, 238, 238); background-image: none; background-repeat: repeat; background-position: left top; background-attachment: scroll; color: rgb(51, 51, 51); font-family: Helvetica, Arial, sans-serif, serif, EmojiFont; line-height: 1.25;">
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" class="x_body-table">
        <tbody>
        <tr>
        <td align="center" valign="top">
        <table border="0" cellpadding="20" cellspacing="0" width="600" class="x_outer-email-container">
        <tbody>
        <tr>
        <td align="center" valign="top">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="x_inner-email-container" style="background-color:#fff; background-image:none; background-repeat:repeat; background-position:top left; background-attachment:scroll">
        <tbody>
        <tr>
        <td align="center" valign="top">
        <table border="0" cellpadding="0" cellspacing="0" height="1" width="100%" class="x_email-divider">
        <tbody>
        <tr>
        <td align="center" valign="middle" width="249" style="background-color:#eeeeee"></td>
        <td align="center" valign="middle" width="102" style="background-color:#6441a5"></td>
        <td align="center" valign="middle" width="249" style="background-color:#eeeeee"></td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        <tr>
        <td align="center" valign="top">
        <table border="0" cellpadding="0" cellspacing="0" height="1" width="100%" class="x_email-header">
        <tbody>
        <tr>
        <td align="center" valign="middle">
        <div class="x_header-message" style="text-align:center; padding:20px 0 20px 0; font-size:20px; line-height:1.5; width:80%">
        <b>Your Portfolio-account - successful login</b> </div>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        <tr>
        <td align="center" valign="top">
        <table border="0" cellpadding="1" cellspacing="0" height="0" width="100%" class="x_email-body">
        <tbody>
        <tr>
        <td align="center" valign="middle">
        <div class="x_header-message" style="text-align:left; padding:0 0 20px 0; font-size:14px; line-height:1.5; width:80%">
        Dear '.$_SESSION['SESS_USER_NAME'].', </div>
        </td>
        </tr>
        <tr>
        <td align="center" valign="middle">
        <div class="x_header-message" style="text-align:left; padding:0 0 20px 0; font-size:14px; line-height:1.5; width:80%">
        This email is generated because of a new login attempt on '.date("d-M-Y").' '.date("h:i").', originating from:
        </div>
        </td>
        </tr>
        <tr>
        <td align="center" valign="middle">
        <div class="x_header-message" style="text-align:left; padding:0 0 20px 0; font-size:14px; line-height:1.5; width:80%">
        <ul style="list-style-type:none">
        <li><b>Location:</b> '.$record->city->name.', '.$record->mostSpecificSubdivision->name.', '.$record->country->name.'</li><li><b>Device:</b> ' .implode(" ",array($_SERVER['HTTP_USER_AGENT'])).'</li><li><b>Browser:</b> Chrome</li><li><b>IP-address:</b> '.$_SERVER['REMOTE_ADDR'].'</li></ul>
        </div>
        </td>
        </tr>
        <tr>
        <td align="center" valign="middle">
        <div class="x_header-message" style="text-align:left; padding:0 0 20px 0; font-size:14px; line-height:1.5; width:80%">
        If it was you logging in - Don\'t worry! We just wanted to confirm if it was you. </div>
        <div class="x_header-message" style="text-align:left; padding:0 0 20px 0; font-size:14px; line-height:1.5; width:80%">
        If it was not you logging in, then immediately <a href="https://portfolio.test/account.php" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable">
        change your Portfolio-password</a> to secure your account. </div>
        </td>
        </tr>
        <tr>
        <td align="center" valign="middle">
        <div class="x_header-message" style="text-align:left; padding:0 0 20px 0; font-size:14px; line-height:1.5; width:80%">
        For more information regarding suspicion that the account is stolen please visit
        <a href="https://portfolio.test/support.php" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable">
        this support page</a>. </div>
        </td>
        </tr>
        <tr>
        <td align="center" valign="middle">
        <div class="x_header-message" style="text-align:left; padding:0 0 20px 0; font-size:14px; line-height:1.5; width:80%">
        Thank you, <br>
        Portfolio-supportteam </div>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        <tr>
        <td align="center" valign="top">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="x_email-footer" style="color:#7F7F7F; font-size:12px">
        <tbody>
        <tr>
        <td align="center" valign="top">© 2019 Portfolio. All rights reserved. </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </div>
        </div>
        ';
        
        // To send HTML mail, the Content-type header must be set
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html;charset=UTF-8';

        // Additional headers
        $headers[] = 'From: Portfolio <no-reply@portfolio.test>';
        $headers[] = 'Reply-To: <no-reply@portfolio.test>';

        $success = mail($to, $subject, $message, implode("\r\n", $headers));
        if (!$success) {
            print_r(error_get_last()['message']);
         }
    }
    else {
        echo "error.";
    }
?>
<?php
	/* Initialize the session */
	session_start();
	
	if (isset($_SESSION['SESS_USER_ID']))
	{
		header("location: home.php");
		exit();
	}
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <title>Portfolio Login</title>
    <meta name="description" content="Portfolio">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="login/css/style.css" />
    <link rel="stylesheet" type="text/css" href="menu/css/style.css" />
    <?php
			include("menu_options.php")
		?>
</head>

<body>
    <div class="wrapper">
        <div class="polaroid">
            <div class="login-form">
                <h1>Log in</h1>
                <form action="login_exec.php" method="POST" id="submitform" enctype="multipart/form-data">
                    <input type="hidden" id="deviceid" value="" name="deviceid">
                    <input type="text" name="username" placeholder="Username" autocomplete="username"><br />
                    <input type="password" name="password" placeholder="Password" autocomplete="current-password"><br />
                    <input type="submit">
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="login/js/deviceid.js"></script>
</body>
<footer>
    <div class="footer">
        <div class="footerContent">
            <p>© Copyright 2018 Portfolio</p>
        </div>
    </div>
</footer>

</html>
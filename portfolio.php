<?php
	/* Initialize the session */
	session_start();
	
	if (empty($_SESSION['SESS_USER_ID'])) 
	{
		header('Location: login_page.php');
		exit;
    }
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <title>Portfolio Uploads</title>
    <meta name="description" content="Portfolio" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="menu/css/style.css" />
    <link rel="stylesheet" type="text/css" href="portfolio/css/style.css" />
    <script type="text/javascript" src="portfolio/js/delete_file.js"></script>
    <?php
			include('menu_options.php')
	    ?>
</head>

<body>
    <h1>Welcome</h1><br />
    <form name="upload" action="upload.php" method="POST" id="myForm" enctype="multipart/form-data"
        target="hidden_iframe">
        <div id="bar_blank">
            <div id="bar_color"></div>
        </div>
        <div id="status"></div>
        <input type="hidden" value="myForm" name="<?php echo ini_get("session.upload_progress.name"); ?>">
        <input type="file" id="file1" name="upload"><br>
        <input type="submit" name="upload" value="upload">
    </form>
    <?php
			if (isset($_SESSION['SESS_USER_ID']))
			{
				/* Load external code to display uploaded files */
				include('retrieve_file.php');
			}
		?>
    <script type="text/javascript" src="portfolio/js/progress_bar.js"></script>
    <script type="text/javascript" src="portfolio/js/beauty.js"></script>
    <iframe id="hidden_iframe" name="hidden_iframe" src="about:blank"></iframe>
</body>
<footer>
    <div class="footer">
        <div class="footerContent">
            <p>© Copyright 2018 Portfolio</p>
        </div>
    </div>
</footer>

</html>
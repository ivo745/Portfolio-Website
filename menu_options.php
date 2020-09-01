<div class="topnav">
    <div class="navcontent">
        <a href="home.php" class="active" style="text-shadow:rgb(40, 40, 40) 0px 0px">Home</a>
        <a href="">News</a>
        <a href="contact.php">Contact</a>
        <a href="#about">About</a>
        <div style="float:right">
            <?php
				if (isset($_SESSION['SESS_USER_ID']))
				{
					?>
            <a href="portfolio.php">Portfolio</a>
            <a href="logout.php">Logout</a>
            <?php
				}
				else
				{
					?>
            <a href="login_page.php">Login</a>
            <a href="register_page.php">Register</a>
            <?php
				}
			?>
        </div>
    </div>
</div>
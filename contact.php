<?php
	/* Initialize the session */
	session_start();
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <title>Portfolio Uploads</title>
    <meta name="description" content="Portfolio">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="menu/css/style.css" />
    <link rel="stylesheet" type="text/css" href="portfolio/css/style.css" />
    <?php
			include("menu_options.php")
		?>
</head>

<body>
    <div class="wrapper">
        <nav id="iframe">
            <p>
                <iframe title='location' class="iframeee"
                    src="https://maps.google.com/maps?q=arendstraat%2012&t=&z=13&ie=UTF8&iwloc=&output=embed"
                    height=”1200px″ width=”100″></iframe>
            </p>
        </nav>
        <table>
            <tr>
                <td colspan="5">
                    <h4 style="margin: 0px;width: 100%;">Contact gegevens<br />
                        <hr />
                    </h4>
                </td>
                <td></td>
                <td>Ons adres<br />
                    <hr />
                </td>
            </tr>
            <tr>
                <td><strong>Naam: *</strong><br />
                    <form action=""><input type="name" name="name"
                            style="margin: 0px;width: 100%;max-width: 500px; maxlength=" 30" />
                </td>
                <td></td>
                <td style="max-width: 600px;" rowspan="2" colspan="5">
                    <p id="school-green">Telefoons: </p>
                    <p>
                        T 088-0015000<br />
                        F 088-0015111
                    </p>
                </td>
            </tr>
            <tr>

            </tr>
            <tr>
                <td><b>Telefoonnummer:</b><br />
                    <form action=""><input type="number" name="tel" style="margin: 0px;width: 100%;max-width: 500px;"
                            maxlength="30" />
                </td>
                <td></td>
                <td style="max-width: 600px;" rowspan="2" colspan="5">
                    <p id="school-green">School: </p>
                    <p>
                        De Kleine Leeuw<br />
                        Arendstraat 12<br />
                        6135KT Sittard
                    </p>
                </td>
            </tr>
            <tr>
                <td><b>Email: *</b><br />
                    <form action=""><input type="text" name="email"
                            style="margin: 0px;min-width:150; width: 100%;max-width: 500px;" maxlength="30" />
                </td>
            </tr>
            <tr>
                <td style="max-width: 600px;" rowspan="2" colspan="5">
                    <form action="">
                        <b>Notitie*</b><br />
                        <textarea style="margin:0 10 0 0; 0px; min-width:170; height: 75px;max-width: 500;width:100%"
                            name="comments" cols="100" rows="10">Voeg hier uw notitie toe...</textarea>
                    </form>
                </td>
            </tr>
            <tr>
                <td></td>

            </tr>
            <tr>
                <td colspan="7"><input type="submit" value="Submit"></td>

            </tr>
        </table>
    </div>
</body>
<footer>
    <div class="footer">
        <div class="footerContent">
            <p>© Copyright 2018 Portfolio</p>
        </div>
    </div>
</footer>

</html>
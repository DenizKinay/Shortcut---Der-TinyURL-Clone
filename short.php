<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type"
content="text/html; charset=iso-8859-1">
<meta name="robots" content="INDEX,FOLLOW">
<meta name="keywords"
content="">
<meta name="description"
content="" >

<link rel="stylesheet" href="format.css" type="text/css">
</head>
<body >

<table  id="main"  align="center"  cellspacing="0" cellpadding="0" border="0" height="100%" >

<tr>

<td valign="top" width="100%" height="100%">


<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" >
<tr>
<td colspan="2" id="top"  ><!--menü-->
<table  align="right"  id="menu2"   border="0" cellpadding="0" cellspacing="0"    >
<tr>


</tr>
</table>
<!--menü ende--></td>
</tr>
<tr>
<td width="50%" id="sp1b"  valign="top"  height="100%"  >

<table align="center"  height="100%" border="0" cellpadding="0" cellspacing="0" >
<tr>
<td align="center" height="100%" >
<img src="images/02_bild.gif" width="400" height="400" border="0" alt="">
</td>
</tr>
</table>





</td>





<td width="50%"   valign="top" style="cursor:url(images/cur02.gif), pointer !important;cursor:url(images/cur02.ani), pointer" >

<table  height="100%" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td height="100%"  id="sp2">
<div class="backani">
                    <h2 id="headlineb"><img src="images/pointer.gif" width="32" height="17" border="0" alt="">Shortcut 
                      - Der TinyURL Clone</h2>
                    <p>&nbsp;</p>
                    <p align="center">Willkommen bei SHORTCUT!<br>
                    </p>
                    <p align="center"><br>
                      Du m&ouml;chtest deine URL verk&uuml;rzen?<br>
                      Du hast es satt, dir lange URL-Adressen merken zu m&uuml;ssen?<br>
                      Du suchst nach einer schnellen L&ouml;sung? Nach einer Abk&uuml;rzung? 
                      <br>
                      Dann bist du bei SHORTCUT genau richtig!</p>
                    <p align="center">Zeige uns deine URL<br>
                      und du erh&auml;lst einen individuellen Shortcut.<br>
                      V&ouml;llig kosentenlos! Probiere es aus, du wirst begeistert 
                      sein!</p>
                    <p align="center">&nbsp;</p>
                    <p align="center"> 
                      <?php

	$baseurl = 'http://localhost/'; //Adresse des "ersten Parts" der verkürzten URL-Adresse.
	$sql_host = 'localhost'; //Der Host der zu nutzenden mySQL-Datenbank (Standart: "localhost").
	$sql_user = 'dkjekkt'; //Name des mySQL-Users, der den Zugriff zur Datenbank besitzt.
	$sql_pass = 'cosmos'; //Das Passwort für diesen User.
	$sql_db = 'tinyurl'; //Der Name der zu nutzenden mySQL-Datenbank.
	$php_data = 'short.php'; //Das Verzeichnis der Seite mit dem ShortCut-Script.

	$db = mysql_connect($sql_host, $sql_user, $sql_pass);	//Eine Verbindung zur mySQL-Datenbank wird hergestellt.
	mysql_select_db($sql_db, $db);							//Eine Verbindung zur mySQL-Datenbank wird hergestellt.

	echo mysql_error(); //Es wird getestet, ob eine Verbindung zur mySQL-Datenbank hergestellt werden kann.

	
	if(isset($_POST['url']))
	{
		if(filter_var($_POST['url'], FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) !== false)
		{
			$url = mysql_real_escape_string($_POST['url'], $db);
			
			if($result = mysql_query("SELECT `key` FROM `turl` WHERE `url` = '" . $url . "'", $db))
			{//Es wird überprüft, ob die eingetragene URL bereits existiert. Falls ja, wird die URL dafür angezeigt.
				
				if(mysql_num_rows($result) > 0)
				{
					$row = mysql_fetch_row($result);
					$key = $row[0];
					
					echo "Die von dir eingegebene URL<br>["; 
					echo $_POST['url'];
					echo "]<br>wurde bereits von dir oder einem anderen User geshortet.<br><br>";
					
					echo "Der Shortcut für diese URL lautet:<br>";
					echo '<a href="' . $baseurl . $row[0] . '" target="_blank">' . $baseurl . $row[0] . '</a>';
					
					echo "<br><br>Klicke ";
					echo '<a href="' . $baseurl . $php_data .'" target="_blank">HIER</a>';
					echo " um zur vorherigen Seite zurückzukehren<br>
						und um eine weitere URL zu shorten.";
				}
			}
			
			if(!isset($key) && mysql_query("INSERT INTO `turl` (`url`) VALUES ('" . $url . "')", $db))
			{//Existiert die URL noch nicht, so wird sie in die Datenbank gespeichert und die dazugehörige Short-URL wird angezeigt.
				$id = mysql_insert_id($db);
				$key = base_convert($id, 10, 36);
				mysql_query("UPDATE `turl` SET `key` = '" . $key . "' WHERE `id` = '" . $id . "'");

				echo "Herzlichen Glückwunsch!
					<br>Deine URL wurde erfolgreich geshortet!
					<br>Der Shortcut deiner URL lautet:<br>";
				echo '<a href="' . $baseurl . $key . '" target="_blank">' . $baseurl . $key . '</a>';
				
				echo "<br><br>Klicke ";
				echo '<a href="' . $baseurl . $php_data .'" target="_blank">HIER</a>';
				echo " um zur vorherigen Seite zurückzukehren<br>
						und um eine weitere URL zu shorten.";
			}
		}
	}

	if(isset($_GET['k']))
	{
		$k = mysql_real_escape_string($_GET['k'], $db);
		
		if($result = mysql_query("SELECT `url` FROM `turl` WHERE `key` = '" . $k . "'", $db))
		{
			if(mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_row($result);
				header('HTTP/1.1 301 Moved Permanently');
				header('Location: ' . $row[0]);
				exit;
			}
		}
	}
	
	
	{
		?>
                    </p>
                    <form method="post" action="short.php">
                      <div align="center">
                        <label>Trage hier deine URL ein!<br>
                        Beispiel: http://www.shortcut.de/<br>
                        <br>
                        <input type="text" name="url" id="url" />
                        </label>
                        <br />
                        <input type="submit" name="submit" id="submit" value="Shorte meine URL!" />
                      </div>
                    </form>
                    <div align="center"> 
                      <?php
	}
	
?>
                    </div>
                    <hr noshade size="1" >
<br>

                    <div class="textklein">
                      <div align="center"><sup></sup>Dennis Hoelter, Jakob Sudau, 
                        Christina Stenger, Deniz Kinay</div>
                    </div>

</div>




<!-- ende inhalt-->


</td>
</tr>
</table>

</td>



</tr>
<tr>
          <td class="fussb"  >www.shortcut.de</td>
          <td class="fussb"  >HAW Hamburg f&uuml;r Media Systems Projekt 1</td>
</tr>
</table>



</td>
</tr>
</table>












</body>
</html>
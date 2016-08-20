<?php
require_once 'asiakastieto.php';
session_start();

if (isset($_SESSION["asiakastieto"])) {
		$asiakastieto = $_SESSION["asiakastieto"];
	} else {
		header ("location: kaikkiAsiakkaat.php");
		exit();
	}

if (isset ( $_POST ["takaisin"] )) {
	header ( "location: kaikkiAsiakkaat.php" );
	exit ();
} 
?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Asiakastietoportaali</title>
<meta name="author" content="Marita Klaavu">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
<link rel="stylesheet" href="cssmenu/styles.css">
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="cssmenu/script.js"></script>

</head>
<body>
	<div class="container">
		<div id='cssmenu'>
		    <ul>
		        <li class='active'><a href="index.php">Etusivu</a></li>
		        <li><a href="uusiAsiakastieto.php">Lisää asiakas</a></li>
		        <li><a href="kaikkiAsiakkaat.php">Listaa kaikki</a></li>
		        <li><a href="etsiAsiakasJSON.html">Etsi</a></li>
		        <li><a href="asetukset.php">Asetukset</a></li>
		    </ul>
		</div>	

			<br><br>
			<div class="etusivudiv">
				<h1>Asiakastieto</h1>
				<?php 
				//if(isset($_COOKIE["asiakastieto"])) { //keksiin asettamalla objekti pitää serialisoida, jotta sen voi lukea
					//print("<p>Nimi: " . $_COOKIE["asiakastieto"]->getNimi() . "</p>");
				//}
				
				//if(isset($_GET["asiakastieto"])) { //getillä voi hakea vain yhden tiedon
					//print("<p>Nimi: " . $_GET["asiakastieto"]. "</p>");
				//}
				
				print("<p><span><b>Nimi: </b></span>" . $asiakastieto[0]->getNimi()); 
				print("<br><span><b>Katuosoite: </b></span>" . $asiakastieto[0]->getKatuosoite()); 
				print("<br><span><b>Postinumero: </b></span>" . $asiakastieto[0]->getPostinumero()); 
				print("<br><span><b>Postitmp: </b></span>" . $asiakastieto[0]->getPostitmp()); 
				print("<br><span><b>Email: </b></span>" . $asiakastieto[0]->getEmail()); 
				print("<br><span><b>Puhnro: </b></span>" . $asiakastieto[0]->getPuhnro()); 
				print("<br><span><b>Ikä: </b></span>" . $asiakastieto[0]->getIka()); 
				print("<br><span><b>Tavoitteet: </b></span>" . $asiakastieto[0]->getTavoitteet()); 
				print("<br><span><b>Kokemus: </b></span>" . $asiakastieto[0]->getKokemus()); 
				print("<br><span><b>Taajuus: </b></span>" . $asiakastieto[0]->getTaajuus()); 
				print("<br><span><b>Vammat: </b></span>" . $asiakastieto[0]->getVammat()); 
				
				unset($_SESSION["asiakastieto"]);
				session_write_close();
				
				?>
			</div>
			<div class="pure-control-group" style="margin-left: 5em; margin-top:2em">
  				<p>
				<form action="naytaAsiakas.php" method="post"><a href="kaikkiAsiakkaat.php"><input class="pure-button" type="submit" name="takaisin" value="Takaisin"></a>
				</form>
				</p>
			</div>
	</div>
</body>
</html>

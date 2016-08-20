<?php
require_once 'asiakastieto.php';
session_start();

if (isset($_SESSION["asiakastieto"])) {
	$asiakastieto = $_SESSION["asiakastieto"];
} else {
	header ("location: index.php");
	exit();
}

// NAPPULAT
if (isset($_GET["korjaa"])) {
	header ("location: uusiAsiakastieto.php");
	exit();
} elseif (isset($_GET["tyhjenna"])) {
	unset($_SESSION["asiakastieto"]);
	header ( "location: index.php" );
	exit ();
} elseif (isset($_GET["tallenna"])) {
	try {
			require_once 'asiakastietoPDO.php';
			$kanta = new asiakastietoPDO(); // luo yhteyden kantaan
			$id = $kanta->lisaaAsiakastieto($asiakastieto);
			$asiakastieto->setId($id);
			$_SESSION["asiakastieto"]->setId($id);
			
		} catch (Exception $e) {
			print("<p>Virhe: " . $e->getMessage ());
			//header ( "location: virhe.php?sivu=Listaus&virhe=" . $error->getMessage() );
			exit ;
		}
	unset($_SESSION["asiakastieto"]);
	header ( "location: kiitos.php" );
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
		        <li><a href="index.php">Etusivu</a></li>
		        <li><a href="uusiAsiakastieto.php">Lisää asiakas</a></li>
		        <li><a href="kaikkiAsiakkaat.php">Listaa kaikki</a></li>
		        <li><a href="etsiAsiakasJSON.html">Etsi</a></li>
		        <li><a href="asetukset.php">Asetukset</a></li>
		    </ul>
		</div>	

			<br><br>
			<div class="etusivudiv">
				<h1>Uusi asiakastieto</h1>
				<?php 
				print("<p>Nimi: " . $asiakastieto->getNimi()); 
				print("<br>Katuosoite: " . $asiakastieto->getKatuosoite()); 
				print("<br>Postinumero: " . $asiakastieto->getPostinumero()); 
				print("<br>Postitmp: " . $asiakastieto->getPostitmp()); 
				print("<br>Email: " . $asiakastieto->getEmail()); 
				print("<br>Puhnro: " . $asiakastieto->getPuhnro()); 
				print("<br>Ikä: " . $asiakastieto->getIka()); 
				print("<br>Tavoitteet: " . $asiakastieto->getTavoitteet()); 
				print("<br>Kokemus: " . $asiakastieto->getKokemus()); 
				print("<br>Taajuus: " . $asiakastieto->getTaajuus()); 
				print("<br>Vammat: " . $asiakastieto->getVammat()); 
				?>
			</div>
			
			<form>
				<div class="pure-control-group">
	  				<p style="margin-left: 11em">
						<input class="pure-button pure-button-primary" style="background-color:#3db2e1;" type="submit" name="korjaa" value="Korjaa">
						<input class="pure-button pure-button-primary" style="background-color:#3db2e1;" type="submit" name="tallenna" value="Tallenna">  
						<input class="pure-button" type="submit" name="tyhjenna" value="Tyhjennä">
					</p>
				</div>
			</form>
	</div>
</body>
</html>

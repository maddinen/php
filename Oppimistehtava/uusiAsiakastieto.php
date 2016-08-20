<?php
require_once "asiakastieto.php";
//aloitetaan sessio
session_start();

if (isset ( $_POST ["submit"] )) {
	// Luodaan olio lomakekenttien tiedoista
	$asiakastieto = new Asiakastieto($_POST["nimi"], $_POST["katuosoite"], $_POST["postinumero"], $_POST["postitmp"], 
			$_POST["email"], $_POST["puhnro"], $_POST["ika"], $_POST["tavoitteet"], $_POST["kokemus"], $_POST["taajuus"], $_POST["vammat"]);	

	// laitetaan luotu olio sessioon		
	$_SESSION["asiakastieto"] = $asiakastieto;
	session_write_close();

	$nimiVirhe = $asiakastieto->checkNimi();
	$katuosoiteVirhe = $asiakastieto->checkKatuosoite();
	$postinumeroVirhe = $asiakastieto->checkPostinumero();
	$postitmpVirhe = $asiakastieto->checkPostitmp();
	$emailVirhe = $asiakastieto->checkEmail();
	$puhnroVirhe = $asiakastieto->checkPuhnro();
	$ikaVirhe = $asiakastieto->checkIka();
	$tavoitteetVirhe = $asiakastieto->checkTavoitteet();
	$vammatVirhe = $asiakastieto->checkVammat();
	
	//jos ei ole virheitä, käyttäjä siirretään tarkastelemaan tietoja uudella sivulla
	if ($nimiVirhe == 0 && $katuosoiteVirhe == 0 && $postinumeroVirhe == 0 && $postitmpVirhe == 0 && 
	$emailVirhe == 0 && $puhnroVirhe == 0 && $ikaVirhe == 0 && $tavoitteetVirhe == 0 && $vammatVirhe == 0) {
		header ("location: tallennaAsiakas.php");
		exit();
	}
} 
elseif (isset ( $_POST ["peruuta"] )) {
	unset($_SESSION["asiakastieto"]);
	header ( "location: index.php" );
	exit ();
} 
else {
	if (isset($_SESSION["asiakastieto"])) {
		$asiakastieto = $_SESSION["asiakastieto"];
		$nimiVirhe = $asiakastieto->checkNimi();
		$katuosoiteVirhe = $asiakastieto->checkKatuosoite();
		$postinumeroVirhe = $asiakastieto->checkPostinumero();
		$postitmpVirhe = $asiakastieto->checkPostitmp();
		$emailVirhe = $asiakastieto->checkEmail();
		$puhnroVirhe = $asiakastieto->checkPuhnro();
		$ikaVirhe = $asiakastieto->checkIka();
		$tavoitteetVirhe = $asiakastieto->checkTavoitteet();
		$vammatVirhe = $asiakastieto->checkVammat();
	} else {
		// Sivu ladataan ekaa kertaa tai sivulle tulla toiselta sivulta ohjattuna
		// Luo tyhjä olio
		$asiakastieto = new Asiakastieto();
		$nimiVirhe = 0;
		$katuosoiteVirhe = 0;
		$postinumeroVirhe = 0;
		$postitmpVirhe = 0;
		$emailVirhe = 0;
		$puhnroVirhe = 0;
		$ikaVirhe = 0;
		$tavoitteetVirhe = 0;
		$vammatVirhe = 0;
	}
	
	
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
		        <li class='active'><a href="uusiAsiakastieto.php">Lisää asiakas</a></li>
		        <li><a href="kaikkiAsiakkaat.php">Listaa kaikki</a></li>
		        <li><a href="etsiAsiakasJSON.html">Etsi</a></li>
		        <li><a href="asetukset.php">Asetukset</a></li>
		    </ul>
		</div>	

			<br><br>
			<form class="pure-form pure-form-aligned" action="uusiAsiakastieto.php" method="post">
				
					<div class="pure-control-group">
						<label>Nimi <span class="red">*</span></label> <input
							type="text" name="nimi" value="<?php print(htmlentities($asiakastieto->getNimi(), ENT_QUOTES, "UTF-8"));?>">
						<span class="error"><?php print($asiakastieto->getError($nimiVirhe));?></span>	
					</div>
					<div class="pure-control-group">
						<label>Katuosoite <span class="red">*</span></label> <input type="text" name="katuosoite"
							value="<?php print(htmlentities($asiakastieto->getKatuosoite(), ENT_QUOTES, "UTF-8"));?>">
							<span class="error"><?php print($asiakastieto->getError($katuosoiteVirhe));?></span>
					</div>
					<div class="pure-control-group">
						<label>Postinumero <span class="red">*</span></label> <input type="text" name="postinumero"
							value="<?php print(htmlentities($asiakastieto->getPostinumero(), ENT_QUOTES, "UTF-8"));?>">
							<span class="error"><?php print($asiakastieto->getError($postinumeroVirhe));?></span>
					</div>
					<div class="pure-control-group">
						<label>Postitoimipaikka <span class="red">*</span></label> <input type="text" name="postitmp"
							value="<?php print(htmlentities($asiakastieto->getPostitmp(), ENT_QUOTES, "UTF-8"));?>">
							<span class="error"><?php print($asiakastieto->getError($postitmpVirhe));?></span>
					</div>
					<div class="pure-control-group">
						<label>Sähköposti <span class="red">*</span></label> <input
							type="text" name="email" value="<?php print(htmlentities($asiakastieto->getEmail(), ENT_QUOTES, "UTF-8"));?>">
							<span class="error"><?php print($asiakastieto->getError($emailVirhe));?></span>
					</div>
					<div class="pure-control-group">
						<label>Puhelinnumero <span class="red">*</span></label> <input type="text" name="puhnro"
							value="<?php print(htmlentities($asiakastieto->getPuhnro(), ENT_QUOTES, "UTF-8"));?>">
							<span class="error"><?php print($asiakastieto->getError($puhnroVirhe));?></span>
					</div>
					<div class="pure-control-group">
						<label>Ikä <span class="red">*</span></label> <input type="text" name="ika"
							value="<?php print(htmlentities($asiakastieto->getIka(), ENT_QUOTES, "UTF-8"));?>">
							<span class="error"><?php print($asiakastieto->getError($ikaVirhe));?></span>
					</div>
					<div class="pure-control-group">
						<label>Tavoitteet <span class="red">*</span></label>
						<textarea rows="10" name="tavoitteet"><?php print(htmlentities($asiakastieto->getTavoitteet(), ENT_QUOTES, "UTF-8"));?></textarea>
						<span class="error"><?php print($asiakastieto->getError($tavoitteetVirhe));?></span>
					</div>
					<div class="pure-control-group">
						<label>Kokemus </label>
						<textarea rows="10" name="kokemus"><?php print(htmlentities($asiakastieto->getKokemus(), ENT_QUOTES, "UTF-8"));?></textarea>
					</div>
					<div class="pure-control-group">
						<label>Taajuus</label>
						<textarea rows="10" name="taajuus"><?php print(htmlentities($asiakastieto->getTaajuus(), ENT_QUOTES, "UTF-8"));?></textarea>
					</div>
					<div class="pure-control-group">
						<label>Vammat <span class="red">*</span></label>
						<textarea rows="10" name="vammat"><?php print(htmlentities($asiakastieto->getVammat(), ENT_QUOTES, "UTF-8"));?></textarea>
						<span class="error"><?php print($asiakastieto->getError($vammatVirhe));?></span>
					</div>
					<br>
					
  					<div class="pure-control-group">
  					<p style="margin-left: 11em">
						<input class="pure-button pure-button-primary" style="background-color:#3db2e1;" type="submit" name="submit" value="Lähetä"> 
						<input class="pure-button" type="submit" name="peruuta" value="Peruuta">
					</div>
			</form>
	</div>
</body>
</html>

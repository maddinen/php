<?php
require_once "ilmoitus.php";

if (isset ( $_POST ["submit"] )) {
	// Luodaan olio lomakekenttien tiedoista
	$ilmoitus = new Ilmoitus($_POST["nimi"], $_POST["email"], $_POST["puhnro"], $_POST["paikkakunta"], $_POST["tyyppi"],
			 $_POST["otsikko"], $_POST["kuvaus"], $_POST["hinta"]);	
//	print_r($ilmoitus);
	$nimiVirhe = $ilmoitus->checkNimi();
	$hintaVirhe = $ilmoitus->checkHinta();
} 
elseif (isset ( $_POST ["peruuta"] )) {
	header ( "location: index.php" );
	exit ();
} 
else {
	// Sivu ladataan ekaa kertaa tai sivulle tulla toiselta sivulta ohjattuna
	// Luo tyhjä olio
	$ilmoitus = new Ilmoitus();
	$nimiVirhe = 0;
	$hintaVirhe = 0;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Myyntipaikka netissä - osta, myy &amp; vaihda!</title>
<meta name="author" content="Sirpa Marttila">
<link href="ilmoitus.css" rel="stylesheet">
<style type="text/css">
label {
	display: block;
	float: left;
	width: 8em;
}
.error {
	color: red;
}
</style>
</head>
<body>
	<div class="tausta">
		<header> Myyntipaikka netissä </header>
		<nav>
			<ul>
				<li><a href="index.php">Etusivu</a></li>
				<li class="active">Ilmoita</li>
				<li><a href="">Kaikki ilmoitukset</a></li>
				<li><a href="">Hae ilmoitusta</a></li>
			</ul>
		</nav>

		<article>
			<form action="uusiIlmoitus.php" method="post">
				<fieldset>

					<legend>Ilmoittaja</legend>
					<p>
						<label>Nimi <span style="color: #B94A48">*</span></label> <input
							type="text" name="nimi" value="<?php print(htmlentities($ilmoitus->getNimi(), ENT_QUOTES, "UTF-8"));?>">
						<span class="error"><?php print($ilmoitus->getError($nimiVirhe));?></span>	
					</p>

					<p>
						<label>Sähköposti <span style="color: #B94A48">*</span></label> <input
							type="text" name="email" value="<?php print(htmlentities($ilmoitus->getEmail(), ENT_QUOTES, "UTF-8"));?>">
					</p>

					<p>
						<label>Puhelinnumero</label> <input type="text" name="puhnro"
							value="<?php print(htmlentities($ilmoitus->getPuhnro(), ENT_QUOTES, "UTF-8"));?>">
					</p>


					<p>
						<label>Paikkakunta <span style="color: #B94A48">*</span></label> <input
							type="text" name="paikkakunta" value="<?php print(htmlentities($ilmoitus->getPaikkakunta(), ENT_QUOTES, "UTF-8"));?>">
					</p>

				</fieldset>

				<fieldset>

					<legend>Ilmoitus</legend>
					<p>
						<label>Tyyppi</label> <select name="tyyppi">
							<option value="1">Myydään</option>
							<option value="2">Ostetaan</option>
							<option value="3">Vaihdetaan</option>
						</select>
					</p>

					<p>
						<label>Otsikko <span style="color: #B94A48">*</span></label> <input
							type="text" name="otsikko" value="<?php print(htmlentities($ilmoitus->getOtsikko(), ENT_QUOTES, "UTF-8"));?>">
					</p>

					<p>
						<label>Kuvaus</label>
						<textarea rows="10" name="kuvaus"><?php print(htmlentities($ilmoitus->getKuvaus(), ENT_QUOTES, "UTF-8"));?></textarea>
					</p>

					<p>
						<label>Hinta <span style="color: #B94A48">*</span></label> <input
							size="16" type="text" name="hinta" value="<?php print(htmlentities($ilmoitus->getHinta(), ENT_QUOTES, "UTF-8"));?>"> &euro;
						<span class="error"><?php print($ilmoitus->getError($hintaVirhe));?></span>	
					</p>

					<p style="margin-left: 8em">
						<input class="blue" type="submit" name="submit" value="Lähetä"> <input
							class="red" type="submit" name="peruuta" value="Peruuta">
					</p>
				</fieldset>
			</form>
		</article>
	</div>
</body>
</html>

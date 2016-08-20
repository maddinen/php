<?php

if (isset ( $_POST ["submit"] )) {
	$kayttajanimi = $_POST["kayttajanimi"];
	setcookie("kayttajanimi", $kayttajanimi, time() + 60*60*24*7);	
	header("location: index.php");
	exit();
}
if (isset($_COOKIE["kayttajanimi"])) {
	$kayttajanimi = $_COOKIE["kayttajanimi"];
} else {
	$kayttajanimi = "";
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
				<h2>Anna käyttäjänimesi:</h2>
				<form class="pure-form pure-form-aligned" action="asetukset.php" method="post">
					<div class="pure-control-group">
						<input type="text" name="kayttajanimi" 
						value="<?php if(isset($_COOKIE["kayttajanimi"])) { 
							print($_COOKIE["kayttajanimi"]);
						}?>">
						<input class="pure-button pure-button-primary" style="background-color:#3db2e1;" type="submit" name="submit" value="OK"> 
					</div>
				</form>
				<h3><?php if (isset($_COOKIE["kayttajanimi"])) {
					print("Hei " . $_COOKIE["kayttajanimi"] . "!");
					}?>
				</h3>
			</div>
	</div>
</body>
</html>

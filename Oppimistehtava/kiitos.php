
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
				<h1>Kiitos
					<?php if (isset($_COOKIE["kayttajanimi"])) {
					print(" " . $_COOKIE["kayttajanimi"] . "!<br>Tiedot on tallennettu onnistuneesti!");
					} else {
					print("!<br>Tiedot on tallennettu onnistuneesti!");
					}?>
				</h1>	
			</div>
	</div>
</body>
</html>

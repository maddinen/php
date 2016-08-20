<?php 
// NAPPULAT

require_once "asiakastietoPDO.php";
session_start(); //aloitetaan sessio

if (isset ( $_POST ["nayta"] )) {
	try {
		$kanta = new asiakastietoPDO(); // luo yhteyden kantaan
		$_SESSION["asiakastieto"] = $kanta->etsiAsiakas($_POST["id"]);
		session_write_close();
	} catch (Exception $e) {
		print("<p>Virhe: " . $e->getMessage ());
	}
	header ("location: naytaAsiakas.php");
	exit();
	
} elseif (isset($_POST["poista"])) {
	try {
			$kanta = new asiakastietoPDO(); // luo yhteyden kantaan
			$asiakastieto = $kanta->poistaAsiakas($_POST["id"]);
			
		} catch (Exception $e) {
			print("<p>Virhe: " . $e->getMessage ());
			//header ( "location: virhe.php?sivu=Listaus&virhe=" . $error->getMessage() );
			exit ;
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
		        <li><a href="uusiAsiakastieto.php">Lisää asiakas</a></li>
		        <li><a href="kaikkiAsiakkaat.php">Listaa kaikki</a></li>
		        <li><a href="etsiAsiakasJSON.html">Etsi</a></li>
		        <li><a href="asetukset.php">Asetukset</a></li>
		    </ul>
		</div>	

			<br><br>
			<div class="listadiv">
				<?php
				try {
					require_once "asiakastietoPDO.php";
					
					$kanta = new asiakastietoPDO();  // Luo yhteyden kantaan
					
					$tulos = $kanta->kaikkiAsiakkaat(); // Haetaan kannasta kaikki rivit
					
					
					print("<table style='margin-left:5em'>");
					print("<tr>");
					print("<td><b><span>Nimi</b></span></td>");
					print("<td><b><span>Tavoitteet</b></span></td>");
					print("<td></td>");
					print("<td></td>");
					print("<td></td>");
					print("</tr>");
					foreach ($tulos as $asiakastieto) {
						print("<form action='kaikkiAsiakkaat.php' method='post'>");
						print("<tr>");
						print("<td>" . $asiakastieto->getNimi() . "</td>");
						print("<td>" . $asiakastieto->getTavoitteet() . "</td>");
						  print("<td><input type='hidden' name='id' value='" . $asiakastieto->getId() . "'></td>");
						  print("<td><input class='pure-button pure-button-primary' style='background-color:#3db2e1;' type='submit' name='nayta' value='Näytä'></td>");
						  print("<td><input class='pure-button' type='submit' name='poista' value='Poista'></td>");
						print("<tr>");
						print("</form>");
					}
					print("</table>");
					
	
				} catch ( Exception $error ) {
					print("<p>Virhe: " . $error->getMessage ());
					exit ();
				}
				?>
			</div>
	</div>
</body>
</html>

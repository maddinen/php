<?php
try {
	require_once 'asiakastietoPDO.php';
	$asiakastietoPDO = new asiakastietoPDO();
	
	if (isset($_GET["etsi"])) {
		$tulos = $asiakastietoPDO->etsiAsiakas($_GET["etsi"]);
		print(json_encode($tulos));
	} else {
		$tulos = $asiakastietoPDO->kaikkiAsiakkaat();
		print(json_encode($tulos));
	}
	
} catch (Exception $e) {
	$tulos["message"] = "Haku ei onnistu";
	http_response_code(400);
	print(json_encode($tulos));
}
?>
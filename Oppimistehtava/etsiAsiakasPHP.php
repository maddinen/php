<?php
require_once("asiakastietoPDO.php");
$kanta = new asiakastietoPDO();
if(!empty($_POST["hakusana"])) {
$sql ="SELECT nimi, tavoitteet FROM asiakas WHERE nimi like '" . $_POST["hakusana"] . "%' ORDER BY nimi";
$tulos = $asiakastietoPDO->ajaLause($sql);
if(!empty($tulos)) {
?>
<ul id="asiakasLista">
<?php
foreach($tulos as $asiakastieto) {
?>
<li onClick="etsiAsiakas('<?php echo $asiakastieto["nimi"]; ?>');"><?php echo $asiakastieto["nimi"]; ?></li>
<?php } ?>
</ul>
<?php } } ?>
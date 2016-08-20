<?php
require_once "asiakastieto.php";

class asiakastietoPDO {
	private $db;
	
	function __construct($dsn = "mysql:host=localhost;dbname=a1500882a", $user = "root", $password = "salainen") {
		// Ota yhteys kantaan
		$this->db = new PDO ( $dsn, $user, $password );
		
		// Virheiden jäljitys kehitysaikana
		$this->db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
		
		// MySQL injection estoon (paramerit sidotaan PHP:ssä ennen SQL-palvelimelle lähettämistä)
		$this->db->setAttribute ( PDO::ATTR_EMULATE_PREPARES, false );
	}
	
	public function kaikkiAsiakkaat() {
		$sql = "SELECT id, nimi, katuosoite, postinumero, postitmp, email, puhnro, ika, tavoitteet, kokemus, taajuus, vammat
		        FROM asiakas";
		
		// Valmistellaan lause
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Ajetaan lauseke
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Käsittellään hakulausekkeen tulos
		$tulos = array ();
		
		// Pyydetään haun tuloksista kukin rivi kerrallaan
		while ( $row = $stmt->fetchObject () ) {
			// Tehdään tietokannasta haetusta rivistä leffa-luokan olio
			$asiakastieto = new Asiakastieto();
			
			$asiakastieto->setId ( $row->id );
			$asiakastieto->setNimi ( utf8_encode ( $row->nimi ) );
			$asiakastieto->setKatuosoite ( utf8_encode ( $row->katuosoite ) );
			$asiakastieto->setPostinumero ( utf8_encode ( $row->postinumero ) );
			$asiakastieto->setPostitmp ( $row->postitmp );
			$asiakastieto->setEmail ( utf8_encode ( $row->email ) );
			$asiakastieto->setPuhnro ( utf8_encode ( $row->puhnro ) );
			$asiakastieto->setIka ( utf8_encode ( $row->ika ) );
			$asiakastieto->setTavoitteet ( utf8_encode ( $row->tavoitteet ) );
			$asiakastieto->setKokemus ( utf8_encode ( $row->kokemus ) );
			$asiakastieto->setTaajuus ( utf8_encode ( $row->taajuus ) );
			$asiakastieto->setVammat ( utf8_encode ( $row->vammat ) );
			
			// Laitetaan olio tulos taulukkoon (olio-taulukkoon)
			$tulos [] = $asiakastieto;
		}
		
		$this->lkm = $stmt->rowCount ();
		
		return $tulos;
	}
	
	public function etsiAsiakas($id) {
		$sql = "SELECT id, nimi, katuosoite, postinumero, postitmp, email, puhnro, ika, tavoitteet, kokemus, taajuus, vammat
		        FROM asiakas
				WHERE id = :id";
		
		// Valmistellaan lause, prepare on PDO-luokan metodeja
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Sidotaan parametrit
		$stmt->bindValue ( ":id", $id, PDO::PARAM_INT );
		
		// Ajetaan lauseke
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Käsittellään hakulausekkeen tulos
		$tulos = array ();
		
		while ( $row = $stmt->fetchObject () ) {
			// Tehdään tietokannasta haetusta rivistä leffa-luokan olio
			$asiakastieto = new Asiakastieto ();
			
			$asiakastieto->setId ( $row->id );
			$asiakastieto->setNimi ( utf8_encode ( $row->nimi ) );
			$asiakastieto->setKatuosoite ( utf8_encode ( $row->katuosoite ) );
			$asiakastieto->setPostinumero ( utf8_encode ( $row->postinumero ) );
			$asiakastieto->setPostitmp ( $row->postitmp );
			$asiakastieto->setEmail ( utf8_encode ( $row->email ) );
			$asiakastieto->setPuhnro ( utf8_encode ( $row->puhnro ) );
			$asiakastieto->setIka ( utf8_encode ( $row->ika ) );
			$asiakastieto->setTavoitteet ( utf8_encode ( $row->tavoitteet ) );
			$asiakastieto->setKokemus ( utf8_encode ( $row->kokemus ) );
			$asiakastieto->setTaajuus ( utf8_encode ( $row->taajuus ) );
			$asiakastieto->setVammat ( utf8_encode ( $row->vammat ) );
			
			// Laitetaan olio tulos taulukkoon (olio-taulukkoon)
			$tulos [] = $asiakastieto;
		}
		return $tulos;
	}
	
	function lisaaAsiakastieto($asiakastieto) {
		$sql = "insert into asiakas (nimi, katuosoite, postinumero, postitmp, email, puhnro, ika, tavoitteet, kokemus, taajuus, vammat)
		        values (:nimi, :katuosoite, :postinumero, :postitmp, :email, :puhnro, :ika, :tavoitteet, :kokemus, :taajuus, :vammat)";
		
		// Valmistellaan SQL-lause
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Parametrien sidonta
		$stmt->bindValue ( ":nimi", utf8_decode ( $asiakastieto->getNimi() ), PDO::PARAM_STR );
		$stmt->bindValue ( ":katuosoite", utf8_decode ( $asiakastieto->getKatuosoite() ), PDO::PARAM_STR );
		$stmt->bindValue ( ":postinumero", utf8_decode ( $asiakastieto->getPostinumero() ), PDO::PARAM_STR );
		$stmt->bindValue ( ":postitmp", utf8_decode ( $asiakastieto->getPostitmp() ), PDO::PARAM_STR );
		$stmt->bindValue ( ":email", utf8_decode ( $asiakastieto->getEmail() ), PDO::PARAM_STR );
		$stmt->bindValue ( ":puhnro", utf8_decode ( $asiakastieto->getPuhnro() ), PDO::PARAM_STR );
		$stmt->bindValue ( ":ika", $asiakastieto->getIka(), PDO::PARAM_INT );
		$stmt->bindValue ( ":tavoitteet", utf8_decode ( $asiakastieto->getTavoitteet() ), PDO::PARAM_STR );
		$stmt->bindValue ( ":kokemus", utf8_decode ( $asiakastieto->getKokemus() ), PDO::PARAM_STR );
		$stmt->bindValue ( ":taajuus", utf8_decode ( $asiakastieto->getTaajuus() ), PDO::PARAM_STR );
		$stmt->bindValue ( ":vammat", utf8_decode ( $asiakastieto->getVammat() ), PDO::PARAM_STR );
		
		// Jotta id:n saa lisäyksestä, täytyy laittaa tapahtumankäsittely päälle
		$this->db->beginTransaction();
		
		// Suoritetaan SQL-lause (insert)
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			 
			// Perutaan tapahtuma
			$this->db->rollBack();
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// id täytyy ottaa talteen ennen tapahtuman päättymistä
		$id = $this->db->lastInsertId ();
		
		$this->db->commit();
		
		// Palautetaan lisätyn ilmoituksen id
		return $id;
	}
	
	public function poistaAsiakas($id) {
		$sql = "DELETE FROM asiakas WHERE id = :id";
		
		// Valmistellaan lause, prepare on PDO-luokan metodeja
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Sidotaan parametrit
		$stmt->bindValue ( ":id", $id, PDO::PARAM_INT );
		
		// Ajetaan lauseke
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}	
	}
	
	public function ajaLause($sql){
		$tulos = mysql_query($sql);
		while($rivi=mysql_fetch_assoc($tulos)) {
			$resultset[] = $rivi;
		}
		if(!empty($resultset))
		return $resultset;
	}
	
}
?>
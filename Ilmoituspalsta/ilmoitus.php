<?php
class Ilmoitus {
	// Virhekoodeja vastaavat virheilmoitukset
	private static $virhelista = array (
			- 1 => "Tuntematon virhe",
			0 => "",
			11 => "Nimi ei voi olla tyhjä",
			12 => "Nimessä tulee olla vain kirjaimia",
			13 => "Nimessä on liian vähän merkkejä",
			14 => "Nimessä on liikaa merkkejä",
			21 => "Sähköpostiosoite ei voi olla tyhjä",
			22 => "Tarkasta sähköpostiosoitteen oikeellisuus",
			31 => "Tarkasta puhelinnumeron oikeellisuus",
			41 => "Paikkakunta ei voi olla tyhjä",
			42 => "Paikkakunnassa ei voi olla numeroita",
			51 => "Otsikko ei voi olla tyhjä",
			52 => "Otsikossa on liian vähän tai liikaa kirjaimia",
			53 => "Otsikossa on kiellettyjä merkkejä",
			61 => "Kuvaus ei voi olla tyhjä",
			62 => "Kuvauksessa on liian vähän kirjaimia",
			63 => "Kuvaus on liian pitkä",
			64 => "Kuvauksessa on kiellettyjä kirjaimia",
			70 => "Hinta on pakollinen",
			71 => "Hinta on virheellinen",
			72 => "Hinta on liian pieni",
			73 => "Hinta on liian suuri"
	);

	// Kertoo virhekoodia vastaavan virhetekstin
	public static function getError($virhekoodi) {
		if (isset ( self::$virhelista [$virhekoodi] ))
			return self::$virhelista [$virhekoodi];

		return self::$virhelista [- 1];
	}

	// Luokan attribuutit
	private $nimi;
	private $email;
	private $puhnro;
	private $paikkakunta;
	private $tyyppi;
	private $otsikko;
	private $kuvaus;
	private $hinta;
	private $id;

	// Konstruktori

	// $ilmoitus = new Ilmoitus(" Sirpa ", "sirpa.marttila@haaga-helia.fi");
	// $ilmoitus = new Ilmoitus();
	function __construct($nimi = "", $email = "", $puhnro = "", $paikkakunta = "", $tyyppi = "", $otsikko = "", $kuvaus = "", $hinta = 0, $id = 0) {
		$this->nimi = trim ( mb_convert_case ( $nimi, MB_CASE_TITLE, "UTF-8" ) );
		$this->email = trim ( $email );
		$this->puhnro = trim ( $puhnro );
		$this->paikkakunta = trim ( mb_convert_case ( $paikkakunta, MB_CASE_TITLE, "UTF-8" ) );
		$this->tyyppi = $tyyppi;
		$this->otsikko = trim ( mb_convert_case ( $otsikko, MB_CASE_TITLE, "UTF-8" ) );
		$this->kuvaus = trim ( $kuvaus );
		$this->hinta = trim ( $hinta );
		$this->id = $id;
	}

	public function setNimi($nimi) {
		$this->nimi = trim ( $nimi );
	}

	public function getNimi() {
		return $this->nimi;
	}

	public function checkNimi($required = true, $min = 3, $max = 50) {
		// Jos saa olla tyhjä ja on tyhjä
		if ($required == false && strlen ( $this->nimi ) == 0) {
			return 0;
		}

		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->nimi ) == 0) {
			return 11;
		}

		// Jos nimen muoto ei ole oikea
		if (preg_match ( "/[^a-zåäöA-ZÅÄÖ\- ]/", $this->nimi )) {
			return 12;
		}

		// Jos nimi on liian lyhyt
		if (strlen ( $this->nimi) < $min) {
			return 13;
		}

		// Jos nimi on liian pitkä
		if (strlen ( $this->nimi ) > $max) {
			return 14;
		}

		// Kentässä ei ole virhettä
		return 0;
	}

	// Email
	public function setEmail($email) {
		$this->email = trim ( $email );
	}

	public function getEmail() {
		return $this->email;
	}

	public function checkEmail($required = true) {
		return 0;
	}

	public function setPuhnro($puhnro) {
		$this->puhnro = trim ( $puhnro );
	}

	public function getPuhnro() {
		return $this->puhnro;
	}

	public function checkPuhnro($empty = true, $min = 8, $max = 15) {
		return 0;
	}

	public function setPaikkakunta($paikkakunta) {
		$this->paikkakunta = trim ( $paikkakunta );
	}

	public function getPaikkakunta() {
		return $this->paikkakunta;
	}

	public function checkPaikkakunta($required = true) {
		// Jos saa olla tyhjä ja on tyhjä
		if ($required == false && strlen ( $this->paikkakunta ) == 0) {
			return 0;
		}

		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->paikkakunta ) == 0) {
			return 41;
		}

		// Jos muoto ei ole oikea


		// Kentässä ei ole virhettä
		return 0;
	}


	public function setTyyppi($tyyppi) {
		$this->tyyppi = trim ( $tyyppi );
	}

	public function getTyyppi() {
		return $this->tyyppi;
	}

	public function checkTyyppi($required = true) {
		return 0;
	}

	public function setOtsikko($otsikko) {
		$this->otsikko = trim ( $otsikko );
	}

	public function getOtsikko() {
		return $this->otsikko;
	}

	public function checkOtsikko($required = true, $min = 2, $max = 100) {
		return 0;
	}

	public function setKuvaus($kuvaus) {
		$this->kuvaus = trim ( $kuvaus );
	}

	public function getKuvaus() {
		return $this->kuvaus;
	}

	public function checkKuvaus($required = true, $min = 3, $max = 1000) {
		if ($required == false && strlen ( $this->kuvaus ) == 0) {
			return 0;
		}

		if ($required == true && strlen ( $this->kuvaus ) == 0) {
			return 61;
		}

		if (strlen ( $this->kuvaus ) < $min) {
			return 62;
		}

		if (strlen ( $this->kuvaus ) > $max) {
			return 63;
		}

		return 0;
	}

	public function setHinta($hinta) {
		$this->hinta = trim ( $hinta );
	}

	public function getHinta() {
		return $this->hinta;
	}

	// $hintaVirhe = $ilmoitus->checkHinta();
	public function checkHinta($required = true, $min = 0.0, $max = 100000.0) {

		// Jos saa olla tyhjä ja on tyhjä
		if ($required == false && strlen ( $this->hinta ) == 0) {
			return 0;
		}

		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->hinta ) == 0) {
			return 70;
		}

		// Jos hinnan muoto ei ole oikea
		if (! preg_match("/^(-)?\d+(\.\d{2})?$/", $this->hinta)) {
			return 71;
		}

		// Jos hinta on liian pieni
 		if ($this->hinta < $min) {
 			return 72;
 		}

		// Jos hinta on liian suuri
 		if ($this->hinta > $max) {
 			return 73;
 		}

		return 0;
	}

	public function setId($id) {
		$this->id = trim ( $id );
	}

	public function getId() {
		return $this->id;
	}
}
?>
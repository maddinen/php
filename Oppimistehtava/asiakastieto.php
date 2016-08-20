<?php
class Asiakastieto implements JsonSerializable {
	// Virhekoodeja vastaavat virheilmoitukset
	private static $virhelista = array (
			- 1 => "Tuntematon virhe",
	
			0 => "",
			11 => "Nimi ei voi olla tyhjä",
			12 => "Nimessä tulee olla vain kirjaimia",
			13 => "Nimessä on liian vähän merkkejä",
			14 => "Nimessä on liikaa merkkejä",
			
			21 => "Katuosoite ei voi olla tyhjä",
			22 => "Tarkasta katuosoitteen oikeellisuus",
			
			31 => "Postinumero ei voi olla tyhjä",
			32 => "Tarkasta postinumeron oikeellisuus",
			33 => "Postinumero voi olla vain pääkaupunkiseudun alueelta",
			
			41 => "Postitoimipaikka ei voi olla tyhjä",
			42 => "Postitoimipaikka voi olla vain pääkaupunkiseudun alueelta",
			
			51 => "Sähköpostiosoite ei voi olla tyhjä",
			52 => "Tarkasta sähköpostiosoitteen oikeellisuus",
			
			61 => "Tarkasta puhelinnumeron oikeellisuus",
			
			71 => "Ikä ei voi olla tyhjä",
			72 => "Asiakkaan tulee olla yli 18-vuotias",
			
			81 => "Tavoitteet ei voi olla tyhjä",
			82 => "Tavoitteissa on liian vähän merkkejä",
			83 => "Tavoitteissa on liikaa merkkejä (max 1000)",
			84 => "Tavoitteet -kentässä ei voi olla erikoismerkkejä (_@#$%^&*;\/|<>)",
			
			91 => "Vammat ei voi olla tyhjä",
			92 => "Vammoissa on liian vähän merkkejä",
			93 => "Vammoissa on liikaa merkkejä (max 1000)",
			94 => "Vammat -kentässä ei voi olla erikoismerkkejä (_@#$%^&*;\/|<>)"
	);

	// Kertoo virhekoodia vastaavan virhetekstin
	public static function getError($virhekoodi) {
		if (isset ( self::$virhelista [$virhekoodi] ))
			return self::$virhelista [$virhekoodi];

		return self::$virhelista [- 1];
	}

	// Luokan attribuutit
	private $nimi;
	private $katuosoite;
	private $postinumero;
	private $postitmp;
	private $email;
	private $puhnro;
	private $ika;
	private $tavoitteet;
	private $kokemus;
	private $taajuus;
	private $vammat;
	private $id;
	

	public function jsonSerialize() {
		return array
		(
			"nimi" => $this->nimi,
			"katuosoite" => $this->katuosoite,
			"postinumero" => $this->postinumero,
			"postitmp" => $this->postitmp,
			"email" => $this->email,
			"puhnro" => $this->puhnro,
			"ika" => $this->ika,
			"tavoitteet" => $this->tavoitteet,
			"kokemus" => $this->kokemus,
			"taajuus" => $this->taajuus,
			"vammat" => $this->vammat,
			"id" => $this->id
		);
	}
	

	// Konstruktori
	function __construct($nimi = "", $katuosoite = "", $postinumero = "", $postitmp = "", $email = "", 
	$puhnro = "", $ika = "", $tavoitteet = "", $kokemus = "", $taajuus = "", $vammat = "", $raskaus = "", $id = 0) {
		$this->nimi = trim ( mb_convert_case ( $nimi, MB_CASE_TITLE, "UTF-8" ) );
		$this->katuosoite = trim ( mb_convert_case ( $katuosoite, MB_CASE_TITLE, "UTF-8" ) );
		$this->postinumero = trim ( $postinumero );
		$this->postitmp = trim ( mb_convert_case ( $postitmp, MB_CASE_TITLE, "UTF-8" ) );
		$this->email = trim ( $email );
		$this->puhnro = trim ( $puhnro );
		$this->ika = trim ( $ika );
		$this->tavoitteet = trim ( $tavoitteet );
		$this->kokemus = trim ( $kokemus );
		$this->taajuus = trim ( $taajuus );
		$this->vammat = trim ( $vammat );
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
	
	// Katuosoite
	public function setKatuosoite($katuosoite) {
		$this->katuosoite = trim ( $katuosoite );
	}
	
	public function getKatuosoite() {
		return $this->katuosoite;
	}
	
	public function checkKatuosoite($required = true, $min = 5, $max = 100) {
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->katuosoite ) == 0) {
			return 21;
		}
		// Katuosoitteessa tulee olla sana, väli, ja tämän jälkeen numeroita (a-z) ja kirjaimia
		if (!preg_match ( "/[a-zåäöA-ZÅÄÖ\-]+[ ][a-zA-z1-9 ]+/", $this->katuosoite )) {
			return 22;
		}
		// Kentässä ei ole virhettä
		return 0;
	}
	
	// Postinumero
	public function setPostinumero($postinumero) {
		$this->postinumero = trim ( $postinumero );
	}
	
	public function getPostinumero() {
		return $this->postinumero;
	}
	
	public function checkPostinumero($required = true) {
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->postinumero ) == 0) {
			return 31;
		}
		
		// Jos postinumeron muoto ei ole oikea
		if (!preg_match ( "/^\d{5}$/", $this->postinumero )) {
			return 32;
		}
		// Jos postinumero ei ole pääkaupunkiseudulta
		if (!preg_match ( "/[0][0-2][0-9]{3}/", $this->postinumero )) {
			return 33;
		}
		if (preg_match( "/^011|^018|^019|^024|^025|^026|^027|^0288/", $this->postinumero)) {
			return 33;
		}
		// Kentässä ei ole virhettä
		return 0;
	}
	
	// Postitmp
	public function setPostitmp($postitmp) {
		$this->postitmp = trim ( $postitmp );
	}

	public function getPostitmp() {
		return $this->postitmp;
	}

	public function checkPostitmp($required = true) {
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->postitmp ) == 0) {
			return 41;
		}

		// Jos postitoimipaikka ei ole pääkaupunkiseudulta
		if (!preg_match ( "/Helsinki|Vantaa|Espoo/", $this->postitmp )) {
			return 42;
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
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->email ) == 0) {
			return 51;
		}
		
		// Jos email ei ole oikeanlainen
		if (!preg_match ( "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $this->email )) {
			return 52;
		}
		// Kentässä ei ole virhettä
		return 0;
	}
	
	
	
	// Puhnro
	public function setPuhnro($puhnro) {
		$this->puhnro = trim ( $puhnro );
	}

	public function getPuhnro() {
		return $this->puhnro;
	}

	public function checkPuhnro($required = true) {
		// Jos puhnro ei ole oikeanlainen
		if (!preg_match ( "/[+]?\d{10,14}/", $this->puhnro )) {
			return 61;
		}
		// Kentässä ei ole virhettä
		return 0;
	}
	
	
	// Ika
	public function setIka($ika) {
		$this->ika = trim ( $ika );
	}
	
	public function getIka() {
		return $this->ika;
	}
	
	public function checkIka($required = true, $min = 18) {
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->ika ) == 0) {
			return 71;
		}
		
		if ($this->ika < $min) {
			return 72;
		}
		// Kentässä ei ole virhettä
		return 0;

	}
	
	// Tavoitteet
	public function setTavoitteet($tavoitteet) {
		$this->tavoitteet = trim ($tavoitteet);
	}
	
	public function getTavoitteet() {
		return $this->tavoitteet;
	}
	
	public function checkTavoitteet($required = true, $min = 10, $max = 1000) {
		if ($required == true && strlen ( $this->tavoitteet ) == 0) {
			return 81;
		}
		// Jos tavoitteet on liian lyhyt
		if (strlen ( $this->tavoitteet) < $min) {
			return 82;
		}

		// Jos tavoitteet on liian pitkä
		if (strlen ( $this->tavoitteet ) > $max) {
			return 83;
		}
		// Tavoitteet kentässä ei voi olla erikoismerkkejä
		if (preg_match( "/[_@#$%^&*;\/|<>]/", $this->tavoitteet )) {
			return 84;
		}

		return 0;
	}
	
	// Kokemus
	public function setKokemus($kokemus) {
		$this->kokemus = trim ( $kokemus );
	}
	
	public function getKokemus() {
		return $this->kokemus;
	}
	
	public function checkKokemus() {
		return 0;
	}
	// Taajuus
	public function setTaajuus($taajuus) {
		$this->taajuus = trim ( $taajuus );
	}
	
	public function getTaajuus() {
		return $this->taajuus;
	}
	
	public function checkTaajuus() {
		return 0;
	}
	
	// Vammat
	public function setVammat($vammat) {
		$this->vammat = trim ( $vammat );
	}
	
	public function getVammat() {
		return $this->vammat;
	}
	
	public function checkVammat($required = true, $min = 2, $max = 1000) {
		if ($required == true && strlen ( $this->vammat ) == 0) {
				return 91;
		}
		// Jos vammat on liian lyhyt
		if (strlen ( $this->vammat) < $min) {
			return 92;
		}

		// Jos vammat on liian pitkä
		if (strlen ( $this->vammat ) > $max) {
			return 93;
		}
		// Vammat kentässä ei voi olla erikoismerkkejä
		if (preg_match ( "/[_@#$%^&*;\/|<>]/", $this->vammat )) {
			return 94;
		}
		
		return 0;
	}
	
	

	// ID
	public function setId($id) {
		$this->id = trim ( $id );
	}

	public function getId() {
		return $this->id;
	}
}
?>
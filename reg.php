<?php
//regisztracio feldolgozasa

//alapfunkciok hasznalata
include 'php/funkciok.php';
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("reg");
//menu beallitasa (a szam csak az aktiv oldal jelzo)(0, akkor nincs aktiv)
menu(0);
//adatbazis csatlakozas a funkciok.php-bol
$conn = adatb_csatlakozas();
//javascript az ui megvaltoztatasahoz, ha bevagyunk jelentkezve
	echo "<script>";
	echo 'var x = window.matchMedia("(max-width: 900px)");';
	echo "nincs_bejelentkezve(x);";
	echo 'x.addListener(nincs_bejelentkezve);';
	echo "</script>";	
//adat ki van-e toltve
if (!isset($_POST['veznev'], $_POST['keresztnev'], $_POST['email'], $_POST['jelszo'], $_POST['jelszom'], $_POST['irsz'], $_POST['varos'], $_POST['utca'], $_POST['hazszam'])) {
	exit('Minden adatot ki kell tölteni!');
}
///adat ki van-e toltve
if (empty($_POST['veznev'] || $_POST['keresztnev'] || $_POST['email'] || $_POST['jelszo'] || $_POST['jelszom'] || $_POST['irsz'] || $_POST['varos'] || $_POST['utca'] || $_POST['hazszam'])) {
	exit('Minden adatot ki kell tölteni!');
}
//kulonbozo ellenorzo jelszo
if($_POST['jelszo'] != $_POST['jelszom']){
	exit('Ellenőrző jelszó nem helyes!');
}
//e-mail cim validalas
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$uzenet = "Nem megfelelő e-mail cím formátum!!";
		echo "<script type='text/javascript'>alert('$uzenet');";
		echo 'window.location.href = "http://localhost:8080/webapp/index.php?oldal=regisztracio"';
		echo "</script>";
}
//jelszo hosszusag ellenorzes
if (strlen($_POST['jelszo']) > 20 || strlen($_POST['jelszo']) < 5) {
		$uzenet = "Jelszónak legalább 5 karakternek kell lennie vagy nem lehet hosszabb, mint 20!";
		echo "<script type='text/javascript'>alert('$uzenet');";
		echo 'window.location.href = "http://localhost:8080/webapp/index.php?oldal=regisztracio"';
		echo "</script>";
}
//van-e mar regisztralva?
if ($stmt = $conn->prepare('SELECT id FROM felhasznalok WHERE email = ?')) {
	$stmt->bind_param('s', $_POST['email']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->close();
	if ($stmt->num_rows > 0) {
		$uzenet = "Már regisztráltál!";
		echo "<script type='text/javascript'>alert('$uzenet');";
		echo 'window.location.href = "http://localhost:8080/webapp/index.php?oldal=bejelentkezes"';
		echo "</script>";
	} 
	//ha nincs akkor berakjuk az adatbazisba
	else {
	if ($stmt = $conn->prepare('INSERT INTO felhasznalok (veznev, keresztnev, email, jelszo, aktivalokod) VALUES (?, ?, ?, ?, ?)')) {
	$jelszo = password_hash($_POST['jelszo'], PASSWORD_DEFAULT);
	$uniqid = uniqid();
	$stmt->bind_param('sssss', $_POST['veznev'],$_POST['keresztnev'], $_POST['email'], $jelszo, $uniqid );
	$stmt->execute();
	}
	//hiba uzenet
	else {
		$uzenet = "Valamilyen hiba merült fel!";
		echo "<script type='text/javascript'>alert('$uzenet');";
		echo 'window.location.href = "http://localhost:8080/webapp/index.php?oldal=regisztracio"';
		echo "</script>";
	}
	//kulon taroljuk a cim adatokat. oda is berakjuk
		if ($stmt = $conn->prepare('INSERT INTO cimek (irsz, varos, utca, hazszam, fid) VALUES (?, ?, ?, ?, ?)')) {
			if ($stmt1 = $conn->prepare('SELECT id FROM felhasznalok WHERE email = ?')) {
				$stmt1->bind_param('s', $_POST['email']);
				$stmt1->execute();
				$stmt1->store_result();
				if ($stmt1->num_rows > 0) {
					$stmt1->bind_result($id);
					$stmt1->fetch();
					$stmt1->close();
				} 
				//hiba
				else{ 
				$uzenet = "Valamilyen hiba merült fel!";
				echo "<script type='text/javascript'>alert('$uzenet');";
				echo 'window.location.href = "http://localhost:8080/webapp/index.php?oldal=regisztracio"';
				echo "</script>";
				}
			}
			//hiba
			else
			{
				$uzenet = "Valamilyen hiba merült fel!";
				echo "<script type='text/javascript'>alert('$uzenet');";
				echo 'window.location.href = "http://localhost:8080/webapp/index.php?oldal=regisztracio"';
				echo "</script>";
			}
			$stmt->bind_param('issii', $_POST['irsz'],$_POST['varos'], $_POST['utca'], $_POST['hazszam'], $id);
			$stmt->execute();
			$stmt->close();
			
				//mail szerviz
				$tol    = 'papdis@gmail.com';
				$targy = 'Aktiválás szükséges!';
				$fejlec = 'From: ' . $tol . "\r\n" . 'Reply-To: ' . $tol . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
				$aktivalo_link = 'http://localhost:8080/webapp/php/aktivalas.php?email=' . $_POST['email'] . '&kod=' . $uniqid;
				$uzenet = '<p>Kattints a linkre az aktiváláshoz!: <a href="' . $aktivalo_link . '">' . $aktivalo_link . '</a></p>';
				mail($_POST['email'], $targy, $uzenet, $fejlec);
				$uzenet = "Sikeres regisztráció, aktiváló link elküldve!";
				echo "<script type='text/javascript'>alert('$uzenet');";
				echo 'window.location.href = "http://localhost:8080/webapp/index.php?oldal=bejelentkezes"';
				echo "</script>";
		}
		else{
				$uzenet = "Valamilyen hiba merült fel!";
				echo "<script type='text/javascript'>alert('$uzenet');";
				echo 'window.location.href = "http://localhost:8080/webapp/index.php?oldal=regisztracio"';
				echo "</script>";
		}
	}
} else {
				$uzenet = "Valamilyen hiba merült fel!";
				echo "<script type='text/javascript'>alert('$uzenet');";
				echo 'window.location.href = "http://localhost:8080/webapp/index.php?oldal=regisztracio"';
				echo "</script>";
}
$conn -> close();
?>
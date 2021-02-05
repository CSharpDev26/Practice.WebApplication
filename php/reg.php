<?php
//javascript real time email ellenorzes?
//gmail beallitas!
$szerver = "localhost";
$felhasz = "root";
$jelszo = "";
$adatb = "webapplication-database";
$conn = new mysqli($szerver, $felhasz, $jelszo, $adatb);
if ($conn->connect_error) {
  die("A szerverhez való csatlakozás meghiúsult: " . $conn->connect_error);
}
if (!isset($_POST['veznev'], $_POST['keresztnev'], $_POST['email'], $_POST['jelszo'], $_POST['jelszom'], $_POST['irsz'], $_POST['varos'], $_POST['utca'], $_POST['hazszam'])) {
	exit('Minden adatot ki kell tölteni!');
}
if (empty($_POST['veznev'] || $_POST['keresztnev'] || $_POST['email'] || $_POST['jelszo'] || $_POST['jelszom'] || $_POST['irsz'] || $_POST['varos'] || $_POST['utca'] || $_POST['hazszam'])) {
	exit('Minden adatot ki kell tölteni!');
}
if($_POST['jelszo'] != $_POST['jelszom']){
	exit('Ellenőrző jelszó nem helyes!');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$message = "Nem megfelelő e-mail cím formátum!!";
		echo "<script type='text/javascript'>alert('$message');";
		echo 'window.location.href = "http://localhost:8080/webapp/regisztracio.html"';
		echo "</script>";
}
if (strlen($_POST['jelszo']) > 20 || strlen($_POST['jelszo']) < 5) {
		$message = "Jelszónak legalább 5 karakternek kell lennie vagy nem lehet hosszabb, mint 20!";
		echo "<script type='text/javascript'>alert('$message');";
		echo 'window.location.href = "http://localhost:8080/webapp/regisztracio.html"';
		echo "</script>";
}

if ($stmt = $conn->prepare('SELECT id FROM felhasznalok WHERE email = ?')) {
	$stmt->bind_param('s', $_POST['email']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		$message = "Már regisztráltál!";
		echo "<script type='text/javascript'>alert('$message');";
		echo 'window.location.href = "http://localhost:8080/webapp/bejelentkezes.html"';
		echo "</script>";
	} else {
	if ($stmt = $conn->prepare('INSERT INTO felhasznalok (veznev, keresztnev, email, jelszo, aktivalokod) VALUES (?, ?, ?, ?, ?)')) {
	//if ($stmt = $conn->prepare('INSERT INTO felhasznalok (veznev, keresztnev, email, jelszo) VALUES (?, ?, ?, ?)')) {
	$jelszo = password_hash($_POST['jelszo'], PASSWORD_DEFAULT);
	$uniqid = uniqid();
	$stmt->bind_param('sssss', $_POST['veznev'],$_POST['keresztnev'], $_POST['email'], $jelszo, $uniqid );
	//$stmt->bind_param('ssss', $_POST['veznev'],$_POST['keresztnev'], $_POST['email'], $jelszo );
	$stmt->execute();
} else {
		$message = "Valamilyen hiba merült fel!";
		echo "<script type='text/javascript'>alert('$message');";
		echo 'window.location.href = "http://localhost:8080/webapp/regisztracio.html"';
		echo "</script>";
}
		$stmt->close();
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
				else{ 
				$message = "Valamilyen hiba merült fel!";
				echo "<script type='text/javascript'>alert('$message');";
				echo 'window.location.href = "http://localhost:8080/webapp/regisztracio.html"';
				echo "</script>";
				}
			}
			else
			{
				$message = "Valamilyen hiba merült fel!";
				echo "<script type='text/javascript'>alert('$message');";
				echo 'window.location.href = "http://localhost:8080/webapp/regisztracio.html"';
				echo "</script>";
			}
			$stmt->bind_param('issii', $_POST['irsz'],$_POST['varos'], $_POST['utca'], $_POST['hazszam'], $id);
			$stmt->execute();
			$stmt->close();
			
				//mail szerviz
				$from    = 'papdis@gmail.com';
				$subject = 'Aktiválás szükséges!';
				$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
				$activate_link = 'http://localhost:8080/webapp/php/aktivalas.php?email=' . $_POST['email'] . '&code=' . $uniqid;
				$message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
				mail($_POST['email'], $subject, $message, $headers);
				$message = "Sikeres regisztráció, aktiváló link elküldve!";
				echo "<script type='text/javascript'>alert('$message');";
				echo 'window.location.href = "http://localhost:8080/webapp/bejelentkezes.html"';
				echo "</script>";
		}
		else{
				$message = "Valamilyen hiba merült fel!";
				echo "<script type='text/javascript'>alert('$message');";
				echo 'window.location.href = "http://localhost:8080/webapp/regisztracio.html"';
				echo "</script>";
		}
	}
} else {
				$message = "Valamilyen hiba merült fel!";
				echo "<script type='text/javascript'>alert('$message');";
				echo 'window.location.href = "http://localhost:8080/webapp/regisztracio.html"';
				echo "</script>";
}

$conn -> close();
?>
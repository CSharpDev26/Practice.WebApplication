<?php
//aktivalasi linkhez oldal es feldolgozas

//alapfunkciok hasznalata
include 'funkciok.php';
//adatbazis csatlakozas a funkciok.php-bol
$conn = adatb_csatlakozas();
//kod felulirasa
if (isset($_GET['email'], $_GET['kod'])) {
	if ($stmt = $conn->prepare('SELECT * FROM felhasznalok WHERE email = ? AND aktivalokod = ?')) {
		$stmt->bind_param('ss', $_GET['email'], $_GET['kod']);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			if ($stmt = $conn->prepare('UPDATE felhasznalok SET aktivalokod = ? WHERE email = ? AND aktivalokod = ?')) {
				$ujkod = 'aktivalva';
				$stmt->bind_param('sss', $ujkod, $_GET['email'], $_GET['kod']);
				$stmt->execute();
				$message = "Sikeres aktiválás!";
				echo "<script type='text/javascript'>alert('$message');";
				echo 'window.location.href = "http://localhost:8080/webapp/bejelentkezes.html"';
				echo "</script>";
			}
		} else {
				$message = "Aktiválás már megtörtént vagy nem létező e-mail!";
				echo "<script type='text/javascript'>alert('$message');";
				echo 'window.location.href = "http://localhost:8080/webapp/regisztracio.html"';
				echo "</script>";
		}
	}
}
?>
<?php
include 'funkciok.php';
$conn = adatb_csatlakozas();
if (isset($_GET['email'], $_GET['code'])) {
	if ($stmt = $conn->prepare('SELECT * FROM felhasznalok WHERE email = ? AND aktivalokod = ?')) {
		$stmt->bind_param('ss', $_GET['email'], $_GET['code']);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			if ($stmt = $conn->prepare('UPDATE felhasznalok SET aktivalokod = ? WHERE email = ? AND aktivalokod = ?')) {
				$newcode = 'aktivalva';
				$stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['code']);
				$stmt->execute();
				$message = "Sikeres aktiválás!";
				echo "<script type='text/javascript'>alert('$message');";
				echo 'window.location.href = "http://localhost:8080/webapp/bejelentkezes.html"';
				echo "</script>";
			}
		} else {
				$message = "Aktiválás megtörtént vagy nem létező e-mail!";
				echo "<script type='text/javascript'>alert('$message');";
				echo 'window.location.href = "http://localhost:8080/webapp/regisztracio.html"';
				echo "</script>";
		}
	}
}
?>
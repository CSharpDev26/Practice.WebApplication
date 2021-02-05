
<?php
$szerver = "localhost";
$felhasz = "root";
$jelszo = "";
$adatb = "webapplication-database";
$conn = new mysqli($szerver, $felhasz, $jelszo, $adatb);
if ($conn->connect_error) {
  die("A szerverhez való csatlakozás meghiúsult: " . $conn->connect_error);
}
if ($stmt = $conn->prepare('UPDATE felhasznalok SET jelszo = ? WHERE id = 2')) {
	$password = password_hash('dolgozo', PASSWORD_DEFAULT);
	$stmt->bind_param('s', $password);
	$stmt->execute();
	echo 'You have successfully registered, you can now login!';
}
?>

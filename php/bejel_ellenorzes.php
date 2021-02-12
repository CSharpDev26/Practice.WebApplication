<?php
include 'funkciok.php';
$conn = adatb_csatlakozas();
session_start();
if ( !isset($_POST['email'], $_POST['jelszo']) ) {
	exit('Töltse ki mind a kettő mezőt!');
}
if ($stmt = $conn->prepare('SELECT keresztnev,id,jelszo FROM felhasznalok WHERE email = ? AND aktivalokod = "aktivalva"')) {
	$stmt->bind_param('s', $_POST['email']);
	$stmt->execute();
	$stmt->store_result();

if ($stmt->num_rows > 0) {
	$stmt->bind_result($keresztnev, $id, $jelszo);
	$stmt->fetch();
	if (password_verify($_POST['jelszo'], $jelszo)) {
		session_regenerate_id();
		$_SESSION['bejelentkezve'] = TRUE;
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['id'] = $id;
		$_SESSION['keresztnev'] = $keresztnev;
		header('Location: ../index.php?oldal=fooldal');
	} else {
		$message = "Helytelen e-mail és/vagy jelszó!";
		echo "<script type='text/javascript'>alert('$message');";
		echo 'window.location.href = "http://localhost:8080/webapp/bejelentkezes.php"';
		echo "</script>";
	}
} else {
		$message = "E-mail cím nincs aktiválva vagy helytelen jelszó/e-mail cím!";
		echo "<script type='text/javascript'>alert('$message');";
		echo 'window.location.href = "http://localhost:8080/webapp/bejelentkezes.php"';
		echo "</script>";
}
	$stmt->close();
}
?>

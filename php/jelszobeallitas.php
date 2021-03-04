<?php
//jelszobeallitas

//alapfunkciok hasznalata
include 'funkciok.php';
//adatbazis csatlakozas a funkciok.php-bol
$conn = adatb_csatlakozas();
//jelszo updatelese
if(isset($_POST['jelszo1']) && isset($_POST['jelszo2']) && isset($_POST['beallitasb'])){
	if($_POST['jelszo1'] == $_POST['jelszo2']){
		$stmt = $conn->prepare('UPDATE felhasznalok SET jelszo = ? WHERE email = ?');
		$jelszo = password_hash($_POST['jelszo1'], PASSWORD_DEFAULT);
		$stmt->bind_param('ss',$jelszo,$_POST['email']);
		$stmt->execute();
		if($stmt->affected_rows > 0){
		$uzenet = "Sikeres jelszó változtatás!";
		echo "<script type='text/javascript'>alert('$uzenet');";
		echo 'window.location.href = "http://localhost:8080/webapp/index.php?oldal=bejelentkezes"';
		echo "</script>";
		}
		else{
		$uzenet = "Sikertelen jelszóváltoztatás, kérjük probálja újra!";
		echo "<script type='text/javascript'>alert('$uzenet');";
		echo 'window.location.href = "http://localhost:8080/webapp/index.php?oldal=bejelentkezes"';
		echo "</script>";
		}
	}
	else{
		$uzenet = "Sikertelen jelszóváltoztatás, kérjük probálja újra!";
		echo "<script type='text/javascript'>alert('$uzenet');";
		echo 'window.location.href = "http://localhost:8080/webapp/index.php?oldal=bejelentkezes"';
		echo "</script>";
	}
}
?>

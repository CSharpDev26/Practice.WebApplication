<?php
//jelszoigenyles eseten uzenetkuldes feldolgozas

//alapfunkciok hasznalata
include 'funkciok.php';
//adatbazis csatlakozas a funkciok.php-bol
$conn = adatb_csatlakozas();
//feldolgozas es email validalas
if(isset($_POST['email'])){
	$stmt = $conn ->prepare('SELECT * FROM felhasznalok WHERE email = ?');
	$stmt->bind_param('s',$_POST['email']);
	$stmt->execute();
	$felhasznalok = $stmt->get_result();
	if($felhasznalok -> num_rows < 1)
	{
		$uzenet = "Helytelen e-mail cím!";
		echo "<script type='text/javascript'>alert('$uzenet');";
		echo 'window.location.href = "http://localhost:8080/webapp/index.php?oldal=felejtettjelszo"';
		echo "</script>";
	}
	else{
		//mail szerviz
				$felhasznalo = $felhasznalok->fetch_assoc();
				$tol    = 'papdis@gmail.com';
				$targy = 'Jelszó változtatás';
				$fejlec = 'From: ' . $tol . "\r\n" . 'Reply-To: ' . $tol . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
				$helyreallitas_link = 'http://localhost:8080/webapp/index.php?oldal=jelszohelyreallitas&mail=' . $_POST['email'] . '&kod=' . $felhasznalo['aktivalokod'];
				$uzenet = '<p>Kattints a linkre új jelszó megadásához: <a href="' . $helyreallitas_link . '">' . $helyreallitas_link . '</a></p>';
				mail($_POST['email'], $targy, $uzenet, $fejlec);
		$uzenet = "E-mail elküldve!";
		echo "<script type='text/javascript'>alert('$uzenet');";
		echo 'window.location.href = "http://localhost:8080/webapp/index.php?oldal=fooldal"';
		echo "</script>";
	}
}
?>
<?php
//jelszo helyreallitas feldolgozo

//alapfunkciok hasznalata
include 'php/funkciok.php';
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("jelszohelyreallitas");
//menu beallitasa (a szam csak az aktiv oldal jelzo)(0, akkor nincs aktiv)
menu(0);
//adatbazis csatlakozas a funkciok.php-bol
$conn = adatb_csatlakozas();
//nincs bejelentkezve termeszetesen, ui
echo "<script>";
echo "nincs_bejelentkezve();";
echo "</script>";
?>
<?php
//ellenorizes, aktivalva van-e az e-mail, ha nincs akkor aktivalo link kuldese
if(isset($_GET['kod']) && isset($_GET['mail']))
{
$email = $_GET['mail'];
		if($_GET['kod'] != "aktivalva"){
			//mail szerviz
			$stmt = $conn->prepare('SELECT aktivalokod FROM felhasznalok WHERE email = ?');
			$stmt->bind_param('s',$_GET['mail']);
			$stmt->execute();
			$felhasznalok = $stmt->get_result();
			$felhasznalo = $felhasznalok->fetch_assoc();
			$stmt->close();
			$tol    = 'papdis@gmail.com';
			$targy = 'Aktiválás szükséges!';
			$fejlec = 'From: ' . $tol . "\r\n" . 'Reply-To: ' . $tol . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
			$aktivalo_link = 'http://localhost:8080/webapp/php/aktivalas.php?email=' . $_GET['mail'] . '&kod=' . $felhasznalo['aktivalokod'];
			$uzenet = '<p>Kattints a linkre az aktiváláshoz!: <a href="' . $aktivalo_link . '">' . $aktivalo_link . '</a></p>';
			mail($_GET['mail'], $targy, $uzenet, $fejlec);
			$uzenet = "Felhasználó nincs aktiválva! E-mail elküldve!";
			echo "<script type='text/javascript'>alert('$uzenet');";
			echo 'window.location.href = "http://localhost:8080/webapp/index.php?oldal=fooldal"';
			echo "</script>";
		}
}

?>
<!-- uj jelszo form -->
<form action = "php/jelszobeallitas.php" method = "post">
<input type = "hidden" name = "email" value = <?=$email?>>
<label>Új jelszó</label>
<input type = "password" name = "jelszo1" required>
<label>Új jelszó megismételve</label>
<input type = "password" name = "jelszo2" required>
<input type = "submit" value = "Beállítás" name = "beallitasb">
</form>
<?php
//lablec es kapcsolat lezaras
lablec();
$conn->close();
?>
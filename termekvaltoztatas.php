<?php 
//termekvaltoztato (fo resz) uzemelteto oldalon

//alapfunkciok hasznalata
include 'php/funkciok.php';
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("termekvaltoztatas");
//menu beallitasa (a szam csak az aktiv oldal jelzo)(0, akkor nincs aktiv)
menu(0);
//adatbazis csatlakozas a funkciok.php-bol
$conn = adatb_csatlakozas();
//javascript az ui megvaltoztatasahoz, ha bevagyunk jelentkezve
if (isset($_SESSION['bejelentkezve'])) {
echo "<script>";
echo "bejelentkezve(\"".$_SESSION['keresztnev']."\",".$_SESSION['id'].");";
echo "</script>";
}
else{
	echo "<script>";
	echo "nincs_bejelentkezve();";
	echo "</script>";
}
?>
<!-- fo resz ui -->
<div class = "termekvalt-osszefogo">
<button onClick = "termekHozzaAdAktiv()">Termék hozzáadás</button>
<button onClick = "termekSzerkesztAktiv()">Termék törlés/szerkesztés</button>
<span class="popupszoveg" id="popupid"></span>
</div>
<!-- hozzaadas ui (alapesetben rejtett) -->
<div class = "termekhozzaadas-osszefogo">
<form method = "post" action = "index.php?oldal=termekvaltoztatas" id = "hozzaadasform" enctype="multipart/form-data">
<table>
<tr>
<td>
Név:
</td>
<td>
<input type="text" name = "nev" required>
</td>
</tr>
<tr>
<td>
Leírás:
</td>
<td>
<textarea name = "leiras" form="hozzaadasform" rows="5" cols="22" required></textarea>
</td>
</tr>
<tr>
<td>
<tr>
<td>
Kép fájl:
</td>
<td>
<input type="file" name = "kep" id = "kep" required>
</td>
</tr>
<tr>
<td>
Típus:
</td>
<td>
<input type="number" name = "tipus" required>
</td>
</tr>
<tr>
<td>
Ár:
</td>
<td>
<input type="number" name = "ar" required>
</td>
</tr>
<tr>
<td>
Akció nélküli ár:
</td>
<td>
<input type="number" name = "akcioar" required>
</td>
</tr>
<tr>
<td>
Mennyiség:
</td>
<td>
<input type="number" name = "mennyiseg" required>
</td>
</tr>
</table>
<input type="submit" name = "submit" value = "Termék felvétele">
</form>
<p>Árak - forintban; a típus: 1 - könyvek, 2 - autógumik, 3 - vegyes</p>
</div>
<div class = "termekszerkesztes-osszefogo">
<form method = "post" action = "index.php?oldal=termekkeredmeny">
<input type = "text" name = "termekkereses" required>
<input type = "submit" id = "kereso" value = "Keresés">
</form>
</div>
<?php 
//termek hozzaadas feldolgozasa
if(isset($_POST['nev']) && isset($_POST['leiras']) && isset($_POST['tipus']) && isset($_POST['ar']) && isset($_POST['akcioar']) && isset($_POST['mennyiseg'])){
$mappa = "termekek/";
$fajlnev = $mappa . basename($_FILES["kep"]["name"]);
$feltoltes_ok = 1;
$ellenorzes = getimagesize($_FILES["kep"]["tmp_name"]);
	if($ellenorzes !== false) 
	$feltoltes_ok = 1; 
	else 
    $feltoltes_ok = 0;
if ($feltoltes_ok == 1) {
	if (move_uploaded_file($_FILES["kep"]["tmp_name"], $fajlnev)) {
	$stmt = $conn -> prepare('INSERT INTO termekek(nev, leiras, kep, tipus, ar, akcio_nelkuli_ar, mennyiseg) VALUES(?,?,?,?,?,?,?)');
	$stmt->bind_param('sssiiii',$_POST['nev'],$_POST['leiras'],$fajlnev,$_POST['tipus'],$_POST['ar'],$_POST['akcioar'],$_POST['mennyiseg']);
	$stmt->execute();
	if($stmt->affected_rows > 0){
	//popup
	echo '<script>';
	echo 'popUp("sikeres");';
	echo '</script>';
	$stmt->close();
	}
		
  } else {
    echo '<script>';
	echo 'popUp("sikertelen");';
	echo '</script>';
  }
} else {
	echo '<script>';
	echo 'popUp("sikertelen");';
	echo '</script>';
}
}
?>
<?php
//lablec es kapcsolat lezaras
lablec();
$conn->close();
?>
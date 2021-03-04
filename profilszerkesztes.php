<?php
//profil szerkesztes oldala

//alapfunkciok hasznalata
include 'php/funkciok.php';
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("profilszerkesztes");
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
//placeholder adat lekerdezes
$stmt = $conn->prepare('SELECT * FROM felhasznalok WHERE id = ?');
$stmt->bind_param('i',$_SESSION['id']);
$stmt->execute();
$felhasznalok_adat = $stmt->get_result();
$fa = $felhasznalok_adat->fetch_assoc();
$stmt = $conn->prepare('SELECT * FROM cimek WHERE fid = ?');
$stmt->bind_param('i',$_SESSION['id']);
$stmt->execute();
$cim_adat = $stmt->get_result();
$ca = $cim_adat->fetch_assoc();
?>
<!-- form a szerkeszteshez -->
<div class = "profil-szerkesztes-osszefogo">
<form action="index.php?oldal=profilvalidalas" method = "post">
	<label>Vezetéknév</label><br>
    <input type="text" id = "veznev" name = "veznev" placeholder = <?=$fa['veznev']?>><br>
    <label>Keresztnév</label><br>
    <input type="text" id = "keresztnev" name = "keresztnev" placeholder = <?=$fa['keresztnev']?>><br>
    <label>Régi jelszó</label><br>
    <input type="password" id = "jelszoregi" name = "jelszoregi"><br>
    <label>Új jelszó</label><br>
    <input type="password" id = "jelszouj" name = "jelszouj"><br>
    <label>Új jelszó megerősítése</label><br>
    <input type="password" id = "jelszoujm" name = "jelszoujm"><br> 	
    <label>Írányítószám</label><br>
    <input type="number" id = "irsz" name = "irsz" placeholder = <?=$ca['irsz']?>><br>
    <label>Város</label><br>
    <input type="text" id = "varos" name = "varos" placeholder = <?=$ca['varos']?>><br>
    <label>Utca</label><br>
    <input type="text" id = "utca" name = "utca" placeholder = <?=$ca['utca']?>><br>   
    <label>Házszám</label><br>
    <input type="number" id = "hazszam" name = "hazszam" placeholder = <?=$ca['hazszam']?>><br> 
    <input type="submit" value="Szerkesztés" name = "submit">
</form>
</div>
<?php 
//lablec es kapcsolat lezaras
lablec();
$stmt->close();
$conn->close();
?>

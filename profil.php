<?php
//profil oldal, szerkesztes gombbal 

//alapfunkciok hasznalata
include 'php/funkciok.php';
//ha nincs bejelentkezve akkor bejelentkezes (elvileg a profil nem lathato bejelentkezes nelkul)
if (!isset($_SESSION['bejelentkezve'])) {
	header('Location: bejelentkezes.php');
	exit;
}
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("profil");
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
//adatok lekeredezes
$stmt = $conn->prepare('SELECT veznev,jelszo FROM felhasznalok WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($veznev,$jelszo);
$stmt->fetch();
$stmt->close();
$stmt = $conn->prepare('SELECT irsz,varos,utca,hazszam FROM cimek WHERE fid = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($irsz,$varos,$utca,$hazszam);
$stmt->fetch();
?>
<!-- adat tablazatba irasa -->
<p id = "adataid">Adataid</p>
<div class = "profil-osszefogo">
<table>
 <tr>
   <td>E-mail cím:</td>
   <td><?=$_SESSION['email']?></td>
 </tr>
 <tr>
	<td>Jelszó::</td>
	<td><?=$jelszo?></td>
 </tr>
 <tr>
	<td>Vezetéknév:</td>
	<td><?=$veznev?></td>
 </tr>
   <tr>
	<td>Keresztnév:</td>
	<td><?=$_SESSION['keresztnev']?></td>
 </tr>
  <tr>
	<td>Cím:</td>
 </tr>
    <tr>
	<td>Irányítószám:</td>
	<td><?=$irsz?></td>
 </tr>
    <tr>
	<td>Város:</td>
	<td><?=$varos?></td>
 </tr>
    <tr>
	<td>Utca:</td>
	<td><?=$utca?></td>
 </tr>
    <tr>
	<td>Házszám::</td>
	<td><?=$hazszam?></td>
 </tr>
</table>
<!-- form a profil szerkeszteshez -->
<form action = "index.php?oldal=profilszerkesztes" method = "post">
<input type = "submit" value = "Szerkesztés">
</form>
</div>
<?php
//lablec es kapcsolat lezaras
lablec();
$stmt->close();
$conn->close();
?>
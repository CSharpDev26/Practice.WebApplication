<?php
include 'php/funkciok.php';
$conn = adatb_csatlakozas();
if (!isset($_SESSION['bejelentkezve'])) {
	header('Location: bejelentkezes.php');
	exit;
}
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
$stmt->close();
$conn->close();
fejlec("profil");
menu(0);
if (isset($_SESSION['bejelentkezve'])) {
echo "<script>";
echo "bejelentkezve(\"".$_SESSION['keresztnev']."\",".$_SESSION['id'].");";
echo "</script>";
}
?>
<p>Adataid</p>
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
<?php
lablec();
?>
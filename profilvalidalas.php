<?php
//profil szerkesztes feldolgozasa

//alapfunkciok hasznalata
include 'php/funkciok.php';
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("profilvalidalas");
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
//van-e kitoltve adat
if(!empty($_POST['veznev'] || $_POST['keresztnev'] || $_POST['jelszoregi'] || $_POST['jelszouj'] || $_POST['jelszoujm'] || $_POST['irsz'] || $_POST['varos'] || $_POST['utca'] || $_POST['hazszam'])){
$stmt = $conn->prepare('SELECT veznev,keresztnev,jelszo FROM felhasznalok WHERE id = ?');
$stmt->bind_param('i',$_SESSION['id']);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
	$stmt->bind_result($veznev, $keresztnev, $jelszo);
	$stmt->fetch();
}
$stmt = $conn->prepare('SELECT irsz,varos,utca,hazszam FROM cimek WHERE fid = ?');
$stmt->bind_param('i',$_SESSION['id']);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
	$stmt->bind_result($irsz, $varos, $utca, $hazszam);
	$stmt->fetch();
}
//jelszo validalas
if($_POST['jelszoregi'] != ""){
	if (password_verify($_POST['jelszoregi'], $jelszo) ){
		if(($_POST['jelszouj'] != $_POST['jelszoujm']) || ($_POST['jelszouj'] == $_POST['jelszoregi']))
			exit('Nem egyező új jelszó vagy ugyanaz a jelszó!');
		else
			$jelszo = password_hash($_POST['jelszouj'], PASSWORD_DEFAULT);
	}
	else{
		exit('Nem helyes régi jelszó!');
	}
}
//ellenorzes -> ugyanaz-e az adat
if($_POST['veznev'] != $veznev && $_POST['veznev'] != "")
	$veznev = $_POST['veznev'];
if($_POST['keresztnev'] != $keresztnev && $_POST['keresztnev'] != "")
	$keresztnev = $_POST['keresztnev'];
if($_POST['irsz'] != $irsz && $_POST['irsz'] != null)
	$irsz = $_POST['irsz'];
if($_POST['varos'] != $varos && $_POST['varos'] != "")
	$varos = $_POST['varos'];
if($_POST['utca'] != $utca && $_POST['utca'] != "")
	$utca = $_POST['utca'];
if($_POST['hazszam'] != $hazszam && $_POST['hazszam'] != null)
	$hazszam = $_POST['hazszam'];
//updateles 
$stmt = $conn->prepare('UPDATE felhasznalok SET veznev = ?, keresztnev = ?, jelszo = ? WHERE id = ?');
$stmt->bind_param('sssi',$veznev,$keresztnev,$jelszo,$_SESSION['id']);
$stmt->execute();
$stmt = $conn->prepare('UPDATE cimek SET irsz = ?, varos = ?, utca = ?, hazszam = ? WHERE fid = ?');
$stmt->bind_param('issii',$irsz,$varos,$utca,$hazszam,$_SESSION['id']);
$stmt->execute();
//bejelentkezes session keresztnevenek updatelese
$_SESSION['keresztnev'] = $keresztnev;
}
//nincs adat
else
	exit('Nem töltötél ki adatot!');
?>
<?php 
//lablec es kapcsolat lezaras
lablec();
$stmt->close();
$conn->close();
?>

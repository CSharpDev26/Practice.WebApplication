<?php
include 'php/funkciok.php';
fejlec("rendelesvalaszto");
menu(0);
$conn = adatb_csatlakozas();
$tovabb_kikapcsol = False;
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
<div class = "valaszto-osszefogo"> 
<form method = "POST" action = "index.php?oldal=rendelesosszegzo">
<div class = "szallitas">
<p>Szállítási mód</p>
<input id = "csomag" type = "radio" name = "szallit" value = "csomagpont" onclick = "mas_gomb()" required>
<label for="csomag">Csomagpont (800 Ft)</label><br>
<input id = "szemelyes" type = "radio" name = "szallit" value = "szemelyes"  onclick = "mas_gomb()">
<label for="szemelyes">Személyes átvétel</label><br>
<input id = "hazhoz" type = "radio" name = "szallit" value = "hazhoz" onclick = "hazhoz_gomb()">
<label for="hazhoz">Házhoz szállítás (1200 Ft)</label><br>
<div class = "szallitasi-cim">
<?php
$cim = null;
if(!isset($_SESSION['id'])) {
	echo '<div class = "nincs-bejelentkezve"><p>Nincs bejelentkezve!</p></div>';
	$tovabb_kikapcsol = True;
}
else{
$stmt=$conn->prepare('SELECT * FROM cimek WHERE fid = ?');
$stmt->bind_param('i',$_SESSION['id']);
$stmt->execute();
$eredmeny = $stmt->get_result();
if($eredmeny->num_rows == 0){
	echo '<div class = "nincs-bejelentkezve"><p>Nem található cím!</p></div>';
}
$cim = $eredmeny->fetch_assoc();
}
?>
<?php if($cim != null): ?>
<p id ="szall-adat">Szállítási adataid:</p>
<table>
    <tr>
	<td>Irányítószám:</td>
	<td><?=$cim['irsz']?></td>
 </tr>
    <tr>
	<td>Város:</td>
	<td><?=$cim['varos']?></td>
 </tr>
    <tr>
	<td>Utca:</td>
	<td><?=$cim['utca']?></td>
 </tr>
    <tr>
	<td>Házszám:</td>
	<td><?=$cim['hazszam']?></td>
 </tr>
</table>
<?php endif; ?>
</div>
</div>
<div class = "fizetes">
<p>Fizetési mód</p>
<input id = "utanvet" type = "radio" name = "fizet" value = "utanvet" required>
<label for="utanvet">Utánvét (400 Ft)</label><br>
<input id = "bankkartya" type = "radio" name = "fizet" value = "bankkartya">
<label for="bankkartya">Bankkártya</label><br>
<input id = "paypal" type = "radio" name = "fizet" value = "paypal">
<label for="paypal">Pay-Pal (150 Ft)</label><br>
<input type = "submit" name = "rendeles_osszegzo" value = "Tovább" id = "rendeles_osszegzo">
</div>
</form>
</div>
<?php
lablec();
?>
<?php 
	if($tovabb_kikapcsol){
	echo "<script>";
	echo "tovabb();";
	echo "</script>";
	//pop-up!
	echo "<p style = margin-left:860px;><br><br>Kérjük jelentkezen be!</p>";
	}
?>
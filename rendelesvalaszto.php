<?php
//szallitasi es fizetesi adatok valasztasa rendeles soran

//alapfunkciok hasznalata
include 'php/funkciok.php';
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("rendelesvalaszto");
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
	echo 'var x = window.matchMedia("(max-width: 900px)");';
	echo "nincs_bejelentkezve(x);";
	echo 'x.addListener(nincs_bejelentkezve);';
	echo "</script>";
}
//gomb kikapcsolashoz
$tovabb_kikapcsol = False;
?> 
<!-- ui -->
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
//ha nincs bejelentkezve akkor nem engedjuk tovabb
if(!isset($_SESSION['id'])) {
	echo '<div class = "nincs-bejelentkezve"><p>Nincs bejelentkezve!</p></div>';
	$tovabb_kikapcsol = True;
}
//hazhoz szallitas mutatasa
else{
$stmt=$conn->prepare('SELECT * FROM cimek WHERE fid = ?');
$stmt->bind_param('i',$_SESSION['id']);
$stmt->execute();
$eredmeny = $stmt->get_result();
if($eredmeny->num_rows == 0){
	echo '<div class = "nincs-bejelentkezve"><p>Nem található cím!</p></div>';
}
$cim = $eredmeny->fetch_assoc();
$stmt->close();
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
	//gomb kikapcsolasa
	if($tovabb_kikapcsol){
	echo "<script>";
	echo "tovabb();";
	echo "</script>";
	echo "<p id = 'kerjukjelent'><br><br>Kérjük jelentkezen be!</p>";
	}
?>
<?php
//lablec es kapcsolat lezaras
lablec();
$conn->close();
?>
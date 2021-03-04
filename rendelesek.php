<?php 
//rendelesek feldolgozasa uzemelteto felol

//alapfunkciok hasznalata
include 'php/funkciok.php';
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("rendelesek");
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
<h1>Rendelések és kommentek</h1>
<?php
//rendeles lekerdezes
$stmt = $conn->prepare('SELECT * FROM rendelesek ORDER BY teljesitve DESC');
$stmt->execute();
$rendeles_alap = $stmt -> get_result();
?>
<h2>Rendelések</h2>
<!-- rendeles kereses (javascript) -->
<div class = "rendeles-kereso">
<input type="text" id="keresotext" onkeyup="rendelesKereso()" placeholder="ID alapján keresés..">
</div>
<!-- rendelesek ui -->
<div class = "rendelesek-osszefogo">
<form action = "php/rendeles_dolgozo.php" method = "post">
<table id = "rendelestabla">
<thead>
  <tr>
    <th></th>
    <th>Rendelésszám</th>
	<th>Vevő e-mail</th>
    <th>Dátum</th>
	<th>Szállítási költség</th>
    <th>Fizetési költség</th>
	<th>Végösszeg</th>
    <th>Termékek</th>
	<th>Teljesítve</th>
  </tr>
</thead>
<tbody>
<?php foreach ($rendeles_alap as $rendeles): ?>
<tr>
<input type = "hidden" name = "rendelescheckid[]" value = <?=$rendeles['id']?>>
<input type = "hidden" name = "rendelesfid[]" value = <?=$rendeles['fid']?>>
<td><input type = "checkbox" name = "termekcheckbox[]" value = <?=$rendeles['id']?>></td>
<td>#<?=$rendeles['id']?></td>
<?php 
//email lekerese a felhasznalokbol
$stmt = $conn->prepare('SELECT email FROM felhasznalok WHERE id = ?');
$stmt->bind_param('i',$rendeles['fid']);
$stmt->execute();
$felhasz_adatok = $stmt->get_result();
$adat = $felhasz_adatok->fetch_assoc();
$feamilt = $adat['email'];
?>
<td><?=$feamilt?></td>
<td><?=$rendeles['datum']?></td>
<td><?=number_format($rendeles['szallitasi_koltseg'] / 1000, 3, ".", "");?> Ft</td>
<td><?=$rendeles['fizetesi_koltseg']?> Ft</td>
<td><?=number_format($rendeles['vegosszeg'] / 1000, 3, ".", "");?> Ft</td>
<?php 
//termekek lekerese a rendelesekbol
$sql = "SELECT * FROM termekek t JOIN rendelesek_termekek rt ON rt.termek_id = t.id WHERE rt.rendeles_id = ?";
$stmt = $conn->prepare($sql);
$stmt -> bind_param('i',$rendeles['id']);
$stmt -> execute();
$termekek = $stmt -> get_result();
?>
<td>
<!-- termek felsorolas -->
<?php foreach($termekek as $termek): ?>
<Label><?=$termek['nev']?></Label>
<Label><?=$termek['mennyiseg']?> db</Label><br>
<?php endforeach; ?>
</td>
<?php if($rendeles['teljesitve'] == "igen"):?>
<td id = "rend-teljesitve"><?=$rendeles['teljesitve']?></td>
<?php elseif($rendeles['teljesitve'] == "lemondott"): ?>
<td id = "rend-lemondva"><?=$rendeles['teljesitve']?></td>
<?php else: ?>
<td id = "rend-nincs-teljesitve"><?=$rendeles['teljesitve']?></td>
<?php endif; ?>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<input type = "submit" value = "Rendelés tejesítése" name = "steljesit" id = "steljesit">
<input type = "submit" value = "Rendelés törlése" name = "storol" id = "storol">
</form>
</div>
<!-- popup -->
<span class="popupszoveg" id="popupid"></span>
<?php
//kommentek lekerese
$stmt = $conn->prepare('SELECT * FROM kommentek');
$stmt->execute();
$kommentek = $stmt->get_result();
?>
<!-- kommentek osszefogasa -->
<h2>Kommentek</h2>
<div class = "kommentek-osszefogo">
<form action = "php/rendeles_dolgozo.php" method = "post" id = "kommentform">
<table>
<thead>
<tr>
<td></td>
<td>Email-cím</td>
<td>Komment</td>
<td>Dátum</td>
<td>Olvasott</td>
</tr>
</thead>
<tbody>
<?php foreach ($kommentek as $komment): ?>
<tr>
<input type = "hidden" name = "kommentid[]" value = <?=$komment['id']?>>
<td> <input type = "checkbox" name = "olvasvalt[]" value = <?=$komment['id']?>> </td>
<td>
<?php 
//email lekerese felhasznalokbol
$stmt = $conn->prepare('SELECT email FROM felhasznalok WHERE id = ?');
$stmt->bind_param('i',$komment['fid']);
$stmt->execute();
$felhasz_adatok = $stmt->get_result();
$adat = $felhasz_adatok->fetch_assoc();
$feamil = $adat['email'];
?>
<?=$feamil?>
</td>
<td><?=$komment['komment']?></td>
<td><?=$komment['datum']?></td>
<?php if($komment['olvasott'] == "Igen"): ?>
<td id = "olvasott"><?=$komment['olvasott']?></td>
<?php else: ?>
<td id = "nem-olvasott"><?=$komment['olvasott']?></td>
<?php endif; ?>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<input type = "submit" value = "Olvasottá tesz" name="submitkomment">
</form>
</div>
<script>
//javascript a rendeles keresohoz
function rendelesKereso(){
  var keresobemenet, szuro, tabla, tr, td, i, sorszoveg;
  keresobemenet = document.getElementById("keresotext");
  szuro = keresobemenet.value.toUpperCase();
  tabla = document.getElementById("rendelestabla");
  tr = tabla.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      sorszoveg = td.textContent || td.innerText;
      if (sorszoveg.toUpperCase().indexOf(szuro) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
<?php
//popup ablakhoz kod
if(isset($_GET['siker'])){
	if($_GET['siker'] != ""){
	echo '<script>';
	echo 'popUp("'.$_GET['siker'].'");';
	echo '</script>';
	}
}
?>
<?php
//lablec es kapcsolat lezaras
lablec();
$stmt->close();
$conn->close();
?>
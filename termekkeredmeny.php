<?php 
//termek kereso (uzemelteto oldalon) szerkeszteshez

//alapfunkciok hasznalata
include 'php/funkciok.php';
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("termekkeredmeny");
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
<?php
//nev alapjan kereses
if(isset($_POST['termekkereses'])){
	$stmt = $conn -> prepare("SELECT * FROM termekek WHERE nev LIKE ? AND kifutott != ?");
	$n = "%{$_POST['termekkereses']}%";
	$k = "igen";
	$stmt->bind_param('ss',$n,$k);
	$stmt->execute();
	$termekek = $stmt->get_result();
	$stmt->close();
}
?>
<!-- popup -->
<span class="popupszoveg" id="popupid"></span>
<!-- ui -->
<div class = "termek-kereso">
<?php if ($termekek->num_rows < 1): ?>
<p>A keresés nem hozott eredményt!</p>
<?php else: ?>
<form action="index.php?oldal=termekkeredmeny" method="post" id = "termekformk">
  <input type = "hidden" value = <?=$_POST['termekkereses']?> name = "termekkereses">
	  <table>
            <thead>
                <tr>
					<td>Név</td>
					<td>Leírás</td>
					<td>Kép neve</td>
					<td>Típus</td>
                    <td>Ár</td>
                    <td>Akció nélküli ár</td>
					<td>Mennyiség</td>
					<td>Törlés</td>
                </tr>
            </thead>
            <tbody>
	<?php foreach ($termekek as $termek): ?>
		<tr>
		<input type = "hidden" name = "tid[]" value = <?=$termek['id']?>>
		<td> <input type = "text" name = "tnev[]" placeholder = "<?=$termek['nev']?>"> </td>
		<td> <textarea name = "tleiras[]" form = "termekformk" rows="5" cols="22" placeholder = "<?=$termek['leiras']?>"></textarea></td>
		<td> <input type = "text" name = "tkep[]" placeholder = "<?=$termek['kep']?>"> </td>
		<td> <input type = "number" name = "ttipus[]" placeholder = "<?=$termek['tipus']?>"> </td>
		<td> <input type = "number" name = "tar[]" placeholder = "<?=$termek['ar']?>"> </td>
		<td> <input type = "number" name = "tar_nelkul[]" placeholder = "<?=$termek['akcio_nelkuli_ar']?>"> </td>
		<td> <input type = "number" name = "tmennyiseg[]" placeholder = "<?=$termek['mennyiseg']?>"> </td>
		<td> <input type = "checkbox" name = "ttorles[]" value = <?=$termek['id']?>> </td>
		</tr>
	<?php endforeach; ?>
</tbody>
</table>
<input type = "submit" value = "Szerkesztés" name = "beado">
<p>Kép változtatás esetén a formátum: "kepneve.kiterjesztes"! </p>
</form>
<?php endif; ?>
</div>
<!-- kep feltoltes ui -->
<div class = "kepfeltolto-osszefogo">
<form action = "index.php?oldal=termekkeredmeny" enctype="multipart/form-data" method = "post">
<input type = "hidden" value = <?=$_POST['termekkereses']?> name = "termekkereses">
<label>Kép feltöltés a változtatáshoz</label><br>
<input type = "file" name = "kepf" id = "kepf" required><br>
<input type = "submit" value = "Feltöltés" name = "kepfeltoltess">
</form>
</div>
<?php
//termek szerkesztes/torles
if(isset($_POST['beado'])){
$i = 0;
while($i < $termekek->num_rows){
	if((isset($_POST['tnev'][$i]) && $_POST['tnev'][$i] != "") || (isset($_POST['tleiras'][$i]) && $_POST['tleiras'][$i] != "") || (isset($_POST['tkep'][$i]) && $_POST['tkep'][$i] != "") || (isset($_POST['ttipus'][$i]) && $_POST['ttipus'][$i] != "") || (isset($_POST['tar'][$i]) && $_POST['tar'][$i] != null) || (isset($_POST['tar_nelkul'][$i]) && $_POST['tar_nelkul'][$i] != null) || (isset($_POST['tmennyiseg'][$i]) && $_POST['tmennyiseg'][$i] != null) || (!empty($_POST['ttorles']))){
	foreach($termekek as $t){
		if($t['id'] == $_POST['tid'][$i])
		{
			$temp = $t;
		}			
	}
	if(empty($_POST['ttorles'])){
	if($temp['nev'] != $_POST['tnev'][$i] && $_POST['tnev'][$i] != "" && isset($_POST['tnev'][$i]))
		$temp['nev'] = $_POST['tnev'][$i];
	
	if($temp['leiras'] != $_POST['tleiras'][$i] && $_POST['tleiras'][$i] != "" && isset($_POST['tleiras'][$i]))
		$temp['leiras'] = $_POST['tleiras'][$i];
	
	if($temp['kep'] != "termekek/".$_POST['tkep'][$i] && $_POST['tkep'][$i] != "" && isset($_POST['tkep'][$i]))
		$temp['kep'] = "termekek/".$_POST['tkep'][$i];
	
	if($temp['tipus'] != $_POST['ttipus'][$i] && $_POST['ttipus'][$i] != null && isset($_POST['ttipus'][$i]))
		$temp['tipus'] = $_POST['ttipus'][$i];
	
	if($temp['ar'] != $_POST['tar'][$i] && $_POST['tar'][$i] != null && isset($_POST['tar'][$i]))
		$temp['ar'] = $_POST['tar'][$i];
	
	if($temp['akcio_nelkuli_ar'] != $_POST['tar_nelkul'][$i] && $_POST['tar_nelkul'][$i] != null && isset($_POST['tar_nelkul'][$i]))
		$temp['akcio_nelkuli_ar'] = $_POST['tar_nelkul'][$i];
	
	if($temp['mennyiseg'] != $_POST['tmennyiseg'][$i] && $_POST['tmennyiseg'][$i] != null && isset($_POST['tmennyiseg'][$i])){
	$temp['mennyiseg'] = $_POST['tmennyiseg'][$i];}
	
	$stmt = $conn -> prepare('UPDATE termekek SET nev = ?, leiras = ?, kep = ?, tipus = ?, ar = ?, akcio_nelkuli_ar = ?, mennyiseg = ? WHERE id = ?');
	$stmt->bind_param('sssiiiii',$temp['nev'],$temp['leiras'],$temp['kep'],$temp['tipus'],$temp['ar'],$temp['akcio_nelkuli_ar'],$temp['mennyiseg'],$_POST['tid'][$i]);
	$stmt->execute();
	if($stmt->affected_rows > 0){
	echo '<script>';
	echo 'popUp("sikeresvaltoztatas");';
	echo '</script>';
	}
	$stmt->close();
	}
	else{
		if(in_array($_POST['tid'][$i],$_POST['ttorles'])){
		$stmt = $conn -> prepare('UPDATE termekek SET kifutott = ? WHERE id = ?');
		$k = "igen";
		$stmt -> bind_param('si',$k,$_POST['tid'][$i]);
		$stmt->execute();
			if($stmt->affected_rows > 0){
			echo '<script>';
			echo 'popUp("sikerestorles");';
			echo '</script>';
			}
		}
		$stmt->close();
		}
	}
	$i++;	
}
}
//kepfeltoltes
if(isset($_POST['kepfeltoltess'])){
$mappa = "termekek/";
$fajlnev = $mappa . basename($_FILES["kepf"]["name"]);
$feltoltes_ok = 1;
$ellenorzes = getimagesize($_FILES["kepf"]["tmp_name"]);
	if($ellenorzes !== false) 
	$feltoltes_ok = 1; 
	else 
    $feltoltes_ok = 0;
if ($feltoltes_ok == 1) {
	if (move_uploaded_file($_FILES["kepf"]["tmp_name"], $fajlnev)) {
			echo '<script>';
			echo 'popUp("sikeresfeltoltes");';
			echo '</script>';
  } else {
    	echo '<script>';
		echo 'popUp("sikertelenfeltoltes");';
		echo '</script>';
  }
} else {
	echo '<script>';
	echo 'popUp("sikertelenfeltoltes");';
	echo '</script>';
}
}
?>
<?php
//lablec es kapcsolat lezaras
lablec();
$conn->close();
?>
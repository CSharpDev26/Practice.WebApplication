<?php
//autogumi termek felulet

//alapfunkciok hasznalata
include 'php/funkciok.php';
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("autogumik");
//menu beallitasa (a szam csak az aktiv oldal jelzo)
menu(2);
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
//egy oldalon megjelenitett termek szam
$termekszam = 12;
//jelenlegi oldalszam
$jelenlegi_oldal = isset($_GET['o']) && is_numeric($_GET['o']) ? (int)$_GET['o'] : 1;
$tarolo = ($jelenlegi_oldal - 1) * $termekszam;
//termek tipus
$tipus = 2;
//kereseshez tartozo php, kereso box szerinti termek megjelenites
if(isset($_POST['kereses']) && $_POST['kereses'] != ""){
$stmt = $conn->prepare('SELECT * FROM termekek WHERE nev LIKE ? AND tipus = ? AND kifutott != ? ORDER BY datum_hozzaadva DESC LIMIT ?,?');
$n = "%{$_POST['kereses']}%";
$k = "igen";
$stmt-> bind_param('sisii',$n,$tipus,$k,$tarolo,$termekszam);
$stmt->execute();
$termekek = $stmt->get_result();
$termek_keres_szam = 0;
if($termekek -> num_rows > 0)
{
	foreach($termekek as $t){
		$termek_keres_szam++;
	}
}
}
//ha nem kereses akkor az osszes termek a tipusbol betoltese
else{
$stmt = $conn->prepare('SELECT * FROM termekek WHERE tipus = ? AND kifutott != ? ORDER BY datum_hozzaadva DESC LIMIT ?,?');
$k = "igen";
$stmt-> bind_param('isii',$tipus,$k,$tarolo,$termekszam);
$stmt->execute();
$termekek = $stmt->get_result();
}
//sql az osszes termekszam lekerdezesehez
$sql = "SELECT * FROM termekek WHERE tipus = 2 AND kifutott != 'igen'";
$termekek_a = mysqli_query($conn,$sql);
if(isset($_POST['kereses']) && $_POST['kereses'] != ""){
	$termekek_osszesen = $termek_keres_szam;
}
else{
$termekek_osszesen = mysqli_num_rows($termekek_a);
}
?>
<!-- a kereses ui-a -->
<div class = "termek-keres">
<form action = "index.php?oldal=autogumik" method = "post">
<input type = "text" name = "kereses" required>
<input type = "submit" value = "Keresés">
</form>
</div>
<!-- a termek ui-a -->
<div class = "termekek-egyben">
	<h1>Autógumik</h1>
	<p><?=$termekek_osszesen?> Termék</p>
	<div class = "termekek">
		<?php foreach ($termekek as $termek): ?>
        <a href="index.php?oldal=termek&id=<?=$termek['id']?>&tipus=2" class="termek">
            <img src="<?=$termek['kep']?>" width="150" height="200" alt="<?=$termek['nev']?>" alt = "Termék képe">
            <span class="nev"><?=$termek['nev']?></span>
            <span class="ar">
                <?=number_format($termek['ar'] / 1000, 3, ".", "");?> Forint
                <?php if ($termek['akcio_nelkuli_ar'] > 0): ?>
                <span class="akcio_ar"><?=number_format($termek['akcio_nelkuli_ar'] / 1000, 3, ".", "");?> Forint</span>
                <?php endif; ?>
            </span>
			<?php if($termek['mennyiseg'] > 0): ?>
				<span class = "termek-raktaron">Raktáron</span>
				<?php else: ?>
				<span class = "termek-nincs-raktaron">Nincs raktáron</span>
				<?php endif; ?>
        </a>
        <?php endforeach; ?>
	</div>
	<div class="oldal-valto-gombok">
        <?php if ($jelenlegi_oldal > 1): ?>
        <a href="index.php?oldal=autogumik&o=<?=$jelenlegi_oldal-1?>">Előző oldal</a>
        <?php endif; ?>
		<div class = "kovetkezo">
        <?php if ($termekek_osszesen > ($jelenlegi_oldal * $termekszam) - $termekszam + mysqli_num_rows($termekek)): ?>
        <a href="index.php?oldal=autogumik&o=<?=$jelenlegi_oldal+1?>">Következő oldal</a>
        <?php endif; ?>
		</div>
	</div>
</div>
<?php
//lablec es kapcsolat lezaras
lablec();
$stmt->close();
$conn->close();
?>
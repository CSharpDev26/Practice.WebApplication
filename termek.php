<?php 
//termek placeholder

//alapfunkciok hasznalata
include 'php/funkciok.php';
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("termek");
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
//termek adatainak lekerdezese
if (isset($_GET['id']) && isset($_GET['tipus'])) {
	$stmt = $conn->prepare('SELECT * FROM termekek WHERE id = ?');
	$stmt-> bind_param('i',$_GET['id']);
	$stmt->execute();
	$termek = $stmt->get_result();
	$stmt->close();
    if ($termek->num_rows < 1) {
		exit('Nem létező termék!');
    }
} else {
    exit('Nem létező termék!');
}
?>
<!-- termek ui -->
<div class="termek-egyben">
	<?php foreach ($termek as $t): ?>
	<div class = "nagyitas">
	<img src="<?=$t['kep']?>" width="250" height="300" alt="<?=$t['nev']?>" alt = "Termék képe">
	</div>
		<div>
        <h1 class="nev"><?=$t['nev']?></h1>
        <span class="ar">
            <?=number_format($t['ar'] / 1000, 3, ".", "");?> Forint
            <?php if ($t['akcio_nelkuli_ar'] > 0): ?>
            <span class="akcio_ar"><?=number_format($t['akcio_nelkuli_ar'] / 1000, 3, ".", "");?> Forint</span>
            <?php endif; ?>
        </span>
        <form action="index.php?oldal=kosar" method="post">
            <input type="number" name="mennyiseg" value="1" min="1" max="<?=$t['mennyiseg']?>" placeholder="Mennyiség" required>
            <input type="hidden" name="termek_id" value="<?=$t['id']?>">
            <input type="submit" value="Kosárba" id = "kosarbaid">
			<?php if($t['mennyiseg'] > 0): ?>
			  <?php $nincs_kosar = False; ?>
				<span class = "termek-raktaron">Raktáron</span>
				<?php else: ?>
				<span class = "termek-nincs-raktaron">Nincs raktáron</span>
				<?php $nincs_kosar = True; ?>
				<?php endif; ?>
        </form>
		<div class="leiras">
		<p>Leírás: </p>
        <?=$t['leiras']?>
        </div>
    </div>
	</div>
	<?php endforeach; ?>
	<?php
	//hasonlo termek lekeres (5)
	$hasonlo_termek_szam = 5;
	$stmt = $conn->prepare('SELECT * FROM termekek WHERE tipus = ? AND id != ? AND mennyiseg > ? ORDER BY datum_hozzaadva DESC LIMIT ?');
	$szam = 0;
	$stmt->bind_param('iiii',$_GET['tipus'],$_GET['id'],$szam,$hasonlo_termek_szam);
	$stmt->execute();
	$hasonlo_termek = $stmt->get_result();
	?>
	<!-- hasonlo termek ui -->
	<h2>Hasonló termékek: </h2>
	<div class = "hasonlo-termekek">
		<div class = "hasonlo-termek">
		<?php foreach($hasonlo_termek as $ht):?>
			<a href="index.php?oldal=termek&id=<?=$ht['id']?>&tipus=<?=$_GET['tipus']?>" >
			<div class = "hasonlo-termek-nagyito">
			<img src="<?=$ht['kep']?>" width="100" height="140" alt="<?=$ht['nev']?>">
			</div>
			<h3 class="nev"><?=$ht['nev']?></h3>
			<span class="ar">
            <?=number_format($ht['ar'] / 1000, 3, ".", "");?> Forint
            <?php if ($ht['akcio_nelkuli_ar'] > 0): ?>
            <span class="akcio_ar"><?=number_format($ht['akcio_nelkuli_ar'] / 1000, 3, ".", "");?> Forint</span>
            <?php endif; ?>
			</span>
			</a>
			<?php endforeach; ?>
		</div>
	</div>

<?php
	//termek nincs raktaron, kosar kikapcsolasa
	if($nincs_kosar){
	echo "<script>";
	echo "kosarkikapcs();";
	echo "</script>";
	}
//lablec es kapcsolat lezaras
lablec();
$stmt->close();
$conn->close();
?>
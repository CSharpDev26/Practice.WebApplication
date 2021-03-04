<?php
//fooldal

//alapfunkciok hasznalata
include 'php/funkciok.php';
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("fooldal");
//menu beallitasa (a szam csak az aktiv oldal jelzo)
menu(1);
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
//heti ajanaltok (akcios)
$stmt = $conn->prepare('SELECT * FROM termekek WHERE akcio_nelkuli_ar > ? AND mennyiseg > ? AND kifutott != ? ORDER BY datum_hozzaadva LIMIT ?');
$akcio_ar = 0;
$menny = 0;
$akcio_limit = 5;
$k = "igen";
$stmt->bind_param('iisi',$akcio_ar,$menny,$k,$akcio_limit);
$stmt->execute();
$eredmeny = $stmt->get_result();
//szamlalo a javascripthez
$szamlalo = 1;
?>
<h3> Üdvözöljük Webáruházunkban! </h3>
<p> E-heti akcióink: </p>
<!-- akcios termek osszefogva, 1 mutatatva, tobbi rejtve -->
<div class = "akcios-termekek">
			<?php foreach($eredmeny as $termek):?>
			<?php if($szamlalo == 1): ?>
			<a href="index.php?oldal=termek&id=<?=$termek['id']?>&tipus=<?=$termek['tipus']?>" class="termek">
            <img src="<?=$termek['kep']?>" width="200" height="250" alt="<?=$termek['nev']?>">
            <span class="nev"><?=$termek['nev']?></span>
            <span class="ar">
                <?=number_format($termek['ar'] / 1000, 3, ".", "");?> Forint
                <?php if ($termek['akcio_nelkuli_ar'] > 0): ?>
                <span class="akcio_ar"><?=number_format($termek['akcio_nelkuli_ar'] / 1000, 3, ".", "");?> Forint</span>
                <?php endif; ?>
            </span>
        </a>
			<?php $szamlalo = 2; ?>
			<?php else: ?>
				<a href="index.php?oldal=termek&id=<?=$termek['id']?>&tipus=<?=$termek['tipus']?>" class="termek-rejtett">
            <img src="<?=$termek['kep']?>" width="200" height="250" alt="<?=$termek['nev']?>">
            <span class="nev"><?=$termek['nev']?></span>
            <span class="ar">
                <?=number_format($termek['ar'] / 1000, 3, ".", "");?> Forint
                <?php if ($termek['akcio_nelkuli_ar'] > 0): ?>
                <span class="akcio_ar"><?=number_format($termek['akcio_nelkuli_ar'] / 1000, 3, ".", "");?> Forint</span>
                <?php endif; ?>
            </span>
        </a>
		<?php endif; ?>
		<?php endforeach;?>
</div>
<!-- script meghivasa a fajlbol -->
<script> akcioBetolto(); </script>
<?php
//lablec es kapcsolat lezaras
lablec();
$stmt->close();
$conn->close();
?>
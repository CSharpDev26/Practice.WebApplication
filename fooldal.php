<?php
include 'php/funkciok.php';
fejlec("fooldal");
menu(1);
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
$conn = adatb_csatlakozas();
$stmt = $conn->prepare('SELECT * FROM termekek WHERE akcio_nelkuli_ar > ? ORDER BY datum_hozzaadva LIMIT ?');
$akcio_ar = 0;
$akcio_limit = 5;
$stmt->bind_param('ii',$akcio_ar,$akcio_limit);
$stmt->execute();
$eredmeny = $stmt->get_result();
$stmt->close();
$conn->close();
$szamlalo = 1;
//$er = $eredmeny-> fetch_assoc();
//echo $er['kep']."<br>";
//$eredmeny->data_seek(0);
//$er = $eredmeny-> fetch_assoc();
//echo $er['kep'];
?>
<!-- Adatok -->
<h3> Üdvözöljük Webáruházunkban! </h3>
<p> E-heti akcióink: </p>
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
<script> akcioBetolto(); </script>
<!--POP-UP ablakok?-->
<?php
lablec();
?>
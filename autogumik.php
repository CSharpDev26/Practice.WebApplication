<?php
include 'php/funkciok.php';
fejlec("autogumik");
menu(2);
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
$termekszam = 12;
$jelenlegi_oldal = isset($_GET['o']) && is_numeric($_GET['o']) ? (int)$_GET['o'] : 1;
$stmt = $conn->prepare('SELECT * FROM termekek WHERE tipus = ? ORDER BY datum_hozzaadva DESC LIMIT ?,?');
$tarolo = ($jelenlegi_oldal - 1) * $termekszam;
$tipus = 2;
$stmt-> bind_param('iii',$tipus,$tarolo,$termekszam);
$stmt->execute();
$termekek = $stmt->get_result();
$stmt->close();
$termekek_a=mysqli_query($conn,"SELECT * FROM termekek WHERE tipus = 2");
$termekek_osszesen=mysqli_num_rows($termekek_a);
$conn->close();
?>
<div class = "termekek-egyben">
	<h1>Autógumik</h1>
	<p><?=$termekek_osszesen?> Termék</p>
	<div class = "termekek">
		<?php foreach ($termekek as $termek): ?>
        <a href="index.php?oldal=termek&id=<?=$termek['id']?>&tipus=2" class="termek">
            <img src="<?=$termek['kep']?>" width="150" height="200" alt="<?=$termek['nev']?>">
            <span class="nev"><?=$termek['nev']?></span>
            <span class="ar">
                <?=number_format($termek['ar'] / 1000, 3, ".", "");?> Forint
                <?php if ($termek['akcio_nelkuli_ar'] > 0): ?>
                <span class="akcio_ar"><?=number_format($termek['akcio_nelkuli_ar'] / 1000, 3, ".", "");?> Forint</span>
                <?php endif; ?>
            </span>
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
//lablec();
?>
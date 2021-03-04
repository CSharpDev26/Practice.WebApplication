<?php
//rendeles vege oldal

//alapfunkciok hasznalata
include 'php/funkciok.php';
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("rendelesosszegzo");
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
//kosarban levo termekek adatai, vegosszeg szamitas
$kosarban_termekek = isset($_SESSION['kosar']) ? $_SESSION['kosar'] : array();
$termekek = array();
$vegoszeg = 0.00;
$szallitasi_koltseg = 0;
$fizetesi_koltseg = 0;
$szallitasi_nev = "";
$fizetesi_nev = "";
if ($kosarban_termekek) {
	$kosar_szam = count($kosarban_termekek);
    $kosar_tomb = implode(',', array_fill(0 ,$kosar_szam, '?'));
    $stmt = $conn->prepare('SELECT * FROM termekek WHERE id IN (' . $kosar_tomb . ')');
	$parameter_str = str_repeat('i', $kosar_szam);
	$stmt->bind_param($parameter_str, ...array_keys($kosarban_termekek));
	$stmt->execute();
    $termekek = $stmt->get_result();
	if($termekek->num_rows > 0){
	foreach ($termekek as $termek) {
        $vegoszeg += $termek['ar'] * (int)$kosarban_termekek[$termek['id']];
    }
	}
}
//vegosszeg szamitas (szallitasi es fizetesi osszeg hozzaadas)
if(isset($_POST['szallit']) && isset($_POST['fizet'])){
	switch($_POST['szallit']){
	case "csomagpont":
	$vegoszeg += 800; 
	$szallitasi_koltseg = 800;
	$szallitasi_nev = "Csomagpont";
	break;
	case "hazhoz":
	$vegoszeg += 1200;
	$szallitasi_koltseg = 1200;
	$szallitasi_nev = "Házhoz szállítás";	
	break;
	case "szemelyes":
	$szallitasi_nev = "Személyes átvétel";
	$vegoszeg += 0; 
	break;
	}
	switch($_POST['fizet']){
	case "utanvet":
	$vegoszeg += 400;
	$fizetesi_koltseg = 400;
	$fizetesi_nev = "Utánvét";	
	break;
	case "paypal":
	$vegoszeg += 150;
	$fizetesi_koltseg = 150;
	$fizetesi_nev = "Pay-Pal";	
	break;
	case "bankkartya":
	$vegoszeg += 0; 
	$fizetesi_nev = "Bankkártya";
	break;
	}
}
?> 
<!-- rendeles ui -->
<h1>Rendelés összegzése</h1>
<div class="osszegzo-egesz">
    <form action="index.php?oldal=rendelesvege" method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Termék</td>
                    <td>Ár</td>
                    <td>Mennyiség</td>
                    <td>Részösszeg</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($termekek as $termek): ?>
                <tr>
                    <td class="kep">
                        <a href="index.php?oldal=termek&id=<?=$termek['id']?>&tipus=<?=$termek['tipus']?>">
                            <img src="<?=$termek['kep']?>" width="50" height="70" alt="<?=$termek['nev']?>">
                        </a>
                    </td>
                    <td>
                        <a id = "nev" href="index.php?oldal=termek&id=<?=$termek['id']?>&tipus=<?=$termek['tipus']?>"><?=$termek['nev']?></a>
                    </td>
                    <td class="ar"><?=number_format($termek['ar'] / 1000, 3, ".", "");?> Ft</td>
                    <td class="mennyiseg"><?=$kosarban_termekek[$termek['id']]?></td>
                    <td class="ar"><?=number_format($termek['ar']* $kosarban_termekek[$termek['id']] / 1000, 3, ".", ""); ?> Ft</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="vegosszeg">
			<span class="szoveg">Szállítási költség (<?=$szallitasi_nev?>): </span>
			<span class="ar"><?=$szallitasi_koltseg?> Ft</span><br>
			<span class="szoveg">Fizetési költség (<?=$fizetesi_nev?>): </span>
			<span class="ar"><?=$fizetesi_koltseg?> Ft</span><br>
            <span class="szoveg">Végösszeg: </span>
            <span class="arvege"><?=number_format($vegoszeg / 1000, 3, ".", "");?> Ft</span>
        </div>
        <div class="osszegzes-kuldese">
			<input type="hidden" value=<?=$vegoszeg?> name ="vegosszeg">
			<input type="hidden" value=<?=$fizetesi_koltseg?> name ="fizosszeg">
			<input type="hidden" value=<?=$szallitasi_koltseg?> name ="szallosszeg">
            <input type="submit" value="Rendelés" name="rendelesek">
        </div>
    </form>
</div>
<?php
//lablec es kapcsolat lezaras
lablec();
$stmt->close();
$conn->close();
?>
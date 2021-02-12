<?php 
include 'php/funkciok.php';
fejlec("kosar");
menu(0);
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
if (isset($_POST['termek_id'], $_POST['mennyiseg']) && is_numeric($_POST['termek_id']) && is_numeric($_POST['mennyiseg'])) {
    $termek_id = (int)$_POST['termek_id'];
    $mennyiseg = (int)$_POST['mennyiseg'];
    $stmt = $conn->prepare('SELECT * FROM termekek WHERE id = ?');
    $stmt->bind_param('i',$_POST['termek_id']);
	$stmt -> execute();
    $termek = $stmt->get_result();
    if (($termek->num_rows > 0) && $mennyiseg > 0) {
        if (isset($_SESSION['kosar']) && is_array($_SESSION['kosar'])) {
            if (array_key_exists($termek_id, $_SESSION['kosar'])) {
                $_SESSION['kosar'][$termek_id] += $mennyiseg;
            } else {
                $_SESSION['kosar'][$termek_id] = $mennyiseg;
            }
        } else {
            $_SESSION['kosar'] = array($termek_id => $mennyiseg);
        }
    }
    header('location: index.php?oldal=kosar');
    exit;
}
if (isset($_GET['torles']) && is_numeric($_GET['torles']) && isset($_SESSION['kosar']) && isset($_SESSION['kosar'][$_GET['torles']])) {
    unset($_SESSION['kosar'][$_GET['torles']]);
}
if (isset($_POST['frissit']) && isset($_SESSION['kosar'])) {
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'mennyiseg') !== false && is_numeric($v)) {
            $id = str_replace('mennyiseg-', '', $k);
            $mennyiseg = (int)$v;
			if (is_numeric($id) && isset($_SESSION['kosar'][$id]) && $mennyiseg > 0) {
				$_SESSION['kosar'][$id] = $mennyiseg;
            }
        }
    }
    header('location: index.php?oldal=kosar');
    exit;
}
if (isset($_POST['rendelesek']) && isset($_SESSION['kosar']) && !empty($_SESSION['kosar'])) {
    header('Location: index.php?oldal=rendelesvalaszto');
    exit;
}

$kosarban_termekek = isset($_SESSION['kosar']) ? $_SESSION['kosar'] : array();
$termekek = array();
$vegoszeg = 0.00;
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
?>
<h1>Kosár</h1>
<div class="kosar-egesz">
    <form action="index.php?oldal=kosar" method="post">
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
                <?php if (empty($termekek)): ?>
                <tr>
                    <td colspan="5" style="text-align:center; color:blue; font-size:18pt;">A kosárban nem található termék!</td>
                </tr>
                <?php else: ?>
                <?php foreach ($termekek as $termek): ?>
                <tr>
                    <td class="kosarkep">
                        <a href="index.php?oldal=termek&id=<?=$termek['id']?>&tipus=<?=$termek['tipus']?>">
                            <img src="<?=$termek['kep']?>" width="50" height="70" alt="<?=$termek['nev']?>">
                        </a>
                    </td>
                    <td>
                        <a id = "nev" href="index.php?oldal=termek&id=<?=$termek['id']?>&tipus=<?=$termek['tipus']?>"><?=$termek['nev']?></a>
                        <br>
                        <a href="index.php?oldal=kosar&torles=<?=$termek['id']?>" class="eltavolitas">Eltávolítás</a>
                    </td>
                    <td class="ar"><?=number_format($termek['ar'] / 1000, 3, ".", "");?> Ft</td>
                    <td class="mennyiseg">
                        <input type="number" name="mennyiseg-<?=$termek['id']?>" value="<?=$kosarban_termekek[$termek['id']]?>" min="1" max="<?=$termek['mennyiseg']?>" placeholder="Mennyiség" required>
                    </td>
                    <td class="ar"><?=number_format($termek['ar']* $kosarban_termekek[$termek['id']] / 1000, 3, ".", ""); ?> Ft</td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="vegosszeg">
            <span class="szoveg">Végösszeg: </span>
            <span class="ar"><?=number_format($vegoszeg / 1000, 3, ".", "");?> Ft</span>
        </div>
        <div class="gombok">
            <input type="submit" value="Frissítés" name="frissit">
            <input type="submit" value="Rendelés" name="rendelesek">
        </div>
    </form>
</div>

<?php
//lablec();
?>
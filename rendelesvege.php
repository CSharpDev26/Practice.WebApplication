<?php
//rendeles feldolgozasa, majd visszajelzes

//alapfunkciok hasznalata
include 'php/funkciok.php';
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("rendelesvege");
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
//feldolgozas
$kosarban_termekek = isset($_SESSION['kosar']) ? $_SESSION['kosar'] : array();
$termekek = array();
$vegoszeg = 0;
$fizgoszeg = 0;
$szalloszeg = 0;
if(isset($_POST['vegosszeg']) && isset($_POST['fizosszeg']) && isset($_POST['szallosszeg'])){
	$vegoszeg = $_POST['vegosszeg'];
	$fizgoszeg = $_POST['fizosszeg'];
	$szalloszeg = $_POST['szallosszeg'];
}
if ($kosarban_termekek) {
	$kosar_szam = count($kosarban_termekek);
    $kosar_tomb = implode(',', array_fill(0 ,$kosar_szam, '?'));
    $stmt = $conn->prepare('SELECT * FROM termekek WHERE id IN (' . $kosar_tomb . ')');
	$parameter_str = str_repeat('i', $kosar_szam);
	$stmt->bind_param($parameter_str, ...array_keys($kosarban_termekek));
	$stmt->execute();
    $termekek = $stmt->get_result();
	$stmt->close();
}
	$stmt = $conn->prepare('SELECT id FROM rendelesek ORDER BY ID DESC LIMIT ?');
	$limit = 1;
	$stmt->bind_param('i',$limit);
	$stmt->execute();
	$id_seged =  $stmt->get_result();
	if($id_seged->num_rows > 0){
	$id_seged1 = $id_seged -> fetch_assoc();
	$id = $id_seged1['id'] + 1;
	}
	else{
	$id = 1;
	}
	$stmt->close();
	
	$stmt = $conn->prepare('INSERT INTO rendelesek(id,fid,fizetesi_koltseg,szallitasi_koltseg,vegosszeg,teljesitve) VALUES(?,?,?,?,?,?)');
	$telj = "nem";
	$stmt->bind_param('iiiiis',$id,$_SESSION['id'],$fizgoszeg,$szalloszeg,$vegoszeg,$telj);
	$stmt->execute();

$termek_mail = array();
foreach ($termekek as $termek){
	$stmt = $conn->prepare('UPDATE termekek SET mennyiseg = ? WHERE id = ?');
	$mennyiseg = $termek['mennyiseg'] - $_SESSION['kosar'][$termek['id']];
	$stmt->bind_param('ii',$mennyiseg,$termek['id']);
	$stmt->execute();
	$stmt->close();
	$stmt = $conn->prepare('INSERT INTO rendelesek_termekek(rendeles_id,termek_id,mennyiseg) VALUES(?,?,?)');
	$stmt->bind_param('iii',$id,$termek['id'],$_SESSION['kosar'][$termek['id']]);
	$stmt->execute();
	array_push($termek_mail,array($termek['nev'],$_SESSION['kosar'][$termek['id']]));
}
		//mail szerviz
				$tol    = 'papdis@gmail.com';
				$targy = 'Köszönjük rendelését!';
				$fejlec = 'From: ' . $tol . "\r\n" . 'Reply-To: ' . $tol . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
				$uzenet = '<h1>P Webáruház</h1><h3>Köszönjük rendelését.</h3><p>Rendelés száma: #'.$id.'</p><p>Termékek:</p>';
				foreach($termek_mail as $termek_m){
					$uzenet .= '<p>';
					$uzenet .= $termek_m[0];
					$uzenet .= ': ';
					$uzenet .= $termek_m[1];
					$uzenet .= ' db';
					$uzenet .= '</p>';
				}
				$uzenet .= '<p>Szállítási költség: ';
				$uzenet .= $szalloszeg;
				$uzenet .= ' Forint</p><p>Fizetési költség: ';
				$uzenet .= $fizgoszeg;
				$uzenet .= ' Forint</p><p>Végösszeg: ';
				$uzenet .= number_format($vegoszeg / 1000, 3, ".", "");
				$uzenet .= ' Forint</p>';
				$uzenet .= '<p>A továbbiakról hamarosan értesítjük!</p>';
				mail($_SESSION['email'], $targy, $uzenet, $fejlec);
//kosar uritese
if (isset($_SESSION['kosar'])) {
	unset($_SESSION['kosar']);
	}
?>
<h1>Rendelés sikerült, e-mailben elküldtük az összegzést!</h1>
<?php
//lablec es kapcsolat lezaras
lablec();
$stmt->close();
$conn->close();
?>
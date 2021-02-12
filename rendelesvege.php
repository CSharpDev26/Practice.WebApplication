<?php
include 'php/funkciok.php';
fejlec("rendelesvege");
menu(0);
$conn = adatb_csatlakozas();
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
	$stmt->close();

foreach ($termekek as $termek){
	$stmt = $conn->prepare('UPDATE termekek SET mennyiseg = ? WHERE id = ?');
	$mennyiseg = $termek['mennyiseg'] - $_SESSION['kosar'][$termek['id']];
	$stmt->bind_param('ii',$mennyiseg,$termek['id']);
	$stmt->execute();
	$stmt->close();
	$stmt = $conn->prepare('INSERT INTO rendelesek_termekek(rendeles_id,termek_id,mennyiseg) VALUES(?,?,?)');
	$stmt->bind_param('iii',$id,$termek['id'],$_SESSION['kosar'][$termek['id']]);
	$stmt->execute();
	
}
	

	
//BEJELENTKEZES NELKUL NE TUDJON RENDELNI!!!
//if (isset($_SESSION['kosar'])) {
//unset($_SESSION['kosar']);
//}
?>
<h1>Rendelés sikerült, e-mailben elküldtük az összegzést!</h1>
<?php
lablec();
?>
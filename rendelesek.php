<?php 
include 'php/funkciok.php';
//$conn = adatb_csatlakozas();
fejlec("rendelesek");
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
?>
<?php
lablec();
?>
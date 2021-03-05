<?php 
//elerhetoseg oldal

//alapfunkciok hasznalata
include 'php/funkciok.php';
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("elerhetoseg");
//menu beallitasa (a szam csak az aktiv oldal jelzo)
menu(4);
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
?>
<!-- dummy szoveg -->
<p> 
  Lorem ipsum dolor sit amet consectetur adipisicing elit. Nihil distinctio, neque quis consequuntur accusamus rerum blanditiis, optio tempora eaque animi magnam commodi aspernatur labore illo reprehenderit incidunt. Perferendis quidem molestias officiis praesentium assumenda a fugit itaque eum. Doloremque repellat adipisci, iure sed libero laborum possimus ex officia reiciendis ipsum unde atque excepturi corrupti placeat harum quibusdam velit dolores quam explicabo cupiditate doloribus facilis! Commodi, natus. Illum totam deserunt, ut in aliquid dolore dignissimos alias accusantium voluptatem ex similique hic quis tempore facilis sit nostrum. Voluptatibus deleniti quos nostrum rem illo, error modi quisquam laudantium amet vitae harum, sit, atque laborum?
</p>
<!-- form az irashoz az oldalnak -->
<p id = "irjon"> Írjon nekünk! </p>
<form action = "index.php?oldal=elerhetoseg" id = "kommentform" method = "post">
<input type = "submit" value = "Küldés" name = "kuldess">
</form>
 <span class="popupszoveg" id="popupid"></span>
<textarea name = "komment" form="kommentform" rows="10" cols="50" placeholder="Írjon nekünk bátran, hamarosan válaszolunk!">
</textarea>
<?php 
//form feldolgozas, csak akkor lehet irni ha bevan jelentkezve
if(isset($_POST['kuldess'])){
if(isset($_POST['komment']) && $_POST['komment'] != "" && isset($_SESSION['id'])){
	$stmt = $conn->prepare('INSERT INTO kommentek (fid,komment) VALUES(?,?)');
	$stmt->bind_param('is',$_SESSION['id'],$_POST['komment']);
	$stmt->execute();
	//ha sikeres akkor popup ablak megjelenitese javascripttel
	if($stmt->affected_rows >= 1){
	echo '<script>';
	echo 'popUp("sikeres");';
	echo '</script>';
	}
	else{
	echo '<script>';
	echo 'popUp("sikertelen");';
	echo '</script>';
	}
	$stmt->close();
}
else{
	echo '<script>';
	echo 'popUp("sikertelen");';
	echo '</script>';
}
}
?>
<?php
//lablec es kapcsolat lezaras
lablec();
$conn->close();
?>
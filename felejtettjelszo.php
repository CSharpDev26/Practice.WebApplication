<?php
//felejtett jelszo ui

//alapfunkciok hasznalata
include 'php/funkciok.php';
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("felejtettjelszo");
//menu beallitasa (a szam csak az aktiv oldal jelzo)(0, akkor nincs aktiv)
menu(0);
//nincs bejelentkezve termeszetesen, ui
	echo "<script>";
	echo 'var x = window.matchMedia("(max-width: 900px)");';
	echo "nincs_bejelentkezve(x);";
	echo 'x.addListener(nincs_bejelentkezve);';
	echo "</script>";
?> 
<!-- form az uj jelszohoz -->
<form action = "php/felejtettjkuldo.php" method = "post">
		<label>E-mail cím</label><br>
        <input type="email" id = "email" name = "email" required><br>
        <input type="submit" value="E-mail küldése" name = "submit"><br>
</form>
<?php
//lablec
lablec();
?>
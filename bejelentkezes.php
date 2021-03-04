<?php
//bejelentkezes ui

//alapfunkciok hasznalata
include 'php/funkciok.php';
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("bejelentkezes");
//menu beallitasa (a szam csak az aktiv oldal jelzo)(ha 0 akkor nincs aktiv oldal)
menu(0);
//javascript az ui megvaltoztatasa, nem vagyunk bejelentkezve
echo "<script>";
echo "nincs_bejelentkezve();";
echo "</script>";
?>   
<!-- bejelentkezes form -->
	<form action = "php/bejel_ellenorzes.php" method = "POST">
        <label>E-mail cím</label><br>
        <input type="email" id = "email" name = "email" required><br>
        <label> Jelszó</label><br>
        <input type="password" id = "jelszo" name = "jelszo" required><br>
        <input type="submit" value="Bejelentkezés" name = "submit"><br>
        <a href="index.php?oldal=regisztracio" id = "reg"> Regisztráció </a><br>
		<a href="index.php?oldal=felejtettjelszo" id = "reg"> Elfelejtett jelszó </a>
    </form>
    
<?php
//lablec
lablec();
?>
<?php
include 'php/funkciok.php';
fejlec("bejelentkezes");
menu(0);
echo "<script>";
echo "nincs_bejelentkezve();";
echo "</script>";
?>   
	<form action = "php/bejel_ellenorzes.php" method = "POST">
        <label>E-mail cím</label><br>
        <input type="email" id = "email" name = "email" required><br>
        <label> Jelszó</label><br>
        <input type="password" id = "jelszo" name = "jelszo" required><br>
        <input type="submit" value="Bejelentkezés" name = "submit"><br>
        <a href="index.php?oldal=regisztracio" id = "reg"> Regisztráció </a>
    </form>
    
<?php
lablec();
?>
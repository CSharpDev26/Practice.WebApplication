<?php
//index csak az oldal navigacio kiindulásához használjuk
//css mobilra, szamla kuldese emailben?
session_start();
$oldal = isset($_GET['oldal']) && file_exists($_GET['oldal'] . '.php') ? $_GET['oldal'] : 'fooldal';
include $oldal . '.php';
/*
fajlszerkezet:
webapp -> minden ui-al rendelkezo php ebben a mappaban talalhato
webapp/php -> alap funkciok es feldolgozo ui nelkuli php fajlok
webapp/css -> minden oldal css fajlja
webapp/fpdf -> a pdf krealo konyvtar fajlai
webapp/datab -> az adatbazis fajl
webapp/kepek -> menu kepei
webapp/scripts -> javascript fajlok
webapp/termekek -> termek kepeinek mappaja
webapp/szamlak -> az elkeszitett szamlak pdf-ei
webapp/keszappkepek screenshot-ok az approl

adatbazis szerkezet:
webapplication-database
	cimek
		id (elsodleges kulcs)
		fid (felhasznalo id) (kulso kulcs)
		hazszam
		irsz
		varos
		utca
	felhasznalok
		id (elsodleges kulcs)
		aktivalokod (regisztralasnal)
		email
		jelszo (hash-elt)
		keresztnev
		veznev
	kommentek
		id (elsodleges kulcs)
		datum
		fid (felhasznalo id) (kulso kulcs)
		komment
		olvasott (uzemeltetok lattak-e)
	rendelesek
		id (elsodleges kulcs)
		datum
		fid (felhasznalo id) (kulso kulcs)
		fizetesi_koltseg
		szallitasi_koltseg
		vegosszeg
		teljesitve
	rendelesek_termekek (termek megkeresesehez)
		rendeles_id (elsodleges kulcs) (kulso kulcs)
		termek_id (elsodleges kulcs) (kulso kulcs)
		mennyiseg
	termekek
		id (elsodleges kulcs)
		datum_hozzaadva
		ar
		akcio_nelkuli_ar (ha 0 akkor nincs akciozva)
		kep (termekek/fajlnev,kiterjesztes formatum)
		kifutott (torolve van-e az oldalrol)
		leiras
		mennyiseg
		nev
		tipus (3 termek tipus)
		

 */

?>

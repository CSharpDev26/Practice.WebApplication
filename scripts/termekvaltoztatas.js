function bejelentkezve(keresztnev,id){
var udv = document.getElementById("udv");
udv.innerHTML = "ÜDV, " + keresztnev;
udv.style.display = "block";

var bejel = document.getElementById("bejelentkezes");
bejel.style.display = "none";

var kijel = document.getElementById("kijelentkezes");
kijel.style.display = "block";

if(id != 1 && id != 2){
var profil = document.getElementById("profil");
profil.style.display = "block";
}

var rendelesek = document.getElementById("rendelesek");
var termekv = document.getElementById("termekv");
var kosar = document.getElementById("kosar");

if(id == 1 || id == 2 )
{
	rendelesek.style.display = "block";
	kosar.style.display = "none";
}
if(id == 1)
{
	termekv.style.display = "block";
}
}
function nincs_bejelentkezve(){
	var kosarj = document.getElementById("kosar_jelzo");
	kosarj.style.right = "245px";
}
// termek valtoztatasanak opcionalis elrejtese-mutatasa
function termekHozzaAdAktiv(){
	var termekhozzaad = document.getElementsByClassName("termekhozzaadas-osszefogo");
	var termekszerk = document.getElementsByClassName("termekszerkesztes-osszefogo-aktiv");
	if(termekhozzaad !== null){
	termekhozzaad[0].classList.add("termekhozzaadas-osszefogo-aktiv");
	termekhozzaad[0].classList.remove("termekhozzaadas-osszefogo");
	}
	if(termekszerk !== null){
	termekszerk[0].classList.add("termekszerkesztes-osszefogo");
	termekszerk[0].classList.remove("termekszerkesztes-osszefogo-aktiv");
	}
}
function termekSzerkesztAktiv(){
	var termekhozzaad = document.getElementsByClassName("termekhozzaadas-osszefogo-aktiv");
	var termekszerk = document.getElementsByClassName("termekszerkesztes-osszefogo");
	if(termekszerk !== null){
	termekszerk[0].classList.add("termekszerkesztes-osszefogo-aktiv");
	termekszerk[0].classList.remove("termekszerkesztes-osszefogo");
	}
	if(termekhozzaad !== null){
	termekhozzaad[0].classList.add("termekhozzaadas-osszefogo");
	termekhozzaad[0].classList.remove("termekhozzaadas-osszefogo-aktiv");
	}
}
function popUp(siker){
  var popup = document.getElementById("popupid");
  if(siker == "sikeres")
	  popup.innerHTML = "Sikeres termékfelvétel!";
  else
	  popup.innerHTML = "Sikertelen termékfelvétel!";
  popup.classList.toggle("popup-mutat");
  var t = setTimeout(function(){ popUpIdozito() }, 3000);
}

function popUpIdozito(){
	var popup = document.getElementById("popupid");
	  popup.classList.toggle("popupszoveg");
	  popup.innerHTML = "";
}
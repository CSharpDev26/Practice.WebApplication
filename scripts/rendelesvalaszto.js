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
//gombok javascript (mutatas-elrejtes)
function hazhoz_gomb(){
	var szallitasi_cim = document.getElementsByClassName("szallitasi-cim");
	szallitasi_cim[0].classList.add("szallitasi-cim-lathato");
	szallitasi_cim[0].classList.remove("szallitasi-cim");
}
function tovabb(){
	var gomb = document.getElementById("rendeles_osszegzo");
	if(gomb != null)
	gomb.disabled = true;
	gomb.style.opacity = 0.5;
}
function mas_gomb(){
	var szallitasi_cim = document.getElementsByClassName("szallitasi-cim-lathato");
	if(szallitasi_cim[0] != null){
	szallitasi_cim[0].classList.add("szallitasi-cim");
	szallitasi_cim[0].classList.remove("szallitasi-cim-lathato");
	}
}

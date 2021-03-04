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
//kosar gomb kikapcsolasa
function kosarkikapcs(){
	var gomb = document.getElementById("kosarbaid");
	if(gomb != null)
	gomb.disabled = true;
	gomb.style.opacity = 0.5;
}
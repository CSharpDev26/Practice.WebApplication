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
//popup
function popUp(siker){
  var popup = document.getElementById("popupid");
  if(siker == "sikeresfeltoltes")
	  popup.innerHTML = "Sikeres képfeltöltés!";
  else if(siker == "sikertelenfeltoltes")
	  popup.innerHTML = "Sikertelen képfeltöltés!";
  else if(siker == "sikeresvaltoztatas")
	  popup.innerHTML = "Sikeres változtatás!";
  else
	  popup.innerHTML = "Sikeres törlés!";
  popup.classList.toggle("popup-mutat");
  var t = setTimeout(function(){ popUpIdozito(siker) }, 1000);
}

function popUpIdozito(siker){
	var popup = document.getElementById("popupid");
	  popup.classList.toggle("popupszoveg");
	  popup.innerHTML = "";
	  if(siker != "sikeresfeltoltes" && siker != "sikertelenfeltoltes")
	  window.location.reload(true);  
}
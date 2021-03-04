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
  if(siker == "sikeresolvasott")
	  popup.innerHTML = "Sikeres változtatás!";
  else if(siker == "sikertelenolvasott")
	  popup.innerHTML = "Sikertelen változtatás!";
  
    else if(siker == "sikeresteljesites")
	  popup.innerHTML = "Sikeres rendelés teljesítés!";
    else if(siker == "sikertelenteljesites")
	  popup.innerHTML = "Sikertelen rendelés teljesítés!";
  
    else if(siker == "sikerestorles")
	  popup.innerHTML = "Sikeres rendelés törlés!";
    else if(siker == "sikertelentorles")
	  popup.innerHTML = "Sikertelen rendelés törlés!";
  
  popup.classList.toggle("popup-mutat");
  var t = setTimeout(function(){ popUpIdozito() }, 3000);
}

function popUpIdozito(){
	var popup = document.getElementById("popupid");
	  popup.classList.toggle("popupszoveg");
	  popup.innerHTML = "";
}
var szamlalo = 1;
var eloszor = true;

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

function akcioAllitas(){
	var mutatott = document.getElementsByClassName("termek");
	var rejtett = document.getElementsByClassName("termek-rejtett");
	if(eloszor){
		eloszor = false;
	}
	else{
		mutatott[0].classList.add("termek-rejtett");
		mutatott[0].classList.remove("termek");
		if(szamlalo != 4){
		rejtett[szamlalo].classList.add("termek");
		rejtett[szamlalo].classList.remove("termek-rejtett");
		szamlalo++;
		}
		else{
		rejtett[szamlalo].classList.add("termek");
		rejtett[szamlalo].classList.remove("termek-rejtett");
		szamlalo = 0;
		}
	}
	
}
function akcioBetolto(){
	akcioAllitas();
	var t = setTimeout(function(){ akcioBetolto() }, 3000);
}
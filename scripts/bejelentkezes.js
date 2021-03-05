function nincs_bejelentkezve(x){
	var kosarj = document.getElementById("kosar_jelzo");
	var kosar = document.getElementById("kosar");
	 if (x.matches) { 
		kosarj.style.left = "245px";
		kosar.style.marginRight = "80px";
	 }
	 else{
		kosarj.style.right = "245px";
	 }
}
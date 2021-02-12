<?php 
include 'php/funkciok.php';
fejlec("elerhetoseg");
menu(4);
if (isset($_SESSION['bejelentkezve'])) {
echo "<script>";
echo "bejelentkezve(\"".$_SESSION['keresztnev']."\",".$_SESSION['id'].");";
echo "</script>";
}
else{
	echo "<script>";
	echo "nincs_bejelentkezve();";
	echo "</script>";
}
?>
<p> 
  Lorem ipsum dolor sit amet consectetur adipisicing elit. Nihil distinctio, neque quis consequuntur accusamus rerum blanditiis, optio tempora eaque animi magnam commodi aspernatur labore illo reprehenderit incidunt. Perferendis quidem molestias officiis praesentium assumenda a fugit itaque eum. Doloremque repellat adipisci, iure sed libero laborum possimus ex officia reiciendis ipsum unde atque excepturi corrupti placeat harum quibusdam velit dolores quam explicabo cupiditate doloribus facilis! Commodi, natus. Illum totam deserunt, ut in aliquid dolore dignissimos alias accusantium voluptatem ex similique hic quis tempore facilis sit nostrum. Voluptatibus deleniti quos nostrum rem illo, error modi quisquam laudantium amet vitae harum, sit, atque laborum?
</p>
<p id = "irjon"> Írjon nekünk! </p>
<textarea rows="10" cols="50" placeholder="Írjon nekünk bátran, hamarosan válaszolunk!">
</textarea>
<button id = "kuldes">Küldés</button>
<?php
lablec();
?>
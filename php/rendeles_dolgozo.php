<?php
//rendeles uzemelteto oldalon valo feldolgozasa

//alapfunkciok hasznalata
include 'funkciok.php';
//pdf krealasahoz
require('../fpdf/fpdf.php');
//adatbazis csatlakozas a funkciok.php-bol
$conn = adatb_csatlakozas();
//popuphoz visszajelzes
$sikeresseg = "";
//komment frissites
if(isset($_POST['submitkomment'])){
$stmt = $conn->prepare('SELECT * FROM kommentek');
$stmt->execute();
$kommentek = $stmt->get_result();
if(!empty($_POST['olvasvalt'])){
$i = 0;
$olvasotta_tesz = "Igen";
while($i < $kommentek->num_rows){
	if(in_array($_POST['kommentid'][$i],$_POST['olvasvalt'])){
	$stmt = $conn->prepare('UPDATE kommentek SET olvasott = ? WHERE id = ?');
	$stmt->bind_param('si',$olvasotta_tesz,$_POST['kommentid'][$i]);
	$stmt->execute();
					if($stmt->affected_rows > 0){
					$sikeresseg = "sikeresolvasott";
					}
					else{
					$sikeresseg = "sikertelensolvasott";
					}
}
	$i++;
}
}
$stmt->close();
header('Location: ../index.php?oldal=rendelesek&siker='.$sikeresseg);
}
//rendeles teljesitese
if(isset($_POST['steljesit'])){
$stmt = $conn->prepare('SELECT * FROM rendelesek ORDER BY teljesitve DESC');
$stmt->execute();
$rendeles_alap = $stmt -> get_result();
	if(!empty($_POST['termekcheckbox'])){
		$i = 0;
		$teljesitette_tesz = "igen";
		while($i < $rendeles_alap->num_rows){
			if(in_array($_POST['rendelescheckid'][$i],$_POST['termekcheckbox'])){
					$stmt = $conn->prepare('UPDATE rendelesek SET teljesitve = ? WHERE id = ?');
					$stmt->bind_param('si',$teljesitette_tesz,$_POST['rendelescheckid'][$i]);
					$stmt->execute();
					if($stmt->affected_rows > 0){
					$sikeresseg = "sikeresteljesites";
					}
					else{
						$sikeresseg = "sikertelenteljesites";
					}
					$stmt1 = $conn->prepare('SELECT email FROM felhasznalok WHERE id = ?');
					$stmt1 -> bind_param('i',$_POST['rendelesfid'][$i]);
					$stmt1->execute();
					$email = $stmt1 -> get_result();
					$emil = $email->fetch_assoc();
					$stmt1->close();
//pdf krealas (szamla)
$pdf=new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(10,10,iconv('UTF-8', 'windows-1250', "Számla"),0,1,'C');

$pdf->SetFont('Arial','',12);

$pdf->Cell(40,10,iconv('UTF-8', 'windows-1250', "Rendelés száma: "),1,0,'C');

$pdf->Cell(10,10,"#".$_POST['rendelescheckid'][$i],1,1,'C');

$pdf->Cell(20,10,iconv('UTF-8', 'windows-1250', "Termékek"),0,1,'C');

$pdf->Cell(100,10,iconv('UTF-8', 'windows-1250', "Név"),1,0,'C');
$pdf->Cell(25,10,iconv('UTF-8', 'windows-1250', "Mennyiség"),1,0,'C');
$pdf->Cell(20,10,iconv('UTF-8', 'windows-1250', "Összeg"),1,1,'C');
$sql = "SELECT * FROM termekek t JOIN rendelesek_termekek rt ON rt.termek_id = t.id WHERE rt.rendeles_id = ?";
$stmt = $conn->prepare($sql);
$stmt -> bind_param('i',$_POST['rendelescheckid'][$i]);
$stmt -> execute();
$termekek = $stmt -> get_result();
foreach($termekek as $termek):
$pdf->Cell(100,10,iconv('UTF-8', 'windows-1250', $termek['nev']),1,0,'C');
$pdf->Cell(25,10,$termek['mennyiseg']." db",1,0,'C');
$arszamolva = number_format(($termek['mennyiseg']*$termek['ar']) / 1000, 3, ".", "");
$pdf->Cell(20,10,$arszamolva." Ft",1,1,'C');
endforeach;
$sql = "SELECT * FROM rendelesek WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt -> bind_param('i',$_POST['rendelescheckid'][$i]);
$stmt -> execute();
$rend_s = $stmt -> get_result();
$rend = $rend_s -> fetch_assoc();

$pdf->Cell(10,10,"",0,1,'C');
$pdf->Cell(50,10,iconv('UTF-8', 'windows-1250', "Szállítási költség: "),1,0,'C');
$pdf->Cell(20,10,$rend['szallitasi_koltseg']." Ft",1,1,'C');

$pdf->Cell(50,10,iconv('UTF-8', 'windows-1250', "Fizetési költség: "),1,0,'C');
$pdf->Cell(20,10,$rend['fizetesi_koltseg']." Ft",1,1,'C');

$pdf->Cell(50,10,iconv('UTF-8', 'windows-1250', "Végösszeg: "),1,0,'C');
$pdf->Cell(20,10,number_format($rend['vegosszeg'] / 1000, 3, ".", "")." Ft",1,1,'C');
$pdf->Cell(10,10,"",0,1,'C');

$pdf->Cell(30,10,"Alairas: ",0,0,'C');
$pdf->Cell(10,10," ................",0,0,'C');
$hely = '../szamlak/szamla'.$_POST['rendelescheckid'][$i].'.pdf';
$pdf->Output($hely,'F');	
					$from    = 'papdis@gmail.com';
					$subject = 'Rendelés teljesítve!';
					$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
					$message = '<h1>P Webáruház</h1><p>Köszönjük megrendelését, a csomag átvehető!</p>';
					mail($emil['email'], $subject, $message, $headers);
			}
				$i++;
		}
	}
$stmt->close();
header('Location: ../index.php?oldal=rendelesek&siker='.$sikeresseg);
}
//rendeles torlese (nem toroljuk az adatbazisbol)
if(isset($_POST['storol'])){
$stmt = $conn->prepare('SELECT * FROM rendelesek ORDER BY teljesitve DESC');
$stmt->execute();
$rendeles_alap = $stmt -> get_result();
	if(!empty($_POST['termekcheckbox'])){
		$i = 0;
		$teljesitette_tesz = "lemondott";
		while($i < $rendeles_alap->num_rows){
			if(in_array($_POST['rendelescheckid'][$i],$_POST['termekcheckbox'])){
					$stmt = $conn->prepare('UPDATE rendelesek SET teljesitve = ? WHERE id = ?');
					$stmt->bind_param('si',$teljesitette_tesz,$_POST['rendelescheckid'][$i]);
					$stmt->execute();
					if($stmt->affected_rows > 0){
						$sikeresseg = "sikerestorles";
					}
					else{
						$sikeresseg = "sikertelentorles";
					}
			}
				$i++;
		}
	}
	$stmt->close();
header('Location: ../index.php?oldal=rendelesek&siker='.$sikeresseg);
}
$conn->close();
?>
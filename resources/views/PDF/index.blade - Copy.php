<?php
include "public/mpdf60/mpdf.php";
session_start();
$html = $_SESSION['his'];
$tipo = $_SESSION['tipo'];
$tipulo = $_SESSION['tipulo'];
$autor = $_SESSION['autor'];
$marca_agua = $_SESSION['marca_agua'];
$um = $_SESSION['um'];
$dois = $_SESSION['dois'];
$tres = $_SESSION['tres'];
$quatro = $_SESSION['quatro'];
$sinco = $_SESSION['sinco'];
$seis = $_SESSION['seis'];



//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================



$mpdf=new mPDF('c',$tipo,'','',$um,$dois,$tres,$quatro,$sinco,$seis); 
$mpdf->SetProtection(array('print'));
$mpdf->SetTitle($tipulo);
$mpdf->SetAuthor($autor);
$mpdf->SetWatermarkText($marca_agua);
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');



$mpdf->WriteHTML($html);


$mpdf->Output(); exit;

exit;
    

?>

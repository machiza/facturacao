<?php

ini_set('max_execution_time', 800);
ini_set("memory_limit","512M");

include "public/mpdf60/mpdf.php";
$inicio = '<div class="container">';
$tabelainicio='<table class="table table-bordered" style="padding-top:-20px; border:none; width: 100%"><tbody>';
    
  $todosLinhas="";
     foreach ($cheques as $cheque) {
        $linhaInicio ='<tr>';
            $culuna='<td style="padding:5px"><br>'; 
                   
            $culuna=$culuna.'<div style="padding-top: -40px">
                       <div  style="font-size:20px; font-weight:bold; font-family:ctimes">Cheque de combustivel FUEL</div>
                    <h4 style="font-size:16px; font-weight:normal; font-family:ctimes;">
                            <strong style="font-size:16px; font-weight:bold; font-family:ctimes">Cliente: </strong>'.str_limit(strip_tags($cliente),20). '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:20px; font-weight:bold; font-family:ctimes">Valor:______________________</span></h4> 
                               <br>
                            <barcode code='.$cheque->reference.' type="C128A" class="barcode" size="1.8"  height="1.3" />
                              <div style="padding-right:10px; font-size:20px; font-weight:normal; font-family:ctimes">
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$cheque->reference.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:20px; font-weight:bold; font-family:ctimes">Qty:______________________</span></div> 
                            <h5 style="text-align: center; font-size:11px; font-weight:normal; font-family:ctimes" ><strong style="font-weight:bold;">&nbsp;&nbsp;&nbsp;Data emissao: </strong>'.formatDate($cheque->created_at).'<strong style="font-weight:bold;"> Validade: </strong> 6 Meses </h5>

                            <h5  style="font-size:10px;font-family:ctimes">&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor da senha a data e do local de consumo</h6>  
                        </div> 
                          '; 
          
          '</td> <br>';

       
     $linhaFim='</tr>';
                
    $todosLinhas=$todosLinhas.$linhaInicio.$culuna.$linhaFim;

     }



   $tabelafim='</tbody>
  </table>
     
      <div>
             <div style="width:500px; float:left; font-size:10px; color:#383838; font-weight:bold;">
                <div>Documento processado por Computador</div>
              </div>
              <div style="width:270px;font-weight:bold; float:right; font-size:10px; color:#383838;">
                 <div>Software N3 Licenciado a:'.Session::get('company_name').'</div>    
              </div>
         </div> 
</div>';
$all=$inicio.$tabelainicio. $todosLinhas.$tabelafim;


$relatorio='<html>
<head>
  <title>BarCode Print</title>
</head>
<body>'
  .$all.'</body>
 <footer class="footer">
         <div>
             <div style="width:500px; float:left; font-size:10px; color:#383838; font-weight:bold;">
                <div>Documento processado por Computador</div>
              </div>
              <div style="width:270px;font-weight:bold; float:right; font-size:10px; color:#383838;">
                 <div>Software N3 Licenciado a:'.Session::get('company_name').'</div>    
              </div>
         </div> 
    </footer>
</html>';


//$all1=$all.$relatorio;

$mpdf=new mPDF('c');
$mpdf->SetDisplayMode('fullpage');
// LOAD a stylesheet
$stylesheet = file_get_contents('public/bootstrap/css/bootstrap.min.css');

$mpdf->WriteHTML($stylesheet,1); 


$mpdf->WriteHTML($all);
$mpdf->Output();
exit;

?>

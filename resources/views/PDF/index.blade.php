<?php

ini_set('max_execution_time', 800);
ini_set("memory_limit","512M");

include "public/mpdf60/mpdf.php";
$inicio = '<div class="container">';

$total1=$limite;
$j=0;
$k=$total;
$todosLinhas="";
$culuna="";


$tabelainicio='<table class="table table-bordered" style="padding-top:-20px; border:none; width: 100%">
     <tbody>';
    
      for ($i=0; $i<$total1; $i++){
      $linhaInicio ='<tr style="border:none">';
         if($j<$k){
       $culuna='<td style="border:none; padding:5px">'; 
                   
                          if($j!=0){
                          $j++; 
                        }
                        
            $culuna=$culuna.'<div style="padding-top: -40px">
                       <div  style="font-size:20px; font-weight:bold; font-family:ctimes">Senha de combustivel FUEL</div>
                    <h4 style="font-size:16px; font-weight:normal; font-family:ctimes;">
                            <strong style="font-size:16px; font-weight:bold; font-family:ctimes">Cliente: </strong>'.str_limit(strip_tags($cliente),28).'</h4>
                          <h4 style="font-size:16px; font-weight:bold; font-family:ctimes">Valor:<strong  style=" font-weight:normal;">'. number_format($senhas[$j]->valor,2,'. ',',').' MT</strong></h4>
                                <br>
                            <barcode code='.$senhas[$j]->reference.' type="C128A" class="barcode" size="1.2"  height="1.3" />
                              <div style="padding-right:10px; font-size:20px; font-weight:normal; font-family:ctimes">
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$senhas[$j]->reference.'</div> 
                            <h5 style="text-align: center; font-size:11px; font-weight:normal; font-family:ctimes" ><strong style="font-weight:bold;">&nbsp;&nbsp;&nbsp;Data emissao: </strong>'.formatDate($senhas[$j]->created_at).'<strong style="font-weight:bold;"> Validade: </strong> 6 Meses </h5>

                            <h5  style="font-size:10px;font-family:ctimes">&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor da senha a data e do local de consumo</h6>  
                        </div> 
                          '; 
                  $j++;
          '</td> <br>';

         }


       if($j<$k){
        $culuna=$culuna.'<td style="border:none">
              
              <div style="padding-top: -40px">
                       <div  style="font-size:20px; font-weight:bold; font-family:ctimes">Senha de combustivel FUEL</div>
                     <h4 style="font-size:16px; font-weight:normal; font-family: ctimes;">
                            <strong style="font-size:16px; font-weight:bold; font-family:ctimes">Cliente: </strong>'.str_limit(strip_tags($cliente),28).'</h4>
                          <h4 style="font-size:16px; font-weight:bold; font-family:ctimes">Valor:<strong  style=" font-weight:normal;">'. number_format($senhas[$j]->valor,2,'. ',',').' MT</strong></h4>
                                  <br>
                               <barcode code='.$senhas[$j]->reference.' type="C128A" class="barcode" size="1.2"  height="1.3" />
                              <h3 style="padding-right:10px ;text-align: center;font-size:20px; font-weight:normal; font-family:ctimes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$senhas[$j]->reference.'</h3> 
                            <h5 style="font-size:11px; font-weight:normal; font-family:ctimes"><strong style="font-weight:bold;">&nbsp;&nbsp;&nbsp;Data emissao: </strong>'.formatDate($senhas[$j]->created_at).'<strong style="font-weight:bold;"> Validade: </strong> 6 Meses </h5>
                            <h5  style="padding-right: 10px;font-size:10px;font-family:ctimes">&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Valor da senha a data e do local de consumo</h6>  
                      </div> 
         </td>';
       }


     $linhaFim='</tr>';
                
    $todosLinhas=$todosLinhas.$linhaInicio.$culuna.$linhaFim;

   }

   $tabelafim='</tbody>
  </table>
</div>';
$all=$inicio.$tabelainicio. $todosLinhas.$tabelafim;


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

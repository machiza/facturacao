<?php
ini_set('max_execution_time', 800);
ini_set("memory_limit","512M");

$lista_alunos ="";
        $i=0;
        foreach ($senhas as $data){
            $i++;
            $lista_alunos.='

             <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">

			<td>'.formatDate($data->created_at).'</td>
			<td style="padding-right:1px;text-align:justify; color: #000000">'.$data->reference.
			'</td>
			<td style="padding-right:1px;text-align:justify; color: #000000">'.
			$data->tipo.'
			</td>
			<td style="padding-right:1px;text-align:justify; color: #000000">'.number_format(($data->valor),2,'.',',').'MT
			</td>
			<td style="padding-right:1px;text-align:justify; color: #000000">'.$data->ref.'
			</td>
            </tr>
           ';
  }
;


$html = '
<html>
<head>
<style>

body{ font-family: sans-serif; color:#121212; line-height:22px;}
         table, tr, td{
            border-bottom: 1px solid #000000;
            padding: 3px 0px;
    }
tr{ height:10px;}

.footer1 {
            position: absolute;
            bottom: 1px;
            width: 100%;
            /* Set the fixed height of the footer here */
            height: 100px;
            /*background-color: #f5f5f5*/;
          }

.footer {
            position: absolute;
            bottom: 1px;
            width: 100%;
            /* Set the fixed height of the footer here */
            height: 120px;
            /*background-color: #f5f5f5*/;
          }

 .tablefooter{
     table {
            border-collapse: collapse;
            width: 100%;
            }

      th, td {
          padding: 2px;
          text-align: left;
          border-bottom: 1px solid #ddd;
    }
  }
</style>
</head>

<body>
	<div style="padding-top:-98px">
	 <img src="'.asset('img/logo.png').'" alt="" width="160">
	</div>
    <div style="width:300px; float:right; height:40px; padding-top:-98px">
       <div style="font-size:18px; font-weight:bold; color:#383838;">
         Relatório das Senhas por Consumir<br>
        </div>
        <div style="font-size:14px; color:#383838;">
         No periodo de '.$inicio.' a '.$fim.'
       </div>   
                  
  </div>
 <div style="margin-top:40px;height:125px;">
    <div style="width:400px; float:left; font-size:15px; color:#383838; font-weight:400;">
    <div><strong style="font-weight:bold;">'.Session::get('company_name').'</strong></div>
    <div>'.Session::get('company_street').'</div>
    <div>'.Session::get('company_city').','.Session::get('company_state').'</div>
    <div>'.Session::get('company_country_id').'</div>
    </div>
    <div style="width:240px;float:right;font-size:15px; color:#383838; font-weight:400;">
   	  <div><strong style="font-weight:bold;">Cliente</strong></div>
      <div>'.$customerInfo->name.'</div>
      <div>'.$customerInfo->billing_street.'</div>
      <div>'.$customerInfo->billing_city.'</div>
    </div>
</div>  
<div>
<br>
	<div><strong style="font-weight:bold;">Total </strong> '.$numero_elemento.'<strong style="font-weight:bold;"> Valor Total</strong>'.number_format(($total_valor),2,'.',',').'MT</div>
   <br>
   <table style="width:100%; border-radius:2px;  ">
       
      <tr style="background-color:#f0f0f0; border-bottom:1px solid #d1d1d1; text-align:center; font-size:13px; font-weight:bold;">

          <th style="padding-right:1px;text-align:justify; color: #000000">
            	Emissao
          </th>
          <th style="padding-right:1px;text-align:justify; color: #000000">
   				Codigo
          </th>
          <th style="padding-right:1px;text-align:justify; color: #000000">
 				Tipo
          </th>
          <th style="padding-right:1px;text-align:justify; color: #000000">
 				 Valor
          </th>
          <th style="padding-right:1px;text-align:justify; color: #000000">
  				 Referente
          </th>
      </tr>'.$lista_alunos.'



  </table> 
  </div>   
      
  <footer class="footer1">
      
      <table class="tablefooter">
          
          <tr style="background-color:#f0f0f0; border-bottom:2px solid #006DEF; text-align:center; font-size:12px; font-weight:bold;">
            <th style="border-bottom:1px solid #000000; width:700px"></th>
         
          </tr>

          <tr style="font-size:10px;">
            <td></td>
       
          </tr>
          <tr style="font-size:10px">
            <td></td>
          
          </tr>
          
          
      </table>

		<div>
           <div style="width:400px; float:left; font-size:10px; color:#383838; font-weight:bold;">
          		<div>Documento processado por Computador</div>
          </div>

        <div style="width:270px;font-weight:bold; float:right; font-size:10px; color:#383838;">
           <div>Software N3 Licenciado a:'.Session::get('company_name').'</div>    
       	  </div>
	   </div>    
    </footer>

</body>
</html>
';
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//define('_MPDF_PATH','../');
//include("../mpdf.php");


include "public/mpdf60/mpdf.php";


//$mpdf=new mPDF('c','A4','','',20,15,48,25,10,10); 
$mpdf=new mPDF('c','A4','','',15,15,30,30,10,10); 
$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("Relatório das Senhas por Consumir");
//$mpdf->SetAuthor("Acme Trading Co.");
//$mpdf->SetWatermarkText("Paid");
//$mpdf->showWatermarkText = true;
//$mpdf->watermark_font = 'DejaVuSansCondensed';
//$mpdf->watermarkTextAlpha = 0.1;
$stylesheet = file_get_contents('public/bootstrap/css/bootstrap.min.css');
$mpdf->WriteHTML($stylesheet,1); 
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html);
$mpdf->Output(); exit;


?>
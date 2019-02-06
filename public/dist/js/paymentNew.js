$('document').ready(function() 
{

	//alert(""+retornaValorFloat1("Metial65,722.0901")); 
	
	function retornaValorFloat1(str){	
		//var str = "MT 1,834,343.43";
		var ParteSegunda = str.split(".")[1];
		var primeiraParte= str.split(".",1);

		//var valorPrimeiro=apenasNumeros(""+primeiraParte); 
		var string=""+primeiraParte;
		var valorPrimeiro = string.replace(/[^0-9]/g,'');
		
		var segunda="0."+ParteSegunda;

		var valorFinal=parseFloat(valorPrimeiro)+parseFloat(segunda);
		//alert("o valor final eh "+valorFinal);
		return valorFinal.toFixed(2);
	}	


	function retornaValorFloat(str){	
		//var str = "MT 1,834,343.43";
		var ParteSegunda = str.split(".")[1];
		var primeiraParte= str.split(".",1);

		var valorPrimeiro=apenasNumeros(""+primeiraParte); 
		var segunda="0."+ParteSegunda;

		var valorFinal=parseFloat(valorPrimeiro)+parseFloat(segunda);
		//alert("o valor final eh "+valorFinal);
		return valorFinal;
	}	

	function apenasNumeros(string) 
	{
	var numsStr = string.replace(/[^0-9]/g,'');
	return parseInt(numsStr);
	}


	 


	$('#account_no').change(function() 
	{
		if($('#account_no').val()=="")
		{
			$('.contaVal').prop('hidden', false);
			$('#status').val('false');
			$('#account_no').focus();
		}

		else 
		{
			$('.contaVal').prop('hidden', true);
			$('#status').val('true');
		}
		
	});

	$('#customer').change(function()
	{
		if ($('#customer').val()=="")
		{
			$('.customerVal').prop('hidden', false);
			$('#status').val('false');
			$('#customer').focus();

		}

		else 
		{
			$('.customerVal').prop('hidden', true);
			$('#status').val('true');

		}
	});

	$('#btnSubmit').click(function(e)
	{	e.preventDefault();

		if ($('#customer').val()=='')
		{
			$('.customerVal').prop('hidden', false);
			$('#status').val('false');
			$('#customer').focus();

		}
		if($('#account_no').val()=='')
		{
			$('.contaVal').prop('hidden', false);
			$('#status').val('false');
			$('#account_no').focus();
		}

		if($('#status').val()=='true' && $('#verificarLimite').val()=='true')
		{
			//$('#payForm').submit();
			console.log('pode enviar');

			   var rows = '';
                            var rows1 = '';
                             
                              $('tbody tr').each(function(i, val){
                              var currentRow=$(this);
                              var checkbox_cell_is_checked =currentRow.find('.factura').is(':checked');

                              if(checkbox_cell_is_checked){

                                  var currentRow=$(this).closest('tr'); 

                                  var preco = currentRow.find('td').eq(0).text();    
                                  var valorApagar =currentRow.find('.valor_a_pagar').val();
                                                                       
                                   rows=rows+'<label>'+preco+'</label></br>';
                                  

                                }
                          });    

					var recibo=$('#reference_no').val();
					var total=$('#total').val();
					var total1=parseFloat(total).toFixed(2);
					rows1='<input type="text" class="form-control" value='+recibo+' disabled="">';
					rows2='<input type="text" class="form-control" value='+total1+' disabled="">';



					$('#conteudoModal').html(rows1);
					$('#conteudoModal2').html(rows2);
					$('#confirmacao_pagamento').modal('show');

		}

		/*else 
		{
			alert('Preencha todos os campos');
		}*/

	});

	
})








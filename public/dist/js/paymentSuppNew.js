$('document').ready(function() 
{
	$('#supplier_id').change(function()
	{
		if($('#supplier_id').val()=='')
		{
			$('.suppVal').prop('hidden', false);
			$('#status').val('false');
			$('#supplier_id').focus();
		}
			else
			{
				$('.suppVal').prop('hidden', true);
				$('#status').val('true');

			}

	});
	$('#account_no').change(function() 
	{
		if($('#account_no').val()=='')
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

		$('#btnSubmit').click(function(e)
	{	e.preventDefault();
		if($('#supplier_id').val()=='')
		{
			$('.suppVal').prop('hidden', false);
			$('#status').val('false');
			$('#supplier_id').focus();
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
                       rows1='<input type="text" class="form-control" value='+recibo+' disabled="">';
                       rows2='<input type="text" class="form-control" value='+total+' disabled="">';

                        
                         
                          $('#conteudoModal').html(rows1);
                          $('#conteudoModal2').html(rows2);
                          $('#confirmacao_pagamento').modal('show');

		}

		/*else 
		{
			alert('Preencha todos os campos');
		}*/

	});

	
});
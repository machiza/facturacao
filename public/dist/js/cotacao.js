$('document').ready(function() 
{
		/*
		casos de teste
		$('#nome_customer').val("Alberto Jorge Matsinhe");
		$('#nuit_customer').val("4000230");
		$('#telemovel_customer').val("823822882");
		*/
	
	$('#cancelar_cadastro').click( function(e)
	{	
		//$('#cancelar_cadastro').prop('hidden', false);
		
		
		
		$('#tipocliente').val("");
		$('#dados').hide();
		$( "#customer" ).prop( "disabled", false );



		//$('#nome_customer').val("");
		//$('#nuit_customer').val("");
		//$('#telemovel_customer').val("");
		//setting values to the form
		$('#customer_new').val("");
		$('#customer_new_telemovel').val(""); 
		$('#customer_new_nuit').val("");

		//$('#customer').val("");
		
		$('#customer').eq(0).prop('selected',true);
		 $('#customer').select2('destroy').select2();


      $("#nome_customer").val("{!! $estadoCliente->name !!}");
      $("#nuit_customer").val("{!! $estadoCliente->nuit !!}");
      $("#telemovel_customer").val("{!! $estadoCliente->phone !!}");

      


	});		


	
	//I am money less
	$("#customer").on('change', function(){
         var debtor_no = $(this).val();

        if(debtor_no!=""){
          $.ajax({
            method: "POST",
            url: SITE_URL+"/sales/get-situation",
            data: { "debtor_no": debtor_no,"_token":token }
            })
            .done(function( data ) {
            console.log(data);
            var data = jQuery.parseJSON(data);
           			
            if(data==null){
              console.log("o valor da requisicao eh nulo");
              $('#imposto').val("");
              $('#discounto').val("");
              $('textarea[name=comments]').val('');
            }else{
              console.log("imposto eh  "+data.imposto+ "  o disconto eh "+data.discounto);
              $('#imposto').val(data.imposto);
              $('#discounto').val(data.discounto);

              if(data.imposto==1){

                $('textarea[name=comments]').val($('#informacao').val());
               
              }else{
                $('textarea[name=comments]').val('');
              }

              var imp=$('#imposto').val();
              var desconto=$('#discounto').val();
              console.log("o valor do imposto "+$('#imposto').val()+ " a desconto feito eh "+$('#discounto').val()+ "o deptor master eh "+debtor_no);

                if($('#contagem').val()!="" && data.imposto==1 || $('#contagem').val()!="" && data.imposto!=0){
                   
                    imposto_set=data.imposto;
                    desconto_set=data.discounto;

                    $('#actualizar').modal('show');
                }
          }});
         
         }else{
          
              var imp=$('#imposto').val();
              var desconto=$('#discounto').val();
              console.log("imposto setado eh "+imp+ " e o disconto setado eh "+desconto+ "o deptor master eh "+debtor_no);
        }
      
    });








//
	$('#cadastro').click(function(e)
	{	e.preventDefault();
		//Registo da 

		if($('#nome_customer').val()!=""){
			
			$( "#customer" ).prop( "disabled", true );
			$('#dados').show();
			$('#customer').val("");
			$('#tipocliente').val("novo");

			$('#customer').eq(0).prop('selected',true);
			$('#customer').select2('destroy').select2();
		}

		//$('#conteudoModal2').html(rows2);
		var nome= $('#nome_customer').val();
		var nuit= $('#nuit_customer').val();
		var telemovel= $('#telemovel_customer').val();
		//setting values to the form
		$('#customer_new').val(nome);
		$('#customer_new_telemovel').val(telemovel); 
		$('#customer_new_nuit').val(nuit);
		
		if(nuit==""){
		$('#customer_new_nuit').val("000000");
			
		} 
		
		var rows = '';
		
		 //rows=rows+'<input type="text" class="form-control" value='+recibo+' disabled="">';
		 if(nome!="")
	     {
		 rows=rows+'<div class="col-md-4">';
         rows=rows+'<div class="form-group">';    
         rows=rows+'<label for="exampleInputEmail1">Nome<span class="text-danger"> *</span>';    
         rows=rows+'</label>';   
         rows=rows+'<input type="text" class="form-control" value="'+nome+'" disabled="">'; 				
	     rows=rows+'</div>';				
	     rows=rows+'</div>';				
         } 
	     if(nuit!="")
	     {
	     rows=rows+'<div class="col-md-2">';
         rows=rows+'<div class="form-group">';    
         rows=rows+'<label for="exampleInputEmail1">NUIT<span class="text-danger"> *</span>';    
         rows=rows+'</label>';   
         rows=rows+'<input type="text" class="form-control" value='+nuit+' disabled="">'; 				
	     rows=rows+'</div>';				
	     rows=rows+'</div>';
	 	 }
	 	 if(telemovel!="")
	 	 {	
	     rows=rows+'<div class="col-md-2">';
         rows=rows+'<div class="form-group">';    
         rows=rows+'<label for="exampleInputEmail1">Telemovel<span class="text-danger"> *</span>';    
         rows=rows+'</label>';   
         rows=rows+'<input type="text" class="form-control" value='+telemovel+' disabled="">'; 				
	     rows=rows+'</div>';				
	     rows=rows+'</div>';
	 	 }
         
         $('#dados_cliente').html(rows);
		 $('#Register_customer').modal('hide');		
		
	});

		//
	if($('#tipocliente').val()==""){
			// validacao
				$('#salesForm').validate({
				 rules: {
					debtor_no: {
					required: true
					},
				}
  		  });			

 		}

	// funcao de comfirmacao
	$("#comfirmar").on('click', function(){

	     $('#actualizar').modal('hide');
	    actualizarLista(imposto_set,desconto_set);
	    console.log("o imposto eh "+imposto_set+"desconto eh "+desconto_set); 
	 });
 		 
//funcao para limpar o as checkbox
  function actualizarLista(imposto,desconto){
      var numero=0;
      var join="";
      
      $("tbody tr.linha").each(function(i, val){
          var rowId = $(this).closest('tr').attr('id');
         
          var currentRow=$(this);
            currentRow.find('.taxa').val(1);
            currentRow.find('.disconto').val(desconto);
            var rate = currentRow.find(".percentagem").val();
            var taxRateValue = parseFloat(currentRow.find('.taxa').find(':selected').attr('taxrate'));
            var qty =  currentRow.find('.unidades').val();
            var discountRate = currentRow.find(".disconto").val();



           if (rowId != undefined) {
                console.log("linha do search");

                   var id = rowId.match(/\d+/); 
                    
                    console.log("todos os dados rate "+rate+"id "+id+" taxRateValue "+taxRateValue+" quantity "+qty+ " discountRate "+ discountRate);
                    console.log("row id is   "+id);
                    var percentagem= currentRow.find("td input[name=tax_id]").val();

                    //"#rowid"+id+
                    if($('.checkitem').prop('checked')==false){ 

                    var price = calculatePrice(qty,rate);  
                    var discountPrice = calculateDiscountPrice(price,discountRate);     
                    currentRow.find(".amount").val(discountPrice);
                    var amountByRow = currentRow.find('.amount').val();
                    var taxByRow = roundToTwo(amountByRow*taxRateValue/100);
                    currentRow.find('.taxAmount').text(taxByRow);
                      console.log("discountPrice "+discountPrice +" taxAmount "+taxAmount+"preco eh "+ price);
                    }

                          //"#rowid"+id+
                    if($('.checkitem').prop('checked')==true){ 

                    var ValorSemTaxaUnitario=rate/(1+((taxRateValue/100)));
                    var price = calculatePrice(qty,ValorSemTaxaUnitario);
                    var discountPrice = calculateDiscountPrice(price,discountRate); 
                    currentRow.find(".amount").val(discountPrice);
                    // done by albert
                    var taxAmount = roundToTwo((discountPrice*taxRateValue)/100); 
                    currentRow.find(".taxAmount").text(taxAmount); 
                    console.log("this chebox is actived "+discountPrice +" taxAmount "+taxAmount+" taxRateValue "+taxRateValue);
                    } 

          }else   {

                    console.log("linha do personalizadas");
                    numero=numero+1;
                  
                      if(currentRow.find('.checkitem').prop('checked')==false){ 
                        console.log("Taxa nao incluida no valor ") ;

                        var price = calculatePrice(qty,rate);  
                        var discountPrice = calculateDiscountPrice(price,discountRate);     
                        var taxAmount = roundToTwo((discountPrice*taxRateValue)/100);
                        currentRow.find('.amount').val(discountPrice);
                         currentRow.find('.taxAmount').text(taxAmount);
                      }

                        
                      if(currentRow.find('.checkitem').prop('checked')==true){ 
                        console.log("Taxa incluida no valor colocado do produto ou servivco") ;

                        var ValorSemTaxaUnitario=rate/(1+((taxRateValue/100)));
                        var price = calculatePrice(qty,ValorSemTaxaUnitario);
                        var discountPrice = calculateDiscountPrice(price,discountRate);
                        currentRow.find('.amount').val(discountPrice);
                        var taxAmount = roundToTwo((discountPrice*taxRateValue)/100); 
                        currentRow.find('.taxAmount').text(taxAmount);
                       
                      } 
                 }
    
           console.log("o identificador da linha eh   ");
          
    });        

    console.log("o numero de dados actualizados eh  "+numero+" A juncao eh "+join);   
     console.log("\n");

    var subTotal = calculateSubTotal();
    $("#subTotal").html(subTotal);
      // Calculate taxTotal
    var taxTotal = calculateTaxTotal();
    $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
    var grandTotal = (subTotal + taxTotal);
    $("#grandTotal").val(roundToTwo(grandTotal));

    //var discountValue = calculateDiscountAmount(price,discountRate);
    var discountValue = calculateDiscountAmountt();
    $("#Descount").text(discountValue);  

  }






 		$('#salesForm').validate({
       		rules: {
            debtor_no: {
                required: true
            },
            from_stk_loc: {
                required: true
            },
            ord_date:{
               required: true
            },
            reference:{
              required:true
            },
            payment_id:{
              required:true
            },
            branch_id:{
              required:true
            }                    
        }
    });

	
})








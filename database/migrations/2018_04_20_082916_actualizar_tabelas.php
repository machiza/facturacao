<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class ActualizarTabelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

             // Actualizacao para a versao 1.1.10
                // verscao para NC
                if (Schema::hasTable('moedas')) {
    
              }else{
  
              Schema::create('moedas', function (Blueprint $table) {
                  $table->increments('id');
                  $table->string('nome')->nullable();
                  $table->string('singular')->nullable();
                  $table->string('plural')->nullable();
                  $table->string('casas_decimais_sing')->nullable();
                  $table->string('casas_decimais_plu')->nullable();
                  $table->timestamps();
  
                  });
              }

              if (Schema::hasTable('taxas')) {
              }else{
              Schema::create('taxas', function (Blueprint $table) {
                  $table->increments('id');
                  $table->string('data_cambio')->nullable();
                  $table->string('compra')->nullable();
                  $table->string('venda')->nullable(); 
                  $table->integer('moedas_id')->unsigned();
      
                  $table->foreign('moedas_id')->references('id')->on('moedas');  
                  $table->timestamps();
              });
          }

              

          if (Schema::hasTable('bank_account_nr')) {
  
          }else{

          Schema::create('bank_account_nr', function (Blueprint $table) {
              $table->increments('id');
              $table->string('nome')->nullable();
              $table->string('nr_conta')->nullable();
              $table->string('nib')->nullable();
              $table->string('swift')->nullable();
              $table->timestamps();

              });
          }

                
            if (Schema::hasTable('planos')) {
    
            }else{

            Schema::create('planos', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nome');
                $table->double('valor')->default(0);
                $table->string('detalhes')->nullable();
                $table->timestamps();

                });
            }
      
              //Adicionado o stockID
            if(Schema::hasColumn('sales_details_vd', 'taxa_inclusa_valor')){
             
             }else{
                Schema::table('sales_details_vd', function ($table) {
                 $table->string('taxa_inclusa_valor')->default('no'); 
               }); 
             }

              
            if(Schema::hasColumn('sales_debito', 'tax_total')){
             
             }else{
                Schema::table('sales_debito', function ($table) {
                 $table->double('tax_total')->default(0);
               }); 
             }  

             if(Schema::hasColumn('sales_orders', 'tax_total')){
             
            }else{
               Schema::table('sales_orders', function ($table) {
                $table->double('tax_total')->default(0);
              }); 
            }  



             if(Schema::hasColumn('sales_credito', 'tax_total')){
             
             }else{
                Schema::table('sales_credito', function ($table) {
                 $table->double('tax_total')->default(0);
               }); 
             }  
 



            //Adicionado o preco de custo dos artigos
            if(Schema::hasColumn('sales_order_details', 'cost_price')){
             
             }else{
                Schema::table('sales_order_details', function ($table) {
                 $table->double('cost_price')->nullable(); 
               }); 
             }

           //Order day
            if(Schema::hasColumn('sales_order_details', 'taxa_inclusa_valor')){
             
             }else{
                    Schema::table('sales_order_details', function ($table) {
                    $table->string('taxa_inclusa_valor')->default('no');

                   }); 
             }
        
             //Order day
            if(Schema::hasColumn('sales_ge_details', 'taxa_inclusa_valor')){
              
             }else{
                    Schema::table('sales_ge_details', function ($table) {
                    $table->string('taxa_inclusa_valor')->default('no');

                   }); 
             }

                 //Order day
            if(Schema::hasColumn('sales_gt_details', 'taxa_inclusa_valor')){
              
             }else{
                    Schema::table('sales_gt_details', function ($table) {
                    $table->string('taxa_inclusa_valor')->default('no');

                   }); 
             }


             
            

            if(Schema::hasColumn('sales_ge_details', 'stock_id')){
             
             }else{
                    Schema::table('sales_ge_details', function ($table) {
                    $table->string('stock_id',30)->nullable(); 
                  
              });   
                  
             }



              //Order day
            if(Schema::hasColumn('sales_order_details', 'ord_date')){
             
             }else{
                    Schema::table('sales_order_details', function ($table) {
                     $table->date('ord_date')->nullable(); 
                   }); 
             }
             



            // Actualizacao para a versao 1.2
            if (Schema::hasTable('produtos')) {
    
            }else{

            Schema::create('produtos', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nome');
                $table->string('detalhes')->nullable();
                $table->timestamps();
            });
            }


            // Actualizacao para a versao 1.2
            if (Schema::hasTable('subscricoes')) {
    
            }else{

            Schema::create('subscricoes', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nome')->nullable();
                $table->integer('produto_id');
                $table->integer('plano_id');
                $table->double('valor');
                $table->date('data_inicio')->nullable();
                $table->date('data_fim')->nullable();
                $table->integer('user_id');
                $table->string('estado');
                $table->timestamps();
            });
            }


           
            // Has Columun subscricoes
            if(Schema::hasColumn('subscricoes', 'cliente_final_id')){
             
             }else{
                    Schema::table('subscricoes', function ($table) {
                     $table->integer('cliente_final_id');   
                   }); 
             }


             // tipos de clientes
              if(Schema::hasColumn('debtors_master', 'tipo_cliente')){
             
             }else{
                    Schema::table('debtors_master', function ($table) {
                     $table->string('tipo_cliente')->default('normal');
                    }); 
             }



            //Tabelas nao existente
            // Actualizacao para a versao 1.1.1
            if (Schema::hasTable('receiptLists')) {
            //
            }else{

            Schema::create('receiptLists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference');
            $table->double('total_amount')->default(0);

            $table->integer('pay_history_id');
            $table->foreign('pay_history_id')->references('id')->on('payment_purchase_history')->onDelete('cascade');

            $table->smallInteger('payment_type_id');
            $table->foreign('payment_type_id')->references('id')->on('payment_terms')->onDelete('cascade');

            $table->date('payment_date');

            $table->integer('supp_id');
            $table->foreign('supp_id')->references('supplier_id')->on('suppliers')->onDelete('cascade');

                $table->timestamps();
            });
            }


              if (Schema::hasTable('purch_cc')) {
              //
              }else{

              Schema::create('purch_cc', function (Blueprint $table) {
              $table->increments('idcc');
              $table->integer('order_no_doc');
              $table->string('reference_doc');
              $table->string('amount_doc');
              $table->double('amount_credito_doc');
              $table->double('saldo_doc');
              $table->integer('supp_id_doc');
              $table->tinyInteger('total_amount')->default(0);
              $table->date('ord_date_doc');
              $table->timestamps();
              });
              }



             if(Schema::hasColumn('purch_cc', 'supp_id_doc')){
             
             }else{
                    Schema::table('purch_cc', function ($table) {
                     $table->integer('supp_id_doc');   
                    }); 
             }



     
            if(Schema::hasColumn('purchase_vd_details', 'discount_percent')){
             
             }else{
                    Schema::table('purchase_vd_details', function ($table) {
                    $table->double('discount_percent');
                    


                    }); 
             }


             if(Schema::hasColumn('sales_orders', 'moedas_id')){
             
       }else{
              Schema::table('sales_orders', function ($table) {
             
                
              $table->double('daily_exchange')->null();
              $table->double('total_foreign')->null();
              $table->integer('moedas_id')->unsigned()->null();
  
              $table->foreign('moedas_id')->references('id')->on('moedas');  

              
              
              }); 
       }
             


            // Actualizacao para a versao 1.1.0
            if(Schema::hasColumn('cust_branch', 'motivation')){
             
             }else{
                    Schema::table('cust_branch', function ($table) {
                    $table->string('motivation',240)->nullable();
                    }); 
             }

            if(Schema::hasColumn('sales_debito', 'status')){
             
             }else{
                    Schema::table('sales_debito', function ($table) {
                    $table->string('status',100);
                    }); 
             }
             if(Schema::hasColumn('purchase_vd', 'into_stock_location')){
             
             }else{
                Schema::table('purchase_vd', function ($table) {
                $table->double('into_stock_location', 100);
                });  
             }

             if(Schema::hasColumn('purch_order_details', 'discount_percent')){
             
             }else{
                     Schema::table('purch_order_details', function ($table) {
                     $table->double('discount_percent', 15, 2);
              }); 

             }


             if(Schema::hasColumn('sales_orders', 'status')){
             
             }else{
                    Schema::table('sales_orders', function ($table) {
                    $table->string('status',150);
                    $table->string('description');
                    

              }); 
             }   
             
            
             if(Schema::hasColumn('sales_cc', 'status')){
             
             }else{
                    Schema::table('sales_cc', function ($table) {
                    $table->string('status',150);
              }); 
             }   
             

              if(Schema::hasColumn('sales_pending', 'status')){
             
             }else{
                    Schema::table('sales_pending', function ($table) {
                    $table->string('status',150);
              }); 
             }   
             
            

              if(Schema::hasColumn('cust_branch', 'imposto')){
             
             }else{
                 
                 Schema::table('cust_branch', function ($table) {
                 $table->integer('imposto');
                 $table->double('discounto');
            });   

             }   
             

              if(Schema::hasColumn('sale_prices', 'inclusao_iva')){
             
             }else{
                    Schema::table('sale_prices', function ($table) {
                    $table->integer('inclusao_iva');
                    $table->double('discounto');
            });   
                  
             }





              if(Schema::hasColumn('sales_order_details', 'tipo_operacao')){
             
             }else{
                  
                Schema::table('sales_order_details', function ($table) {
                $table->string('tipo_operacao',150);
                }); 
             }  

              if(Schema::hasColumn('sales_vd', 'status_vd')){
             
             }else{
                   Schema::table('sales_vd', function ($table) {
                  $table->string('status_vd',150);
                });
                  
             }  

              if(Schema::hasColumn('debtors_master', 'status_debtor')){
                   Schema::table('debtors_master', function ($table) {
                  $table->string('status_debtor',100)->default("activo")->change();
                });
             }else{
                Schema::table('debtors_master', function ($table) {
                $table->string('status_debtor',100)->default("activo");
                });
                  
             }  


             // funcionalidades para a importacao de stock
           
             if(Schema::hasColumn('stock_master', 'brand_id')){
             
             }else{
                 

                 Schema::table('stock_master', function ($table) {
                 $table->integer('brand_id')->default(1);
             });   

             }


               if(Schema::hasColumn('item_code', 'brand_id')){
             
             }else{
                 

                 Schema::table('item_code', function ($table) {
                 $table->integer('brand_id')->default(1);
             });   

             }


              // criacao da tabela de marcas

              if (Schema::hasTable('brand')) {

              }else{

              Schema::create('brand', function (Blueprint $table) {
              $table->increments('id');
              $table->string('description');
              $table->timestamps();
              });

              DB::insert('insert into brand (id, description) values (?, ?)', [1, 'Sem Marca']);
              
              }
               //  DB::updte('insert into brand (id, description) values (?, ?)', [1, 'Sem Marca']);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}







<?php
		// Rotas para actualizacao da BD
		Route::get('update/version/seed', 'CronController@index');
		Route::get('update/version/now', 'CronController@setup');
		Route::get('update/version/now/force', 'CronController@force_quick');
		
		/* Admin part routing */
		Route::get('/', 'LoginController@login');
		Route::get('/login', 'LoginController@login');
		Route::post('/authenticate', 'LoginController@authenticate');
		Route::get('/logout', 'LoginController@logout');
		// Password Reset Routes...

		Route::get('password/resets/{token?}', 'LoginController@showResetForm');
		Route::post('password/resets/{token?}', 'LoginController@setPassword');
		Route::post('password/email', 'LoginController@sendResetLinkEmail');
		Route::get('password/reset', 'LoginController@reset');

		// Customer Login Route 
		Route::get('customer', 'CustomerAuth\AuthController@showLoginForm');
		Route::post('customer/authenticate', 'CustomerAuth\AuthController@login');
		Route::get('customer/logout', 'CustomerAuth\AuthController@logout');

		Route::get('customer/dashboard', 'CustomerPanelController@index');
		Route::get('customer/profile', 'CustomerPanelController@profile');
		Route::post('customer/profile', 'CustomerPanelController@updateProfile');

		Route::get('customer-panel/order/{id}','CustomerPanelController@salesOrder');
		Route::get('customer-panel/view-order-details/{id}','CustomerPanelController@viewOrderDetails');
		Route::get('customer-panel/orderPdf/{order_id}','CustomerPanelController@orderPdf');
		Route::get('customer-panel/orderPrint/{order_id}','CustomerPanelController@orderPrint');

		Route::get('customer-panel/invoice/{id}','CustomerPanelController@invoice');
		Route::get('customer-panel/view-detail-invoice/{order_id}/{invoice_id}','CustomerPanelController@viewInvoiceDetails');
		Route::get('customer-panel/invoice-pdf/{order_id}/{invoice_id}','CustomerPanelController@invoicePdf');
		Route::get('customer-panel/invoice-print/{order_id}/{invoice_id}','CustomerPanelController@invoicePrint');

		Route::get('customer-panel/payment/{id}','CustomerPanelController@payment');
		Route::get('customer-panel/view-receipt/{id}','CustomerPanelController@viewReceipt');
		
		Route::get('customer-panel/shipment/{id}','CustomerPanelController@shipment');
		Route::get('customer-panel/view-shipment-details/{order_id}/{shipment_id}','CustomerPanelController@shipmentDetails');

		Route::get('customer-panel/branch/{id}','CustomerPanelController@branch');
		Route::get('customer-panel/branch/edit/{id}','CustomerPanelController@branchEdit');
		Route::post('customer-panel/branch/update/{id}','CustomerPanelController@branchUpdate');

		// Customer payment start
        Route::post('customer/pay','CustomerPayController@payNow');
        Route::get('customer_payments/success','CustomerPayController@paymentSuccess');
        Route::get('customer_payments/cancel','CustomerPayController@paymentCancel');
        Route::get('customer_payments/fail','CustomerPayController@paymentFail');
		Route::post('customer_payments/bank-payment','CustomerPayController@bankPayment');
		
		Route::get('termo_pagamento/{id}','SalesOrderController@termo_pagamento');

        // Customer payment end

		Route::group(['middleware' => ['auth','locale'] ], function() {

		// Novo
		
	
		/* User Actions */
		Route::get('dashboard','DashboardController@index');
		Route::post('change-lang','DashboardController@switchLanguage');
		Route::get('users','UserController@index')->middleware(['permission:manage_team_member']);
		Route::get('create-user','UserController@create')->middleware(['permission:add_team_member']);
		Route::post('save-user','UserController@store');
		Route::get('edit-user/{id}','UserController@edit')->middleware(['permission:add_team_member']);
		Route::post('update-user/{id}','UserController@update');
		Route::post('delete-user/{id}','UserController@destroy')->middleware(['permission:delete_team_member']);
		Route::post('email-valid','UserController@validEmail');
		Route::get('profile','UserController@profile');
		Route::get('change-password/{id}','UserController@changePassword');
		Route::post('change-password/{id}','UserController@updatePassword');
		// Details 
		Route::get('user/purchase-list/{id}','UserController@userPurchaseOrderList');
		Route::get('user/sales-order-list/{id}','UserController@userSalesOrderList');
		Route::get('user/sales-invoice-list/{id}','UserController@userSalesInvoiceList');
		Route::get('user/user-transfer-list/{id}','UserController@userTransferList');
		Route::get('user/user-payment-list/{id}','UserController@userPaymentList');

		// user Role
		
		Route::get('role/list','RoleController@index')->middleware(['permission:manage_role']);
		Route::get('role/create','RoleController@create')->middleware(['permission:add_role']);
		Route::post('role/save','RoleController@store');
		Route::get('role/edit/{id}','RoleController@edit')->middleware(['permission:edit_role']);
		Route::post('role/update','RoleController@update');
		Route::post('role/delete','RoleController@destroy')->middleware(['permission:delete_role']);

		// item category
		Route::get('item-category','CategoryController@index');//->middleware(['permission:manage_item_category']);
		Route::get('create-category','CategoryController@create')->middleware(['permission:add_item_category']);
		Route::post('save-category','CategoryController@store');
		Route::post('edit-category','CategoryController@edit')->middleware(['permission:edit_item_category']);
		Route::post('update-category','CategoryController@update');
		Route::post('delete-category/{id}','CategoryController@destroy')->middleware(['permission:delete_item_category']);
		Route::get('categorydownloadExcel/{type}', 'CategoryController@downloadCsv');
		Route::get('categoryimport', 'CategoryController@import');
		Route::post('categoryimportcsv', 'CategoryController@importCsv');

		// item brand
		Route::get('item-brand','CategoryController@index_brand');//->middleware(['permission:manage_item_category']);
		Route::post('edit-brand','CategoryController@edit_brand')->middleware(['permission:edit_item_category']);
		Route::post('save-brand','CategoryController@store_brand');
		Route::post('update-brand','CategoryController@update_brand');
		Route::post('delete-brand/{id}','CategoryController@destroy_brand')->middleware(['permission:delete_item_category']);
		Route::get('brandimport', 'CategoryController@import_brand');
		Route::get('branddownloadExcel/{type}', 'CategoryController@downloadxls_brand');
		Route::post('brandmportxls', 'CategoryController@importxls_brand');

// Abdul Sumail - 840302176 / 826215197 | abdulsumail@gmail.com

		//Bank Account Routes - Begin
		Route::get('/bank_account','BankAccountController@index')->middleware(['permission:manage_bank_account']);
        Route::get('/bank_account/add','BankAccountController@create')->middleware(['permission:add_bank_account']);
		Route::post('/bank_account/save','BankAccountController@store');
		Route::post('/bank_account/update', 'BankAccountController@update');
		Route::get('/bank_account/{id}', 'BankAccountController@edit');
		Route::post('/bank_account/delete/{id}', 'BankAccountController@destroy');
		 
		//Bank Account Routes -End

		// Abdul Sumail - 840302176 / 826215197 | abdulsumail@gmail.com

		//Cambio Routes - Begin
		Route::get('/cambio','CambioController@index')->middleware(['permission:manage_setting']);
        Route::get('/cambio/add','CambioController@create')->middleware(['permission:manage_setting']);
		Route::post('/cambio/save','CambioController@store');
		Route::post('/cambio/update', 'CambioController@update');
		Route::get('/cambio/{id}', 'CambioController@edit');
		Route::post('/cambio/delete/{id}', 'CambioController@destroy');
		 
		//Cambio Routes -End

		// Abdul Sumail - 840302176 / 826215197 | abdulsumail@gmail.com

		//Taxas de Cambio Routes - Begin
		
		Route::get('/taxas','TaxasController@index')->middleware(['permission:manage_setting']);
        Route::get('/taxas/add','TaxasController@create')->middleware(['permission:manage_setting']);
		Route::post('/taxas/save','TaxasController@store');
		Route::post('/taxas/update', 'TaxasController@update');
		Route::get('/taxas/{id}', 'TaxasController@edit');
		Route::post('/taxas/delete/{id}', 'TaxasController@destroy');
         
		 
		//Taxas de Cambio Routes -End


		// item Unit
		Route::get('unit','UnitController@index')->middleware(['permission:manage_unit']);
		Route::get('create-unit','UnitController@create')->middleware(['permission:add_unit']);
		Route::post('save-unit','UnitController@store');
		Route::post('edit-unit','UnitController@edit')->middleware(['permission:edit_unit']);
		Route::post('update-unit','UnitController@update');
		Route::post('delete-unit/{id}','UnitController@destroy')->middleware(['permission:delete_unit']);

		
		// Location
		Route::get('location','LocationController@index')->middleware(['permission:manage_location']);
		Route::get('create-location','LocationController@create')->middleware(['permission:add_location']);
		Route::post('save-location','LocationController@store');
		Route::get('edit-location/{id}','LocationController@edit')->middleware(['permission:edit_location']);
		Route::post('update-location/{id}','LocationController@update');
		Route::post('delete-location/{id}','LocationController@destroy')->middleware(['permission:delete_location']);
		Route::get('loc_code-valid','LocationController@validLocCode');

		// Item
		Route::get('item','ItemController@index')->middleware(['permission:manage_item']);
		Route::get('create-item/{tab}','ItemController@create')->middleware(['permission:add_item']);
		Route::post('save-item','ItemController@store');
		Route::get('edit-item/{tab}/{id}','ItemController@edit')->middleware(['permission:edit_item']);
		Route::get('copy-item/{id}','ItemController@copy');
		Route::get('show-item/{id}','ItemController@show');
		Route::post('update-item/{id}','ItemController@update');
		Route::post('item/delete/{id}','ItemController@destroy')->middleware(['permission:delete_item']);
		Route::post('save-sale-price','ItemController@storeSalePrice');
		Route::post('save-purchase-price','ItemController@storePurchasePrice');
		Route::post('update-item-info','ItemController@updateItemInfo');
		Route::post('add-sale-price','ItemController@addSalePrice');
		Route::post('edit-sale-price','ItemController@editSalePrice');
		Route::post('update-sale-price','ItemController@updateSalePrice');
		Route::post('delete-sale-price/{id}/{item_id}','ItemController@deleteSalePrice');
		Route::post('update-purchase-price','ItemController@updatePurchasePrice');

		Route::post('add-stock','ItemController@addStock');
		Route::post('remove-stock','ItemController@removeStock');
		Route::post('move-stock','ItemController@moveStock');
		Route::post('stock-valid','ItemController@stockValidChk');
		Route::post('qty-valid','ItemController@qtyValidAjax');
		Route::get('trans-details/{id}','ItemController@showFullDetails');

		Route::get('itemdownloadcsv/{type}', 'ItemController@downloadCsv');
		Route::get('itemimport', 'ItemController@import');
		//Route::post('itemimportcsv', 'ItemController@importCsv');
		Route::post('itemimportcsv', 'ItemController@importExcel');

		// Company 
		Route::get('company','CompanyController@index');
		Route::get('create-company','CompanyController@create');
		Route::post('save-company','CompanyController@store');
		Route::get('edit-company/{id}','CompanyController@edit');
		Route::post('update-company/{id}','CompanyController@update');
		Route::post('delete-company/{id}','CompanyController@destroy');

		// create direct sale / invoive
		//ROTA PARA DEBITO:
		Route::get('sales/debito','DebitoController@index')->middleware(['permission:manage_invoice']);
		Route::get('sales/add_debit','DebitoController@create')->middleware(['permission:add_invoice']);
		Route::get('sales/debit/{id}/edit','DebitoController@edit')->middleware(['permission:add_invoice']);

	
		Route::post('sales/debit-delete/{id}','DebitoController@destroy')->middleware(['permission:delete_invoice']);
		Route::post('sales/savedebito','DebitoController@store');
		Route::post('sales/updatedebito','DebitoController@update');
		Route::get('debito-report','DebitoController@reporte');
		
		Route::get('sales/add_guiaentrega','GEController@create')->middleware(['permission:add_invoice']);
		Route::get('guiaentrega-report','GEController@reporte');
		Route::get('sales/guiaentrega/{id}/edit','GEController@edit');



		Route::get('guiatransporte-report','GTController@reporte');

		//ROTA PARA nta de credito:
		Route::get('sales/credito','CreditoController@index')->middleware(['permission:manage_invoice']);
		Route::get('sales/add_credit','CreditoController@create')->middleware(['permission:add_invoice']);
		Route::post('sales/credit-delete/{id}','CreditoController@destroy')->middleware(['permission:delete_invoice']);
		Route::get('sales/credit/{id}','CreditoController@edit');
		//->middleware(['permission:delete_invoice'])
		Route::post('sales/savecredito','CreditoController@store');
		Route::post('sales/updatecredito','CreditoController@update');
		Route::get('credito-report','CreditoController@reporte');


		Route::get('sales/guiaentrega','GEController@index')->middleware(['permission:manage_invoice']);
		Route::post('sales/save_ge','GEController@store');
		Route::post('sales/update_ge','GEController@update');
		Route::post('sales/get-inv_ge','GEController@getInvoices');

		Route::post('sales/save_gt','GTController@store');
		Route::post('sales/update_gt','GTController@update');
		Route::post('sales/get-inv_gt','GEController@getInvoices');

		Route::post('sales/get-inv','DebitoController@getInvoices');

		//rotas gt:
		Route::get('sales/guiatransporte','GTController@index')->middleware(['permission:manage_invoice']);
		Route::get('sales/add_guiatransporte','GTController@create')->middleware(['permission:add_invoice']);
		Route::get('sales/add_guiatransporte/{id}/edit','GTController@edit');

		// remocao das Guias
		Route::post('sales/delete_guiaentrega/{id}','GEController@destroy')->middleware(['permission:add_invoice']);
		Route::post('sales/delete_guiatransporte/{id}','GTController@destroy')->middleware(['permission:add_invoice']);


		Route::get('sales/vd','VDController@index')->middleware(['permission:manage_invoice']);
		Route::get('sales/add_vd','VDController@create')->middleware(['permission:add_invoice']);
		Route::get('sales/vd-report','VDController@reporte');
		Route::post('sales/vd-delete/{id}','VDController@destroy');

        //vd fornecedor
		Route::get('purchase/vd','PurchaseController@vd')->middleware(['permission:manage_purchase']);
		//Reports of Purchases by Payment
		Route::get('purchase/reportVD','PurchaseController@reportVD');

		Route::get('sales/list','SalesController@index')->middleware(['permission:manage_invoice']);
		Route::get('sales/add','SalesController@create')->middleware(['permission:add_invoice']);
		Route::post('sales/save','SalesController@store');
		Route::get('sales/edit/{id}','SalesController@edit')->middleware(['permission:edit_invoice']);
		Route::post('sales/editStatus/{id}','SalesController@editStatus')->middleware(['permission:edit_invoice'])->name('updateOrder');

		Route::post('sales/update','SalesController@update');
		Route::post('sales/delete/{id}','SalesController@destroy')->middleware(['permission:delete_invoice']);
		Route::post('sales/reference-validation','SalesController@referenceValidation');
		Route::post('sales/get-branches','SalesController@customerBranches');
		Route::post('sales/get-situation','SalesController@customer_info');

		//Sh@dy gething the 
		
		Route::post('sales/get-order-detalhes','SalesController@getDetalhes');
		Route::post('sales/save_vd','VDController@store');
		Route::post('sales/update_vd','VDController@update');
		Route::get('sales/vd/{id}/edit','VDController@edit');



		Route::post('sales/search','SalesController@search');
		Route::post('sales/quantity-validation','SalesController@quantityValidation');
		Route::post('sales/check-item-qty','SalesController@checkItemQty');
		Route::get('sales/preview/{id}','SalesController@pdfview');
        Route::post('sales/quantity-validation-with-localtion','SalesController@quantityValidationWithLocaltion');
		Route::post('sales/quantity-validation-edit-invoice','SalesController@quantityValidationEditInvoice');
		Route::get('sales/filtering','SalesController@salesFiltering');
		// create sales order
		Route::get('order/list','SalesOrderController@index')->middleware(['permission:manage_quotation']);
		Route::get('order/add','SalesOrderController@create')->middleware(['permission:add_quotation']);
		Route::post('order/save','SalesOrderController@store');
		Route::get('order/edit/{id}','SalesOrderController@edit')->middleware(['permission:edit_quotation']);
		Route::post('order/update','SalesOrderController@update');
		Route::post('order/delete/{id}','SalesOrderController@destroy')->middleware(['permission:delete_quotation']);
		Route::get('order/view-order/{id}','SalesOrderController@viewOrder');
		Route::post('order/convert-order','SalesOrderController@convertOrder');
		Route::get('taxasCambio','SalesOrderController@taxasCambio');
		Route::post('order/search','SalesOrderController@search');
		Route::post('order/quantity-validation','SalesOrderController@quantityValidation');
		Route::get('order/view-order-details/{id}','SalesOrderController@viewOrderDetails');
		Route::get('order/auto-invoice-create/{id}','SalesOrderController@autoInvoiceCreate');
		Route::post('order/check-quantity-after-invoice','SalesOrderController@checkQuantityAfterInvoice');
		Route::get('order/pdf/{order_id}','SalesOrderController@orderPdf');
		Route::get('order/print/{order_id}','SalesOrderController@orderPrint');
		Route::post('order/email-order-info','SalesOrderController@sendOrderInformationByEmail');	
		Route::get('order/filtering','SalesOrderController@orderFiltering');	

		// Invoice Routing
        //DEBITO:{orderId}/{invoiceId}/
        Route::get('invoice/view-detail-invoice-debito/{id}','InvoiceDebitoController@viewInvoiceDetailsDebito');
        Route::get('invoice/pdf-debito/{id}','InvoiceDebitoController@invoicePdf');

        Route::get('invoice/pdf-credito/{invoice_id}','InvoiceCreditoController@invoicePdf');

        Route::get('invoice/pdf-contacorrente/{order_id}','CustomerController@contacorrentePdf');
        Route::get('invoice/pdf-contacorrente-pendente/{order_id}','CustomerController@contacorrente_pendentePdf');

        //for
        Route::get('supplier/pdf-contacorrente-pdf/{id}','SupplierController@contacorrentePdf');
        Route::get('supplier/pdf-pendente-pdf/{id}','SupplierController@pendentePdf');

        Route::get('invoice/pdf-vd/{id}','VDController@vdPdf');
        Route::get('purchase/pdf-vd/{id}','PurchaseController@vdPdf');
 
        //GUIA ENTREGA
        Route::get('sales/view_detail_ge/{ge_no}','GEController@viewGe');
        Route::get('invoice/pdf-ge/{ge_no}','GEController@gePdf');
        Route::get('invoice/pdf-ge-print/{ge_no}','GEController@gePrint');
        Route::get('invoice/pdf-gt-print/{ge_no}','GTController@gePrint');

        Route::get('sales/view_detail_gt/{gt_no}','GTController@viewGt');

        Route::get('invoice/pdf-gt/{gt_no}','GTController@gtPdf');
  

        Route::get('invoice/view-detail-vd/{vdId}','VDController@viewVDDetails');
        Route::get('invoice/pdf-vd-print/{vdId}','VDController@vdPrint');
        Route::get('purchase/view-detail-vd/{vdId}','PurchaseController@viewVDDetails');
        Route::get('purchase/pdf-vd-print/{vdId}','PurchaseController@vdPrint')->middleware(['permission:manage_purchase']);

        Route::post('sales/vd/editStatus/{id}','VDController@editStatus')->middleware(['permission:edit_invoice'])->name('updateVD');

       //CREDITO
        //nova routa para a visualizacao dos detalhes da notaCredito
        Route::get('invoice/view-detail-invoice-credito/{id}','InvoiceCreditoController@viewInvoiceDetailsCredito');

		Route::get('invoice/view-detail-invoice/{orderId}/{invoiceId}','InvoiceController@viewInvoiceDetails');
		Route::post('invoice/email-invoice-info','InvoiceController@sendInvoiceInformationByEmail');

		Route::post('invoice/email-invoice-debit-info','InvoiceDebitoController@sendInvoiceInformationByEmail');

		Route::get('invoice/pdf/{order_id}/{invoice_id}','InvoiceController@invoicePdf');
		Route::get('invoice/print/{order_id}/{invoice_id}','InvoiceController@invoicePrint');
		Route::get('invoice/print-debito/{id}','InvoiceDebitoController@invoicePrint');

		Route::get('invoice/print-credito/{invoice_id}','InvoiceCreditoController@invoicePrint');

		Route::post('invoice/delete/{id}','InvoiceController@destroy');
		Route::get('invoice/delete-invoice/{id}','InvoiceController@destroy');
		// Customer 
		Route::get('customer/list','CustomerController@index')->middleware(['permission:manage_customer']);
		Route::get('customer/report','CustomerController@report' );
		Route::get('create-customer','CustomerController@create')->middleware(['permission:add_customer']);
		Route::post('save-customer','CustomerController@store');
		Route::get('customer/edit/{id}','CustomerController@edit')->middleware(['permission:edit_customer']);
		Route::get('customer/order/{id}','CustomerController@salesOrder');
		Route::get('customer/invoice/{id}','CustomerController@invoice');

		//fornecedor cc:
		Route::get('supplier/current_account/{id}','SupplierController@current_account');
		Route::get('supplier/pendentes/{id}','SupplierController@pendente');
		Route::post('supplier/delete/{id}','SupplierController@destroy');

		Route::get('suppliers/pendentes','SupplierController@pendentes_all');
		Route::get('suppliers/pendentes_reporte','SupplierController@pendentes_all_pdf');

		//debitos
		Route::get('customer/debit/{id}','CustomerController@debit');
		//credits
		Route::get('customer/credit/{id}','CustomerController@credit');
		Route::get('customer/payment/{id}','CustomerController@payment');

        //cont corrent
		Route::get('customer/current_account/{id}','CustomerController@current_account');
		Route::get('customer/pendentes/{id}','CustomerController@pendente');


		Route::get('customer/shipment/{id}','CustomerController@shipment');
		Route::post('update-customer/{id}','CustomerController@update');
		Route::post('customer/update-password','CustomerController@updatePassword');
		Route::post('delete-customer/{id}','CustomerController@destroy')->middleware(['permission:delete_customer']);

		Route::get('customerdownloadCsv/{type}', 'CustomerController@downloadCsv');
		Route::get('customerdownloadXls/{xls}', 'CustomerController@downloadCsv');
		Route::get('customerimport', 'CustomerController@import');
		Route::post('customerimportcsv', 'CustomerController@importExcel');
		Route::post('customer/delete-sales-info', 'CustomerController@deleteSalesInfo');
		//rota para eliminar o cliente
		Route::post('customer/delete/{id}', 'CustomerController@destroy');
		//Route::post('customerimportcsv', 'CustomerController@importCsv');

		// Customer Branch
		Route::get('branch','CustomerController@index');
		Route::get('create-branch','CustomerController@create');
		Route::post('save-branch','CustomerController@storeBranch');
		Route::post('edit-branch','CustomerController@editBranch');
		Route::post('update-branch','CustomerController@updateBranch');
		Route::post('delete-branch/{id}','CustomerController@destroyBranch');

		// supplier 
		Route::get('supplier','SupplierController@index')->middleware(['permission:manage_supplier']);
		Route::get('create-supplier','SupplierController@create')->middleware(['permission:add_supplier']);
		Route::post('save-supplier','SupplierController@store');
		Route::get('edit-supplier/{id}','SupplierController@edit')->middleware(['permission:edit_supplier']);
		Route::post('update-supplier/{id}','SupplierController@update');
		Route::post('delete-supplier/{id}','SupplierController@destroy')->middleware(['permission:delete_supplier']);
        Route::get('supplier/orders/{id}','SupplierController@orderList');

		Route::get('supplierdownloadCsv/{type}', 'SupplierController@downloadCsv');
		Route::get('supplierimport', 'SupplierController@import');
		Route::post('supplierimportcsv', 'SupplierController@importCsv');

		Route::get('payment/view-supp-receipt/{id}','PaymentSupplierController@viewSuppReceipt');

		// check-in Purchese Order

		/*PAGAR FORNECEDOR:*/
        Route::post('purchase/pagar/{id}', 'PurchaseController@pagar_edit');

		Route::get('purchase/list','PurchaseController@index')->middleware(['permission:manage_purchase']);
		Route::get('purchase/add','PurchaseController@create')->middleware(['permission:add_purchase']);
		//Report of Purchases
		Route::get('purchase/report', 'PurchaseController@report');
		//add vd compra:
		Route::get('purchase/add_vd','PurchaseController@createVD')->middleware(['permission:add_purchase']);

		Route::post('purchase/save','PurchaseController@store');
		Route::post('purchase/save_vd','PurchaseController@storeVD');
		Route::get('purchase/edit/{id}','PurchaseController@edit')->middleware(['permission:edit_purchase']);
		Route::post('purchase/update','PurchaseController@update');
		Route::post('purchase/delete/{id}','PurchaseController@destroy')->middleware(['permission:delete_purchase']);
		
		Route::post('purchase/item-search','PurchaseController@searchItem');
		Route::get('purchase/view-purchase-details/{id}','PurchaseController@viewPurchaseInvoiceDetail');
	
		Route::get('purchase/pdf/{order_id}','PurchaseController@invoicePdf');
		Route::get('purchase/print/{order_id}','PurchaseController@invoicePrint');
		Route::post('purchase/reference-validation','PurchaseController@referenceValidation');
		
		Route::get('purchase/filtering','PurchaseController@Filtering');

		// Payment Routing
		Route::post('payment/save','PaymentController@createPayment');

		Route::post('payment_supplier/save','PaymentSupplierController@createPayment');
		Route::get('payment_supplier/list','PaymentSupplierController@PaymentListAll')->middleware(['permission:manage_payment']);
		Route::get('payment_supplier/report','PaymentSupplierController@report');

		Route::post('payment_supplier/delete_payment/{id}','PaymentSupplierController@destroy')->middleware(['permission:delete_payment']);
        
        //for cc
		Route::get('supplier/payment_list/{id}','PaymentSupplierController@PaymentListSingle')->middleware(['permission:manage_payment']);

		Route::get('payment_supplier/new_payment','PaymentSupplierController@createPaymentAll');

        // Debito
		Route::post('payment_debit/save','PaymentDebitController@createPayment');
        //Credito paymant
		Route::post('payment_credit/save','PaymentCreditController@createPayment');
        //new payment
		Route::post('payment/save_newpayment','PaymentController@createNewPayment');
		Route::post('payment/get-inv','PaymentController@getInvoices');

        Route::post('payment-supp/save_newpayment','PaymentSupplierController@createNewPayment');
		Route::post('payment-supp/get-inv','PaymentSupplierController@getInvoices');

		// item Tax
		Route::get('tax','TaxController@index');//->middleware(['permission:manage_tax']);
		Route::get('create-tax','TaxController@create')->middleware(['permission:add_tax']);
		Route::post('save-tax','TaxController@store');
		Route::post('edit-tax','TaxController@edit')->middleware(['permission:edit_tax']);
		Route::post('update-tax','TaxController@update');
		Route::post('delete-tax/{id}','TaxController@destroy')->middleware(['permission:delete_tax']);

		// item Sales Type
		Route::get('sales-type','SalesTypeController@index');

		Route::post('save-sales-type','SalesTypeController@store');
		Route::post('edit-sales-type','SalesTypeController@edit');
		Route::post('update-sales-type','SalesTypeController@update');
		Route::post('delete-sales-type/{id}','SalesTypeController@destroy');

		// Settings
		Route::get('setting-general','SettingController@index');
		Route::get('setting-email-template','SettingController@mailTemp');
		Route::get('setting-preference','SettingController@preference');
		Route::get('setting-finance','SettingController@finance');
		Route::get('setting-company','SettingController@company');
		Route::post('save-preference','SettingController@savePreference');
		Route::get('currency','SettingController@currency')->middleware(['permission:manage_currency']);
		Route::post('save-currency','SettingController@store');
		Route::post('edit-currency','SettingController@edit')->middleware(['permission:add_currency']);
		Route::post('update-currency','SettingController@update');
		Route::post('delete-currency/{id}','SettingController@destroy')->middleware(['permission:delete_currency']);
		Route::get('backup/list','SettingController@backupList')->middleware(['permission:manage_db_backup']);
		Route::get('back-up','SettingController@backupDB');
		Route::get('email/setup','SettingController@emailSetup');
		Route::post('save-email-config','SettingController@emailSaveConfig');
		Route::post('test-email','SettingController@testEmailConfig');

		//Actualizar a versao
		Route::get('update/version','SettingController@update_version');





		Route::post('backup/delete/{id}','SettingController@destroyBackup')->middleware(['permission:delete_db_backup']);

		
		//Payment route
		Route::get('payment/terms','SettingController@paymentTerm')->middleware(['permission:manage_payment_term']);
		Route::post('payment/terms/add','SettingController@addPaymentTerms')->middleware(['permission:add_payment_term']);
		Route::post('payment/terms/edit','SettingController@editPaymentTerms')->middleware(['permission:edit_payment_term']);
		Route::post('payment/terms/update','SettingController@updatePaymentTerms');
		Route::post('payment/terms/delete/{id}','SettingController@deletePaymentTerm')->middleware(['permission:delete_payment_term']);
		Route::get('payment/method','SettingController@paymentMethod')->middleware(['permission:manage_payment_method']);
		Route::post('payment/method/add','SettingController@addPaymentMethod')->middleware(['permission:add_payment_method']);
		Route::post('payment/method/edit','SettingController@editPaymentMethod')->middleware(['permission:edit_payment_method']);
		Route::post('payment/method/update','SettingController@updatePaymentMethod');
		Route::post('payment/method/delete/{id}','SettingController@deletePaymentMethod')->middleware(['permission:delete_payment_method']);
		Route::get('company/setting','SettingController@companySetting');
		Route::post('company/setting/save','SettingController@companySettingSave');

		//Route::get('payment/gateway','SettingController@PaymentGateway');
		Route::match(['get', 'post'], 'payment/gateway', 'SettingController@PaymentGateway');
		
		//mail template
		Route::get('mail-temp','MailTemplateController@index');
		Route::get('customer-invoice-temp/{id}','MailTemplateController@customerInvTemp');
		Route::post('customer-invoice-temp/{id}','MailTemplateController@update');

		// Payment Routing
		Route::get('payment/list','PaymentController@index')->middleware(['permission:manage_payment']);

		Route::post('payment/delete_payment/{id}','PaymentController@destroy')->middleware(['permission:delete_payment']);

		Route::get('customers/pendentes','CustomerController@pendentes_all')->middleware(['permission:manage_customer']);
		Route::get('pendentes-reporte','CustomerController@pendentes_all_pdf')->middleware(['permission:manage_invoice']);

		Route::get('payment/new_payment','PaymentController@newpayment');
		//Report of Payment of Invoices
		Route::get('payment/report','PaymentController@report');
     
        Route::get('payment_debit/list','PaymentDebitController@index')->middleware(['permission:manage_payment']);//DEBIT

		Route::post('payment/delete/{id}','PaymentController@delete')->middleware(['permission:delete_payment']);
		Route::get('payment/view-receipt/{id}','PaymentController@viewReceipt');
		Route::get('payment/create-receipt/{id}','PaymentController@createReceiptPdf');
		Route::get('payment/print-receipt/{id}','PaymentController@printReceipt');
		Route::post('payment/email-payment-info','PaymentController@sendPaymentInformationByEmail');
		Route::get('payment/pay-all/{orderid}','PaymentController@payAllAmount');

		Route::get('payment/create-receipt-supp/{id}','PaymentSupplierController@createReceiptPdf');

		Route::get('payment/print-receipt-supp/{id}','PaymentSupplierController@printReceipt');



		Route::get('payment/filtering','PaymentController@paymentFiltering');
		
		Route::post('payment/edit-payment','PaymentController@editPayment')->middleware(['permission:edit_payment']);
		Route::post('payment/update-payment','PaymentController@updatePayment');

		// Shipment Routing
		Route::get('shipment/add/{id}','ShipmentController@createShipment');
		Route::post('shipment/store','ShipmentController@storeShipment');
		Route::get('shipment/create-auto-shipment/{id}','ShipmentController@storeAutoShipment');
		Route::get('shipment/list','ShipmentController@index');
		Route::post('shipment/status-change','ShipmentController@StatusChange');
		Route::post('shipment/delete/{id}','ShipmentController@destroy');
		Route::get('shipment/view-details/{order_id}/{shipment_id}','ShipmentController@shipmentDetails');
		Route::get('shipment/pdf/{order_id}/{shipment_id}','ShipmentController@pdfMake');
		Route::get('shipment/print/{order_id}/{shipment_id}','ShipmentController@shipmentPrint');
		Route::get('shipment/edit/{id}','ShipmentController@edit');
		Route::post('shipment/quantity-validation','ShipmentController@shipmentQuantityValidation');
		Route::post('shipment/update','ShipmentController@update');
		Route::post('shipment/email-shipment-info','ShipmentController@sendShipmentInformationByEmail');
		Route::get('shipment/delivery/{oid}/{sid}','ShipmentController@makeDelivery');

		Route::get('shipment/filtering','ShipmentController@shipmentFiltering');

		// Report Routing
		Route::get('report/inventory-stock-on-hand','ReportController@inventoryStockOnHand')->middleware(['permission:manage_stock_on_hand']);
		
		Route::get('report/inventory-stock-on-hand-pdf','ReportController@inventoryStockOnHandPdf');
		Route::get('report/inventory-stock-on-hand-csv','ReportController@inventoryStockOnHandCsv');
		Route::get('report/sales-report','ReportController@salesReport')->middleware(['permission:manage_sale_report']);
		Route::get('report/sales-report-pdf','ReportController@salesReportPdf');
		Route::get('report/sales-report-csv','ReportController@salesReportCsv');
		Route::get('report/sales-report-by-date/{date}','ReportController@salesReportByDate');
		Route::get('report/sales-report-by-date-pdf/{date}','ReportController@salesReportByDatePdf');
		Route::get('report/sales-report-by-date-csv/{date}','ReportController@salesReportByDateCsv');
		Route::get('sales-report','SalesController@reporte');
		Route::get('sales-report/{from}/{to}/{customer}','SalesController@salesFiltering_pdf');
		Route::get('sales_orders-report','SalesOrderController@reporte');
		

	
		Route::get('report/sales-history-report','ReportController@salesHistoryReport')->middleware(['permission:manage_sale_history_report']);
		Route::get('report/sales-history-report-pdf','ReportController@salesHistoryReportPdf');
		Route::get('report/sales-history-report-csv','ReportController@salesHistoryReportCsv');
		// Purchase Report
        Route::get('report/purchase-report','ReportController@purchaseReport')->middleware(['permission:manage_purchase_report']);
        Route::get('report/purchase-report-pdf','ReportController@purchaseReportPdf');
        Route::get('report/purchase-report-csv','ReportController@purchaseReportCsv');
        Route::get('report/purchase_report_datewise/{time}','ReportController@purchaseReportDateWise');
        Route::get('report/purchase-year-list','ReportController@purchaseYearList');

        Route::get('report/member-report','UserController@memberReport')->middleware(['permission:manage_team_report']);

        // Bank Account
        Route::get('bank/list','BankController@index')->middleware(['permission:manage_bank_account']);
        Route::get('bank/add-account','BankController@addAccount')->middleware(['permission:add_bank_account']);
        Route::post('bank/save-account','BankController@storeAccount');
        Route::get('bank/edit-account/{tab}/{id}','BankController@editAccount')->middleware(['permission:edit_bank_account']);
        Route::post('bank/update-account','BankController@updateAccount');
        Route::get('bank/balances','BankController@bankBalance');
        Route::post('bank/delete/{id}','BankController@destroy')->middleware(['permission: delete_bank_account']);
        Route::get('bank/report','BankController@report');

        // Income expense category
        Route::get('income-expense-category/list','IncomeExpenseCategoryController@index')->middleware(['permission:manage_income_expense_category']);
        Route::post('income-expense-category/save','IncomeExpenseCategoryController@store');
        Route::post('income-expense-category/edit','IncomeExpenseCategoryController@edit')->middleware(['permission:edit_income_expense_category']);
        Route::post('income-expense-category/update','IncomeExpenseCategoryController@update');
        Route::post('income-expense-category/delete/{id}','IncomeExpenseCategoryController@destroy')->middleware(['permission:delete_income_expense_category']);

        //Deposit
        Route::get('deposit/list','DepositController@index')->middleware(['permission:manage_deposit']);
        Route::get('deposit/add-deposit','DepositController@addDeposit')->middleware(['permission:add_deposit']);
        Route::post('deposit/save','DepositController@store');
        Route::get('deposit/edit-deposit/{id}','DepositController@editDeposit')->middleware(['permission:edit_deposit']);
        Route::post('deposit/update','DepositController@updateDeposit');
        Route::post('deposit/delete/{id}','DepositController@destroy')->middleware(['permission:delete_deposit']);
        Route::get('deposit/report','DepositController@report');

        //Expense
        Route::get('expense/list','ExpenseController@index')->middleware(['permission:manage_expense']);
        Route::get('expense/report','ExpenseController@report');
        
        Route::get('expense/add-expense','ExpenseController@addExpense')->middleware(['permission:add_expense']);
        Route::post('expense/save','ExpenseController@store');
        Route::get('expense/edit-expense/{id}','ExpenseController@editExpense')->middleware(['permission:edit_expense']);
        Route::post('expense/update','ExpenseController@updateExpense');
        Route::post('expense/delete/{id}','ExpenseController@destroy')->middleware(['permission:delete_expense']);
		
		// Balance Transfer Routing
		Route::get('transfer/list','BalanceTransferController@index')->middleware(['permission:manage_balance_transfer']);
		Route::get('transfer/create','BalanceTransferController@addTransfer')->middleware(['permission:add_balance_transfer']);
		Route::post('transfer/save','BalanceTransferController@store');
		Route::post('transfer/check-balance','BalanceTransferController@checkBalance');
		Route::post('transfer/delete/{id}','BalanceTransferController@destroy')->middleware(['permission:delete_balance_transfer']);
		Route::get('transfer/edit-transfer/{id}','BalanceTransferController@editTransfer')->middleware(['permission:edit_balance_transfer']);
		Route::post('transfer/update','BalanceTransferController@updateTransfer');
		Route::get('tranfer/report','BalanceTransferController@report');

		// Transaction Routing
		Route::get('transaction/list','TransactionController@index')->middleware(['permission:manage_transaction']);
		Route::get('transaction/expense-report','TransactionController@expenseReport');
		Route::post('transaction/delete/{id}','TransactionController@destroy');
		Route::get('transaction/edit/{id}','TransactionController@edit');
		Route::get('transaction/update','TransactionController@update');
		Route::get('transaction/income-report','TransactionController@incomeReport')->middleware(['permission:manage_income_report']);
		Route::get('transaction/income-vs-expense','TransactionController@incomeVsExpense')->middleware(['permission:manage_income_vs_expense']);
		Route::get('transaction/report','TransactionController@report');

		// Barcode Generation
		Route::match(['get','post'],'barcode/create',  'BarcodeController@index')->middleware(['permission:manage_barcode']);
		Route::post('barcode/search','BarcodeController@search');

		// Rota para relatorio de Fornecedores
		Route::get('supplier/report','supplierController@report' );


		//Gestao dos planos	
		Route::post('save-produto','ProdutoSubscricaoController@store');
		Route::post('save-plano','ProdutoSubscricaoController@store_plano');

		Route::post('edit-produto','ProdutoSubscricaoController@edit');
		Route::post('edit-plano','ProdutoSubscricaoController@edit_plano');

		Route::post('update-plano','ProdutoSubscricaoController@update_plano');
		Route::post('update-produto','ProdutoSubscricaoController@update_produto');
		
		Route::resource('produto/plano','ProdutoSubscricaoController' );
		Route::post('valor_plano','ProdutoSubscricaoController@edit_plano');

		//
		Route::post('plano/delete/{id}','ProdutoSubscricaoController@destroy_plano');
		Route::post('produto/delete/{id}','ProdutoSubscricaoController@destroy');

		Route::get('subscrition','SubscricaoController@index' );
		Route::get('subscrition/create','SubscricaoController@create');
		Route::post('subscrition-store','SubscricaoController@store');
		Route::post('subscrition-update','SubscricaoController@update');
		Route::post('edit-subcription','SubscricaoController@editar');
		Route::post('subscrition/delete/{id}','SubscricaoController@destroy');

		// verficar o tipo de cliente
		Route::post('tipo_de_cliente','CustomerController@tipo_de_cliente');


		// routas para o visualizacao dos relatorios;
	
	    Route::get('report/inventory-sold','ReportController@venda_por_stock')->middleware(['permission:manage_stock_on_hand']);

	    Route::get('report/inventory-sold/new/pdf','ReportController@venda_por_stock_pdf')->middleware(['permission:manage_stock_on_hand']);

	    Route::get('report/inventory-stock-hand','ReportController@inventoryExistente')->middleware(['permission:manage_stock_on_hand']);


	     Route::get('report/inventory-general','ReportController@inventoryGeneral')->middleware(['permission:manage_stock_on_hand']);
	    



	     Route::resource('pdf','PDFController');
	     Route::get('emissao/{id}/cheques', 'PDFController@cheques');
	     Route::get('report/inventory/sold/{inicio}/{fim}', 'PDFController@sold_report');
	    
	    


	});
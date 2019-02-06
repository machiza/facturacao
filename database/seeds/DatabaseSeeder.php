<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
       Model::unguard();

       // Seeding when installation start
        $this->call(BankAccountTypeTableSeeder::class); 
        $this->call(EmailConfigTableSeeder::class);
        $this->call(EmailTempDetailsTableSeeder::class);
        $this->call(PaymentTermsTableSeeder::class);
        $this->call(CurrencyTableSeeder::class);
        //$this->call(MoedasTableSeeder::class);
        //$this->call(TaxasTableSeeder::class);


/*
      $this->call(CountryListTableSeeder::class);

      $this->call(CurrencyTableSeeder::class);

      $this->call(EmailConfigTableSeeder::class);

      $this->call(EmailTempDetailsTableSeeder::class);

      $this->call(IncomeExpenseCategoryTableSeeder::class); 

      $this->call(InvoicePaymentTermsTableSeeder::class); 

      $this->call(ItemTaxTypesTableSeeder::class);

      $this->call(ItemUnitTableSeeder::class);

      $this->call(LocationTableSeeder::class);

      $this->call(MonthTableSeeder::class); 

      $this->call(PaymentTermsTableSeeder::class);

      $this->call(PreferenceTableSeeder::class);        

      $this->call(SalesTypesTableSeeder::class);

      $this->call(SecurityRoleTableSeeder::class);

      $this->call(StockCategoryTableSeeder::class);

      $this->call(PaymentGatewayTableSeeder::class);

      $this->call(PermissionsTableSeeder::class);

      $this->call(RolesTableSeeder::class);

      $this->call(PermissionRoleTableSeeder::class);

      $this->call(RoleUserTableSeeder::class);

  */

      // Seeding when installation end

      // Seeding when cron run start
     
    /*  $this->call(AdminUserTableSeeder::class);

      $this->call(BankAccountTableSeeder::class);

      $this->call(BankTransactionTableSeeder::class);

      $this->call(OrderCustomItemTableSeeder::class); 

      $this->call(DebtorMasterTableSeeder::class); 

      $this->call(CustomerBranchTableSeeder::class);

      $this->call(ItemCodeTableSeeder::class); 

      $this->call(PaymentHistoryTableSeeder::class);

      $this->call(PurchasePriceTableSeeder::class);

      $this->call(PurchaseOrderTableSeeder::class);

      $this->call(PurchaseOrderDetailTableSeeder::class);

      $this->call(SalesOrderTableSeeder::class);                

      $this->call(SalesOrderDetailTableSeeder::class); 

      $this->call(SalesPriceTableSeeder::class);

      $this->call(StockMasterTableSeeder::class);

      $this->call(SupplierTableSeeder::class);

      $this->call(StockMoveTableSeeder::class);
      */
      
    }
}

<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();

        DB::table('permissions')->insert([
             
              // Relationship Start
              ['id' => '1', 'name' => 'manage_relationship', 'display_name' => 'Manage Relationship', 'description' => 'Manage Relationship'],

              ['id' => '2', 'name' => 'manage_customer', 'display_name' => 'Manage Customers', 'description' => 'Manage Customers'],
              ['id' => '3', 'name' => 'add_customer', 'display_name' => 'Add Customer', 'description' => 'Add Customer'],
              ['id' => '4', 'name' => 'edit_customer', 'display_name' => 'Edit Customer', 'description' => 'Edit Customer'],
              ['id' => '5', 'name' => 'delete_customer', 'display_name' => 'Delete Customer', 'description' => 'Delete Customer'],

              ['id' => '6', 'name' => 'manage_supplier', 'display_name' => 'Manage Suppliers', 'description' => 'Manage Suppliers'],
              ['id' => '7', 'name' => 'add_supplier', 'display_name' => 'Add Supplier', 'description' => 'Add Supplier'],
              ['id' => '8', 'name' => 'edit_supplier', 'display_name' => 'Edit Supplier', 'description' => 'Edit Supplier'],
              ['id' => '9', 'name' => 'delete_supplier', 'display_name' => 'Delete Supplier', 'description' => 'Delete Supplier'],
              
              // Items Start
              ['id' => '10', 'name' => 'manage_item', 'display_name' => 'Manage Items', 'description' => 'Manage Items'],
              ['id' => '11', 'name' => 'add_item', 'display_name' => 'Add Item', 'description' => 'Add Item'],
              ['id' => '12', 'name' => 'edit_item', 'display_name' => 'Edit Item', 'description' => 'Edit Item'],
              ['id' => '13', 'name' => 'delete_item', 'display_name' => 'Delete Item', 'description' => 'Delete Item'],

              // Sales Start
              ['id' => '14', 'name' => 'manage_sale', 'display_name' => 'Manage Sales', 'description' => 'Manage Sales'],

              ['id' => '15', 'name' => 'manage_quotation', 'display_name' => 'Manage Quotations', 'description' => 'Manage Quotations'],
              ['id' => '16', 'name' => 'add_quotation', 'display_name' => 'Add Quotation', 'description' => 'Add Quotation'],
              ['id' => '17', 'name' => 'edit_quotation', 'display_name' => 'Edit Quotation', 'description' => 'Edit Quotation'],
              ['id' => '18', 'name' => 'delete_quotation', 'display_name' => 'Delete Quotation', 'description' => 'Delete Quotation'],

              ['id' => '19', 'name' => 'manage_invoice', 'display_name' => 'Manage Invoices', 'description' => 'Manage Invoices'],
              ['id' => '20', 'name' => 'add_invoice', 'display_name' => 'Add Invoice', 'description' => 'Add Invoice'],
              ['id' => '21', 'name' => 'edit_invoice', 'display_name' => 'Edit Invoice', 'description' => 'Edit Invoice'],
              ['id' => '22', 'name' => 'delete_invoice', 'display_name' => 'Delete Invoice', 'description' => 'Delete Invoice'],

              ['id' => '23', 'name' => 'manage_payment', 'display_name' => 'Manage Payment', 'description' => 'Manage Payment'],
              ['id' => '24', 'name' => 'add_payment', 'display_name' => 'Add Payment', 'description' => 'Add Payment'],
              ['id' => '25', 'name' => 'edit_payment', 'display_name' => 'Edit Payment', 'description' => 'Edit Payment'],
              ['id' => '26', 'name' => 'delete_payment', 'display_name' => 'Delete Payment', 'description' => 'Delete Payment'],

              // Purchase Start
              ['id' => '27', 'name' => 'manage_purchase', 'display_name' => 'Manage Purchase', 'description' => 'Manage Purchase'],
              ['id' => '28', 'name' => 'add_purchase', 'display_name' => 'Add Purchase', 'description' => 'Add Purchase'],
              ['id' => '29', 'name' => 'edit_purchase', 'display_name' => 'Edit Purchase', 'description' => 'Edit Purchase'],
              ['id' => '30', 'name' => 'delete_purchase', 'display_name' => 'Delete Purchase', 'description' => 'Delete Purchase'],
              
              // Manage Banking & Transactions Start
              ['id' => '31', 'name' => 'manage_banking_transaction', 'display_name' => 'Manage Banking & Transactions', 'description' => 'Manage Banking & Transactions'],

              ['id' => '32', 'name' => 'manage_bank_account', 'display_name' => 'Manage Bank Accounts', 'description' => 'Manage Bank Accounts'],
              ['id' => '33', 'name' => 'add_bank_account', 'display_name' => 'Add Bank Account', 'description' => 'Add Bank Account'],
              ['id' => '34', 'name' => 'edit_bank_account', 'display_name' => 'Edit Bank Account', 'description' => 'Edit Bank Account'],
              ['id' => '35', 'name' => 'delete_bank_account', 'display_name' => 'Delete Bank Account', 'description' => 'Delete Bank Account'],

              ['id' => '36', 'name' => 'manage_deposit', 'display_name' => 'Manage Deposit', 'description' => 'Manage Deposit'],
              ['id' => '37', 'name' => 'add_deposit', 'display_name' => 'Add Deposit', 'description' => 'Add Deposit'],
              ['id' => '38', 'name' => 'edit_deposit', 'display_name' => 'Edit Deposit', 'description' => 'Edit Deposit'],
              ['id' => '39', 'name' => 'delete_deposit', 'display_name' => 'Delete Deposit', 'description' => 'Delete Deposit'],

              ['id' => '40', 'name' => 'manage_balance_transfer', 'display_name' => 'Manage Balance Transfer', 'description' => 'Manage Balance Transfer'],
              ['id' => '41', 'name' => 'add_balance_transfer', 'display_name' => 'Add Balance Transfer', 'description' => 'Add Balance Transfer'],
              ['id' => '42', 'name' => 'edit_balance_transfer', 'display_name' => 'Edit Balance Transfer', 'description' => 'Edit Balance Transfer'],
              ['id' => '43', 'name' => 'delete_balance_transfer', 'display_name' => 'Delete Balance Transfer', 'description' => 'Delete Balance Transfer'],  

              ['id' => '44', 'name' => 'manage_transaction', 'display_name' => 'Manage Transactions', 'description' => 'Manage Transactions'],

              // Expense Start
              ['id' => '45', 'name' => 'manage_expense', 'display_name' => 'Manage Expense', 'description' => 'Manage Expense'],
              ['id' => '46', 'name' => 'add_expense', 'display_name' => 'Add Expense', 'description' => 'Add Expense'],
              ['id' => '47', 'name' => 'edit_expense', 'display_name' => 'Edit Expense', 'description' => 'Edit Expense'],
              ['id' => '48', 'name' => 'delete_expense', 'display_name' => 'Delete Expense', 'description' => 'Delete Expense'],
 
              // Report Start
              ['id' => '49', 'name' => 'manage_report', 'display_name' => 'Manage Report', 'description'=> 'Manage Report'],

              ['id' => '50', 'name' => 'manage_stock_on_hand', 'display_name' => 'Manage Inventory Stock On Hand' , 'description'=> 'Manage Inventory Stock On Hand'],

              ['id' => '51', 'name' => 'manage_sale_report', 'display_name' => 'Manage Sales Report' , 'description'=> 'Manage Sales Report'],
             
              ['id' => '52', 'name' => 'manage_sale_history_report', 'display_name' => 'Manage Sales History Report', 'description' => 'Manage Sales History Report'],
              ['id' => '53', 'name' => 'manage_purchase_report', 'display_name' => 'Manage Purchase Report' , 'description'=> 'Manage Purchase Report'],
              ['id' => '54', 'name' => 'manage_team_report', 'display_name' => 'Manage Team Member Report' , 'description'=> 'Manage Team Member Report'],
              ['id' => '55', 'name' => 'manage_expense_report', 'display_name' => 'Manage Expense Report' , 'description'=> 'Manage Expense Report'],
              
              ['id' => '56', 'name' => 'manage_income_report', 'display_name' => 'Manage Income Report' , 'description'=> 'Manage Income Report'],

              ['id' => '57', 'name' => 'manage_income_vs_expense', 'display_name' => 'Manage Income vs Expense', 'description' => 'Manage Income vs Expense'],

              // Setiings Start

              ['id' => '58', 'name' => 'manage_setting', 'display_name' => 'Manage Settings', 'description' => 'Manage Settings'],

              // Company Setiings Start
              ['id' => '59', 'name' => 'manage_company_setting', 'display_name' => 'Manage Company Setting', 'description' => 'Manage Company Setting'],

              ['id' => '60', 'name' => 'manage_team_member', 'display_name' => 'Manage Team Member', 'description' => 'Manage Team Member'],
              ['id' => '61', 'name' => 'add_team_member', 'display_name' => 'Add Team Member', 'description' => 'Add Team Member'],
              ['id' => '62', 'name' => 'edit_team_member', 'display_name' => 'Edit Team Member', 'description' => 'Edit Team Member'],
              ['id' => '63', 'name' => 'delete_team_member', 'display_name' => 'Delete Team Member', 'description' => 'Delete Team Member'],

              ['id' => '64', 'name' => 'manage_role', 'display_name' => 'Manage Roles', 'description' => 'Manage Roles'],
              ['id' => '65', 'name' => 'add_role', 'display_name' => 'Add Role', 'description' => 'Add Role'],
              ['id' => '66', 'name' => 'edit_role', 'display_name' => 'Edit Role', 'description' => 'Edit Role'],
              ['id' => '67', 'name' => 'delete_role', 'display_name' => 'Delete Role', 'description' => 'Delete Role'],

              ['id' => '68', 'name' => 'manage_location', 'display_name' => 'Manage Location', 'description' => 'Manage Location'],
              ['id' => '69', 'name' => 'add_location', 'display_name' => 'Add Location', 'description' => 'Add Location'],
              ['id' => '70', 'name' => 'edit_location', 'display_name' => 'Edit Location', 'description' => 'Edit Location'],
              ['id' => '71', 'name' => 'delete_location', 'display_name' => 'Delete Location', 'description' => 'Delete Location'],

              // Start General Setting

              ['id' => '72', 'name' => 'manage_general_setting', 'display_name' => 'Manage General Settings', 'description' => 'Manage General Settings'],

              ['id' => '73', 'name' => 'manage_item_category', 'display_name' => 'Manage Item Category', 'description' => 'Manage Item Category'],
              ['id' => '74', 'name' => 'add_item_category', 'display_name' => 'Add Item Category', 'description' => 'Add Item Category'],
              ['id' => '75', 'name' => 'edit_item_category', 'display_name' => 'Edit Item Category', 'description' => 'Edit Item Category'],
              ['id' => '76', 'name' => 'delete_item_category', 'display_name' => 'Delete Item Category', 'description' => 'Delete Item Category'],


              ['id' => '77', 'name' => 'manage_income_expense_category', 'display_name' => 'Manage Income Expense Category', 'description' => 'Manage Income Expense Category'],
              ['id' => '78', 'name' => 'add_income_expense_category', 'display_name' => 'Add Income Expense Category', 'description' => 'Add Income Expense Category'],
              ['id' => '79', 'name' => 'edit_income_expense_category', 'display_name' => 'Edit Income Expense Category', 'description' => 'Edit Income Expense Category'],
              ['id' => '80', 'name' => 'delete_income_expense_category', 'display_name' => 'Delete Income Expense Category', 'description' => 'Delete Income Expense Category'],


              ['id' => '81', 'name' => 'manage_unit', 'display_name' => 'Manage Unit', 'description' => 'Manage Unit'],
              ['id' => '82', 'name' => 'add_unit', 'display_name' => 'Add Unit', 'description' => 'Add Unit'],
              ['id' => '83', 'name' => 'edit_unit', 'display_name' => 'Edit Unit', 'description' => 'Edit Unit'],
              ['id' => '84', 'name' => 'delete_unit', 'display_name' => 'Delete Unit', 'description' => 'Delete Unit'],

              ['id' => '85', 'name' => 'manage_db_backup', 'display_name' => 'Manage Database Backup', 'description' => 'Manage Database Backup'],
              ['id' => '86', 'name' => 'add_db_backup', 'display_name' => 'Add Database Backup', 'description' => 'Add Database Backup'],
              ['id' => '87', 'name' => 'delete_db_backup', 'display_name' => 'Delete Database Backup', 'description' => 'Delete Database Backup'],

              ['id' => '88', 'name' => 'manage_email_setup', 'display_name' => 'Manage Email Setup', 'description' => 'Manage Email Setup'],

              // Start Finance
              ['id' => '89', 'name' => 'manage_finance', 'display_name' => 'Manage Finance', 'description' => 'Manage Finance'],

              ['id' => '90', 'name' => 'manage_tax', 'display_name' => 'Manage Taxs', 'description' => 'Manage Taxs'],
              ['id' => '91', 'name' => 'add_tax', 'display_name' => 'Add Tax', 'description' => 'Add Tax'],
              ['id' => '92', 'name' => 'edit_tax', 'display_name' => 'Edit Tax', 'description' => 'Edit Tax'],
              ['id' => '93', 'name' => 'delete_tax', 'display_name' => 'Delete Tax', 'description' => 'Delete Tax'],

              ['id' => '94', 'name' => 'manage_currency', 'display_name' => 'Manage Currency', 'description' => 'Manage Currency'],
              ['id' => '95', 'name' => 'add_currency', 'display_name' => 'Add Currency', 'description' => 'Add Currency'],
              ['id' => '96', 'name' => 'edit_currency', 'display_name' => 'Edit Currency', 'description' => 'Edit Currency'],
              ['id' => '97', 'name' => 'delete_currency', 'display_name' => 'Delete Currency', 'description' => 'Delete Currency'],

              ['id' => '98', 'name' => 'manage_payment_term', 'display_name' => 'Manage Payment Term', 'description' => 'Manage Payment Term'],
              ['id' => '99', 'name' => 'add_payment_term', 'display_name' => 'Add Payment Term', 'description' => 'Add Payment Term'],
              ['id' => '100', 'name' => 'edit_payment_term', 'display_name' => 'Edit Payment Term', 'description' => 'Edit Payment Term'],
              ['id' => '101', 'name' => 'delete_payment_term', 'display_name' => 'Delete Payment Term', 'description' => 'Delete Payment Term'],

              ['id' => '102', 'name' => 'manage_payment_method', 'display_name' => 'Manage Payment Method', 'description' => 'Manage Payment Method'],
              ['id' => '103', 'name' => 'add_payment_method', 'display_name' => 'Add Payment Method', 'description' => 'Add Payment Method'],
              ['id' => '104', 'name' => 'edit_payment_method', 'display_name' => 'Edit Payment Method', 'description' => 'Edit Payment Method'],
              ['id' => '105', 'name' => 'delete_payment_method', 'display_name' => 'Delete Payment Method', 'description' => 'Delete Payment Method'],

              ['id' => '106', 'name' => 'manage_payment_gateway', 'display_name' => 'Manage Payment Method', 'description' => 'Manage Payment Gateway'],   

               // Start Email Template   
                ['id' => '107', 'name' => 'manage_email_template', 'display_name' => 'Manage Email Template', 'description' => 'Manage Email Template'], 

                ['id' => '108', 'name' => 'manage_quotation_email_template', 'display_name' => 'Manage Quotation Template', 'description' => 'Manage Quotation Email Template'], 
                ['id' => '109', 'name' => 'manage_invoice_email_template', 'display_name' => 'Manage Invoice Email Template', 'description' => 'Manage Invoice Email Template'], 
                ['id' => '110', 'name' => 'manage_payment_email_template', 'display_name' => 'Manage Payment Email Template', 'description' => 'Manage Payment Email Template'],

                // Start Preference
               ['id' => '111', 'name' => 'manage_preference', 'display_name' => 'Manage Preference', 'description' => 'Manage Preference'],
               
                // Start Print barcode/label
               ['id' => '112', 'name' => 'manage_barcode', 'display_name' => 'Manage barcode/label', 'description' => 'Manage barcode/label'],

               ['id' => '113', 'name' => 'download_db_backup', 'display_name' => 'Download Database Backup', 'description' => 'Download Database Backup'],              

        ]);
    }
}



CREATE TABLE IF NOT EXISTS `backup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE IF NOT EXISTS `bank_account_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO bank_account_type VALUES("1","Savings Account");
INSERT INTO bank_account_type VALUES("2","Chequing Account");
INSERT INTO bank_account_type VALUES("3","Credit Account");
INSERT INTO bank_account_type VALUES("4","Cash Account");





CREATE TABLE IF NOT EXISTS `bank_accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_type_id` tinyint(4) NOT NULL,
  `account_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `account_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `bank_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `bank_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default_account` tinyint(4) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO bank_accounts VALUES("1","1","John Bradon","100001","Bank of America Corp","USA","1","0");
INSERT INTO bank_accounts VALUES("2","3","Michle Harry","200001","JPMorgan Chase & Co","USA","0","0");
INSERT INTO bank_accounts VALUES("3","4","Mr. Russell","300001","Bank of America","USA","0","0");





CREATE TABLE IF NOT EXISTS `bank_trans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `amount` double NOT NULL,
  `trans_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `account_no` int(11) NOT NULL,
  `trans_date` date NOT NULL,
  `person_id` int(11) NOT NULL,
  `reference` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `attachment` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO bank_trans VALUES("1","1000","cash-in","1","2017-05-30","1","opening balance","opening balance","1","1","","2017-05-30 05:45:26");
INSERT INTO bank_trans VALUES("2","5000","cash-in","2","2017-05-30","1","opening balance","opening balance","1","1","","2017-05-30 05:45:26");
INSERT INTO bank_trans VALUES("3","10000","cash-in","3","2017-05-30","1","opening balance","opening balance","1","1","","2017-05-30 05:45:26");
INSERT INTO bank_trans VALUES("4","50000","deposit","1","2017-05-05","1","","New Deposit","1","1","","2017-05-05 05:45:26");
INSERT INTO bank_trans VALUES("5","35000","deposit","2","2017-05-08","1","","New Deposit","2","1","","2017-05-08 05:45:26");
INSERT INTO bank_trans VALUES("6","60000","deposit","3","2017-05-23","1","","New Deposit","1","2","","2017-05-23 05:45:26");
INSERT INTO bank_trans VALUES("7","500","deposit","2","2017-05-18","1","","New Deposit","1","1","","2017-05-18 05:45:26");
INSERT INTO bank_trans VALUES("8","40000","deposit","1","2017-05-30","1","","New Deposit","1","1","","2017-05-30 05:45:26");
INSERT INTO bank_trans VALUES("9","5000","deposit","3","2017-02-19","1","","New Doposit","1","1","","2017-02-19 05:45:26");
INSERT INTO bank_trans VALUES("10","-45000","expense","1","2017-01-23","1","","New Expense","4","1","","2017-01-23 05:45:26");
INSERT INTO bank_trans VALUES("11","-40000","expense","2","2017-05-05","1","","New Expense","3","1","","2017-05-05 05:45:26");
INSERT INTO bank_trans VALUES("12","-35000","expense","1","2017-05-24","1","","New Expense","3","1","","2017-05-24 05:45:26");
INSERT INTO bank_trans VALUES("13","-3000","expense","1","2017-05-28","1","","New Expense","3","1","","2017-05-28 05:45:26");
INSERT INTO bank_trans VALUES("14","25000","deposit","1","2017-05-18","1","","New Deposit","1","1","","2017-05-18 05:45:26");
INSERT INTO bank_trans VALUES("15","-5000","expense","1","2017-05-18","1","","New Expense","3","1","","2017-05-18 05:45:26");
INSERT INTO bank_trans VALUES("16","60000","deposit","1","2017-02-07","1","","New Deposit","1","1","","2017-02-07 05:45:26");
INSERT INTO bank_trans VALUES("17","615","cash-in-by-sale","2","2017-05-30","1","","Payment for INV-0002","1","1","","2017-05-30 05:45:26");
INSERT INTO bank_trans VALUES("18","500","cash-in-by-sale","1","2017-05-25","1","","Payment for INV-0003","1","1","","2017-05-25 05:45:26");





CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=243 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO countries VALUES("1","United States","US");
INSERT INTO countries VALUES("2","Canada","CA");
INSERT INTO countries VALUES("3","Afghanistan","AF");
INSERT INTO countries VALUES("4","Albania","AL");
INSERT INTO countries VALUES("5","Algeria","DZ");
INSERT INTO countries VALUES("6","American Samoa","AS");
INSERT INTO countries VALUES("7","Andorra","AD");
INSERT INTO countries VALUES("8","Angola","AO");
INSERT INTO countries VALUES("9","Anguilla","AI");
INSERT INTO countries VALUES("10","Antarctica","AQ");
INSERT INTO countries VALUES("11","Antigua and/or Barbuda","AG");
INSERT INTO countries VALUES("12","Argentina","AR");
INSERT INTO countries VALUES("13","Armenia","AM");
INSERT INTO countries VALUES("14","Aruba","AW");
INSERT INTO countries VALUES("15","Australia","AU");
INSERT INTO countries VALUES("16","Austria","AT");
INSERT INTO countries VALUES("17","Azerbaijan","AZ");
INSERT INTO countries VALUES("18","Bahamas","BS");
INSERT INTO countries VALUES("19","Bahrain","BH");
INSERT INTO countries VALUES("20","Bangladesh","BD");
INSERT INTO countries VALUES("21","Barbados","BB");
INSERT INTO countries VALUES("22","Belarus","BY");
INSERT INTO countries VALUES("23","Belgium","BE");
INSERT INTO countries VALUES("24","Belize","BZ");
INSERT INTO countries VALUES("25","Benin","BJ");
INSERT INTO countries VALUES("26","Bermuda","BM");
INSERT INTO countries VALUES("27","Bhutan","BT");
INSERT INTO countries VALUES("28","Bolivia","BO");
INSERT INTO countries VALUES("29","Bosnia and Herzegovina","BA");
INSERT INTO countries VALUES("30","Botswana","BW");
INSERT INTO countries VALUES("31","Bouvet Island","BV");
INSERT INTO countries VALUES("32","Brazil","BR");
INSERT INTO countries VALUES("33","British lndian Ocean Territory","IO");
INSERT INTO countries VALUES("34","Brunei Darussalam","BN");
INSERT INTO countries VALUES("35","Bulgaria","BG");
INSERT INTO countries VALUES("36","Burkina Faso","BF");
INSERT INTO countries VALUES("37","Burundi","BI");
INSERT INTO countries VALUES("38","Cambodia","KH");
INSERT INTO countries VALUES("39","Cameroon","CM");
INSERT INTO countries VALUES("40","Cape Verde","CV");
INSERT INTO countries VALUES("41","Cayman Islands","KY");
INSERT INTO countries VALUES("42","Central African Republic","CF");
INSERT INTO countries VALUES("43","Chad","TD");
INSERT INTO countries VALUES("44","Chile","CL");
INSERT INTO countries VALUES("45","China","CN");
INSERT INTO countries VALUES("46","Christmas Island","CX");
INSERT INTO countries VALUES("47","Cocos (Keeling) Islands","CC");
INSERT INTO countries VALUES("48","Colombia","CO");
INSERT INTO countries VALUES("49","Comoros","KM");
INSERT INTO countries VALUES("50","Congo","CG");
INSERT INTO countries VALUES("51","Cook Islands","CK");
INSERT INTO countries VALUES("52","Costa Rica","CR");
INSERT INTO countries VALUES("53","Croatia (Hrvatska)","HR");
INSERT INTO countries VALUES("54","Cuba","CU");
INSERT INTO countries VALUES("55","Cyprus","CY");
INSERT INTO countries VALUES("56","Czech Republic","CZ");
INSERT INTO countries VALUES("57","Democratic Republic of Congo","CD");
INSERT INTO countries VALUES("58","Denmark","DK");
INSERT INTO countries VALUES("59","Djibouti","DJ");
INSERT INTO countries VALUES("60","Dominica","DM");
INSERT INTO countries VALUES("61","Dominican Republic","DO");
INSERT INTO countries VALUES("62","East Timor","TP");
INSERT INTO countries VALUES("63","Ecudaor","EC");
INSERT INTO countries VALUES("64","Egypt","EG");
INSERT INTO countries VALUES("65","El Salvador","SV");
INSERT INTO countries VALUES("66","Equatorial Guinea","GQ");
INSERT INTO countries VALUES("67","Eritrea","ER");
INSERT INTO countries VALUES("68","Estonia","EE");
INSERT INTO countries VALUES("69","Ethiopia","ET");
INSERT INTO countries VALUES("70","Falkland Islands (Malvinas)","FK");
INSERT INTO countries VALUES("71","Faroe Islands","FO");
INSERT INTO countries VALUES("72","Fiji","FJ");
INSERT INTO countries VALUES("73","Finland","FI");
INSERT INTO countries VALUES("74","France","FR");
INSERT INTO countries VALUES("75","France, Metropolitan","FX");
INSERT INTO countries VALUES("76","French Guiana","GF");
INSERT INTO countries VALUES("77","French Polynesia","PF");
INSERT INTO countries VALUES("78","French Southern Territories","TF");
INSERT INTO countries VALUES("79","Gabon","GA");
INSERT INTO countries VALUES("80","Gambia","GM");
INSERT INTO countries VALUES("81","Georgia","GE");
INSERT INTO countries VALUES("82","Germany","DE");
INSERT INTO countries VALUES("83","Ghana","GH");
INSERT INTO countries VALUES("84","Gibraltar","GI");
INSERT INTO countries VALUES("85","Greece","GR");
INSERT INTO countries VALUES("86","Greenland","GL");
INSERT INTO countries VALUES("87","Grenada","GD");
INSERT INTO countries VALUES("88","Guadeloupe","GP");
INSERT INTO countries VALUES("89","Guam","GU");
INSERT INTO countries VALUES("90","Guatemala","GT");
INSERT INTO countries VALUES("91","Guinea","GN");
INSERT INTO countries VALUES("92","Guinea-Bissau","GW");
INSERT INTO countries VALUES("93","Guyana","GY");
INSERT INTO countries VALUES("94","Haiti","HT");
INSERT INTO countries VALUES("95","Heard and Mc Donald Islands","HM");
INSERT INTO countries VALUES("96","Honduras","HN");
INSERT INTO countries VALUES("97","Hong Kong","HK");
INSERT INTO countries VALUES("98","Hungary","HU");
INSERT INTO countries VALUES("99","Iceland","IS");
INSERT INTO countries VALUES("100","India","IN");
INSERT INTO countries VALUES("101","Indonesia","ID");
INSERT INTO countries VALUES("102","Iran (Islamic Republic of)","IR");
INSERT INTO countries VALUES("103","Iraq","IQ");
INSERT INTO countries VALUES("104","Ireland","IE");
INSERT INTO countries VALUES("105","Israel","IL");
INSERT INTO countries VALUES("106","Italy","IT");
INSERT INTO countries VALUES("107","Ivory Coast","CI");
INSERT INTO countries VALUES("108","Jamaica","JM");
INSERT INTO countries VALUES("109","Japan","JP");
INSERT INTO countries VALUES("110","Jordan","JO");
INSERT INTO countries VALUES("111","Kazakhstan","KZ");
INSERT INTO countries VALUES("112","Kenya","KE");
INSERT INTO countries VALUES("113","Kiribati","KI");
INSERT INTO countries VALUES("114","Korea, Democratic People\'s Republic of","KP");
INSERT INTO countries VALUES("115","Korea, Republic of","KR");
INSERT INTO countries VALUES("116","Kuwait","KW");
INSERT INTO countries VALUES("117","Kyrgyzstan","KG");
INSERT INTO countries VALUES("118","Lao People\'s Democratic Republic","LA");
INSERT INTO countries VALUES("119","Latvia","LV");
INSERT INTO countries VALUES("120","Lebanon","LB");
INSERT INTO countries VALUES("121","Lesotho","LS");
INSERT INTO countries VALUES("122","Liberia","LR");
INSERT INTO countries VALUES("123","Libyan Arab Jamahiriya","LY");
INSERT INTO countries VALUES("124","Liechtenstein","LI");
INSERT INTO countries VALUES("125","Lithuania","LT");
INSERT INTO countries VALUES("126","Luxembourg","LU");
INSERT INTO countries VALUES("127","Macau","MO");
INSERT INTO countries VALUES("128","Macedonia","MK");
INSERT INTO countries VALUES("129","Madagascar","MG");
INSERT INTO countries VALUES("130","Malawi","MW");
INSERT INTO countries VALUES("131","Malaysia","MY");
INSERT INTO countries VALUES("132","Maldives","MV");
INSERT INTO countries VALUES("133","Mali","ML");
INSERT INTO countries VALUES("134","Malta","MT");
INSERT INTO countries VALUES("135","Marshall Islands","MH");
INSERT INTO countries VALUES("136","Martinique","MQ");
INSERT INTO countries VALUES("137","Mauritania","MR");
INSERT INTO countries VALUES("138","Mauritius","MU");
INSERT INTO countries VALUES("139","Mayotte","TY");
INSERT INTO countries VALUES("140","Mexico","MX");
INSERT INTO countries VALUES("141","Micronesia, Federated States of","FM");
INSERT INTO countries VALUES("142","Moldova, Republic of","MD");
INSERT INTO countries VALUES("143","Monaco","MC");
INSERT INTO countries VALUES("144","Mongolia","MN");
INSERT INTO countries VALUES("145","Montserrat","MS");
INSERT INTO countries VALUES("146","Morocco","MA");
INSERT INTO countries VALUES("147","Mozambique","MZ");
INSERT INTO countries VALUES("148","Myanmar","MM");
INSERT INTO countries VALUES("149","Namibia","NA");
INSERT INTO countries VALUES("150","Nauru","NR");
INSERT INTO countries VALUES("151","Nepal","NP");
INSERT INTO countries VALUES("152","Netherlands","NL");
INSERT INTO countries VALUES("153","Netherlands Antilles","AN");
INSERT INTO countries VALUES("154","New Caledonia","NC");
INSERT INTO countries VALUES("155","New Zealand","NZ");
INSERT INTO countries VALUES("156","Nicaragua","NI");
INSERT INTO countries VALUES("157","Niger","NE");
INSERT INTO countries VALUES("158","Nigeria","NG");
INSERT INTO countries VALUES("159","Niue","NU");
INSERT INTO countries VALUES("160","Norfork Island","NF");
INSERT INTO countries VALUES("161","Northern Mariana Islands","MP");
INSERT INTO countries VALUES("162","Norway","NO");
INSERT INTO countries VALUES("163","Oman","OM");
INSERT INTO countries VALUES("164","Pakistan","PK");
INSERT INTO countries VALUES("165","Palau","PW");
INSERT INTO countries VALUES("166","Panama","PA");
INSERT INTO countries VALUES("167","Papua New Guinea","PG");
INSERT INTO countries VALUES("168","Paraguay","PY");
INSERT INTO countries VALUES("169","Peru","PE");
INSERT INTO countries VALUES("170","Philippines","PH");
INSERT INTO countries VALUES("171","Pitcairn","PN");
INSERT INTO countries VALUES("172","Poland","PL");
INSERT INTO countries VALUES("173","Portugal","PT");
INSERT INTO countries VALUES("174","Puerto Rico","PR");
INSERT INTO countries VALUES("175","Qatar","QA");
INSERT INTO countries VALUES("176","Republic of South Sudan","SS");
INSERT INTO countries VALUES("177","Reunion","RE");
INSERT INTO countries VALUES("178","Romania","RO");
INSERT INTO countries VALUES("179","Russian Federation","RU");
INSERT INTO countries VALUES("180","Rwanda","RW");
INSERT INTO countries VALUES("181","Saint Kitts and Nevis","KN");
INSERT INTO countries VALUES("182","Saint Lucia","LC");
INSERT INTO countries VALUES("183","Saint Vincent and the Grenadines","VC");
INSERT INTO countries VALUES("184","Samoa","WS");
INSERT INTO countries VALUES("185","San Marino","SM");
INSERT INTO countries VALUES("186","Sao Tome and Principe","ST");
INSERT INTO countries VALUES("187","Saudi Arabia","SA");
INSERT INTO countries VALUES("188","Senegal","SN");
INSERT INTO countries VALUES("189","Serbia","RS");
INSERT INTO countries VALUES("190","Seychelles","SC");
INSERT INTO countries VALUES("191","Sierra Leone","SL");
INSERT INTO countries VALUES("192","Singapore","SG");
INSERT INTO countries VALUES("193","Slovakia","SK");
INSERT INTO countries VALUES("194","Slovenia","SI");
INSERT INTO countries VALUES("195","Solomon Islands","SB");
INSERT INTO countries VALUES("196","Somalia","SO");
INSERT INTO countries VALUES("197","South Africa","ZA");
INSERT INTO countries VALUES("198","South Georgia South Sandwich Islands","GS");
INSERT INTO countries VALUES("199","Spain","ES");
INSERT INTO countries VALUES("200","Sri Lanka","LK");
INSERT INTO countries VALUES("201","St. Helena","SH");
INSERT INTO countries VALUES("202","St. Pierre and Miquelon","PM");
INSERT INTO countries VALUES("203","Sudan","SD");
INSERT INTO countries VALUES("204","Suriname","SR");
INSERT INTO countries VALUES("205","Svalbarn and Jan Mayen Islands","SJ");
INSERT INTO countries VALUES("206","Swaziland","SZ");
INSERT INTO countries VALUES("207","Sweden","SE");
INSERT INTO countries VALUES("208","Switzerland","CH");
INSERT INTO countries VALUES("209","Syrian Arab Republic","SY");
INSERT INTO countries VALUES("210","Taiwan","TW");
INSERT INTO countries VALUES("211","Tajikistan","TJ");
INSERT INTO countries VALUES("212","Tanzania, United Republic of","TZ");
INSERT INTO countries VALUES("213","Thailand","TH");
INSERT INTO countries VALUES("214","Togo","TG");
INSERT INTO countries VALUES("215","Tokelau","TK");
INSERT INTO countries VALUES("216","Tonga","TO");
INSERT INTO countries VALUES("217","Trinidad and Tobago","TT");
INSERT INTO countries VALUES("218","Tunisia","TN");
INSERT INTO countries VALUES("219","Turkey","TR");
INSERT INTO countries VALUES("220","Turkmenistan","TM");
INSERT INTO countries VALUES("221","Turks and Caicos Islands","TC");
INSERT INTO countries VALUES("222","Tuvalu","TV");
INSERT INTO countries VALUES("223","Uganda","UG");
INSERT INTO countries VALUES("224","Ukraine","UA");
INSERT INTO countries VALUES("225","United Arab Emirates","AE");
INSERT INTO countries VALUES("226","United Kingdom","GB");
INSERT INTO countries VALUES("227","United States minor outlying islands","UM");
INSERT INTO countries VALUES("228","Uruguay","UY");
INSERT INTO countries VALUES("229","Uzbekistan","UZ");
INSERT INTO countries VALUES("230","Vanuatu","VU");
INSERT INTO countries VALUES("231","Vatican City State","VA");
INSERT INTO countries VALUES("232","Venezuela","VE");
INSERT INTO countries VALUES("233","Vietnam","VN");
INSERT INTO countries VALUES("234","Virgin Islands (British)","VG");
INSERT INTO countries VALUES("235","Virgin Islands (U.S.)","VI");
INSERT INTO countries VALUES("236","Wallis and Futuna Islands","WF");
INSERT INTO countries VALUES("237","Western Sahara","EH");
INSERT INTO countries VALUES("238","Yemen","YE");
INSERT INTO countries VALUES("239","Yugoslavia","YU");
INSERT INTO countries VALUES("240","Zaire","ZR");
INSERT INTO countries VALUES("241","Zambia","ZM");
INSERT INTO countries VALUES("242","Zimbabwe","ZW");





CREATE TABLE IF NOT EXISTS `currency` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `symbol` char(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO currency VALUES("1","USD","$");





CREATE TABLE IF NOT EXISTS `cust_branch` (
  `branch_code` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `debtor_no` int(11) NOT NULL,
  `br_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `br_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `br_contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_zip_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_country_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_zip_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_country_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`branch_code`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO cust_branch VALUES("1","1","Mary Roe","","","MARY ROE","MEGASYSTEMS INC","TUCSON","Washington","AZ","USA","MEGASYSTEMS INC","TUCSON","Washington","AZ");
INSERT INTO cust_branch VALUES("2","2","John Smith","","","JOHN SMITH","300 BOYLSTON AVE E","SEATTLE","Washington","WA","USA","300 BOYLSTON AVE E","SEATTLE","Washington","WA");
INSERT INTO cust_branch VALUES("3","3","Kyla Olsen","","","Kyla Olsen","Ap #651-8679 Sodales Av","Tamuning","Tamuning","PA","TZ","Ap #651-8679 Sodales Av","Tamuning","Tamuning","PA");
INSERT INTO cust_branch VALUES("4","4","Cecilia Chapman","","","Cecilia Chapman","711-2880 Nulla St","Mankato","Mississippi","US","US","711-2880 Nulla St","Mankato","Mississippi","US");
INSERT INTO cust_branch VALUES("5","5","Iris Watson","","","Iris Watson","Fusce Rd","Frederick","Nebraska","GB","GB","Fusce Rd","Frederick","Nebraska","GB");





CREATE TABLE IF NOT EXISTS `custom_item_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` int(11) NOT NULL,
  `tax_type_id` tinyint(4) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` double NOT NULL,
  `unit_price` double NOT NULL,
  `discount_percent` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE IF NOT EXISTS `debtors_master` (
  `debtor_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sales_type` int(11) NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`debtor_no`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO debtors_master VALUES("1","Mary Roe","maryroe@gmail.com","","","(257) 563-7401","0","","0","","");
INSERT INTO debtors_master VALUES("2","John Smith","customer@techvill.net","$2y$10$NFl9z/cbBkX8q41bIkZbm.32OT/Ogp2fYKIZXifzgm2M6n1oG5/0C","","(372) 587-2335","0","","0","","");
INSERT INTO debtors_master VALUES("3","Kyla Olsen","kyla.olsen@gmail.com","","","(654) 393-5734","0","","0","","");
INSERT INTO debtors_master VALUES("4","Cecilia Chapman","cecilia@gmail.com","","","(257) 563-7401","0","","0","","");
INSERT INTO debtors_master VALUES("5","Iris Watson","iris@yahoo.com","$2y$10$GwzEH2DV/98Fmt1s8bkk7.qWJsYZo9tW36c/cG/o9g/lGkrEp8fCC","","(372) 587-2335","0","","0","","");





CREATE TABLE IF NOT EXISTS `email_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email_protocol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_encryption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_port` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO email_config VALUES("1","smtp","tls","smtp.gmail.com","587","stockpile.techvill@gmail.com","stockpile.techvill@gmail.com","xgldhlpedszmglvj","stockpile.techvill@gmail.com","stockpile.techvill@gmail.com");





CREATE TABLE IF NOT EXISTS `email_temp_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `temp_id` tinyint(4) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `lang_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO email_temp_details VALUES("1","2","Your Quotation # {order_reference_no} from {company_name} has been shipped","Hi {customer_name},<br><br>Thank you for your Quotation. Here’s a brief overview of your shipment:<br>Quotation # {order_reference_no} was packed on {packed_date} and shipped on {delivery_date}.<br> <br><b>Shipping address   </b><br><br>{shipping_street}<br>{shipping_city}<br>{shipping_state}<br>{shipping_zip_code}<br>{shipping_country}<br><br><b>Item Summery</b><br>{item_information}<br> <br>If you have any questions, please feel free to reply to this email.<br><br>Regards<br>{company_name}<br><br><br>","en","1");
INSERT INTO email_temp_details VALUES("2","2","Subject","Body","ar","2");
INSERT INTO email_temp_details VALUES("3","2","Subject","Body","ch","3");
INSERT INTO email_temp_details VALUES("4","2","Subject","Body","fr","4");
INSERT INTO email_temp_details VALUES("5","2","Subject","Body","po","5");
INSERT INTO email_temp_details VALUES("6","2","Subject","Body","rs","6");
INSERT INTO email_temp_details VALUES("7","2","Subject","Body","sp","7");
INSERT INTO email_temp_details VALUES("8","2","Subject","Body","tu","8");
INSERT INTO email_temp_details VALUES("9","1","Payment information for Quotation#{order_reference_no} and Invoice#{invoice_reference_no}.","<p>Hi {customer_name},</p><p>Thank you for purchase our product and pay for this.</p><p>We just want to confirm a few details about payment information:</p><p><b>Customer Information</b></p><p>{billing_street}</p><p>{billing_city}</p><p>{billing_state}</p><p>{billing_zip_code}</p><p>{billing_country}<br></p><p><b>Payment Summary<br></b></p><p><b></b><i>Payment No : {payment_id}</i></p><p><i>Payment Date : {payment_date}&nbsp;</i></p><p><i>Payment Method : {payment_method} <br></i></p><p><i><b>Total Amount : {total_amount}</b></i></p><p><i>Quotation No : {order_reference_no}</i><br><i></i></p><p><i>Invoice No : {invoice_reference_no}</i><br></p><p><br></p><p>Regards,</p><p>{company_name}<br></p><br><br><br><br><br><br>","en","1");
INSERT INTO email_temp_details VALUES("10","1","Subject","Body","ar","2");
INSERT INTO email_temp_details VALUES("11","1","Subject","Body","ch","3");
INSERT INTO email_temp_details VALUES("12","1","Subject","Body","fr","4");
INSERT INTO email_temp_details VALUES("13","1","Subject","Body","po","5");
INSERT INTO email_temp_details VALUES("14","1","Subject","Body","rs","6");
INSERT INTO email_temp_details VALUES("15","1","Subject","Body","sp","7");
INSERT INTO email_temp_details VALUES("16","1","Subject","Body","tu","8");
INSERT INTO email_temp_details VALUES("17","3","Payment information for Quotation#{order_reference_no} and Invoice#{invoice_reference_no}.","<p>Hi {customer_name},</p><p>Thank you for purchase our product and pay for this.</p><p>We just want to confirm a few details about payment information:</p><p><b>Customer Information</b></p><p>{billing_street}</p><p>{billing_city}</p><p>{billing_state}</p><p>{billing_zip_code}<br></p><p>{billing_country}<br>&nbsp; &nbsp; &nbsp; &nbsp; <br></p><p><b>Payment Summary<br></b></p><p><b></b><i>Payment No : {payment_id}</i></p><p><i>Payment Date : {payment_date}&nbsp;</i></p><p><i>Payment Method : {payment_method} <br></i></p><p><i><b>Total Amount : {total_amount}</b><br>Quotation No : {order_reference_no}<br>&nbsp;</i><i>Invoice No : {invoice_reference_no}<br>&nbsp;</i>Regards,</p><p>{company_name} <br></p><br>","en","1");
INSERT INTO email_temp_details VALUES("18","3","Subject","Body","ar","2");
INSERT INTO email_temp_details VALUES("19","3","Subject","Body","ch","3");
INSERT INTO email_temp_details VALUES("20","3","Subject","Body","fr","4");
INSERT INTO email_temp_details VALUES("21","3","Subject","Body","po","5");
INSERT INTO email_temp_details VALUES("22","3","Subject","Body","rs","6");
INSERT INTO email_temp_details VALUES("23","3","Subject","Body","sp","7");
INSERT INTO email_temp_details VALUES("24","3","Subject","Body","tu","8");
INSERT INTO email_temp_details VALUES("25","4","Your Invoice # {invoice_reference_no} for Quotation #{order_reference_no} from {company_name} has been created.","<p>Hi {customer_name},</p><p>Thank you for your order. Here’s a brief overview of your invoice: Invoice #{invoice_reference_no} is for Quotation #{order_reference_no}. The invoice total is {currency}{total_amount}, please pay before {due_date}.</p><p>If you have any questions, please feel free to reply to this email. </p><p><b>Billing address</b></p><p>&nbsp;{billing_street}</p><p>&nbsp;{billing_city}</p><p>&nbsp;{billing_state}</p><p>&nbsp;{billing_zip_code}</p><p>&nbsp;{billing_country}<br></p><p><br></p><p><b>Quotation summary<br></b></p><p><b></b>{invoice_summery}<br></p><p>Regards,</p><p>{company_name}<br></p><br><br>","en","1");
INSERT INTO email_temp_details VALUES("26","4","Subject","Body","ar","2");
INSERT INTO email_temp_details VALUES("27","4","Subject","Body","ch","3");
INSERT INTO email_temp_details VALUES("28","4","Subject","Body","fr","4");
INSERT INTO email_temp_details VALUES("29","4","Subject","Body","po","5");
INSERT INTO email_temp_details VALUES("30","4","Subject","Body","rs","6");
INSERT INTO email_temp_details VALUES("31","4","Subject","Body","sp","7");
INSERT INTO email_temp_details VALUES("32","4","Subject","Body","tu","8");
INSERT INTO email_temp_details VALUES("33","5","Your Quotation # {order_reference_no} from {company_name} has been created.","<p>Hi {customer_name},</p><p>Thank you for your order. Here’s a brief overview of your Quotation #{order_reference_no} that was created on {order_date}. The order total is {currency}{total_amount}.</p><p>If you have any questions, please feel free to reply to this email. </p><p><b>Billing address</b></p><p>&nbsp;{billing_street}</p><p>&nbsp;{billing_city}</p><p>&nbsp;{billing_state}</p><p>&nbsp;{billing_zip_code}</p><p>&nbsp;{billing_country}<br></p><p><br></p><p><b>Quotation summary<br></b></p><p><b></b>{order_summery}<br></p><p>Regards,</p><p>{company_name}</p><br><br>","en","1");
INSERT INTO email_temp_details VALUES("34","5","Subject","Body","ar","2");
INSERT INTO email_temp_details VALUES("35","5","Subject","Body","ch","3");
INSERT INTO email_temp_details VALUES("36","5","Subject","Body","fr","4");
INSERT INTO email_temp_details VALUES("37","5","Subject","Body","po","5");
INSERT INTO email_temp_details VALUES("38","5","Subject","Body","rs","6");
INSERT INTO email_temp_details VALUES("39","5","Subject","Body","sp","7");
INSERT INTO email_temp_details VALUES("40","5","Subject","Body","tu","8");
INSERT INTO email_temp_details VALUES("41","6","Your Quotation # {order_reference_no} from {company_name} has been packed","Hi {customer_name},<br><br>Thank you for your order. Here’s a brief overview of your shipment:<br>Quotation # {order_reference_no} was packed on {packed_date}.<br> <br><b>Shipping address   </b><br><br>{shipping_street}<br>{shipping_city}<br>{shipping_state}<br>{shipping_zip_code}<br>{shipping_country}<br><br><b>Item Summery</b><br>{item_information}<br> <br>If you have any questions, please feel free to reply to this email.<br><br>Regards<br>{company_name}<br><br><br>","en","1");
INSERT INTO email_temp_details VALUES("42","6","Subject","Body","ar","2");
INSERT INTO email_temp_details VALUES("43","6","Subject","Body","ch","3");
INSERT INTO email_temp_details VALUES("44","6","Subject","Body","fr","4");
INSERT INTO email_temp_details VALUES("45","6","Subject","Body","po","5");
INSERT INTO email_temp_details VALUES("46","6","Subject","Body","rs","6");
INSERT INTO email_temp_details VALUES("47","6","Subject","Body","sp","7");
INSERT INTO email_temp_details VALUES("48","6","Subject","Body","tu","8");





CREATE TABLE IF NOT EXISTS `income_expense_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO income_expense_categories VALUES("1","Sales","income");
INSERT INTO income_expense_categories VALUES("2","Sallery","income");
INSERT INTO income_expense_categories VALUES("3","Utility Bill","expense");
INSERT INTO income_expense_categories VALUES("4","Repair & MaintEnance","expense");





CREATE TABLE IF NOT EXISTS `invoice_payment_terms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `terms` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `days_before_due` tinyint(4) NOT NULL,
  `defaults` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO invoice_payment_terms VALUES("1","Cash on deleivery","0","1");
INSERT INTO invoice_payment_terms VALUES("2","Net15","15","0");
INSERT INTO invoice_payment_terms VALUES("3","Net30","30","0");





CREATE TABLE IF NOT EXISTS `item_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` tinyint(4) NOT NULL,
  `item_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO item_code VALUES("1","APPLE","Iphone 7+","1","iphone.jpg","0","0","","");
INSERT INTO item_code VALUES("2","HP","HP Pro Book","1","hpprobook.jpg","0","0","","");
INSERT INTO item_code VALUES("3","LENEVO","LED TV","1","ledtv.jpg","0","0","","");
INSERT INTO item_code VALUES("4","LG","LG Refrigeretor","1","lgrefrigeretor.jpg","0","0","","");
INSERT INTO item_code VALUES("5","SAMSUNG","Samsung G7","1","samsung-galaxy7.jpg","0","0","","");
INSERT INTO item_code VALUES("6","SINGER","Singer Refrigerator","1","singer-refrideretor.jpg","0","0","","");
INSERT INTO item_code VALUES("7","SONY","Sony experia 5","1","sony-xperia5.jpg","0","0","","");
INSERT INTO item_code VALUES("8","WALTON","Walton Primo GH","1","walton-primo.jpg","0","0","","");





CREATE TABLE IF NOT EXISTS `item_tax_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tax_rate` double(8,2) NOT NULL,
  `defaults` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO item_tax_types VALUES("1","Tax Exempt","0.00","0");
INSERT INTO item_tax_types VALUES("2","Sales Tax","15.00","1");
INSERT INTO item_tax_types VALUES("3","Purchases Tax","15.00","0");
INSERT INTO item_tax_types VALUES("4","Normal","5.00","0");





CREATE TABLE IF NOT EXISTS `item_unit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `abbr` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO item_unit VALUES("1","each","Each","0","","");





CREATE TABLE IF NOT EXISTS `location` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `loc_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `location_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_address` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO location VALUES("1","PL","Primary Location","Primary Location","","","","Primary Location","0","2017-05-30 05:45:26","");
INSERT INTO location VALUES("2","JA","Jackson Av","125 Hayes St, San Francisco, CA 94102, USA","","","","Jackson Av","0","2017-05-30 05:45:26","");





CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO migrations VALUES("2014_10_12_100000_create_password_resets_table","1");
INSERT INTO migrations VALUES("2016_08_30_100832_create_users_table","1");
INSERT INTO migrations VALUES("2016_08_30_104058_create_security_role_table","1");
INSERT INTO migrations VALUES("2016_08_30_104506_create_stock_category_table","1");
INSERT INTO migrations VALUES("2016_08_30_105339_create_location_table","1");
INSERT INTO migrations VALUES("2016_08_30_110408_create_item_code_table","1");
INSERT INTO migrations VALUES("2016_08_30_114231_create_item_unit_table","1");
INSERT INTO migrations VALUES("2016_09_02_070031_create_stock_master_table","1");
INSERT INTO migrations VALUES("2016_09_20_123717_create_stock_move_table","1");
INSERT INTO migrations VALUES("2016_10_05_113244_create_debtor_master_table","1");
INSERT INTO migrations VALUES("2016_10_05_113333_create_sales_orders_table","1");
INSERT INTO migrations VALUES("2016_10_05_113356_create_sales_order_details_table","1");
INSERT INTO migrations VALUES("2016_10_18_060431_create_supplier_table","1");
INSERT INTO migrations VALUES("2016_10_18_063931_create_purch_order_table","1");
INSERT INTO migrations VALUES("2016_10_18_064211_create_purch_order_detail_table","1");
INSERT INTO migrations VALUES("2016_11_15_121343_create_preference_table","1");
INSERT INTO migrations VALUES("2016_12_01_130110_create_shipment_table","1");
INSERT INTO migrations VALUES("2016_12_01_130443_create_shipment_details_table","1");
INSERT INTO migrations VALUES("2016_12_03_051429_create_sale_price_table","1");
INSERT INTO migrations VALUES("2016_12_03_052017_create_sales_types_table","1");
INSERT INTO migrations VALUES("2016_12_03_061206_create_purchase_price_table","1");
INSERT INTO migrations VALUES("2016_12_03_062131_create_payment_term_table","1");
INSERT INTO migrations VALUES("2016_12_03_062247_create_payment_history_table","1");
INSERT INTO migrations VALUES("2016_12_03_062932_create_item_tax_type_table","1");
INSERT INTO migrations VALUES("2016_12_03_063827_create_invoice_payment_term_table","1");
INSERT INTO migrations VALUES("2016_12_03_064157_create_email_temp_details_table","1");
INSERT INTO migrations VALUES("2016_12_03_064747_create_email_config_table","1");
INSERT INTO migrations VALUES("2016_12_03_065532_create_cust_branch_table","1");
INSERT INTO migrations VALUES("2016_12_03_065915_create_currency_table","1");
INSERT INTO migrations VALUES("2016_12_03_070030_create_country_table","1");
INSERT INTO migrations VALUES("2016_12_03_070030_create_stock_transfer_table","1");
INSERT INTO migrations VALUES("2016_12_03_071018_create_backup_table","1");
INSERT INTO migrations VALUES("2017_03_20_104506_create_bank_account_type_table","1");
INSERT INTO migrations VALUES("2017_03_20_104506_create_bank_accounts_table","1");
INSERT INTO migrations VALUES("2017_03_20_104506_create_bank_trans_table","1");
INSERT INTO migrations VALUES("2017_03_20_104506_create_custom_item_orders_table","1");
INSERT INTO migrations VALUES("2017_03_20_104506_create_income_expense_categories_table","1");
INSERT INTO migrations VALUES("2017_03_20_104506_create_month_table","1");
INSERT INTO migrations VALUES("2017_04_10_062131_create_payment_gateway_table","1");





CREATE TABLE IF NOT EXISTS `months` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO months VALUES("1","January");
INSERT INTO months VALUES("2","February");
INSERT INTO months VALUES("3","March");
INSERT INTO months VALUES("4","Appril");
INSERT INTO months VALUES("5","May");
INSERT INTO months VALUES("6","June");
INSERT INTO months VALUES("7","July");
INSERT INTO months VALUES("8","August");
INSERT INTO months VALUES("9","September");
INSERT INTO months VALUES("10","October");
INSERT INTO months VALUES("11","November");
INSERT INTO months VALUES("12","December");





CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE IF NOT EXISTS `payment_gateway` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `site` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO payment_gateway VALUES("1","username","techvillage_business_api1.gmail.com","PayPal");
INSERT INTO payment_gateway VALUES("2","password","9DDYZX2JLA6QL668","PayPal");
INSERT INTO payment_gateway VALUES("3","signature","AFcWxV21C7fd0v3bYYYRCpSSRl31ABayz5pdk84jno7.Udj6-U8ffwbT","PayPal");
INSERT INTO payment_gateway VALUES("4","mode","sandbox","PayPal");





CREATE TABLE IF NOT EXISTS `payment_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `payment_type_id` smallint(6) NOT NULL,
  `order_reference` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_reference` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `payment_date` date NOT NULL,
  `amount` double DEFAULT '0',
  `person_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO payment_history VALUES("1","17","1","SO-0004","INV-0002","2017-05-30","615","1","2","","completed","2017-05-30 05:45:26","");
INSERT INTO payment_history VALUES("2","18","1","SO-0001","INV-0003","2017-05-25","500","1","1","","completed","2017-05-25 05:45:26","");





CREATE TABLE IF NOT EXISTS `payment_terms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `defaults` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO payment_terms VALUES("1","Paypal","0");
INSERT INTO payment_terms VALUES("2","Bank","1");





CREATE TABLE IF NOT EXISTS `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO permission_role VALUES("1","1");
INSERT INTO permission_role VALUES("1","2");
INSERT INTO permission_role VALUES("2","1");
INSERT INTO permission_role VALUES("2","2");
INSERT INTO permission_role VALUES("3","1");
INSERT INTO permission_role VALUES("3","2");
INSERT INTO permission_role VALUES("4","1");
INSERT INTO permission_role VALUES("4","2");
INSERT INTO permission_role VALUES("5","1");
INSERT INTO permission_role VALUES("6","1");
INSERT INTO permission_role VALUES("7","1");
INSERT INTO permission_role VALUES("8","1");
INSERT INTO permission_role VALUES("9","1");
INSERT INTO permission_role VALUES("10","1");
INSERT INTO permission_role VALUES("11","1");
INSERT INTO permission_role VALUES("12","1");
INSERT INTO permission_role VALUES("13","1");
INSERT INTO permission_role VALUES("14","1");
INSERT INTO permission_role VALUES("15","1");
INSERT INTO permission_role VALUES("16","1");
INSERT INTO permission_role VALUES("17","1");
INSERT INTO permission_role VALUES("18","1");
INSERT INTO permission_role VALUES("19","1");
INSERT INTO permission_role VALUES("20","1");
INSERT INTO permission_role VALUES("21","1");
INSERT INTO permission_role VALUES("22","1");
INSERT INTO permission_role VALUES("23","1");
INSERT INTO permission_role VALUES("24","1");
INSERT INTO permission_role VALUES("25","1");
INSERT INTO permission_role VALUES("26","1");
INSERT INTO permission_role VALUES("27","1");
INSERT INTO permission_role VALUES("28","1");
INSERT INTO permission_role VALUES("29","1");
INSERT INTO permission_role VALUES("30","1");
INSERT INTO permission_role VALUES("31","1");
INSERT INTO permission_role VALUES("32","1");
INSERT INTO permission_role VALUES("33","1");
INSERT INTO permission_role VALUES("34","1");
INSERT INTO permission_role VALUES("35","1");
INSERT INTO permission_role VALUES("36","1");
INSERT INTO permission_role VALUES("37","1");
INSERT INTO permission_role VALUES("38","1");
INSERT INTO permission_role VALUES("39","1");
INSERT INTO permission_role VALUES("40","1");
INSERT INTO permission_role VALUES("41","1");
INSERT INTO permission_role VALUES("42","1");
INSERT INTO permission_role VALUES("43","1");
INSERT INTO permission_role VALUES("44","1");
INSERT INTO permission_role VALUES("45","1");
INSERT INTO permission_role VALUES("46","1");
INSERT INTO permission_role VALUES("47","1");
INSERT INTO permission_role VALUES("48","1");
INSERT INTO permission_role VALUES("49","1");
INSERT INTO permission_role VALUES("50","1");
INSERT INTO permission_role VALUES("51","1");
INSERT INTO permission_role VALUES("52","1");
INSERT INTO permission_role VALUES("53","1");
INSERT INTO permission_role VALUES("54","1");
INSERT INTO permission_role VALUES("55","1");
INSERT INTO permission_role VALUES("56","1");
INSERT INTO permission_role VALUES("57","1");
INSERT INTO permission_role VALUES("58","1");
INSERT INTO permission_role VALUES("59","1");
INSERT INTO permission_role VALUES("60","1");
INSERT INTO permission_role VALUES("61","1");
INSERT INTO permission_role VALUES("62","1");
INSERT INTO permission_role VALUES("63","1");
INSERT INTO permission_role VALUES("64","1");
INSERT INTO permission_role VALUES("65","1");
INSERT INTO permission_role VALUES("66","1");
INSERT INTO permission_role VALUES("67","1");
INSERT INTO permission_role VALUES("68","1");
INSERT INTO permission_role VALUES("69","1");
INSERT INTO permission_role VALUES("70","1");
INSERT INTO permission_role VALUES("71","1");
INSERT INTO permission_role VALUES("72","1");
INSERT INTO permission_role VALUES("73","1");
INSERT INTO permission_role VALUES("74","1");
INSERT INTO permission_role VALUES("75","1");
INSERT INTO permission_role VALUES("76","1");
INSERT INTO permission_role VALUES("77","1");
INSERT INTO permission_role VALUES("78","1");
INSERT INTO permission_role VALUES("79","1");
INSERT INTO permission_role VALUES("80","1");
INSERT INTO permission_role VALUES("81","1");
INSERT INTO permission_role VALUES("82","1");
INSERT INTO permission_role VALUES("83","1");
INSERT INTO permission_role VALUES("84","1");
INSERT INTO permission_role VALUES("85","1");
INSERT INTO permission_role VALUES("86","1");
INSERT INTO permission_role VALUES("87","1");
INSERT INTO permission_role VALUES("88","1");
INSERT INTO permission_role VALUES("89","1");
INSERT INTO permission_role VALUES("90","1");
INSERT INTO permission_role VALUES("91","1");
INSERT INTO permission_role VALUES("92","1");
INSERT INTO permission_role VALUES("93","1");
INSERT INTO permission_role VALUES("94","1");
INSERT INTO permission_role VALUES("95","1");
INSERT INTO permission_role VALUES("96","1");
INSERT INTO permission_role VALUES("97","1");
INSERT INTO permission_role VALUES("98","1");
INSERT INTO permission_role VALUES("99","1");
INSERT INTO permission_role VALUES("100","1");
INSERT INTO permission_role VALUES("101","1");
INSERT INTO permission_role VALUES("102","1");
INSERT INTO permission_role VALUES("103","1");
INSERT INTO permission_role VALUES("104","1");
INSERT INTO permission_role VALUES("105","1");
INSERT INTO permission_role VALUES("106","1");
INSERT INTO permission_role VALUES("107","1");
INSERT INTO permission_role VALUES("108","1");
INSERT INTO permission_role VALUES("109","1");
INSERT INTO permission_role VALUES("110","1");
INSERT INTO permission_role VALUES("111","1");
INSERT INTO permission_role VALUES("112","1");
INSERT INTO permission_role VALUES("113","1");





CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=114 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO permissions VALUES("1","manage_relationship","Manage Relationship","Manage Relationship","","");
INSERT INTO permissions VALUES("2","manage_customer","Manage Customers","Manage Customers","","");
INSERT INTO permissions VALUES("3","add_customer","Add Customer","Add Customer","","");
INSERT INTO permissions VALUES("4","edit_customer","Edit Customer","Edit Customer","","");
INSERT INTO permissions VALUES("5","delete_customer","Delete Customer","Delete Customer","","");
INSERT INTO permissions VALUES("6","manage_supplier","Manage Suppliers","Manage Suppliers","","");
INSERT INTO permissions VALUES("7","add_supplier","Add Supplier","Add Supplier","","");
INSERT INTO permissions VALUES("8","edit_supplier","Edit Supplier","Edit Supplier","","");
INSERT INTO permissions VALUES("9","delete_supplier","Delete Supplier","Delete Supplier","","");
INSERT INTO permissions VALUES("10","manage_item","Manage Items","Manage Items","","");
INSERT INTO permissions VALUES("11","add_item","Add Item","Add Item","","");
INSERT INTO permissions VALUES("12","edit_item","Edit Item","Edit Item","","");
INSERT INTO permissions VALUES("13","delete_item","Delete Item","Delete Item","","");
INSERT INTO permissions VALUES("14","manage_sale","Manage Sales","Manage Sales","","");
INSERT INTO permissions VALUES("15","manage_quotation","Manage Quotations","Manage Quotations","","");
INSERT INTO permissions VALUES("16","add_quotation","Add Quotation","Add Quotation","","");
INSERT INTO permissions VALUES("17","edit_quotation","Edit Quotation","Edit Quotation","","");
INSERT INTO permissions VALUES("18","delete_quotation","Delete Quotation","Delete Quotation","","");
INSERT INTO permissions VALUES("19","manage_invoice","Manage Invoices","Manage Invoices","","");
INSERT INTO permissions VALUES("20","add_invoice","Add Invoice","Add Invoice","","");
INSERT INTO permissions VALUES("21","edit_invoice","Edit Invoice","Edit Invoice","","");
INSERT INTO permissions VALUES("22","delete_invoice","Delete Invoice","Delete Invoice","","");
INSERT INTO permissions VALUES("23","manage_payment","Manage Payment","Manage Payment","","");
INSERT INTO permissions VALUES("24","add_payment","Add Payment","Add Payment","","");
INSERT INTO permissions VALUES("25","edit_payment","Edit Payment","Edit Payment","","");
INSERT INTO permissions VALUES("26","delete_payment","Delete Payment","Delete Payment","","");
INSERT INTO permissions VALUES("27","manage_purchase","Manage Purchase","Manage Purchase","","");
INSERT INTO permissions VALUES("28","add_purchase","Add Purchase","Add Purchase","","");
INSERT INTO permissions VALUES("29","edit_purchase","Edit Purchase","Edit Purchase","","");
INSERT INTO permissions VALUES("30","delete_purchase","Delete Purchase","Delete Purchase","","");
INSERT INTO permissions VALUES("31","manage_banking_transaction","Manage Banking & Transactions","Manage Banking & Transactions","","");
INSERT INTO permissions VALUES("32","manage_bank_account","Manage Bank Accounts","Manage Bank Accounts","","");
INSERT INTO permissions VALUES("33","add_bank_account","Add Bank Account","Add Bank Account","","");
INSERT INTO permissions VALUES("34","edit_bank_account","Edit Bank Account","Edit Bank Account","","");
INSERT INTO permissions VALUES("35","delete_bank_account","Delete Bank Account","Delete Bank Account","","");
INSERT INTO permissions VALUES("36","manage_deposit","Manage Deposit","Manage Deposit","","");
INSERT INTO permissions VALUES("37","add_deposit","Add Deposit","Add Deposit","","");
INSERT INTO permissions VALUES("38","edit_deposit","Edit Deposit","Edit Deposit","","");
INSERT INTO permissions VALUES("39","delete_deposit","Delete Deposit","Delete Deposit","","");
INSERT INTO permissions VALUES("40","manage_balance_transfer","Manage Balance Transfer","Manage Balance Transfer","","");
INSERT INTO permissions VALUES("41","add_balance_transfer","Add Balance Transfer","Add Balance Transfer","","");
INSERT INTO permissions VALUES("42","edit_balance_transfer","Edit Balance Transfer","Edit Balance Transfer","","");
INSERT INTO permissions VALUES("43","delete_balance_transfer","Delete Balance Transfer","Delete Balance Transfer","","");
INSERT INTO permissions VALUES("44","manage_transaction","Manage Transactions","Manage Transactions","","");
INSERT INTO permissions VALUES("45","manage_expense","Manage Expense","Manage Expense","","");
INSERT INTO permissions VALUES("46","add_expense","Add Expense","Add Expense","","");
INSERT INTO permissions VALUES("47","edit_expense","Edit Expense","Edit Expense","","");
INSERT INTO permissions VALUES("48","delete_expense","Delete Expense","Delete Expense","","");
INSERT INTO permissions VALUES("49","manage_report","Manage Report","Manage Report","","");
INSERT INTO permissions VALUES("50","manage_stock_on_hand","Manage Inventory Stock On Hand","Manage Inventory Stock On Hand","","");
INSERT INTO permissions VALUES("51","manage_sale_report","Manage Sales Report","Manage Sales Report","","");
INSERT INTO permissions VALUES("52","manage_sale_history_report","Manage Sales History Report","Manage Sales History Report","","");
INSERT INTO permissions VALUES("53","manage_purchase_report","Manage Purchase Report","Manage Purchase Report","","");
INSERT INTO permissions VALUES("54","manage_team_report","Manage Team Member Report","Manage Team Member Report","","");
INSERT INTO permissions VALUES("55","manage_expense_report","Manage Expense Report","Manage Expense Report","","");
INSERT INTO permissions VALUES("56","manage_income_report","Manage Income Report","Manage Income Report","","");
INSERT INTO permissions VALUES("57","manage_income_vs_expense","Manage Income vs Expense","Manage Income vs Expense","","");
INSERT INTO permissions VALUES("58","manage_setting","Manage Settings","Manage Settings","","");
INSERT INTO permissions VALUES("59","manage_company_setting","Manage Company Setting","Manage Company Setting","","");
INSERT INTO permissions VALUES("60","manage_team_member","Manage Team Member","Manage Team Member","","");
INSERT INTO permissions VALUES("61","add_team_member","Add Team Member","Add Team Member","","");
INSERT INTO permissions VALUES("62","edit_team_member","Edit Team Member","Edit Team Member","","");
INSERT INTO permissions VALUES("63","delete_team_member","Delete Team Member","Delete Team Member","","");
INSERT INTO permissions VALUES("64","manage_role","Manage Roles","Manage Roles","","");
INSERT INTO permissions VALUES("65","add_role","Add Role","Add Role","","");
INSERT INTO permissions VALUES("66","edit_role","Edit Role","Edit Role","","");
INSERT INTO permissions VALUES("67","delete_role","Delete Role","Delete Role","","");
INSERT INTO permissions VALUES("68","manage_location","Manage Location","Manage Location","","");
INSERT INTO permissions VALUES("69","add_location","Add Location","Add Location","","");
INSERT INTO permissions VALUES("70","edit_location","Edit Location","Edit Location","","");
INSERT INTO permissions VALUES("71","delete_location","Delete Location","Delete Location","","");
INSERT INTO permissions VALUES("72","manage_general_setting","Manage General Settings","Manage General Settings","","");
INSERT INTO permissions VALUES("73","manage_item_category","Manage Item Category","Manage Item Category","","");
INSERT INTO permissions VALUES("74","add_item_category","Add Item Category","Add Item Category","","");
INSERT INTO permissions VALUES("75","edit_item_category","Edit Item Category","Edit Item Category","","");
INSERT INTO permissions VALUES("76","delete_item_category","Delete Item Category","Delete Item Category","","");
INSERT INTO permissions VALUES("77","manage_income_expense_category","Manage Income Expense Category","Manage Income Expense Category","","");
INSERT INTO permissions VALUES("78","add_income_expense_category","Add Income Expense Category","Add Income Expense Category","","");
INSERT INTO permissions VALUES("79","edit_income_expense_category","Edit Income Expense Category","Edit Income Expense Category","","");
INSERT INTO permissions VALUES("80","delete_income_expense_category","Delete Income Expense Category","Delete Income Expense Category","","");
INSERT INTO permissions VALUES("81","manage_unit","Manage Unit","Manage Unit","","");
INSERT INTO permissions VALUES("82","add_unit","Add Unit","Add Unit","","");
INSERT INTO permissions VALUES("83","edit_unit","Edit Unit","Edit Unit","","");
INSERT INTO permissions VALUES("84","delete_unit","Delete Unit","Delete Unit","","");
INSERT INTO permissions VALUES("85","manage_db_backup","Manage Database Backup","Manage Database Backup","","");
INSERT INTO permissions VALUES("86","add_db_backup","Add Database Backup","Add Database Backup","","");
INSERT INTO permissions VALUES("87","delete_db_backup","Delete Database Backup","Delete Database Backup","","");
INSERT INTO permissions VALUES("88","manage_email_setup","Manage Email Setup","Manage Email Setup","","");
INSERT INTO permissions VALUES("89","manage_finance","Manage Finance","Manage Finance","","");
INSERT INTO permissions VALUES("90","manage_tax","Manage Taxs","Manage Taxs","","");
INSERT INTO permissions VALUES("91","add_tax","Add Tax","Add Tax","","");
INSERT INTO permissions VALUES("92","edit_tax","Edit Tax","Edit Tax","","");
INSERT INTO permissions VALUES("93","delete_tax","Delete Tax","Delete Tax","","");
INSERT INTO permissions VALUES("94","manage_currency","Manage Currency","Manage Currency","","");
INSERT INTO permissions VALUES("95","add_currency","Add Currency","Add Currency","","");
INSERT INTO permissions VALUES("96","edit_currency","Edit Currency","Edit Currency","","");
INSERT INTO permissions VALUES("97","delete_currency","Delete Currency","Delete Currency","","");
INSERT INTO permissions VALUES("98","manage_payment_term","Manage Payment Term","Manage Payment Term","","");
INSERT INTO permissions VALUES("99","add_payment_term","Add Payment Term","Add Payment Term","","");
INSERT INTO permissions VALUES("100","edit_payment_term","Edit Payment Term","Edit Payment Term","","");
INSERT INTO permissions VALUES("101","delete_payment_term","Delete Payment Term","Delete Payment Term","","");
INSERT INTO permissions VALUES("102","manage_payment_method","Manage Payment Method","Manage Payment Method","","");
INSERT INTO permissions VALUES("103","add_payment_method","Add Payment Method","Add Payment Method","","");
INSERT INTO permissions VALUES("104","edit_payment_method","Edit Payment Method","Edit Payment Method","","");
INSERT INTO permissions VALUES("105","delete_payment_method","Delete Payment Method","Delete Payment Method","","");
INSERT INTO permissions VALUES("106","manage_payment_gateway","Manage Payment Method","Manage Payment Gateway","","");
INSERT INTO permissions VALUES("107","manage_email_template","Manage Email Template","Manage Email Template","","");
INSERT INTO permissions VALUES("108","manage_quotation_email_template","Manage Quotation Template","Manage Quotation Email Template","","");
INSERT INTO permissions VALUES("109","manage_invoice_email_template","Manage Invoice Email Template","Manage Invoice Email Template","","");
INSERT INTO permissions VALUES("110","manage_payment_email_template","Manage Payment Email Template","Manage Payment Email Template","","");
INSERT INTO permissions VALUES("111","manage_preference","Manage Preference","Manage Preference","","");
INSERT INTO permissions VALUES("112","manage_barcode","Manage barcode/label","Manage barcode/label","","");
INSERT INTO permissions VALUES("113","download_db_backup","Download Database Backup","Download Database Backup","","");





CREATE TABLE IF NOT EXISTS `preference` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `field` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO preference VALUES("1","preference","row_per_page","25");
INSERT INTO preference VALUES("2","preference","date_format","1");
INSERT INTO preference VALUES("3","preference","date_sepa","-");
INSERT INTO preference VALUES("4","preference","soft_name","goBilling");
INSERT INTO preference VALUES("5","company","site_short_name","GB");
INSERT INTO preference VALUES("6","preference","percentage","0");
INSERT INTO preference VALUES("7","preference","quantity","0");
INSERT INTO preference VALUES("8","preference","date_format_type","dd-mm-yyyy");
INSERT INTO preference VALUES("9","company","company_name","goBilling");
INSERT INTO preference VALUES("10","company","company_email","admin@techvill.net");
INSERT INTO preference VALUES("11","company","company_phone","123465798");
INSERT INTO preference VALUES("12","company","company_street","City Hall Park Path");
INSERT INTO preference VALUES("13","company","company_city","New York");
INSERT INTO preference VALUES("14","company","company_state","New York");
INSERT INTO preference VALUES("15","company","company_zipCode","10007");
INSERT INTO preference VALUES("16","company","company_country_id","United States");
INSERT INTO preference VALUES("17","company","dflt_lang","en");
INSERT INTO preference VALUES("18","company","dflt_currency_id","1");
INSERT INTO preference VALUES("19","company","sates_type_id","1");





CREATE TABLE IF NOT EXISTS `purch_order_details` (
  `po_detail_item` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` int(11) NOT NULL,
  `item_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `qty_invoiced` double NOT NULL DEFAULT '0',
  `unit_price` double NOT NULL DEFAULT '0',
  `tax_type_id` int(11) NOT NULL,
  `quantity_ordered` double NOT NULL DEFAULT '0',
  `quantity_received` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`po_detail_item`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO purch_order_details VALUES("1","1","WALTON","Walton Primo GH","5000","50","1","5000","5000");
INSERT INTO purch_order_details VALUES("2","1","SONY","Sony experia 5","5000","50","1","5000","5000");
INSERT INTO purch_order_details VALUES("3","1","SAMSUNG","Samsung G7","5000","50","1","5000","5000");
INSERT INTO purch_order_details VALUES("4","1","LG","LG Refrigeretor","5000","50","1","5000","5000");
INSERT INTO purch_order_details VALUES("5","1","LENEVO","LED TV","5000","50","1","5000","5000");
INSERT INTO purch_order_details VALUES("6","1","APPLE","Iphone 7+","5000","100","1","5000","5000");
INSERT INTO purch_order_details VALUES("7","1","HP","HP Pro Book","5000","80","1","5000","5000");
INSERT INTO purch_order_details VALUES("8","2","APPLE","Iphone 7+","100","100","2","100","100");
INSERT INTO purch_order_details VALUES("9","3","WALTON","Walton Primo GH","3000","50","2","3000","3000");
INSERT INTO purch_order_details VALUES("10","3","SONY","Sony experia 5","3000","50","2","3000","3000");
INSERT INTO purch_order_details VALUES("11","3","SINGER","Singer Refrigerator","3000","50","2","3000","3000");
INSERT INTO purch_order_details VALUES("12","3","SAMSUNG","Samsung G7","3000","50","2","3000","3000");
INSERT INTO purch_order_details VALUES("13","3","LG","LG Refrigeretor","3000","50","2","3000","3000");
INSERT INTO purch_order_details VALUES("14","3","LENEVO","LED TV","3000","50","2","3000","3000");
INSERT INTO purch_order_details VALUES("15","3","HP","HP Pro Book","3000","80","2","3000","3000");
INSERT INTO purch_order_details VALUES("16","3","APPLE","Iphone 7+","3000","100","2","3000","3000");
INSERT INTO purch_order_details VALUES("17","4","SAMSUNG","Samsung G7","100","50","2","100","100");
INSERT INTO purch_order_details VALUES("18","5","SINGER","Singer Refrigerator","10","50","2","10","10");
INSERT INTO purch_order_details VALUES("19","6","LENEVO","LED TV","100","50","2","100","100");
INSERT INTO purch_order_details VALUES("20","7","SAMSUNG","Samsung G7","500","50","2","500","500");





CREATE TABLE IF NOT EXISTS `purch_orders` (
  `order_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `comments` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ord_date` date NOT NULL,
  `reference` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `into_stock_location` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_no`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO purch_orders VALUES("1","1","1","","2017-03-09","PO-0001","PL","2150000");
INSERT INTO purch_orders VALUES("2","2","1","","2016-09-01","PO-0002","PL","11500");
INSERT INTO purch_orders VALUES("3","4","1","","2017-04-09","PO-0003","JA","1656000");
INSERT INTO purch_orders VALUES("4","4","1","","2017-05-02","PO-0004","JA","5750");
INSERT INTO purch_orders VALUES("5","4","1","","2017-05-08","PO-0004","JA","575");
INSERT INTO purch_orders VALUES("6","1","1","","2017-05-23","PO-0006","JA","5750");
INSERT INTO purch_orders VALUES("7","3","1","","2017-05-28","PO-0007","PL","28750");





CREATE TABLE IF NOT EXISTS `purchase_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO purchase_prices VALUES("1","APPLE","100");
INSERT INTO purchase_prices VALUES("2","HP","80");
INSERT INTO purchase_prices VALUES("3","LENEVO","50");
INSERT INTO purchase_prices VALUES("4","LG","50");
INSERT INTO purchase_prices VALUES("5","SAMSUNG","50");
INSERT INTO purchase_prices VALUES("6","SINGER","50");
INSERT INTO purchase_prices VALUES("7","SONY","50");
INSERT INTO purchase_prices VALUES("8","WALTON","50");





CREATE TABLE IF NOT EXISTS `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO role_user VALUES("1","1");
INSERT INTO role_user VALUES("2","2");





CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO roles VALUES("1","Admin","Admin User","This is an admin user","","");
INSERT INTO roles VALUES("2","Member","Member user","This is a member user","","");





CREATE TABLE IF NOT EXISTS `sale_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sales_type_id` tinyint(4) NOT NULL,
  `curr_abrev` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sale_prices VALUES("1","APPLE","1","USD","160");
INSERT INTO sale_prices VALUES("2","HP","1","USD","120");
INSERT INTO sale_prices VALUES("3","LENEVO","1","USD","70");
INSERT INTO sale_prices VALUES("4","LG","1","USD","80");
INSERT INTO sale_prices VALUES("5","SAMSUNG","1","USD","90");
INSERT INTO sale_prices VALUES("6","SINGER","1","USD","80");
INSERT INTO sale_prices VALUES("7","SONY","1","USD","90");
INSERT INTO sale_prices VALUES("8","WALTON","1","USD","85");





CREATE TABLE IF NOT EXISTS `sales_order_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` int(11) NOT NULL,
  `trans_type` mediumint(9) NOT NULL,
  `stock_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `tax_type_id` tinyint(4) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit_price` double NOT NULL DEFAULT '0',
  `qty_sent` double NOT NULL DEFAULT '0',
  `quantity` double NOT NULL DEFAULT '0',
  `is_inventory` double NOT NULL,
  `discount_percent` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_order_details VALUES("1","1","201","APPLE","2","Iphone 7+","160","0","500","1","0","","");
INSERT INTO sales_order_details VALUES("2","2","201","LENEVO","2","LED TV","700","0","100","1","0","","");
INSERT INTO sales_order_details VALUES("3","3","201","WALTON","2","Walton Primo GH","90","0","10","1","0","","");
INSERT INTO sales_order_details VALUES("4","4","202","WALTON","2","Walton Primo GH","90","0","10","1","0","","");
INSERT INTO sales_order_details VALUES("5","3","201","APPLE","2","Iphone 7+","160","0","10","1","0","","");
INSERT INTO sales_order_details VALUES("6","4","202","APPLE","2","Iphone 7+","160","0","10","1","0","","");
INSERT INTO sales_order_details VALUES("7","3","201","SAMSUNG","2","Samsung G7","90","0","10","1","0","","");
INSERT INTO sales_order_details VALUES("8","4","201","SAMSUNG","2","Samsung G7","90","0","10","1","0","","");
INSERT INTO sales_order_details VALUES("9","5","201","SONY","2","Sony experia 5","90","0","50","1","0","","");
INSERT INTO sales_order_details VALUES("10","6","202","SONY","2","Sony experia 5","90","0","50","1","0","","");
INSERT INTO sales_order_details VALUES("11","5","201","LG","2","LG Refrigeretor","80","0","70","1","0","","");
INSERT INTO sales_order_details VALUES("12","6","202","LG","2","LG Refrigeretor","80","0","70","1","0","","");
INSERT INTO sales_order_details VALUES("13","7","202","APPLE","2","Iphone 7+","160","0","5000","1","0","","");
INSERT INTO sales_order_details VALUES("14","8","201","SAMSUNG","2","Samsung G7","90","0","100","1","0","","");
INSERT INTO sales_order_details VALUES("15","9","202","SAMSUNG","2","Samsung G7","90","0","100","1","0","","");
INSERT INTO sales_order_details VALUES("16","10","201","LG","2","LG Refrigeretor","80","0","100","1","0","","");
INSERT INTO sales_order_details VALUES("17","11","202","LG","2","LG Refrigeretor","80","0","1000","1","0","","");
INSERT INTO sales_order_details VALUES("18","11","202","SAMSUN","2","Samsung G7","90000","0","1000","1","0","","");
INSERT INTO sales_order_details VALUES("19","12","201","APPLE","2","Iphone 7+","50000","0","50","1","0","","");
INSERT INTO sales_order_details VALUES("20","13","202","APPLE","2","Iphone 7+","50000","0","50","1","0","","");





CREATE TABLE IF NOT EXISTS `sales_orders` (
  `order_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `trans_type` mediumint(9) NOT NULL,
  `invoice_type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `debtor_no` int(11) NOT NULL,
  `branch_id` tinyint(4) NOT NULL,
  `person_id` int(11) NOT NULL,
  `reference` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `customer_ref` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_reference_id` int(11) NOT NULL,
  `order_reference` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ord_date` date NOT NULL,
  `order_type` int(11) NOT NULL,
  `from_stk_loc` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_id` mediumint(9) NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  `paid_amount` double NOT NULL DEFAULT '0',
  `payment_term` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`order_no`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_orders VALUES("1","201","directOrder","1","1","1","SO-0001","","0","","","2017-05-30","0","PL","1","92000","0","2","2017-05-30 05:45:26","");
INSERT INTO sales_orders VALUES("2","201","directOrder","2","2","1","SO-0002","","0","","","2017-05-18","0","PL","1","80500","0","2","2017-05-18 05:45:26","");
INSERT INTO sales_orders VALUES("3","201","indirectOrder","4","4","1","SO-0003","","0","","","2017-05-13","0","PL","1","3910","0","0","2017-05-13 05:45:26","");
INSERT INTO sales_orders VALUES("4","202","directInvoice","4","4","1","INV-0001","","3","SO-0003","","2017-05-13","0","PL","1","3910","0","2","2017-05-13 05:45:26","");
INSERT INTO sales_orders VALUES("5","201","indirectOrder","2","2","1","SO-0004","","0","","","2017-05-18","0","JA","1","11615","0","0","2017-05-18 05:45:26","");
INSERT INTO sales_orders VALUES("6","202","directInvoice","2","2","1","INV-0002","","5","SO-0004","","2017-05-18","0","JA","1","11615","615","1","2017-05-18 05:45:26","");
INSERT INTO sales_orders VALUES("7","202","indirectInvoice","1","1","1","INV-0003","","1","SO-0001","","2017-05-30","0","PL","1","920000","500","2","2017-05-30 05:45:26","");
INSERT INTO sales_orders VALUES("8","201","indirectOrder","4","4","1","SO-0005","","0","","","2017-05-30","0","PL","1","10350","0","0","2017-05-30 05:45:26","");
INSERT INTO sales_orders VALUES("9","202","directInvoice","4","4","1","INV-0004","","8","SO-0005","","2017-05-30","0","PL","1","10350","0","1","2017-05-30 05:45:26","");
INSERT INTO sales_orders VALUES("10","201","indirectOrder","3","3","1","SO-0006","","0","","","2017-05-09","0","PL","1","9200","0","0","2017-05-09 05:45:26","");
INSERT INTO sales_orders VALUES("11","202","directInvoice","3","3","1","INV-0005","","10","SO-0006","","2017-05-30","0","PL","1","195500","0","1","2017-05-30 05:45:26","");
INSERT INTO sales_orders VALUES("12","201","indirectOrder","2","2","1","SO-0007","","0","","","2017-05-10","0","PL","1","2875000","0","0","2017-05-30 05:45:26","");
INSERT INTO sales_orders VALUES("13","202","directInvoice","2","2","1","INV-0006","","12","SO-0007","","2017-05-10","0","PL","1","2875000","0","0","2017-05-30 05:45:26","");





CREATE TABLE IF NOT EXISTS `sales_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sales_type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `tax_included` tinyint(4) NOT NULL,
  `factor` double NOT NULL,
  `defaults` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_types VALUES("1","Retail","1","0","1");
INSERT INTO sales_types VALUES("2","Wholesale","0","0","0");





CREATE TABLE IF NOT EXISTS `security_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sections` text COLLATE utf8_unicode_ci,
  `areas` text COLLATE utf8_unicode_ci,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO security_role VALUES("1","System Administrator","System Administrator","a:26:{s:8:\"category\";s:3:\"100\";s:4:\"unit\";s:3:\"600\";s:3:\"loc\";s:3:\"200\";s:4:\"item\";s:3:\"300\";s:4:\"user\";s:3:\"400\";s:4:\"role\";s:3:\"500\";s:8:\"customer\";s:3:\"700\";s:8:\"purchase\";s:3:\"900\";s:8:\"supplier\";s:4:\"1000\";s:7:\"payment\";s:4:\"1400\";s:6:\"backup\";s:4:\"1500\";s:5:\"email\";s:4:\"1600\";s:9:\"emailtemp\";s:4:\"1700\";s:10:\"preference\";s:4:\"1800\";s:3:\"tax\";s:4:\"1900\";s:10:\"currencies\";s:4:\"2100\";s:11:\"paymentterm\";s:4:\"2200\";s:13:\"paymentmethod\";s:4:\"2300\";s:14:\"companysetting\";s:4:\"2400\";s:10:\"iecategory\";s:4:\"2600\";s:7:\"expense\";s:4:\"2700\";s:7:\"deposit\";s:4:\"3000\";s:9:\"quotation\";s:4:\"2800\";s:7:\"invoice\";s:4:\"2900\";s:12:\"bank_account\";s:4:\"3100\";s:21:\"bank_account_transfer\";s:4:\"3200\";}","a:59:{s:7:\"cat_add\";s:3:\"101\";s:8:\"cat_edit\";s:3:\"102\";s:10:\"cat_delete\";s:3:\"103\";s:8:\"unit_add\";s:3:\"601\";s:9:\"unit_edit\";s:3:\"602\";s:11:\"unit_delete\";s:3:\"603\";s:7:\"loc_add\";s:3:\"201\";s:8:\"loc_edit\";s:3:\"202\";s:10:\"loc_delete\";s:3:\"203\";s:8:\"item_add\";s:3:\"301\";s:9:\"item_edit\";s:3:\"302\";s:11:\"item_delete\";s:3:\"303\";s:8:\"user_add\";s:3:\"401\";s:9:\"user_edit\";s:3:\"402\";s:11:\"user_delete\";s:3:\"403\";s:12:\"customer_add\";s:3:\"701\";s:13:\"customer_edit\";s:3:\"702\";s:15:\"customer_delete\";s:3:\"703\";s:12:\"purchase_add\";s:3:\"901\";s:13:\"purchase_edit\";s:3:\"902\";s:15:\"purchase_delete\";s:3:\"903\";s:12:\"supplier_add\";s:4:\"1001\";s:13:\"supplier_edit\";s:4:\"1002\";s:15:\"supplier_delete\";s:4:\"1003\";s:11:\"payment_add\";s:4:\"1401\";s:12:\"payment_edit\";s:4:\"1402\";s:14:\"payment_delete\";s:4:\"1403\";s:10:\"backup_add\";s:4:\"1501\";s:15:\"backup_download\";s:4:\"1502\";s:7:\"tax_add\";s:4:\"1901\";s:8:\"tax_edit\";s:4:\"1902\";s:10:\"tax_delete\";s:4:\"1903\";s:14:\"currencies_add\";s:4:\"2101\";s:15:\"currencies_edit\";s:4:\"2102\";s:17:\"currencies_delete\";s:4:\"2103\";s:15:\"paymentterm_add\";s:4:\"2201\";s:16:\"paymentterm_edit\";s:4:\"2202\";s:18:\"paymentterm_delete\";s:4:\"2203\";s:17:\"paymentmethod_add\";s:4:\"2301\";s:18:\"paymentmethod_edit\";s:4:\"2302\";s:20:\"paymentmethod_delete\";s:4:\"2303\";s:11:\"expense_add\";s:4:\"2701\";s:12:\"expense_edit\";s:4:\"2702\";s:14:\"expense_delete\";s:4:\"2703\";s:11:\"deposit_add\";s:4:\"3001\";s:12:\"deposit_edit\";s:4:\"3002\";s:14:\"deposit_delete\";s:4:\"3003\";s:13:\"quotation_add\";s:4:\"2801\";s:14:\"quotation_edit\";s:4:\"2802\";s:16:\"quotation_delete\";s:4:\"2803\";s:11:\"invoice_add\";s:4:\"2901\";s:12:\"invoice_edit\";s:4:\"2902\";s:14:\"invoice_delete\";s:4:\"2903\";s:16:\"bank_account_add\";s:4:\"3101\";s:17:\"bank_account_edit\";s:4:\"3102\";s:19:\"bank_account_delete\";s:4:\"3103\";s:25:\"bank_account_transfer_add\";s:4:\"3201\";s:26:\"bank_account_transfer_edit\";s:4:\"3202\";s:28:\"bank_account_transfer_delete\";s:4:\"3203\";}","0","2017-05-30 05:45:26","");





CREATE TABLE IF NOT EXISTS `shipment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` int(11) NOT NULL,
  `trans_type` int(11) NOT NULL,
  `comments` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `packed_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE IF NOT EXISTS `shipment_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shipment_id` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `stock_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_type_id` tinyint(4) NOT NULL,
  `unit_price` double NOT NULL,
  `quantity` double NOT NULL,
  `discount_percent` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE IF NOT EXISTS `stock_category` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dflt_units` int(11) NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO stock_category VALUES("1","Default","1","0","2017-05-30 05:45:26","");
INSERT INTO stock_category VALUES("2","Hardware","1","0","2017-05-30 05:45:26","");
INSERT INTO stock_category VALUES("3","Health & Beauty","1","0","2017-05-30 05:45:26","");





CREATE TABLE IF NOT EXISTS `stock_master` (
  `stock_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` tinyint(4) NOT NULL,
  `tax_type_id` tinyint(4) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `long_description` text COLLATE utf8_unicode_ci NOT NULL,
  `units` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`stock_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO stock_master VALUES("APPLE","1","2","Iphone 7+","","Each","0","0");
INSERT INTO stock_master VALUES("HP","1","2","HP Pro Book","","Each","0","0");
INSERT INTO stock_master VALUES("LENEVO","1","2","LED TV","","Each","0","0");
INSERT INTO stock_master VALUES("LG","1","2","LG Refrigeretor","","Each","0","0");
INSERT INTO stock_master VALUES("SAMSUNG","1","2","Samsung G7","","Each","0","0");
INSERT INTO stock_master VALUES("SINGER","1","2","Singer Refrigerator","","Each","0","0");
INSERT INTO stock_master VALUES("SONY","1","2","Sony experia 5","","Each","0","0");
INSERT INTO stock_master VALUES("WALTON","1","2","Walton Primo GH","","Each","0","0");





CREATE TABLE IF NOT EXISTS `stock_moves` (
  `trans_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `order_no` int(11) NOT NULL,
  `trans_type` smallint(6) NOT NULL DEFAULT '0',
  `loc_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `tran_date` date NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `order_reference` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `reference` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_reference_id` int(11) NOT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `qty` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`trans_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO stock_moves VALUES("1","WALTON","0","102","PL","2017-03-09","1","","store_in_1","1","","5000","0");
INSERT INTO stock_moves VALUES("2","SONY","0","102","PL","2017-03-09","1","","store_in_1","1","","5000","0");
INSERT INTO stock_moves VALUES("3","SAMSUN","0","102","PL","2017-03-09","1","","store_in_1","1","","5000","0");
INSERT INTO stock_moves VALUES("4","LG","0","102","PL","2017-03-09","1","","store_in_1","1","","5000","0");
INSERT INTO stock_moves VALUES("5","LENEVO","0","102","PL","2017-03-09","1","","store_in_1","1","","5000","0");
INSERT INTO stock_moves VALUES("6","APPLE","0","102","PL","2017-03-09","1","","store_in_1","1","","5000","0");
INSERT INTO stock_moves VALUES("7","HP","0","102","PL","2017-03-09","1","","store_in_1","1","","5000","0");
INSERT INTO stock_moves VALUES("8","APPLE","0","102","PL","2016-08-22","1","","store_in_2","2","","100","0");
INSERT INTO stock_moves VALUES("9","WALTON","0","102","JA","2017-04-10","1","","store_in_3","3","","3000","0");
INSERT INTO stock_moves VALUES("10","SONY","0","102","JA","2017-04-10","1","","store_in_3","3","","3000","0");
INSERT INTO stock_moves VALUES("11","SINGER","0","102","JA","2017-04-10","1","","store_in_3","3","","3000","0");
INSERT INTO stock_moves VALUES("12","SAMSUN","0","102","JA","2017-03-09","1","","store_in_3","3","","3000","0");
INSERT INTO stock_moves VALUES("13","LG","0","102","JA","2017-03-09","1","","store_in_3","3","","3000","0");
INSERT INTO stock_moves VALUES("14","LENEVO","0","102","JA","2017-04-10","1","","store_in_3","3","","3000","0");
INSERT INTO stock_moves VALUES("15","HP","0","102","JA","2017-04-10","1","","store_in_3","3","","3000","0");
INSERT INTO stock_moves VALUES("16","APPLE","0","102","JA","2017-04-10","1","","store_in_3","3","","3000","0");
INSERT INTO stock_moves VALUES("17","SAMSUN","0","102","JA","2017-04-10","1","","store_in_4","4","","100","0");
INSERT INTO stock_moves VALUES("18","SINGER","0","102","JA","2017-04-10","1","","store_in_5","5","","10","0");
INSERT INTO stock_moves VALUES("19","LENEVO","0","102","JA","2017-04-10","1","","store_in_6","6","","100","0");
INSERT INTO stock_moves VALUES("20","SAMSUN","0","102","PL","2017-04-10","1","","store_in_7","7","","500","0");
INSERT INTO stock_moves VALUES("21","WALTON","3","202","PL","2017-04-10","1","SO-0003","store_out_4","4","","-10","0");
INSERT INTO stock_moves VALUES("22","APPLE","3","202","PL","2017-04-10","1","SO-0003","store_out_4","4","","-10","0");
INSERT INTO stock_moves VALUES("23","SAMSUN","3","202","PL","2017-04-10","1","SO-0003","store_out_4","4","","-10","0");
INSERT INTO stock_moves VALUES("24","SONY","5","202","JA","2017-04-10","1","SO-0004","store_out_6","6","","-50","0");
INSERT INTO stock_moves VALUES("25","LG","5","202","JA","2017-04-10","1","SO-0004","store_out_6","6","","-70","0");
INSERT INTO stock_moves VALUES("26","APPLE","1","202","PL","2017-04-10","1","SO-0001","store_out_7","7","","-5000","0");
INSERT INTO stock_moves VALUES("27","SAMSUN","8","202","PL","2017-04-10","1","SO-0005","store_out_9","9","","-100","0");
INSERT INTO stock_moves VALUES("28","LG","10","202","PL","2017-04-10","1","SO-0006","store_out_11","11","","-1000","0");
INSERT INTO stock_moves VALUES("29","SAMSUN","10","202","PL","2017-04-10","1","SO-0005","store_out_11","11","","-1000","0");
INSERT INTO stock_moves VALUES("30","APPLE","12","202","PL","2017-05-09","1","SO-0007","store_out_13","13","","-50","0");





CREATE TABLE IF NOT EXISTS `stock_transfer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `source` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `destination` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `transfer_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE IF NOT EXISTS `suppliers` (
  `supplier_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `supp_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `zipcode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO suppliers VALUES("1","Ina Moran","ina.morn@yahoo.com","Santa Rosa","(684) 579-1879","Nunc Road","Lebanon","KY 69409","Lebanon","0","","");
INSERT INTO suppliers VALUES("2","Hedy Greene","hedy@yahoo.com","Ap #696-3279 Viverra. Avenue","(608) 265-2215","Latrobe","Lebanon","DE 38100","Lebanon","0","","");
INSERT INTO suppliers VALUES("3","Melvin Porter","melvin@gmail.com","Curabitur Rd.","(959) 119-8364","Bandera","South Dakota","45149","USA","0","","");
INSERT INTO suppliers VALUES("4","Celeste Slater","celeste@yahoo.com","Ullamcorper. Street","(786) 713-861","Roseville","New york","NH 11523","United States","0","","");
INSERT INTO suppliers VALUES("5","Theodore Lowe","lowe@yahoo.com","Ap #867-859 Sit Rd.","(793) 151-623","Azusa","New York","39531","United States","0","","");





CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `real_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '1',
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO users VALUES("1","","$2y$10$NFl9z/cbBkX8q41bIkZbm.32OT/Ogp2fYKIZXifzgm2M6n1oG5/0C","Admin","1","","admin@techvill.net","","0","LkSk4H15imd09fq5rWA3o4CEZkXYNLPAGD8Kygy9UNmlVOGjTDfztifYZm8R","","2017-05-31 08:22:36");
INSERT INTO users VALUES("2","","$2y$10$2tp9E..a7xJG5uQ6EoJ1z.eGd25ekYkdormz0AUrhXqZ4wWKOU1sy","Shahin Alam","2","123456","shahin@yahoo.com","","0","sKJIdO0HnRQ1dmDqSsLU5fYk7jT3JeumoD5PiOj5np7zzhCXLc8frhYrxdTq","2017-05-31 07:44:04","2017-05-31 08:12:07");




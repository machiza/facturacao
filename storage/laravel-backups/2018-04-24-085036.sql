

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO bank_accounts VALUES("5","1","CAIXA","caixa","BANCO UNICO","","1","0");





CREATE TABLE IF NOT EXISTS `bank_trans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `amount` double NOT NULL DEFAULT '0',
  `trans_type` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `account_no` int(11) NOT NULL,
  `trans_date` date NOT NULL,
  `person_id` int(11) NOT NULL,
  `reference` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `attachment` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO bank_trans VALUES("1","87750","cash-in-by-sale","5","2018-02-14","4","","Payment for FT-0002/2018","1","3","","2018-02-14 07:39:21");
INSERT INTO bank_trans VALUES("2","18720","cash-in-by-sale","5","2018-02-21","4","","Payment for FT-0007/2018","1","4","","2018-02-21 08:36:37");
INSERT INTO bank_trans VALUES("6","16379.999999999998","cash-in-by-sale","5","2018-02-22","2","","Payment for FT-0005/2018","1","2","","2018-02-22 13:37:27");
INSERT INTO bank_trans VALUES("7","3931.2","cash-in-by-sale","5","2018-02-22","2","","Payment for FT-0008/2018","1","2","","2018-02-22 13:37:27");
INSERT INTO bank_trans VALUES("5","1053","cash-in-by-sale","5","2018-02-22","4","","Payment for FT-0001/2018","1","4","","2018-02-22 08:34:03");
INSERT INTO bank_trans VALUES("8","4176.9","cash-in-by-sale","5","2018-02-22","2","","Payment for FT-0009/2018","1","2","","2018-02-22 13:37:27");
INSERT INTO bank_trans VALUES("9","87750","cash-in-by-sale","5","2018-03-02","4","","Payment for FT-0010/2018","1","3","","2018-03-02 07:53:46");
INSERT INTO bank_trans VALUES("10","48816.64","cash-in-by-sale","5","2018-03-09","4","","Payment for FT-0013/2018","1","4","","2018-03-09 10:16:29");
INSERT INTO bank_trans VALUES("11","23177.7","cash-in-by-sale","5","2018-03-21","4","","Payment for FT-0015/2018","1","3","","2018-03-21 12:59:51");
INSERT INTO bank_trans VALUES("12","105768","cash-in-by-sale","5","2018-03-26","4","","Payment for FT-0003/2018","1","4","","2018-03-26 14:04:00");
INSERT INTO bank_trans VALUES("13","87750","cash-in-by-sale","5","2018-03-29","4","","Payment for FT-0017/2018","1","4","","2018-03-29 06:20:29");
INSERT INTO bank_trans VALUES("14","15444","cash-in-by-sale","5","2018-03-29","4","","Payment for FT-0014/2018","1","4","","2018-03-29 06:22:32");
INSERT INTO bank_trans VALUES("15","16497","cash-in-by-sale","5","2018-04-04","4","","Payment for FT-0016/2018","1","4","","2018-04-04 09:12:08");
INSERT INTO bank_trans VALUES("16","12285","cash-in-by-sale","5","2018-04-13","4","","Payment for FT-0019/2018","1","4","","2018-04-13 07:49:35");
INSERT INTO bank_trans VALUES("17","1.17","cash-in-by-sale","5","2018-04-16","2","","Payment for FT-0020/2018","1","2","","2018-04-16 13:09:43");
INSERT INTO bank_trans VALUES("18","58140","cash-in-by-sale","5","2018-04-23","2","RE-0015/2018","Payment for FT-0021/2018","1","2","","2018-04-23 14:57:25");
INSERT INTO bank_trans VALUES("19","36270","cash-in-by-sale","5","2018-04-23","2","RE-0015/2018","Payment for ND-0002/2018","1","2","","2018-04-23 14:57:25");
INSERT INTO bank_trans VALUES("20","-26910","cash-in-by-sale","5","2018-04-23","2","RE-0015/2018","Payment for NC-0002/2018","1","2","","2018-04-23 14:57:25");
INSERT INTO bank_trans VALUES("21","24570","cash-in-by-sale","5","2018-04-23","2","RE-0015/2018","Payment for ND-0003/2018","1","2","","2018-04-23 14:57:25");
INSERT INTO bank_trans VALUES("22","24570","cash-in-by-sale","5","2018-04-23","2","RE-0016/2018","Payment for FT-0023/2018","1","2","","2018-04-23 15:06:40");
INSERT INTO bank_trans VALUES("23","-1340","cash-in-by-sale","5","2018-04-23","2","RE-0016/2018","Payment for NC-0003/2018","1","2","","2018-04-23 15:06:40");
INSERT INTO bank_trans VALUES("24","-1000","cash-in-by-sale","5","2018-04-23","2","RE-0017/2018","Payment for NC-0003/2018","1","2","","2018-04-23 15:06:59");
INSERT INTO bank_trans VALUES("25","66570","cash-in-by-sale","5","2018-04-24","2","","Payment for FT-0024/2018","1","2","","2018-04-24 07:27:41");





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

INSERT INTO currency VALUES("1","Metical","MT");





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
  `nuit` int(9) NOT NULL,
  `billing_country_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_zip_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_country_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `motivation` varchar(240) COLLATE utf8_unicode_ci NOT NULL,
  `imposto` int(11) NOT NULL,
  `discounto` double NOT NULL,
  PRIMARY KEY (`branch_code`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO cust_branch VALUES("1","1","TSENANE","","","Av. Ahmed-Sekou-Toure, Nt. 1919 1 andar","Maputo","Maputo","","400154694","MZ","Av. Ahmed-Sekou-Toure, Nt. 1919 1 andar","Maputo","Maputo","","MZ","","0","0");
INSERT INTO cust_branch VALUES("2","2","ALSAA - Petroleum Mozambique, Lda","","","Rani Towers, 2 andar","Maputo","Maputo","","400797129","MZ","Rani Towers, 2 andar","Maputo","Maputo","","MZ","","0","0");
INSERT INTO cust_branch VALUES("3","3","KPMG","","","Rua 1233, Edificio Hollard Nr. 72C","Maputo","Maputo","","400004021","MZ","Rua 1233, Edificio Hollard Nr. 72C","Maputo","Maputo","","MZ","","0","0");
INSERT INTO cust_branch VALUES("4","4","Soclima - Sociedade de Climatizacao, Lda","","","Av. do Trabalho, Nr. 1690/1708","Maputo","Maputo","","400010811","MZ","Av. do Trabalho, Nr. 1690/1708","Maputo","Maputo","","MZ","","0","0");
INSERT INTO cust_branch VALUES("5","5","CDN  - Corredor de Desenvolvimento do Norte","","","Rua do Porto, Nr. 39","Nacala - Porto","Nampula","","400091579","MZ","Rua do Porto, Nr. 39","Nacala - Porto","Nampula","","MZ","","0","0");
INSERT INTO cust_branch VALUES("6","6","ECOBANK","","","Av. Vlademir Lenine, Nr. 210","Maputo","Maputo","","400083045","MZ","Av. Vlademir Lenine, Nr. 210","Maputo","Maputo","","MZ","","0","0");
INSERT INTO cust_branch VALUES("7","7","CR Aviation","","","Aeroportos de Moputo","Maputo","Maputo","","400298084","MZ","Aeroportos de Moputo","Maputo","","","MZ","","0","0");
INSERT INTO cust_branch VALUES("8","8","INSS - Instituto Nacional de Seguranca Social","","","Av. 24 de Julho, Nr. 3549","Maputo","Maputo","","500005025","MZ","Av. 24 de Julho, Nr. 3549","Maputo","Maputo","","MZ","","0","0");
INSERT INTO cust_branch VALUES("9","9","Banco Societe General Mocambique","","","Av. Julius Nyerere, Nr. 140 - 4 andar","Maputo","Maputo","","400066183","MZ","Av. Julius Nyerere, Nr. 140 - 4 andar","Maputo","Maputo","","MZ","","0","0");
INSERT INTO cust_branch VALUES("10","10","TM - advogados, Lda","","","Av. Vlademir Lenine, Nr. 548 R/C, Flat 4","Maputo","","","400679126","MZ","Av. Vlademir Lenine, Nr. 548 R/C, Flat 4","Maputo","","","MZ","","0","0");
INSERT INTO cust_branch VALUES("11","11","3F Designs e Decoracao de Interiores, Lda ","","","Av. 24 de Julho, Nr. 7 - 6 andar Esquerdo","Maputo","","","400779521","MZ","Av. 24 de Julho, Nr. 7 - 6 andar Esquerdo","Maputo","","","MZ","","0","0");
INSERT INTO cust_branch VALUES("12","12","Mocambique Companhia de Seguros","","","Av. Kenneth kaunda, Nr. 518","Maputo","","","400081263","MZ","Av. Kenneth kaunda, Nr. 518","Maputo","","","MZ","","0","0");
INSERT INTO cust_branch VALUES("13","13","SAMPLEX MOCAMBIQUE","","","Av. Martires da Machava, Nr. 534","Maputo","Maputo","","400404046","MZ","Av. Martires da Machava, Nr. 534","Maputo","","","MZ","","0","0");
INSERT INTO cust_branch VALUES("14","14","Cliente","","","A1","A2","","","11223344","MZ","A1","A2","","","MZ","","0","0");
INSERT INTO cust_branch VALUES("15","15","teste mail","","","Estrada Nacional n.8 , Muchilipo","Nacala - Porto","","","400202540","MZ","","","","","","","0","0");
INSERT INTO cust_branch VALUES("16","16","CF & A","","","Rua 1301, Nr. 97","Maputo","Maputo","","400600147","MZ","Rua 1301, Nr. 97","Maputo","Maputo","","MZ","","0","0");
INSERT INTO cust_branch VALUES("17","17","DREAMZ","","","Rua da Estrada Velha, Nr. 6874","Matola","Maputo","","400302391","MZ","Rua da Estrada Velha, Nr. 6874","Matola","Maputo","","MZ","","0","0");
INSERT INTO cust_branch VALUES("18","18","Universidade Lurio","","","Bairro de Marere, Rua 4.250 Km2,3","Nampula","Nampula","","400000003","MZ","Bairro de Marere, Rua 4.250 Km2,3","Nampula","Nampula","","MZ","","0","0");
INSERT INTO cust_branch VALUES("19","19","Computech S U, Lda","","","Av. Eduardo Mondlane, Nr. 1619","Maputo","Maputo","","400246650","MZ","Av. Eduardo Mondlane, Nr. 1619","Maputo","Maputo","","MZ","","0","0");
INSERT INTO cust_branch VALUES("20","20","Laboratorio de Engenharias de Mocambique","","","Av. de Mocambique, Km 1,5 -  Nr. 1018 ","Maputo","Maputo","","500000791","MZ","Av. de Mocambique, Km 1,5 -  Nr. 1018 ","Maputo","","","MZ","","0","0");
INSERT INTO cust_branch VALUES("21","21","Bravo Seguranca, Lda","","","Rua Daniel Tome Magaia, Nr. 23 - 1 Andar","Maputo","","","400385599","MZ","Rua Daniel Tome Magaia, Nr. 23 - 1 Andar","Maputo","","","MZ","","0","0");
INSERT INTO cust_branch VALUES("22","22","MHM","","","Av. Amilcar Cabral, Nr. 1079","Maputo","Maputo","","400010978","MZ","Av. Amilcar Cabral, Nr. 1079","Maputo","Maputo","","MZ","","0","0");
INSERT INTO cust_branch VALUES("23","23","SGS MOCAMBIQUE, LTD","","","Av. Vlademir Lenine, Nr. 174, Millennium Park, Boco B - 2 andar","Maputo","Maputo","","400258503","MZ","Av. Vlademir Lenine, Nr. 174, Millennium Park, Boco B - 2 andar","Maputo","Maputo","","MZ","","0","0");
INSERT INTO cust_branch VALUES("24","24","Engenharia Servicos e Processos Industriais, Lda","","","Rua da Mozal, Nr. 13B, Boane","Matola","Maputo","","400578702","MZ","Rua da Mozal, Nr. 13B, Boane","Matola","Maputo","","MZ","","0","0");
INSERT INTO cust_branch VALUES("25","25","Movitel SA","","","Av. Guerra popular 2019 ","Cidade de Maputo","Cidade de Maputo","","400020300","","Av. Guerra popular 2019 ","Cidade de Maputo","","","","","0","0");





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
  `status_debtor` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`debtor_no`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO debtors_master VALUES("1","TSENANE","amacassa@tsenane.co.mz","","","823132800","0","","0","2018-02-12 13:10:55","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("2","ALSAA - Petroleum Mozambique, Lda","valentina@alsaa.ae","","","847689315","0","","0","2018-02-12 13:12:41","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("3","KPMG","mchutumia@kpmg.com","","","843552000","0","","0","2018-02-12 13:21:39","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("4","Soclima - Sociedade de Climatizacao, Lda","vmatusse@soclima.co.mz","","","21401072","0","","0","2018-02-12 13:49:01","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("5","CDN  - Corredor de Desenvolvimento do Norte","Vanessa.oliveira@cdncear.com","","","845403232","0","","0","2018-02-12 14:27:06","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("6","ECOBANK","DMagaia@ecobank.com","","","","0","","0","2018-02-12 18:50:40","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("7","CR Aviation","marcia.bambo@craviation.co.mz","","","848264847","0","","0","2018-02-12 19:12:03","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("8","INSS - Instituto Nacional de Seguranca Social","info@inss.co.mz","","","21403010/","0","","0","2018-02-13 13:42:23","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("9","Banco Societe General Mocambique","nataniel.nhanombe@socgen.com","","","21481900","0","","0","2018-02-14 14:01:54","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("10","TM - advogados, Lda","teobanze@gmail.com","","","844278999","0","","0","2018-02-21 06:19:42","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("11","3F Designs e Decoracao de Interiores, Lda ","Ana.Zara@BCI.co.mz","","","843090820","0","","0","2018-03-12 08:07:17","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("12","Mocambique Companhia de Seguros","rrafael@mcs.co.za","","","21485020","0","","0","2018-03-12 17:43:50","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("13","SAMPLEX MOCAMBIQUE","denise@samplex.co.mz","","","843946087","0","","0","2018-03-23 07:30:20","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("14","Cliente","cli@gmail.com","","","","0","","0","2018-03-23 11:03:07","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("15","teste mail","update_mz@outlook.com","","","","0","","0","2018-03-23 11:38:18","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("16","CF & A","aeg@legalma.com","","","21493465","0","","0","2018-04-02 08:37:59","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("17","DREAMZ","dreamz.moz@gmail.com","","","828895940","0","","0","2018-04-02 08:56:02","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("18","Universidade Lurio","carlaganhaoster@gmail.com","","","842641255","0","","0","2018-04-03 13:36:56","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("19","Computech S U, Lda","marcelomuchave@gmail.com","","","842894378","0","","0","2018-04-05 09:51:17","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("20","Laboratorio de Engenharias de Mocambique","davchirindja@gmail.com","","","843716309","0","","0","2018-04-13 07:59:14","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("21","Bravo Seguranca, Lda","info@bravoseguranca.co.mz","","","21400000","0","","0","2018-04-13 09:02:55","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("22","MHM","compras@mhm.co.mz","","","821313625","0","","0","2018-04-13 09:10:40","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("23","SGS MOCAMBIQUE, LTD","Celio.Vembane@sgs.com","","","843026198","0","","0","2018-04-13 12:39:59","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("24","Engenharia Servicos e Processos Industriais, Lda","3.spi@outlook.com","","","827860939","0","","0","2018-04-20 12:47:09","0000-00-00 00:00:00","");
INSERT INTO debtors_master VALUES("25","Movitel SA","movitel@movitel.co.mz","","","878787878","0","","0","2018-04-23 14:44:25","","");





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

INSERT INTO email_config VALUES("1","smtp","ssl","n3.co.mz","465","no-reply@n3.co.mz","no-reply@n3.co.mz","Update2018!","no-reply@n3.co.mz","no-reply@n3.co.mz");





CREATE TABLE IF NOT EXISTS `email_temp_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `temp_id` tinyint(4) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `lang_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO email_temp_details VALUES("1","2","Your Quotation # {order_reference_no} from {company_name} has been shipped","Hi {customer_name},<br><br>Thank you for your Quotation. Here?s a brief overview of your shipment:<br>Quotation # {order_reference_no} was packed on {packed_date} and shipped on {delivery_date}.<br> <br><b>Shipping address   </b><br><br>{shipping_street}<br>{shipping_city}<br>{shipping_state}<br>{shipping_zip_code}<br>{shipping_country}<br><br><b>Item Summery</b><br>{item_information}<br> <br>If you have any questions, please feel free to reply to this email.<br><br>Regards<br>{company_name}<br><br><br>","en","1");
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
INSERT INTO email_temp_details VALUES("25","4","Your Invoice # {invoice_reference_no} for Quotation #{order_reference_no} from {company_name} has been created.","<p>Hi {customer_name},</p><p>Thank you for your order. Here?s a brief overview of your invoice: Invoice #{invoice_reference_no} is for Quotation #{order_reference_no}. The invoice total is {currency}{total_amount}, please pay before {due_date}.</p><p>If you have any questions, please feel free to reply to this email. </p><p><b>Billing address</b></p><p>&nbsp;{billing_street}</p><p>&nbsp;{billing_city}</p><p>&nbsp;{billing_state}</p><p>&nbsp;{billing_zip_code}</p><p>&nbsp;{billing_country}<br></p><p><br></p><p><b>Quotation summary<br></b></p><p><b></b>{invoice_summery}<br></p><p>Regards,</p><p>{company_name}<br></p><br><br>","en","1");
INSERT INTO email_temp_details VALUES("26","4","Subject","Body","ar","2");
INSERT INTO email_temp_details VALUES("27","4","Subject","Body","ch","3");
INSERT INTO email_temp_details VALUES("28","4","Subject","Body","fr","4");
INSERT INTO email_temp_details VALUES("29","4","Subject","Body","po","5");
INSERT INTO email_temp_details VALUES("30","4","Subject","Body","rs","6");
INSERT INTO email_temp_details VALUES("31","4","Subject","Body","sp","7");
INSERT INTO email_temp_details VALUES("32","4","Subject","Body","tu","8");
INSERT INTO email_temp_details VALUES("33","5","Your Quotation # {order_reference_no} from {company_name} has been created.","<p>Hi {customer_name},</p><p>Thank you for your order. Here?s a brief overview of your Quotation #{order_reference_no} that was created on {order_date}. The order total is {currency}{total_amount}.</p><p>If you have any questions, please feel free to reply to this email. </p><p><b>Billing address</b></p><p>&nbsp;{billing_street}</p><p>&nbsp;{billing_city}</p><p>&nbsp;{billing_state}</p><p>&nbsp;{billing_zip_code}</p><p>&nbsp;{billing_country}<br></p><p><br></p><p><b>Quotation summary<br></b></p><p><b></b>{order_summery}<br></p><p>Regards,</p><p>{company_name}</p><br><br>","en","1");
INSERT INTO email_temp_details VALUES("34","5","Subject","Body","ar","2");
INSERT INTO email_temp_details VALUES("35","5","Subject","Body","ch","3");
INSERT INTO email_temp_details VALUES("36","5","Subject","Body","fr","4");
INSERT INTO email_temp_details VALUES("37","5","Subject","Body","po","5");
INSERT INTO email_temp_details VALUES("38","5","Subject","Body","rs","6");
INSERT INTO email_temp_details VALUES("39","5","Subject","Body","sp","7");
INSERT INTO email_temp_details VALUES("40","5","Subject","Body","tu","8");
INSERT INTO email_temp_details VALUES("41","6","Your Quotation # {order_reference_no} from {company_name} has been packed","Hi {customer_name},<br><br>Thank you for your order. Here?s a brief overview of your shipment:<br>Quotation # {order_reference_no} was packed on {packed_date}.<br> <br><b>Shipping address   </b><br><br>{shipping_street}<br>{shipping_city}<br>{shipping_state}<br>{shipping_zip_code}<br>{shipping_country}<br><br><b>Item Summery</b><br>{item_information}<br> <br>If you have any questions, please feel free to reply to this email.<br><br>Regards<br>{company_name}<br><br><br>","en","1");
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

INSERT INTO invoice_payment_terms VALUES("1","Pronto Pagamento","0","1");
INSERT INTO invoice_payment_terms VALUES("2","15 dias","15","0");
INSERT INTO invoice_payment_terms VALUES("3","30 dias","30","0");





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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO item_code VALUES("1","00","SERVICO DE TRADUCAO DE DOCUMENTOS ","2","","0","0","","");





CREATE TABLE IF NOT EXISTS `item_tax_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tax_rate` double(8,2) NOT NULL,
  `defaults` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO item_tax_types VALUES("4","Normal(17%)","17.00","1");





CREATE TABLE IF NOT EXISTS `item_unit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `abbr` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO item_unit VALUES("1","each","Each","0","0000-00-00 00:00:00","0000-00-00 00:00:00");





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

INSERT INTO location VALUES("1","PL","Primary Location","Primary Location","","","","Primary Location","0","2017-10-18 05:51:20","0000-00-00 00:00:00");
INSERT INTO location VALUES("2","JA","Jackson Av","125 Hayes St, San Francisco, CA 94102, USA","","","","Jackson Av","0","2017-10-18 05:51:20","0000-00-00 00:00:00");





CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO migrations VALUES("2018_04_20_082916_actualizar_tabelas","1");





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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO payment_history VALUES("1","1","3"," COT-0002/2018","FT-0002/2018 ","2018-02-14","87750","4","2","RE-0001/2018","completed","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO payment_history VALUES("2","2","4"," COT-0012/2018","FT-0007/2018 ","2018-02-21","18720","4","3","RE-0002/2018","completed","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO payment_history VALUES("6","6","2"," COT-0005/2018","FT-0005/2018 ","2018-02-22","8271.9","2","4","RE-0005/2018","completed","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO payment_history VALUES("7","7","2"," COT-0015/2018","FT-0008/2018 ","2018-02-22","3931.2","2","4","RE-0005/2018","completed","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO payment_history VALUES("5","5","4"," COT-0001/2018","FT-0001/2018 ","2018-02-22","1053","4","1","RE-0004/2018","completed","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO payment_history VALUES("8","8","2"," COT-0017/2018","FT-0009/2018 ","2018-02-22","4176.9","2","4","RE-0005/2018","completed","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO payment_history VALUES("9","9","3"," COT-0023/2018","FT-0010/2018 ","2018-03-02","87750","4","2","RE-0006/2018","completed","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO payment_history VALUES("10","10","4"," COT-0027/2018","FT-0013/2018 ","2018-03-09","48816.64","4","3","RE-0007/2018","completed","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO payment_history VALUES("11","11","3"," COT-0034/2018","FT-0015/2018 ","2018-03-21","23177.7","4","12","RE-0008/2018","completed","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO payment_history VALUES("12","12","4"," COT-0003/2018","FT-0003/2018 ","2018-03-26","105768","4","3","RE-0009/2018","completed","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO payment_history VALUES("13","13","4"," COT-0038/2018","FT-0017/2018 ","2018-03-29","87750","4","2","RE-0010/2018","completed","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO payment_history VALUES("14","14","4"," COT-0028/2018","FT-0014/2018 ","2018-03-29","15444","4","11","RE-0011/2018","completed","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO payment_history VALUES("15","15","4"," COT-0036/2018","FT-0016/2018 ","2018-04-04","16497","4","3","RE-0012/2018","completed","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO payment_history VALUES("16","16","4"," COT-0055/2018","FT-0019/2018 ","2018-04-13","12285","4","17","RE-0013/2018","completed","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO payment_history VALUES("17","17","2"," COT-0061/2018","FT-0020/2018 ","2018-04-16","1.17","2","23","RE-0014/2018","completed","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO payment_history VALUES("18","18","2"," COT-0065/2018","FT-0021/2018 ","2018-04-23","58140","2","25","RE-0015/2018","completed","","");
INSERT INTO payment_history VALUES("19","19","2","  0","ND-0002/2018 ","2018-04-23","36270","2","25","RE-0015/2018","completed","","");
INSERT INTO payment_history VALUES("20","20","2","  0","NC-0002/2018 ","2018-04-23","-26910","2","25","RE-0015/2018","completed","","");
INSERT INTO payment_history VALUES("21","21","2","  6","ND-0003/2018 ","2018-04-23","24570","2","25","RE-0015/2018","completed","","");
INSERT INTO payment_history VALUES("22","22","2"," COT-0066/2018","FT-0023/2018 ","2018-04-23","24570","2","25","RE-0016/2018","completed","","");
INSERT INTO payment_history VALUES("23","23","2","  0","NC-0003/2018 ","2018-04-23","-1340","2","25","RE-0016/2018","completed","","");
INSERT INTO payment_history VALUES("24","24","2","  0","NC-0003/2018 ","2018-04-23","-1000","2","25","RE-0017/2018","completed","","");
INSERT INTO payment_history VALUES("25","25","2","COT-0067/2018","FT-0024/2018","2018-04-24","66570","2","25","RE-0018/2018","completed","","");





CREATE TABLE IF NOT EXISTS `payment_purchase_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `payment_type_id` smallint(6) NOT NULL,
  `order_reference` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `payment_date` date NOT NULL,
  `amount` double DEFAULT '0',
  `person_id` int(11) NOT NULL,
  `supp_id` int(11) NOT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE IF NOT EXISTS `payment_terms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `defaults` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO payment_terms VALUES("1","Paypal","0");
INSERT INTO payment_terms VALUES("2","Numerario","1");
INSERT INTO payment_terms VALUES("3","Transferencia","0");
INSERT INTO payment_terms VALUES("4","Cheque","0");
INSERT INTO payment_terms VALUES("5","Sistafe","0");





CREATE TABLE IF NOT EXISTS `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`)
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
INSERT INTO permission_role VALUES("5","2");
INSERT INTO permission_role VALUES("6","1");
INSERT INTO permission_role VALUES("6","2");
INSERT INTO permission_role VALUES("7","1");
INSERT INTO permission_role VALUES("7","2");
INSERT INTO permission_role VALUES("8","1");
INSERT INTO permission_role VALUES("8","2");
INSERT INTO permission_role VALUES("9","1");
INSERT INTO permission_role VALUES("10","1");
INSERT INTO permission_role VALUES("10","2");
INSERT INTO permission_role VALUES("11","1");
INSERT INTO permission_role VALUES("11","2");
INSERT INTO permission_role VALUES("12","1");
INSERT INTO permission_role VALUES("12","2");
INSERT INTO permission_role VALUES("13","1");
INSERT INTO permission_role VALUES("13","2");
INSERT INTO permission_role VALUES("14","1");
INSERT INTO permission_role VALUES("14","2");
INSERT INTO permission_role VALUES("15","1");
INSERT INTO permission_role VALUES("15","2");
INSERT INTO permission_role VALUES("16","1");
INSERT INTO permission_role VALUES("16","2");
INSERT INTO permission_role VALUES("17","1");
INSERT INTO permission_role VALUES("17","2");
INSERT INTO permission_role VALUES("18","1");
INSERT INTO permission_role VALUES("18","2");
INSERT INTO permission_role VALUES("19","1");
INSERT INTO permission_role VALUES("19","2");
INSERT INTO permission_role VALUES("20","1");
INSERT INTO permission_role VALUES("20","2");
INSERT INTO permission_role VALUES("21","1");
INSERT INTO permission_role VALUES("21","2");
INSERT INTO permission_role VALUES("22","1");
INSERT INTO permission_role VALUES("22","2");
INSERT INTO permission_role VALUES("23","1");
INSERT INTO permission_role VALUES("23","2");
INSERT INTO permission_role VALUES("24","1");
INSERT INTO permission_role VALUES("24","2");
INSERT INTO permission_role VALUES("25","1");
INSERT INTO permission_role VALUES("25","2");
INSERT INTO permission_role VALUES("26","1");
INSERT INTO permission_role VALUES("26","2");
INSERT INTO permission_role VALUES("27","1");
INSERT INTO permission_role VALUES("27","2");
INSERT INTO permission_role VALUES("28","1");
INSERT INTO permission_role VALUES("28","2");
INSERT INTO permission_role VALUES("29","1");
INSERT INTO permission_role VALUES("29","2");
INSERT INTO permission_role VALUES("30","1");
INSERT INTO permission_role VALUES("30","2");
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
INSERT INTO permission_role VALUES("49","2");
INSERT INTO permission_role VALUES("50","1");
INSERT INTO permission_role VALUES("50","2");
INSERT INTO permission_role VALUES("51","1");
INSERT INTO permission_role VALUES("51","2");
INSERT INTO permission_role VALUES("52","1");
INSERT INTO permission_role VALUES("52","2");
INSERT INTO permission_role VALUES("53","1");
INSERT INTO permission_role VALUES("53","2");
INSERT INTO permission_role VALUES("54","1");
INSERT INTO permission_role VALUES("55","1");
INSERT INTO permission_role VALUES("56","1");
INSERT INTO permission_role VALUES("56","2");
INSERT INTO permission_role VALUES("57","1");
INSERT INTO permission_role VALUES("57","2");
INSERT INTO permission_role VALUES("58","1");
INSERT INTO permission_role VALUES("58","2");
INSERT INTO permission_role VALUES("59","1");
INSERT INTO permission_role VALUES("59","2");
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
INSERT INTO permission_role VALUES("114","1");





CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO permissions VALUES("1","manage_relationship","Manage Relationship","Manage Relationship","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("2","manage_customer","Manage Customers","Manage Customers","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("3","add_customer","Add Customer","Add Customer","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("4","edit_customer","Edit Customer","Edit Customer","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("5","delete_customer","Delete Customer","Delete Customer","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("6","manage_supplier","Manage Suppliers","Manage Suppliers","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("7","add_supplier","Add Supplier","Add Supplier","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("8","edit_supplier","Edit Supplier","Edit Supplier","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("9","delete_supplier","Delete Supplier","Delete Supplier","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("10","manage_item","Manage Items","Manage Items","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("11","add_item","Add Item","Add Item","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("12","edit_item","Edit Item","Edit Item","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("13","delete_item","Delete Item","Delete Item","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("14","manage_sale","Manage Sales","Manage Sales","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("15","manage_quotation","Manage Quotations","Manage Quotations","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("16","add_quotation","Add Quotation","Add Quotation","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("17","edit_quotation","Edit Quotation","Edit Quotation","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("18","delete_quotation","Delete Quotation","Delete Quotation","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("19","manage_invoice","Manage Invoices","Manage Invoices","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("20","add_invoice","Add Invoice","Add Invoice","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("21","edit_invoice","Edit Invoice","Edit Invoice","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("22","delete_invoice","Delete Invoice","Delete Invoice","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("23","manage_payment","Manage Payment","Manage Payment","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("24","add_payment","Add Payment","Add Payment","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("25","edit_payment","Edit Payment","Edit Payment","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("26","delete_payment","Delete Payment","Delete Payment","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("27","manage_purchase","Manage Purchase","Manage Purchase","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("28","add_purchase","Add Purchase","Add Purchase","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("29","edit_purchase","Edit Purchase","Edit Purchase","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("30","delete_purchase","Delete Purchase","Delete Purchase","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("31","manage_banking_transaction","Manage Banking & Transactions","Manage Banking & Transactions","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("32","manage_bank_account","Manage Bank Accounts","Manage Bank Accounts","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("33","add_bank_account","Add Bank Account","Add Bank Account","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("34","edit_bank_account","Edit Bank Account","Edit Bank Account","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("35","delete_bank_account","Delete Bank Account","Delete Bank Account","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("36","manage_deposit","Manage Deposit","Manage Deposit","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("37","add_deposit","Add Deposit","Add Deposit","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("38","edit_deposit","Edit Deposit","Edit Deposit","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("39","delete_deposit","Delete Deposit","Delete Deposit","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("40","manage_balance_transfer","Manage Balance Transfer","Manage Balance Transfer","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("41","add_balance_transfer","Add Balance Transfer","Add Balance Transfer","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("42","edit_balance_transfer","Edit Balance Transfer","Edit Balance Transfer","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("43","delete_balance_transfer","Delete Balance Transfer","Delete Balance Transfer","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("44","manage_transaction","Manage Transactions","Manage Transactions","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("45","manage_expense","Manage Expense","Manage Expense","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("46","add_expense","Add Expense","Add Expense","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("47","edit_expense","Edit Expense","Edit Expense","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("48","delete_expense","Delete Expense","Delete Expense","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("49","manage_report","Manage Report","Manage Report","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("50","manage_stock_on_hand","Manage Inventory Stock On Hand","Manage Inventory Stock On Hand","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("51","manage_sale_report","Manage Sales Report","Manage Sales Report","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("52","manage_sale_history_report","Manage Sales History Report","Manage Sales History Report","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("53","manage_purchase_report","Manage Purchase Report","Manage Purchase Report","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("54","manage_team_report","Manage Team Member Report","Manage Team Member Report","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("55","manage_expense_report","Manage Expense Report","Manage Expense Report","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("56","manage_income_report","Manage Income Report","Manage Income Report","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("57","manage_income_vs_expense","Manage Income vs Expense","Manage Income vs Expense","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("58","manage_setting","Manage Settings","Manage Settings","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("59","manage_company_setting","Manage Company Setting","Manage Company Setting","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("60","manage_team_member","Manage Team Member","Manage Team Member","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("61","add_team_member","Add Team Member","Add Team Member","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("62","edit_team_member","Edit Team Member","Edit Team Member","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("63","delete_team_member","Delete Team Member","Delete Team Member","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("64","manage_role","Manage Roles","Manage Roles","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("65","add_role","Add Role","Add Role","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("66","edit_role","Edit Role","Edit Role","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("67","delete_role","Delete Role","Delete Role","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("68","manage_location","Manage Location","Manage Location","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("69","add_location","Add Location","Add Location","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("70","edit_location","Edit Location","Edit Location","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("71","delete_location","Delete Location","Delete Location","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("72","manage_general_setting","Manage General Settings","Manage General Settings","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("73","manage_item_category","Manage Item Category","Manage Item Category","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("74","add_item_category","Add Item Category","Add Item Category","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("75","edit_item_category","Edit Item Category","Edit Item Category","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("76","delete_item_category","Delete Item Category","Delete Item Category","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("77","manage_income_expense_category","Manage Income Expense Category","Manage Income Expense Category","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("78","add_income_expense_category","Add Income Expense Category","Add Income Expense Category","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("79","edit_income_expense_category","Edit Income Expense Category","Edit Income Expense Category","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("80","delete_income_expense_category","Delete Income Expense Category","Delete Income Expense Category","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("81","manage_unit","Manage Unit","Manage Unit","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("82","add_unit","Add Unit","Add Unit","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("83","edit_unit","Edit Unit","Edit Unit","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("84","delete_unit","Delete Unit","Delete Unit","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("85","manage_db_backup","Manage Database Backup","Manage Database Backup","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("86","add_db_backup","Add Database Backup","Add Database Backup","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("87","delete_db_backup","Delete Database Backup","Delete Database Backup","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("88","manage_email_setup","Manage Email Setup","Manage Email Setup","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("89","manage_finance","Manage Finance","Manage Finance","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("90","manage_tax","Manage Taxs","Manage Taxs","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("91","add_tax","Add Tax","Add Tax","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("92","edit_tax","Edit Tax","Edit Tax","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("93","delete_tax","Delete Tax","Delete Tax","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("94","manage_currency","Manage Currency","Manage Currency","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("95","add_currency","Add Currency","Add Currency","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("96","edit_currency","Edit Currency","Edit Currency","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("97","delete_currency","Delete Currency","Delete Currency","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("98","manage_payment_term","Manage Payment Term","Manage Payment Term","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("99","add_payment_term","Add Payment Term","Add Payment Term","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("100","edit_payment_term","Edit Payment Term","Edit Payment Term","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("101","delete_payment_term","Delete Payment Term","Delete Payment Term","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("102","manage_payment_method","Manage Payment Method","Manage Payment Method","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("103","add_payment_method","Add Payment Method","Add Payment Method","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("104","edit_payment_method","Edit Payment Method","Edit Payment Method","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("105","delete_payment_method","Delete Payment Method","Delete Payment Method","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("106","manage_payment_gateway","Manage Payment Method","Manage Payment Gateway","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("107","manage_email_template","Manage Email Template","Manage Email Template","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("108","manage_quotation_email_template","Manage Quotation Template","Manage Quotation Email Template","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("109","manage_invoice_email_template","Manage Invoice Email Template","Manage Invoice Email Template","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("110","manage_payment_email_template","Manage Payment Email Template","Manage Payment Email Template","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("111","manage_preference","Manage Preference","Manage Preference","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("112","manage_barcode","Manage barcode/label","Manage barcode/label","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("113","download_db_backup","Download Database Backup","Download Database Backup","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO permissions VALUES("114","update_version","Update version","Update version","","");





CREATE TABLE IF NOT EXISTS `preference` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `field` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO preference VALUES("1","preference","row_per_page","25");
INSERT INTO preference VALUES("2","preference","date_format","1");
INSERT INTO preference VALUES("3","preference","date_sepa","-");
INSERT INTO preference VALUES("4","preference","soft_name","goBilling");
INSERT INTO preference VALUES("5","company","site_short_name","MC");
INSERT INTO preference VALUES("6","preference","percentage","0");
INSERT INTO preference VALUES("7","preference","quantity","0");
INSERT INTO preference VALUES("8","preference","date_format_type","dd-mm-yyyy");
INSERT INTO preference VALUES("9","company","company_name","MC Comunicação o e Serviços, Lda");
INSERT INTO preference VALUES("10","company","company_email","contabilidade@grupom.co.mz");
INSERT INTO preference VALUES("11","company","company_phone","21 418 155");
INSERT INTO preference VALUES("12","company","company_street"," Av. Marien Ngouabi Nr. 330 Rc");
INSERT INTO preference VALUES("13","company","company_city","Maputo");
INSERT INTO preference VALUES("14","company","company_state","Mocambique");
INSERT INTO preference VALUES("15","company","company_zipCode",".");
INSERT INTO preference VALUES("16","company","company_country_id","Mozambique");
INSERT INTO preference VALUES("17","company","dflt_lang","po");
INSERT INTO preference VALUES("18","company","dflt_currency_id","1");
INSERT INTO preference VALUES("19","company","sates_type_id","1");
INSERT INTO preference VALUES("20","company","company_nuit","400660859");
INSERT INTO preference VALUES("21","preference","version","1.1.0");
INSERT INTO preference VALUES("22","preference","date_version","21042018");





CREATE TABLE IF NOT EXISTS `purch_cc` (
  `idcc` int(11) NOT NULL AUTO_INCREMENT,
  `supp_id_doc` int(10) unsigned NOT NULL,
  `order_no_doc` int(10) unsigned DEFAULT NULL,
  `rec_no_doc` int(11) DEFAULT NULL,
  `reference_doc` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `amount_doc` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount_credito_doc` double DEFAULT NULL,
  `saldo_doc` double DEFAULT NULL,
  `debito_credito` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1 para debito(Sai) 0 para credito(Entra)',
  `ord_date_doc` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idcc`),
  KEY `purch_cc_supp_id_doc_foreign` (`supp_id_doc`),
  KEY `purch_cc_order_no_doc_foreign` (`order_no_doc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






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
  `discount_percent` double(15,2) NOT NULL,
  PRIMARY KEY (`po_detail_item`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE IF NOT EXISTS `purch_orders` (
  `order_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `comments` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ord_date` date NOT NULL,
  `reference` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `into_stock_location` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  `valor_pago` decimal(9,2) DEFAULT '0.00',
  `saldo` decimal(9,2) DEFAULT NULL,
  PRIMARY KEY (`order_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE IF NOT EXISTS `purchase_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO purchase_prices VALUES("1","00","18000");





CREATE TABLE IF NOT EXISTS `purchase_vd` (
  `vd_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_no_vd` int(11) NOT NULL,
  `account_no` int(11) NOT NULL,
  `reference_vd` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vd_date` date NOT NULL,
  `payment_id` mediumint(9) NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `into_stock_location` double NOT NULL,
  PRIMARY KEY (`vd_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE IF NOT EXISTS `purchase_vd_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vd_no` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `tax_type_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit_price` double NOT NULL DEFAULT '0',
  `quantity` double NOT NULL DEFAULT '0',
  `is_inventory` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE IF NOT EXISTS `receiptlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(45) NOT NULL,
  `total_amount` double NOT NULL DEFAULT '0',
  `pay_history_id` int(11) NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `supp_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;






CREATE TABLE IF NOT EXISTS `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO role_user VALUES("1","1");
INSERT INTO role_user VALUES("2","1");
INSERT INTO role_user VALUES("3","2");
INSERT INTO role_user VALUES("4","2");
INSERT INTO role_user VALUES("5","2");





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

INSERT INTO roles VALUES("1","admin","Admin","Admin User","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO roles VALUES("2","user","user","user","0000-00-00 00:00:00","0000-00-00 00:00:00");





CREATE TABLE IF NOT EXISTS `sale_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sales_type_id` tinyint(4) NOT NULL,
  `curr_abrev` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `inclusao_iva` int(11) NOT NULL,
  `discounto` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sale_prices VALUES("1","00","1","USD","21000","0","0");
INSERT INTO sale_prices VALUES("2","00","2","USD","0","0","0");





CREATE TABLE IF NOT EXISTS `sales_cc` (
  `idcc` int(11) NOT NULL AUTO_INCREMENT,
  `debtor_no_doc` int(10) unsigned NOT NULL,
  `order_no_doc` int(10) unsigned NOT NULL,
  `rec_no_doc` int(11) DEFAULT NULL,
  `debit_no_doc` int(11) DEFAULT NULL,
  `credit_no_doc` int(11) DEFAULT NULL,
  `reference_doc` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `order_reference_doc` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `amount_doc` double DEFAULT NULL,
  `amount_credito_doc` double DEFAULT NULL,
  `saldo_doc` double DEFAULT NULL,
  `payment_type_id_doc` smallint(6) DEFAULT NULL,
  `debito_credito` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1 para debito(Sai) 0 para credito(Entra)',
  `ord_date_doc` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idcc`),
  KEY `sales_cc_debtor_no_doc_foreign` (`debtor_no_doc`),
  KEY `sales_cc_order_no_doc_foreign` (`order_no_doc`),
  KEY `sales_cc_debit_no_doc_foreign` (`debit_no_doc`),
  KEY `sales_cc_credit_no_doc_foreign` (`credit_no_doc`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_cc VALUES("1","1","2","0","0","0","FT-0001/2018","COT-0001/2018","1053","0","0","0","1","2018-01-22","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("2","2","4","0","0","0","FT-0002/2018","COT-0002/2018","87750","0","0","0","1","2018-01-22","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("3","3","6","0","0","0","FT-0003/2018","COT-0003/2018","105768","0","0","0","1","2018-01-26","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("4","1","8","0","0","0","FT-0004/2018","COT-0004/2018","10203.57","0","10203.57","0","1","2018-02-12","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("5","4","10","0","0","0","FT-0005/2018","COT-0005/2018","8271.9","0","0","0","1","2018-02-12","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("6","5","12","0","0","0","FT-0006/2018","COT-0006/2018","25580.88","0","25580.88","0","1","2018-02-12","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("7","3","19","0","0","0","FT-0007/2018","COT-0012/2018","18720","0","0","0","1","2018-02-13","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("13","1","2","5","0","0","RE-0004/2018"," COT-0001/2018","0","1053","0","4","1","2018-02-22","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("9","4","23","0","0","0","FT-0008/2018","COT-0015/2018","3931.2","0","0","0","1","2018-02-15","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("10","4","26","0","0","0","FT-0009/2018","COT-0017/2018","4176.9","0","0","0","1","2018-02-19","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("14","4","26","8","0","0","RE-0005/2018"," COT-0017/2018","0","16379.999999999998","0","2","1","2018-02-22","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("15","2","33","0","0","0","FT-0010/2018","COT-0023/2018","87750","0","0","0","1","2018-02-26","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("16","2","33","9","0","0","RE-0006/2018"," COT-0023/2018","0","87750","0","3","1","2018-03-02","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("17","3","36","0","0","0","FT-0011/2018","COT-0025/2018","55411.2","0","55411.2","0","1","2018-03-07","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("18","3","38","0","0","0","FT-0012/2018","COT-0026/2018","49644.04","0","49644.04","0","1","2018-03-07","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("19","3","40","0","0","0","FT-0013/2018","COT-0027/2018","48816.64","0","0","0","1","2018-03-08","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("20","3","40","10","0","0","RE-0007/2018"," COT-0027/2018","0","48816.64","0","4","1","2018-03-09","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("21","11","42","0","0","0","FT-0014/2018","COT-0028/2018","15444","0","0","0","1","2018-03-12","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("23","12","50","0","0","0","FT-0015/2018","COT-0034/2018","46355.4","0","23177.7","0","1","2018-03-21","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("24","12","50","11","0","0","RE-0008/2018"," COT-0034/2018","0","23177.7","0","3","1","2018-03-21","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("25","3","53","0","0","0","FT-0016/2018","COT-0036/2018","16497","0","0","0","1","2018-03-23","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("26","2","57","0","0","0","FT-0017/2018","COT-0038/2018","87750","0","0","0","1","2018-03-26","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("27","3","59","0","0","0","FT-0018/2018","COT-0039/2018","57847.93","0","57847.93","0","1","2018-03-26","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("28","3","6","12","0","0","RE-0009/2018"," COT-0003/2018","0","105768","0","4","1","2018-03-26","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("29","2","57","13","0","0","RE-0010/2018"," COT-0038/2018","0","87750","0","4","1","2018-03-29","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("30","11","42","14","0","0","RE-0011/2018"," COT-0028/2018","0","15444","0","4","1","2018-03-29","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("31","3","53","15","0","0","RE-0012/2018"," COT-0036/2018","0","16497","0","4","1","2018-04-04","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("32","17","76","0","0","0","FT-0019/2018","COT-0055/2018","12285","0","0","0","1","2018-04-13","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("33","17","76","16","0","0","RE-0013/2018"," COT-0055/2018","0","12285","0","4","1","2018-04-13","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("34","23","83","0","0","0","FT-0047/2017","COT-0061/2018","382363.02","0","382363.02","0","1","2017-09-12","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("35","23","83","0","0","2","NC-0001/2018","COT-0061/2018","0","21937.5","21937.5","0","0","2018-04-16","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("39","23","83","17","0","0","RE-0036/2017"," COT-0061/2018","0","305890.42","0","2","1","2017-09-12","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_cc VALUES("40","25","87","","","","FT-0021/2018","COT-0065/2018","58140","","0","","1","2018-04-23","","","");
INSERT INTO sales_cc VALUES("41","25","0","","","5","ND-0002/2018","","36270","","0","","1","2018-04-23","2018-04-23 14:47:07","2018-04-23 14:47:07","");
INSERT INTO sales_cc VALUES("42","25","0","","","3","NC-0002/2018","","26910","26910","0","","0","2018-04-23","2018-04-23 14:48:30","2018-04-23 14:48:30","");
INSERT INTO sales_cc VALUES("43","25","6","","","6","ND-0003/2018","","24570","","0","","1","2018-04-23","2018-04-23 14:49:34","2018-04-23 14:49:34","");
INSERT INTO sales_cc VALUES("44","15","55","","","","FT-0022/2018","COT-0037/2018","1170","","1170","","1","2018-03-23","","","");
INSERT INTO sales_cc VALUES("45","25","0","21","","","RE-0015/2018","  6","","92070","","2","1","2018-04-23","","","");
INSERT INTO sales_cc VALUES("46","25","91","","","","FT-0023/2018","COT-0066/2018","24570","","0","","1","2018-04-23","","","");
INSERT INTO sales_cc VALUES("47","25","0","","","4","NC-0003/2018","","2340","2340","0","","0","2018-04-23","2018-04-23 15:05:35","2018-04-23 15:05:35","");
INSERT INTO sales_cc VALUES("48","25","0","23","","","RE-0016/2018","  0","","23230","","2","1","2018-04-23","","","");
INSERT INTO sales_cc VALUES("49","25","0","24","","","RE-0017/2018","  0","","-1000","","2","1","2018-04-23","","","");
INSERT INTO sales_cc VALUES("50","25","93","","","","FT-0024/2018","COT-0067/2018","66570","","0","","1","2018-04-24","","","");
INSERT INTO sales_cc VALUES("51","25","93","25","","","RE-0018/2018","COT-0067/2018","","66570","","2","1","2018-04-24","","","");
INSERT INTO sales_cc VALUES("52","9","95","","","","FT-0025/2018","COT-0068/2018","26910","","26910","","1","2018-04-24","","","");
INSERT INTO sales_cc VALUES("53","8","0","","","5","NC-0004/2018","","25740","25740","25740","","0","2018-04-24","2018-04-24 07:55:03","2018-04-24 07:55:03","");
INSERT INTO sales_cc VALUES("54","3","0","","","7","ND-0004/2018","","25740","","25740","","1","2018-04-24","2018-04-24 07:56:39","2018-04-24 07:56:39","");
INSERT INTO sales_cc VALUES("56","3","97","","","","FT-0026/2018","COT-0069/2018","5323.5","","5323.5","","1","2018-04-24","","","");
INSERT INTO sales_cc VALUES("57","3","99","","","","FT-0027/2018","COT-0070/2018","5000","","5000","","1","2018-04-24","","","");





CREATE TABLE IF NOT EXISTS `sales_credito` (
  `credit_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `credito` double NOT NULL DEFAULT '0',
  `order_no_id` int(10) unsigned NOT NULL,
  `credit_date` date NOT NULL,
  `trans_type_credit` mediumint(9) NOT NULL,
  `debtor_no_credit` int(11) NOT NULL,
  `person_id_credit` int(11) NOT NULL,
  `reference_credit` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_reference_id_credit` int(11) NOT NULL DEFAULT '0',
  `order_reference_credit` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoice_type_credit` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `from_stk_loc` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_id_credit` mediumint(9) NOT NULL,
  `paid_amount_credit` double NOT NULL DEFAULT '0',
  `payment_term_credit` tinyint(4) NOT NULL DEFAULT '0',
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`credit_no`),
  KEY `sales_credito_order_no_id_foreign` (`order_no_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_credito VALUES("1","21937.5","82","2018-04-16","201","23","4","","0","","indirectOrder","PL","3","0","0","","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO sales_credito VALUES("2","21937.5","83","2018-04-16","202","23","4","NC-0001/2018","1","COT-0061/2018","directInvoice","PL","3","0","1","","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO sales_credito VALUES("3","26910","0","2018-04-23","201","25","2","NC-0002/2018","0","","directInvoice","PL","2","26910","1","","","");
INSERT INTO sales_credito VALUES("4","2340","0","2018-04-23","201","25","2","NC-0003/2018","0","","directInvoice","PL","2","2340","1","","","");
INSERT INTO sales_credito VALUES("5","25740","0","2018-04-24","201","8","2","NC-0004/2018","0","","directInvoice","PL","2","0","1","","","");





CREATE TABLE IF NOT EXISTS `sales_debito` (
  `debit_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `debito` double NOT NULL DEFAULT '0',
  `order_no_id` int(10) unsigned NOT NULL,
  `debit_date` date NOT NULL,
  `trans_type_debit` mediumint(9) NOT NULL,
  `debtor_no_debit` int(11) NOT NULL,
  `person_id_debit` int(11) NOT NULL,
  `reference_debit` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_reference_id_debit` int(11) NOT NULL DEFAULT '0',
  `order_reference_debit` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoice_type_debit` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `from_stk_loc` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_id_debit` mediumint(9) NOT NULL,
  `paid_amount_debit` double NOT NULL DEFAULT '0',
  `payment_term_debit` tinyint(4) NOT NULL DEFAULT '0',
  `comments` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`debit_no`),
  KEY `sales_debito_order_no_id_foreign` (`order_no_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_debito VALUES("7","25740","0","2018-04-24","201","3","2","ND-0004/2018","0","","directInvoice","PL","2","0","1","","","","");
INSERT INTO sales_debito VALUES("5","36270","0","2018-04-23","201","25","2","ND-0002/2018","0","","directInvoice","PL","2","36270","1","","","","");
INSERT INTO sales_debito VALUES("6","24570","88","2018-04-23","201","25","2","ND-0003/2018","0","","directInvoice","PL","2","24570","1","","","","");





CREATE TABLE IF NOT EXISTS `sales_details_vd` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vd_no` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `tax_type_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit_price` double NOT NULL DEFAULT '0',
  `quantity` double NOT NULL DEFAULT '0',
  `is_inventory` int(11) NOT NULL,
  `discount_percent` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE IF NOT EXISTS `sales_ge` (
  `ge_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reference_ge` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `total` double NOT NULL,
  `ge_date` date NOT NULL,
  `local_entrega` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `motorista` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `carta` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `matricula` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `debtor_no_ge` int(10) unsigned NOT NULL,
  `branch_id` int(11) NOT NULL,
  `comments` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ge_no`),
  KEY `sales_ge_debtor_no_ge_foreign` (`debtor_no_ge`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_ge VALUES("1","GE-0001/2018","24570","2018-04-24","Matola |Cidade","Joao Lorenco","11003023","AAA-BC-MC","4","4","","","");





CREATE TABLE IF NOT EXISTS `sales_ge_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ge_no_id` int(11) NOT NULL,
  `trans_type` mediumint(9) NOT NULL,
  `stock_id` varchar(30) NOT NULL,
  `tax_type_id` tinyint(4) NOT NULL,
  `description` varchar(255) NOT NULL,
  `unit_price` double NOT NULL DEFAULT '0',
  `qty_sent` double NOT NULL DEFAULT '0',
  `quantity` double NOT NULL DEFAULT '0',
  `is_inventory` double NOT NULL,
  `discount_percent` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO sales_ge_details VALUES("1","1","201","","4","Servico de traducao de documentos ","21000","0","1","1","0");





CREATE TABLE IF NOT EXISTS `sales_gt` (
  `gt_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reference_gt` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `total` double NOT NULL,
  `gt_date` date NOT NULL,
  `local_entrega` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `motorista` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `carta` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `matricula` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `debtor_no_gt` int(10) unsigned NOT NULL,
  `branch_id` int(11) NOT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`gt_no`),
  KEY `sales_gt_debtor_no_gt_foreign` (`debtor_no_gt`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_gt VALUES("1","GT-0001/2018","24570","2018-04-24","matola agaree","Joao Lorenco","","AAA-BC-MC","2","2","","","");





CREATE TABLE IF NOT EXISTS `sales_gt_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gt_no_id` int(11) NOT NULL,
  `trans_type` mediumint(9) NOT NULL,
  `stock_id` varchar(30) NOT NULL,
  `tax_type_id` tinyint(4) NOT NULL,
  `description` varchar(255) NOT NULL,
  `unit_price` double NOT NULL DEFAULT '0',
  `qty_sent` double NOT NULL DEFAULT '0',
  `quantity` double NOT NULL DEFAULT '0',
  `is_inventory` double NOT NULL,
  `discount_percent` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO sales_gt_details VALUES("1","1","201","00","4","Servico de traducao de documentos ","21000","0","1","1","0");





CREATE TABLE IF NOT EXISTS `sales_order_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `debit_no_id` int(11) DEFAULT NULL,
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
  `tipo_operacao` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sales_order_details_sales_debito_idx` (`debit_no_id`)
) ENGINE=MyISAM AUTO_INCREMENT=237 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_order_details VALUES("1","0","1","201","","4","Cartoes de visita, impressao 2 faces (Sr. Angelo Macassa)","18","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("2","0","2","202","","4","Cartoes de visita, impressao 2 faces (Sr. Angelo Macassa)","18","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("3","0","3","201","","4","Aluguer do Escitorio, referente ao mes de Fevereiro de 2018","75000","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("4","0","4","202","","4","Aluguer do Escitorio, referente ao mes de Fevereiro de 2018","75000","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("5","0","5","201","","4","Bolsas para manifesto 125x80mm com impressao uma cor","90.4","0","1000","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("6","0","6","202","","4","Bolsas para manifesto 125x80mm com impressao uma cor","90.4","0","1000","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("7","0","7","201","","4","Porta Brochuras executivo","8721","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("8","0","8","202","","4","Porta Brochuras executivo","8721","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("9","0","9","201","","4","Caixas de papel A4","1575","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("10","0","10","202","","4","Caixas de papel A4","1575","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("11","0","9","201","","4","Pastas de Arquivo Azuis 1450","210","0","12","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("12","0","10","202","","4","Pastas de Arquivo Azuis 1450","210","0","12","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("13","0","9","201","","4","Caixas de canetas BIC (azuis)","560","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("14","0","10","202","","4","Caixas de canetas BIC (azuis)","560","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("15","0","9","201","","4","Camisetes Polo M(vermelhas), com bordado ","420","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("16","0","10","202","","4","Camisetes Polo M(vermelhas), com bordado ","420","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("17","0","11","201","","4","Chaveiros com Lanterna no formato de capacete, e impressao a 2 cores","109.32","0","200","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("18","0","12","202","","4","Chaveiros com Lanterna no formato de capacete, e impressao a 2 cores","109.32","0","200","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("19","0","13","201","","4","Cartoes de visita, impressao frente e Verso e laminado","18","0","200","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("20","0","14","201","","4","Blocos de Nota com impressao a relevo uma face BF0104","683.86","0","300","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("21","0","14","201","","4","Blocos de Notas com impressao a relevo uma face BF0024","820.66","0","300","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("22","0","15","201","","4","Bolsas para Manifesto 125x80mm com impressao a uma cor","90.4","0","1000","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("23","0","15","201","","4","Bolsas para manifesto 125 x 80mm com impressao a uma cor","82.61","0","2000","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("24","0","16","201","","4","Camisete de Gola redonda, com bordado no peito e na manga a uma cor","442","0","25","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("25","0","16","201","","4","Bones Azuis com bordado uma face","234","0","25","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("26","0","17","201","","4","Camisete de gola redonda, com bordado no peito e manga a 1 cor","420","0","25","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("27","0","17","201","","4","Bone, com bordado uma face, a uma cor","220","0","25","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("28","0","18","201","","4","Camisete de gola redonda, com bordado no peito e manga a 1 cor","420","0","25","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("29","0","19","202","","4","Camisete de gola redonda, com bordado no peito e manga a 1 cor","420","0","25","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("30","0","18","201","","4","Bones Azuis com bordado uma face","220","0","25","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("31","0","19","202","","4","Bones Azuis com bordado uma face","220","0","25","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("32","0","20","201","","4","Fato Masculino(conjunto de calca e casaco)","4200","0","13","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("33","0","20","201","","4","Camisa de manga cumprida/ curta Masculina","1350","0","13","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("34","0","20","201","","4","Cintos Masculino","1100","0","13","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("35","0","20","201","","4","Sapatos Masculinos","2750","0","13","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("36","0","21","201","","4","Camisete Polo de Malha Superior, com bordado no peito","690","0","200","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("37","0","21","201","","4","Bone Preto, com bordado frontal","200","0","200","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("38","0","21","201","","4","Camisete Polo Preta, com Bordado no peito","420","0","200","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("39","0","22","201","","4","Camisetes Azul Claro, com bordado no peito a branco","420","0","8","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("40","0","23","202","","4","Camisetes Azul Claro, com bordado no peito a branco","420","0","8","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("41","0","24","201","","4","Vinil 2m x 40cm, formato oval,  fundo amarelo escrita vermelha","4300","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("42","0","24","201","","4","Cartoes de visita, impressos em 2 faces em papel glossy","21","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("43","0","24","201","","4","Cartoes de visita, impressos em 2 faces sem nome","18","0","200","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("44","0","24","201","","4","Camisas para Piloto brancas, com bordado no peito","1769.28","0","10","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("45","0","24","201","","4","Camisetes Polos Masculinas, com bordado no peito","420","0","4","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("46","0","24","201","","4","Calcas azuis escuras Masculinas","2830","0","4","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("47","0","24","201","","4","Folhetos A5, impressao uma face","13","0","1000","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("48","0","25","201","","4","Resma de Papel Timbrado","3500","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("49","0","26","202","","4","Resma de Papel Timbrado","3500","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("50","0","25","201","","4","Caixa de Clips Coloridos","70","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("51","0","26","202","","4","Caixa de Clips Coloridos","70","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("52","0","27","201","","4","Camisa Branca / Creme Feminina de manga curta com bordado no peito","1231.09","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("53","0","27","201","","4","Saia Azul escura ou Preta","1644.09","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("54","0","27","201","","4","Camisa Branca / Creme Masculina de manga curta com bordado no peito","1291.09","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("55","0","27","201","","4","Calcas Azuis Escuras/ Preta","2010","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("56","0","27","201","","4","Conjunto de Tunica e calca para servente","2565","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("57","0","27","201","","4","Conjunto de calca e camisa para motorista (tipo Balalaica)","2980","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("58","0","28","201","","4","Camisete Polo de malha superior Roly (preta), com bordado no peito","890","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("59","0","29","201","","4","Camisete Polo de malha superior Roly (preta), com bordado no peito","890","0","200","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("60","0","29","201","","4","Bones pretos com bordado uma face","200","0","200","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("61","0","30","201","","4","Camisete Polo, com bordado no peito","420","0","77","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("62","0","30","201","","4","Bone Lilas com detalhe branco e bordado HW028","193.2","0","77","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("63","0","31","201","","4","Camisete Polo, com bordado no peito (Lilaz)","420","0","77","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("64","0","31","201","","4","Bone Lilaz com detalhe branco e bordado  HW019","287.18","0","77","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("65","0","32","201","","4","Aluguer do Escritorio, referente ao mes de Marco","75000","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("66","0","33","202","","4","Aluguer do Escritorio, referente ao mes de Marco","75000","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("67","0","34","201","","4","Foto Feminino de Saia e Casaco Nr. 40 e 42","3890","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("68","0","34","201","","4","Fato Feminino de Calca e Casaco Nr. 40 e 42","3890","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("69","0","34","201","","4","Camisas / Blusas azul claro XL e XXL","1600","0","4","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("70","0","34","201","","4","Fato feminino de Saia e Casaco Nr. 34","3700","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("71","0","34","201","","4","Fato Feminino de Calca e Casaco Nr. 34","3700","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("72","0","34","201","","4","Camisa/ Blusa azul ceu tamanho M","1450","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("73","0","34","201","","4","Fato Feminino Saia e Casaco Nr. 46","4050","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("74","0","34","201","","4","Fato Feminino de Calca e Casaco Nr. 46","4050","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("75","0","34","201","","4","Camisa / Blusa azul ceu Nr. XXXL","1750","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("76","0","34","201","","4","Fatos Masculinos de Calca e Casaco (32 e 36)","4200","0","6","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("77","0","34","201","","4","Camisas Masculinas (M - XL) azul Claro","1600","0","6","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("78","0","34","201","","4","Gravatas com logotipo bordado","980","0","7","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("79","0","35","201","","4","Camisetes de Gola redonda, com 2 bordados (Peito e Mangas)","420","0","74","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("80","0","36","202","","4","Camisetes de Gola redonda, com 2 bordados (Peito e Mangas)","420","0","74","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("81","0","35","201","","4","Bones Azuis com bordado uma face","220","0","74","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("82","0","36","202","","4","Bones Azuis com bordado uma face","220","0","74","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("83","0","37","201","","4","Bone Lilaz com bordado uma face em branco","287.18","0","60","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("84","0","38","202","","4","Bone Lilaz com bordado uma face em branco","287.18","0","60","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("85","0","37","201","","4","Camisete Polo com bordado no peito e manga","420","0","60","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("86","0","38","202","","4","Camisete Polo com bordado no peito e manga","420","0","60","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("87","0","39","201","","4","Camisetes Polos com bordado no peito e na manga","420","0","59","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("88","0","40","202","","4","Camisetes Polos com bordado no peito e na manga","420","0","59","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("89","0","39","201","","4","Bone lilaz com bordado uma face, em branco","287.18","0","59","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("90","0","40","202","","4","Bone lilaz com bordado uma face, em branco","287.18","0","59","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("91","0","41","201","","4","Camisetes bordadas no Peito e Costas (Amarelas e Cinzentas)","480","0","15","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("92","0","42","202","","4","Camisetes bordadas no Peito e Costas (Amarelas e Cinzentas)","480","0","15","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("93","0","41","201","","4","Calcas para Operacionais, Cinzentas com logotipo no bolso lateral","1200","0","5","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("94","0","42","202","","4","Calcas para Operacionais, Cinzentas com logotipo no bolso lateral","1200","0","5","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("95","0","43","201","","4","Bolas anti-stress, com impressao uma face a uma cor","89.19","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("96","0","43","201","","4","Porta-comprimido, com 4 divisoes, impressao a uma cor, uma face","63.38","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("97","0","43","201","","4","Sacolas A4, em cartolina com impressao uma face","173.8","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("98","0","43","201","","4","Bolas anti-stress , com impressao duas faces a uma cor","123.9","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("99","0","43","201","","4","Porta comprimidos, com 4 divisoes impressao em 2 tampas diferentes a uma cor","98.59","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("100","0","43","201","","4","Sacolas A4, em c artolina com impressao em duas faces a uma cor","218.14","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("101","0","44","201","","4","Bolas anti-stress, com impressao uma face a uma cor","98.5","0","1000","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("102","0","45","202","","4","Bolas anti-stress, com impressao uma face a uma cor","98.5","0","1000","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("103","0","44","201","","4","Camisetes (t-shirts) de Gola redonda com impressao / bordado duas face","445","0","400","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("104","0","45","202","","4","Camisetes (t-shirts) de Gola redonda com impressao / bordado duas face","445","0","400","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("105","0","44","201","","4","Bones Azuis com bordado uma face","280","0","400","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("106","0","45","202","","4","Bones Azuis com bordado uma face","280","0","400","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("107","0","46","201","","4","Bolas anti-stress, com impressao duas faces a uma cor","123.9","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("108","0","46","201","","4","Sacolas A4, com impressao numa face a uma cor","173.8","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("109","0","46","201","","4","Porta-comprimidos , com 4 divisoes, impressao a uma cor, uma face","98.5","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("110","0","47","201","","4","Camisete Polo verde alface, com detalhe em branco, e bordados(peito e manga)","490","0","18","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("111","0","47","201","","4","Bone Verde e Branco HW007","295.5","0","18","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("112","0","48","201","","4","Vestidos azuis escuros, com bordado no peito","3800","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("113","0","48","201","","4","Blusas azuis de manga curta, com bordado no peito","1867.22","0","6","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("114","0","48","201","","4","Saias azuis escuras","1627.82","0","4","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("115","0","48","201","","4","Calcas  azuis escuras","1900","0","4","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("116","0","48","201","","4","Casaco Azul escuro","3900","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("117","0","48","201","","4","Camisola Azul escura, com bordado no peito","2394.04","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("118","0","49","201","","4","Sacolas A4, em kaki com impressao uma face, a uma cor","173.8","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("119","0","50","202","","4","Sacolas A4, em kaki com impressao uma face, a uma cor","173.8","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("120","0","49","201","","4","Bolas anti-stress, com impressao uma face a uma cor","123.9","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("121","0","50","202","","4","Bolas anti-stress, com impressao uma face a uma cor","123.9","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("122","0","49","201","","4","Porta-comprimidos, com 4 divisoes, impressao uma face ","98.5","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("123","0","50","202","","4","Porta-comprimidos, com 4 divisoes, impressao uma face ","98.5","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("124","0","51","201","","4","Poster hunter\'s, tamanho A1","926.1","0","3000","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("125","0","52","201","","4","Confeccao de Carteiras de Capulana ","2350","0","6","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("126","0","53","202","","4","Confeccao de Carteiras de Capulana ","2350","0","6","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("127","0","48","201","","4","Camisa de manga cumprida, com bordado no peito","1970","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("130","0","55","201","","4","Transporte","1000","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("131","0","56","201","","4","Aluguer do Escritorio, referente ao mes de Abril","75000","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("132","0","57","202","","4","Aluguer do Escritorio, referente ao mes de Abril","75000","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("133","0","58","201","","4","Blusas azuis de manga curta, com bordado  no peito","1867.22","0","6","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("134","0","59","202","","4","Blusas azuis de manga curta, com bordado  no peito","1867.22","0","6","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("135","0","58","201","","4","Saias  azuis escuras","1627.82","0","4","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("136","0","59","202","","4","Saias  azuis escuras","1627.82","0","4","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("137","0","58","201","","4","Calcas azuis escuras","1900","0","4","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("138","0","59","202","","4","Calcas azuis escuras","1900","0","4","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("139","0","58","201","","4","Camisola azul escura, com bordado no peito","2394.04","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("140","0","59","202","","4","Camisola azul escura, com bordado no peito","2394.04","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("141","0","58","201","","4","Casaco Azul escuro","3900","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("142","0","59","202","","4","Casaco Azul escuro","3900","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("143","0","58","201","","4","Camisa de manga cumprida, com bordado no peito","1970","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("144","0","59","202","","4","Camisa de manga cumprida, com bordado no peito","1970","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("145","0","58","201","","4","Vestidos Azuis escuros, com bordado no peito","3800","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("146","0","59","202","","4","Vestidos Azuis escuros, com bordado no peito","3800","0","2","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("147","0","60","201","","4","Roll up com base normal","5900","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("148","0","60","201","","4","Roll up com base executiva","7500","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("149","0","61","201","","4","Conjunto de 3 autocolantes para congelador","3900","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("150","0","62","201","","4","Conjunto de 3 autocolantes, para congelador","3500","0","3","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("151","0","64","201","","4","Camisa masculina (LO-CIT), com bordado no peito","1821.5","0","30","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("152","0","64","201","","4","Blusa Feminina(LL-JAS), com bordado no peito","2225.15","0","40","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("153","0","64","201","","4","Camisete Polo Feminina/ Masculina (L-PUL/PUL), com bordado no peito","1521.78","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("154","0","65","201","","4","Fitas para Cracha (LAN006), com impressao a uma cor","115.47","0","600","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("155","0","65","201","","4","Fitas para Cracha (LAN 213), com impressao a uma cor","169.4","0","600","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("156","0","65","201","","4","Fitas para Cracha (LAN724B), com impressao a uma cor","126.5","0","600","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("157","0","66","201","","4","BAG 20025, personalizada","378.92","0","600","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("158","0","66","201","","4","BAG 20006, personalizada","149.2","0","600","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("159","0","66","201","","4","BAG 20002, personalizada","203.4","0","600","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("160","0","67","201","","4","Porta - Cracha (CARD 309A)","17.99","0","600","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("161","0","67","201","","4","Porta - Cracha (CARD 310A)","17.99","0","600","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("162","0","68","201","","4","Bloco de Notas, com caneta (NOTE 10045)","233.99","0","600","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("163","0","68","201","","4","Bloco de Notas com caneta (NOTE 790)","275.99","0","600","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("164","0","68","201","","4","Bloco de Notas com Caneta (NOTE 10048)","238.8","0","600","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("165","0","69","201","","4","Camisete polo Brancas/ laranja, com bordado no peito","390","0","5","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("166","0","69","201","","4","Bones brancos/ laranja, com bordado frontal","220","0","5","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("167","0","69","201","","4","","0","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("168","0","70","201","","4","Pastas (FOLD003), com impressao a uma cor, uma face","2007.58","0","75","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("169","0","70","201","","4","Pastas (FOLD008), com impressao a uma cor, uma face","1298.98","0","75","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("170","0","71","201","","4","USB (Pen Drive 8 GB), com impressao  a cores","918.33","0","600","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("171","0","72","201","","4","Camisetes de gola redonda com 2 bordados/ Impressao (logotipo e 1 de Maio na manga)","420","0","430","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("172","0","72","201","","4","Camisete Polo (como gola), 2 bordados (peito e 1 de maio na manga)","460","0","430","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("173","0","73","201","","4","Camisete Polo (com gola), 2 bordados (peito, e 1 de Maio na manga)","460","0","430","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("174","0","74","201","","4","Camisete/ T-shirt de  gola redonda, com 2 bordados/ Impressao no peito e 1 de Maio na manga","420","0","430","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("175","0","75","201","","4","Conjunto de 3 autocolantes, para congelador","3500","0","3","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("176","0","76","202","","4","Conjunto de 3 autocolantes, para congelador","3500","0","3","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("177","0","77","201","","4","Camisete Polo, Masculino/ Feminino com bordado no peito e manga (PAG. 218/219)","852.68","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("178","0","77","201","","4","Bone, com bordado uma face","352.94","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("179","0","78","201","","4","Camisete Polo Masculina / Feminina, com bordado no peito e manga (Pg. 222/223)","1019.88","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("180","0","78","201","","4","Bone, com bordado uma face (Pg. 487 HW0004)","352.94","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("181","0","79","201","","4","Camisete Polo Executiva Feminina/ Masculina, com bordado no peito e manga (amostra da Medimoc) Pg. 300 e 301","2112.08","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("182","0","79","201","","4","Bone, com bordado uma face (Pg. 487 HW0004)","352.94","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("183","0","80","201","","4","Camisetes de Gola redonda, com impressao/ Bordado no peito do Logotipo","310","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("184","0","80","201","","4","Camisetes Polos, com impressao / Bordado no peito do logotipo","430","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("185","0","80","201","","4","Bones, com impressao / Bordado uma face","210","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("186","0","81","201","","4","Camisetes de gola redonda (t-shirt), com impressao / bordado uma face","310","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("187","0","81","201","","4","Bones, com bordado/ impressao uma face","210","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("188","0","82","201","","4","teste","1","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("189","0","83","202","","4","SALDO","326806","0","1","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("190","0","1","201","","4","Canetas com impressao","107","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("191","0","2","202","","4","Canetas com impressao","107","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("192","0","1","201","","4","Brochuras","268","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("193","0","2","202","","4","Brochuras","268","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("194","0","3","201","","4","Canetas com impressao ","107","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("195","0","4","202","","4","Canetas com impressao ","107","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("196","0","3","201","","4","Brochuras","268","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("197","0","4","202","","4","Brochuras","268","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("198","0","5","201","","4","Canetas com impressao","107","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("199","0","6","202","","4","Canetas com impressao","107","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("200","0","5","201","","4","Brochuras","268","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("201","0","6","202","","4","Brochuras","268","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("202","0","7","201","","4","Canetas com impressao","107","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("203","0","8","202","","4","Canetas com impressao","107","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("204","0","7","201","","4","Brochuras","268","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("205","0","8","202","","4","Brochuras","268","0","50","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("206","0","84","201","","4","Mantinhas (1,52 x 1,27), com bordado lateral","883.2","0","250","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("207","0","84","201","","4","Canecas, com impressao a uma cor, uma face ","331.08","0","250","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("208","0","85","201","","4","Camisete Polo BIZ 7107","1749.96","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("209","0","85","201","","4","Bone 808-BU","322.38","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("210","0","85","201","","4","Camisete Polo BIZ 4855","1672.83","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("211","0","85","201","","4","Camisete Polo BIZ 3602","1749.96","0","100","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("212","0","86","201","","4","Camisetes polos, com bordado 1 face","420","0","18","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("213","0","86","201","","4","Bones, com bordado uma face","210","0","18","0","0","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_order_details VALUES("214","","87","201","00","4","Servico de traducao de documentos ","21000","0","2","1","0","","","");
INSERT INTO sales_order_details VALUES("215","","87","201","zero","4","Sistema de gestao de stock","8547.0111111111","0","1","0","10","","","");
INSERT INTO sales_order_details VALUES("216","","88","202","00","4","Servico de traducao de documentos ","21000","0","2","1","0","","","");
INSERT INTO sales_order_details VALUES("217","","88","202","zero","4","Sistema de gestao de stock","8547.0111111111","0","1","0","10","","","");
INSERT INTO sales_order_details VALUES("218","","5","201","00","4","Servico de traducao de documentos ","21000","0","1","1","0","","","debito");
INSERT INTO sales_order_details VALUES("219","","5","201","zero","4","Montagem e selagem de documentos","10000","0","1","0","0","","","debito");
INSERT INTO sales_order_details VALUES("220","","3","201","00","4","Servico de traducao de documentos ","21000","0","1","1","0","","","credito");
INSERT INTO sales_order_details VALUES("221","","3","201","zero","4","Sistema de gestao de stock","2000","0","1","0","0","","","credito");
INSERT INTO sales_order_details VALUES("222","","6","201","00","4","Servico de traducao de documentos ","21000","0","1","1","0","","","debito");
INSERT INTO sales_order_details VALUES("223","","89","202","","4","Transporte","1000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("224","","91","202","00","4","Servico de traducao de documentos ","21000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("225","","4","201","zero","4","Pagamento da factura","2000","0","1","0","0","","","credito");
INSERT INTO sales_order_details VALUES("226","","93","202","00","4","Servico de traducao de documentos ","21000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("227","","93","202","00","4","Sistema de gestao de stock","1709.4","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("228","","93","202","00","4","Formacao PHP laravel 5.2","427.350375","0","80","0","0","","","");
INSERT INTO sales_order_details VALUES("229","","95","202","00","4","Servico de traducao de documentos ","21000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("230","","95","202","00","4","Nova cena ","2000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("231","","5","201","00","4","Servico de traducao de documentos ","21000","0","1","1","0","","","credito");
INSERT INTO sales_order_details VALUES("232","","5","201","zero","4","Olha a rapiz ","1000","0","1","0","0","","","credito");
INSERT INTO sales_order_details VALUES("233","","7","201","00","4","Servico de traducao de documentos ","21000","0","1","1","0","","","debito");
INSERT INTO sales_order_details VALUES("234","","7","201","zero","4","Servico de traducao de doc","1000","0","1","0","0","","","debito");
INSERT INTO sales_order_details VALUES("235","","97","202","","4","ser","4550","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("236","","99","202","","4","Gestao de bens ","427.35","0","10","0","0","","","");





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
  `status` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`order_no`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_orders VALUES("1","201","indirectOrder","1","1","4","COT-0001/2018","","0","","","2018-01-22","0","PL","4","1053","0","0","2018-02-12 13:14:27","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("2","202","directInvoice","1","1","4","FT-0001/2018","","1","COT-0001/2018","","2018-01-22","0","PL","4","1053","1053","3","2018-02-12 13:14:27","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("3","201","indirectOrder","2","2","4","COT-0002/2018","","0","","","2018-01-22","0","PL","3","87750","0","0","2018-02-12 13:16:38","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("4","202","directInvoice","2","2","4","FT-0002/2018","","3","COT-0002/2018","","2018-01-22","0","PL","3","87750","87750","1","2018-02-12 13:16:38","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("5","201","indirectOrder","3","3","4","COT-0003/2018","","0","","","2018-01-26","0","PL","4","105768","0","0","2018-02-12 13:23:17","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("6","202","directInvoice","3","3","4","FT-0003/2018","","5","COT-0003/2018","","2018-01-26","0","PL","4","105768","105768","1","2018-02-12 13:23:17","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("7","201","indirectOrder","1","1","4","COT-0004/2018","","0","","","2018-02-12","0","PL","4","10203.57","0","0","2018-02-12 13:29:13","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("8","202","directInvoice","1","1","4","FT-0004/2018","","7","COT-0004/2018","","2018-02-12","0","PL","4","10203.57","0","1","2018-02-12 13:29:13","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("9","201","indirectOrder","4","4","4","COT-0005/2018","","0","","","2018-02-12","0","PL","2","8271.9","0","0","2018-02-12 14:17:04","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("10","202","directInvoice","4","4","4","FT-0005/2018","","9","COT-0005/2018","","2018-02-12","0","PL","2","8271.9","8271.9","1","2018-02-12 14:17:04","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("11","201","indirectOrder","5","5","4","COT-0006/2018","","0","","","2018-02-12","0","PL","3","25580.88","0","0","2018-02-12 14:29:09","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("12","202","directInvoice","5","5","4","FT-0006/2018","","11","COT-0006/2018","","2018-02-12","0","PL","3","25580.88","0","1","2018-02-12 14:29:09","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("13","201","directOrder","1","1","4","COT-0007/2018","","0","","","2018-01-15","0","PL","2","4212","0","2","2018-02-12 18:59:07","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("14","201","directOrder","6","6","4","COT-0008/2018","","0","","","2018-01-15","0","PL","3","528086.52","0","2","2018-02-12 19:01:41","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("15","201","directOrder","3","3","4","COT-0009/2018","","0","","","2018-01-24","0","PL","2","299075.4","0","2","2018-02-12 19:04:45","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("16","201","directOrder","3","3","4","COT-0010/2018","","0","","","2018-02-07","0","PL","2","19773","0","2","2018-02-12 19:07:02","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("17","201","directOrder","3","3","4","COT-0011/2018","","0","","","2018-02-07","0","PL","4","18720","0","2","2018-02-12 19:09:03","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("18","201","indirectOrder","3","3","4","COT-0012/2018","","0","","","2018-02-13","0","PL","4","18720","0","0","2018-02-13 07:46:25","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("19","202","directInvoice","3","3","4","FT-0007/2018","","18","COT-0012/2018","","2018-02-13","0","PL","4","18720","18720","1","2018-02-13 07:46:25","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("20","201","directOrder","8","8","4","COT-0013/2018","","0","","Condicoes de Pagamento: 70% no acto de adjudicacao, e o remanescente apos entrega do material .                                                                                                                                              ","2018-02-13","0","PL","3","142974","0","2","2018-02-13 13:48:15","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("21","201","directOrder","9","9","4","COT-0014/2018","","0","","","2018-02-14","0","PL","3","306540","0","2","2018-02-14 14:05:28","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("22","201","indirectOrder","4","4","4","COT-0015/2018","","0","","","2018-02-15","0","PL","2","3931.2","0","0","2018-02-15 09:40:08","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("23","202","directInvoice","4","4","4","FT-0008/2018","","22","COT-0015/2018","","2018-02-15","0","PL","2","3931.2","3931.2","1","2018-02-15 09:40:08","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("24","201","directOrder","7","7","4","COT-0016/2018","","0","","","2018-02-16","0","PL","4","62820.58","0","2","2018-02-16 09:14:24","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("25","201","indirectOrder","4","4","4","COT-0017/2018","","0","","","2018-02-19","0","PL","2","4176.9","0","0","2018-02-19 07:51:44","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("26","202","directInvoice","4","4","4","FT-0009/2018","","25","COT-0017/2018","","2018-02-19","0","PL","2","4176.9","4176.9","1","2018-02-19 07:51:44","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("27","201","directOrder","10","10","4","COT-0018/2018","","0","","","2018-02-21","0","PL","2","13713.9","0","2","2018-02-21 06:26:37","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("28","201","directOrder","9","9","4","COT-0019/2018","","0","","","2018-02-21","0","PL","4","104130","0","2","2018-02-21 09:28:21","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("29","201","directOrder","9","9","4","COT-0020/2018","","0","","","2018-02-21","0","PL","3","255060","0","2","2018-02-21 12:06:24","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("30","201","directOrder","3","3","4","COT-0021/2018","","0","","","2018-02-22","0","PL","4","55243.19","0","2","2018-02-22 12:18:13","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("31","201","directOrder","3","3","4","COT-0022/2018","","0","","","2018-02-22","0","PL","4","63709.85","0","2","2018-02-22 12:22:14","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("32","201","indirectOrder","2","2","4","COT-0023/2018","","0","","","2018-02-26","0","PL","3","87750","0","0","2018-02-26 07:34:53","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("33","202","directInvoice","2","2","4","FT-0010/2018","","32","COT-0023/2018","","2018-02-26","0","PL","3","87750","87750","1","2018-02-26 07:34:53","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("34","201","directOrder","8","8","4","COT-0024/2018","","0","","","2018-02-27","0","PL","2","100058.4","0","2","2018-02-27 06:41:48","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("35","201","indirectOrder","3","3","4","COT-0025/2018","","0","","","2018-03-07","0","PL","4","55411.2","0","0","2018-03-07 08:36:42","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("36","202","directInvoice","3","3","4","FT-0011/2018","","35","COT-0025/2018","","2018-03-07","0","PL","4","55411.2","0","1","2018-03-07 08:36:42","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("37","201","indirectOrder","3","3","4","COT-0026/2018","","0","","","2018-03-07","0","PL","4","49644.04","0","0","2018-03-07 08:54:48","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("38","202","directInvoice","3","3","4","FT-0012/2018","","37","COT-0026/2018","","2018-03-07","0","PL","4","49644.04","0","1","2018-03-07 08:54:48","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("39","201","indirectOrder","3","3","4","COT-0027/2018","","0","","","2018-03-08","0","PL","4","48816.64","0","0","2018-03-08 12:05:53","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("40","202","directInvoice","3","3","4","FT-0013/2018","","39","COT-0027/2018","","2018-03-08","0","PL","4","48816.64","48816.64","1","2018-03-08 12:05:53","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("41","201","indirectOrder","11","11","4","COT-0028/2018","","0","","","2018-03-12","0","PL","2","15444","0","0","2018-03-12 08:13:57","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("42","202","directInvoice","11","11","4","FT-0014/2018","","41","COT-0028/2018","","2018-03-12","0","PL","2","15444","15444","1","2018-03-12 08:13:57","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("43","201","directOrder","12","12","4","COT-0029/2018","","0","","","2018-03-12","0","PL","4","89739","0","2","2018-03-12 17:48:53","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("48","201","directOrder","3","3","4","COT-0033/2018","","0","","","2018-03-21","0","PL","2","57847.93","0","2","2018-03-21 09:18:47","2018-03-23 08:58:26","","");
INSERT INTO sales_orders VALUES("47","201","directOrder","3","3","4","COT-0032/2018","","0","","","2018-03-20","0","PL","4","16542.63","0","2","2018-03-20 19:31:54","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("46","201","directOrder","12","12","4","COT-0031/2018","","0","","Condicoes de pagamento: 60% no acto de adjudicacao, e o remanescente apos entrega do material","2018-03-15","0","PL","4","46355.4","0","2","2018-03-15 12:52:19","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("55","201","directOrder","15","15","2","COT-0037/2018","","0","","","2018-03-23","0","PL","2","1170","0","2","2018-03-23 11:39:00","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("49","201","indirectOrder","12","12","4","COT-0034/2018","","0","","","2018-03-21","0","PL","3","46355.4","0","0","2018-03-21 12:57:40","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("50","202","directInvoice","12","12","4","FT-0015/2018","","49","COT-0034/2018","","2018-03-21","0","PL","3","46355.4","23177.7","1","2018-03-21 12:57:40","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("51","201","directOrder","13","13","4","COT-0035/2018","","0","","Tempo de Entrega: 10 dias uteis, apos pagamento do valor da adjudicacao  ","2018-03-23","0","PL","4","3250611","0","2","2018-03-23 07:44:07","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("52","201","indirectOrder","3","3","4","COT-0036/2018","","0","","","2018-03-23","0","PL","4","16497","0","0","2018-03-23 08:38:31","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("53","202","directInvoice","3","3","4","FT-0016/2018","","52","COT-0036/2018","","2018-03-23","0","PL","4","16497","16497","1","2018-03-23 08:38:31","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("56","201","indirectOrder","2","2","4","COT-0038/2018","","0","","","2018-03-26","0","PL","3","87750","0","0","2018-03-26 06:44:09","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("57","202","directInvoice","2","2","4","FT-0017/2018","","56","COT-0038/2018","","2018-03-26","0","PL","3","87750","87750","1","2018-03-26 06:44:09","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("58","201","indirectOrder","3","3","4","COT-0039/2018","","0","","","2018-03-26","0","PL","4","57847.93","0","0","2018-03-26 10:26:34","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("59","202","directInvoice","3","3","4","FT-0018/2018","","58","COT-0039/2018","","2018-03-26","0","PL","4","57847.93","0","1","2018-03-26 10:26:34","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("60","201","directOrder","16","16","4","COT-0040/2018","","0","","","2018-04-02","0","PL","2","15678","0","2","2018-04-02 08:41:20","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("61","201","directOrder","17","17","4","COT-0041/2018","","0","","Condicoes de Pagamento: 70% no acto de adjudicacao, e o remanescente apos entrega do material","2018-04-02","0","PL","2","4563","0","2","2018-04-02 13:33:43","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("62","201","directOrder","17","17","4","COT-0042/2018","","0","","","2018-04-03","0","PL","2","12285","0","2","2018-04-03 13:20:05","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("63","201","directOrder","18","18","4","COT-0043/2018","","0","","","2018-04-03","0","PL","2","346119.93","0","2","2018-04-03 13:42:04","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("64","201","directOrder","18","18","4","COT-0044/2018","","0","","","2018-04-03","0","PL","2","346119.93","0","2","2018-04-03 13:45:13","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("65","201","directOrder","18","18","4","COT-0045/2018","","0","","","2018-04-03","0","PL","2","288781.74","0","2","2018-04-03 13:51:14","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("66","201","directOrder","18","18","4","COT-0046/2018","","0","","","2018-04-04","0","PL","2","513527.04","0","2","2018-04-04 10:26:33","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("67","201","directOrder","18","18","4","COT-0047/2018","","0","","","2018-04-04","0","PL","2","25257.96","0","2","2018-04-04 12:10:28","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("68","201","directOrder","18","18","4","COT-0048/2018","","0","","","2018-04-04","0","PL","2","525643.56","0","2","2018-04-04 12:18:03","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("69","201","directOrder","19","19","4","COT-0049/2018","","0","","","2018-04-05","0","PL","2","3568.5","0","2","2018-04-05 09:59:07","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("70","201","directOrder","18","18","4","COT-0050/2018","","0","","","2018-04-05","0","PL","2","290150.65","0","2","2018-04-05 12:10:50","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("71","201","directOrder","18","18","4","COT-0051/2018","","0","","","2018-04-05","0","PL","2","644667.66","0","2","2018-04-05 19:17:48","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("72","201","directOrder","18","18","4","COT-0052/2018","","0","","Condicoes de Pagamento: 70% no acto de adjudicacao, e o remanescente apos entrega do material","2018-04-09","0","PL","2","442728","0","2","2018-04-09 16:21:08","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("73","201","directOrder","18","18","4","COT-0053/2018","","0","","Condicoes de Pagamento: 70% no acto de adjudicacao, e o remanescente apos entrega do material ","2018-04-09","0","PL","2","231426","0","2","2018-04-09 16:51:07","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("74","201","directOrder","18","18","4","COT-0054/2018","","0","","","2018-04-09","0","PL","2","211302","0","2","2018-04-09 16:53:05","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("75","201","indirectOrder","17","17","4","COT-0055/2018","","0","","","2018-04-13","0","PL","4","12285","0","0","2018-04-13 07:42:57","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("76","202","directInvoice","17","17","4","FT-0019/2018","","75","COT-0055/2018","","2018-04-13","0","PL","4","12285","12285","1","2018-04-13 07:42:57","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("77","201","directOrder","20","20","4","COT-0056/2018","","0","","","2018-04-13","0","PL","2","1410.58","0","2","2018-04-13 08:02:48","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("78","201","directOrder","20","20","4","COT-0057/2018","","0","","","2018-04-13","0","PL","2","1606.2","0","2","2018-04-13 08:09:07","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("79","201","directOrder","20","20","4","COT-0058/2018","","0","","","2018-04-13","0","PL","2","2884.07","0","2","2018-04-13 08:21:18","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("80","201","directOrder","21","21","4","COT-0059/2018","","0","","","2018-04-13","0","PL","2","55575","0","2","2018-04-13 09:05:12","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("81","201","directOrder","22","22","4","COT-0060/2018","","0","","","2018-04-13","0","PL","2","30420","0","2","2018-04-13 09:13:01","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("82","201","indirectOrder","23","23","2","COT-0061/2018","","0","","","2018-04-16","0","PL","2","1.17","0","0","2018-04-16 07:14:42","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("83","202","directInvoice","23","23","2","FT-0020/2018","","82","COT-0061/2018","","2018-04-16","0","PL","2","382363.02","1.17","1","2018-04-16 07:14:42","2018-04-16 13:05:41","","");
INSERT INTO sales_orders VALUES("84","201","directOrder","3","3","4","COT-0062/2018","","0","","","2018-04-17","0","PL","2","355176.9","0","2","2018-04-17 09:42:03","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("85","201","directOrder","6","6","4","COT-0063/2018","","0","","","2018-04-19","0","PL","2","642930.21","0","2","2018-04-19 13:55:46","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("86","201","directOrder","24","24","4","COT-0064/2018","","0","","","2018-04-20","0","PL","2","13267.8","0","2","2018-04-20 12:48:53","0000-00-00 00:00:00","","");
INSERT INTO sales_orders VALUES("87","201","directOrder","25","25","2","COT-0065/2018","","0","","","2018-04-23","0","PL","2","58140","0","2","2018-04-23 14:44:25","","","");
INSERT INTO sales_orders VALUES("88","202","directInvoice","25","25","2","FT-0021/2018","","87","COT-0065/2018","","2018-04-23","0","PL","2","58140","58140","2","2018-04-23 14:44:35","","","");
INSERT INTO sales_orders VALUES("89","202","directInvoice","15","15","2","FT-0022/2018","","55","COT-0037/2018","","2018-03-23","0","PL","2","1170","0","2","2018-04-23 14:50:46","","","");
INSERT INTO sales_orders VALUES("90","201","indirectOrder","25","25","2","COT-0066/2018","","0","","","2018-04-23","0","PL","2","24570","0","0","2018-04-23 15:05:02","","","");
INSERT INTO sales_orders VALUES("91","202","directInvoice","25","25","2","FT-0023/2018","","90","COT-0066/2018","","2018-04-23","0","PL","2","24570","24570","1","2018-04-23 15:05:02","","","");
INSERT INTO sales_orders VALUES("92","201","indirectOrder","25","25","2","COT-0067/2018","","0","","","2018-04-24","0","PL","2","66570","0","0","2018-04-24 07:21:29","","","");
INSERT INTO sales_orders VALUES("93","202","directInvoice","25","25","2","FT-0024/2018","","92","COT-0067/2018","","2018-04-24","0","PL","2","66570","66570","1","2018-04-24 07:21:29","","","");
INSERT INTO sales_orders VALUES("94","201","indirectOrder","9","9","2","COT-0068/2018","","0","","","2018-04-24","0","PL","2","26910","0","0","2018-04-24 07:52:21","","","");
INSERT INTO sales_orders VALUES("95","202","directInvoice","9","9","2","FT-0025/2018","","94","COT-0068/2018","","2018-04-24","0","PL","2","26910","0","1","2018-04-24 07:52:21","","","");
INSERT INTO sales_orders VALUES("96","201","indirectOrder","3","3","2","COT-0069/2018","","0","","","2018-04-24","0","PL","2","5323.5","0","0","2018-04-24 08:25:39","","","");
INSERT INTO sales_orders VALUES("97","202","directInvoice","3","3","2","FT-0026/2018","","96","COT-0069/2018","","2018-04-24","0","PL","2","5323.5","0","1","2018-04-24 08:25:39","","","");
INSERT INTO sales_orders VALUES("98","201","indirectOrder","3","3","2","COT-0070/2018","","0","","","2018-04-24","0","PL","2","5000","0","0","2018-04-24 08:35:05","","","");
INSERT INTO sales_orders VALUES("99","202","directInvoice","3","3","2","FT-0027/2018","","98","COT-0070/2018","","2018-04-24","0","PL","2","5000","0","1","2018-04-24 08:35:05","","","");





CREATE TABLE IF NOT EXISTS `sales_pending` (
  `idp` int(11) NOT NULL AUTO_INCREMENT,
  `debtor_no_pending` int(10) unsigned NOT NULL,
  `order_no_pending` int(10) unsigned NOT NULL,
  `reference_pending` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `amount_total_pending` double DEFAULT NULL,
  `amount_paid_pending` double NOT NULL DEFAULT '0',
  `ord_date_pending` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idp`),
  KEY `sales_pending_debtor_no_pending_foreign` (`debtor_no_pending`),
  KEY `sales_pending_order_no_pending_foreign` (`order_no_pending`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_pending VALUES("1","1","2","FT-0001/2018","1053","1053","2018-01-22","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("2","2","4","FT-0002/2018","87750","87750","2018-01-22","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("3","3","6","FT-0003/2018","105768","105768","2018-01-26","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("4","1","8","FT-0004/2018","10203.57","0","2018-02-12","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("5","4","10","FT-0005/2018","8271.9","8271.9","2018-02-12","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("6","5","12","FT-0006/2018","25580.88","0","2018-02-12","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("7","3","19","FT-0007/2018","18720","0","2018-02-13","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("8","4","23","FT-0008/2018","3931.2","3931.2","2018-02-15","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("9","4","26","FT-0009/2018","4176.9","4176.9","2018-02-19","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("10","2","33","FT-0010/2018","87750","87750","2018-02-26","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("11","3","36","FT-0011/2018","55411.2","0","2018-03-07","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("12","3","38","FT-0012/2018","49644.04","0","2018-03-07","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("13","3","40","FT-0013/2018","48816.64","48816.64","2018-03-08","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("14","11","42","FT-0014/2018","15444","15444","2018-03-12","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("16","12","50","FT-0015/2018","46355.4","23177.7","2018-03-21","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("17","3","53","FT-0016/2018","16497","16497","2018-03-23","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("18","2","57","FT-0017/2018","87750","87750","2018-03-26","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("19","3","59","FT-0018/2018","57847.93","0","2018-03-26","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("20","17","76","FT-0019/2018","12285","12285","2018-04-13","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("21","23","83","FT-0047/2017","382363.02","0","2017-09-12","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("22","23","83","NC-0001/2018","21937.5","0","2018-04-16","0000-00-00 00:00:00","0000-00-00 00:00:00","");
INSERT INTO sales_pending VALUES("23","25","0","ND-0002/2018","36270","36270","2018-04-23","2018-04-23 14:47:07","2018-04-23 14:47:07","");
INSERT INTO sales_pending VALUES("24","25","0","NC-0002/2018","26910","26910","2018-04-23","2018-04-23 14:48:30","2018-04-23 14:48:30","");
INSERT INTO sales_pending VALUES("25","25","88","ND-0003/2018","24570","24570","2018-04-23","2018-04-23 14:49:34","2018-04-23 14:49:34","");
INSERT INTO sales_pending VALUES("26","25","91","FT-0023/2018","24570","24570","2018-04-23","","","");
INSERT INTO sales_pending VALUES("27","25","0","NC-0003/2018","2340","2340","2018-04-23","2018-04-23 15:05:35","2018-04-23 15:05:35","");
INSERT INTO sales_pending VALUES("28","25","93","FT-0024/2018","66570","66570","2018-04-24","","","");
INSERT INTO sales_pending VALUES("29","9","95","FT-0025/2018","26910","0","2018-04-24","","","");
INSERT INTO sales_pending VALUES("30","8","0","NC-0004/2018","25740","0","2018-04-24","2018-04-24 07:55:03","2018-04-24 07:55:03","");
INSERT INTO sales_pending VALUES("31","3","0","ND-0004/2018","25740","0","2018-04-24","2018-04-24 07:56:39","2018-04-24 07:56:39","");
INSERT INTO sales_pending VALUES("33","3","97","FT-0026/2018","5323.5","0","2018-04-24","","","");
INSERT INTO sales_pending VALUES("34","3","99","FT-0027/2018","5000","0","2018-04-24","","","");





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





CREATE TABLE IF NOT EXISTS `sales_vd` (
  `vd_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `debtor_no_vd` int(11) NOT NULL,
  `account_no` int(11) NOT NULL,
  `reference_vd` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vd_date` date NOT NULL,
  `payment_id` mediumint(9) NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_vd` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`vd_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






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

INSERT INTO security_role VALUES("1","System Administrator","System Administrator","a:26:{s:8:\"category\";s:3:\"100\";s:4:\"unit\";s:3:\"600\";s:3:\"loc\";s:3:\"200\";s:4:\"item\";s:3:\"300\";s:4:\"user\";s:3:\"400\";s:4:\"role\";s:3:\"500\";s:8:\"customer\";s:3:\"700\";s:8:\"purchase\";s:3:\"900\";s:8:\"supplier\";s:4:\"1000\";s:7:\"payment\";s:4:\"1400\";s:6:\"backup\";s:4:\"1500\";s:5:\"email\";s:4:\"1600\";s:9:\"emailtemp\";s:4:\"1700\";s:10:\"preference\";s:4:\"1800\";s:3:\"tax\";s:4:\"1900\";s:10:\"currencies\";s:4:\"2100\";s:11:\"paymentterm\";s:4:\"2200\";s:13:\"paymentmethod\";s:4:\"2300\";s:14:\"companysetting\";s:4:\"2400\";s:10:\"iecategory\";s:4:\"2600\";s:7:\"expense\";s:4:\"2700\";s:7:\"deposit\";s:4:\"3000\";s:9:\"quotation\";s:4:\"2800\";s:7:\"invoice\";s:4:\"2900\";s:12:\"bank_account\";s:4:\"3100\";s:21:\"bank_account_transfer\";s:4:\"3200\";}","a:59:{s:7:\"cat_add\";s:3:\"101\";s:8:\"cat_edit\";s:3:\"102\";s:10:\"cat_delete\";s:3:\"103\";s:8:\"unit_add\";s:3:\"601\";s:9:\"unit_edit\";s:3:\"602\";s:11:\"unit_delete\";s:3:\"603\";s:7:\"loc_add\";s:3:\"201\";s:8:\"loc_edit\";s:3:\"202\";s:10:\"loc_delete\";s:3:\"203\";s:8:\"item_add\";s:3:\"301\";s:9:\"item_edit\";s:3:\"302\";s:11:\"item_delete\";s:3:\"303\";s:8:\"user_add\";s:3:\"401\";s:9:\"user_edit\";s:3:\"402\";s:11:\"user_delete\";s:3:\"403\";s:12:\"customer_add\";s:3:\"701\";s:13:\"customer_edit\";s:3:\"702\";s:15:\"customer_delete\";s:3:\"703\";s:12:\"purchase_add\";s:3:\"901\";s:13:\"purchase_edit\";s:3:\"902\";s:15:\"purchase_delete\";s:3:\"903\";s:12:\"supplier_add\";s:4:\"1001\";s:13:\"supplier_edit\";s:4:\"1002\";s:15:\"supplier_delete\";s:4:\"1003\";s:11:\"payment_add\";s:4:\"1401\";s:12:\"payment_edit\";s:4:\"1402\";s:14:\"payment_delete\";s:4:\"1403\";s:10:\"backup_add\";s:4:\"1501\";s:15:\"backup_download\";s:4:\"1502\";s:7:\"tax_add\";s:4:\"1901\";s:8:\"tax_edit\";s:4:\"1902\";s:10:\"tax_delete\";s:4:\"1903\";s:14:\"currencies_add\";s:4:\"2101\";s:15:\"currencies_edit\";s:4:\"2102\";s:17:\"currencies_delete\";s:4:\"2103\";s:15:\"paymentterm_add\";s:4:\"2201\";s:16:\"paymentterm_edit\";s:4:\"2202\";s:18:\"paymentterm_delete\";s:4:\"2203\";s:17:\"paymentmethod_add\";s:4:\"2301\";s:18:\"paymentmethod_edit\";s:4:\"2302\";s:20:\"paymentmethod_delete\";s:4:\"2303\";s:11:\"expense_add\";s:4:\"2701\";s:12:\"expense_edit\";s:4:\"2702\";s:14:\"expense_delete\";s:4:\"2703\";s:11:\"deposit_add\";s:4:\"3001\";s:12:\"deposit_edit\";s:4:\"3002\";s:14:\"deposit_delete\";s:4:\"3003\";s:13:\"quotation_add\";s:4:\"2801\";s:14:\"quotation_edit\";s:4:\"2802\";s:16:\"quotation_delete\";s:4:\"2803\";s:11:\"invoice_add\";s:4:\"2901\";s:12:\"invoice_edit\";s:4:\"2902\";s:14:\"invoice_delete\";s:4:\"2903\";s:16:\"bank_account_add\";s:4:\"3101\";s:17:\"bank_account_edit\";s:4:\"3102\";s:19:\"bank_account_delete\";s:4:\"3103\";s:25:\"bank_account_transfer_add\";s:4:\"3201\";s:26:\"bank_account_transfer_edit\";s:4:\"3202\";s:28:\"bank_account_transfer_delete\";s:4:\"3203\";}","0","2017-10-18 05:51:20","0000-00-00 00:00:00");





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

INSERT INTO stock_category VALUES("1","Default","1","0","2017-10-18 05:51:20","0000-00-00 00:00:00");
INSERT INTO stock_category VALUES("2","Hardware","1","0","2017-10-18 05:51:20","0000-00-00 00:00:00");
INSERT INTO stock_category VALUES("3","Health & Beauty","1","0","2017-10-18 05:51:20","0000-00-00 00:00:00");





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

INSERT INTO stock_master VALUES("A002","1","1","SOFTWARE N3 - PLANO BOOST","","Each","0","0");
INSERT INTO stock_master VALUES("STARTUP","1","1","SOFTWARE N3 - PLANO STARTUP","","Each","0","0");
INSERT INTO stock_master VALUES("BOOST","1","1","SOFTWARE N3 - PLANO BOOST","","Each","0","0");
INSERT INTO stock_master VALUES("RAYLITE","1","1","SOFTWARE N3 - PLANO BOOST - obra  de ex[ansao de armzem","","Each","0","0");
INSERT INTO stock_master VALUES("00","2","4","Servico de traducao de documentos ","","Each","0","0");





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
) ENGINE=MyISAM AUTO_INCREMENT=176 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO stock_moves VALUES("147","BOOST","220","202","PL","2018-01-18","2","COT-0002/2018","store_out_221","221","","-1","0");
INSERT INTO stock_moves VALUES("148","RAYLITE","220","202","PL","2018-01-18","2","COT-0002/2018","store_out_221","221","","-1","0");
INSERT INTO stock_moves VALUES("149","STARTUP","220","202","PL","2018-01-18","2","COT-0002/2018","store_out_221","221","","-1","0");
INSERT INTO stock_moves VALUES("150","A002","220","202","PL","2018-01-18","2","COT-0002/2018","store_out_221","221","","-1","0");
INSERT INTO stock_moves VALUES("151","A002","142","202","PL","2018-01-18","2","COT-0002/2018","store_out_143","143","","-1","0");
INSERT INTO stock_moves VALUES("152","A002","43","202","PL","2018-01-18","2","COT-0002/2018","store_out_44","44","","-1","0");
INSERT INTO stock_moves VALUES("153","RAYLITE","222","202","PL","2018-01-19","2","COT-0003/2018","store_out_223","223","","-1","0");
INSERT INTO stock_moves VALUES("154","BOOST","222","202","PL","2018-01-19","2","COT-0003/2018","store_out_223","223","","-1","0");
INSERT INTO stock_moves VALUES("155","STARTUP","222","202","PL","2018-01-19","2","COT-0003/2018","store_out_223","223","","-1","0");
INSERT INTO stock_moves VALUES("156","A002","222","202","PL","2018-01-19","2","COT-0003/2018","store_out_223","223","","-1","0");
INSERT INTO stock_moves VALUES("157","A002","224","202","PL","2018-01-19","2","COT-0004/2018","store_out_225","225","","-1","0");
INSERT INTO stock_moves VALUES("158","STARTUP","226","202","PL","2018-01-19","2","COT-0005/2018","store_out_227","227","","-1","0");
INSERT INTO stock_moves VALUES("159","BOOST","228","202","PL","2018-01-19","2","COT-0006/2018","store_out_229","229","","-1","0");
INSERT INTO stock_moves VALUES("160","RAYLITE","230","202","PL","2018-01-19","2","COT-0007/2018","store_out_231","231","","-1","0");
INSERT INTO stock_moves VALUES("161","A002","0","102","PL","2018-01-25","2","","store_in_24","24","","50","5000");
INSERT INTO stock_moves VALUES("162","A002","232","202","PL","2018-01-29","2","COT-0008/2018","store_out_233","233","","-1","0");
INSERT INTO stock_moves VALUES("163","STARTUP","234","202","PL","2018-02-02","2","COT-0009/2018","store_out_235","235","","-1","0");
INSERT INTO stock_moves VALUES("164","RAYLITE","234","202","PL","2018-02-02","2","COT-0009/2018","store_out_235","235","","-1","0");
INSERT INTO stock_moves VALUES("165","BOOST","234","202","PL","2018-02-02","2","COT-0009/2018","store_out_235","235","","-1","0");
INSERT INTO stock_moves VALUES("166","A002","236","202","PL","2018-02-04","4","COT-0010/2018","store_out_237","237","","-1","0");
INSERT INTO stock_moves VALUES("167","00","87","202","PL","2018-04-23","2","COT-0065/2018","store_out_88","88","","-2","21000");
INSERT INTO stock_moves VALUES("168","00","5","202","PL","0000-00-00","2","ND-0002/2018","store_out_5","0","","-1","0");
INSERT INTO stock_moves VALUES("172","00","92","202","PL","2018-04-24","2","COT-0067/2018","store_out_93","93","","-1","0");
INSERT INTO stock_moves VALUES("170","00","6","202","PL","0000-00-00","2","ND-0003/2018","store_out_6","0","","-1","0");
INSERT INTO stock_moves VALUES("171","00","90","202","PL","2018-04-23","2","COT-0066/2018","store_out_91","91","","-1","0");
INSERT INTO stock_moves VALUES("173","00","94","202","PL","2018-04-24","2","COT-0068/2018","store_out_95","95","","-1","0");
INSERT INTO stock_moves VALUES("174","00","5","202","PL","0000-00-00","2","","store_in_5","0","","1","0");
INSERT INTO stock_moves VALUES("175","00","7","202","PL","0000-00-00","2","ND-0004/2018","store_out_7","0","","-1","0");





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
  `nuit` int(9) NOT NULL,
  `country` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO suppliers VALUES("7","Compra Tudo","info@mstours.co.mz","C-19, Nilkanth Ro House Duplex, Near Dharnidhar Bunglows, Krishnanagar","","MAPUTO","","","400004021","MZ","0","2018-01-24 14:14:24","0000-00-00 00:00:00");





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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO users VALUES("4","","$2y$10$OzphZbQyUfGWsrnEFilJAO7KjkvGpBJhJUvwhAXxVcfDI91p3WREK","Marlene Coelho","2","847142865","marlenecoelho@grupom.co.mz","","0","CDyhfaWf3Kc07fd0F6eDIPgujevnmkOql22MqW72NciiJlfnnyzL5qGmLPKl","2018-02-04 19:46:41","2018-02-04 20:27:20");
INSERT INTO users VALUES("2","","$2y$10$GbgX0Z2DGHOJIWAkFbkXaOPGH1Fu8QBqktctseholx3RLlKHGM/Y6","demo","1","+8012654159","demo@n3.co.mz","","0","Zn2mqoVRmJ1sCYGJHFRdRVrjqpFXiE7yvDtS6pKTD7Po5SL0QobOmAsYe4i7","2017-12-30 01:14:15","2018-04-23 18:32:12");
INSERT INTO users VALUES("5","","$2y$10$EZ2wvynNxEQWOh2yBRPXneq395U53TSyS.8glk6dsEKkGNE8Cdcme","Contabilidade","2","823259020","contabilidade@grupom.co.mz","","0","CgKm1NTNm1xDu2sXqdzcBTv4fHabqEUBdWUDJZOLoAJYUuuWL9Ikjt9J8baC","2018-02-04 20:30:08","2018-02-04 20:33:24");




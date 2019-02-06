

CREATE TABLE IF NOT EXISTS `allocation_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `allocation_id` int(11) NOT NULL,
  `quantity` double NOT NULL,
  `unit_price` double NOT NULL,
  `tax_type_id` int(11) NOT NULL,
  `discount_percent` double NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO allocation_details VALUES("17","SAA","7","1","1500","2","5","2","","2018-03-09 01:14:29","");
INSERT INTO allocation_details VALUES("16","SM","7","1","25000","2","5","2","","2018-03-09 01:14:29","");
INSERT INTO allocation_details VALUES("15","SRP","7","1","45000","2","5","2","","2018-03-09 01:14:29","");
INSERT INTO allocation_details VALUES("18","SAA","8","1","1500","1","0","2","","2018-03-12 09:46:45","");
INSERT INTO allocation_details VALUES("19","SM","8","1","25000","1","0","2","","2018-03-12 09:46:45","");
INSERT INTO allocation_details VALUES("20","SRP","9","1","45000","1","0","2","","2018-03-13 07:27:56","");
INSERT INTO allocation_details VALUES("21","SAA","9","1","1500","1","0","2","","2018-03-13 07:27:56","");
INSERT INTO allocation_details VALUES("22","SM","10","1","25000","1","0","2","","2018-03-15 08:34:52","");
INSERT INTO allocation_details VALUES("23","SRP","10","1","45000","1","0","2","","2018-03-15 08:34:52","");
INSERT INTO allocation_details VALUES("24","SAA","11","1","1500","1","0","2","","2018-03-15 08:36:12","");
INSERT INTO allocation_details VALUES("25","SRP","11","1","45000","1","0","2","","2018-03-15 08:36:12","");
INSERT INTO allocation_details VALUES("26","SAA","12","1","1500","1","0","2","","2018-03-15 08:52:59","");
INSERT INTO allocation_details VALUES("27","SAA","13","1","1500","1","0","2","","2018-03-15 08:53:36","");
INSERT INTO allocation_details VALUES("28","11","14","1","500","3","10","2","","2018-03-16 08:37:10","");
INSERT INTO allocation_details VALUES("29","11","15","1","500","1","0","2","","2018-03-16 08:44:26","");





CREATE TABLE IF NOT EXISTS `allocations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `costumer_id` int(11) NOT NULL,
  `status` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `costumer_id_UNIQUE` (`costumer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO allocations VALUES("7","16","active","","2","","2018-03-09 01:14:29","");
INSERT INTO allocations VALUES("8","18","active","","2","","2018-03-12 09:46:45","");
INSERT INTO allocations VALUES("9","19","active","","2","","2018-03-13 07:27:56","");
INSERT INTO allocations VALUES("10","20","inactive","","2","","2018-03-15 12:57:09","");
INSERT INTO allocations VALUES("11","21","inactive","","2","","2018-03-15 12:57:09","");
INSERT INTO allocations VALUES("12","15","active","","2","","2018-03-15 08:52:58","");
INSERT INTO allocations VALUES("13","17","active","","2","","2018-03-15 08:53:36","");
INSERT INTO allocations VALUES("14","24","active","","2","","2018-03-16 08:37:10","");
INSERT INTO allocations VALUES("15","25","active","","2","","2018-03-16 08:44:26","");





CREATE TABLE IF NOT EXISTS `backup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO backup VALUES("1","2018-02-16-140230.sql","2018-02-16 14:02:30","");





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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO bank_accounts VALUES("5","4","Caixa","000000001","Local Banco","","0","0");
INSERT INTO bank_accounts VALUES("6","3","Banco Bim","0100102010","BIM","","1","0");





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
) ENGINE=MyISAM AUTO_INCREMENT=691 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO bank_trans VALUES("557","-603252","cash-in-by-sale","5","2018-03-08","2","","Supplier Payment","1","2","","2018-03-08 07:59:58");
INSERT INTO bank_trans VALUES("556","-140400","cash-in-by-sale","5","2018-03-08","2","","Supplier Payment","1","2","","2018-03-08 07:53:10");
INSERT INTO bank_trans VALUES("555","700000","deposit","5","2018-03-08","2","","Deposito do saldo Inicial na conta","1","1","","2018-03-08 07:49:41");
INSERT INTO bank_trans VALUES("558","44000","deposit","5","2018-03-12","2","","Deposito","1","2","","2018-03-12 08:10:04");
INSERT INTO bank_trans VALUES("559","11700","cash-in-by-sale","5","2018-03-12","2","","Payment for FT-0001/2018","1","2","","2018-03-12 08:30:06");
INSERT INTO bank_trans VALUES("602","-2018","cash-in-by-sale","5","2018-03-20","2","","Cancel VD VD-0001/2018","1","2","","2018-03-20 20:21:17");
INSERT INTO bank_trans VALUES("561","-485","cash-in-by-sale","5","2018-03-12","2","","Payment for NC-0001/2018","1","2","","2018-03-12 08:51:53");
INSERT INTO bank_trans VALUES("562","500","cash-in-by-sale","5","2018-03-12","2","","Payment for FT-0003/2018","1","2","","2018-03-12 12:38:09");
INSERT INTO bank_trans VALUES("563","500","cash-in-by-sale","5","2018-03-12","2","","Payment for ND-0004/2018","1","2","","2018-03-12 12:38:09");
INSERT INTO bank_trans VALUES("564","-250","cash-in-by-sale","5","2018-03-12","2","","Payment for NC-0003/2018","1","2","","2018-03-12 12:38:09");
INSERT INTO bank_trans VALUES("565","-125","cash-in-by-sale","5","2018-03-12","2","","Payment for NC-0003/2018","1","2","","2018-03-12 12:58:38");
INSERT INTO bank_trans VALUES("566","11700","cash-in-by-sale","5","2018-03-12","2","","Payment for FT-0002/2018","1","2","","2018-03-12 13:00:39");
INSERT INTO bank_trans VALUES("567","-11700","cash-in-by-sale","5","2018-03-12","2","","Payment for NC-0002/2018","1","2","","2018-03-12 13:00:39");
INSERT INTO bank_trans VALUES("568","500","cash-in-by-sale","5","2018-03-12","2","","Payment for FT-0004/2018","1","2","","2018-03-12 14:34:56");
INSERT INTO bank_trans VALUES("569","900","cash-in-by-sale","5","2018-03-12","2","","Payment for ND-0005/2018","1","2","","2018-03-12 14:34:56");
INSERT INTO bank_trans VALUES("570","-900","cash-in-by-sale","5","2018-03-12","2","","Payment for NC-0004/2018","1","2","","2018-03-12 14:34:56");
INSERT INTO bank_trans VALUES("571","200","cash-in-by-sale","5","2018-03-12","2","","Payment for FT-0004/2018","1","2","","2018-03-12 21:30:23");
INSERT INTO bank_trans VALUES("572","2000","cash-in-by-sale","5","2018-03-12","2","","Payment for ND-0006/2018","1","2","","2018-03-12 21:56:15");
INSERT INTO bank_trans VALUES("573","500","cash-in-by-sale","5","2018-03-13","2","","Payment for FT-0006/2018","1","2","","2018-03-12 22:35:02");
INSERT INTO bank_trans VALUES("574","1340","cash-in-by-sale","5","2018-03-13","2","","Payment for ND-0007/2018","1","2","","2018-03-12 22:35:02");
INSERT INTO bank_trans VALUES("575","-1469.29","cash-in-by-sale","5","2018-03-13","2","","Payment for NC-0006/2018","1","2","","2018-03-12 22:35:02");
INSERT INTO bank_trans VALUES("576","1000","cash-in-by-sale","5","2018-03-13","2","","Payment for ND-0007/2018","1","2","","2018-03-12 22:37:11");
INSERT INTO bank_trans VALUES("577","1925","cash-in-by-sale","5","2018-03-13","2","","Payment for FT-0009/2018","1","2","","2018-03-13 08:30:57");
INSERT INTO bank_trans VALUES("578","1170","cash-in-by-sale","5","2018-03-13","2","","Payment for ND-0008/2018","1","2","","2018-03-13 08:30:57");
INSERT INTO bank_trans VALUES("579","1340","cash-in-by-sale","5","2018-03-13","2","","Payment for FT-0010/2018","1","2","","2018-03-13 09:01:30");
INSERT INTO bank_trans VALUES("580","1170","cash-in-by-sale","5","2018-03-13","2","","Payment for ND-0009/2018","1","2","","2018-03-13 09:01:30");
INSERT INTO bank_trans VALUES("581","-2340","cash-in-by-sale","5","2018-03-13","2","","Payment for NC-0008/2018","1","2","","2018-03-13 09:01:30");
INSERT INTO bank_trans VALUES("582","300","cash-in-by-sale","5","2018-03-13","2","","Payment for FT-0004/2018","1","2","","2018-03-13 13:08:54");
INSERT INTO bank_trans VALUES("583","100","cash-in-by-sale","5","2018-03-13","2","","Payment for ND-0005/2018","1","2","","2018-03-13 13:08:54");
INSERT INTO bank_trans VALUES("584","-100","cash-in-by-sale","5","2018-03-13","2","","Payment for NC-0004/2018","1","2","","2018-03-13 13:08:54");
INSERT INTO bank_trans VALUES("585","300","cash-in-by-sale","5","2018-03-13","2","","Payment for FT-0004/2018","1","2","","2018-03-13 13:09:10");
INSERT INTO bank_trans VALUES("586","100","cash-in-by-sale","5","2018-03-13","2","","Payment for ND-0005/2018","1","2","","2018-03-13 13:09:10");
INSERT INTO bank_trans VALUES("587","-100","cash-in-by-sale","5","2018-03-13","2","","Payment for NC-0004/2018","1","2","","2018-03-13 13:09:10");
INSERT INTO bank_trans VALUES("588","1000","cash-in-by-sale","5","2018-03-13","2","","Payment for FT-0009/2018","1","2","","2018-03-13 13:10:03");
INSERT INTO bank_trans VALUES("589","-2000","cash-in-by-sale","5","2018-03-13","2","","Payment for NC-0007/2018","1","2","","2018-03-13 13:10:03");
INSERT INTO bank_trans VALUES("590","-1170","cash-in-by-sale","5","2018-03-13","2","","Payment for NC-0009/2018","1","2","","2018-03-13 13:10:03");
INSERT INTO bank_trans VALUES("591","-62010","cash-in-by-sale","5","2018-03-14","2","","Supplier Payment","1","2","","2018-03-14 14:05:59");
INSERT INTO bank_trans VALUES("592","42886.29","deposit","5","2018-03-15","2","","Deposito do caixa com objectivo de zerar","1","1","","2018-03-15 08:30:46");
INSERT INTO bank_trans VALUES("593","100000","deposit","5","2018-03-15","2","","Deposito do saldo para inicio das actividades","1","1","","2018-03-15 08:33:07");
INSERT INTO bank_trans VALUES("594","-15000","expense","5","2018-03-15","2","","Pagamento do salario da Leia","3","2","","2018-03-15 08:34:37");
INSERT INTO bank_trans VALUES("595","14360","cash-in-by-sale","5","2018-03-15","2","","Payment for FT-0012/2018","1","2","","2018-03-15 13:35:38");
INSERT INTO bank_trans VALUES("596","-5850","cash-in-by-sale","5","2018-03-15","2","","Payment for NC-0010/2018","1","2","","2018-03-15 13:35:38");
INSERT INTO bank_trans VALUES("597","30420","cash-in-by-sale","5","2018-03-15","2","","Payment for FT-0013/2018","1","2","","2018-03-15 13:39:37");
INSERT INTO bank_trans VALUES("598","10000","cash-in-by-sale","5","2018-03-15","2","","Payment for ND-0010/2018","1","2","","2018-03-15 13:39:37");
INSERT INTO bank_trans VALUES("599","1700","cash-in-by-sale","5","2018-03-15","2","","Payment for ND-0010/2018","1","2","","2018-03-15 13:45:26");
INSERT INTO bank_trans VALUES("600","-300","cash-in-by-sale","5","2018-03-15","2","","Payment for NC-0005/2018","1","2","","2018-03-15 21:30:08");
INSERT INTO bank_trans VALUES("601","500","cash-in-by-sale","5","2018-03-20","2","","Payment for VD-0001/2018","1","2","","2018-03-20 14:19:43");
INSERT INTO bank_trans VALUES("603","-410000","cash-in-by-sale","5","2018-03-20","2","","Supplier Payment","1","2","","2018-03-20 20:36:50");
INSERT INTO bank_trans VALUES("624","2500","cash-in-by-sale","6","2018-03-21","2","","Payment for VD-0007/2018","1","2","","2018-03-21 09:04:56");
INSERT INTO bank_trans VALUES("615","-10000","cash-in-by-sale","5","2018-03-20","2","","Cancel VD VD-0004/2018","1","2","","2018-03-21 08:18:38");
INSERT INTO bank_trans VALUES("606","2000","cash-in-by-sale","5","2018-03-20","2","","Payment for VD-0003/2018","1","2","","2018-03-20 20:41:57");
INSERT INTO bank_trans VALUES("607","-2018","cash-in-by-sale","5","2018-03-20","2","","Cancel VD VD-0003/2018","1","2","","2018-03-20 20:48:15");
INSERT INTO bank_trans VALUES("608","-2018","cash-in-by-sale","5","2018-03-20","2","","Cancel VD VD-0003/2018","1","2","","2018-03-20 20:48:26");
INSERT INTO bank_trans VALUES("609","10000","cash-in-by-sale","5","2018-03-20","2","","Payment for VD-0004/2018","1","2","","2018-03-20 20:50:41");
INSERT INTO bank_trans VALUES("610","7500","cash-in-by-sale","5","2018-03-20","2","","Payment for VD-0005/2018","1","2","","2018-03-20 20:59:33");
INSERT INTO bank_trans VALUES("611","-2018","cash-in-by-sale","5","2018-03-20","2","","Cancel VD VD-0005/2018","1","2","","2018-03-20 20:59:43");
INSERT INTO bank_trans VALUES("612","-380000","cash-in-by-sale","5","2018-03-20","2","","Supplier Payment","1","2","","2018-03-20 21:00:42");
INSERT INTO bank_trans VALUES("613","64350","cash-in-by-sale","5","2018-03-20","2","","Payment for VD-0006/2018","1","2","","2018-03-20 21:02:19");
INSERT INTO bank_trans VALUES("614","-2018","cash-in-by-sale","5","2018-03-20","2","","Cancel VD VD-0006/2018","1","2","","2018-03-20 21:03:07");
INSERT INTO bank_trans VALUES("617","576580","deposit","5","2018-03-21","2","","Deposito do valor ","1","1","","2018-03-21 08:29:51");
INSERT INTO bank_trans VALUES("618","576580","deposit","5","2018-03-21","2","","Deposito do valor ","1","1","","2018-03-21 08:29:52");
INSERT INTO bank_trans VALUES("619","0","cash-in","6","2018-03-21","2","opening balance","opening balance","1","1","","0000-00-00 00:00:00");
INSERT INTO bank_trans VALUES("625","-2500","cash-in-by-sale","6","2018-03-21","2","","Cancel VD VD-0007/2018","1","2","","2018-03-21 09:05:33");
INSERT INTO bank_trans VALUES("623","-2000","cash-in-by-sale","5","2018-03-20","2","","Cancel VD VD-0003/2018","1","2","","2018-03-21 09:03:34");
INSERT INTO bank_trans VALUES("627","500","cash-in-by-sale","6","2018-03-22","2","","Payment for FT-0003/2018","1","2","","2018-03-22 13:31:54");
INSERT INTO bank_trans VALUES("628","500","cash-in-by-sale","6","2018-03-22","2","","Payment for ND-0004/2018","1","2","","2018-03-22 13:31:54");
INSERT INTO bank_trans VALUES("629","184","cash-in-by-sale","6","2018-03-22","2","","Payment for FT-0017/2018","1","2","","2018-03-22 13:33:43");
INSERT INTO bank_trans VALUES("630","1750","cash-in-by-sale","6","2018-03-22","2","","Payment for ND-0011/2018","1","2","","2018-03-22 13:33:43");
INSERT INTO bank_trans VALUES("631","201","cash-in-by-sale","5","2018-03-22","2","FT-0017/2018 ","Payment for FT-0017/2018","1","2","","2018-03-22 13:36:19");
INSERT INTO bank_trans VALUES("632","750","cash-in-by-sale","5","2018-03-22","2","ND-0011/2018 ","Payment for ND-0011/2018","1","2","","2018-03-22 13:36:19");
INSERT INTO bank_trans VALUES("633","750","cash-in-by-sale","5","2018-03-22","2","ND-0011/2018 ","Payment for ND-0011/2018","1","2","","2018-03-22 13:36:19");
INSERT INTO bank_trans VALUES("634","8195","cash-in-by-sale","5","2018-03-23","2","FT-0015/2018 ","Payment for FT-0015/2018","1","2","","2018-03-23 08:30:32");
INSERT INTO bank_trans VALUES("635","1000","cash-in-by-sale","5","2018-03-23","2","FT-0015/2018 ","Payment for FT-0015/2018","1","2","","2018-03-23 08:33:19");
INSERT INTO bank_trans VALUES("636","170","cash-in-by-sale","5","2018-03-23","2","FT-0005/2018 ","Payment for FT-0005/2018","1","2","","2018-03-23 09:07:53");
INSERT INTO bank_trans VALUES("637","140","cash-in-by-sale","5","2018-03-23","2","ND-0006/2018 ","Payment for ND-0006/2018","1","2","","2018-03-23 09:07:53");
INSERT INTO bank_trans VALUES("638","-100","cash-in-by-sale","5","2018-03-23","2","NC-0005/2018 ","Payment for NC-0005/2018","1","2","","2018-03-23 09:07:53");
INSERT INTO bank_trans VALUES("639","340","cash-in-by-sale","5","2018-03-23","2","FT-0005/2018 ","Payment for FT-0005/2018","1","2","","2018-03-23 09:32:50");
INSERT INTO bank_trans VALUES("640","20","cash-in-by-sale","5","2018-03-23","2","ND-0006/2018 ","Payment for ND-0006/2018","1","2","","2018-03-23 09:32:50");
INSERT INTO bank_trans VALUES("641","-10","cash-in-by-sale","5","2018-03-23","2","NC-0005/2018 ","Payment for NC-0005/2018","1","2","","2018-03-23 09:32:50");
INSERT INTO bank_trans VALUES("642","500","cash-in-by-sale","5","2018-03-23","2","RE-0026/2018","Payment for FT-0006/2018","1","2","","2018-03-23 09:38:40");
INSERT INTO bank_trans VALUES("643","1000","cash-in-by-sale","6","2018-03-23","2","RE-0027/2018","Payment for FT-0005/2018","1","2","","2018-03-23 09:40:17");
INSERT INTO bank_trans VALUES("644","500","cash-in-by-sale","6","2018-03-23","2","RE-0028/2018","Payment for FT-0005/2018","1","2","","2018-03-23 09:40:48");
INSERT INTO bank_trans VALUES("645","500","cash-in-by-sale","5","2018-03-23","2","RE-0029/2018","Payment for FT-0005/2018","1","2","","2018-03-23 09:41:23");
INSERT INTO bank_trans VALUES("646","90","cash-in-by-sale","6","2018-03-23","2","RE-0030/2018","Payment for FT-0005/2018","1","2","","2018-03-23 09:47:16");
INSERT INTO bank_trans VALUES("647","10","cash-in-by-sale","6","2018-03-23","2","RE-0030/2018","Payment for ND-0006/2018","1","2","","2018-03-23 09:47:16");
INSERT INTO bank_trans VALUES("648","-10","cash-in-by-sale","6","2018-03-23","2","RE-0030/2018","Payment for NC-0005/2018","1","2","","2018-03-23 09:47:16");
INSERT INTO bank_trans VALUES("649","200","cash-in-by-sale","5","2018-03-23","2","RE-0031/2018","Payment for FT-0017/2018","1","2","","2018-03-23 11:26:42");
INSERT INTO bank_trans VALUES("650","650","cash-in-by-sale","5","2018-03-23","2","RE-0032/2018","Payment for FT-0019/2018","1","2","","2018-03-23 14:37:06");
INSERT INTO bank_trans VALUES("651","650","cash-in-by-sale","6","2018-03-23","2","RE-0033/2018","Payment for FT-0019/2018","1","2","","2018-03-23 14:41:42");
INSERT INTO bank_trans VALUES("652","1510","cash-in-by-sale","6","2018-03-23","2","RE-0033/2018","Payment for ND-0011/2018","1","2","","2018-03-23 14:41:42");
INSERT INTO bank_trans VALUES("653","-308295","cash-in-by-sale","5","2018-04-02","2","","Supplier Payment","1","2","","2018-04-02 13:09:27");
INSERT INTO bank_trans VALUES("654","10000","cash-in-by-sale","6","2018-04-02","2","RE-0034/2018","Payment for FT-0020/2018","1","2","","2018-04-02 13:33:48");
INSERT INTO bank_trans VALUES("655","3084","cash-in-by-sale","6","2018-04-02","2","RE-0034/2018","Payment for ND-0012/2018","1","2","","2018-04-02 13:33:48");
INSERT INTO bank_trans VALUES("656","-2000","cash-in-by-sale","6","2018-04-02","2","RE-0034/2018","Payment for NC-0011/2018","1","2","","2018-04-02 13:33:48");
INSERT INTO bank_trans VALUES("657","25000","cash-in-by-sale","6","2018-04-02","2","RE-0035/2018","Payment for FT-0020/2018","1","2","","2018-04-02 13:37:47");
INSERT INTO bank_trans VALUES("658","3042","cash-in-by-sale","6","2018-04-02","2","RE-0035/2018","Payment for ND-0012/2018","1","2","","2018-04-02 13:37:47");
INSERT INTO bank_trans VALUES("659","-2000","cash-in-by-sale","6","2018-04-02","2","RE-0035/2018","Payment for NC-0011/2018","1","2","","2018-04-02 13:37:47");
INSERT INTO bank_trans VALUES("668","49450","cash-in-by-sale","6","2018-04-02","2","","Payment for VD-0009/2018","1","2","","2018-04-02 13:55:06");
INSERT INTO bank_trans VALUES("667","-4680","cash-in-by-sale","6","2018-04-02","2","","Cancel VD VD-0008/2018","1","2","","2018-04-02 13:53:33");
INSERT INTO bank_trans VALUES("666","4680","cash-in-by-sale","6","2018-04-02","2","","Payment for VD-0008/2018","1","2","","2018-04-02 13:52:53");
INSERT INTO bank_trans VALUES("669","-49450","cash-in-by-sale","6","2018-04-02","2","","Cancel VD VD-0009/2018","1","2","","2018-04-02 13:56:29");
INSERT INTO bank_trans VALUES("670","-27970","cash-in-by-sale","6","2018-04-02","2","","Supplier Payment","1","2","","2018-04-02 14:06:39");
INSERT INTO bank_trans VALUES("671","-20000","cash-in-by-sale","6","2018-04-02","2","","Supplier Payment","1","2","","2018-04-02 14:10:59");
INSERT INTO bank_trans VALUES("672","9000","cash-in-by-sale","6","2018-04-02","2","RE-0036/2018","Payment for FT-0015/2018","1","2","","2018-04-02 19:45:07");
INSERT INTO bank_trans VALUES("673","-22000","cash-in-by-sale","6","2018-04-02","2","","Supplier Payment","1","2","","2018-04-02 19:57:30");
INSERT INTO bank_trans VALUES("674","-12100","cash-in-by-sale","6","2018-04-02","2","","Supplier Payment","1","2","","2018-04-02 20:06:45");
INSERT INTO bank_trans VALUES("675","-12100","cash-in-by-sale","6","2018-04-02","2","","Supplier Payment","1","2","","2018-04-02 20:09:22");
INSERT INTO bank_trans VALUES("681","150","cash-in-by-sale","6","2018-04-04","2","RE-0037/2018","Payment for FT-0004/2018","1","2","","2018-04-04 14:19:56");
INSERT INTO bank_trans VALUES("682","100","cash-in-by-sale","6","2018-04-04","2","RE-0037/2018","Payment for ND-0005/2018","1","2","","2018-04-04 14:19:56");
INSERT INTO bank_trans VALUES("683","-100","cash-in-by-sale","6","2018-04-04","2","RE-0037/2018","Payment for NC-0004/2018","1","2","","2018-04-04 14:19:56");
INSERT INTO bank_trans VALUES("684","270","cash-in-by-sale","6","2018-04-04","2","RE-0037/2018","Payment for FT-0017/2018","1","2","","2018-04-04 14:19:56");
INSERT INTO bank_trans VALUES("685","1005","cash-in-by-sale","6","2018-04-04","2","RE-0037/2018","Payment for ND-0014/2018","1","2","","2018-04-04 14:19:56");
INSERT INTO bank_trans VALUES("686","1000","cash-in-by-sale","5","2018-04-18","2","RE-0038/2018","Payment for FT-0036/2018","1","2","","2018-04-18 06:53:54");
INSERT INTO bank_trans VALUES("687","2000","cash-in-by-sale","5","2018-04-18","2","RE-0038/2018","Payment for FT-0040/2018","1","2","","2018-04-18 06:53:54");
INSERT INTO bank_trans VALUES("688","58020","cash-in-by-sale","5","2018-04-18","2","RE-0038/2018","Payment for FT-0048/2018","1","2","","2018-04-18 06:53:54");
INSERT INTO bank_trans VALUES("689","10","cash-in-by-sale","5","2018-04-18","2","RE-0038/2018","Payment for FT-0061/2018","1","2","","2018-04-18 06:53:54");
INSERT INTO bank_trans VALUES("690","6000","cash-in-by-sale","5","2018-04-18","2","RE-0039/2018","Payment for FT-0069/2018","1","2","","2018-04-18 12:41:55");





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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO currency VALUES("1","USD","$");
INSERT INTO currency VALUES("3","Metical","MT");





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
  `imposto` int(11) NOT NULL,
  `discounto` double NOT NULL,
  PRIMARY KEY (`branch_code`)
) ENGINE=MyISAM AUTO_INCREMENT=163 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO cust_branch VALUES("15","15","Mozal S.A.R.L","","","Av de Mocambique nr 3011","Cidade Maputo","Cidade de Maputo","1110","10002323","MZ","","","","","","0","30");
INSERT INTO cust_branch VALUES("17","17","Novo CL ","","","Av de Mocambique nr 3016","Cidade de Maputo","","","5676887","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("18","18","Assane Obadias Junior","","","Matola Agare","Cidade da Beira","Maputo City","1001","400129393","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("19","19","Minerva Central","","","Av. Samora Machel nr 3001 RC 04","Cidade","Cidade de Maputo","100","23232323","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("20","20","Update customer","","","Av de mocambique 2023. Mavalene B","Cidade de Maputo","Maputo City","10008","400023232","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("21","21","Julio","","","Zimpeto","Cidade de Maputo","Cidade de Maputo","","400023232","MZ","Zimpeto","Cidade de Maputo","Cidade de Maputo","","MZ","0","0");
INSERT INTO cust_branch VALUES("22","22","Luisa SA","","","Mavalane B","Cidade de Maputo","Maputo City","10008","4000334","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("23","23","Nome","","","8209021212","Cidade de Maputo","","","8902020","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("24","24","Leia Customer","","","Hulene B","Cidade de Maputo","8430391233","","400012884","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("25","25","Alberto","","","Hulene B","Cidade de Maputo","Maputo City","490011","82299992","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("1","99","Malo","Malhazine","","Matola H","Cidade de Maputo","Maputo Cidade","1020302","40023232","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("60","90","","","","","","","","4000","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("61","29","Alberto Matsinhe","","","","","","","4009232","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("62","30","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("63","31","Ordela Joaquim","","","Matola ","Cidade de Maputo","Cidade de Maputo","20002","777777777","MZ","","","","","","0","9");
INSERT INTO cust_branch VALUES("64","32","Alberto Matsinhe","","","","","","","40016723","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("65","33","Alberto Jorge Matsinhe","","","Hulene B","Cidade de Mapuot","Maputo Cidade","2000","400023232","MZ","","","","","","0","12.9");
INSERT INTO cust_branch VALUES("66","34","Joanas Maria Magaia","","","Matola Agare","Cidade de Maputo","Cidade de Maputo","100009","400023290","MZ","","","","","","1","1.9");
INSERT INTO cust_branch VALUES("67","35","nome completo","","","","","","","40023232","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("68","36","Antonio Miguel Obadias","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("69","37","Onda Magnetica","","","","","","","400013903","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("70","38","Onda Magnetica","","","","","","","400013903","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("71","39","Januario lda","","","","","","","40002323","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("72","40","Nome completo","","","","","","","400034343","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("73","41","Maria Madalenaa","","","","","","","400786857","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("74","42","Ordelas Matias Gloria Lda","","","","","","","40018994","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("75","43","Nome","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("76","44","nome","","","","","","","4000","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("77","45","Matias Damasio","","","","","","","40001219","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("78","46","Rosa Almeida","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("79","47","Alberto Matsinhe","","","","","","","40013219","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("80","48","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("81","49","Alberto Matsinhe","","","","","","","40018199","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("82","50","Jorge Matsinhe","","","","","","","4000230","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("83","51","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("84","52","Alberto Matsinhe","","","","","","","40002838","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("85","53","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("86","54","Gustavo Obadias Matias","","","","","","","4000230","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("87","55","Mafurra Sociedade Anonima","","","","","","","4000232","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("88","56","Jonas Matias","","","","","","","400293929","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("89","57","Matsinhe","","","Matola Agare","Cidade de Maputo","Cidade de Maputo","1000112","400023232","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("90","58","Matsinhe","","","Hulene B","Cidade de Maputo","40023882","100100","4000320","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("91","59","TesteCustomer","","","Teste Zone","Cidade da Matola","Maputo city","1002302","4002320","MZ","","","","","","1","2.4");
INSERT INTO cust_branch VALUES("92","60","Matias Joanas","","","Matola agare","Cidade de Maputo","Maputo","129392","400023203","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("93","61","Kelvin","","","","","","","400003223","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("94","62","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("95","63","Joao Maria","","","Matola ","Cidade de Maputo","Cidade de Maputo","11222","400809","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("96","64","Mateus Cossa","","","","","","","40006786","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("97","65","Maria Almeida","","","Hulene B","Cidade de Mapuot","Maputo Cidade","2000","400023232","MZ","","","","","","1","9");
INSERT INTO cust_branch VALUES("98","66","Mafalda Matias cossa","","","Matola Agare","Cidade de Maputo","Cidade de Maputo","100009","400023290","MZ","","","","","","0","2");
INSERT INTO cust_branch VALUES("99","67","Mario Pinto","","","Matola 700, 345","Matola","Maputo","1132","400322019","MZ","","","","","","1","0");
INSERT INTO cust_branch VALUES("100","68","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("101","69","New customer","","","Matola H","Cidade de Maputo","Cidade de Maputo","1111","6000870","MZ","","","","","","1","20");
INSERT INTO cust_branch VALUES("102","70","Mario Antonio Baptista","","","","","","","4001930","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("103","71","Mario Antonio Chilengue","","","","","","","40002323","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("104","72","Maria de lurde Motala","","","","","","","40002323","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("105","73","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("106","74","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("107","75","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("108","76","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("109","77","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("110","78","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("111","79","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("112","80","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("113","81","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("114","82","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("115","83","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("116","84","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("117","85","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("118","86","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("119","87","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("120","88","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("121","89","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("122","90","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("123","91","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("124","92","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("125","93","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("126","94","Alberto","","","Huelene B","Cidade de Maputo","Cidade de Maputo","100232","400234234","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("127","97","Alberto","","","Malhazine D","Cidade de Maputo","","","400232023","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("128","99","MArio","","","Matola H","Cidade de Maputo","Maputo Cidade","1020302","40023232","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("129","105","Alberto","","","Huelene B","Cidade de Maputo","Cidade de Maputo","1002323","400012313","MZ","1","1","1","1","1","0","0");
INSERT INTO cust_branch VALUES("130","106","Alberto","","","Huelene B","Cidade de Maputo","Cidade de Maputo","1002323","400012313","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("131","107","Alberto","","","Hurlene M","Cidade de Maputo","Cidade de Maputo","10002432","40020323","MZ","","","","","","1","0");
INSERT INTO cust_branch VALUES("132","108","Januario Matias Cossa","","","Huelene B","Cidade de Maputo","Cidade de Maputo","1002323","40023230","MZ","","","","","","1","10");
INSERT INTO cust_branch VALUES("133","109","Januario Matias Almeida","","","Huelene B","Cidade de Maputo","Cidade de Maputo","100323","40002323","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("134","110","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("135","111","Alberto Matsinhe","","","","","","","40002322","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("136","112","Generico","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("137","113","nome","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("138","114","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("139","115","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("140","116","Jona Matias Cossa","","","","","","","4002322","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("141","117","Momed Gali Junior","","","","","","","2147483647","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("142","118","Mario Baptista","","","","","","","2147483647","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("143","119","Joana Maria Matola","","","","","","","40029430","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("144","120","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("145","121","PhC Software lda","","","Mavalane C. ","Cidade de Maputo","Cidade de Maputo","1100","40012132","MZ","","","","","","0","7");
INSERT INTO cust_branch VALUES("146","122","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("147","123","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("148","124","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("149","125","Maria Antonio Saide","","","","","","","1000232340","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("150","126","Matias Matavel Junior","","","Mavalane D","Cidade de Maputo","Cidade de Maputo","1100","400013290","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("151","127","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("152","128","Marcos","","","Av. Eduardo Mondlane nr 3002, Maputo","Cidade de Maputo","Cidade de Maputo","1000233","400232302","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("153","129","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("154","130","Mzdados lda","","","Av de Mocambique nr 30023 , Zimpeto.","Cidade de Maputo","Cidade de Maputo","100232043","40002322","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("155","131","","","","","","","","0","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("156","132","prince","","","Av. De Mocambique nr 4002","Cidade de Maputo","Cidade de Maputo","100108","40030300","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("157","134","Farmacia Jasmine lda ","","","Av de Mocam  bique nr 3002","Cidade de Maputo","Cidade de Maputo","10003243","10000001","","","","","","","0","0");
INSERT INTO cust_branch VALUES("159","136","Joana Matias Cossa","","","","","","","2147483647","","","","","","","0","0");
INSERT INTO cust_branch VALUES("160","137","joao Matias Cossa","","","Av. Samora Machel nr 3001 RC 04","Maputo","Cidade de Maputo","1100","40020302","MZ","","","","","","0","0");
INSERT INTO cust_branch VALUES("161","138","Mafala Service","","","","","","","400023003","","","","","","","0","0");
INSERT INTO cust_branch VALUES("162","139","Matias Juntamente","","","","","","","5000303","","","","","","","0","0");





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
  `status_debtor` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`debtor_no`)
) ENGINE=MyISAM AUTO_INCREMENT=140 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO debtors_master VALUES("15","Mozal SA","email@email.com","","","845058838","0","","0","","2018-02-16 12:58:49","");
INSERT INTO debtors_master VALUES("17","Novo CL ","novo@teste.com","","","","0","","0","desactivo","2018-03-12 08:17:44","");
INSERT INTO debtors_master VALUES("18","Assane Obadias Junior","assane@assane.com","","","843443245","0","","0","","2018-03-12 13:35:21","");
INSERT INTO debtors_master VALUES("19","Minerva Central","minerva@minerve.co.mz","","","845058846","0","","0","","2018-03-12 21:41:32","");
INSERT INTO debtors_master VALUES("20","Update customer","customer@customer.com","","","84505884","0","","0","","2018-03-12 22:11:40","");
INSERT INTO debtors_master VALUES("21","Julio","massango.julio2@gmail.com","","","842627828","0","","1","","2018-03-13 08:01:01","");
INSERT INTO debtors_master VALUES("22","Luisa SA","emai1l@gmail.com","","","84505884","0","","1","","2018-03-13 08:55:13","");
INSERT INTO debtors_master VALUES("23","António Madeira","matsinhe@mzdados.co.mz","","","84505884","0","","1","","2018-03-14 09:12:43","");
INSERT INTO debtors_master VALUES("24","Leia Customer","sshaddymz@gmail.com","","","845058848","0","","1","","2018-03-15 12:39:31","");
INSERT INTO debtors_master VALUES("64","Mateus Cossa","","","","845697909","0","","1","desactivo","2018-04-03 07:27:47","");
INSERT INTO debtors_master VALUES("26","Alberto Matsinhe","","","","","0","","1","","","");
INSERT INTO debtors_master VALUES("27","Alberto Matsinhe","","twtwtwtwt","","","0","","1","","","");
INSERT INTO debtors_master VALUES("31","Ordela Joaquim","","","","8213131313","0","","1","desactivo","2018-03-19 09:22:26","");
INSERT INTO debtors_master VALUES("32","Alberto Matsinhe","","","","8232323232","0","","1","desactivo","2018-03-19 12:08:21","");
INSERT INTO debtors_master VALUES("33","Alberto Jorge Matsinhe","","","","8232323133","0","","1","desactivo","2018-03-19 12:17:33","");
INSERT INTO debtors_master VALUES("34","Joanas Maria Magaia","","","","823232323","0","","1","desactivo","2018-03-19 12:24:31","");
INSERT INTO debtors_master VALUES("35","nome completo","","","","832323234","0","","1","desactivo","2018-03-19 12:35:21","");
INSERT INTO debtors_master VALUES("36","Antonio Miguel Obadias","","","","","0","","1","desactivo","2018-03-19 13:07:45","");
INSERT INTO debtors_master VALUES("37","Onda Magnetica","","","","8232323231","0","","1","desactivo","2018-03-19 13:52:16","");
INSERT INTO debtors_master VALUES("38","Onda Magnetica","","","","8232323231","0","","1","desactivo","2018-03-19 13:53:36","");
INSERT INTO debtors_master VALUES("39","Januario lda","","","","","0","","1","desactivo","2018-03-19 13:55:19","");
INSERT INTO debtors_master VALUES("40","Nome completo","","","","","0","","1","desactivo","2018-03-19 14:01:36","");
INSERT INTO debtors_master VALUES("41","Maria Madalenaa","","","","","0","","1","desactivo","2018-03-19 14:02:53","");
INSERT INTO debtors_master VALUES("42","Ordelas Matias Gloria Lda","","","","","0","","1","desactivo","2018-03-19 14:26:38","");
INSERT INTO debtors_master VALUES("43","Nome","","","","","0","","1","desactivo","2018-03-19 14:27:09","");
INSERT INTO debtors_master VALUES("44","nome","","","","","0","","1","desactivo","2018-03-19 14:33:13","");
INSERT INTO debtors_master VALUES("45","Matias Damasio","","","","","0","","1","desactivo","2018-03-19 14:35:38","");
INSERT INTO debtors_master VALUES("46","Rosa Almeida","","","","","0","","1","desactivo","2018-03-19 14:46:51","");
INSERT INTO debtors_master VALUES("47","Alberto Matsinhe","","","","","0","","1","desactivo","2018-03-19 15:31:43","");
INSERT INTO debtors_master VALUES("48","","","","","","0","","1","desactivo","2018-03-19 15:44:03","");
INSERT INTO debtors_master VALUES("49","Alberto Matsinhe","","","","8249393299","0","","1","desactivo","2018-03-20 06:57:31","");
INSERT INTO debtors_master VALUES("50","Jorge Matsinhe","","","","823822882","0","","1","desactivo","2018-03-20 08:04:06","");
INSERT INTO debtors_master VALUES("51","","","","","","0","","1","desactivo","2018-03-20 08:04:49","");
INSERT INTO debtors_master VALUES("52","Alberto Matsinhe","","","","828328382","0","","1","desactivo","2018-03-20 08:32:32","");
INSERT INTO debtors_master VALUES("53","","","","","","0","","1","desactivo","2018-03-20 08:52:00","");
INSERT INTO debtors_master VALUES("54","Gustavo Obadias Matias","","","","823822882","0","","1","desactivo","2018-03-20 09:03:31","");
INSERT INTO debtors_master VALUES("55","Mafurra Sociedade Anonima","","","","","0","","1","desactivo","2018-03-20 13:22:39","");
INSERT INTO debtors_master VALUES("56","Jonas Matias","","","","82323232","0","","1","desactivo","2018-03-20 14:01:06","");
INSERT INTO debtors_master VALUES("58","Matsinhe","infomzdados@gmail.comm","","","845058848","0","","1","","2018-03-23 14:11:13","");
INSERT INTO debtors_master VALUES("59","TesteCustomer","teste@teste.co.mz","","","845434343","0","","1","","2018-04-02 13:08:10","");
INSERT INTO debtors_master VALUES("63","Joao Maria","jao@gmail.com","","","845008080","0","","1","","2018-04-03 07:04:33","");
INSERT INTO debtors_master VALUES("61","Kelvin","","","","834343445","0","","1","desactivo","2018-04-03 03:50:10","");
INSERT INTO debtors_master VALUES("62","","","","","","0","","1","desactivo","2018-04-03 03:50:53","");
INSERT INTO debtors_master VALUES("65","Maria Almeida","maria@maria.com","","","84454545","0","","1","","2018-04-09 07:49:24","");
INSERT INTO debtors_master VALUES("66","Mafalda Matias cossa","mafalda@mafalda.com","","","834434343","0","","1","","2018-04-09 07:51:50","");
INSERT INTO debtors_master VALUES("67","Mario Pinto","mariopinto@email.com","","","868878822","0","","1","","2018-04-13 09:55:19","");
INSERT INTO debtors_master VALUES("68","","","","","","0","","1","desactivo","2018-04-13 12:24:20","");
INSERT INTO debtors_master VALUES("69","New customer","albertomatsinhe@gmail.com","","","84505885","0","","1","","2018-04-13 13:24:24","");
INSERT INTO debtors_master VALUES("70","Mario Antonio Baptista","","","","84450232332","0","","1","desactivo","2018-04-16 14:53:38","");
INSERT INTO debtors_master VALUES("71","Mario Antonio Chilengue","","","","84923923","0","","1","desactivo","2018-04-17 07:33:36","");
INSERT INTO debtors_master VALUES("72","Maria de lurde Motala","","","","82384848","0","","1","desactivo","2018-04-17 13:55:33","");
INSERT INTO debtors_master VALUES("117","Momed Gali Junior","","","","845058849","0","","1","desactivo","2018-04-18 09:49:03","");
INSERT INTO debtors_master VALUES("116","Jona Matias Cossa","","","","","0","","1","desactivo","2018-04-18 09:43:06","");
INSERT INTO debtors_master VALUES("113","nome","","","","","0","","1","desactivo","2018-04-18 09:03:21","");
INSERT INTO debtors_master VALUES("112","Generico","","","","","0","","1","desactivo","2018-04-18 09:02:55","");
INSERT INTO debtors_master VALUES("111","Alberto Matsinhe","","","","840230230","0","","1","desactivo","2018-04-18 09:00:13","");
INSERT INTO debtors_master VALUES("109","Januario Matias Almeida","albertomatsinhe@gmail.com","","","845949942","0","","1","","2018-04-18 08:26:17","");
INSERT INTO debtors_master VALUES("108","Januario Matias Cossa","email.com@email.com","","","845405459","0","","1","","2018-04-18 08:25:01","");
INSERT INTO debtors_master VALUES("95","Januario Matias  Cossa","","","","845459934","0","","1","","2018-04-18 07:09:17","");
INSERT INTO debtors_master VALUES("96","Januario Matias  Cossa","","","","845459934","0","","1","","2018-04-18 07:09:39","");
INSERT INTO debtors_master VALUES("97","Alberto","","","","839399439","0","","1","","2018-04-18 07:11:06","");
INSERT INTO debtors_master VALUES("98","Kelvin","","","","839434394","0","","1","","2018-04-18 07:14:31","");
INSERT INTO debtors_master VALUES("99","MArio","","","","849399349","0","","1","","2018-04-18 07:19:45","");
INSERT INTO debtors_master VALUES("100","Modal ","","","","849949494","0","","1","","2018-04-18 07:22:17","");
INSERT INTO debtors_master VALUES("101","MArio","","","","849495949","0","","1","","2018-04-18 07:28:49","");
INSERT INTO debtors_master VALUES("102","matias","","","","845040045","0","","1","","2018-04-18 07:34:33","");
INSERT INTO debtors_master VALUES("103","Alberto","albertomatsinhe@gmail.com","","","840303003","0","","1","","2018-04-18 07:37:55","");
INSERT INTO debtors_master VALUES("104","Alberto","","","","850030034","0","","1","","2018-04-18 07:41:14","");
INSERT INTO debtors_master VALUES("105","Alberto","","","","845954945","0","","1","","2018-04-18 07:43:04","");
INSERT INTO debtors_master VALUES("106","Alberto","albertomatsinhe@gmail.com","","","845954945","0","","1","","2018-04-18 07:43:54","");
INSERT INTO debtors_master VALUES("107","Alberto","sshaddymz@gmail.com","","","840303030","0","","1","","2018-04-18 07:44:57","");
INSERT INTO debtors_master VALUES("118","Mario Baptista","","","","845495949","0","","1","desactivo","2018-04-18 12:41:02","");
INSERT INTO debtors_master VALUES("119","Joana Maria Matola","","","","823232322","0","","1","desactivo","2018-04-18 13:18:19","");
INSERT INTO debtors_master VALUES("136","Joana Matias Cossa","","","","8450505055","0","","1","desactivo","2018-04-19 08:28:30","");
INSERT INTO debtors_master VALUES("121","PhC Software lda","phc@phcsoftware.com","","","845058848","0","","1","","2018-04-18 13:47:40","");
INSERT INTO debtors_master VALUES("122","","","","","","0","","1","desactivo","2018-04-18 13:48:47","");
INSERT INTO debtors_master VALUES("123","","","","","","0","","1","desactivo","2018-04-18 13:49:12","");
INSERT INTO debtors_master VALUES("124","","","","","","0","","1","desactivo","2018-04-18 14:04:39","");
INSERT INTO debtors_master VALUES("125","Maria Antonio Saide","","","","+258845058848","0","","1","desactivo","2018-04-18 14:18:16","");
INSERT INTO debtors_master VALUES("126","Matias Matavel Junior","","","","845540030","0","","1","","2018-04-18 14:38:28","");
INSERT INTO debtors_master VALUES("127","","","","","","0","","1","desactivo","2018-04-18 14:39:23","");
INSERT INTO debtors_master VALUES("128","Marcos","marcos@marcos.com","","","838483884","0","","1","","2018-04-18 14:50:48","");
INSERT INTO debtors_master VALUES("129","","","","","","0","","1","desactivo","2018-04-18 14:51:21","");
INSERT INTO debtors_master VALUES("130","Mzdados lda","info@mzdados.co.mz","","","845058848","0","","1","","2018-04-18 14:54:36","");
INSERT INTO debtors_master VALUES("131","","","","","","0","","1","desactivo","2018-04-18 14:55:23","");
INSERT INTO debtors_master VALUES("132","prince","prince@teste.com","","","845058843","0","","1","","2018-04-18 17:40:19","");
INSERT INTO debtors_master VALUES("133","nome","email@email.com","","","845058848","0","","1","","2018-04-18 18:41:00","");
INSERT INTO debtors_master VALUES("134","Farmacia Jasmine lda ","email@email.com","","","845050504","0","","1","","2018-04-18 18:42:42","");
INSERT INTO debtors_master VALUES("137","joao Matias Cossa","","","","845050505","0","","1","","2018-04-19 09:21:03","");
INSERT INTO debtors_master VALUES("138","Mafala Service","","","","848599595959","0","","1","desactivo","2018-04-19 09:23:18","");
INSERT INTO debtors_master VALUES("139","Matias Juntamente","","","","8499329030","0","","1","","2018-04-19 10:03:14","");





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
INSERT INTO email_temp_details VALUES("37","5","Documento nr  # {order_reference_no} da empresa ","<p>Caro Cliente!</p><p>Agradecemos pelos seus pedidos!</p><p><br></p>","po","5");
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

INSERT INTO invoice_payment_terms VALUES("1","Pagamento na entrega","0","1");
INSERT INTO invoice_payment_terms VALUES("2","Net15","15","0");
INSERT INTO invoice_payment_terms VALUES("3","Net30","30","0");





CREATE TABLE IF NOT EXISTS `item_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` tinyint(4) NOT NULL,
  `item_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `item_type_id` int(11) NOT NULL,
  `deleted_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO item_code VALUES("25","004","MOTOROLA","2","","0","0","1","","");
INSERT INTO item_code VALUES("24","003","HUWAWEI","1","","0","0","1","","");
INSERT INTO item_code VALUES("23","02","IPHONE","1","","0","0","0","","2018-04-06 06:14:33");
INSERT INTO item_code VALUES("22","001","Sumsung S8","2","","0","0","1","","2018-03-14 13:39:51");
INSERT INTO item_code VALUES("26","009","APPLE WATCH","1","","0","0","0","","");
INSERT INTO item_code VALUES("27","01","MOTOROLA","1","","0","0","0","","");
INSERT INTO item_code VALUES("28","09","TECNO","1","","0","0","0","","");
INSERT INTO item_code VALUES("29","10","SERVICO DE TRADUCAO","4","","0","2","0","","");
INSERT INTO item_code VALUES("30","11","SERVICO DE TRADUCAO DE DOCUMENTOS","1","","0","2","0","","2018-04-05 14:03:37");
INSERT INTO item_code VALUES("31","PP","NOVO SMARTPHONE","1","","0","0","0","","");
INSERT INTO item_code VALUES("32","II","IPHONE 3","1","","0","0","0","","");
INSERT INTO item_code VALUES("33","OO","PAPEL","4","","0","0","0","","2018-04-05 12:49:20");
INSERT INTO item_code VALUES("34","PARACETAMOL 500 MG","PARACETAMOL","1","","0","0","0","","");
INSERT INTO item_code VALUES("35","00","WINDOWS","2","","0","0","0","","2018-04-13 10:04:59");
INSERT INTO item_code VALUES("36","77","WINDOWS 10","1","","0","0","0","","");





CREATE TABLE IF NOT EXISTS `item_tax_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tax_rate` double(8,2) NOT NULL,
  `defaults` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO item_tax_types VALUES("1","Isento de Iva","0.00","0");
INSERT INTO item_tax_types VALUES("2","Sales Tax","15.00","0");
INSERT INTO item_tax_types VALUES("3","Iva","17.00","1");





CREATE TABLE IF NOT EXISTS `item_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO item_type VALUES("1","Produto");
INSERT INTO item_type VALUES("2","Serviço");





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

INSERT INTO location VALUES("1","PL","Armazem I","Av. Eduardo Mondlane nr 3092","","","","829999999","0","2017-10-18 13:51:20","2018-03-08 07:33:14");
INSERT INTO location VALUES("2","JA","Armazem II","125 Hayes St, San Francisco, CA 94102, USA","","","","Armazem II 288 843232232","0","2017-10-18 13:51:20","2018-03-08 07:32:21");





CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO migrations VALUES("2014_10_12_100000_create_password_resets_table","1");
INSERT INTO migrations VALUES("2015_09_26_161159_entrust_setup_tables","1");
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
INSERT INTO migrations VALUES("2017_11_06_072813_sales_debito","2");
INSERT INTO migrations VALUES("2017_11_07_095325_sales_debit","3");
INSERT INTO migrations VALUES("2017_11_07_132723_sales_debit","4");
INSERT INTO migrations VALUES("2017_11_13_080012_payment_history_debito","5");
INSERT INTO migrations VALUES("2017_11_13_080436_bank_trans_debito","5");
INSERT INTO migrations VALUES("2017_11_20_130755_sales_credit","6");
INSERT INTO migrations VALUES("2017_11_22_062045_sales_credits","7");
INSERT INTO migrations VALUES("2017_11_22_083333_sales_credit","8");
INSERT INTO migrations VALUES("2017_11_22_083534_sales_credits","9");
INSERT INTO migrations VALUES("2017_11_22_123718_payment_history_creditos","10");
INSERT INTO migrations VALUES("2017_11_22_124029_bank_trans_credito","10");
INSERT INTO migrations VALUES("2017_11_24_063301_cc","11");
INSERT INTO migrations VALUES("2017_11_24_071650_sales_cc","12");
INSERT INTO migrations VALUES("2017_11_28_072003_sales_peding","13");
INSERT INTO migrations VALUES("2017_12_04_061634_bank_trans_recibo","14");
INSERT INTO migrations VALUES("2017_12_13_120101_sales_ge","15");
INSERT INTO migrations VALUES("2017_12_15_101620_sales_gt","16");
INSERT INTO migrations VALUES("2017_12_18_132928_sales_vd","17");
INSERT INTO migrations VALUES("2017_12_18_135731_sales_details_vd","18");
INSERT INTO migrations VALUES("2017_12_22_082946_purchase_vd","19");
INSERT INTO migrations VALUES("2017_12_22_083531_purchase_vd_details","19");
INSERT INTO migrations VALUES("2017_12_27_130710_payment_purchase_history","20");
INSERT INTO migrations VALUES("2016_08_30_100832_create_teste_table","21");





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
) ENGINE=MyISAM AUTO_INCREMENT=360 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO payment_history VALUES("273","559","2"," COT-0001/2018","FT-0001/2018 ","2018-03-12","11700","2","17","RE-0001/2018","completed","","");
INSERT INTO payment_history VALUES("311","627","2"," COT-0003/2018","FT-0003/2018 ","2018-03-22","500","2","15","RE-0019/2018","completed","","");
INSERT INTO payment_history VALUES("275","561","2","  0","NC-0001/2018 ","2018-03-12","-485","2","17","RE-0002/2018","completed","","");
INSERT INTO payment_history VALUES("276","562","2"," COT-0003/2018","FT-0003/2018 ","2018-03-12","500","2","15","RE-0003/2018","completed","","");
INSERT INTO payment_history VALUES("277","563","2","  0","ND-0004/2018 ","2018-03-12","500","2","15","RE-0003/2018","completed","","");
INSERT INTO payment_history VALUES("278","564","2","  0","NC-0003/2018 ","2018-03-12","-250","2","15","RE-0003/2018","completed","","");
INSERT INTO payment_history VALUES("279","565","2","  0","NC-0003/2018 ","2018-03-12","-125","2","15","RE-0004/2018","completed","","");
INSERT INTO payment_history VALUES("280","566","2"," COT-0002/2018","FT-0002/2018 ","2018-03-12","11700","2","17","RE-0005/2018","completed","","");
INSERT INTO payment_history VALUES("281","567","2","  0","NC-0002/2018 ","2018-03-12","-11700","2","17","RE-0005/2018","completed","","");
INSERT INTO payment_history VALUES("358","689","2"," COT-0107/2018","FT-0061/2018 ","2018-04-18","10","2","21","RE-0038/2018","completed","","");
INSERT INTO payment_history VALUES("357","688","2"," COT-0074/2018","FT-0048/2018 ","2018-04-18","58020","2","21","RE-0038/2018","completed","","");
INSERT INTO payment_history VALUES("285","571","2"," COT-0004/2018","FT-0004/2018 ","2018-03-12","200","2","18","RE-0007/2018","completed","","");
INSERT INTO payment_history VALUES("286","572","2","  0","ND-0006/2018 ","2018-03-12","2000","2","19","RE-0008/2018","completed","","");
INSERT INTO payment_history VALUES("356","687","2"," COT-0066/2018","FT-0040/2018 ","2018-04-18","2000","2","21","RE-0038/2018","completed","","");
INSERT INTO payment_history VALUES("355","686","2"," COT-0062/2018","FT-0036/2018 ","2018-04-18","1000","2","21","RE-0038/2018","completed","","");
INSERT INTO payment_history VALUES("354","685","2","  191","ND-0014/2018 ","2018-04-04","1005","2","18","RE-0037/2018","completed","","");
INSERT INTO payment_history VALUES("291","577","2"," COT-0009/2018","FT-0009/2018 ","2018-03-13","1925","2","21","RE-0011/2018","completed","","");
INSERT INTO payment_history VALUES("292","578","2","  0","ND-0008/2018 ","2018-03-13","1170","2","21","RE-0011/2018","completed","","");
INSERT INTO payment_history VALUES("293","579","2"," COT-0010/2018","FT-0010/2018 ","2018-03-13","1340","2","22","RE-0012/2018","completed","","");
INSERT INTO payment_history VALUES("294","580","2","  0","ND-0009/2018 ","2018-03-13","1170","2","22","RE-0012/2018","completed","","");
INSERT INTO payment_history VALUES("295","581","2","  0","NC-0008/2018 ","2018-03-13","-2340","2","22","RE-0012/2018","completed","","");
INSERT INTO payment_history VALUES("296","582","2"," COT-0004/2018","FT-0004/2018 ","2018-03-13","300","2","18","RE-0013/2018","completed","","");
INSERT INTO payment_history VALUES("297","583","2","  0","ND-0005/2018 ","2018-03-13","100","2","18","RE-0013/2018","completed","","");
INSERT INTO payment_history VALUES("298","584","2","  0","NC-0004/2018 ","2018-03-13","-100","2","18","RE-0013/2018","completed","","");
INSERT INTO payment_history VALUES("299","585","2"," COT-0004/2018","FT-0004/2018 ","2018-03-13","300","2","18","RE-0013/2018","completed","","");
INSERT INTO payment_history VALUES("300","586","2","  0","ND-0005/2018 ","2018-03-13","100","2","18","RE-0013/2018","completed","","");
INSERT INTO payment_history VALUES("301","587","2","  0","NC-0004/2018 ","2018-03-13","-100","2","18","RE-0013/2018","completed","","");
INSERT INTO payment_history VALUES("302","588","2"," COT-0009/2018","FT-0009/2018 ","2018-03-13","1000","2","21","RE-0014/2018","completed","","");
INSERT INTO payment_history VALUES("303","589","2","  0","NC-0007/2018 ","2018-03-13","-2000","2","21","RE-0014/2018","completed","","");
INSERT INTO payment_history VALUES("304","590","2","  0","NC-0009/2018 ","2018-03-13","-1170","2","21","RE-0014/2018","completed","","");
INSERT INTO payment_history VALUES("305","595","2"," COT-0012/2018","FT-0012/2018 ","2018-03-15","14360","2","24","RE-0015/2018","completed","","");
INSERT INTO payment_history VALUES("306","596","2","  0","NC-0010/2018 ","2018-03-15","-5850","2","24","RE-0015/2018","completed","","");
INSERT INTO payment_history VALUES("307","597","2"," COT-0013/2018","FT-0013/2018 ","2018-03-15","30420","2","24","RE-0016/2018","completed","","");
INSERT INTO payment_history VALUES("308","598","2","  0","ND-0010/2018 ","2018-03-15","10000","2","24","RE-0016/2018","completed","","");
INSERT INTO payment_history VALUES("309","599","2","  0","ND-0010/2018 ","2018-03-15","1700","2","24","RE-0017/2018","completed","","");
INSERT INTO payment_history VALUES("310","600","2","  0","NC-0005/2018 ","2018-03-15","-300","2","19","RE-0018/2018","completed","","");
INSERT INTO payment_history VALUES("312","628","2","  0","ND-0004/2018 ","2018-03-22","500","2","15","RE-0019/2018","completed","","");
INSERT INTO payment_history VALUES("313","629","2"," COT-0018/2018","FT-0017/2018 ","2018-03-22","184","2","18","RE-0020/2018","completed","","");
INSERT INTO payment_history VALUES("314","630","2","  0","ND-0011/2018 ","2018-03-22","1750","2","18","RE-0020/2018","completed","","");
INSERT INTO payment_history VALUES("315","631","2"," COT-0018/2018","FT-0017/2018 ","2018-03-22","201","2","18","RE-0021/2018","completed","","");
INSERT INTO payment_history VALUES("316","632","2","  0","ND-0011/2018 ","2018-03-22","750","2","18","RE-0021/2018","completed","","");
INSERT INTO payment_history VALUES("317","633","2","  183","ND-0011/2018 ","2018-03-22","750","2","18","RE-0021/2018","completed","","");
INSERT INTO payment_history VALUES("318","634","2"," COT-0016/2018","FT-0015/2018 ","2018-03-23","8195","2","17","RE-0022/2018","completed","","");
INSERT INTO payment_history VALUES("319","635","2"," COT-0016/2018","FT-0015/2018 ","2018-03-23","1000","2","17","RE-0023/2018","completed","","");
INSERT INTO payment_history VALUES("320","636","2"," COT-0005/2018","FT-0005/2018 ","2018-03-23","170","2","19","RE-0024/2018","completed","","");
INSERT INTO payment_history VALUES("321","637","2","  0","ND-0006/2018 ","2018-03-23","140","2","19","RE-0024/2018","completed","","");
INSERT INTO payment_history VALUES("322","638","2","  0","NC-0005/2018 ","2018-03-23","-100","2","19","RE-0024/2018","completed","","");
INSERT INTO payment_history VALUES("323","639","2"," COT-0005/2018","FT-0005/2018 ","2018-03-23","340","2","19","RE-0025/2018","completed","","");
INSERT INTO payment_history VALUES("324","640","2","  0","ND-0006/2018 ","2018-03-23","20","2","19","RE-0025/2018","completed","","");
INSERT INTO payment_history VALUES("325","641","2","  0","NC-0005/2018 ","2018-03-23","-10","2","19","RE-0025/2018","completed","","");
INSERT INTO payment_history VALUES("326","642","2"," COT-0006/2018","FT-0006/2018 ","2018-03-23","500","2","20","RE-0026/2018","completed","","");
INSERT INTO payment_history VALUES("327","643","2"," COT-0005/2018","FT-0005/2018 ","2018-03-23","1000","2","19","RE-0027/2018","completed","","");
INSERT INTO payment_history VALUES("328","644","2"," COT-0005/2018","FT-0005/2018 ","2018-03-23","500","2","19","RE-0028/2018","completed","","");
INSERT INTO payment_history VALUES("329","645","2"," COT-0005/2018","FT-0005/2018 ","2018-03-23","500","2","19","RE-0029/2018","completed","","");
INSERT INTO payment_history VALUES("330","646","2"," COT-0005/2018","FT-0005/2018 ","2018-03-23","90","2","19","RE-0030/2018","completed","","");
INSERT INTO payment_history VALUES("331","647","2","  0","ND-0006/2018 ","2018-03-23","10","2","19","RE-0030/2018","completed","","");
INSERT INTO payment_history VALUES("332","648","2","  0","NC-0005/2018 ","2018-03-23","-10","2","19","RE-0030/2018","completed","","");
INSERT INTO payment_history VALUES("333","649","2"," COT-0018/2018","FT-0017/2018 ","2018-03-23","200","2","18","RE-0031/2018","completed","","");
INSERT INTO payment_history VALUES("351","682","2","  0","ND-0005/2018 ","2018-04-04","100","2","18","RE-0037/2018","completed","","");
INSERT INTO payment_history VALUES("350","681","2"," COT-0004/2018","FT-0004/2018 ","2018-04-04","150","2","18","RE-0037/2018","completed","","");
INSERT INTO payment_history VALUES("336","652","2","  0","ND-0011/2018 ","2018-03-23","1510","2","58","RE-0033/2018","completed","","");
INSERT INTO payment_history VALUES("353","684","2"," COT-0018/2018","FT-0017/2018 ","2018-04-04","270","2","18","RE-0037/2018","completed","","");
INSERT INTO payment_history VALUES("338","655","2","  189","ND-0012/2018 ","2018-04-02","3084","2","59","RE-0034/2018","completed","","");
INSERT INTO payment_history VALUES("339","656","2","  343","NC-0011/2018 ","2018-04-02","-2000","2","59","RE-0034/2018","completed","","");
INSERT INTO payment_history VALUES("352","683","2","  0","NC-0004/2018 ","2018-04-04","-100","2","18","RE-0037/2018","completed","","");
INSERT INTO payment_history VALUES("341","658","2","  189","ND-0012/2018 ","2018-04-02","3042","2","59","RE-0035/2018","completed","","");
INSERT INTO payment_history VALUES("342","659","2","  343","NC-0011/2018 ","2018-04-02","-2000","2","59","RE-0035/2018","completed","","");
INSERT INTO payment_history VALUES("349","672","2"," COT-0016/2018","FT-0015/2018 ","2018-04-02","9000","2","17","RE-0036/2018","completed","","");
INSERT INTO payment_history VALUES("359","690","2"," COT-0117/2018","FT-0069/2018 ","2018-04-18","6000","2","118","RE-0039/2018","completed","","");





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
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO payment_purchase_history VALUES("108","557","2","OC-0001","2018-03-08","603252","2","7","PF-0001/2018","","");
INSERT INTO payment_purchase_history VALUES("109","670","2","OC-0001","2018-04-02","27970","2","7","PF-0002/2018","","");
INSERT INTO payment_purchase_history VALUES("110","671","2","OC-0001","2018-04-02","20000","2","7","PF-0003/2018","","");
INSERT INTO payment_purchase_history VALUES("111","673","2","OC-0003","2018-04-02","1000","2","10","PF-0004/2018","","");
INSERT INTO payment_purchase_history VALUES("112","673","2","OC-0004","2018-04-02","21000","2","10","PF-0004/2018","","");
INSERT INTO payment_purchase_history VALUES("113","675","2","OC-0003","2018-04-02","100","2","10","PF-0005/2018","","");
INSERT INTO payment_purchase_history VALUES("114","675","2","OC-0004","2018-04-02","12000","2","10","PF-0005/2018","","");
INSERT INTO payment_purchase_history VALUES("115","676","2","OC-0003","2018-04-02","100","2","10","PF-0005/2018","","");
INSERT INTO payment_purchase_history VALUES("116","676","2","OC-0004","2018-04-02","12000","2","10","PF-0005/2018","","");
INSERT INTO payment_purchase_history VALUES("117","677","2","OC-0003","2018-04-02","100","2","10","PF-0006/2018","","");
INSERT INTO payment_purchase_history VALUES("118","678","2","OC-0003","2018-04-02","100","2","10","PF-0006/2018","","");
INSERT INTO payment_purchase_history VALUES("119","679","2","OC-0003","2018-04-02","700","2","10","PF-0007/2018","","");
INSERT INTO payment_purchase_history VALUES("120","680","2","OC-0003","2018-04-03","3100","2","10","PF-0008/2018","","");
INSERT INTO payment_purchase_history VALUES("121","680","2","OC-0004","2018-04-03","17000","2","10","PF-0008/2018","","");
INSERT INTO payment_purchase_history VALUES("122","680","2","OC-0006","2018-04-03","60000","2","10","PF-0008/2018","","");





CREATE TABLE IF NOT EXISTS `payment_terms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `defaults` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO payment_terms VALUES("1","Paypal","0");
INSERT INTO payment_terms VALUES("2","Transferencia Bancaria","1");





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
INSERT INTO permission_role VALUES("7","1");
INSERT INTO permission_role VALUES("8","1");
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
INSERT INTO permission_role VALUES("16","1");
INSERT INTO permission_role VALUES("17","1");
INSERT INTO permission_role VALUES("18","1");
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
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO preference VALUES("1","preference","row_per_page","25");
INSERT INTO preference VALUES("2","preference","date_format","1");
INSERT INTO preference VALUES("3","preference","date_sepa","-");
INSERT INTO preference VALUES("4","preference","soft_name","goBilling");
INSERT INTO preference VALUES("5","company","site_short_name","FT");
INSERT INTO preference VALUES("6","preference","percentage","0");
INSERT INTO preference VALUES("7","preference","quantity","0");
INSERT INTO preference VALUES("8","preference","date_format_type","dd-mm-yyyy");
INSERT INTO preference VALUES("9","company","company_name","Facturação ");
INSERT INTO preference VALUES("10","company","company_email","admin@techvill.net");
INSERT INTO preference VALUES("11","company","company_phone","827555526");
INSERT INTO preference VALUES("12","company","company_street","Av Eduardo Mondlane nr 3090");
INSERT INTO preference VALUES("13","company","company_city","Maputo");
INSERT INTO preference VALUES("14","company","company_state","Mocambique");
INSERT INTO preference VALUES("15","company","company_zipCode","10007");
INSERT INTO preference VALUES("16","company","company_country_id","Mozambique");
INSERT INTO preference VALUES("17","company","dflt_lang","po");
INSERT INTO preference VALUES("18","company","dflt_currency_id","3");
INSERT INTO preference VALUES("19","company","sates_type_id","1");
INSERT INTO preference VALUES("20","company","company_nuit","400178293");
INSERT INTO preference VALUES("21","preferences","version","1.1.0");





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
) ENGINE=MyISAM AUTO_INCREMENT=166 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO purch_cc VALUES("148","7","","","PF-0001/2018","","603252","","1","2018-03-08","","");
INSERT INTO purch_cc VALUES("147","9","29","","CD-0001/2018","140400","","","0","2018-03-08","","");
INSERT INTO purch_cc VALUES("146","7","38","","OC-0001","603252","","","0","2018-03-08","","");
INSERT INTO purch_cc VALUES("149","8","30","","CD-0001/2018","62010","","","0","2018-03-14","","");
INSERT INTO purch_cc VALUES("150","8","31","","CD-0002/2018","410000","","","0","2018-03-20","","");
INSERT INTO purch_cc VALUES("151","8","32","","CD-0003/2018","380000","","","0","2018-03-20","","");
INSERT INTO purch_cc VALUES("152","7","33","","CD-0004/2018","308295","","","0","2018-04-02","","");
INSERT INTO purch_cc VALUES("153","7","39","","OC-0001","47970","","","0","2018-04-02","","");
INSERT INTO purch_cc VALUES("154","9","40","","OC-0002","468000","","","0","2018-04-02","","");
INSERT INTO purch_cc VALUES("155","7","","","PF-0002/2018","","27970","","1","2018-04-02","","");
INSERT INTO purch_cc VALUES("156","7","","","PF-0003/2018","","20000","","1","2018-04-02","","");
INSERT INTO purch_cc VALUES("157","10","41","","OC-0003","4000","","","0","2018-04-02","","");
INSERT INTO purch_cc VALUES("158","10","42","","OC-0004","38000","","","0","2018-04-02","","");
INSERT INTO purch_cc VALUES("159","9","43","","OC-0005","3510","","","0","2018-04-02","","");
INSERT INTO purch_cc VALUES("160","10","","","PF-0004/2018","","22000","","1","2018-04-02","","");
INSERT INTO purch_cc VALUES("161","10","","","PF-0005/2018","","12100","","1","2018-04-02","","");
INSERT INTO purch_cc VALUES("162","10","","","PF-0006/2018","","100","","1","2018-04-02","","");
INSERT INTO purch_cc VALUES("163","10","","","PF-0007/2018","","700","","1","2018-04-02","","");
INSERT INTO purch_cc VALUES("164","10","44","","OC-0006","60000","","","0","2018-04-03","","");
INSERT INTO purch_cc VALUES("165","10","","","PF-0008/2018","","80100","","1","2018-04-03","","");





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
  `discount_percent` double NOT NULL,
  PRIMARY KEY (`po_detail_item`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO purch_order_details VALUES("43","39","11","Servico de traducao de documentos","10","300","3","10","10","0");
INSERT INTO purch_order_details VALUES("44","39","02","Iphone","10","3800","3","10","10","0");
INSERT INTO purch_order_details VALUES("45","40","09","Tecno","100","4000","3","100","100","0");
INSERT INTO purch_order_details VALUES("46","41","11","Servico de traducao de documentos","10","300","1","10","10","0");
INSERT INTO purch_order_details VALUES("47","42","02","Iphone","10","3800","1","10","10","0");
INSERT INTO purch_order_details VALUES("48","43","11","Servico de traducao de documentos","10","300","3","10","10","0");
INSERT INTO purch_order_details VALUES("49","44","11","Servico de traducao de documentos","200","300","1","200","200","0");





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
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO purch_orders VALUES("39","7","2","","2018-04-02","OC-0001","PL","47970","47970.00","");
INSERT INTO purch_orders VALUES("40","9","2","","2018-04-02","OC-0002","JA","468000","0.00","");
INSERT INTO purch_orders VALUES("41","10","2","","2018-04-02","OC-0003","PL","3000","-100.00","");
INSERT INTO purch_orders VALUES("42","10","2","","2018-04-02","OC-0004","PL","38000","21000.00","");
INSERT INTO purch_orders VALUES("43","9","2","","2018-04-02","OC-0005","PL","3510","0.00","");
INSERT INTO purch_orders VALUES("44","10","2","","2018-04-03","OC-0006","PL","60000","0.00","");





CREATE TABLE IF NOT EXISTS `purchase_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO purchase_prices VALUES("17","001","40000");
INSERT INTO purchase_prices VALUES("18","002","1500");
INSERT INTO purchase_prices VALUES("19","003","2000");
INSERT INTO purchase_prices VALUES("20","004","6000");
INSERT INTO purchase_prices VALUES("21","005","1200");
INSERT INTO purchase_prices VALUES("22","001","40000");
INSERT INTO purchase_prices VALUES("23","02","3800");
INSERT INTO purchase_prices VALUES("24","003","0");
INSERT INTO purchase_prices VALUES("25","004","0");
INSERT INTO purchase_prices VALUES("26","009","5000");
INSERT INTO purchase_prices VALUES("27","01","4800");
INSERT INTO purchase_prices VALUES("28","09","4000");
INSERT INTO purchase_prices VALUES("29","11","300");
INSERT INTO purchase_prices VALUES("30","PP","8000");
INSERT INTO purchase_prices VALUES("31","II","10000");
INSERT INTO purchase_prices VALUES("32","OO","20003");
INSERT INTO purchase_prices VALUES("33","PARACETAMOL 500 MG","7.5");
INSERT INTO purchase_prices VALUES("34","00","0");
INSERT INTO purchase_prices VALUES("35","77","6000");





CREATE TABLE IF NOT EXISTS `purchase_vd` (
  `vd_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `into_stock_location` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supplier_no_vd` int(11) NOT NULL,
  `account_no` int(11) NOT NULL,
  `reference_vd` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vd_date` date NOT NULL,
  `payment_id` mediumint(9) NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`vd_no`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO purchase_vd VALUES("30","PL","8","5","CD-0001/2018","","2018-03-14","2","62010","","");
INSERT INTO purchase_vd VALUES("31","PL","8","5","CD-0002/2018","","2018-03-20","2","410000","","");
INSERT INTO purchase_vd VALUES("32","PL","8","5","CD-0003/2018","","2018-03-20","2","380000","","");
INSERT INTO purchase_vd VALUES("33","PL","7","5","CD-0004/2018","","2018-04-02","2","308295","","");





CREATE TABLE IF NOT EXISTS `purchase_vd_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vd_no` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `tax_type_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit_price` double NOT NULL DEFAULT '0',
  `quantity` double NOT NULL DEFAULT '0',
  `is_inventory` int(11) NOT NULL,
  `discount_percent` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO purchase_vd_details VALUES("26","29","5","3","Huwawei","1200","100","1","0","","");
INSERT INTO purchase_vd_details VALUES("27","30","9","3","Apple watch","5000","3","1","0","","");
INSERT INTO purchase_vd_details VALUES("28","30","2","3","Iphone","3800","10","1","0","","");
INSERT INTO purchase_vd_details VALUES("29","31","2","1","Iphone","3800","100","1","0","","");
INSERT INTO purchase_vd_details VALUES("30","31","11","1","Servico de traducao de documentos","300","100","1","0","","");
INSERT INTO purchase_vd_details VALUES("31","32","2","1","Iphone","3800","100","1","0","","");
INSERT INTO purchase_vd_details VALUES("32","33","9","3","Apple watch","5000","50","1","0","","");
INSERT INTO purchase_vd_details VALUES("33","33","11","3","Servico de traducao de documentos","300","50","1","10","","");





CREATE TABLE IF NOT EXISTS `receiptlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(45) NOT NULL,
  `total_amount` double NOT NULL DEFAULT '0',
  `pay_history_id` int(11) NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `supp_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

INSERT INTO receiptlists VALUES("24","PF-0002/2018","27970","109","2","2018-04-02","7");
INSERT INTO receiptlists VALUES("25","PF-0003/2018","20000","110","2","2018-04-02","7");
INSERT INTO receiptlists VALUES("26","PF-0004/2018","22000","112","2","2018-04-02","10");





CREATE TABLE IF NOT EXISTS `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO role_user VALUES("1","1");
INSERT INTO role_user VALUES("2","1");
INSERT INTO role_user VALUES("3","2");





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

INSERT INTO roles VALUES("1","admin","Admin","Admin User","","");
INSERT INTO roles VALUES("2","user","user","user","","");





CREATE TABLE IF NOT EXISTS `sale_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sales_type_id` tinyint(4) NOT NULL,
  `curr_abrev` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `inclusao_iva` int(11) NOT NULL,
  `discounto` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sale_prices VALUES("43","001","1","USD","50000","0","0");
INSERT INTO sale_prices VALUES("44","001","2","USD","0","0","0");
INSERT INTO sale_prices VALUES("45","02","1","USD","5000","1","0");
INSERT INTO sale_prices VALUES("46","02","2","USD","0","0","0");
INSERT INTO sale_prices VALUES("47","003","1","USD","30000","0","0");
INSERT INTO sale_prices VALUES("48","003","2","USD","0","0","0");
INSERT INTO sale_prices VALUES("49","004","1","USD","50000","0","0");
INSERT INTO sale_prices VALUES("50","004","2","USD","0","0","0");
INSERT INTO sale_prices VALUES("51","009","1","USD","7000","0","0");
INSERT INTO sale_prices VALUES("52","009","2","USD","0","0","0");
INSERT INTO sale_prices VALUES("53","01","1","USD","6000","0","0");
INSERT INTO sale_prices VALUES("54","01","2","USD","0","0","0");
INSERT INTO sale_prices VALUES("55","09","1","USD","5000","1","0");
INSERT INTO sale_prices VALUES("56","09","2","USD","0","0","0");
INSERT INTO sale_prices VALUES("57","11","1","USD","1000","1","0");
INSERT INTO sale_prices VALUES("58","11","2","USD","0","0","0");
INSERT INTO sale_prices VALUES("59","PP","1","USD","9000","0","0");
INSERT INTO sale_prices VALUES("60","PP","2","USD","0","0","0");
INSERT INTO sale_prices VALUES("61","II","1","USD","12000","1","0");
INSERT INTO sale_prices VALUES("62","II","2","USD","0","0","0");
INSERT INTO sale_prices VALUES("63","OO","1","USD","2000","0","10");
INSERT INTO sale_prices VALUES("64","OO","2","USD","0","0","0");
INSERT INTO sale_prices VALUES("65","PARACETAMOL 500 MG","1","USD","10","0","0");
INSERT INTO sale_prices VALUES("66","PARACETAMOL 500 MG","2","USD","0","0","0");
INSERT INTO sale_prices VALUES("67","00","1","USD","7000","1","0");
INSERT INTO sale_prices VALUES("68","00","2","USD","0","0","0");
INSERT INTO sale_prices VALUES("69","77","1","USD","7000","1","0");
INSERT INTO sale_prices VALUES("70","77","2","USD","0","0","0");





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
  `status` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idcc`),
  KEY `sales_cc_debtor_no_doc_foreign` (`debtor_no_doc`),
  KEY `sales_cc_order_no_doc_foreign` (`order_no_doc`),
  KEY `sales_cc_debit_no_doc_foreign` (`debit_no_doc`),
  KEY `sales_cc_credit_no_doc_foreign` (`credit_no_doc`)
) ENGINE=MyISAM AUTO_INCREMENT=392 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_cc VALUES("218","17","281","","","","FT-0001/2018","COT-0001/2018","11700","","0","","0","2018-03-12","","","");
INSERT INTO sales_cc VALUES("219","17","0","","","172","ND-0001/2018","","1170","","0","","1","2018-03-12","","2018-03-12 08:19:04","2018-03-12 08:19:04");
INSERT INTO sales_cc VALUES("220","17","0","","","87","NC-0001/2018","","0","585","585","","1","2018-03-12","","2018-03-12 08:21:33","2018-03-12 08:21:33");
INSERT INTO sales_cc VALUES("221","17","0","274","","","RE-0001/2018","  0","","12870","","2","1","2018-03-12","","","");
INSERT INTO sales_cc VALUES("223","17","283","","","","FT-0002/2018","COT-0002/2018","11700","","0","","0","2018-03-12","","","");
INSERT INTO sales_cc VALUES("299","59","343","","","","FT-0020/2018","COT-0041/2018","50000","","50000","","1","2018-04-02","","","");
INSERT INTO sales_cc VALUES("285","17","309","318","","","RE-0022/2018"," COT-0016/2018","","8195","","2","1","2018-03-23","","","");
INSERT INTO sales_cc VALUES("226","17","0","","","88","NC-0002/2018","","11700","","0","","1","2018-03-12","","2018-03-12 09:45:22","2018-03-12 09:45:22");
INSERT INTO sales_cc VALUES("227","15","285","","","","FT-0003/2018","COT-0003/2018","1000","","0","","0","2018-03-12","","","");
INSERT INTO sales_cc VALUES("228","15","0","","","175","ND-0004/2018","","1000","","0","","1","2018-03-12","","2018-03-12 12:32:49","2018-03-12 12:32:49");
INSERT INTO sales_cc VALUES("229","15","0","","","89","NC-0003/2018","","","500","125","","1","2018-03-12","","2018-03-12 12:33:27","2018-03-12 12:33:27");
INSERT INTO sales_cc VALUES("230","15","0","278","","","RE-0003/2018","  0","","750","","2","1","2018-03-12","","","");
INSERT INTO sales_cc VALUES("231","15","0","279","","","RE-0004/2018","  0","","-125","","2","1","2018-03-12","","","");
INSERT INTO sales_cc VALUES("232","17","0","281","","","RE-0005/2018","  0","","0","","2","0","2018-03-12","","","");
INSERT INTO sales_cc VALUES("233","18","287","","","","FT-0004/2018","COT-0004/2018","1000","","350","","1","2018-03-12","","","");
INSERT INTO sales_cc VALUES("234","18","0","","","176","ND-0005/2018","","1000","","800","","1","2018-03-12","","2018-03-12 13:43:30","2018-03-12 13:43:30");
INSERT INTO sales_cc VALUES("235","18","0","","","90","NC-0004/2018","","1000","1000","800","","0","2018-03-12","","2018-03-12 13:44:08","2018-03-12 13:44:08");
INSERT INTO sales_cc VALUES("237","18","287","285","","","RE-0007/2018"," COT-0004/2018","","200","","2","0","2018-03-12","","","");
INSERT INTO sales_cc VALUES("238","19","289","","","","FT-0005/2018","COT-0005/2018","1170","","5520","","1","2018-03-12","","","");
INSERT INTO sales_cc VALUES("239","19","0","","","177","ND-0006/2018","","2340","","4500","","1","2018-03-12","","2018-03-12 21:48:35","2018-03-12 21:48:35");
INSERT INTO sales_cc VALUES("240","19","0","","","91","NC-0005/2018","","500","500","910","","0","2018-03-12","","2018-03-12 21:50:27","2018-03-12 21:50:27");
INSERT INTO sales_cc VALUES("241","19","0","286","","","RE-0008/2018","  0","","2000","","2","0","2018-03-12","","","");
INSERT INTO sales_cc VALUES("242","20","291","","","","FT-0006/2018","COT-0006/2018","1000","","1500","","1","2018-03-13","","","");
INSERT INTO sales_cc VALUES("243","19","295","","","","FT-0008/2018","COT-0008/2018","4446","","4446","","1","2018-03-13","cancelado","","");
INSERT INTO sales_cc VALUES("244","20","0","","","178","ND-0007/2018","","2340","","2340","","1","2018-03-13","","2018-03-12 22:29:41","2018-03-12 22:29:41");
INSERT INTO sales_cc VALUES("245","20","0","","","92","NC-0006/2018","","1469.29","1469.29","1469.29","","0","2018-03-13","","2018-03-12 22:32:56","2018-03-12 22:32:56");
INSERT INTO sales_cc VALUES("307","20","345","","","","FT-0021/2018","COT-0043/2018","500","","500","","0","2018-04-03","","","");
INSERT INTO sales_cc VALUES("248","21","297","","","","FT-0009/2018","COT-0009/2018","2925","","0","","1","2018-03-13","","","");
INSERT INTO sales_cc VALUES("249","21","0","","","179","ND-0008/2018","","1170","","0","","1","2018-03-13","","2018-03-13 08:27:31","2018-03-13 08:27:31");
INSERT INTO sales_cc VALUES("250","21","0","","","93","NC-0007/2018","","2000","2000","0","","0","2018-03-13","","2018-03-13 08:29:01","2018-03-13 08:29:01");
INSERT INTO sales_cc VALUES("251","21","0","292","","","RE-0011/2018","  0","","3095","","2","1","2018-03-13","","","");
INSERT INTO sales_cc VALUES("252","22","299","","","","FT-0010/2018","COT-0010/2018","2340","","1000","","1","2018-03-13","","","");
INSERT INTO sales_cc VALUES("253","22","0","","","180","ND-0009/2018","","1170","","0","","1","2018-03-13","","2018-03-13 08:57:07","2018-03-13 08:57:07");
INSERT INTO sales_cc VALUES("254","22","0","","","94","NC-0008/2018","","2340","2340","0","","0","2018-03-13","","2018-03-13 08:58:52","2018-03-13 08:58:52");
INSERT INTO sales_cc VALUES("255","22","0","295","","","RE-0012/2018","  0","","170","","2","1","2018-03-13","","","");
INSERT INTO sales_cc VALUES("256","21","0","","","95","NC-0009/2018","","1170","1170","0","","0","2018-03-13","","2018-03-13 12:37:30","2018-03-13 12:37:30");
INSERT INTO sales_cc VALUES("257","18","0","298","","","RE-0013/2018","  0","","300","","2","1","2018-03-13","","","");
INSERT INTO sales_cc VALUES("258","18","0","301","","","RE-0013/2018","  0","","300","","2","1","2018-03-13","","","");
INSERT INTO sales_cc VALUES("259","21","0","304","","","RE-0014/2018","  0","","-2170","","2","0","2018-03-13","","","");
INSERT INTO sales_cc VALUES("260","20","301","","","","FT-0011/2018","COT-0011/2018","8190","","8190","","1","2018-03-14","","","");
INSERT INTO sales_cc VALUES("261","24","303","","","","FT-0012/2018","COT-0012/2018","14360","","0","","1","2018-03-15","","","");
INSERT INTO sales_cc VALUES("262","24","305","","","","FT-0013/2018","COT-0013/2018","30420","","0","","1","2018-03-15","","","");
INSERT INTO sales_cc VALUES("263","24","0","","","181","ND-0010/2018","","11700","","0","","1","2018-03-15","","2018-03-15 12:59:24","2018-03-15 12:59:24");
INSERT INTO sales_cc VALUES("264","24","0","","","96","NC-0010/2018","","5850","5850","0","","0","2018-03-15","","2018-03-15 13:33:12","2018-03-15 13:33:12");
INSERT INTO sales_cc VALUES("265","24","0","306","","","RE-0015/2018","  0","","8510","","2","1","2018-03-15","","","");
INSERT INTO sales_cc VALUES("266","24","0","308","","","RE-0016/2018","  0","","40420","","2","1","2018-03-15","","","");
INSERT INTO sales_cc VALUES("267","24","0","309","","","RE-0017/2018","  0","","1700","","2","1","2018-03-15","","","");
INSERT INTO sales_cc VALUES("268","19","0","310","","","RE-0018/2018","  0","","-300","","2","1","2018-03-15","","","");
INSERT INTO sales_cc VALUES("269","24","307","","","","FT-0014/2018","COT-0014/2018","5850","","5850","","1","2018-03-16","cancelado","","");
INSERT INTO sales_cc VALUES("270","17","309","","","","FT-0015/2018","COT-0016/2018","858195","","840000","","1","2018-03-16","","","");
INSERT INTO sales_cc VALUES("271","29","311","","","","FT-0016/2018","COT-0017/2018","6435","","6435","","0","2018-03-19","","","");
INSERT INTO sales_cc VALUES("272","18","313","","","","FT-0017/2018","COT-0018/2018","585","","130","","0","2018-03-19","","","");
INSERT INTO sales_cc VALUES("273","31","315","","","","FT-0018/2018","COT-0019/2018","11350","","11350","","0","2018-03-19","cancelado","","");
INSERT INTO sales_cc VALUES("274","33","318","","","","FT-0019/2018","COT-0021/2018","37440","","500","","0","2018-03-19","","","");
INSERT INTO sales_cc VALUES("315","20","353","","","","FT-0021/2018","COT-0047/2018","17292.6","","17292.6","","1","2018-04-04","","","");
INSERT INTO sales_cc VALUES("282","15","0","312","","","RE-0019/2018","  0","","1000","","2","1","2018-03-22","","","");
INSERT INTO sales_cc VALUES("283","18","0","314","","","RE-0020/2018","  0","","1934","","2","1","2018-03-22","","","");
INSERT INTO sales_cc VALUES("284","18","0","317","","","RE-0021/2018","  183","","1701","","2","1","2018-03-22","","","");
INSERT INTO sales_cc VALUES("286","17","309","319","","","RE-0023/2018"," COT-0016/2018","","1000","","2","1","2018-03-23","","","");
INSERT INTO sales_cc VALUES("287","19","0","322","","","RE-0024/2018","  0","","210","","2","1","2018-03-23","","","");
INSERT INTO sales_cc VALUES("288","19","0","325","","","RE-0025/2018","  0","","350","","2","1","2018-03-23","","","");
INSERT INTO sales_cc VALUES("289","20","291","326","","","RE-0026/2018"," COT-0006/2018","","500","","2","1","2018-03-23","","","");
INSERT INTO sales_cc VALUES("290","19","289","327","","","RE-0027/2018"," COT-0005/2018","","1000","","2","1","2018-03-23","","","");
INSERT INTO sales_cc VALUES("291","19","289","328","","","RE-0028/2018"," COT-0005/2018","","500","","2","1","2018-03-23","","","");
INSERT INTO sales_cc VALUES("295","58","341","","","","FT-0019/2018","COT-0040/2018","1150","","500","","1","2018-03-23","","","");
INSERT INTO sales_cc VALUES("314","20","301","","","102","NC-0013/2018","","11700","11700","11700","","0","2018-04-03","","2018-04-03 12:21:55","2018-04-03 12:21:55");
INSERT INTO sales_cc VALUES("316","18","0","354","","","RE-0037/2018","  191","","1425","","2","1","2018-04-04","","","");
INSERT INTO sales_cc VALUES("301","59","343","","","99","NC-0011/2018","","4000","4000","4000","","0","2018-04-02","","2018-04-02 13:30:58","2018-04-02 13:30:58");
INSERT INTO sales_cc VALUES("306","17","309","349","","","RE-0036/2018"," COT-0016/2018","","9000","","2","1","2018-04-02","","","");
INSERT INTO sales_cc VALUES("309","59","0","","","101","NC-0012/2018","","500","500","500","","0","2018-04-03","","2018-04-03 03:56:01","2018-04-03 03:56:01");
INSERT INTO sales_cc VALUES("317","59","355","","","","FT-0022/2018","COT-0048/2018","37989","","37989","","1","2018-04-04","","","");
INSERT INTO sales_cc VALUES("311","63","348","","","","FT-0019/2018","COT-0044/2018","5000","","5000","","1","2018-04-03","","","");
INSERT INTO sales_cc VALUES("312","24","351","","","","FT-0020/2018","COT-0046/2018","500","","500","","1","2018-04-03","","","");
INSERT INTO sales_cc VALUES("313","18","191","","","191","ND-0014/2018","","11115","","10110","","1","2018-04-03","","2018-04-03 12:09:00","2018-04-03 12:09:00");
INSERT INTO sales_cc VALUES("318","15","357","","","","FT-0023/2018","COT-0049/2018","1000","","1000","","1","2018-04-05","","","");
INSERT INTO sales_cc VALUES("319","15","359","","","","FT-0024/2018","COT-0050/2018","49715.39","","49715.39","","1","2018-04-09","","","");
INSERT INTO sales_cc VALUES("320","59","361","","","","FT-0025/2018","COT-0051/2018","3240","","3240","","1","2018-04-10","","","");
INSERT INTO sales_cc VALUES("321","20","363","","","","FT-0026/2018","COT-0052/2018","1351","","1351","","1","2018-04-10","","","");
INSERT INTO sales_cc VALUES("322","66","365","","","","FT-0027/2018","COT-0053/2018","2000","","2000","","1","2018-04-10","","","");
INSERT INTO sales_cc VALUES("323","19","367","","","","FT-0028/2018","COT-0054/2018","914.53","","914.53","","1","2018-04-11","","","");
INSERT INTO sales_cc VALUES("324","19","369","","","","FT-0029/2018","COT-0055/2018","900","","900","","1","2018-04-11","","","");
INSERT INTO sales_cc VALUES("325","19","371","","","","FT-0030/2018","COT-0056/2018","1000","","1000","","1","2018-04-11","","","");
INSERT INTO sales_cc VALUES("326","19","373","","","","FT-0031/2018","COT-0057/2018","1000","","1000","","1","2018-04-11","","","");
INSERT INTO sales_cc VALUES("327","19","375","","","","FT-0032/2018","COT-0058/2018","1000","","1000","","1","2018-04-11","","","");
INSERT INTO sales_cc VALUES("328","20","377","","","","FT-0033/2018","COT-0059/2018","1000","","1000","","1","2018-04-11","","","");
INSERT INTO sales_cc VALUES("329","18","379","","","","FT-0034/2018","COT-0060/2018","1000","","1000","","1","2018-04-11","","","");
INSERT INTO sales_cc VALUES("330","19","381","","","","FT-0035/2018","COT-0061/2018","1000","","1000","","1","2018-04-11","","","");
INSERT INTO sales_cc VALUES("331","21","383","","","","FT-0036/2018","COT-0062/2018","1000","","0","","1","2018-04-11","","","");
INSERT INTO sales_cc VALUES("332","19","385","","","","FT-0037/2018","COT-0063/2018","1000","","1000","","1","2018-04-11","","","");
INSERT INTO sales_cc VALUES("333","18","387","","","","FT-0038/2018","COT-0064/2018","1000","","1000","","1","2018-04-11","","","");
INSERT INTO sales_cc VALUES("334","19","389","","","","FT-0039/2018","COT-0065/2018","1000","","1000","","1","2018-04-11","","","");
INSERT INTO sales_cc VALUES("335","21","391","","","","FT-0040/2018","COT-0066/2018","2000","","0","","1","2018-04-11","","","");
INSERT INTO sales_cc VALUES("336","20","393","","","","FT-0041/2018","COT-0067/2018","914.53","","914.53","","1","2018-04-11","","","");
INSERT INTO sales_cc VALUES("337","19","395","","","","FT-0042/2018","COT-0068/2018","15050.53","","15050.53","","1","2018-04-11","","","");
INSERT INTO sales_cc VALUES("338","59","397","","","","FT-0043/2018","COT-0069/2018","2000.02","","2000.02","","1","2018-04-12","","","");
INSERT INTO sales_cc VALUES("339","20","399","","","","FT-0044/2018","COT-0070/2018","1170","","1170","","1","2018-04-12","","","");
INSERT INTO sales_cc VALUES("340","59","401","","","","FT-0045/2018","COT-0071/2018","1141.92","","1141.92","","1","2018-04-12","","","");
INSERT INTO sales_cc VALUES("341","65","403","","","","FT-0046/2018","COT-0072/2018","22530.01","","22530.01","","1","2018-04-12","","","");
INSERT INTO sales_cc VALUES("342","22","405","","","","FT-0047/2018","COT-0073/2018","5914.53","","5914.53","","1","2018-04-12","","","");
INSERT INTO sales_cc VALUES("343","21","407","","","","FT-0048/2018","COT-0074/2018","58020","","0","","1","2018-04-12","","","");
INSERT INTO sales_cc VALUES("344","59","409","","","","FT-0049/2018","COT-0075/2018","32208","","32208","","1","2018-04-12","","","");
INSERT INTO sales_cc VALUES("345","65","411","","","","FT-0050/2018","COT-0076/2018","12740","","12740","","1","2018-04-12","cancelado","","");
INSERT INTO sales_cc VALUES("346","59","413","","","","FT-0050/2018","COT-0077/2018","1952","","1952","","1","2018-04-12","","","");
INSERT INTO sales_cc VALUES("347","65","415","","","","FT-0051/2018","COT-0078/2018","19119.1","","19119.1","","1","2018-04-13","","","");
INSERT INTO sales_cc VALUES("348","18","417","","","","FT-0052/2018","COT-0079/2018","1000","","1000","","1","2018-04-13","","","");
INSERT INTO sales_cc VALUES("349","59","419","","","","FT-0053/2018","COT-0080/2018","976","","976","","1","2018-04-13","","","");
INSERT INTO sales_cc VALUES("350","59","421","","","","FT-0054/2018","COT-0081/2018","11712","","11712","","1","2018-04-13","","","");
INSERT INTO sales_cc VALUES("351","59","423","","","","FT-0055/2018","COT-0082/2018","976","","976","","1","2018-04-13","","","");
INSERT INTO sales_cc VALUES("352","67","425","","","","FT-0056/2018","COT-0083/2018","10350","","10350","","1","2018-04-13","","","");
INSERT INTO sales_cc VALUES("353","67","427","","","","FT-0057/2018","COT-0084/2018","1000","","1000","","1","2018-04-13","","","");
INSERT INTO sales_cc VALUES("354","18","428","","","","FT-0058/2018","COT-0085/2018","32760","","32760","","0","2018-04-13","","","");
INSERT INTO sales_cc VALUES("355","19","0","","","103","NC-0014/2018","","1170","1170","1170","","0","2018-04-13","","2018-04-13 13:16:14","2018-04-13 13:16:14");
INSERT INTO sales_cc VALUES("356","19","0","","","104","NC-0015/2018","","1170","1170","1170","","0","2018-04-13","","2018-04-13 13:20:24","2018-04-13 13:20:24");
INSERT INTO sales_cc VALUES("357","69","431","","","","FT-0059/2018","COT-0086/2018","7000","","7000","","1","2018-04-13","","","");
INSERT INTO sales_cc VALUES("358","15","0","","","105","NC-0016/2018","","117000","117000","117000","","0","2018-04-16","","2018-04-16 08:32:26","2018-04-16 08:32:26");
INSERT INTO sales_cc VALUES("359","59","434","","","","FT-0060/2018","COT-0088/2018","23424","","23424","","1","2018-04-17","","","");
INSERT INTO sales_cc VALUES("360","73","437","","","","FT-0061/2018","COT-0091/2018","11000","","890","","0","2018-04-17","","","");
INSERT INTO sales_cc VALUES("361","21","455","","","","FT-0061/2018","COT-0107/2018","900","","890","","0","2018-04-17","","","");
INSERT INTO sales_cc VALUES("362","21","455","358","","","RE-0038/2018"," COT-0107/2018","","61030","","2","1","2018-04-18","","","");
INSERT INTO sales_cc VALUES("363","95","457","","","","FT-0062/2018","COT-0108/2018","7300.01","","7300.01","","0","2018-04-18","","","");
INSERT INTO sales_cc VALUES("364","19","465","","","","FT-0063/2018","COT-0113/2018","0","","0","","1","2018-04-18","","","");
INSERT INTO sales_cc VALUES("365","19","0","","","192","ND-0015/2018","","0","","0","","1","2018-04-18","","2018-04-18 09:25:01","2018-04-18 09:25:01");
INSERT INTO sales_cc VALUES("366","15","0","","","106","NC-0017/2018","","0","0","0","","0","2018-04-18","","2018-04-18 09:25:22","2018-04-18 09:25:22");
INSERT INTO sales_cc VALUES("367","116","466","","","","FT-0064/2018","COT-0114/2018","1000","","0","","0","2018-04-18","","","");
INSERT INTO sales_cc VALUES("368","117","468","","","","FT-0065/2018","COT-0115/2018","1000","","1000","","1","2018-04-18","","","");
INSERT INTO sales_cc VALUES("369","20","471","","","","FT-0066/2018","COT-0116/2018","1000","","1000","","1","2018-04-18","","","");
INSERT INTO sales_cc VALUES("370","70","432","","","","FT-0067/2018","COT-0087/2018","20007","","20007","","0","2018-04-16","","","");
INSERT INTO sales_cc VALUES("371","70","432","","","","FT-0068/2018","COT-0087/2018","20007","","20007","","0","2018-04-16","","","");
INSERT INTO sales_cc VALUES("372","118","474","","","","FT-0069/2018","COT-0117/2018","6000","","0","","1","2018-04-18","","","");
INSERT INTO sales_cc VALUES("373","118","474","359","","","RE-0039/2018"," COT-0117/2018","","6000","","2","1","2018-04-18","","","");
INSERT INTO sales_cc VALUES("374","105","477","","","","FT-0070/2018","COT-0118/2018","6000","","6000","","1","2018-04-18","","","");
INSERT INTO sales_cc VALUES("375","121","481","","","","FT-0071/2018","COT-0122/2018","43524","","43524","","1","2018-04-18","","","");
INSERT INTO sales_cc VALUES("376","1","483","","","","FT-0072/2018","COT-0123/2018","1000","","1000","","1","2018-04-18","","","");
INSERT INTO sales_cc VALUES("377","126","486","","","","FT-0071/2018","COT-0125/2018","1000","","1000","","1","2018-04-18","","","");
INSERT INTO sales_cc VALUES("378","121","480","","","","FT-0072/2018","COT-0121/2018","19000","","19000","","1","2018-04-18","","","");
INSERT INTO sales_cc VALUES("379","130","490","","","","FT-0073/2018","COT-0127/2018","6000","","6000","","1","2018-04-18","","","");
INSERT INTO sales_cc VALUES("380","132","493","","","","FT-0074/2018","COT-0128/2018","8000","","8000","","1","2018-04-18","","","");
INSERT INTO sales_cc VALUES("381","134","495","","","","FT-0075/2018","COT-0129/2018","25720","","25720","","1","2018-04-18","","","");
INSERT INTO sales_cc VALUES("382","134","496","","","","FT-0076/2018","COT-0130/2018","7000","","7000","","1","2018-04-18","","","");
INSERT INTO sales_cc VALUES("383","134","499","","","","FT-0077/2018","COT-0131/2018","1000","","1000","","1","2018-04-18","","","");
INSERT INTO sales_cc VALUES("384","125","485","","","","FT-0078/2018","COT-0124/2018","1000","","1000","","1","2018-04-18","","","");
INSERT INTO sales_cc VALUES("385","19","193","","","193","ND-0016/2018","","1170","","1170","","1","2018-04-19","","2018-04-19 07:02:48","2018-04-19 07:02:48");
INSERT INTO sales_cc VALUES("386","134","194","","","194","ND-0017/2018","","34230","","34230","","1","2018-04-19","","2018-04-19 07:32:50","2018-04-19 07:32:50");
INSERT INTO sales_cc VALUES("387","18","195","","","195","ND-0018/2018","","1170","","1170","","1","2018-04-19","","2018-04-19 07:35:48","2018-04-19 07:35:48");
INSERT INTO sales_cc VALUES("388","19","293","","","107","NC-0018/2018","","1170","1170","1170","","0","2018-04-19","","2018-04-19 08:14:01","2018-04-19 08:14:01");
INSERT INTO sales_cc VALUES("389","136","501","","","","FT-0079/2018","COT-0132/2018","1000","","1000","","1","2018-04-19","","","");
INSERT INTO sales_cc VALUES("390","138","503","","","","FT-0080/2018","COT-0133/2018","7030","","7030","","1","2018-04-19","","","");
INSERT INTO sales_cc VALUES("391","139","505","","","","FT-0081/2018","COT-0134/2018","9000","","9000","","1","2018-04-19","","","");





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
) ENGINE=MyISAM AUTO_INCREMENT=108 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_credito VALUES("87","585","0","2018-03-12","201","17","2","NC-0001/2018","0","","directInvoice","PL","2","0","1","","","");
INSERT INTO sales_credito VALUES("88","11700","0","2018-03-12","201","17","2","NC-0002/2018","0","","directInvoice","PL","2","11700","3","","","");
INSERT INTO sales_credito VALUES("89","500","0","2018-03-12","201","15","2","NC-0003/2018","0","","directInvoice","PL","2","375","1","","","");
INSERT INTO sales_credito VALUES("90","1000","0","2018-03-12","201","18","2","NC-0004/2018","0","","directInvoice","PL","2","200","1","","","");
INSERT INTO sales_credito VALUES("91","500","0","2018-03-12","201","19","2","NC-0005/2018","0","","directInvoice","PL","2","410","1","","","");
INSERT INTO sales_credito VALUES("92","1469.29","0","2018-03-13","201","20","2","NC-0006/2018","0","","directInvoice","PL","2","0","1","","","");
INSERT INTO sales_credito VALUES("93","2000","0","2018-03-13","201","21","2","NC-0007/2018","0","","directInvoice","PL","2","2000","1","","","");
INSERT INTO sales_credito VALUES("94","2340","0","2018-03-13","201","22","2","NC-0008/2018","0","","directInvoice","PL","2","2340","1","","","");
INSERT INTO sales_credito VALUES("95","1170","0","2018-03-13","201","21","2","NC-0009/2018","0","","directInvoice","PL","2","1170","1","","","");
INSERT INTO sales_credito VALUES("96","5850","0","2018-03-15","201","24","2","NC-0010/2018","0","","directInvoice","PL","2","5850","1","","","");
INSERT INTO sales_credito VALUES("99","4000","343","2018-04-02","201","59","2","NC-0011/2018","0","","directInvoice","PL","2","0","1","","","");
INSERT INTO sales_credito VALUES("101","500","0","2018-04-03","201","59","2","NC-0012/2018","0","","directInvoice","PL","2","0","1","","","");
INSERT INTO sales_credito VALUES("102","11700","301","2018-04-03","201","20","2","NC-0013/2018","0","","directInvoice","PL","2","0","1","","","");
INSERT INTO sales_credito VALUES("103","1170","0","2018-04-13","201","19","2","NC-0014/2018","0","","directInvoice","PL","2","0","1","","","");
INSERT INTO sales_credito VALUES("104","1170","0","2018-04-13","201","19","2","NC-0015/2018","0","","directInvoice","PL","2","0","1","","","");
INSERT INTO sales_credito VALUES("105","117000","0","2018-04-16","201","15","2","NC-0016/2018","0","","directInvoice","PL","2","0","1","","","");
INSERT INTO sales_credito VALUES("106","0","0","2018-04-18","201","15","2","NC-0017/2018","0","","directInvoice","PL","2","0","1","","","");
INSERT INTO sales_credito VALUES("107","1170","293","2018-04-19","201","19","2","NC-0018/2018","0","","directInvoice","PL","2","0","1","","","");





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
  PRIMARY KEY (`debit_no`),
  KEY `sales_debito_order_no_id_foreign` (`order_no_id`)
) ENGINE=MyISAM AUTO_INCREMENT=196 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_debito VALUES("172","1170","0","2018-03-12","201","17","2","ND-0001/2018","0","","directInvoice","PL","2","1170","1","","","");
INSERT INTO sales_debito VALUES("192","0","0","2018-04-18","201","19","2","ND-0015/2018","0","","directInvoice","PL","2","0","1","","","");
INSERT INTO sales_debito VALUES("175","1000","0","2018-03-12","201","15","2","ND-0004/2018","0","","directInvoice","PL","2","1000","1","","","");
INSERT INTO sales_debito VALUES("176","1000","0","2018-03-12","201","18","2","ND-0005/2018","0","","directInvoice","PL","2","200","1","","","");
INSERT INTO sales_debito VALUES("177","2340","0","2018-03-12","201","19","2","ND-0006/2018","0","","directInvoice","PL","2","2160","1","","","");
INSERT INTO sales_debito VALUES("178","2340","0","2018-03-13","201","20","2","ND-0007/2018","0","","directInvoice","PL","2","0","1","","","");
INSERT INTO sales_debito VALUES("179","1170","0","2018-03-13","201","21","2","ND-0008/2018","0","","directInvoice","PL","2","1170","1","","","");
INSERT INTO sales_debito VALUES("180","1170","0","2018-03-13","201","22","2","ND-0009/2018","0","","directInvoice","PL","2","1170","1","","","");
INSERT INTO sales_debito VALUES("181","11700","0","2018-03-15","201","24","2","ND-0010/2018","0","","directInvoice","PL","2","11700","1","","","");
INSERT INTO sales_debito VALUES("193","1170","295","2018-04-19","201","19","2","ND-0016/2018","0","","directInvoice","PL","2","0","1","","","");
INSERT INTO sales_debito VALUES("194","34230","497","2018-04-19","201","134","2","ND-0017/2018","0","","directInvoice","PL","2","0","1","","","");
INSERT INTO sales_debito VALUES("191","11115","314","2018-04-03","201","18","2","ND-0014/2018","0","","directInvoice","PL","2","1005","1","","","");
INSERT INTO sales_debito VALUES("195","1170","287","2018-04-19","201","18","2","ND-0018/2018","0","","directInvoice","PL","2","0","1","","","");





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
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_details_vd VALUES("34","35","11","1","Servico de traducao de documentos","500","1","1","0","","");
INSERT INTO sales_details_vd VALUES("35","36","11","1","Servico de traducao de documentos","500","7","1","0","","");
INSERT INTO sales_details_vd VALUES("36","36","2","1","Iphone","5000","5","1","0","","");
INSERT INTO sales_details_vd VALUES("37","37","11","1","Servico de traducao de documentos","500","4","1","0","","");
INSERT INTO sales_details_vd VALUES("38","38","11","1","Servico de traducao de documentos","500","10","1","0","","");
INSERT INTO sales_details_vd VALUES("39","38","2","1","Iphone","5000","1","1","0","","");
INSERT INTO sales_details_vd VALUES("40","39","11","1","Servico de traducao de documentos","500","10","1","0","","");
INSERT INTO sales_details_vd VALUES("41","39","11","1","Instalação de Software","500","5","0","0","","");
INSERT INTO sales_details_vd VALUES("42","40","11","3","Servico de traducao de documentos","500","10","1","0","","");
INSERT INTO sales_details_vd VALUES("43","40","2","3","Iphone","5000","10","1","0","","");
INSERT INTO sales_details_vd VALUES("44","41","2","1","Iphone","5000","2","1","0","","");
INSERT INTO sales_details_vd VALUES("45","41","11","1","Servico de traducao de documentos","500","10","1","0","","");
INSERT INTO sales_details_vd VALUES("46","42","2","3","Iphone","5000","10","1","0","","");
INSERT INTO sales_details_vd VALUES("47","42","11","3","Servico de traducao de documentos","500","10","1","0","","");
INSERT INTO sales_details_vd VALUES("48","43","11","1","Servico de traducao de documentos","500","5","1","0","","");
INSERT INTO sales_details_vd VALUES("49","44","11","1","Servico de traducao de documentos","500","15","1","0","","");
INSERT INTO sales_details_vd VALUES("50","45","0","3","Servico de consultoria ","4000","1","0","0","","");
INSERT INTO sales_details_vd VALUES("51","46","0","2","Hospedagem de servicos ","43000","1","0","0","","");





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
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_ge VALUES("32","GE-0001/2018","8190","2018-03-16","Malhagalene","Julio Baptista","AAA-539_MC","MMMM","24","24","","","");
INSERT INTO sales_ge VALUES("34","GE-0002/2018","8346835.04","2018-04-03","matola agaree","Local motorista","11003023","AAA-BC-MC","59","59","","","");
INSERT INTO sales_ge VALUES("35","GE-0003/2018","0","2018-04-18","Matola Agare","Julio Antonio Bptista","","","18","18","","","");





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
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

INSERT INTO sales_ge_details VALUES("44","32","201","","3","Apple watch","7000","0","1","1","0");
INSERT INTO sales_ge_details VALUES("47","34","201","","1","Servico de traducao de documentos","500","0","100","1","0");
INSERT INTO sales_ge_details VALUES("48","34","201","","3","hhghgg","899","0","7888","0","0");





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
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_gt VALUES("32","GT-0003/2018","87000","2018-03-22","Av Acordos de lusaca 208, Bairro Polana","Joao Ribeiro ","10002389239","ACY-439-MP","19","19","","","");
INSERT INTO sales_gt VALUES("33","GT-0004/2018","0","2018-04-02","Matola Agare","Julio Baptista","10001210","AAA-BB-MC","15","15","","","");
INSERT INTO sales_gt VALUES("34","GT-0005/2018","1000","2018-04-02","Motola C","Julio Matavel","11003023","AAA-BC-MC","18","18","","","");
INSERT INTO sales_gt VALUES("35","GT-0006/2018","0","2018-05-03","matola agaree","Matias cossa","1212121213","AAA-BC-MC","18","18","","","");





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
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;

INSERT INTO sales_gt_details VALUES("70","32","201","","3","Serviço de instalação de redes de computadores","3000","0","1","1","0");
INSERT INTO sales_gt_details VALUES("74","33","201","","2","Serviço de instalação de redes de computadores","1000","0","1","1","0");
INSERT INTO sales_gt_details VALUES("71","32","201","","3","sistema de gestao de stock","2000","0","1","1","10");
INSERT INTO sales_gt_details VALUES("72","32","201","","3","N3 pacote Basic","2000","0","1","1","0");
INSERT INTO sales_gt_details VALUES("73","32","201","09","3","Tecno","20000","0","4","1","0");
INSERT INTO sales_gt_details VALUES("75","33","201","zero","2","Novo servico ","89090","0","1","0","0");
INSERT INTO sales_gt_details VALUES("76","34","201","","1","instalacao da frita de camiões de carga para armazenamento","1000","0","1","1","0");
INSERT INTO sales_gt_details VALUES("77","35","201","11","3","Servico de traducao de documentos","500","0","1","1","0");
INSERT INTO sales_gt_details VALUES("78","35","201","","1","instalacao da frita de camiões de carga para armazenamento","1000","0","1","1","0");
INSERT INTO sales_gt_details VALUES("79","35","201","zero","3","shdhsd","5650","0","2000","0","0");





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
  `tipo_operacao` varchar(190) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sales_order_details_sales_debito_idx` (`debit_no_id`)
) ENGINE=MyISAM AUTO_INCREMENT=802 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_order_details VALUES("506","","281","202","","3","teste","10000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("507","","172","201","zero","3","Transporte das mercadorias ","1000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("508","","87","201","zero","3","acerto","500","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("509","","283","202","","3","servico teste","10","0","1000","0","0","","","");
INSERT INTO sales_order_details VALUES("510","","173","201","zero","2","No sistema para as pessoas ","2000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("511","","174","201","zero","3","novo","2000","0","1","0","10","","","");
INSERT INTO sales_order_details VALUES("512","","88","201","zero","3","Serviço de instalação de redes de computadores","10000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("513","","285","202","","1","Serviço de instalação de redes de computadores","1000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("514","","175","201","zero","1","Instalação de Software","1000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("515","","89","201","zero","1","nota de credito","500","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("516","","287","202","","1","instalacao da frita de camiões de carga para armazenamento","1000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("517","","176","201","zero","1","Instalação de Software","1000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("518","","90","201","zero","1","Servico de Montagem de hardware","1000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("519","","289","202","","3","Serviço de instalação de redes de computadores","3000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("520","","177","201","zero","3","Serviço de instalação de redes de computadores","2000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("521","","91","201","zero","1","Instalação de Software","500","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("522","","291","202","","1","sistema de gestao de stock","1000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("523","","295","202","","3","sistema de gestao de stock","2000","0","1","0","10","","","");
INSERT INTO sales_order_details VALUES("524","","295","202","","3","N3 pacote Basic","2000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("525","","178","201","zero","3","Internet a Cabo ","2000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("526","","92","201","zero","3","window 7","1300","0","1","0","3.4","","","");
INSERT INTO sales_order_details VALUES("527","","297","202","","3","Servico de reparacao de Tela","2000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("528","","297","202","","3","Mouse HP","500","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("529","","179","201","zero","3","Serviço de instalação de redes de computadores","1000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("530","","93","201","zero","1","Devolucao dos bens ","2000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("531","","299","202","","3","Instalação de Software","2000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("532","","180","201","zero","3","Net Plus","1000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("533","","94","201","zero","3","Instalação de Software windows 7","2000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("534","","95","201","zero","3","instalacao da frita de camiões de carga para armazenamento","1000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("535","","301","202","009","3","Apple watch","7000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("536","","295","201","09","3","Tecno","20000","0","4","1","0","","","");
INSERT INTO sales_order_details VALUES("537","","305","202","009","3","Apple watch","7000","0","3","1","0","","","");
INSERT INTO sales_order_details VALUES("538","","305","202","02","3","Iphone","5000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("539","","181","201","zero","3","Servico de consultoria ","10000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("540","","96","201","zero","3","Servico de localizacao","5000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("541","","307","202","02","3","Iphone","5000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("542","","308","201","11","3","Servico de traducao de documentos","500","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("543","","308","201","02","3","Iphone","5000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("544","","308","201","009","3","Apple watch","7000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("545","","309","201","02","3","Iphone","5000","0","100","1","10","","","");
INSERT INTO sales_order_details VALUES("546","","309","201","01","3","Motorola","6000","0","50","1","10","","","");
INSERT INTO sales_order_details VALUES("547","","309","201","11","3","Servico de traducao de documentos","500","0","30","1","10","","","");
INSERT INTO sales_order_details VALUES("548","","310","202","02","3","Iphone","5000","0","100","1","10","","","");
INSERT INTO sales_order_details VALUES("549","","310","202","01","3","Motorola","6000","0","50","1","10","","","");
INSERT INTO sales_order_details VALUES("550","","310","202","11","3","Servico de traducao de documentos","500","0","30","1","10","","","");
INSERT INTO sales_order_details VALUES("620","","191","201","11","3","Servico de traducao de documentos","500","0","1","1","0","debito","","");
INSERT INTO sales_order_details VALUES("619","","191","201","PP","3","Novo Smartphone","9000","0","1","1","0","debito","","");
INSERT INTO sales_order_details VALUES("618","","351","202","11","1","Servico de traducao de documentos","500","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("555","","313","201","11","3","Servico de traducao de documentos","500","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("556","","314","202","11","3","Servico de traducao de documentos","500","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("557","","315","201","11","1","Servico de traducao de documentos","500","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("558","","315","201","09","3","Tecno","5000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("559","","315","201","02","1","Iphone","5000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("560","","316","202","11","1","Servico de traducao de documentos","500","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("561","","316","202","09","3","Tecno","5000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("562","","316","202","02","1","Iphone","5000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("563","","317","201","11","1","Servico de traducao de documentos","500","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("564","","317","201","02","1","Iphone","5000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("565","","318","201","zero","3","Serviço de instalação de redes de computadores","30000","0","1","0","10","","","");
INSERT INTO sales_order_details VALUES("566","","318","201","02","3","Iphone","5000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("594","","183","201","02","1","Iphone","5000","0","2","1","0","","","");
INSERT INTO sales_order_details VALUES("593","","182","201","11","2","Servico de traducao de documentos","500","0","10","1","0","","","");
INSERT INTO sales_order_details VALUES("569","","320","201","02","3","Iphone","5000","0","10","1","0","","","");
INSERT INTO sales_order_details VALUES("570","","320","201","11","3","Servico de traducao de documentos","500","0","10","1","0","","","");
INSERT INTO sales_order_details VALUES("571","","321","201","11","3","Servico de traducao de documentos","500","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("572","","321","201","02","3","Iphone","5000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("574","","323","201","11","1","Servico de traducao de documentos","500","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("575","","324","201","11","3","Servico de traducao de documentos","500","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("576","","325","201","02","1","Iphone","5000","0","10","1","0","","","");
INSERT INTO sales_order_details VALUES("577","","325","201","11","1","Servico de traducao de documentos","500","0","10","1","0","","","");
INSERT INTO sales_order_details VALUES("578","","328","201","zero","3","Aulas de Base de dados ","4500","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("579","","329","201","zero","1","Aula de base cde dados","3000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("580","","330","201","zero","3","Aula de base de dados","43000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("581","","331","201","11","3","Servico de traducao de documentos","500","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("582","","332","201","11","3","Servico de traducao de documentos","5000","0","107","1","0","","","");
INSERT INTO sales_order_details VALUES("590","","338","201","zero","3","Servico de marketing digital","500","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("589","","338","201","zero","3","Servico de traducao de documentos","200","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("585","","334","201","zero","3","In0stalacao do sistema de gestao","3000","0","1","0","1","","","");
INSERT INTO sales_order_details VALUES("586","","335","201","11","1","Servico de traducao de documentos","5000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("587","","336","201","zero","1","No sistema para as pessoas ","2000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("588","","337","201","11","3","Servico de traducao de documentos","5000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("591","","339","201","11","3","Servico de traducao de documentos","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("592","","339","201","zero","3","Servicos de traducao","5000","0","1","0","10","","","");
INSERT INTO sales_order_details VALUES("595","","185","201","02","3","Iphone","5000","0","2","1","0","","","");
INSERT INTO sales_order_details VALUES("596","","186","201","02","1","Iphone","5000","0","2","1","0","","","");
INSERT INTO sales_order_details VALUES("598","","97","201","02","3","Iphone","5000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("599","","97","201","zero","3","Montagem de redes de computador","8978","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("621","","102","201","11","3","Servico de traducao de documentos","500","0","2","1","0","credito","","");
INSERT INTO sales_order_details VALUES("616","","348","202","11","1","Servico de traducao de documentos","500","0","10","1","0","","","");
INSERT INTO sales_order_details VALUES("617","","349","201","11","3","Servico de traducao de documentos","500","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("623","","353","202","11","3","Servico de traducao de documentos","500","0","4","1","10","","","");
INSERT INTO sales_order_details VALUES("622","","102","201","PP","3","Novo Smartphone","9000","0","1","1","0","credito","","");
INSERT INTO sales_order_details VALUES("608","","99","201","zero","1","Bonus de aniversario","4000","0","1","0","0","credito","","");
INSERT INTO sales_order_details VALUES("609","","344","201","II","3","iphone 3","12000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("610","","344","201","02","3","Iphone","5000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("611","","345","201","11","1","Servico de traducao de documentos","500","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("614","","101","201","11","1","Servico de traducao de documentos","500","0","1","1","0","credito","","");
INSERT INTO sales_order_details VALUES("624","","353","202","II","3","iphone 3","1200","0","10","1","0","","","");
INSERT INTO sales_order_details VALUES("625","","353","202","II","3","Servico de instalacao ","1000","0","1","0","2","","","");
INSERT INTO sales_order_details VALUES("626","","355","202","11","3","Servico de traducao de documentos","500","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("627","","355","202","PP","3","Novo Smartphone","9000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("628","","355","202","II","3","iphone 3","12000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("629","","355","202","02","3","Iphone","5000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("630","","355","202","09","3","Tecno","5000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("631","","357","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("632","","359","202","","1","Sistema de gestao de stock","9000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("633","","359","202","09","1","Tecno","9000","0","4","1","9","","","");
INSERT INTO sales_order_details VALUES("634","","359","202","02","3","IPHONE","5000","0","1","1","9","","","");
INSERT INTO sales_order_details VALUES("635","","359","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("636","","359","202","OO","3","PAPEL","2000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("637","","361","202","","2","Paracemol da comutarias  AA-BB-CC","3000","0","1","0","40","","","");
INSERT INTO sales_order_details VALUES("638","","361","202","","3","servicol de |M","1000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("639","","363","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("640","","363","202","11","3","Encadernacao do sistema de gestao","300","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("641","","365","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("642","","365","202","11","3","Instalacao do servico ","1000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("643","","367","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("644","","369","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("645","","371","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("646","","373","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("647","","389","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("648","","391","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","2","1","0","","","");
INSERT INTO sales_order_details VALUES("649","","393","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("650","","395","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("651","","395","202","09","3","Tecno","4273.5","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("652","","395","202","01","3","Motorola","6000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("653","","395","202","PARACETAMOL 500 MG","1","Paracetamol","10","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("654","","395","202","OO","3","PAPEL","2000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("655","","397","202","11","2","SERVICO DE TRADUCAO DE DOCUMENTOS","869.57","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("656","","397","202","11","2","Sistema Operativo Windows 10","1000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("657","","399","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("658","","401","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","2.4","","","");
INSERT INTO sales_order_details VALUES("659","","403","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("660","","403","202","09","3","Tecno","4273.5","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("661","","403","202","PP","3","Novo Smartphone","9000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("662","","403","202","01","3","Motorola","5128.21","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("663","","405","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("664","","405","202","09","3","Tecno","4273.5","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("665","","407","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("666","","407","202","01","3","Motorola","6000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("667","","407","202","09","3","Tecno","4273.504","0","10","1","0","","","");
INSERT INTO sales_order_details VALUES("668","","409","202","11","1","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","2.4","","","");
INSERT INTO sales_order_details VALUES("669","","409","202","02","1","IPHONE","5000","0","1","1","2.4","","","");
INSERT INTO sales_order_details VALUES("670","","409","202","II","1","iphone 3","12000","0","1","1","2.4","","","");
INSERT INTO sales_order_details VALUES("671","","409","202","01","1","Motorola","6000","0","1","1","2.4","","","");
INSERT INTO sales_order_details VALUES("672","","409","202","PP","1","Novo Smartphone","9000","0","1","1","2.4","","","");
INSERT INTO sales_order_details VALUES("677","","413","202","11","1","Consultoria RH","1000","0","1","0","2.4","","","");
INSERT INTO sales_order_details VALUES("676","","413","202","11","1","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","2.4","","","");
INSERT INTO sales_order_details VALUES("678","","415","202","11","1","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","9","","","");
INSERT INTO sales_order_details VALUES("679","","415","202","PP","1","Novo Smartphone","9000","0","1","1","9","","","");
INSERT INTO sales_order_details VALUES("680","","415","202","01","1","Motorola","6000","0","1","1","9","","","");
INSERT INTO sales_order_details VALUES("681","","415","202","PARACETAMOL 500 MG","1","Paracetamol","10","0","1","1","9","","","");
INSERT INTO sales_order_details VALUES("682","","415","202","02","1","IPHONE","5000","0","1","1","9","","","");
INSERT INTO sales_order_details VALUES("683","","417","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("684","","419","202","11","1","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","2.4","","","");
INSERT INTO sales_order_details VALUES("685","","421","202","11","1","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","2.4","","","");
INSERT INTO sales_order_details VALUES("686","","421","202","02","1","IPHONE","5000","0","1","1","2.4","","","");
INSERT INTO sales_order_details VALUES("687","","421","202","01","1","Motorola","6000","0","1","1","2.4","","","");
INSERT INTO sales_order_details VALUES("688","","423","202","11","1","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","2.4","","","");
INSERT INTO sales_order_details VALUES("689","","425","202","PP","2","Novo Smartphone","9000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("690","","427","202","11","1","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("691","","428","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("692","","428","201","PP","3","Novo Smartphone","9000","0","3","1","0","","","");
INSERT INTO sales_order_details VALUES("693","","429","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("694","","429","202","PP","3","Novo Smartphone","9000","0","3","1","0","","","");
INSERT INTO sales_order_details VALUES("695","","103","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","credito","","");
INSERT INTO sales_order_details VALUES("696","","104","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","credito","","");
INSERT INTO sales_order_details VALUES("697","","431","202","77","3","windows 10","5982.91","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("698","","105","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","100","1","0","credito","","");
INSERT INTO sales_order_details VALUES("699","","432","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("700","","432","201","009","3","Apple watch","7000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("701","","432","201","01","3","Motorola","6000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("702","","432","201","09","3","Tecno","5000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("703","","434","202","11","1","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","2.4","","","");
INSERT INTO sales_order_details VALUES("704","","434","202","11","1","Prestacao de servicos na area de traducao","20000","0","1","0","2.4","","","");
INSERT INTO sales_order_details VALUES("705","","434","202","11","1","Malaria ","3000","0","1","0","2.4","","","");
INSERT INTO sales_order_details VALUES("706","","435","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("707","","435","201","zero","3","Servico de consultoria em RH","4000","0","1","0","0","","","");
INSERT INTO sales_order_details VALUES("708","","436","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("727","","457","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","2","1","10","","","");
INSERT INTO sales_order_details VALUES("738","","466","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("739","","467","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("713","","440","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("714","","440","201","zero","3","Sistema de gestao de base de dados","1000","0","1","0","10","","","");
INSERT INTO sales_order_details VALUES("715","","441","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("716","","442","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("717","","443","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("718","","444","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("719","","449","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","0","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("720","","450","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","0","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("721","","451","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","0","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("722","","452","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("723","","453","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","0","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("728","","457","201","09","3","Tecno","4273.5","0","1","1","50","","","");
INSERT INTO sales_order_details VALUES("729","","457","201","01","3","Motorola","5128.22","0","1","1","50","","","");
INSERT INTO sales_order_details VALUES("730","","458","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","2","1","10","","","");
INSERT INTO sales_order_details VALUES("731","","458","202","09","3","Tecno","4273.5","0","1","1","50","","","");
INSERT INTO sales_order_details VALUES("732","","458","202","01","3","Motorola","5128.22","0","1","1","50","","","");
INSERT INTO sales_order_details VALUES("742","","471","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("741","","469","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("740","","468","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("743","","472","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("744","","472","202","009","3","Apple watch","7000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("745","","472","202","01","3","Motorola","6000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("746","","472","202","09","3","Tecno","5000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("747","","473","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("748","","473","202","009","3","Apple watch","7000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("749","","473","202","01","3","Motorola","6000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("750","","473","202","09","3","Tecno","5000","0","1","1","10","","","");
INSERT INTO sales_order_details VALUES("751","","474","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("752","","474","201","09","3","Tecno","4273.5","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("753","","475","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("754","","475","202","09","3","Tecno","4273.5","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("755","","477","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("756","","477","202","09","3","Tecno","4273.5","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("757","","478","201","11","1","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","2.4","","","");
INSERT INTO sales_order_details VALUES("758","","478","201","09","1","Tecno","5000","0","1","1","2.4","","","");
INSERT INTO sales_order_details VALUES("759","","479","201","11","1","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","2.4","","","");
INSERT INTO sales_order_details VALUES("760","","480","201","09","3","Tecno","4273.5","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("761","","480","201","77","3","windows 10","5982.91","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("762","","480","201","00","3","WINDOWS","5982.91","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("767","","485","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("768","","486","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("765","","483","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("769","","487","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("770","","488","202","09","3","Tecno","4273.5","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("771","","488","202","77","3","windows 10","5982.91","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("772","","488","202","00","3","WINDOWS","5982.91","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("773","","489","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("774","","490","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("775","","490","201","09","3","Tecno","4273.5","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("776","","491","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("777","","491","202","09","3","Tecno","4273.5","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("778","","493","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("779","","493","202","00","3","WINDOWS","5982.91","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("780","","495","202","PP","3","Novo Smartphone","9000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("781","","495","202","009","3","Apple watch","7000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("782","","495","202","00","3","WINDOWS","5982.91","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("783","","496","201","00","3","WINDOWS","5982.91","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("784","","497","202","00","3","WINDOWS","5982.91","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("785","","499","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("786","","500","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("787","","193","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","debito","","");
INSERT INTO sales_order_details VALUES("788","","194","201","02","3","IPHONE","5000","0","1","1","0","debito","","");
INSERT INTO sales_order_details VALUES("789","","194","201","II","1","iphone 3","12000","0","1","1","0","debito","","");
INSERT INTO sales_order_details VALUES("790","","194","201","77","3","windows 10","7000","0","1","1","0","debito","","");
INSERT INTO sales_order_details VALUES("791","","194","201","00","3","WINDOWS","7000","0","1","1","0","debito","","");
INSERT INTO sales_order_details VALUES("792","","195","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","debito","","");
INSERT INTO sales_order_details VALUES("793","","107","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","1000","0","1","1","0","credito","","");
INSERT INTO sales_order_details VALUES("794","","501","201","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("795","","502","202","11","3","SERVICO DE TRADUCAO DE DOCUMENTOS","854.7","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("796","","503","201","01","3","Motorola","6000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("797","","503","201","PARACETAMOL 500 MG","1","Paracetamol","10","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("798","","504","202","01","3","Motorola","6000","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("799","","504","202","PARACETAMOL 500 MG","1","Paracetamol","10","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("800","","505","201","PP","3","Novo Smartphone","7692.31","0","1","1","0","","","");
INSERT INTO sales_order_details VALUES("801","","506","202","PP","3","Novo Smartphone","7692.31","0","1","1","0","","","");





CREATE TABLE IF NOT EXISTS `sales_orders` (
  `order_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `trans_type` mediumint(9) NOT NULL,
  `invoice_type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `debtor_no` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
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
  `status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`order_no`)
) ENGINE=MyISAM AUTO_INCREMENT=507 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_orders VALUES("280","201","indirectOrder","17","17","2","COT-0001/2018","","0","","","2018-03-12","0","PL","2","11700","0","0","","","2018-03-12 08:18:25","");
INSERT INTO sales_orders VALUES("281","202","directInvoice","17","17","2","FT-0001/2018","","280","COT-0001/2018","","2018-03-12","0","PL","2","11700","11700","1","","","2018-03-12 08:18:25","");
INSERT INTO sales_orders VALUES("282","201","indirectOrder","17","17","2","COT-0002/2018","","0","","","2018-03-12","0","PL","2","11700","0","0","","","2018-03-12 09:23:51","");
INSERT INTO sales_orders VALUES("283","202","directInvoice","17","17","2","FT-0002/2018","","282","COT-0002/2018","","2018-03-12","0","PL","2","11700","11700","1","","","2018-03-12 09:23:51","");
INSERT INTO sales_orders VALUES("284","201","indirectOrder","15","15","2","COT-0003/2018","","0","","","2018-03-12","0","PL","2","1000","0","0","","","2018-03-12 12:32:11","");
INSERT INTO sales_orders VALUES("285","202","directInvoice","15","15","2","FT-0003/2018","","284","COT-0003/2018","","2018-03-12","0","PL","2","1000","1000","1","","","2018-03-12 12:32:11","");
INSERT INTO sales_orders VALUES("286","201","indirectOrder","18","18","2","COT-0004/2018","","0","","","2018-03-12","0","PL","2","1000","0","0","","","2018-03-12 13:37:48","");
INSERT INTO sales_orders VALUES("287","202","directInvoice","18","18","2","FT-0004/2018","","286","COT-0004/2018","","2018-03-12","0","PL","2","1000","650","1","","","2018-03-12 13:37:48","");
INSERT INTO sales_orders VALUES("288","201","indirectOrder","19","19","2","COT-0005/2018","","0","","","2018-03-12","0","PL","2","1170","0","0","","","2018-03-12 21:42:07","");
INSERT INTO sales_orders VALUES("289","202","directInvoice","19","19","2","FT-0005/2018","","288","COT-0005/2018","","2018-03-12","0","PL","2","3510","2010","1","","","2018-03-12 21:42:07","2018-03-15 09:32:17");
INSERT INTO sales_orders VALUES("290","201","indirectOrder","20","20","2","COT-0006/2018","","0","","","2018-03-13","0","PL","2","1000","0","0","","","2018-03-12 22:12:16","");
INSERT INTO sales_orders VALUES("291","202","directInvoice","20","20","2","FT-0006/2018","","290","COT-0006/2018","","2018-03-13","0","PL","2","1000","500","1","","","2018-03-12 22:12:16","");
INSERT INTO sales_orders VALUES("292","201","indirectOrder","19","19","2","COT-0007/2018","","0","","","2018-03-13","0","PL","2","2000","0","0","","","2018-03-12 22:18:19","");
INSERT INTO sales_orders VALUES("293","202","directInvoice","19","19","2","FT-0007/2018","","292","COT-0007/2018","","2018-03-13","0","PL","2","2000","0","1","","","2018-03-12 22:18:19","");
INSERT INTO sales_orders VALUES("294","201","indirectOrder","19","19","2","COT-0008/2018","","0","","","2018-03-13","0","PL","2","4446","0","0","","","2018-03-12 22:22:08","");
INSERT INTO sales_orders VALUES("295","202","directInvoice","19","19","2","FT-0008/2018","","294","COT-0008/2018","","2018-03-13","0","PL","2","27846","0","1","cancelado","Cancelado por falha do user","2018-03-12 22:22:08","2018-03-15 09:28:10");
INSERT INTO sales_orders VALUES("296","201","indirectOrder","21","21","2","COT-0009/2018","","0","","","2018-03-13","0","PL","2","2925","0","0","","","2018-03-13 08:02:25","");
INSERT INTO sales_orders VALUES("297","202","directInvoice","21","21","2","FT-0009/2018","","296","COT-0009/2018","","2018-03-13","0","PL","2","2925","2925","1","","","2018-03-13 08:02:25","");
INSERT INTO sales_orders VALUES("298","201","indirectOrder","22","22","2","COT-0010/2018","","0","","","2018-03-13","0","PL","2","2340","0","0","","","2018-03-13 08:55:51","");
INSERT INTO sales_orders VALUES("299","202","directInvoice","22","22","2","FT-0010/2018","","298","COT-0010/2018","","2018-03-13","0","PL","2","2340","1340","1","","","2018-03-13 08:55:51","");
INSERT INTO sales_orders VALUES("300","201","indirectOrder","20","20","2","COT-0011/2018","","0","","","2018-03-14","0","PL","2","8190","0","0","","","2018-03-14 14:07:06","");
INSERT INTO sales_orders VALUES("301","202","directInvoice","20","20","2","FT-0011/2018","","300","COT-0011/2018","","2018-03-14","0","PL","2","8190","0","1","","","2018-03-14 14:07:06","");
INSERT INTO sales_orders VALUES("302","201","indirectOrder","24","24","2","COT-0012/2018","","0","","","2018-03-15","0","PL","2","14360","0","0","","","2018-03-15 12:40:32","");
INSERT INTO sales_orders VALUES("303","202","directInvoice","24","24","2","FT-0012/2018","","302","COT-0012/2018","","2018-03-15","0","PL","2","14360","14360","1","","","2018-03-15 12:40:32","");
INSERT INTO sales_orders VALUES("304","201","indirectOrder","24","24","2","COT-0013/2018","","0","","","2018-03-15","0","PL","2","30420","0","0","","","2018-03-15 12:58:22","");
INSERT INTO sales_orders VALUES("305","202","directInvoice","24","24","2","FT-0013/2018","","304","COT-0013/2018","","2018-03-15","0","PL","2","30420","30420","1","","","2018-03-15 12:58:22","");
INSERT INTO sales_orders VALUES("306","201","indirectOrder","24","24","2","COT-0014/2018","","0","","","2018-03-16","0","PL","2","5850","0","0","","","2018-03-16 08:10:13","");
INSERT INTO sales_orders VALUES("307","202","directInvoice","24","24","2","FT-0014/2018","","306","COT-0014/2018","","2018-03-16","0","PL","2","5850","0","1","cancelado","falha do user","2018-03-16 08:10:13","2018-04-03 07:15:02");
INSERT INTO sales_orders VALUES("308","201","directOrder","23","23","2","COT-0015/2018","","0","","","2018-03-16","0","PL","2","14625","0","2","","","2018-03-16 12:39:34","");
INSERT INTO sales_orders VALUES("309","201","directOrder","17","17","2","COT-0016/2018","","0","","","2018-03-16","0","PL","2","858195","0","2","","","2018-03-16 14:49:10","");
INSERT INTO sales_orders VALUES("310","202","directInvoice","17","17","2","FT-0015/2018","","309","COT-0016/2018","","2018-03-16","0","PL","2","858195","18195","2","","","2018-03-16 14:49:26","");
INSERT INTO sales_orders VALUES("352","201","indirectOrder","20","20","2","COT-0047/2018","","0","","","2018-04-04","0","PL","2","17292.6","0","0","","","2018-04-04 08:15:20","");
INSERT INTO sales_orders VALUES("350","201","indirectOrder","24","24","2","COT-0046/2018","","0","","","2018-04-03","0","PL","2","500","0","0","","","2018-04-03 07:51:40","");
INSERT INTO sales_orders VALUES("313","201","directOrder","18","18","2","COT-0018/2018","","0","","","2018-03-19","0","PL","2","585","0","2","","","2018-03-19 09:02:50","");
INSERT INTO sales_orders VALUES("314","202","directInvoice","18","18","2","FT-0017/2018","","313","COT-0018/2018","","2018-03-19","0","PL","2","585","455","2","","","2018-03-19 09:03:02","");
INSERT INTO sales_orders VALUES("315","201","directOrder","31","15","2","COT-0019/2018","","0","","","2018-03-19","0","PL","2","11350","0","2","","","2018-03-19 09:22:26","");
INSERT INTO sales_orders VALUES("316","202","directInvoice","31","15","2","FT-0018/2018","","315","COT-0019/2018","","2018-03-19","0","PL","2","11350","0","2","cancelado","Teste o seu conhecimento","2018-03-19 09:22:54","2018-03-19 09:26:44");
INSERT INTO sales_orders VALUES("317","201","directOrder","32","31","2","COT-0020/2018","","0","","","2018-03-19","0","PL","2","5500","0","2","","","2018-03-19 12:08:21","");
INSERT INTO sales_orders VALUES("318","201","directOrder","33","17","2","COT-0021/2018","","0","","","2018-03-19","0","PL","2","37440","0","2","","","2018-03-19 12:17:33","");
INSERT INTO sales_orders VALUES("320","201","directOrder","34","15","2","COT-0022/2018","","0","","","2018-03-19","0","PL","2","64350","0","2","","","2018-03-19 12:24:31","");
INSERT INTO sales_orders VALUES("321","201","directOrder","35","20","2","COT-0023/2018","","0","","","2018-03-19","0","PL","2","6435","0","2","","","2018-03-19 12:35:21","");
INSERT INTO sales_orders VALUES("323","201","directOrder","40","40","2","COT-0024/2018","","0","","","2018-03-19","0","PL","2","500","0","2","","","2018-03-19 14:01:36","");
INSERT INTO sales_orders VALUES("324","201","directOrder","41","41","2","COT-0025/2018","","0","","","2018-03-19","0","PL","2","585","0","2","","","2018-03-19 14:02:53","");
INSERT INTO sales_orders VALUES("325","201","directOrder","42","42","2","COT-0026/2018","","0","","","2018-03-19","0","PL","2","55000","0","2","","","2018-03-19 14:26:38","");
INSERT INTO sales_orders VALUES("327","201","directOrder","44","44","2","COT-0027/2018","","0","","","2018-03-19","0","PL","2","0","0","2","","","2018-03-19 14:33:13","");
INSERT INTO sales_orders VALUES("328","201","directOrder","45","45","2","COT-0028/2018","","0","","","2018-03-19","0","PL","2","5265","0","2","","","2018-03-19 14:35:38","");
INSERT INTO sales_orders VALUES("329","201","directOrder","46","46","2","COT-0029/2018","","0","","","2018-03-19","0","PL","2","3000","0","2","","","2018-03-19 14:46:51","");
INSERT INTO sales_orders VALUES("330","201","directOrder","47","47","2","COT-0030/2018","","0","","","2018-03-19","0","PL","2","50310","0","2","","","2018-03-19 15:31:43","");
INSERT INTO sales_orders VALUES("331","201","directOrder","19","19","2","COT-0031/2018","","0","","","2018-03-19","0","PL","2","585","0","2","","","2018-03-19 15:44:03","");
INSERT INTO sales_orders VALUES("332","201","directOrder","49","49","2","COT-0032/2018","","0","","","2018-03-20","0","PL","2","625950","0","2","","","2018-03-20 06:57:31","");
INSERT INTO sales_orders VALUES("338","201","directOrder","55","55","2","COT-0038/2018","","0","","","2018-03-20","0","PL","2","819","0","2","","","2018-03-20 13:22:39","");
INSERT INTO sales_orders VALUES("334","201","directOrder","19","19","2","COT-0034/2018","","0","","","2018-03-20","0","PL","2","3474.9","0","2","","","2018-03-20 08:04:49","");
INSERT INTO sales_orders VALUES("335","201","directOrder","45","40","2","COT-0035/2018","","0","","","2018-03-20","0","PL","2","5000","0","2","","","2018-03-20 08:32:32","2018-03-20 12:56:51");
INSERT INTO sales_orders VALUES("336","201","directOrder","26","26","2","COT-0036/2018","","0","","","2018-03-20","0","PL","2","2000","0","2","","","2018-03-20 08:52:00","");
INSERT INTO sales_orders VALUES("337","201","directOrder","45","45","2","COT-0037/2018","","0","","","2018-03-20","0","PL","2","5850","0","2","","","2018-03-20 09:03:31","2018-03-20 12:56:15");
INSERT INTO sales_orders VALUES("339","201","directOrder","56","56","2","COT-0039/2018","","0","","","2018-03-20","0","PL","2","6435","0","2","","","2018-03-20 14:01:06","");
INSERT INTO sales_orders VALUES("340","201","indirectOrder","58","58","2","COT-0040/2018","","0","","","2018-03-23","0","PL","2","1150","0","0","","","2018-03-23 14:15:19","");
INSERT INTO sales_orders VALUES("347","201","indirectOrder","63","63","2","COT-0044/2018","","0","","","2018-04-03","0","PL","2","5000","0","0","","","2018-04-03 07:22:34","");
INSERT INTO sales_orders VALUES("342","201","indirectOrder","59","59","2","COT-0041/2018","","0","","","2018-04-02","0","PL","2","50000","0","0","","","2018-04-02 13:27:15","");
INSERT INTO sales_orders VALUES("348","202","directInvoice","63","63","2","FT-0019/2018","","347","COT-0044/2018","","2018-04-03","0","PL","2","5000","0","1","","","2018-04-03 07:22:34","");
INSERT INTO sales_orders VALUES("344","201","directOrder","61","61","2","COT-0042/2018","","0","","","2018-04-03","0","PL","2","19890","0","2","","","2018-04-03 03:50:10","");
INSERT INTO sales_orders VALUES("345","201","directOrder","20","20","2","COT-0043/2018","","0","","","2018-04-03","0","PL","2","500","0","2","","","2018-04-03 03:50:53","");
INSERT INTO sales_orders VALUES("349","201","directOrder","64","64","2","COT-0045/2018","","0","","","2018-04-03","0","PL","2","585","0","2","","","2018-04-03 07:27:47","");
INSERT INTO sales_orders VALUES("351","202","directInvoice","24","24","2","FT-0020/2018","","350","COT-0046/2018","","2018-04-03","0","PL","2","500","0","1","","","2018-04-03 07:51:40","");
INSERT INTO sales_orders VALUES("353","202","directInvoice","20","20","2","FT-0021/2018","","352","COT-0047/2018","","2018-04-04","0","PL","2","17292.6","0","1","","","2018-04-04 08:15:20","");
INSERT INTO sales_orders VALUES("354","201","indirectOrder","59","59","2","COT-0048/2018","","0","","Descricao!","2018-04-04","0","PL","2","37989","0","0","","","2018-04-04 14:46:16","");
INSERT INTO sales_orders VALUES("355","202","directInvoice","59","59","2","FT-0022/2018","","354","COT-0048/2018","Descricao!","2018-04-04","0","PL","2","37989","0","1","","","2018-04-04 14:46:16","");
INSERT INTO sales_orders VALUES("356","201","indirectOrder","15","15","2","COT-0049/2018","","0","","","2018-04-05","0","PL","2","1000","0","0","","","2018-04-05 21:36:33","");
INSERT INTO sales_orders VALUES("357","202","directInvoice","15","15","2","FT-0023/2018","","356","COT-0049/2018","","2018-04-05","0","PL","2","1000","0","1","","","2018-04-05 21:36:33","");
INSERT INTO sales_orders VALUES("358","201","indirectOrder","15","15","2","COT-0050/2018","","0","","","2018-04-09","0","PL","2","49715.39","0","0","","","2018-04-09 13:38:11","");
INSERT INTO sales_orders VALUES("359","202","directInvoice","15","15","2","FT-0024/2018","","358","COT-0050/2018","","2018-04-09","0","PL","2","49715.39","0","1","","","2018-04-09 13:38:11","");
INSERT INTO sales_orders VALUES("360","201","indirectOrder","59","59","2","COT-0051/2018","","0","","","2018-04-10","0","PL","2","3240","0","0","","","2018-04-10 14:24:43","");
INSERT INTO sales_orders VALUES("361","202","directInvoice","59","59","2","FT-0025/2018","","360","COT-0051/2018","","2018-04-10","0","PL","2","3240","0","1","","","2018-04-10 14:24:43","");
INSERT INTO sales_orders VALUES("362","201","indirectOrder","20","20","2","COT-0052/2018","","0","","","2018-04-10","0","PL","2","1351","0","0","","","2018-04-10 14:26:15","");
INSERT INTO sales_orders VALUES("363","202","directInvoice","20","20","2","FT-0026/2018","","362","COT-0052/2018","","2018-04-10","0","PL","2","1351","0","1","","","2018-04-10 14:26:15","");
INSERT INTO sales_orders VALUES("364","201","indirectOrder","66","66","2","COT-0053/2018","","0","","","2018-04-10","0","PL","2","2000","0","0","","","2018-04-10 21:06:44","");
INSERT INTO sales_orders VALUES("365","202","directInvoice","66","66","2","FT-0027/2018","","364","COT-0053/2018","","2018-04-10","0","PL","2","2000","0","1","","","2018-04-10 21:06:44","");
INSERT INTO sales_orders VALUES("366","201","indirectOrder","19","19","2","COT-0054/2018","","0","","","2018-04-11","0","PL","2","914.53","0","0","","","2018-04-11 14:44:37","");
INSERT INTO sales_orders VALUES("367","202","directInvoice","19","19","2","FT-0028/2018","","366","COT-0054/2018","","2018-04-11","0","PL","2","914.53","0","1","","","2018-04-11 14:44:37","");
INSERT INTO sales_orders VALUES("368","201","indirectOrder","19","19","2","COT-0055/2018","","0","","","2018-04-11","0","PL","2","900","0","0","","","2018-04-11 20:31:18","");
INSERT INTO sales_orders VALUES("369","202","directInvoice","19","19","2","FT-0029/2018","","368","COT-0055/2018","","2018-04-11","0","PL","2","900","0","1","","","2018-04-11 20:31:18","");
INSERT INTO sales_orders VALUES("370","201","indirectOrder","19","19","2","COT-0056/2018","","0","","","2018-04-11","0","PL","2","1000","0","0","","","2018-04-11 20:32:56","");
INSERT INTO sales_orders VALUES("371","202","directInvoice","19","19","2","FT-0030/2018","","370","COT-0056/2018","","2018-04-11","0","PL","2","1000","0","1","","","2018-04-11 20:32:56","");
INSERT INTO sales_orders VALUES("372","201","indirectOrder","19","19","2","COT-0057/2018","","0","","","2018-04-11","0","PL","2","1000","0","0","","","2018-04-11 20:34:37","");
INSERT INTO sales_orders VALUES("373","202","directInvoice","19","19","2","FT-0031/2018","","372","COT-0057/2018","","2018-04-11","0","PL","2","1000","0","1","","","2018-04-11 20:34:37","");
INSERT INTO sales_orders VALUES("374","201","indirectOrder","19","19","2","COT-0058/2018","","0","","","2018-04-11","0","PL","2","1000","0","0","","","2018-04-11 20:35:42","");
INSERT INTO sales_orders VALUES("375","202","directInvoice","19","19","2","FT-0032/2018","","374","COT-0058/2018","","2018-04-11","0","PL","2","1000","0","1","","","2018-04-11 20:35:42","");
INSERT INTO sales_orders VALUES("376","201","indirectOrder","20","20","2","COT-0059/2018","","0","","","2018-04-11","0","PL","2","1000","0","0","","","2018-04-11 20:37:00","");
INSERT INTO sales_orders VALUES("377","202","directInvoice","20","20","2","FT-0033/2018","","376","COT-0059/2018","","2018-04-11","0","PL","2","1000","0","1","","","2018-04-11 20:37:00","");
INSERT INTO sales_orders VALUES("378","201","indirectOrder","18","18","2","COT-0060/2018","","0","","","2018-04-11","0","PL","2","1000","0","0","","","2018-04-11 20:38:30","");
INSERT INTO sales_orders VALUES("379","202","directInvoice","18","18","2","FT-0034/2018","","378","COT-0060/2018","","2018-04-11","0","PL","2","1000","0","1","","","2018-04-11 20:38:30","");
INSERT INTO sales_orders VALUES("380","201","indirectOrder","19","19","2","COT-0061/2018","","0","","","2018-04-11","0","PL","2","1000","0","0","","","2018-04-11 20:39:16","");
INSERT INTO sales_orders VALUES("381","202","directInvoice","19","19","2","FT-0035/2018","","380","COT-0061/2018","","2018-04-11","0","PL","2","1000","0","1","","","2018-04-11 20:39:16","");
INSERT INTO sales_orders VALUES("382","201","indirectOrder","21","21","2","COT-0062/2018","","0","","","2018-04-11","0","PL","2","1000","0","0","","","2018-04-11 20:40:41","");
INSERT INTO sales_orders VALUES("383","202","directInvoice","21","21","2","FT-0036/2018","","382","COT-0062/2018","","2018-04-11","0","PL","2","1000","1000","1","","","2018-04-11 20:40:41","");
INSERT INTO sales_orders VALUES("384","201","indirectOrder","19","19","2","COT-0063/2018","","0","","","2018-04-11","0","PL","2","1000","0","0","","","2018-04-11 20:41:38","");
INSERT INTO sales_orders VALUES("385","202","directInvoice","19","19","2","FT-0037/2018","","384","COT-0063/2018","","2018-04-11","0","PL","2","1000","0","1","","","2018-04-11 20:41:38","");
INSERT INTO sales_orders VALUES("386","201","indirectOrder","18","18","2","COT-0064/2018","","0","","","2018-04-11","0","PL","2","1000","0","0","","","2018-04-11 20:45:48","");
INSERT INTO sales_orders VALUES("387","202","directInvoice","18","18","2","FT-0038/2018","","386","COT-0064/2018","","2018-04-11","0","PL","2","1000","0","1","","","2018-04-11 20:45:48","");
INSERT INTO sales_orders VALUES("388","201","indirectOrder","19","19","2","COT-0065/2018","","0","","","2018-04-11","0","PL","2","1000","0","0","","","2018-04-11 20:46:24","");
INSERT INTO sales_orders VALUES("389","202","directInvoice","19","19","2","FT-0039/2018","","388","COT-0065/2018","","2018-04-11","0","PL","2","1000","0","1","","","2018-04-11 20:46:24","");
INSERT INTO sales_orders VALUES("390","201","indirectOrder","21","21","2","COT-0066/2018","","0","","","2018-04-11","0","PL","2","2000","0","0","","","2018-04-11 20:47:39","");
INSERT INTO sales_orders VALUES("391","202","directInvoice","21","21","2","FT-0040/2018","","390","COT-0066/2018","","2018-04-11","0","PL","2","2000","2000","1","","","2018-04-11 20:47:39","");
INSERT INTO sales_orders VALUES("392","201","indirectOrder","20","20","2","COT-0067/2018","","0","","","2018-04-11","0","PL","2","914.53","0","0","","","2018-04-11 20:48:34","");
INSERT INTO sales_orders VALUES("393","202","directInvoice","20","20","2","FT-0041/2018","","392","COT-0067/2018","","2018-04-11","0","PL","2","914.53","0","1","","","2018-04-11 20:48:34","");
INSERT INTO sales_orders VALUES("394","201","indirectOrder","19","19","2","COT-0068/2018","","0","","","2018-04-11","0","PL","2","15050.53","0","0","","","2018-04-11 20:53:09","");
INSERT INTO sales_orders VALUES("395","202","directInvoice","19","19","2","FT-0042/2018","","394","COT-0068/2018","","2018-04-11","0","PL","2","15050.53","0","1","","","2018-04-11 20:53:09","");
INSERT INTO sales_orders VALUES("396","201","indirectOrder","59","59","2","COT-0069/2018","","0","","","2018-04-12","0","PL","2","2000.02","0","0","","","2018-04-12 06:39:14","");
INSERT INTO sales_orders VALUES("397","202","directInvoice","59","59","2","FT-0043/2018","","396","COT-0069/2018","","2018-04-12","0","PL","2","2000.02","0","1","","","2018-04-12 06:39:14","");
INSERT INTO sales_orders VALUES("398","201","indirectOrder","20","20","2","COT-0070/2018","","0","","","2018-04-12","0","PL","2","1170","0","0","","","2018-04-12 07:02:28","");
INSERT INTO sales_orders VALUES("399","202","directInvoice","20","20","2","FT-0044/2018","","398","COT-0070/2018","","2018-04-12","0","PL","2","1170","0","1","","","2018-04-12 07:02:28","");
INSERT INTO sales_orders VALUES("400","201","indirectOrder","59","59","2","COT-0071/2018","","0","","","2018-04-12","0","PL","2","1141.92","0","0","","","2018-04-12 07:03:02","");
INSERT INTO sales_orders VALUES("401","202","directInvoice","59","59","2","FT-0045/2018","","400","COT-0071/2018","","2018-04-12","0","PL","2","1141.92","0","1","","","2018-04-12 07:03:02","");
INSERT INTO sales_orders VALUES("402","201","indirectOrder","65","65","2","COT-0072/2018","","0","","","2018-04-12","0","PL","2","22530.01","0","0","","","2018-04-12 07:07:24","");
INSERT INTO sales_orders VALUES("403","202","directInvoice","65","65","2","FT-0046/2018","","402","COT-0072/2018","","2018-04-12","0","PL","2","22530.01","0","1","","","2018-04-12 07:07:24","");
INSERT INTO sales_orders VALUES("404","201","indirectOrder","22","22","2","COT-0073/2018","","0","","","2018-04-12","0","PL","2","5914.53","0","0","","","2018-04-12 07:12:38","");
INSERT INTO sales_orders VALUES("405","202","directInvoice","22","22","2","FT-0047/2018","","404","COT-0073/2018","","2018-04-12","0","PL","2","5914.53","0","1","","","2018-04-12 07:12:38","");
INSERT INTO sales_orders VALUES("406","201","indirectOrder","21","21","2","COT-0074/2018","","0","","","2018-04-12","0","PL","2","58020","0","0","","","2018-04-12 07:19:11","");
INSERT INTO sales_orders VALUES("407","202","directInvoice","21","21","2","FT-0048/2018","","406","COT-0074/2018","","2018-04-12","0","PL","2","58020","58020","1","","","2018-04-12 07:19:11","");
INSERT INTO sales_orders VALUES("408","201","indirectOrder","59","59","2","COT-0075/2018","","0","","","2018-04-12","0","PL","2","32208","0","0","","","2018-04-12 09:30:49","");
INSERT INTO sales_orders VALUES("409","202","directInvoice","59","59","2","FT-0049/2018","","408","COT-0075/2018","","2018-04-12","0","PL","2","32208","0","1","","","2018-04-12 09:30:49","");
INSERT INTO sales_orders VALUES("410","201","indirectOrder","65","65","2","COT-0076/2018","","0","","","2018-04-12","0","PL","2","12740","0","0","","","2018-04-12 09:36:26","");
INSERT INTO sales_orders VALUES("412","201","indirectOrder","59","59","2","COT-0077/2018","","0","","","2018-04-12","0","PL","2","1952","0","0","","","2018-04-12 14:58:35","");
INSERT INTO sales_orders VALUES("413","202","directInvoice","59","59","2","FT-0050/2018","","412","COT-0077/2018","","2018-04-12","0","PL","2","1952","0","1","","","2018-04-12 14:58:35","");
INSERT INTO sales_orders VALUES("414","201","indirectOrder","65","65","2","COT-0078/2018","","0","","","2018-04-13","0","PL","2","19119.1","0","0","","","2018-04-13 06:59:33","");
INSERT INTO sales_orders VALUES("415","202","directInvoice","65","65","2","FT-0051/2018","","414","COT-0078/2018","","2018-04-13","0","PL","2","19119.1","0","3","","","2018-04-13 06:59:33","");
INSERT INTO sales_orders VALUES("416","201","indirectOrder","18","18","2","COT-0079/2018","","0","","|Cliente nai inseto do Iva sendo assim nao podera mostar a base dos seus rendimentos ","2018-04-13","0","PL","2","1000","0","0","","","2018-04-13 07:01:31","");
INSERT INTO sales_orders VALUES("417","202","directInvoice","18","18","2","FT-0052/2018","","416","COT-0079/2018","|Cliente nai inseto do Iva sendo assim nao podera mostar a base dos seus rendimentos ","2018-04-13","0","PL","2","1000","0","1","","","2018-04-13 07:01:31","");
INSERT INTO sales_orders VALUES("418","201","indirectOrder","59","59","2","COT-0080/2018","","0","","Cliente com insecao do iva ","2018-04-13","0","PL","2","976","0","0","","","2018-04-13 07:29:19","");
INSERT INTO sales_orders VALUES("419","202","directInvoice","59","59","2","FT-0053/2018","","418","COT-0080/2018","Cliente com insecao do iva ","2018-04-13","0","PL","2","976","0","1","","","2018-04-13 07:29:19","");
INSERT INTO sales_orders VALUES("420","201","indirectOrder","59","59","2","COT-0081/2018","","0","","Cliente com  isenção da taxa do iva. ","2018-04-13","0","PL","2","11712","0","0","","","2018-04-13 07:37:48","");
INSERT INTO sales_orders VALUES("421","202","directInvoice","59","59","2","FT-0054/2018","","420","COT-0081/2018","Cliente com  isenção da taxa do iva. ","2018-04-13","0","PL","2","11712","0","1","","","2018-04-13 07:37:48","");
INSERT INTO sales_orders VALUES("422","201","indirectOrder","59","59","2","COT-0082/2018","","0","","Cliente com  isenção da taxa do iva. ","2018-04-13","0","PL","2","976","0","0","","","2018-04-13 09:22:53","");
INSERT INTO sales_orders VALUES("423","202","directInvoice","59","59","2","FT-0055/2018","","422","COT-0082/2018","Cliente com  isenção da taxa do iva. ","2018-04-13","0","PL","2","976","0","1","","","2018-04-13 09:22:53","");
INSERT INTO sales_orders VALUES("424","201","indirectOrder","67","67","2","COT-0083/2018","","0","","Cliente com  isenção da taxa do iva. ","2018-04-13","0","PL","2","10350","0","0","","","2018-04-13 09:56:51","");
INSERT INTO sales_orders VALUES("425","202","directInvoice","67","67","2","FT-0056/2018","","424","COT-0083/2018","Cliente com  isenção da taxa do iva. ","2018-04-13","0","PL","2","10350","0","1","","","2018-04-13 09:56:51","");
INSERT INTO sales_orders VALUES("426","201","indirectOrder","67","67","2","COT-0084/2018","","0","","Cliente com  isenção da taxa do iva. ","2018-04-13","0","PL","2","1000","0","0","","","2018-04-13 09:58:54","");
INSERT INTO sales_orders VALUES("427","202","directInvoice","67","67","2","FT-0057/2018","","426","COT-0084/2018","Cliente com  isenção da taxa do iva. ","2018-04-13","0","PL","2","1000","0","1","","","2018-04-13 09:58:54","");
INSERT INTO sales_orders VALUES("428","201","directOrder","18","18","2","COT-0085/2018","","0","","","2018-04-13","0","PL","2","32760","0","2","","","2018-04-13 12:24:20","");
INSERT INTO sales_orders VALUES("429","202","directInvoice","18","18","2","FT-0058/2018","","428","COT-0085/2018","","2018-04-13","0","PL","2","32760","0","2","","","2018-04-13 13:03:59","");
INSERT INTO sales_orders VALUES("430","201","indirectOrder","69","69","2","COT-0086/2018","","0","","","2018-04-13","0","PL","2","7000","0","0","","","2018-04-13 13:26:02","");
INSERT INTO sales_orders VALUES("431","202","directInvoice","69","69","2","FT-0059/2018","","430","COT-0086/2018","","2018-04-13","0","PL","2","7000","0","1","","","2018-04-13 13:26:02","");
INSERT INTO sales_orders VALUES("432","201","directOrder","70","70","2","COT-0087/2018","","0","","","2018-04-16","0","PL","2","20007","0","2","","","2018-04-16 14:53:38","");
INSERT INTO sales_orders VALUES("433","201","indirectOrder","59","59","2","COT-0088/2018","","0","","Cliente com  isenção da taxa do iva. ","2018-04-17","0","PL","2","23424","0","0","","","2018-04-17 07:29:57","");
INSERT INTO sales_orders VALUES("434","202","directInvoice","59","59","2","FT-0060/2018","","433","COT-0088/2018","Cliente com  isenção da taxa do iva. ","2018-04-17","0","PL","2","23424","0","1","","","2018-04-17 07:29:57","");
INSERT INTO sales_orders VALUES("435","201","directOrder","71","71","2","COT-0089/2018","","0","","","2018-04-17","0","PL","2","5850","0","2","","","2018-04-17 07:33:36","");
INSERT INTO sales_orders VALUES("436","201","directOrder","72","72","2","COT-0090/2018","","0","","","2018-04-17","0","PL","2","1170","0","2","","","2018-04-17 13:55:33","");
INSERT INTO sales_orders VALUES("472","202","directInvoice","70","70","2","FT-0067/2018","","432","COT-0087/2018","","2018-04-16","0","PL","2","20007","0","2","","","2018-04-18 12:05:06","");
INSERT INTO sales_orders VALUES("473","202","directInvoice","70","70","2","FT-0068/2018","","432","COT-0087/2018","","2018-04-16","0","PL","2","20007","0","2","","","2018-04-18 12:07:24","");
INSERT INTO sales_orders VALUES("439","201","directOrder","20","20","2","COT-0092/2018","","0","","","2018-04-17","0","PL","2","6000","0","2","","","2018-04-17 19:38:36","");
INSERT INTO sales_orders VALUES("440","201","directOrder","20","20","2","COT-0093/2018","","0","","","2018-04-17","0","PL","2","1900","0","2","","","2018-04-17 19:41:07","");
INSERT INTO sales_orders VALUES("441","201","directOrder","19","19","2","COT-0094/2018","","0","","","2018-04-17","0","PL","2","1000","0","2","","","2018-04-17 19:45:30","");
INSERT INTO sales_orders VALUES("442","201","directOrder","19","19","2","COT-0095/2018","","0","","","2018-04-17","0","PL","2","1000","0","2","","","2018-04-17 19:48:06","");
INSERT INTO sales_orders VALUES("443","201","directOrder","18","18","2","COT-0096/2018","","0","","","2018-04-17","0","PL","2","1000","0","2","","","2018-04-17 19:50:03","");
INSERT INTO sales_orders VALUES("444","201","directOrder","18","18","2","COT-0097/2018","","0","","","2018-04-17","0","PL","2","1000","0","2","","","2018-04-17 19:53:12","");
INSERT INTO sales_orders VALUES("445","201","directOrder","20","20","2","COT-0098/2018","","0","","","2018-04-17","0","PL","2","1000","0","2","","","2018-04-17 19:56:06","");
INSERT INTO sales_orders VALUES("446","201","directOrder","19","19","2","COT-0099/2018","","0","","","2018-04-17","0","PL","2","1000","0","2","","","2018-04-17 19:56:51","");
INSERT INTO sales_orders VALUES("447","201","directOrder","18","18","2","COT-0100/2018","","0","","","2018-04-17","0","PL","2","1000","0","2","","","2018-04-17 19:59:04","");
INSERT INTO sales_orders VALUES("448","201","directOrder","19","19","2","COT-0101/2018","","0","","","2018-04-17","0","PL","2","1000","0","2","","","2018-04-17 19:59:24","");
INSERT INTO sales_orders VALUES("449","201","directOrder","18","18","2","COT-0102/2018","","0","","","2018-04-17","0","PL","2","1000","0","2","","","2018-04-17 20:02:55","");
INSERT INTO sales_orders VALUES("450","201","directOrder","19","19","2","COT-0103/2018","","0","","","2018-04-17","0","PL","2","1000","0","2","","","2018-04-17 20:04:35","");
INSERT INTO sales_orders VALUES("451","201","directOrder","18","18","2","COT-0104/2018","","0","","","2018-04-17","0","PL","2","1000","0","2","","","2018-04-17 20:07:53","");
INSERT INTO sales_orders VALUES("452","201","directOrder","20","20","2","COT-0105/2018","","0","","","2018-04-17","0","PL","2","1170","0","2","","","2018-04-17 20:08:20","");
INSERT INTO sales_orders VALUES("453","201","directOrder","18","18","2","COT-0106/2018","","0","","","2018-04-17","0","PL","2","1000","0","2","","","2018-04-17 20:09:45","");
INSERT INTO sales_orders VALUES("462","201","directOrder","15","15","2","COT-0111/2018","","0","","","2018-04-18","0","PL","2","0","0","2","","","2018-04-18 09:23:00","");
INSERT INTO sales_orders VALUES("457","201","directOrder","95","95","2","COT-0108/2018","","0","","","2018-04-18","0","PL","2","7300.01","0","2","","","2018-04-18 08:52:33","");
INSERT INTO sales_orders VALUES("458","202","directInvoice","95","95","2","FT-0062/2018","","457","COT-0108/2018","","2018-04-18","0","PL","2","7300.01","0","2","","","2018-04-18 08:53:35","");
INSERT INTO sales_orders VALUES("463","201","directOrder","20","20","2","COT-0112/2018","","0","","","2018-04-18","0","PL","2","0","0","2","","","2018-04-18 09:23:31","");
INSERT INTO sales_orders VALUES("464","201","indirectOrder","19","19","2","COT-0113/2018","","0","","","2018-04-18","0","PL","2","0","0","0","","","2018-04-18 09:24:18","");
INSERT INTO sales_orders VALUES("465","202","directInvoice","19","19","2","FT-0063/2018","","464","COT-0113/2018","","2018-04-18","0","PL","2","0","0","1","","","2018-04-18 09:24:18","");
INSERT INTO sales_orders VALUES("466","201","directOrder","116","116","2","COT-0114/2018","","0","","","2018-04-18","0","PL","2","1000","0","2","","","2018-04-18 09:43:06","");
INSERT INTO sales_orders VALUES("467","202","directInvoice","116","116","2","FT-0064/2018","","466","COT-0114/2018","","2018-04-18","0","PL","2","1000","0","2","","","2018-04-18 09:44:58","");
INSERT INTO sales_orders VALUES("468","201","directOrder","117","117","2","COT-0115/2018","","0","","","2018-04-18","0","PL","2","1000","0","2","","","2018-04-18 09:49:03","");
INSERT INTO sales_orders VALUES("469","202","directInvoice","117","117","2","FT-0065/2018","","468","COT-0115/2018","","2018-04-18","0","PL","2","1000","0","2","","","2018-04-18 09:50:04","");
INSERT INTO sales_orders VALUES("470","201","indirectOrder","20","20","2","COT-0116/2018","","0","","","2018-04-18","0","PL","2","1000","0","0","","","2018-04-18 09:55:49","");
INSERT INTO sales_orders VALUES("471","202","directInvoice","20","20","2","FT-0066/2018","","470","COT-0116/2018","","2018-04-18","0","PL","2","1000","0","1","","","2018-04-18 09:55:49","");
INSERT INTO sales_orders VALUES("474","201","directOrder","118","118","2","COT-0117/2018","","0","","","2018-04-18","0","PL","2","6000","0","2","","","2018-04-18 12:41:02","");
INSERT INTO sales_orders VALUES("475","202","directInvoice","118","118","2","FT-0069/2018","","474","COT-0117/2018","","2018-04-18","0","PL","2","6000","6000","2","","","2018-04-18 12:41:10","");
INSERT INTO sales_orders VALUES("476","201","indirectOrder","105","105","2","COT-0118/2018","","0","","","2018-04-18","0","PL","2","6000","0","0","","","2018-04-18 12:59:34","");
INSERT INTO sales_orders VALUES("477","202","directInvoice","105","105","2","FT-0070/2018","","476","COT-0118/2018","","2018-04-18","0","PL","2","6000","0","1","","","2018-04-18 12:59:34","");
INSERT INTO sales_orders VALUES("478","201","directOrder","119","119","2","COT-0119/2018","","0","","Cliente com  isenção da taxa do iva. ","2018-04-18","0","PL","2","5856","0","2","","","2018-04-18 13:18:19","");
INSERT INTO sales_orders VALUES("479","201","directOrder","59","59","2","COT-0120/2018","","0","","Cliente com  isenção da taxa do iva. ","2018-04-18","0","PL","2","976","0","2","","","2018-04-18 13:44:03","");
INSERT INTO sales_orders VALUES("480","201","directOrder","121","121","2","COT-0121/2018","","0","","","2018-04-18","0","PL","2","19000","0","2","","","2018-04-18 13:48:47","");
INSERT INTO sales_orders VALUES("485","201","directOrder","125","125","2","COT-0124/2018","","0","","","2018-04-18","0","PL","2","1000","0","2","","","2018-04-18 14:18:16","");
INSERT INTO sales_orders VALUES("486","201","directOrder","126","126","2","COT-0125/2018","","0","","","2018-04-18","0","PL","2","1000","0","2","","","2018-04-18 14:39:23","");
INSERT INTO sales_orders VALUES("483","201","directOrder","1","1","2","COT-0123/2018","","0","","","2018-04-18","0","PL","2","1000","0","2","","","2018-04-18 14:04:39","");
INSERT INTO sales_orders VALUES("487","202","directInvoice","126","126","2","FT-0071/2018","","486","COT-0125/2018","","2018-04-18","0","PL","2","1000","0","2","","","2018-04-18 14:39:46","");
INSERT INTO sales_orders VALUES("488","202","directInvoice","121","121","2","FT-0072/2018","","480","COT-0121/2018","","2018-04-18","0","PL","2","19000","0","2","","","2018-04-18 14:43:45","");
INSERT INTO sales_orders VALUES("489","201","directOrder","128","127","2","COT-0126/2018","","0","","","2018-04-18","0","PL","2","1000","0","2","","","2018-04-18 14:51:21","");
INSERT INTO sales_orders VALUES("490","201","directOrder","130","127","2","COT-0127/2018","","0","","","2018-04-18","0","PL","2","6000","0","2","","","2018-04-18 14:55:23","");
INSERT INTO sales_orders VALUES("491","202","directInvoice","130","127","2","FT-0073/2018","","490","COT-0127/2018","","2018-04-18","0","PL","2","6000","0","2","","","2018-04-18 15:00:18","");
INSERT INTO sales_orders VALUES("492","201","indirectOrder","132","127","2","COT-0128/2018","","0","","","2018-04-18","0","PL","2","8000","0","0","","","2018-04-18 17:41:07","");
INSERT INTO sales_orders VALUES("493","202","directInvoice","132","127","2","FT-0074/2018","","492","COT-0128/2018","","2018-04-18","0","PL","2","8000","0","1","","","2018-04-18 17:41:07","");
INSERT INTO sales_orders VALUES("494","201","indirectOrder","134","127","2","COT-0129/2018","","0","","","2018-04-18","0","PL","2","25720","0","0","","","2018-04-18 18:43:23","");
INSERT INTO sales_orders VALUES("495","202","directInvoice","134","157","2","FT-0075/2018","","494","COT-0129/2018","","2018-04-18","0","PL","2","25720","0","1","","","2018-04-18 18:43:23","");
INSERT INTO sales_orders VALUES("496","201","directOrder","134","134","2","COT-0130/2018","","0","","","2018-04-18","0","PL","2","7000","0","2","","","2018-04-18 19:08:42","");
INSERT INTO sales_orders VALUES("497","202","directInvoice","134","134","2","FT-0076/2018","","496","COT-0130/2018","","2018-04-18","0","PL","2","7000","0","2","","","2018-04-18 19:08:49","");
INSERT INTO sales_orders VALUES("498","201","indirectOrder","134","134","2","COT-0131/2018","","0","","","2018-04-18","0","PL","2","1000","0","0","","","2018-04-18 19:17:58","");
INSERT INTO sales_orders VALUES("499","202","directInvoice","134","134","2","FT-0077/2018","","498","COT-0131/2018","","2018-04-18","0","PL","2","1000","0","1","","","2018-04-18 19:17:58","");
INSERT INTO sales_orders VALUES("500","202","directInvoice","125","125","2","FT-0078/2018","","485","COT-0124/2018","","2018-04-18","0","PL","2","1000","0","2","","","2018-04-18 20:09:00","");
INSERT INTO sales_orders VALUES("501","201","directOrder","136","136","2","COT-0132/2018","","0","","","2018-04-19","0","PL","2","1000","0","2","","","2018-04-19 08:28:30","");
INSERT INTO sales_orders VALUES("502","202","directInvoice","136","136","2","FT-0079/2018","","501","COT-0132/2018","","2018-04-19","0","PL","2","1000","0","2","","","2018-04-19 08:30:56","");
INSERT INTO sales_orders VALUES("503","201","directOrder","138","138","2","COT-0133/2018","","0","","","2018-04-19","0","PL","2","7030","0","2","","","2018-04-19 09:23:18","");
INSERT INTO sales_orders VALUES("504","202","directInvoice","138","138","2","FT-0080/2018","","503","COT-0133/2018","","2018-04-19","0","PL","2","7030","0","2","","","2018-04-19 09:23:42","");
INSERT INTO sales_orders VALUES("505","201","directOrder","139","139","2","COT-0134/2018","","0","","","2018-04-19","0","PL","2","9000","0","2","","","2018-04-19 10:03:14","");
INSERT INTO sales_orders VALUES("506","202","directInvoice","139","139","2","FT-0081/2018","","505","COT-0134/2018","","2018-04-19","0","PL","2","9000","0","2","","","2018-04-19 10:03:26","");





CREATE TABLE IF NOT EXISTS `sales_pending` (
  `idp` int(11) NOT NULL AUTO_INCREMENT,
  `debtor_no_pending` int(10) unsigned NOT NULL,
  `order_no_pending` int(10) unsigned NOT NULL,
  `reference_pending` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `amount_total_pending` double DEFAULT NULL,
  `amount_paid_pending` double NOT NULL DEFAULT '0',
  `ord_date_pending` date NOT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idp`),
  KEY `sales_pending_debtor_no_pending_foreign` (`debtor_no_pending`),
  KEY `sales_pending_order_no_pending_foreign` (`order_no_pending`)
) ENGINE=MyISAM AUTO_INCREMENT=251 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_pending VALUES("144","17","281","FT-0001/2018","11700","11700","2018-03-12","","","");
INSERT INTO sales_pending VALUES("145","17","0","ND-0001/2018","1170","1170","2018-03-12","","2018-03-12 08:19:04","2018-03-12 08:19:04");
INSERT INTO sales_pending VALUES("146","17","0","NC-0001/2018","585","0","2018-03-12","","2018-03-12 08:21:33","2018-03-12 08:21:33");
INSERT INTO sales_pending VALUES("147","17","283","FT-0002/2018","11700","11700","2018-03-12","","","");
INSERT INTO sales_pending VALUES("150","17","0","NC-0002/2018","11700","11700","2018-03-12","","2018-03-12 09:45:22","2018-03-12 09:45:22");
INSERT INTO sales_pending VALUES("151","15","285","FT-0003/2018","1000","1000","2018-03-12","","","");
INSERT INTO sales_pending VALUES("152","15","0","ND-0004/2018","1000","1000","2018-03-12","","2018-03-12 12:32:49","2018-03-12 12:32:49");
INSERT INTO sales_pending VALUES("153","15","0","NC-0003/2018","500","375","2018-03-12","","2018-03-12 12:33:27","2018-03-12 12:33:27");
INSERT INTO sales_pending VALUES("154","18","287","FT-0004/2018","1000","650","2018-03-12","","","");
INSERT INTO sales_pending VALUES("155","18","0","ND-0005/2018","1000","200","2018-03-12","","2018-03-12 13:43:30","2018-03-12 13:43:30");
INSERT INTO sales_pending VALUES("156","18","0","NC-0004/2018","1000","200","2018-03-12","","2018-03-12 13:44:08","2018-03-12 13:44:08");
INSERT INTO sales_pending VALUES("157","19","289","FT-0005/2018","1170","2010","2018-03-12","","","");
INSERT INTO sales_pending VALUES("158","19","0","ND-0006/2018","2340","2160","2018-03-12","","2018-03-12 21:48:35","2018-03-12 21:48:35");
INSERT INTO sales_pending VALUES("159","19","0","NC-0005/2018","500","410","2018-03-12","","2018-03-12 21:50:27","2018-03-12 21:50:27");
INSERT INTO sales_pending VALUES("160","20","291","FT-0006/2018","1000","500","2018-03-13","","","");
INSERT INTO sales_pending VALUES("161","19","295","FT-0008/2018","4446","0","2018-03-13","","","");
INSERT INTO sales_pending VALUES("162","20","0","ND-0007/2018","2340","0","2018-03-13","","2018-03-12 22:29:41","2018-03-12 22:29:41");
INSERT INTO sales_pending VALUES("163","20","0","NC-0006/2018","1469.29","0","2018-03-13","","2018-03-12 22:32:56","2018-03-12 22:32:56");
INSERT INTO sales_pending VALUES("164","21","297","FT-0009/2018","2925","2925","2018-03-13","","","");
INSERT INTO sales_pending VALUES("165","21","0","ND-0008/2018","1170","1170","2018-03-13","","2018-03-13 08:27:31","2018-03-13 08:27:31");
INSERT INTO sales_pending VALUES("166","21","0","NC-0007/2018","2000","2000","2018-03-13","","2018-03-13 08:29:01","2018-03-13 08:29:01");
INSERT INTO sales_pending VALUES("167","22","299","FT-0010/2018","2340","1340","2018-03-13","","","");
INSERT INTO sales_pending VALUES("168","22","0","ND-0009/2018","1170","1170","2018-03-13","","2018-03-13 08:57:07","2018-03-13 08:57:07");
INSERT INTO sales_pending VALUES("169","22","0","NC-0008/2018","2340","2340","2018-03-13","","2018-03-13 08:58:52","2018-03-13 08:58:52");
INSERT INTO sales_pending VALUES("170","21","0","NC-0009/2018","1170","1170","2018-03-13","","2018-03-13 12:37:30","2018-03-13 12:37:30");
INSERT INTO sales_pending VALUES("171","20","301","FT-0011/2018","8190","0","2018-03-14","","","");
INSERT INTO sales_pending VALUES("172","24","303","FT-0012/2018","14360","14360","2018-03-15","","","");
INSERT INTO sales_pending VALUES("173","24","305","FT-0013/2018","30420","30420","2018-03-15","","","");
INSERT INTO sales_pending VALUES("174","24","0","ND-0010/2018","11700","11700","2018-03-15","","2018-03-15 12:59:24","2018-03-15 12:59:24");
INSERT INTO sales_pending VALUES("175","24","0","NC-0010/2018","5850","5850","2018-03-15","","2018-03-15 13:33:12","2018-03-15 13:33:12");
INSERT INTO sales_pending VALUES("176","24","307","FT-0014/2018","5850","0","2018-03-16","","","");
INSERT INTO sales_pending VALUES("196","20","353","FT-0021/2018","17292.6","0","2018-04-04","","","");
INSERT INTO sales_pending VALUES("195","20","301","NC-0013/2018","11700","0","2018-04-03","","2018-04-03 12:21:55","2018-04-03 12:21:55");
INSERT INTO sales_pending VALUES("184","58","341","FT-0019/2018","1150","-650","2018-03-23","","","");
INSERT INTO sales_pending VALUES("186","59","343","FT-0020/2018","50000","0","2018-04-02","","","");
INSERT INTO sales_pending VALUES("197","59","355","FT-0022/2018","37989","0","2018-04-04","","","");
INSERT INTO sales_pending VALUES("188","59","343","NC-0011/2018","4000","0","2018-04-02","","2018-04-02 13:30:58","2018-04-02 13:30:58");
INSERT INTO sales_pending VALUES("190","59","0","NC-0012/2018","500","0","2018-04-03","","2018-04-03 03:56:01","2018-04-03 03:56:01");
INSERT INTO sales_pending VALUES("198","15","357","FT-0023/2018","1000","0","2018-04-05","","","");
INSERT INTO sales_pending VALUES("192","63","348","FT-0019/2018","5000","0","2018-04-03","","","");
INSERT INTO sales_pending VALUES("193","24","351","FT-0020/2018","500","0","2018-04-03","","","");
INSERT INTO sales_pending VALUES("194","18","314","ND-0014/2018","11115","1005","2018-04-03","","2018-04-03 12:09:00","2018-04-03 12:09:00");
INSERT INTO sales_pending VALUES("199","15","359","FT-0024/2018","49715.39","0","2018-04-09","","","");
INSERT INTO sales_pending VALUES("200","59","361","FT-0025/2018","3240","0","2018-04-10","","","");
INSERT INTO sales_pending VALUES("201","20","363","FT-0026/2018","1351","0","2018-04-10","","","");
INSERT INTO sales_pending VALUES("202","66","365","FT-0027/2018","2000","0","2018-04-10","","","");
INSERT INTO sales_pending VALUES("203","19","367","FT-0028/2018","914.53","0","2018-04-11","","","");
INSERT INTO sales_pending VALUES("204","19","369","FT-0029/2018","900","0","2018-04-11","","","");
INSERT INTO sales_pending VALUES("205","19","371","FT-0030/2018","1000","0","2018-04-11","","","");
INSERT INTO sales_pending VALUES("206","19","373","FT-0031/2018","1000","0","2018-04-11","","","");
INSERT INTO sales_pending VALUES("207","19","375","FT-0032/2018","1000","0","2018-04-11","","","");
INSERT INTO sales_pending VALUES("208","20","377","FT-0033/2018","1000","0","2018-04-11","","","");
INSERT INTO sales_pending VALUES("209","18","379","FT-0034/2018","1000","0","2018-04-11","","","");
INSERT INTO sales_pending VALUES("210","19","381","FT-0035/2018","1000","0","2018-04-11","","","");
INSERT INTO sales_pending VALUES("211","21","383","FT-0036/2018","1000","1000","2018-04-11","","","");
INSERT INTO sales_pending VALUES("212","19","385","FT-0037/2018","1000","0","2018-04-11","","","");
INSERT INTO sales_pending VALUES("213","18","387","FT-0038/2018","1000","0","2018-04-11","","","");
INSERT INTO sales_pending VALUES("214","19","389","FT-0039/2018","1000","0","2018-04-11","","","");
INSERT INTO sales_pending VALUES("215","21","391","FT-0040/2018","2000","2000","2018-04-11","","","");
INSERT INTO sales_pending VALUES("216","20","393","FT-0041/2018","914.53","0","2018-04-11","","","");
INSERT INTO sales_pending VALUES("217","19","395","FT-0042/2018","15050.53","0","2018-04-11","","","");
INSERT INTO sales_pending VALUES("218","59","397","FT-0043/2018","2000.02","0","2018-04-12","","","");
INSERT INTO sales_pending VALUES("219","20","399","FT-0044/2018","1170","0","2018-04-12","","","");
INSERT INTO sales_pending VALUES("220","59","401","FT-0045/2018","1141.92","0","2018-04-12","","","");
INSERT INTO sales_pending VALUES("221","65","403","FT-0046/2018","22530.01","0","2018-04-12","","","");
INSERT INTO sales_pending VALUES("222","22","405","FT-0047/2018","5914.53","0","2018-04-12","","","");
INSERT INTO sales_pending VALUES("223","21","407","FT-0048/2018","58020","58020","2018-04-12","","","");
INSERT INTO sales_pending VALUES("224","59","409","FT-0049/2018","32208","0","2018-04-12","","","");
INSERT INTO sales_pending VALUES("225","65","411","FT-0050/2018","12740","0","2018-04-12","","","");
INSERT INTO sales_pending VALUES("226","59","413","FT-0050/2018","1952","0","2018-04-12","","","");
INSERT INTO sales_pending VALUES("227","65","415","FT-0051/2018","19119.1","0","2018-04-13","","","");
INSERT INTO sales_pending VALUES("228","18","417","FT-0052/2018","1000","0","2018-04-13","","","");
INSERT INTO sales_pending VALUES("229","59","419","FT-0053/2018","976","0","2018-04-13","","","");
INSERT INTO sales_pending VALUES("230","59","421","FT-0054/2018","11712","0","2018-04-13","","","");
INSERT INTO sales_pending VALUES("231","59","423","FT-0055/2018","976","0","2018-04-13","","","");
INSERT INTO sales_pending VALUES("232","67","425","FT-0056/2018","10350","0","2018-04-13","","","");
INSERT INTO sales_pending VALUES("233","67","427","FT-0057/2018","1000","0","2018-04-13","","","");
INSERT INTO sales_pending VALUES("234","19","0","NC-0014/2018","1170","0","2018-04-13","","2018-04-13 13:16:14","2018-04-13 13:16:14");
INSERT INTO sales_pending VALUES("235","19","0","NC-0015/2018","1170","0","2018-04-13","","2018-04-13 13:20:24","2018-04-13 13:20:24");
INSERT INTO sales_pending VALUES("236","69","431","FT-0059/2018","7000","0","2018-04-13","","","");
INSERT INTO sales_pending VALUES("237","15","0","NC-0016/2018","117000","0","2018-04-16","","2018-04-16 08:32:26","2018-04-16 08:32:26");
INSERT INTO sales_pending VALUES("238","59","434","FT-0060/2018","23424","0","2018-04-17","","","");
INSERT INTO sales_pending VALUES("239","19","465","FT-0063/2018","0","0","2018-04-18","","","");
INSERT INTO sales_pending VALUES("240","19","0","ND-0015/2018","0","0","2018-04-18","","2018-04-18 09:25:01","2018-04-18 09:25:01");
INSERT INTO sales_pending VALUES("241","15","0","NC-0017/2018","0","0","2018-04-18","","2018-04-18 09:25:22","2018-04-18 09:25:22");
INSERT INTO sales_pending VALUES("242","20","471","FT-0066/2018","1000","0","2018-04-18","","","");
INSERT INTO sales_pending VALUES("243","105","477","FT-0070/2018","6000","0","2018-04-18","","","");
INSERT INTO sales_pending VALUES("244","132","493","FT-0074/2018","8000","0","2018-04-18","","","");
INSERT INTO sales_pending VALUES("245","134","495","FT-0075/2018","25720","0","2018-04-18","","","");
INSERT INTO sales_pending VALUES("246","134","499","FT-0077/2018","1000","0","2018-04-18","","","");
INSERT INTO sales_pending VALUES("247","19","295","ND-0016/2018","1170","0","2018-04-19","","2018-04-19 07:02:48","2018-04-19 07:02:48");
INSERT INTO sales_pending VALUES("248","134","497","ND-0017/2018","34230","0","2018-04-19","","2018-04-19 07:32:50","2018-04-19 07:32:50");
INSERT INTO sales_pending VALUES("249","18","287","ND-0018/2018","1170","0","2018-04-19","","2018-04-19 07:35:48","2018-04-19 07:35:48");
INSERT INTO sales_pending VALUES("250","19","293","NC-0018/2018","1170","0","2018-04-19","","2018-04-19 08:14:01","2018-04-19 08:14:01");





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
  `status_vd` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sales_vd_description` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`vd_no`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO sales_vd VALUES("35","18","5","VD-0001/2018","","2018-03-20","2","500","","","Anulado","Falha no cadastro");
INSERT INTO sales_vd VALUES("36","15","5","VD-0002/2018","","2018-03-20","2","28500","","","Anulado","Teste da anulacao");
INSERT INTO sales_vd VALUES("37","15","5","VD-0003/2018","","2018-03-20","2","2000","","","Anulado","cancelamento");
INSERT INTO sales_vd VALUES("38","18","5","VD-0004/2018","","2018-03-20","2","10000","","","Anulado","teste da anulacao\n");
INSERT INTO sales_vd VALUES("39","17","5","VD-0005/2018","","2018-03-20","2","7500","","","Anulado","nada");
INSERT INTO sales_vd VALUES("40","19","5","VD-0006/2018","","2018-03-20","2","64350","","","Anulado","falha");
INSERT INTO sales_vd VALUES("43","19","6","VD-0007/2018","","2018-03-21","2","2500","","","Anulado","Anulando a venda ");
INSERT INTO sales_vd VALUES("45","59","6","VD-0008/2018","","2018-04-02","2","4680","","","Anulado","a venda deve ser anulada pois houve falha do usuario");
INSERT INTO sales_vd VALUES("46","59","6","VD-0009/2018","","2018-04-02","2","49450","","","Anulado","Falha");





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

INSERT INTO security_role VALUES("1","System Administrator","System Administrator","a:26:{s:8:\"category\";s:3:\"100\";s:4:\"unit\";s:3:\"600\";s:3:\"loc\";s:3:\"200\";s:4:\"item\";s:3:\"300\";s:4:\"user\";s:3:\"400\";s:4:\"role\";s:3:\"500\";s:8:\"customer\";s:3:\"700\";s:8:\"purchase\";s:3:\"900\";s:8:\"supplier\";s:4:\"1000\";s:7:\"payment\";s:4:\"1400\";s:6:\"backup\";s:4:\"1500\";s:5:\"email\";s:4:\"1600\";s:9:\"emailtemp\";s:4:\"1700\";s:10:\"preference\";s:4:\"1800\";s:3:\"tax\";s:4:\"1900\";s:10:\"currencies\";s:4:\"2100\";s:11:\"paymentterm\";s:4:\"2200\";s:13:\"paymentmethod\";s:4:\"2300\";s:14:\"companysetting\";s:4:\"2400\";s:10:\"iecategory\";s:4:\"2600\";s:7:\"expense\";s:4:\"2700\";s:7:\"deposit\";s:4:\"3000\";s:9:\"quotation\";s:4:\"2800\";s:7:\"invoice\";s:4:\"2900\";s:12:\"bank_account\";s:4:\"3100\";s:21:\"bank_account_transfer\";s:4:\"3200\";}","a:59:{s:7:\"cat_add\";s:3:\"101\";s:8:\"cat_edit\";s:3:\"102\";s:10:\"cat_delete\";s:3:\"103\";s:8:\"unit_add\";s:3:\"601\";s:9:\"unit_edit\";s:3:\"602\";s:11:\"unit_delete\";s:3:\"603\";s:7:\"loc_add\";s:3:\"201\";s:8:\"loc_edit\";s:3:\"202\";s:10:\"loc_delete\";s:3:\"203\";s:8:\"item_add\";s:3:\"301\";s:9:\"item_edit\";s:3:\"302\";s:11:\"item_delete\";s:3:\"303\";s:8:\"user_add\";s:3:\"401\";s:9:\"user_edit\";s:3:\"402\";s:11:\"user_delete\";s:3:\"403\";s:12:\"customer_add\";s:3:\"701\";s:13:\"customer_edit\";s:3:\"702\";s:15:\"customer_delete\";s:3:\"703\";s:12:\"purchase_add\";s:3:\"901\";s:13:\"purchase_edit\";s:3:\"902\";s:15:\"purchase_delete\";s:3:\"903\";s:12:\"supplier_add\";s:4:\"1001\";s:13:\"supplier_edit\";s:4:\"1002\";s:15:\"supplier_delete\";s:4:\"1003\";s:11:\"payment_add\";s:4:\"1401\";s:12:\"payment_edit\";s:4:\"1402\";s:14:\"payment_delete\";s:4:\"1403\";s:10:\"backup_add\";s:4:\"1501\";s:15:\"backup_download\";s:4:\"1502\";s:7:\"tax_add\";s:4:\"1901\";s:8:\"tax_edit\";s:4:\"1902\";s:10:\"tax_delete\";s:4:\"1903\";s:14:\"currencies_add\";s:4:\"2101\";s:15:\"currencies_edit\";s:4:\"2102\";s:17:\"currencies_delete\";s:4:\"2103\";s:15:\"paymentterm_add\";s:4:\"2201\";s:16:\"paymentterm_edit\";s:4:\"2202\";s:18:\"paymentterm_delete\";s:4:\"2203\";s:17:\"paymentmethod_add\";s:4:\"2301\";s:18:\"paymentmethod_edit\";s:4:\"2302\";s:20:\"paymentmethod_delete\";s:4:\"2303\";s:11:\"expense_add\";s:4:\"2701\";s:12:\"expense_edit\";s:4:\"2702\";s:14:\"expense_delete\";s:4:\"2703\";s:11:\"deposit_add\";s:4:\"3001\";s:12:\"deposit_edit\";s:4:\"3002\";s:14:\"deposit_delete\";s:4:\"3003\";s:13:\"quotation_add\";s:4:\"2801\";s:14:\"quotation_edit\";s:4:\"2802\";s:16:\"quotation_delete\";s:4:\"2803\";s:11:\"invoice_add\";s:4:\"2901\";s:12:\"invoice_edit\";s:4:\"2902\";s:14:\"invoice_delete\";s:4:\"2903\";s:16:\"bank_account_add\";s:4:\"3101\";s:17:\"bank_account_edit\";s:4:\"3102\";s:19:\"bank_account_delete\";s:4:\"3103\";s:25:\"bank_account_transfer_add\";s:4:\"3201\";s:26:\"bank_account_transfer_edit\";s:4:\"3202\";s:28:\"bank_account_transfer_delete\";s:4:\"3203\";}","0","2017-10-18 13:51:20","");





CREATE TABLE IF NOT EXISTS `service_ord_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` double NOT NULL,
  `unit_price` double NOT NULL,
  `discount_percent` double NOT NULL,
  `tax_type_id` int(11) NOT NULL,
  `service_orders_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=692 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE IF NOT EXISTS `service_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `allocation_id` int(11) NOT NULL,
  `reference` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `total_amount` double NOT NULL,
  `paid_amount` double NOT NULL,
  `status` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=282 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO service_orders VALUES("277","2","","2018-03-16 08:17:56","","7","FT-0015/2018","71500","0","Por Regularizar");
INSERT INTO service_orders VALUES("278","2","","2018-03-16 08:20:03","","7","FT-0016/2018","71500","0","Por Regularizar");
INSERT INTO service_orders VALUES("279","2","","2018-03-16 08:44:53","","7","FT-0017/2018","71500","0","Por Regularizar");
INSERT INTO service_orders VALUES("280","2","","2018-03-16 08:44:57","","7","FT-0018/2018","71500","0","Por Regularizar");
INSERT INTO service_orders VALUES("281","2","","2018-03-16 08:45:06","","7","FT-0019/2018","71500","0","Por Regularizar");





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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO stock_category VALUES("1","Default","1","0","2017-10-18 13:51:20","");
INSERT INTO stock_category VALUES("2","Hardware","1","0","2017-10-18 13:51:20","");
INSERT INTO stock_category VALUES("3","Saude e Beleza","1","0","2017-10-18 13:51:20","2018-03-08 07:34:25");
INSERT INTO stock_category VALUES("4","Outros","1","0","2018-02-20 09:55:22","2018-03-08 07:34:40");





CREATE TABLE IF NOT EXISTS `stock_master` (
  `stock_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item_type_id` int(11) NOT NULL,
  `category_id` tinyint(4) NOT NULL,
  `tax_type_id` tinyint(4) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `long_description` text COLLATE utf8_unicode_ci NOT NULL,
  `units` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`stock_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO stock_master VALUES("004","0","2","1","Motorola","","Each","0","1");
INSERT INTO stock_master VALUES("003","0","1","1","Huwawei","","Each","0","1");
INSERT INTO stock_master VALUES("02","0","1","3","IPHONE","","Each","0","0");
INSERT INTO stock_master VALUES("001","0","2","3","Sumsung S8","","Each","0","1");
INSERT INTO stock_master VALUES("009","0","1","3","Apple watch","","Each","0","0");
INSERT INTO stock_master VALUES("01","0","1","3","Motorola","","Each","0","0");
INSERT INTO stock_master VALUES("09","0","1","3","Tecno","","Each","0","0");
INSERT INTO stock_master VALUES("11","2","1","3","SERVICO DE TRADUCAO DE DOCUMENTOS","","Each","0","0");
INSERT INTO stock_master VALUES("PP","0","1","3","Novo Smartphone","","Each","0","0");
INSERT INTO stock_master VALUES("II","0","1","1","iphone 3","","Each","0","0");
INSERT INTO stock_master VALUES("OO","0","4","3","PAPEL","","Each","0","0");
INSERT INTO stock_master VALUES("PARACETAMOL 500 MG","0","1","1","Paracetamol","Este produto e\' inseto de iva ","Each","0","0");
INSERT INTO stock_master VALUES("00","0","2","3","WINDOWS","","Each","0","0");
INSERT INTO stock_master VALUES("77","0","1","3","windows 10","","Each","0","0");





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
) ENGINE=MyISAM AUTO_INCREMENT=419 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO stock_moves VALUES("249","02","306","202","PL","2018-03-16","2","COT-0014/2018","store_out_307","307","","0","0");
INSERT INTO stock_moves VALUES("248","02","304","202","PL","2018-03-15","2","COT-0013/2018","store_out_305","305","","-1","0");
INSERT INTO stock_moves VALUES("247","009","304","202","PL","2018-03-15","2","COT-0013/2018","store_out_305","305","","-3","0");
INSERT INTO stock_moves VALUES("246","09","294","202","PL","2018-03-15","2","SO-0008/2018","store_out_295","295","","-4","0");
INSERT INTO stock_moves VALUES("245","009","300","202","PL","2018-03-14","2","COT-0011/2018","store_out_301","301","","-1","0");
INSERT INTO stock_moves VALUES("244","02","0","102","PL","2018-03-14","2","","store_in_30","30","","10","3800");
INSERT INTO stock_moves VALUES("243","009","0","102","PL","2018-03-14","2","","store_in_30","30","","3","5000");
INSERT INTO stock_moves VALUES("250","02","309","202","PL","2018-03-16","2","COT-0016/2018","store_out_310","310","","-100","5000");
INSERT INTO stock_moves VALUES("251","01","309","202","PL","2018-03-16","2","COT-0016/2018","store_out_310","310","","-50","6000");
INSERT INTO stock_moves VALUES("252","11","309","202","PL","2018-03-16","2","COT-0016/2018","store_out_310","310","","-30","500");
INSERT INTO stock_moves VALUES("301","PP","191","202","PL","0000-00-00","2","ND-0014/2018","store_out_191","0","","-1","0");
INSERT INTO stock_moves VALUES("300","11","350","202","PL","2018-04-03","2","COT-0046/2018","store_out_351","351","","-1","0");
INSERT INTO stock_moves VALUES("255","11","313","202","PL","2018-03-19","2","COT-0018/2018","store_out_314","314","","-1","500");
INSERT INTO stock_moves VALUES("256","11","315","202","PL","2018-03-19","2","COT-0019/2018","store_out_316","316","","0","500");
INSERT INTO stock_moves VALUES("257","09","315","202","PL","2018-03-19","2","COT-0019/2018","store_out_316","316","","0","5000");
INSERT INTO stock_moves VALUES("258","02","315","202","PL","2018-03-19","2","COT-0019/2018","store_out_316","316","","0","5000");
INSERT INTO stock_moves VALUES("272","02","41","202","PL","2018-03-21","2","VD-0007/2018","store_out_41","41","","0","0");
INSERT INTO stock_moves VALUES("260","11","35","202","PL","2018-03-20","2","VD-0001/2018","store_out_35","35","","-1","0");
INSERT INTO stock_moves VALUES("261","02","0","102","PL","2018-03-20","2","","store_in_31","31","","100","3800");
INSERT INTO stock_moves VALUES("262","11","0","102","PL","2018-03-20","2","","store_in_31","31","","100","300");
INSERT INTO stock_moves VALUES("263","11","36","202","PL","2018-03-20","2","VD-0002/2018","store_out_36","36","","-7","0");
INSERT INTO stock_moves VALUES("264","02","36","202","PL","2018-03-20","2","VD-0002/2018","store_out_36","36","","-5","0");
INSERT INTO stock_moves VALUES("265","11","37","202","PL","2018-03-20","2","VD-0003/2018","store_out_37","37","","0","0");
INSERT INTO stock_moves VALUES("266","11","38","202","PL","2018-03-20","2","VD-0004/2018","store_out_38","38","","0","0");
INSERT INTO stock_moves VALUES("267","02","38","202","PL","2018-03-20","2","VD-0004/2018","store_out_38","38","","0","0");
INSERT INTO stock_moves VALUES("268","11","39","202","PL","2018-03-20","2","VD-0005/2018","store_out_39","39","","0","0");
INSERT INTO stock_moves VALUES("269","02","0","102","PL","2018-03-20","2","","store_in_32","32","","100","3800");
INSERT INTO stock_moves VALUES("270","11","40","202","PL","2018-03-20","2","VD-0006/2018","store_out_40","40","","0","0");
INSERT INTO stock_moves VALUES("271","02","40","202","PL","2018-03-20","2","VD-0006/2018","store_out_40","40","","0","0");
INSERT INTO stock_moves VALUES("273","11","41","202","PL","2018-03-21","2","VD-0007/2018","store_out_41","41","","0","0");
INSERT INTO stock_moves VALUES("274","02","42","202","PL","2018-03-21","2","VD-0008/2018","store_out_42","42","","0","0");
INSERT INTO stock_moves VALUES("275","11","42","202","PL","2018-03-21","2","VD-0008/2018","store_out_42","42","","0","0");
INSERT INTO stock_moves VALUES("276","11","43","202","PL","2018-03-21","2","VD-0007/2018","store_out_43","43","","0","0");
INSERT INTO stock_moves VALUES("278","11","0","202","PL","0000-00-00","2","","store_out_182","0","","-10","0");
INSERT INTO stock_moves VALUES("283","02","0","202","PL","0000-00-00","2","","store_in_97","0","","1","0");
INSERT INTO stock_moves VALUES("286","009","0","102","PL","2018-04-02","2","","store_in_33","33","","50","5000");
INSERT INTO stock_moves VALUES("287","11","0","102","PL","2018-04-02","2","","store_in_33","33","","50","300");
INSERT INTO stock_moves VALUES("299","11","347","202","PL","2018-04-03","2","COT-0044/2018","store_out_348","348","","-10","0");
INSERT INTO stock_moves VALUES("289","11","0","102","PL","2018-04-02","2","","store_in_39","39","","10","300");
INSERT INTO stock_moves VALUES("290","02","0","102","PL","2018-04-02","2","","store_in_39","39","","10","3800");
INSERT INTO stock_moves VALUES("291","09","0","102","JA","2018-04-02","2","","store_in_40","40","","100","4000");
INSERT INTO stock_moves VALUES("292","11","0","102","PL","2018-04-02","2","","store_in_41","41","","10","300");
INSERT INTO stock_moves VALUES("293","02","0","102","PL","2018-04-02","2","","store_in_42","42","","10","3800");
INSERT INTO stock_moves VALUES("294","11","0","102","PL","2018-04-02","2","","store_in_43","43","","10","300");
INSERT INTO stock_moves VALUES("295","11","0","102","PL","2018-04-03","2","","store_in_44","44","","200","300");
INSERT INTO stock_moves VALUES("302","11","191","202","PL","0000-00-00","2","ND-0014/2018","store_out_191","0","","-1","0");
INSERT INTO stock_moves VALUES("298","11","101","202","PL","0000-00-00","2","","store_in_101","0","","1","0");
INSERT INTO stock_moves VALUES("303","11","102","202","PL","0000-00-00","2","","store_in_102","0","","2","0");
INSERT INTO stock_moves VALUES("304","PP","102","202","PL","0000-00-00","2","","store_in_102","0","","1","0");
INSERT INTO stock_moves VALUES("305","11","352","202","PL","2018-04-04","2","COT-0047/2018","store_out_353","353","","-4","0");
INSERT INTO stock_moves VALUES("306","II","352","202","PL","2018-04-04","2","COT-0047/2018","store_out_353","353","","-10","0");
INSERT INTO stock_moves VALUES("307","11","354","202","PL","2018-04-04","2","COT-0048/2018","store_out_355","355","","-1","0");
INSERT INTO stock_moves VALUES("308","PP","354","202","PL","2018-04-04","2","COT-0048/2018","store_out_355","355","","-1","0");
INSERT INTO stock_moves VALUES("309","II","354","202","PL","2018-04-04","2","COT-0048/2018","store_out_355","355","","-1","0");
INSERT INTO stock_moves VALUES("310","02","354","202","PL","2018-04-04","2","COT-0048/2018","store_out_355","355","","-1","0");
INSERT INTO stock_moves VALUES("311","09","354","202","PL","2018-04-04","2","COT-0048/2018","store_out_355","355","","-1","0");
INSERT INTO stock_moves VALUES("312","11","356","202","PL","2018-04-05","2","COT-0049/2018","store_out_357","357","","-1","0");
INSERT INTO stock_moves VALUES("313","09","358","202","PL","2018-04-09","2","COT-0050/2018","store_out_359","359","","-4","0");
INSERT INTO stock_moves VALUES("314","02","358","202","PL","2018-04-09","2","COT-0050/2018","store_out_359","359","","-1","0");
INSERT INTO stock_moves VALUES("315","11","358","202","PL","2018-04-09","2","COT-0050/2018","store_out_359","359","","-1","0");
INSERT INTO stock_moves VALUES("316","OO","358","202","PL","2018-04-09","2","COT-0050/2018","store_out_359","359","","-1","0");
INSERT INTO stock_moves VALUES("317","11","362","202","PL","2018-04-10","2","COT-0052/2018","store_out_363","363","","-1","0");
INSERT INTO stock_moves VALUES("318","11","364","202","PL","2018-04-10","2","COT-0053/2018","store_out_365","365","","-1","0");
INSERT INTO stock_moves VALUES("319","11","366","202","PL","2018-04-11","2","COT-0054/2018","store_out_367","367","","-1","0");
INSERT INTO stock_moves VALUES("320","11","368","202","PL","2018-04-11","2","COT-0055/2018","store_out_369","369","","-1","0");
INSERT INTO stock_moves VALUES("321","11","370","202","PL","2018-04-11","2","COT-0056/2018","store_out_371","371","","-1","0");
INSERT INTO stock_moves VALUES("322","11","372","202","PL","2018-04-11","2","COT-0057/2018","store_out_373","373","","-1","0");
INSERT INTO stock_moves VALUES("323","11","388","202","PL","2018-04-11","2","COT-0065/2018","store_out_389","389","","-1","0");
INSERT INTO stock_moves VALUES("324","11","390","202","PL","2018-04-11","2","COT-0066/2018","store_out_391","391","","-2","0");
INSERT INTO stock_moves VALUES("325","11","392","202","PL","2018-04-11","2","COT-0067/2018","store_out_393","393","","-1","0");
INSERT INTO stock_moves VALUES("326","11","394","202","PL","2018-04-11","2","COT-0068/2018","store_out_395","395","","-1","0");
INSERT INTO stock_moves VALUES("327","09","394","202","PL","2018-04-11","2","COT-0068/2018","store_out_395","395","","-1","0");
INSERT INTO stock_moves VALUES("328","01","394","202","PL","2018-04-11","2","COT-0068/2018","store_out_395","395","","-1","0");
INSERT INTO stock_moves VALUES("329","PARACETAMOL 500 MG","394","202","PL","2018-04-11","2","COT-0068/2018","store_out_395","395","","-1","0");
INSERT INTO stock_moves VALUES("330","OO","394","202","PL","2018-04-11","2","COT-0068/2018","store_out_395","395","","-1","0");
INSERT INTO stock_moves VALUES("331","11","396","202","PL","2018-04-12","2","COT-0069/2018","store_out_397","397","","-1","0");
INSERT INTO stock_moves VALUES("332","11","398","202","PL","2018-04-12","2","COT-0070/2018","store_out_399","399","","-1","0");
INSERT INTO stock_moves VALUES("333","11","400","202","PL","2018-04-12","2","COT-0071/2018","store_out_401","401","","-1","0");
INSERT INTO stock_moves VALUES("334","11","402","202","PL","2018-04-12","2","COT-0072/2018","store_out_403","403","","-1","0");
INSERT INTO stock_moves VALUES("335","09","402","202","PL","2018-04-12","2","COT-0072/2018","store_out_403","403","","-1","0");
INSERT INTO stock_moves VALUES("336","PP","402","202","PL","2018-04-12","2","COT-0072/2018","store_out_403","403","","-1","0");
INSERT INTO stock_moves VALUES("337","01","402","202","PL","2018-04-12","2","COT-0072/2018","store_out_403","403","","-1","0");
INSERT INTO stock_moves VALUES("338","11","404","202","PL","2018-04-12","2","COT-0073/2018","store_out_405","405","","-1","0");
INSERT INTO stock_moves VALUES("339","09","404","202","PL","2018-04-12","2","COT-0073/2018","store_out_405","405","","-1","0");
INSERT INTO stock_moves VALUES("340","11","406","202","PL","2018-04-12","2","COT-0074/2018","store_out_407","407","","-1","0");
INSERT INTO stock_moves VALUES("341","01","406","202","PL","2018-04-12","2","COT-0074/2018","store_out_407","407","","-1","0");
INSERT INTO stock_moves VALUES("342","09","406","202","PL","2018-04-12","2","COT-0074/2018","store_out_407","407","","-10","0");
INSERT INTO stock_moves VALUES("343","11","408","202","PL","2018-04-12","2","COT-0075/2018","store_out_409","409","","-1","0");
INSERT INTO stock_moves VALUES("344","02","408","202","PL","2018-04-12","2","COT-0075/2018","store_out_409","409","","-1","0");
INSERT INTO stock_moves VALUES("345","II","408","202","PL","2018-04-12","2","COT-0075/2018","store_out_409","409","","-1","0");
INSERT INTO stock_moves VALUES("346","01","408","202","PL","2018-04-12","2","COT-0075/2018","store_out_409","409","","-1","0");
INSERT INTO stock_moves VALUES("347","PP","408","202","PL","2018-04-12","2","COT-0075/2018","store_out_409","409","","-1","0");
INSERT INTO stock_moves VALUES("353","PP","414","202","PL","2018-04-13","2","COT-0078/2018","store_out_415","415","","-1","0");
INSERT INTO stock_moves VALUES("352","11","414","202","PL","2018-04-13","2","COT-0078/2018","store_out_415","415","","-1","0");
INSERT INTO stock_moves VALUES("351","11","412","202","PL","2018-04-12","2","COT-0077/2018","store_out_413","413","","-1","0");
INSERT INTO stock_moves VALUES("354","01","414","202","PL","2018-04-13","2","COT-0078/2018","store_out_415","415","","-1","0");
INSERT INTO stock_moves VALUES("355","PARACETAMOL 500 MG","414","202","PL","2018-04-13","2","COT-0078/2018","store_out_415","415","","-1","0");
INSERT INTO stock_moves VALUES("356","02","414","202","PL","2018-04-13","2","COT-0078/2018","store_out_415","415","","-1","0");
INSERT INTO stock_moves VALUES("357","11","416","202","PL","2018-04-13","2","COT-0079/2018","store_out_417","417","","-1","0");
INSERT INTO stock_moves VALUES("358","11","418","202","PL","2018-04-13","2","COT-0080/2018","store_out_419","419","","-1","0");
INSERT INTO stock_moves VALUES("359","11","420","202","PL","2018-04-13","2","COT-0081/2018","store_out_421","421","","-1","0");
INSERT INTO stock_moves VALUES("360","02","420","202","PL","2018-04-13","2","COT-0081/2018","store_out_421","421","","-1","0");
INSERT INTO stock_moves VALUES("361","01","420","202","PL","2018-04-13","2","COT-0081/2018","store_out_421","421","","-1","0");
INSERT INTO stock_moves VALUES("362","11","422","202","PL","2018-04-13","2","COT-0082/2018","store_out_423","423","","-1","0");
INSERT INTO stock_moves VALUES("363","PP","424","202","PL","2018-04-13","2","COT-0083/2018","store_out_425","425","","-1","0");
INSERT INTO stock_moves VALUES("364","11","426","202","PL","2018-04-13","2","COT-0084/2018","store_out_427","427","","-1","0");
INSERT INTO stock_moves VALUES("365","11","428","202","PL","2018-04-13","2","COT-0085/2018","store_out_429","429","","-1","1000");
INSERT INTO stock_moves VALUES("366","PP","428","202","PL","2018-04-13","2","COT-0085/2018","store_out_429","429","","-3","9000");
INSERT INTO stock_moves VALUES("367","11","103","202","PL","0000-00-00","2","","store_in_103","0","","1","0");
INSERT INTO stock_moves VALUES("368","11","104","202","PL","0000-00-00","2","","store_in_104","0","","1","0");
INSERT INTO stock_moves VALUES("369","77","430","202","PL","2018-04-13","2","COT-0086/2018","store_out_431","431","","-1","0");
INSERT INTO stock_moves VALUES("370","11","105","202","PL","0000-00-00","2","","store_in_105","0","","100","0");
INSERT INTO stock_moves VALUES("371","11","433","202","PL","2018-04-17","2","COT-0088/2018","store_out_434","434","","-1","0");
INSERT INTO stock_moves VALUES("375","11","457","202","PL","2018-04-18","2","COT-0108/2018","store_out_458","458","","-2","854.7");
INSERT INTO stock_moves VALUES("378","11","466","202","PL","2018-04-18","2","COT-0114/2018","store_out_467","467","","-1","854.7");
INSERT INTO stock_moves VALUES("376","09","457","202","PL","2018-04-18","2","COT-0108/2018","store_out_458","458","","-1","4273.5");
INSERT INTO stock_moves VALUES("377","01","457","202","PL","2018-04-18","2","COT-0108/2018","store_out_458","458","","-1","5128.22");
INSERT INTO stock_moves VALUES("379","11","468","202","PL","2018-04-18","2","COT-0115/2018","store_out_469","469","","-1","854.7");
INSERT INTO stock_moves VALUES("380","11","470","202","PL","2018-04-18","2","COT-0116/2018","store_out_471","471","","-1","0");
INSERT INTO stock_moves VALUES("381","11","432","202","PL","2018-04-18","2","COT-0087/2018","store_out_472","472","","-1","1000");
INSERT INTO stock_moves VALUES("382","009","432","202","PL","2018-04-18","2","COT-0087/2018","store_out_472","472","","-1","7000");
INSERT INTO stock_moves VALUES("383","01","432","202","PL","2018-04-18","2","COT-0087/2018","store_out_472","472","","-1","6000");
INSERT INTO stock_moves VALUES("384","09","432","202","PL","2018-04-18","2","COT-0087/2018","store_out_472","472","","-1","5000");
INSERT INTO stock_moves VALUES("385","11","432","202","PL","2018-04-18","2","COT-0087/2018","store_out_473","473","","-1","1000");
INSERT INTO stock_moves VALUES("386","009","432","202","PL","2018-04-18","2","COT-0087/2018","store_out_473","473","","-1","7000");
INSERT INTO stock_moves VALUES("387","01","432","202","PL","2018-04-18","2","COT-0087/2018","store_out_473","473","","-1","6000");
INSERT INTO stock_moves VALUES("388","09","432","202","PL","2018-04-18","2","COT-0087/2018","store_out_473","473","","-1","5000");
INSERT INTO stock_moves VALUES("389","11","474","202","PL","2018-04-18","2","COT-0117/2018","store_out_475","475","","-1","854.7");
INSERT INTO stock_moves VALUES("390","09","474","202","PL","2018-04-18","2","COT-0117/2018","store_out_475","475","","-1","4273.5");
INSERT INTO stock_moves VALUES("391","11","476","202","PL","2018-04-18","2","COT-0118/2018","store_out_477","477","","-1","0");
INSERT INTO stock_moves VALUES("392","09","476","202","PL","2018-04-18","2","COT-0118/2018","store_out_477","477","","-1","0");
INSERT INTO stock_moves VALUES("394","11","486","202","PL","2018-04-18","2","COT-0125/2018","store_out_487","487","","-1","854.7");
INSERT INTO stock_moves VALUES("395","09","480","202","PL","2018-04-18","2","COT-0121/2018","store_out_488","488","","-1","4273.5");
INSERT INTO stock_moves VALUES("396","77","480","202","PL","2018-04-18","2","COT-0121/2018","store_out_488","488","","-1","5982.91");
INSERT INTO stock_moves VALUES("397","00","480","202","PL","2018-04-18","2","COT-0121/2018","store_out_488","488","","-1","5982.91");
INSERT INTO stock_moves VALUES("398","11","490","202","PL","2018-04-18","2","COT-0127/2018","store_out_491","491","","-1","854.7");
INSERT INTO stock_moves VALUES("399","09","490","202","PL","2018-04-18","2","COT-0127/2018","store_out_491","491","","-1","4273.5");
INSERT INTO stock_moves VALUES("400","11","492","202","PL","2018-04-18","2","COT-0128/2018","store_out_493","493","","-1","0");
INSERT INTO stock_moves VALUES("401","00","492","202","PL","2018-04-18","2","COT-0128/2018","store_out_493","493","","-1","0");
INSERT INTO stock_moves VALUES("402","PP","494","202","PL","2018-04-18","2","COT-0129/2018","store_out_495","495","","-1","0");
INSERT INTO stock_moves VALUES("403","009","494","202","PL","2018-04-18","2","COT-0129/2018","store_out_495","495","","-1","0");
INSERT INTO stock_moves VALUES("404","00","494","202","PL","2018-04-18","2","COT-0129/2018","store_out_495","495","","-1","0");
INSERT INTO stock_moves VALUES("405","00","496","202","PL","2018-04-18","2","COT-0130/2018","store_out_497","497","","-1","5982.91");
INSERT INTO stock_moves VALUES("406","11","498","202","PL","2018-04-18","2","COT-0131/2018","store_out_499","499","","-1","0");
INSERT INTO stock_moves VALUES("407","11","485","202","PL","2018-04-18","2","COT-0124/2018","store_out_500","500","","-1","854.7");
INSERT INTO stock_moves VALUES("408","11","193","202","PL","0000-00-00","2","ND-0016/2018","store_out_193","0","","-1","0");
INSERT INTO stock_moves VALUES("409","02","194","202","PL","0000-00-00","2","ND-0017/2018","store_out_194","0","","-1","0");
INSERT INTO stock_moves VALUES("410","II","194","202","PL","0000-00-00","2","ND-0017/2018","store_out_194","0","","-1","0");
INSERT INTO stock_moves VALUES("411","77","194","202","PL","0000-00-00","2","ND-0017/2018","store_out_194","0","","-1","0");
INSERT INTO stock_moves VALUES("412","00","194","202","PL","0000-00-00","2","ND-0017/2018","store_out_194","0","","-1","0");
INSERT INTO stock_moves VALUES("413","11","195","202","PL","0000-00-00","2","ND-0018/2018","store_out_195","0","","-1","0");
INSERT INTO stock_moves VALUES("414","11","107","202","PL","0000-00-00","2","","store_in_107","0","","1","0");
INSERT INTO stock_moves VALUES("415","11","501","202","PL","2018-04-19","2","COT-0132/2018","store_out_502","502","","-1","854.7");
INSERT INTO stock_moves VALUES("416","01","503","202","PL","2018-04-19","2","COT-0133/2018","store_out_504","504","","-1","6000");
INSERT INTO stock_moves VALUES("417","PARACETAMOL 500 MG","503","202","PL","2018-04-19","2","COT-0133/2018","store_out_504","504","","-1","10");
INSERT INTO stock_moves VALUES("418","PP","505","202","PL","2018-04-19","2","COT-0134/2018","store_out_506","506","","-1","7692.31");





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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO suppliers VALUES("7","Sunsung Anc","sunsung@sunsung.com","Nova york","847474744","Cidade de Maputo","Cidade de Maputo","","400121213","MZ","0","2018-02-16 13:27:22","");
INSERT INTO suppliers VALUES("8","Apple Software representante","apple@apple.com","California ","+1 782828","Cidade de Maputo","Cidade de Maputo","10023","40003423","MZ","0","2018-02-16 13:29:01","");
INSERT INTO suppliers VALUES("9","Software Inc","email@email.com","Magoanine C","842323232","Cidade de Maputo","Maputo Provincia","1012","50002323","MZ","0","2018-02-20 14:41:04","");
INSERT INTO suppliers VALUES("10","Luis Farinha  Mendes","email@email.com","Mavalane B","844343434","Cidade de Maputo","Maputo","","40043242","MZ","0","2018-04-02 15:00:50","");





CREATE TABLE IF NOT EXISTS `teste` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE IF NOT EXISTS `teste_table` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nome` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO teste_table VALUES("3","sjdhsjdfh");
INSERT INTO teste_table VALUES("4","ksjfdksdjksk");





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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO users VALUES("1","","$2y$10$63pmjgQtT9d6MEhgko4qQeF4B50iY42KUxhtl0kdIPXQjwf.iftEm","Gerson Hugo","1","822441262","gchiule@gmail.com","user1.png","0","69P4YDenGRG4SkXVM2oFzhx35LTHWdCJcf1xPwHFbbTY1EUpjvuM6YgLETPz","2017-10-18 13:51:55","2018-01-18 09:56:12");
INSERT INTO users VALUES("2","","$2y$10$GbgX0Z2DGHOJIWAkFbkXaOPGH1Fu8QBqktctseholx3RLlKHGM/Y6","demo","1","+8012654159","demo@n3.co.mz","","0","OGzH3MdBrjFmcxHMkrzUtVzm0l9cA7STmkKBMxSb62LEDCPBER61fpuujilS","2017-12-30 10:14:15","2018-04-19 13:12:33");
INSERT INTO users VALUES("3","","$2y$10$bIzGNJzurSIZFfnvFGUshObsv69BRKzL4kfPuMfJCHwtumoTiXvRy","teste","2","83636","teste@teste.co.mz","","0","SvFddCf1yE6gotQbIEZyGQExSAAJA95ryGhoqNDdrJNlXs2uhpT9Yxzjc2Xy","2018-01-06 17:32:54","2018-01-07 14:22:24");




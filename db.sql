/*2019/03/22 add commit-增加前端是否显示字段*/
ALTER TABLE `xxfood`.`store_menu` ADD COLUMN `is_show` TINYINT(1) DEFAULT 1  NOT NULL   COMMENT '是都前端显示1显示 0不显示' AFTER `sale_date`;

/*1.0.4-自提柜*/
ALTER TABLE `store`
MODIFY COLUMN `personal_type`  varchar(20) NULL DEFAULT '1' COMMENT '自取方式 可多选 1服务台2自提柜提货-人工放餐3自提柜提货-机器放餐' AFTER `personal`,
ADD COLUMN `cabinet_auto_print`  tinyint(1) NULL DEFAULT 0 COMMENT '自提柜自动打印 1是0否' AFTER `personal_auto_print`;

CREATE TABLE `store_cabinet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '门店ID',
  `name` varchar(40) NOT NULL COMMENT '自提柜名称',
  `no` varchar(20) NOT NULL COMMENT '自提柜编号',
  `number` varchar(40) NOT NULL COMMENT '自提柜设备号',
  `start_time` time NOT NULL COMMENT '开放时间-开始',
  `end_time` time NOT NULL COMMENT '开放时间-结束',
  `rows` tinyint(2) NOT NULL COMMENT '行数',
  `cols` tinyint(2) NOT NULL COMMENT '列数',
  `max_num` int(4) NOT NULL COMMENT '最大存储量',
  `sort` int(4) DEFAULT '0' COMMENT '排序',
  `remark` varchar(500) DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1正常2全部停用3部分停用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_store_id` (`store_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='门店自提柜';

CREATE TABLE `store_cabinet_cell` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_cabinet_id` int(11) NOT NULL COMMENT '自提柜ID',
  `name` varchar(20) NOT NULL COMMENT '自提柜格子名称',
  `no` int(11) NOT NULL COMMENT '自提柜格子编号',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0空1存货2停用',
  `order_id` int(11) DEFAULT NULL COMMENT '订单ID',
  `storaged_at` timestamp NULL DEFAULT NULL COMMENT '存货时间',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_store_cabinet_id` (`store_cabinet_id`) USING BTREE,
  KEY `idx_order_id` (`order_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COMMENT='门店自提柜格子';

/*2019/04/02 用户表，新增是否激活字段*/
ALTER TABLE `users` ADD COLUMN `is_active` TINYINT(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否激活' AFTER `sex`;
UPDATE `users` SET is_active = 1

/*2019/04/03 1.1.5-发票管理，新增发票抬头表*/
CREATE TABLE `invoice_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '发票抬头',
  `number` varchar(45) DEFAULT NULL COMMENT '税号',
  `status` tinyint(1) DEFAULT '1' COMMENT '是否启用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='发票抬头表';

/*2019/04/09 cf 新增财务日报表及其详情*/
CREATE TABLE `finance_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(10) NOT NULL COMMENT '门店id',
  `store_name` varchar(255) NOT NULL COMMENT '门店名称',
  `user_id_create` int(10) NOT NULL COMMENT '添加人id',
  `user_name_create` varchar(255) NOT NULL COMMENT '添加人姓名',
  `user_id_save` int(10) NULL COMMENT '确认人id',
  `user_name_save` varchar(255) NULL COMMENT '确认人姓名',
  `report_date` varchar(255) Not NULL COMMENT '报表日期',
  `type` varchar(2) Not NULL DEFAULT 1 COMMENT '报表类型，1为正常报表，2为补填报表',
  `status` varchar(2) Not NULL DEFAULT 0 COMMENT '状态，0为初始状态，1为确认状态',
  `remark` varchar(1000) NULL COMMENT '备注',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '记录更新时间',
  `confirm_at` timestamp NULL COMMENT '最后确认时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='财务日报表';

CREATE TABLE `finance_report_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `pid` int(10) NOT NULL COMMENT '父级id',
  `paytype` varchar(255) NOT NULL COMMENT '支付方式简称',
  `paytype_name` varchar(255) NOT NULL COMMENT '支付方式名称',
  `content` varchar(255) NOT NULL COMMENT '内容',
  `status` varchar(2) Not NULL DEFAULT 0 COMMENT '状态，0为初始状态，1为确认状态',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '记录更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='财务日报详情表';

/*外包不知道何时更新的正式服订单表*/
ALTER TABLE `order`
ADD COLUMN `table_number`  varchar(45) NULL COMMENT '桌号信息（客如云）' AFTER `order_address`,
ADD COLUMN `update_store`  tinyint(1) NOT NULL DEFAULT 0 AFTER `table_number`;

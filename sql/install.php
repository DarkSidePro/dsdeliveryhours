<?php
/**
* 2007-2019 Dark-Side.pro.
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.dark-side.pro for more information.
*
*  @author    Dark-Side.pro <contact@dark-side.pro>
*  @copyright 2007-2019 Dark-Side.pro
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ds_deliveryhours` (
    `id_deliveryhours` INT(11) NOT NULL AUTO_INCREMENT,
    `main_hour_start` TIME NOT NULL,
    `main_hour_stop` TIME NOT NULL,
    `main_interval` TIME NOT NULL,
    `main_day_delay` INT(4) NOT NULL,
    `main_day_limit` INT(4) NOT NULL,
    `main_order_number` INT(11) NOT NULL,
    PRIMARY KEY  (`id_deliveryhours`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ds_deliveryhoursinterval` (
    `id_deliveryhoursinterval` INT(11) NOT NULL AUTO_INCREMENT,
    `interval_time` TIME NOT NULL,
    PRIMARY KEY  (`id_deliveryhoursinterval`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ds_deliveryhoursdays` (
    `id_deliveryhoursdays` INT(11) NOT NULL AUTO_INCREMENT,
    `days_date` DATE NOT NULL,
    `days_week` INT(1) NOT NULL,
    PRIMARY KEY  (`id_deliveryhoursdays`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ds_deliveryhoursshipper` (
    `id_deliveryhoursshipper` INT(11) NOT NULL AUTO_INCREMENT,
    `shipper_name` VARCHAR(64) NOT NULL,  
    `shipper_email` VARCHAR(64),  
    `shipper_phone` VARCHAR(12),  
    `shipper_description` text,
    `shipper_address` VARCHAR(256),
    `shipper_vat_number` VARCHAR(13),
    `shipper_cost` DECIMAL(20,6) NOT NULL,
    PRIMARY KEY  (`id_deliveryhoursshipper`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ds_deliveryhoursrules` (
    `id_deliveryhoursrules` INT(11) NOT NULL AUTO_INCREMENT,
    `rules_day_ID` INT(11) NOT NULL,  
    `rules_start` DATE NOT NULL,  
    `rules_stop` DATE NOT NULL,  
    `rules_interval_start` INT(11) NOT NULL,
    `rules_interval_stop` INT(11) NOT NULL,
    `id_deliveryhoursshipper` INT(11) NOT NULL,
    `rules_quantity` INT(11) NOT NULL,
    PRIMARY KEY  (`id_deliveryhoursrules`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ds_deliveryhoursorders` (
    `id_deliveryhoursorders` INT(11) NOT NULL AUTO_INCREMENT,
    `id_deliveryhoursdays` INT(11) NOT NULL,
    `id_deliveryhoursinterval` INT(11) NOT NULL,
    `id_deliveryhoursshipper` INT(11) NOT NULL,
    `orders_number` INT(11) NOT NULL,
    PRIMARY KEY  (`id_deliveryhoursorders`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ds_deliveryhoursused` (
    `id_deliveryhoursused` INT(11) NOT NULL AUTO_INCREMENT,
    `id_deliveryhoursorders` INT(11) NOT NULL,
    `id_deliveryhoursdays` INT(11) NOT NULL,
    `id_deliveryhoursinterval` INT(11) NOT NULL,
    `orders_number` INT(11) NOT NULL,
    PRIMARY KEY  (`id_deliveryhoursused`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ds_deliveryhoursevents` (
    `id_deliveryhoursevents` INT(11) NOT NULL AUTO_INCREMENT,
    `id_deliveryhoursorders` INT(11) NOT NULL,
    `id_cart` INT(11) NOT NULL,
    `shipper_name` VARCHAR(64) NOT NULL,  
    `shipper_email` VARCHAR(64),  
    `shipper_phone` VARCHAR(12),
    `shipper_cost` DECIMAL(20,6) NOT NULL,
    `event_timestamp` TIMESTAMP NOT NULL,
    `event_hour_start` TIME NOT NULL,
    `event_hour_stop` TIME NOT NULL,
    `event_date` DATE NOT NULL,
    PRIMARY KEY  (`id_deliveryhoursevents`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}

if (Db::getInstance()->insert('ds_deliveryhours', array(
    'main_hour_start' => '08:00:00',
    'main_hour_stop' => '16:00:00',
    'main_interval' => '00:30:00',
    'main_day_delay' => 1,
    'main_day_limit' => 7,
    'main_order_number' => 10,
)) == false) {
    return false;
}

if (Db::getInstance()->insert('ds_deliveryhoursshipper', array(
    'shipper_name' => 'Default',
    'shipper_email' => '',
    'shipper_phone' => '',
    'shipper_description' => '',
    'shipper_address' => '',
    'shipper_vat_number' => '',
    'shipper_cost' => 19.99,
    )) == false) {
    return false;
}

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

/**
 * In some cases you should not drop the tables.
 * Maybe the merchant will just try to reset the module
 * but does not want to loose all of the data associated to the module.
 */
$sql = array();

$sql[] = '
DROP TABLE IF EXISTS 
`'._DB_PREFIX_.'ds_deliveryhours`,  
`'._DB_PREFIX_.'ds_deliveryhoursinterval`,
`'._DB_PREFIX_.'ds_deliveryhoursdays`,
`'._DB_PREFIX_.'ds_deliveryhoursshipper`, 
`'._DB_PREFIX_.'ds_deliveryhoursrules`,
`'._DB_PREFIX_.'ds_deliveryhoursorders`,
`'._DB_PREFIX_.'ds_deliveryhoursused`
';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}

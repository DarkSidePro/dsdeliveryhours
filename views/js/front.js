/**
* 2007-2019 Dark-Side.pro
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
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/

var table = document.getElementById('dsdelivery');

if (table) {/*
    $('.cstCheck').on('click', function() {
           // console.log(prestashop.urls.current_url);
        let order = $(this).data('order');

        //var ano = prestashop.urls.base_url + 'index.php?fc=module&module=dsdeliveryhours&controller=ajax';
        var ano = prestashop.urls.base_url+'index.php';
        //var ano = prestashop.urls.base_url + 'index.php?controller=dsdeliveryhoursajax&redirect=module&module=dsdeliveryhours';
        
        
        $.ajax({
            type: "POST",
            url: ano, 
            data: {
                ajax: true,
                controller: 'DsdeliveryhoursAjax',
                action: 'call'
            },


            
            success: function(data) {															
            alert(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(xhr.responseText);
                alert(thrownError);
            }
        });
    })*/
}

/*
            
        $.ajax({
            type: "POST",
            url: prestashop.urls.base_url, prestashop.urls.base_url+'index.php',
            data: {
                ajax: true,
                dscarrier: order,
                controller: 'DsdeliveryhoursAjax',
                action: 'call'
            },
            */
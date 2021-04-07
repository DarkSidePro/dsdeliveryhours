{*
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
*}

<div class='panel'>
    <h3><i class="icon icon-truck"></i> {l s='DS: Delivery hours - Available orders' mod='dsdeliveryhours'}</h3>
    <div class='panel-body'>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-lg-12'>
                    <table class='table table__delivery table-responsive' id='dsdelivery'>
                        <thead class='thead-default'>
                            <tr class='column-headers'>
                                <th></th>
                                {foreach $actualDays as $days}
                                    <th scope='col'>
                                        <span>{$days.days_date|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</span>
                                        {foreach $daysOfWeek as $week}
                                            {if $days.days_week == $week.id}
                                                <span>{$week.day|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</span>
                                            {/if}
                                        {/foreach}
                                    </th>            
                                {/foreach}
                            </tr>
                        </thead>
                        <tbody>        
                                {foreach from=$actualIntervals key=i item=$interval}
                                    <tr>
                                        <td>                        
                                            {$interval.interval_time_start|strip_tags:'UTF-8'|escape:'htmlall':'UTF-8'|truncate:5:""}
                                            {$interval.interval_time_stop|strip_tags:'UTF-8'|escape:'htmlall':'UTF-8'|truncate:5:""}                                              
                                        </td>  
                                    {foreach from=$actualOrders key=i item=$order}                    
                                            {if $interval.id_deliveryhoursinterval == $order.id_deliveryhoursinterval}
                                                {if $order.ds_possible == 1}    
                                                    <td class='item'>                                                                                                                          
                                                        <label class='cstCheck' data-order='{$order.id_deliveryhoursorders|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'> 
                                                            {$order.ds_quantity|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}                                                                                                
                                                            <input class='hidden d-none delivery__checkbox' type='radio' name='dscarrier' value='{$order.id_deliveryhoursorders|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>
                                                            <span class='check'>{l s='Avaliable' d='dsdeliveryhours'}</span>                            
                                                        </label>    
                                                    </td>
                                                {else}
                                                    <td class='item'>
                                                        <span>{l s='Not available' d='dsdeliveryhours'}</span>
                                                    </td>
                                                {/if}
                                            {/if}                                                              
                                    {/foreach}                                                                       
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


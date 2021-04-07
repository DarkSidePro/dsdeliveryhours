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
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-lg-l2'>
                <div class="table-responsive-row clearfix">
		            <table id="table-order" class="table order">
                        <thead>
							<form method='POST'>
								<input type='hidden' name='searchOrderForm'>							
								<tr class="nodrag nodrop">
									<th class="center fixed-width-xs"></th>
									<th class="fixed-width-xs text-center">
										<span class="title_box active">{l s='ID' d='dsdeliveryhours'}
											<a {if $orders[0].orderField == 'id_order' && $orders[0].orderRef == 'desc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=id_order&orderway=desc">
												<i class="icon-caret-down"></i>
											</a>
											<a {if $orders[0].orderField == 'id_order' && $orders[0].orderRef == 'asc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=id_order&orderway=asc">
												<i class="icon-caret-up"></i>
											</a>
										</span>
									</th>
									<th class="">
										<span class="title_box">
											{l s='Reference' d='dsdeliveryhours'}
											<a {if $orders[0].orderField == 'reference' && $orders[0].orderRef == 'desc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=reference&orderway=desc">
												<i class="icon-caret-down"></i>
											</a>
											<a {if $orders[0].orderField == 'reference' && $orders[0].orderRef == 'asc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=reference&orderway=asc">
												<i class="icon-caret-up"></i>
											</a>
										</span>
									</th>
									<th class=" text-center">
										<span class="title_box">
											{l s='New client' d='dsdeliveryhours'}
										</span>
									</th>
									<th class="">
										<span class="title_box">
											{l s='Delivery country' d='dsdeliveryhours'}
											<a href="{if $orders[0].orderField == 'cname' && $orders[0].orderRef == 'desc'} class="active" {/if} {$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=cname&orderway=desc">
												<i class="icon-caret-down"></i>
											</a>
											<a {if $orders[0].orderField == 'cname' && $orders[0].orderRef == 'asc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=cname&orderway=asc">
												<i class="icon-caret-up"></i>
											</a>
										</span>
									</th>
									<th class="">
										<span class="title_box">
											{l s='Customer' d='dsdeliveryhours'}
											<a {if $orders[0].orderField == 'customer' && $orders[0].orderRef == 'desc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=customer&orderway=desc">
												<i class="icon-caret-down"></i>
											</a>
											<a {if $orders[0].orderField == 'customer' && $orders[0].orderRef == 'asc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=customer&orderway=asc">
												<i class="icon-caret-up"></i>
											</a>
										</span>
									</th>
									<th class=" text-right">
										<span class="title_box">
											{l s='Total' d='dsdeliveryhours'}
											<a {if $orders[0].orderField == 'total_paid' && $orders[0].orderRef == 'desc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=total_paid&orderway=desc">
												<i class="icon-caret-down"></i>
											</a>
											<a {if $orders[0].orderField == 'total_paid' && $orders[0].orderRef == 'asc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=total_paid&orderway=asc">
												<i class="icon-caret-up"></i>
											</a>
										</span>
									</th>
									<th class="">
										<span class="title_box">
											{l s='Payment' d='dsdeliveryhours'}
											<a {if $orders[0].orderField == 'payment' && $orders[0].orderRef == 'desc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=payment&orderway=desc">
												<i class="icon-caret-down"></i>
											</a>
											<a {if $orders[0].orderField == 'payment' && $orders[0].orderRef == 'asc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=payment&orderway=asc">
												<i class="icon-caret-up"></i>
											</a>
										</span>
									</th>
									<th class="">
										<span class="title_box">
											{l s='Status' d='dsdeliveryhours'}
											<a {if $orders[0].orderField == 'status' && $orders[0].orderRef == 'desc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=status&orderway=desc">
												<i class="icon-caret-down"></i>
											</a>
											<a {if $orders[0].orderField == 'status' && $orders[0].orderRef == 'asc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=status&orderway=asc">
												<i class="icon-caret-up"></i>
											</a>
										</span>
									</th>
									<th class=" text-right">
										<span class="title_box">
											{l s='Order date' d='dsdeliveryhours'}
											<a {if $orders[0].orderField == 'date' && $orders[0].orderRef == 'desc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=date&orderway=desc">
												<i class="icon-caret-down"></i>
											</a>
											<a {if $orders[0].orderField == 'date' && $orders[0].orderRef == 'asc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=date&orderway=asc">
												<i class="icon-caret-up"></i>
											</a>
										</span>
									</th>
									<th>
										<span class="title_box">
											{l s='Delivery date' d='dsdeliveryhours'}
											<a {if $orders[0].orderField == 'datedelivery' && $orders[0].orderRef == 'desc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=datedelivery&orderway=desc">
												<i class="icon-caret-down"></i>
											</a>
											<a {if $orders[0].orderField == 'datedelivery' && $orders[0].orderRef == 'asc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=datedelivery&orderway=asc">
												<i class="icon-caret-up"></i>
											</a>
										</span>
									</th>
									<th>
										<span class="title_box">
											{l s='Shipper name' d='dsdeliveryhours'}
											<a {if $orders[0].orderField == 'shipper_name' && $orders[0].orderRef == 'desc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=shipper_name&orderway=desc">
												<i class="icon-caret-down"></i>
											</a>
											<a {if $orders[0].orderField == 'shipper_name' && $orders[0].orderRef == 'asc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=shipper_name&orderway=asc">
												<i class="icon-caret-up"></i>
											</a>
										</span>
									</th>
									<th>
										<span class="title_box">
											{l s='Shipper email' d='dsdeliveryhours'}
											<a {if $orders[0].orderField == 'shipper_email' && $orders[0].orderRef == 'desc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=shipper_email&orderway=desc">
												<i class="icon-caret-down"></i>
											</a>
											<a {if $orders[0].orderField == 'shipper_email' && $orders[0].orderRef == 'asc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=shipper_email&orderway=asc">
												<i class="icon-caret-up"></i>
											</a>
										</span>
									</th>
									<th>
										<span class="title_box">
											{l s='Shipper phone' d='dsdeliveryhours'}
											<a {if $orders[0].orderField == 'shipper_phone' && $orders[0].orderRef == 'desc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=shipper_phone&orderway=desc">
												<i class="icon-caret-down"></i>
											</a>
											<a {if $orders[0].orderField == 'shipper_phone' && $orders[0].orderRef == 'asc'} class="active" {/if} href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&getdeliveryorders&orderBy=shipper_phone&orderway=asc">
												<i class="icon-caret-up"></i>
											</a>
										</span>
									</th>
								</tr>								
								<tr class="nodrag nodrop filter row_hover">
									<th class="text-center">
										--
									</th>
										<th class="text-center">
											<input type="text" class="filter" name="orderFilter_id_order" value='{$filters.id_order_state|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>
										</th>
										<th>
											<input type="text" class="filter" name="orderFilter_reference" value='{$filters.orderFilter_reference|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>
										</th>
										<th class="text-center">
											<select class="filter fixed-width-sm center" name="orderFilter_new">
												<option value="" {if $filters.orderFilter_new == false} selected {/if}>-</option>
												<option value="1" {if $filters.orderFilter_new == 1} selected {/if}>Yes</option>
												<option value="0" {if $filters.orderFilter_new == 0} selected {/if}>No</option>
											</select>
										</th>
										<th>
											<select class="filter"  name="orderFilter_country">
												<option value="" selected="selected" {if $filters.orderFilter_country == false} selected {/if}>-</option>
												{foreach $countries as $country}
													<option value='{$country.id_country|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}' {if $filters.orderFilter_country == $country.id_country} selected {/if}>{$country.name|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</option>
												{/foreach}											
											</select>
										</th>
										<th>
											<input type="text" class="filter" name="orderFilter_customer" value="{$filters.orderFilter_customer|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}">
										</th>
										<th class="text-right">
											<input type="text" class="filter" name="orderFilter_total_paid_tax_incl" value='{$filters.orderFilter_total_paid_tax_incl|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>
										</th>
										<th>
											<input type="text" class="filter" name="orderFilter_payment" value='{$filters.orderFilter_payment|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}''>
										</th>
										<th>
											<select class="filter" name="id_order_state">
												<option value="" selected="selected" {if $filters.id_order_state == false} selected {/if}>-</option>
													{foreach $statuses as $status}
														<option value='{$status.id_order_state|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}' {if $filters.id_order_state == $status.id_order_state} selected {/if}>{$status.name|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</option>
													{/foreach}										
											</select>
										</th>
										<th class="text-right">
										<div class="date_range row">
											<div class="input-group fixed-width-md center">
												<input type="text" class="filter datepicker date-input form-control" id="local_orderFilter_a__date_add_0" name="date_addA" placeholder="From">
												<input type="hidden" id="orderFilter_a__date_add_0" name="date_addA" value='{$filters.date_addA|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}''>
												<span class="input-group-addon">
													<i class="icon-calendar"></i>
												</span>
											</div>
											<div class="input-group fixed-width-md center">
												<input type="text" class="filter datepicker date-input form-control" id="local_orderFilter_a__date_add_1" name="date_addB" placeholder="To">
												<input type="hidden" id="orderFilter_a__date_add_1" name="date_addB" value='{$filters.date_addB|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>
												<span class="input-group-addon">
													<i class="icon-calendar"></i>
												</span>
											</div>
										</div>
									</th>
									<th>
										<div class="date_range row">
											<div class="input-group fixed-width-md center">
												<input type="text" class="filter datepicker date-input form-control" id="local_orderFilter_a__date_add_2" name="date_addA" placeholder="From">
												<input type="hidden" id="orderFilter_a__date_add_0" name="date_addC" value='{$filters.date_addC|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>
												<span class="input-group-addon">
													<i class="icon-calendar"></i>
												</span>
											</div>
											<div class="input-group fixed-width-md center">
												<input type="text" class="filter datepicker date-input form-control" id="local_orderFilter_a__date_add_3" name="date_addB" placeholder="To">
												<input type="hidden" id="orderFilter_a__date_add_1" name="date_addD" value='{$filters.date_addC|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>
												<span class="input-group-addon">
													<i class="icon-calendar"></i>
												</span>
											</div>
										</div>
									</th>
									<th>
										<input type="text" class="filter" name="orderFilter_carrierName" value='{$filters.orderFilter_carrierName|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>
									</th>
									<th>
										<input type="text" class="filter" name="orderFilter_phone" value='{$filters.orderFilter_phone|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>
									</th>
									<th>
										<input type="text" class="filter" name="orderFilter_email" value='{$filters.orderFilter_email|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>
									</th>													
									<th class="actions">
										<span class="pull-right">
											<button type="submit" id="submitFilterButtonorder" name="submitFilter" class="btn btn-default" data-list-id="order">
												<i class="icon-search"></i> {l s='Search' d='dsdeliveryhours'}
											</button>
										</span>
									</th>
								</tr>
							</form>
						</thead>
                        <tbody>
							{foreach $orders as $order}								
								<tr class=" odd">
									<td class="row-selector text-center">
										<input type="checkbox" name="orderBox[]" value="5" class="noborder">
									</td>						
									<td class="pointer fixed-width-xs text-center" onclick="document.location = 'index.php?controller=AdminOrders&amp;id_order={$order.id_order|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}&amp;vieworder&amp;token={$token|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'">										
										{$order.id_order|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}																											
									</td>					
									<td class="pointer" onclick="document.location = 'index.php?controller=AdminOrders&amp;id_order={$order.id_order|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}&amp;vieworder&amp;token={$token|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'">											
										{$order.reference|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}																																		
									</td>								
									<td class="pointer text-center" onclick="document.location = 'index.php?controller=AdminOrders&amp;id_order={$order.id_order|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}&amp;vieworder&amp;token={$token|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'">			
										{if $order.new == 0}
											{l s='No' d='dsdeliveryhours'}
										{else}
											{l s='Yes' d='dsdeliveryhours'}
										{/if}																						
									</td>					
									<td class="pointer" onclick="document.location = 'index.php?controller=AdminOrders&amp;id_order={$order.id_order|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}&amp;vieworder&amp;token={$token|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'">											
										{$order.cname|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}																															
									</td>		    
									<td class="pointer" onclick="document.location = 'index.php?controller=AdminOrders&amp;id_order={$order.id_order|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}&amp;vieworder&amp;token={$token|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'">								
										{$order.customer|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}																																	
									</td>								
									<td class="pointer text-right" onclick="document.location = 'index.php?controller=AdminOrders&amp;id_order={$order.id_order|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}&amp;vieworder&amp;token={$token|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'">											
										{foreach $currencies as $currencie}
											{if $order.id_currency == $currencie.id_currency}
												{$currencie.iso_code|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}
											{/if}
										{/foreach}
										{$order.total_paid_tax_incl|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"|truncate:5:""}																																								
									</td>							
									<td class="pointer" onclick="document.location = 'index.php?controller=AdminOrders&amp;id_order={$order.id_order|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}&amp;vieworder&amp;token={$token|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'">											
										{$order.payment|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}
									</td>
									<td class="pointer" onclick="document.location = 'index.php?controller=AdminOrders&amp;id_order={$order.id_order|strip_tags:"UTF-8"}&amp;vieworder&amp;token={$token|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'">											
										<span class="label color_field" style="background-color:{$order.color|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"};color:white">
											{$order.osname|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}
										</span>																						
									</td>							
									<td class="pointer text-right" onclick="document.location = 'index.php?controller=AdminOrders&amp;id_order={$order.id_order|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}&amp;vieworder&amp;token={$token|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'">											
										{$order.date_add|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}																															
									</td>
									<td  class="pointer text-right">
										{$order.event_hour_start|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"|truncate:5:""}
										{$order.event_hour_stop|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"|truncate:5:""}
										{$order.event_date|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}
									</td>
									<td class='pointer text-right'>
										{$order.shipper_name|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}
									</td>				                			
									<td class='pointer text-right'>
										{$order.shipper_phone|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}										
									</td>
									<td class='pointer text-right'>
										{$order.shipper_email|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}										
									</td>									
									<td class="text-right">
										<div class="btn-group pull-right">
											<a href="index.php?controller=AdminOrders&amp;id_order={$order.id_order|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}&amp;vieworder&amp;token={$token|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}" class="btn btn-default" title="View">
												<i class="icon-search-plus"></i> {l s='View' d='dsdeliveryhours'}
											</a>
										</div>
									</td>
								</tr>	
							{/foreach}							                  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{literal}
	<script type="text/javascript">
		window.onload = function()
		{ 
			$( "#local_orderFilter_a__date_add_0" ).datepicker({
			dateFormat: "yy-mm-dd"
			});
			$( "#local_orderFilter_a__date_add_1" ).datepicker({
			dateFormat: "yy-mm-dd"
			});
			$( "#local_orderFilter_a__date_add_2" ).datepicker({
			dateFormat: "yy-mm-dd"
			});
			$( "#local_orderFilter_a__date_add_3" ).datepicker({
			dateFormat: "yy-mm-dd"
			});
		}
	</script>
{/literal}

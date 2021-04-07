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

<div class="panel">
	<h3><i class="icon icon-truck"></i> {l s='DS: Delivery hours - Add Schedule' mod='dsdeliveryhours'}</h3>
	<form id='addDeliverySchema' class='form-horizontal' method='POST'>
		<input type='hidden' name='addDeliverySchema'>
		<div class='panel-body'>	
			{*<div class="input-group date" id="datetimepickerfrom" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" data-target="#datetimepickerfrom"/>
                <div class="input-group-append" data-target="#datetimepickerfrom" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
			<div class="input-group date" id="datetimepickerto" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" data-target="#datetimepickerto"/>
                <div class="input-group-append" data-target="#datetimepickerto" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>*}
			<div class='form-group'>
				
			</div>
			<div class='table'>
				<table class='table table-responsive'>
					<thead class='thead-default'>
						<tr class='column-headers'>							
							<th scope="col">{l s='Delivery day' mod='dsdeliveryhours'}</th>
							<th scope="col">{l s='Start' mod='dsdeliveryhours'}</th>
							<th scope="col">{l s='Stop' mod='dsdeliveryhours'}</th>
							<th scope="col">{l s='From' mod='dsdeliveryhours'}</th>
							<th scope="col">{l s='To' mod='dsdeliveryhours'}</th>						
							<th scope="col">{l s='Shipper' mod='dsdeliveryhours'}</th>
							<th scope='col'>{l s='Max orders' mod='dsdeliveryhours'}</th>					
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<select class='form-control' name='dayWeek'>
									<option disabled>{l s='Select day of the week' mod='dsdeliveryhours'}</option>
									{foreach $days as $day}
										<option value='{$day.id|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>{$day.day|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</option>
									{/foreach}
								</select>
							</td>
							<td>
								<select class='form-control' name='hourStart'>
									<option disabled>{l s='Select starting hour' mod='dsdeliveryhours'}</option>
									{foreach $hours as $hour}							
										<option value='{$hour.id_deliveryhoursinterval|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>{$hour.interval_time|strip_tags:'UTF-8'|escape:'htmlall':'UTF-8'|truncate:5:""}</option>
									{/foreach}									
								</select>
							</td>
							<td>
								<select class='form-control' name='hourStop'>
									<option disabled>{l s='Select ending hour' mod='dsdeliveryhours'}</option>
									{foreach $hours as $hour}
										<option value='{$hour.id_deliveryhoursinterval|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>{$hour.interval_time|strip_tags:'UTF-8'|escape:'htmlall':'UTF-8'|truncate:5:""}</option>
									{/foreach}	
								</select>
							</td>
							<td>
								<input type='date' class='form-control' name='dateStart'>
							</td>
							<td>
								<input type='date' class='form-control' name='dateStop'>
							</td>							
								<td>
									<select class='form-control' id='selectCarrier' name='selectCarrier'>
										<option disabled>{l s='Select shipper' mod='dsdeliveryhours'}</option>
										{foreach $carriers as $carrier}						
											<option value='{$carrier.id_deliveryhoursshipper|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>{$carrier.shipper_name|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</option>
										{/foreach}
									</select>
								</td>				
							<td>
								<input type='number' class='form-control' name='maxOrdersPerInterval' value='{$defultMaxorders|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>
							</td>								
						</tr>
					</tbody>
				</table>
			</div>
		
	</div>
	<div class='panel-footer'>
		<a href='{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}' class='pull-left btn btn-default'>{l s='Back' mod='dsdeliveryhours'}</a>                    
		<button class='btn btn-default pull-right'><i class="process-icon-save"></i>{l s='Save' mod='dsdeliveryhours'}</button>
	</div>
	</form>
</div>

{*{literal}
	<script type="text/javascript">
        $(function () {
            $('#datetimepickerfrom').datetimepicker();
			$('#datetimepickerto').datetimepicker();
        });
    </script>
{/literal}*}

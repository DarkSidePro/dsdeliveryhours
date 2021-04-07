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
	<h3><i class="icon icon-truck"></i> {l s='DS: Delivery hours - Main settings' mod='dsdeliveryhours'}</h3>
	<div class='panel-body'>
		<div class='container'>
			<div class='row'>
				<div class='col-lg-12'>
					<form id='defaultSchema' class='form-horizontal' method='POST'>
						<input type='hidden' name='defaultSchema'>
						<div class='form-group'>
							<label for='timeSchemaStart'>{l s='Shipping starts from:' mod='dsdeliveryhours'}</label>
							<div class="input-group clockpicker">
								<input type='text' class='form-control' name='timeSchemaStart' id='time1' readonly value='{$mainSettings.main_hour_start|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"|truncate:5:""}'>
								<span class='time btn btn-default' onclick="darkPicker1()">Change</span> 							
							</div>						
						</div>
						<div class='form-group'>
							<label for='timeSchemaStop'>{l s='Shipping stops at:' mod='dsdeliveryhours'}</label>
							<div class="input-group clockpicker">
								<input type="text" class="form-control time" name='timeSchemaStop' readonly id='time2' value='{$mainSettings.main_hour_stop|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"|truncate:5:""}'>
								<span class='time btn btn-default' onclick="darkPicker2()">Change</span>								
							</div>							
						</div>
						<br />
						<div class='form-group'>					
							<label for='interval'>{l s='Time interval:' mod='dsdeliveryhours'}</label>
							<div class="input-group clockpicker">
								<input type="text" class="form-control" readonly name='timeInterval' id='time3' value='{$mainSettings.main_interval|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"|truncate:5:""}'>
								<span class='time btn btn-default' onclick="darkPicker3()">Change</span>
							</div>
						</div>
						<br />
						<div class='form-group'>
							<label>{l s='Delay:' mod='dsdeliveryhours'}</label>
							<input type='number' class='form-control' name='deliveryDelay' min='0' value='{$mainSettings.main_day_delay|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>
						</div>
						<br />
						<div class='form-group'>
							<label>{l s='Duration:' mod='dsdeliveryhours'}</label>
							<input type='number' class='form-control' name='deliveryDayLimit' min='0' value='{$mainSettings.main_day_limit|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>
						</div>
						<br />
						<div class='form-group'>
							<label>{l s='Number of orders per interval:' mod='dsdeliveryhours'}</label>
							<input type='number' class='form-control' name='deliveryIntervalLimit' min='0' value='{$mainSettings.main_order_number|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}'>
						</div>
						<button type='submit' class='pull-right btn btn-default'>{l s='Save' mod='dsdeliveryhours'}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class='panel'>
	<h3>
		<i class="icon icon-truck"></i> {l s='DS: Delivery hours - Shippers list' mod='dsdeliveryhours'}
		<span class="panel-heading-action">
			<a class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules|strip_tags:'UTF-8'|escape:'htmlall':'UTF-8'}&addEmploye=1">
				<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new" data-html="true">
					<i class="process-icon-new"></i>
				</span>
        	</a>
    	</span>
	</h3>
	<div class='panel-body'>
		<table class='table'>
			<thead class='thead-default'>
				<tr class='column-headers'>
					<th>{l s='ID' mod='dsdeliveryhours'}</th>
					<th>{l s='Shipper name' mod='dsdeliveryhours'}</th>
					<th>{l s='Phone' mod='dsdeliveryhours'}</th>
					<th>{l s='Email' mod='dsdeliveryhours'}</th>
					<th>{l s='Address' mod='dsdeliveryhours'}</th>					
					<th>{l s='VAT/DNI' mod='dsdeliveryhours'}</th>
					<th>{l s='Cost' mod='dsdeliveryhours'}</th>
					<th>{l s='Description' mod='dsdeliveryhours'}</th>
					<th>{l s='Actions' mod='dsdeliveryhours'}</th>					
				</tr>
			</thead>
			<tbody>			
				{foreach $carriers as $carrier}
					<tr>						
						<th>{$carrier.id_deliveryhoursshipper|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</th>
						<td>{$carrier.shipper_name|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</td>
						<td>{$carrier.shipper_phone|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</td>
						<td>{$carrier.shipper_email|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</td>
						<td>{$carrier.shipper_address|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</td>
						<td>{$carrier.shipper_vat_number|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</td>
						<td>{$carrier.shipper_cost|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</td>
						<td>{$carrier.shipper_description|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</td>
						<td>
							<div class="btn-group-action">
								<div class="btn-group pull-right">
									<a href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&editCarrier={$carrier.id_deliveryhoursshipper}"
									title="{l s='Edit' mod='dsdeliveryhours'}" class="details btn btn-default">
										<i class="icon-edit"></i> {l s='Edit' mod='dsdeliveryhours'}
									</a>
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down"></i>&nbsp;
									</button>
									{if $carrier.id_deliveryhoursshipper != 1}
										<ul class="dropdown-menu">
											<li>
												<a href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&deleteCarrier={$carrier.id_deliveryhoursshipper}"
												title="{l s='Delete' mod='dsdeliveryhours'}" class="notes">
													<i class="icon-upload"></i> {l s='Delete' mod='dsdeliveryhours'}
												</a>
											</li>
										</ul>
									{/if}
								</div>
							</div>
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>	
</div>
<div class="panel">
	<h3>
		<i class="icon icon-truck"></i> {l s='DS: Delivery hours - Scheduling' mod='dsdeliveryhours'}
		<span class="panel-heading-action">
			<a class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&addNew=1">
				<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new" data-html="true">
					<i class="process-icon-new "></i>
				</span>
        	</a>
    	</span>
	</h3>	
	<div class='panel-body'>
		<table class='table'>
			<thead class='thead-default'>
				<tr class='column-headers'>
					<th>{l s='ID' mod='dsdeliveryhours'}</th>
					<th>{l s='From' mod='dsdeliveryhours'}</th>
					<th>{l s='To' mod='dsdeliveryhours'}</th>
					<th>{l s='Day of the week' mod='dsdeliveryhours'}</th>					
					<th>{l s='Shipper name' mod='dsdeliveryhours'}</th>										
					<th>{l s='Max orders' mod='dsdeliveryhours'}</th>
					<th>{l s='Actions' mod='dsdeliveryhours'}</th>					
				</tr>
			</thead>
			<tbody>
				{foreach $deliverySchemas as $schema}
					<tr>
						<td>{$schema.id_deliveryhoursrules|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</td>
						<td>{$schema.rules_start|date_format|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</td>
						<td>{$schema.rules_stop|date_format|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</td>
						<td>
							{foreach $days as $day}								
								{if $schema.rules_day_ID == $day.id}
									{$day.day|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}
								{/if}
							{/foreach}
						</td>
						<td>
							{foreach $carriers as $carrier}
								{if $carrier.id_deliveryhoursshipper == $schema.id_deliveryhoursshipper}
									{$carrier.shipper_name|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}
								{/if}
							{/foreach}
						</td>						
						<td>{$schema.rules_quantity|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</td>
						<td>
							<div class="btn-group-action">
								<div class="btn-group pull-right">
									<a href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&editSchema={$schema.id_deliveryhoursrules}"
									title="{l s='Edit' mod='dsdeliveryhours'}" class="details btn btn-default">
										<i class="icon-edit"></i> {l s='Edit' mod='dsdeliveryhours'}
									</a>
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
										<i class="icon-caret-down"></i>&nbsp;
									</button>
									<ul class="dropdown-menu">
										<li>
											<a href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&deleteSchema={$schema.id_deliveryhoursrules}"
											title="{l s='Delete' mod='dsdeliveryhours'}" class="notes">
												<i class="icon-upload"></i> {l s='Delete' mod='dsdeliveryhours'}
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
</div>
<div class="panel">
	<h3><i class="icon icon-truck"></i> {l s='DS: Delivery hours - Notifications' mod='dsdeliveryhours'}</h3>
	<div class='panel-body'>
		<div class='container'>
			<div class='row'>
				<div class='col-lg-12'>
					<form id='notyfications' class='form-horizontal' method='POST'>
						<input type='hidden' name='notifications'>
						<div class="form-group">
                            <span class="ps-switch ps-switch-sm border">
                                <input type="radio" name="extraOrders" id="example_off_1b" value="0" {if $extraOrders == 0} checked {/if}>
                                <label for="example_off_1b">Yes</label>
                                <input type="radio" name="extraOrders" id="example_on_1b" value="1" {if $extraOrders == 1} checked {/if}>
                                <label for="example_on_1b">No</label>
                                <span class="slide-button"></span>
                            </span>
                            <small class="form-text">{l s='Do you want to send extra e-mails to employees for orders using this module?' d='dsdeliveryhours'}</small>
                        </div>
						
						
							<div class="form-group">
								<label>{l s='Select status name which sends extra e-mail to employees:' d='dsdeliveryhours'}</label>
								<select class='form-control' name='reminderTeam'>
									<option disabled>Select status</option>
									{foreach $statuses as $status}
										<option value='{$status.id_order_state|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}' {if $adminNotifyStatus == $status.id_order_state}selected{/if}>{$status.name|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</option>
									{/foreach}
								</select>
							</div>
						

						<div class="form-group">
                            <span class="ps-switch ps-switch-sm border">
                                <input type="radio" name="extraCustomer" id="example_off_1b" value="0" {if $extraCustomer == 0} checked {/if}>
                                <label for="example_off_1b">Yes</label>
                                <input type="radio" name="extraCustomer" id="example_on_1b" value="1" {if $extraCustomer == 1} checked {/if}>
                                <label for="example_on_1b">No</label>
                                <span class="slide-button"></span>
                            </span>
                            <small class="form-text">{l s='Do you want to send extra e-mails to customers for orders using this module?' d='dsdeliveryhours'}</small>
                        </div>
						
							<div class="form-group">
								<label>{l s='Select status name which sends extra e-mail to customers:' d='dsdeliveryhours'}</label>
								<select class='form-control' name='reminderSupplier'>
									<option disabled selected>Select status</option>
									{foreach $statuses as $status}
										<option value='{$status.id_order_state|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}' {if $customerNotifyStatus == $status.id_order_state}selected{/if}>{$status.name|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</option>
									{/foreach}
								</select>
							</div>
						

						<div class="form-group">
                            <span class="ps-switch ps-switch-sm border">
                                <input type="radio" name="extraSupplier" id="example_off_1b" value="0" {if $extraSupplier == 0} checked {/if}>
                                <label for="example_off_1b">Yes</label>
                                <input type="radio" name="extraSupplier" id="example_on_1b" value="1" {if $extraSupplier == 1} checked {/if}>
                                <label for="example_on_1b">No</label>
                                <span class="slide-button"></span>
                            </span>
                            <small class="form-text">{l s='Do you want to send extra e-mails to shippers for orders using this module?' d='dsdeliveryhours'}</small>
                        </div>
						
						
							<div class="form-group">
								<label>{l s='Select status name which sends extra e-mail to shippers:' d='dsdeliveryhours'}</label>
								<select class='form-control' name='reminderCustomer'>
									<option disabled selected>Select status</option>
									{foreach $statuses as $status}
										<option value='{$status.id_order_state|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}' {if $deliverNotifyStatus == $status.id_order_state}selected{/if}>{$status.name|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}</option>
									{/foreach}
								</select>
							</div>
						
						<button type='submit' class='pull-right btn btn-default'>{l s='Save' mod='dsdeliveryhours'}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
{literal}
	<script>
		function darkPicker1() {
			Timepicker.showPicker({
				time: document.getElementById('time1').value,
				headerBackground: '#424242',
				headerColor: '#e0e0e0',
				headerSelected: '#fafafa',
				wrapperBackground: "#424242",
				footerBackground: "#424242",
				submitColor: "#F44336",
				cancelColor: "#F44336",
				clockBackground: "#424242",
				clockItemColor: "#fafafa",
				clockItemInnerColor: "#e0e0e0",
				handColor: "#F44336",
				onSubmit: (selected) => {
					document.getElementById("time1").value = selected.formatted();
				}
			})
		}
		function darkPicker2() {
			Timepicker.showPicker({
				time: document.getElementById('time2').value,
				headerBackground: '#424242',
				headerColor: '#e0e0e0',
				headerSelected: '#fafafa',
				wrapperBackground: "#424242",
				footerBackground: "#424242",
				submitColor: "#F44336",
				cancelColor: "#F44336",
				clockBackground: "#424242",
				clockItemColor: "#fafafa",
				clockItemInnerColor: "#e0e0e0",
				handColor: "#F44336",
				onSubmit: (selected) => {
					document.getElementById("time2").value = selected.formatted();
				}
			})
		}
		function darkPicker3() {
			Timepicker.showPicker({
				time: document.getElementById('time3').value,
				headerBackground: '#424242',
				headerColor: '#e0e0e0',
				headerSelected: '#fafafa',
				wrapperBackground: "#424242",
				footerBackground: "#424242",
				submitColor: "#F44336",
				cancelColor: "#F44336",
				clockBackground: "#424242",
				clockItemColor: "#fafafa",
				clockItemInnerColor: "#e0e0e0",
				handColor: "#F44336",
				onSubmit: (selected) => {
					document.getElementById("time3").value = selected.formatted();
				}
			})
		}
	</script>
{/literal}
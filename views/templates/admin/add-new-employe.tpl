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
	<h3><i class="icon icon-truck"></i> {l s='DS: Delivery hours - Add Shipper' mod='dsdeliveryhours'}</h3>
	<div class='panel-body'>
		<div class='container'>
			<div class='row'>
				<div class='col-lg-12'>
					<form id='addNewEmploye' class='form-horizontal' method='POST'>
						<input type='hidden' name='addNewEmploye'>
                        <div class='form-group'>
                            <label for='firstname'>{l s='Name' mod='dsdeliveryhours'}</label>
                            <input type='text' class='form-control' name='name' required> 
                        </div>
                        <div class='form-group'>
                            <label for='email'>{l s='Email' mod='dsdeliveryhours'}</label>
                            <input type='email' class='form-control' name='email'>
                        </div>
                        <div class='form-group'>
                            <label for='phone'>{l s='Phone' mod='dsdeliveryhours'}</label>
                            <input type='text' class='form-control' name='phone'>
                        </div>
                        <div class='form-group'>
                            <label for='address'>{l s='Address' mod='dsdeliveryhours'}</label>
                            <input type='text' class='form-control' name='address'>
                        </div>
                        <div class='form-group'>
                            <label for='vat_number'>{l s='VAT/DNI Number' mod='dsdeliveryhours'}</label>
                            <input type='text' class='form-control' name='vat'>
                        </div>
                        <div class='form-group'>
                            <label for='cost'>{l s='Shipper cost' mod='dsdeliveryhours'}</label>
                            <input type='number' class='form-control' name='cost' step="0.01">
                        </div>
                        <div class='form-group'>
                            <label for='desc'>{l s='Description' mod='dsdeliveryhours'}</label>
                            <textarea class='form-control' name='desc'></textarea>
                        </div>
                        <a href='{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}' class='pull-left btn btn-default'>{l s='Back' mod='dsdeliveryhours'}</a>                    
						<button type='submit' class='pull-right btn btn-default'>{l s='Save' mod='dsdeliveryhours'}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


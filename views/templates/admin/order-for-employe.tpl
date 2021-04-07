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
	<h3><i class="icon icon-truck"></i> {l s='DS: Delivery hours' mod='dsdeliveryhours'}</h3>
	<span class="panel-heading-action">
        <a id="desc-product-new" class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')|escape:'html':'UTF-8'}&configure={$namemodules|strip_tags:"UTF-8"|escape:"htmlall":"UTF-8"}&addNew=1">
            <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new" data-html="true">
                <i class="process-icon-new "></i>
			</span>
        </a>
    </span>
	<div class='panel-body'>
		{*<table class='table'>
			<thead class='thead-default'>
				<tr class='column-headers'>
					<th>{l s='ID' mod='dsdeliveryhours'}</th>
					<th>{l s='Shipper name' mod='dsdeliveryhours'}</th>
					<th>{l s='From' mod='dsdeliveryhours'}</th>
					<th>{l s='To' mod='dsdeliveryhours'}</th>
					<th>{l s='Day of the week' mod='dsdeliveryhours'}</th>
					<th>{l s='Status' mod='dsdeliveryhours'}</th>
					<th></th>					
				</tr>
			</thead>
			<tbody>

			{* Tu będzie jakiś foreach *}

			</tbody>
		</table>*}
	</div>
</div>

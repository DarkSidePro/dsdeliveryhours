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

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once dirname(__FILE__).'/classes/DS.php';

class Dsdeliveryhours extends CarrierModule
{
    protected $config_form = false;
    public $carrier;
    public $toolbar_title;
    protected $statuses_array = array();

    public function __construct()
    {
        $this->name = 'dsdeliveryhours';
        $this->tab = 'shipping_logistics';
        $this->version = '1.0.0';
        $this->author = 'Dark-Side.pro';
        $this->need_instance = 1;
        $this->module_key = '432f5ba4356bf514c428e29ba86a78d6';

        /*
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DS: delivery hours');
        $this->description = $this->l('Configuration of delivery hours');

        $this->confirmUninstall = $this->l('Do you want remove this module?');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    private function createTab()
    {
        $response = true;
        $parentTabID = Tab::getIdFromClassName('AdminDarkSideMenu');
        if ($parentTabID) {
            $parentTab = new Tab($parentTabID);
        } else {
            $parentTab = new Tab();
            $parentTab->active = 1;
            $parentTab->name = array();
            $parentTab->class_name = 'AdminDarkSideMenu';
            foreach (Language::getLanguages() as $lang) {
                $parentTab->name[$lang['id_lang']] = 'Dark-Side.pro';
            }
            $parentTab->id_parent = 0;
            $parentTab->module = '';
            $response &= $parentTab->add();
        }
        $parentTab_2ID = Tab::getIdFromClassName('AdminDarkSideMenuSecond');
        if ($parentTab_2ID) {
            $parentTab_2 = new Tab($parentTab_2ID);
        } else {
            $parentTab_2 = new Tab();
            $parentTab_2->active = 1;
            $parentTab_2->name = array();
            $parentTab_2->class_name = 'AdminDarkSideMenuSecond';
            foreach (Language::getLanguages() as $lang) {
                $parentTab_2->name[$lang['id_lang']] = 'Dark-Side Config';
            }
            $parentTab_2->id_parent = $parentTab->id;
            $parentTab_2->module = '';
            $response &= $parentTab_2->add();
        }
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdministratorDeliveryHours';
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = 'Delivery Hours';
        }
        $tab->id_parent = $parentTab_2->id;
        $tab->module = $this->name;
        $response &= $tab->add();

        return $response;
    }

    private function createSellerTab()
    {
        $response = true;

        $parentTab_2ID = Tab::getIdFromClassName('AdminParentOrders');
        if ($parentTab_2ID) {
            $parentTab_2 = new Tab($parentTab_2ID);
        }

        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdministratorDeliveryOrders';
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = 'DS: Delivery Orders';
        }
        $tab->id_parent = $parentTab_2->id;
        $tab->module = $this->name;
        $response &= $tab->add();

        return $response;
    }

    private function createFreeTab()
    {
        $response = true;

        $parentTab_2ID = Tab::getIdFromClassName('AdminParentOrders');
        if ($parentTab_2ID) {
            $parentTab_2 = new Tab($parentTab_2ID);
        }

        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdministratorDeliveryOrdersFree';
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = 'DS: Avaiable Orders';
        }
        $tab->id_parent = $parentTab_2->id;
        $tab->module = $this->name;
        $response &= $tab->add();

        return $response;
    }

    private function removeSellerTab()
    {
        $id_tab = Tab::getIdFromClassName('AdministratorDeliveryOrders');
        if ($id_tab) {
            $tab = new Tab($id_tab);
            $tab->delete();
        }

        return true;
    }

    private function removeFreeTab()
    {
        $id_tab = Tab::getIdFromClassName('AdministratorDeliveryOrdersFree');
        if ($id_tab) {
            $tab = new Tab($id_tab);
            $tab->delete();
        }

        return true;
    }

    private function tabRem()
    {
        $id_tab = Tab::getIdFromClassName('AdministratorDeliveryHours');
        if ($id_tab) {
            $tab = new Tab($id_tab);
            $tab->delete();
        }
        $parentTab_2ID = Tab::getIdFromClassName('AdminDarkSideMenuSecond');
        if ($parentTab_2ID) {
            $tabCount_2 = Tab::getNbTabs($parentTab_2ID);
            if ($tabCount_2 == 0) {
                $parentTab_2 = new Tab($parentTab_2ID);
                $parentTab_2->delete();
            }
        }
        $parentTabID = Tab::getIdFromClassName('AdminDarkSideMenu');
        if ($parentTabID) {
            $tabCount = Tab::getNbTabs($parentTabID);
            if ($tabCount == 0) {
                $parentTab = new Tab($parentTabID);
                $parentTab->delete();
            }
        }

        return true;
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update.
     */
    public function install()
    {
        if (extension_loaded('curl') == false) {
            $this->_errors[] = $this->l('You have to enable the cURL extension on your server to install this module');

            return false;
        }

        $carrier = $this->addCarrier();

        $this->addZones($carrier);
        $this->addGroups($carrier);
        $this->addRanges($carrier);

        include dirname(__FILE__).'/sql/install.php';
        DS::sqlAddIntervals();
        DS::sqlAddDays();
        DS::sqlAddOrders();

        $this->createTab();
        $this->createSellerTab();
        $this->createFreeTab();

        Configuration::updateValue('DSDELIVERYHOURS_EXTRAORDERS', (int) 1);
        Configuration::updateValue('DSDELIVERYHOURS_EXTRACUSTOMER', (int) 1);
        Configuration::updateValue('DSDELIVERYHOURS_EXTRASUPPLIER', (int) 1);
        Configuration::updateValue('DSDELIVERYHOURS_REMINDERTEAM_STATUS', (int) 0);
        Configuration::updateValue('DSDELIVERYHOURS_REMINDERSUPPLIER_STATUS', (int) 0);
        Configuration::updateValue('DSDELIVERYHOURS_REMINDERCUSTOMER_STATUS', (int) 0);

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('updateCarrier') &&
            $this->registerHook('displayCarrierExtraContent') &&
            $this->registerHook('actionCarrierProcess') &&
            $this->registerHook('actionCarrierUpdate') &&
            $this->registerHook('actionValidateOrder') &&
            $this->registerHook('actionOrderStatusPostUpdate');
    }

    public function uninstall()
    {
        $this->tabRem();
        $this->removeSellerTab();
        $this->removeCarriers();
        $this->removeFreeTab();

        include dirname(__FILE__).'/sql/uninstall.php';

        return parent::uninstall();
    }

    /**
     * Load the configuration form.
     */
    public function getContent()
    {
        DS::sqlDayEngine();
        DS::sqlMainEngine();

        DS::versionValidation();

        //var_dump(DS::getOrderDataGlobal(30,1));

        if ((bool) Tools::isSubmit('getdeliveryorders')) {
            return $this->getOrders();
        } elseif ((bool) Tools::isSubmit('getdeliveryordersfree')) {
            return $this->getFreeOrders();
        } else {
            $msg = '';

            $isNotification = Tools::isSubmit('notifications');
            $isDefultSchema = Tools::isSubmit('defaultSchema');

            if ((bool) Tools::isSubmit('notifications') == true) {
                $extraOrders = Tools::getValue('extraOrders');
                $extraCustomer = Tools::getValue('extraCustomer');
                $extraSupplier = Tools::getValue('extraSupplier');
                $reminderTeam = Tools::getValue('reminderTeam');
                $reminderSupplier = Tools::getValue('reminderSupplier');
                $reminderCustomer = Tools::getValue('reminderCustomer');

                if (Validate::isInt($extraOrders) != true) {
                    $msg .= $this->displayError($this->trans(
                        'Incorect value in extra order mail field',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                } else {
                    $confirm = Configuration::updateValue('DSDELIVERYHOURS_EXTRAORDERS', (int) $extraOrders);

                    if ($confirm) {
                        $msg .= (new Dsdeliveryhours())->displayConfirmation(
                            Context::getContext()->getTranslator()->trans(
                                'Extra order mail - success.',
                                array(),
                                'Admin.Dsdeliveryhours.Success'
                            )
                        );
                    } else {
                        $msg .= $this->displayError($this->trans(
                            'Extra order mail - insertion failed',
                            array(),
                            'Admin.Dsdeliveryhours.Error'
                        ));
                    }
                }

                if (Validate::isInt($extraCustomer) != true) {
                    $msg .= $this->displayError($this->trans(
                        'Incorect value in extra customer mail field',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                } else {
                    $confirm = Configuration::updateValue('DSDELIVERYHOURS_EXTRACUSTOMER', (int) $extraCustomer);

                    if ($confirm) {
                        $msg .= (new Dsdeliveryhours())->displayConfirmation(
                            Context::getContext()->getTranslator()->trans(
                                'Extra customer mail - success.',
                                array(),
                                'Admin.Dsdeliveryhours.Success'
                            )
                        );
                    } else {
                        $msg .= $this->displayError($this->trans(
                            'Extra customer mail - insertion failed',
                            array(),
                            'Admin.Dsdeliveryhours.Error'
                        ));
                    }
                }

                if (Validate::isInt($extraSupplier) != true) {
                    $msg .= $this->displayError($this->trans(
                        'Incorect value in extra supplier field',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                } else {
                    $confirm = Configuration::updateValue('DSDELIVERYHOURS_EXTRASUPPLIER', (int) $extraSupplier);

                    if ($confirm) {
                        $msg .= (new Dsdeliveryhours())->displayConfirmation(
                            Context::getContext()->getTranslator()->trans(
                                'Extra supplier mail - success.',
                                array(),
                                'Admin.Dsdeliveryhours.Success'
                            )
                        );
                    } else {
                        $msg .= $this->displayError($this->trans(
                            'Extra supplier mail - insertion failed',
                            array(),
                            'Admin.Dsdeliveryhours.Error'
                        ));
                    }
                }

                if (Validate::isInt($reminderTeam) != true) {
                    $msg .= $this->displayError($this->trans(
                        'Incorect value in status field for shop team',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                } else {
                    $confirm = Configuration::updateValue('DSDELIVERYHOURS_REMINDERTEAM_STATUS', (int) $reminderTeam);

                    if ($confirm) {
                        $msg .= (new Dsdeliveryhours())->displayConfirmation(
                            Context::getContext()->getTranslator()->trans(
                                'Status field for shop team - successfully inserted.',
                                array(),
                                'Admin.Dsdeliveryhours.Success'
                            )
                        );
                    } else {
                        $msg .= $this->displayError($this->trans(
                            'Status field for shop team - insertion failed',
                            array(),
                            'Admin.Dsdeliveryhours.Error'
                        ));
                    }
                }

                if (Validate::isInt($reminderSupplier) != true) {
                    $msg .= $this->displayError($this->trans(
                        'Incorect value in status field for supplier',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                } else {
                    $confirm = Configuration::updateValue('DSDELIVERYHOURS_REMINDERSUPPLIER_STATUS', (int) $reminderSupplier);

                    if ($confirm) {
                        $msg .= (new Dsdeliveryhours())->displayConfirmation(
                            Context::getContext()->getTranslator()->trans(
                                'Status field for supplier - successfully inserted.',
                                array(),
                                'Admin.Dsdeliveryhours.Success'
                            )
                        );
                    } else {
                        $msg .= $this->displayError($this->trans(
                            'Status field for supplier - insertion failed',
                            array(),
                            'Admin.Dsdeliveryhours.Error'
                        ));
                    }
                }

                if (Validate::isInt($reminderCustomer) != true) {
                    $msg .= $this->displayError($this->trans(
                        'Incorect value in status field for customer',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                } else {
                    $confirm = Configuration::updateValue('DSDELIVERYHOURS_REMINDERCUSTOMER_STATUS', (int) $reminderCustomer);

                    if ($confirm) {
                        $msg .= (new Dsdeliveryhours())->displayConfirmation(
                            Context::getContext()->getTranslator()->trans(
                                'Status field for customer - successfully inserted.',
                                array(),
                                'Admin.Dsdeliveryhours.Success'
                            )
                        );
                    } else {
                        $msg .= $this->displayError($this->trans(
                            'Status field for customer - insertion failed',
                            array(),
                            'Admin.Dsdeliveryhours.Error'
                        ));
                    }
                }
            }

            if ((bool) Tools::isSubmit('deleteCarrier') == true && $isNotification != true && $isDefultSchema != true) {
                $carrierId = Tools::getValue('deleteCarrier');

                if (Validate::isInt($carrierId) != true) {
                    $msg = $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                } else {
                    $msg = DS::sqlDeleteCarrier($carrierId);
                }
            }

            if ((bool) Tools::isSubmit('deleteSchema') == true) {
                $schemaId = Tools::getValue('deleteSchema');

                if (Validate::isInt($schemaId) != true) {
                    $msg = $this->displayError($this->trans(
                        'schema ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                } else {
                    $msg = DS::sqlDeleteDeliverySchedule($schemaId);
                }
            }

            if ((bool) Tools::isSubmit('editDeliverySchema') == true && $isNotification != true && $isDefultSchema != true) {
                $msg = '';
                $validation = true;

                $schemaID = Tools::getValue('editDeliverySchema');
                $deliveryDay = Tools::getValue('dayWeek');
                $hourStart = Tools::getValue('hourStart');
                $hourStop = Tools::getValue('hourStop');
                $dateStart = Tools::getValue('dateStart');
                $dateStop = Tools::getValue('dateStop');
                $maxItems = Tools::getValue('maxOrdersPerInterval');
                $selectCarrier = Tools::getValue('selectCarrier');

                if (Validate::isInt($hourStart) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Hour ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isInt($hourStop) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Hour ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isDate($dateStart) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Date start is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isDate($dateStop) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Date start is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isInt($maxItems) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Max orders per interval is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isInt($selectCarrier) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isInt($schemaID) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if ($validation) {
                    $msg = DS::sqlEditDeliverySchedule(
                        $schemaID,
                        $deliveryDay,
                        $dateStart,
                        $dateStop,
                        $hourStart,
                        $hourStop,
                        $selectCarrier,
                        $maxItems
                    );
                }
            }

            if ((bool) Tools::isSubmit('addDeliverySchema') == true && $isNotification != true && $isDefultSchema != true) {
                $msg = '';
                $validation = true;

                $deliveryDay = Tools::getValue('dayWeek');
                $hourStart = Tools::getValue('hourStart');
                $hourStop = Tools::getValue('hourStop');
                $dateStart = Tools::getValue('dateStart');
                $dateStop = Tools::getValue('dateStop');
                $maxItems = Tools::getValue('maxOrdersPerInterval');
                $selectCarrier = Tools::getValue('selectCarrier');

                if (Validate::isInt($hourStart) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Hour ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isInt($hourStop) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Hour ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isDate($dateStart) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Date start is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isDate($dateStop) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Date start is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isInt($maxItems) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Max orders per interval is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isInt($selectCarrier) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if ($validation) {
                    $msg = DS::sqlAddDeliverySchedule(
                        $deliveryDay,
                        $dateStart,
                        $dateStop,
                        $hourStart,
                        $hourStop,
                        $selectCarrier,
                        $maxItems
                    );
                    $msg .= DS::sqlMainEngine();
                }
            }

            if ((bool) Tools::isSubmit('editEmploye') == true && $isNotification != true && $isDefultSchema != true) {
                $msg = '';
                $validation = true;

                $carrierId = Tools::getValue('editEmploye');
                $name = Tools::getValue('name');
                $email = Tools::getValue('email');
                $phone = Tools::getValue('phone');
                $address = Tools::getValue('address');
                $vat = Tools::getValue('vat');
                $cost = Tools::getValue('cost');
                $desc = Tools::getValue('desc');

                if (Validate::isInt($carrierId) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isString($name) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isString($email) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isString($phone) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isString($address) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isString($vat) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isString($cost) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isString($desc) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if ($validation) {
                    $msg = DS::sqlAddDeliverySchedule(
                        $deliveryDay,
                        $dateStart,
                        $dateStop,
                        $hourStart,
                        $hourStop,
                        $selectCarrier,
                        $maxItems
                    );
                    $msg = DS::sqlEditOurCarrier($carrierId, $name, $email, $phone, $desc, $address, $vat, $cost);
                }
            }

            if ((bool) Tools::isSubmit('defaultSchema') == true) {
                $msg = '';
                $validationTime = false;
                $validationTime2 = false;
                $validationTime3 = false;

                $mainSettings = DS::sqlGetMainSettings();

                $timeSchemaStart = Tools::getValue('timeSchemaStart');
                $timeSchemaStop = Tools::getValue('timeSchemaStop');
                $timeInterval = Tools::getValue('timeInterval');
                $deliveryDelay = Tools::getValue('deliveryDelay');
                $deliveryLimit = Tools::getValue('deliveryDayLimit');
                $deliveryIntervalLimit = Tools::getValue('deliveryIntervalLimit');

                if (Validate::isString($timeSchemaStart) != true) {
                    $msg .= $this->displayError($this->trans(
                        'Shipping starts is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                } else {
                    $validationTime = true;
                }

                if (Validate::isString($timeSchemaStop) != true) {
                    $msg .= $this->displayError($this->trans(
                        'Shipping stops is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                } else {
                    $validationTime2 = true;
                }

                if ($timeSchemaStart < $timeSchemaStop != true) {
                    $msg .= $this->displayError(
                        $this->trans(
                            'Settings error - starting hour must be lower then ending.',
                            array(),
                            'Admin.Dsdeliveryhours.Success'
                        )
                    );
                } else {
                    $validationTime3 = true;
                }

                if ($validationTime3 && $validationTime && $validationTime2) {
                    $msg .= $this->displayConfirmation(
                        $this->trans(
                            'Shipping start and stops - success.',
                            array(),
                            'Admin.Dsdeliveryhours.Success'
                        )
                    );
                } else {
                    $timeSchemaStart = $mainSettings['main_hour_start'];
                    $timeSchemaStop = $mainSettings['main_hour_stop'];
                }

                if (Validate::isString($timeInterval) != true || $timeInterval == '00:00') {
                    $msg .= $this->displayError($this->trans(
                        'Time interval is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                    $timeInterval = $mainSettings['main_interval'];
                } else {
                    $msg .= $this->displayConfirmation(
                        $this->trans(
                            'Time interval - success.',
                            array(),
                            'Admin.Dsdeliveryhours.Success'
                        )
                    );
                }

                if (Validate::isInt($deliveryDelay) != true) {
                    $msg .= $this->displayError($this->trans(
                        'Delay is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                    $deliveryDelay = $mainSettings['main_day_delay'];
                } else {
                    $msg .= $this->displayConfirmation(
                        $this->trans(
                            'Delay - success.',
                            array(),
                            'Admin.Dsdeliveryhours.Success'
                        )
                    );
                }

                if (Validate::isInt($deliveryLimit) != true) {
                    $msg .= $this->displayError($this->trans(
                        'Duration is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                    $deliveryLimit = $mainSettings['main_day_limit'];
                } else {
                    $msg .= $this->displayConfirmation(
                        $this->trans(
                            'Duration - success.',
                            array(),
                            'Admin.Dsdeliveryhours.Success'
                        )
                    );
                }

                if (Validate::isInt($deliveryIntervalLimit) != true) {
                    $msg .= $this->displayError($this->trans(
                        'Number of orders per interval is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                    $deliveryIntervalLimit = $mainSettings['main_order_number'];
                } else {
                    $msg .= $this->displayConfirmation(
                        $this->trans(
                            'Number of orders per interval - success.',
                            array(),
                            'Admin.Dsdeliveryhours.Success'
                        )
                    );
                }

                $msg .= DS::sqlUpdateMainSettings(
                    $timeSchemaStart,
                    $timeSchemaStop,
                    $timeInterval,
                    $deliveryDelay,
                    $deliveryLimit,
                    $deliveryIntervalLimit
                );

                $msg .= DS::sqlClearAfterMainConfig();
                $msg .= DS::sqlAddIntervals();
                $msg .= DS::sqlAddDays();
                $msg .= DS::sqlAddOrders();
                $msg .= DS::sqlDayEngine();
                $msg .= DS::sqlMainEngine();
            }

            if ((bool) Tools::isSubmit('addNewEmploye') == true && $isNotification != true && $isDefultSchema != true) {
                $validation = true;

                $name = Tools::getValue('name');
                $email = Tools::getValue('email');
                $phone = Tools::getValue('phone');
                $address = Tools::getValue('address');
                $vat = Tools::getValue('vat');
                $cost = Tools::getValue('cost');
                $desc = Tools::getValue('desc');

                if (Validate::isString($name) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isString($email) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isString($phone) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isString($address) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isString($vat) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isString($cost) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if (Validate::isString($desc) != true) {
                    $validation = false;
                    $msg .= $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                }

                if ($validation) {
                    $msg = DS::sqlAddOurCarrier($name, $email, $phone, $desc, $address, $vat, $cost);
                }
            }

            $carriers = DS::sqlGetAllOurCarriers();
            $mainSettings = DS::sqlGetMainSettings();
            $deliverySchemas = DS::sqlGetAllDeliverySchedule();
            $days = $this->getDaysOfWeek();
            $idLang = Context::getContext()->language->id;
            $statuses = DS::sqlStateByLang($idLang);
            $extraOrders = Configuration::get('DSDELIVERYHOURS_EXTRAORDERS');
            $extraCustomer = Configuration::get('DSDELIVERYHOURS_EXTRACUSTOMER');
            $extraSupplier = Configuration::get('DSDELIVERYHOURS_EXTRASUPPLIER');
            $adminNotifyStatus = Configuration::get('DSDELIVERYHOURS_REMINDERTEAM_STATUS');
            $deliverNotifyStatus = Configuration::get('DSDELIVERYHOURS_REMINDERSUPPLIER_STATUS');
            $customerNotifyStatus = Configuration::get('DSDELIVERYHOURS_REMINDERCUSTOMER_STATUS');

            $this->context->smarty->assign('adminNotifyStatus', $adminNotifyStatus);
            $this->context->smarty->assign('deliverNotifyStatus', $deliverNotifyStatus);
            $this->context->smarty->assign('customerNotifyStatus', $customerNotifyStatus);
            $this->context->smarty->assign('days', $days);
            $this->context->smarty->assign('carriers', $carriers);
            $this->context->smarty->assign('mainSettings', $mainSettings);
            $this->context->smarty->assign('statuses', $statuses);
            $this->context->smarty->assign('module_dir', $this->_path);
            $this->context->smarty->assign('link', $this->context->link);
            $this->context->smarty->assign('namemodules', $this->name);
            $this->context->smarty->assign('deliverySchemas', $deliverySchemas);
            $this->context->smarty->assign('extraOrders', $extraOrders);
            $this->context->smarty->assign('extraCustomer', $extraCustomer);
            $this->context->smarty->assign('extraSupplier', $extraSupplier);

            $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

            if ((bool) Tools::isSubmit('addNewEmploye') == true && $isNotification != true && $isDefultSchema != true) {
                return $msg.$output;
            }

            if ((bool) Tools::isSubmit('deleteSchema') == true && $isNotification != true && $isDefultSchema != true) {
                return $msg.$output;
            }

            if ((bool) Tools::isSubmit('addDeliverySchema') == true && $isNotification != true && $isDefultSchema != true) {
                return $msg.$output;
            }

            if ((bool) Tools::isSubmit('editCarrier') == true && $isNotification != true && $isDefultSchema != true) {
                $carrierID = Tools::getValue('editCarrier');

                if (Validate::isInt($carrierID) != true) {
                    $msg = $this->displayError($this->trans(
                        'Carrier ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));

                    return $msg.$output;
                }

                $data = DS::sqlGetOurCarrier($carrierID);

                if (Tools::isEmpty($data) || $data == null || $data == false) {
                    $msg = $this->displayError($this->trans(
                        'Carrier not found',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));

                    return $msg.$output;
                }

                $this->context->smarty->assign('data', $data);

                $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/edit-employe.tpl');

                return $output;
            }

            if ((bool) Tools::isSubmit('editSchema') == true && $isNotification != true && $isDefultSchema != true) {
                $schemaID = Tools::getValue('editSchema');

                if (Validate::isInt($schemaID) != true) {
                    $msg = $this->displayError($this->trans(
                        'Schema ID is incorrect',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));

                    return $msg.$output;
                }

                $data = DS::getDeliveryDataSchedule($schemaID);
                $days = $this->getDaysOfWeek();
                $carriers = DS::sqlGetAllOurCarriers();
                $hours = DS::sqlGetAllIntervals();

                $this->context->smarty->assign('data', $data);
                $this->context->smarty->assign('days', $days);
                $this->context->smarty->assign('hours', $hours);
                $this->context->smarty->assign('carriers', $carriers);
                $output = $this->context->smarty->fetch(
                    $this->local_path.'views/templates/admin/edit-delivery-schedule.tpl'
                );

                return $output;
            }

            if ((bool) Tools::isSubmit('addEmploye') == true && $isNotification != true && $isDefultSchema != true) {
                $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/add-new-employe.tpl');

                return $output;
            }

            if ((bool) Tools::isSubmit('addNew') == true && $isNotification != true && $isDefultSchema != true) {
                $days = $this->getDaysOfWeek();
                $carriers = DS::sqlGetAllOurCarriers();
                $hours = DS::sqlGetAllIntervals();
                $defultMaxorders = DS::sqlGetDefaultOrders();

                $this->context->smarty->assign('days', $days);
                $this->context->smarty->assign('hours', $hours);
                $this->context->smarty->assign('carriers', $carriers);
                $this->context->smarty->assign('defultMaxorders', $defultMaxorders);

                $output = $this->context->smarty->fetch(
                    $this->local_path.'views/templates/admin/add-new-delivery-schedule.tpl'
                );

                return $output;
            }

            if ((bool) Tools::isSubmit('editNew') == true && $isNotification != true && $isDefultSchema != true) {
                $deliverySchemaId = Tools::getValue('editNew');

                if ($deliverySchemaId != null) {
                    return DS::sqlEditDeliverySchedule($deliverySchemaId);
                }
            }

            if ((bool) Tools::isSubmit('defaultSchema') == true) {
                return $msg.$output;
            }

            /* if ((bool) Tools::isSubmit('intervalSettings') == true) {
                return $msg.$output;
            } */

            if ((bool) Tools::isSubmit('deleteCarrier') == true && $isNotification != true && $isDefultSchema != true) {
                return $msg.$output;
            }

            if ((bool) Tools::isSubmit('editEmploye') == true && $isNotification != true && $isDefultSchema != true) {
                return $msg.$output;
            }

            return $output;
        }
    }

    protected function getFreeOrders()
    {
        $actualDays = DS::sqlGetAllDays();
        $actualIntervals = DS::sqlGetFrontIntervals();
        $actualOrders = DS::sqlGetAllOrders();
        $daysOfWeek = $this->getDaysOfWeek();
        DS::sqlDayEngine();
        DS::sqlMainEngine();

        $this->context->smarty->assign('actualDays', $actualDays);
        $this->context->smarty->assign('actualIntervals', $actualIntervals);
        $this->context->smarty->assign('actualOrders', $actualOrders);
        $this->context->smarty->assign('daysOfWeek', $daysOfWeek);
        $output = $this->context->smarty->fetch(
            $this->local_path.'views/templates/admin/admin-carrier-delivery-table.tpl'
        );

        return $output;
    }

    protected function getOrders()
    {
        $msg = '';

        if ((bool) Tools::isSubmit('orderBy') && Tools::getValue('orderBy') != '') {
            if (Validate::isOrderBy(Tools::getValue('orderBy')) != true) {
                $msg .= $this->displayError($this->trans(
                    'OrderBy field must be a string',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            } else {
                $orderBy = Tools::getValue('orderBy');
            }
        } else {
            $orderBy = false;
        }

        if ((bool) Tools::isSubmit('orderway') && Tools::getValue('orderway') != '') {
            if (Validate::isString(Tools::getValue('orderway')) != true) {
                $msg .= $this->displayError($this->trans(
                    'Orderway field must be a string',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            } else {
                if (Validate::isOrderWay(Tools::getValue('orderway')) != true) {
                    $msg .= $this->displayError($this->trans(
                        'Orderway field must be a ASC or DESC',
                        array(),
                        'Admin.Dsdeliveryhours.Error'
                    ));
                } else {
                    $orderway = Tools::getValue('orderway');
                }
            }
        } else {
            $orderway = false;
        }

        if ((bool) Tools::isSubmit('id_order_state') && Tools::getValue('id_order_state') != '') {
            if (Validate::isInt(Tools::getValue('id_order_state')) != true) {
                $msg .= $this->displayError($this->trans(
                    'id_order_state field must be a number',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            } else {
                $id_order_state = Tools::getValue('id_order_state');
            }
        } else {
            $id_order_state = false;
        }

        if ((bool) Tools::isSubmit('orderFilter_customer') && Tools::getValue('orderFilter_customer') != '') {
            if (Validate::isInt(Tools::getValue('orderFilter_customer')) != true) {
                $msg .= $this->displayError($this->trans(
                    'orderFilter_customer field must be a number',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            } else {
                $orderFilter_customer = Tools::getValue('orderFilter_customer');
            }
        } else {
            $orderFilter_customer = false;
        }

        if ((bool) Tools::isSubmit('orderFilter_country') && Tools::getValue('orderFilter_country') != '') {
            if (Validate::isInt('orderFilter_country') != true) {
                $msg .= $this->displayError($this->trans(
                    'orderFilter_country field must be a number',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            } else {
                $orderFilter_country = Tools::getValue('orderFilter_country');
            }
        } else {
            $orderFilter_country = false;
        }

        if ((bool) Tools::isSubmit('orderFilter_reference') && Tools::getValue('orderFilter_reference') != '') {
            if (Validate::isReference(Tools::getValue('orderFilter_reference')) != true) {
                $msg .= $this->displayError($this->trans(
                    'orderFilter_reference field must be a reference',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            } else {
                $orderFilter_reference = Tools::getValue('orderFilter_reference');
            }
        } else {
            $orderFilter_reference = false;
        }

        if ((bool) Tools::isSubmit('orderFilter_id_order') && Tools::getValue('orderFilter_id_order') != '') {
            if (Validate::isInt(Tools::getValue('orderFilter_id_order'))) {
                $msg .= $this->displayError($this->trans(
                    'orderFilter_id_order field must be a string',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            } else {
                $orderFilter_id_order = Tools::getValue('orderFilter_id_order');
            }
        } else {
            $orderFilter_id_order = false;
        }

        if ((bool) Tools::isSubmit('orderFilter_new') && Tools::getValue('orderFilter_new') != '') {
            if (Validate::isInt(Tools::getValue('orderFilter_new')) != true) {
                $msg .= $this->displayError($this->trans(
                    'orderFilter_new field must be a number',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            } else {
                $orderFilter_new = Tools::getValue('orderFilter_new');
            }
        } else {
            $orderFilter_new = false;
        }

        $testValue = (bool) Tools::isSubmit('orderFilter_total_paid_tax_incl');

        if ($testValue && Tools::getValue('orderFilter_total_paid_tax_incl') != '') {
            if (Validate::isPrice(Tools::getValue('orderFilter_total_paid_tax_incl')) != true) {
                $msg .= $this->displayError($this->trans(
                    'orderFilter_total_paid_tax_incl field must be a price',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            } else {
                $orderFilter_total_paid_tax_incl = Tools::getValue('orderFilter_total_paid_tax_incl');
            }
        } else {
            $orderFilter_total_paid_tax_incl = false;
        }

        if ((bool) Tools::isSubmit('orderFilter_payment') && Tools::getValue('orderFilter_payment') != '') {
            if (Validate::isInt(Tools::getValue('orderFilter_payment')) != true) {
                $msg .= $this->displayError($this->trans(
                    'orderFilter_payment field must be a int',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            } else {
                $orderFilter_payment = Tools::getValue('orderFilter_payment');
            }
        } else {
            $orderFilter_payment = false;
        }

        if ((bool) Tools::isSubmit('date_addA') && Tools::getValue('date_addA') != '') {
            if (Validate::isDate(Tools::getValue('date_addA')) != true) {
                $msg .= $this->displayError($this->trans(
                    'date_addA field must be a date',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            } else {
                $date_addA = Tools::getValue('date_addA');
            }
        } else {
            $date_addA = false;
        }

        if ((bool) Tools::isSubmit('date_addB') && Tools::getValue('date_addB') != '') {
            if (Validate::isDate(Tools::getValue('date_addB')) != true) {
                $msg .= $this->displayError($this->trans(
                    'date_addB field must be a date',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            } else {
                $date_addA = Tools::getValue('date_addB');
            }
        } else {
            $date_addB = false;
        }

        if ((bool) Tools::isSubmit('date_addC') && Tools::getValue('date_addC') != '') {
            if (Validate::isDate(Tools::getValue('date_addC')) != true) {
                $msg .= $this->displayError($this->trans(
                    'date_addC field must be a date',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            } else {
                $date_addA = Tools::getValue('date_addC');
            }
        } else {
            $date_addC = false;
        }

        if ((bool) Tools::isSubmit('date_addD') && Tools::getValue('date_addD') != '') {
            if (Validate::isDate(Tools::getValue('date_addD')) != true) {
                $msg .= $this->displayError($this->trans(
                    'date_addD field must be a date',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            } else {
                $date_addD = Tools::getValue('date_addD');
            }
        } else {
            $date_addD = false;
        }

        if ((bool) Tools::isSubmit('orderFilter_phone') && Tools::getValue('orderFilter_phone') != '') {
            if (Validate::isPhoneNumber(Tools::getValue('orderFilter_phone')) != true) {
                $msg .= $this->displayError($this->trans(
                    'orderFilter_phone field must be a phone',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            } else {
                $orderFilter_phone = Tools::getValue('orderFilter_phone');
            }
        } else {
            $orderFilter_phone = false;
        }

        if ((bool) Tools::isSubmit('orderFilter_email') && Tools::getValue('orderFilter_email') != '') {
            if (Validate::isEmail(Tools::getValue('orderFilter_email')) != true) {
                $msg .= $this->displayError($this->trans(
                    'orderFilter_email field must be a email',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            } else {
                $orderFilter_email = Tools::getValue('orderFilter_email');
            }
        } else {
            $orderFilter_email = false;
        }

        if ((bool) Tools::isSubmit('orderFilter_carrierName') && Tools::getValue('orderFilter_carrierName') != '') {
            if (Validate::isString(Tools::getValue('orderFilter_carrierName')) != true) {
                $msg .= $this->displayError($this->trans(
                    'orderFilter_carrierName field must be a string',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            } else {
                $orderFilter_carrierName = Tools::getValue('orderFilter_carrierName');
            }
        } else {
            $orderFilter_carrierName = false;
        }

        $token = Tools::getAdminTokenLite('AdminOrders');
        $idLang = Context::getContext()->language->id;
        $statuses = DS::sqlStateByLang($idLang);
        $countries = DS::sqlGetAllCountryByLang($idLang);
        $orders = DS::sqlDisplayOrders(
            $orderFilter_id_order,
            $orderFilter_reference,
            $orderFilter_total_paid_tax_incl,
            $orderFilter_payment,
            $date_addA,
            $date_addB,
            $orderFilter_country,
            $id_order_state,
            $orderFilter_customer,
            $orderFilter_new,
            $orderFilter_carrierName,
            $orderFilter_email,
            $orderFilter_phone,
            $date_addC,
            $date_addD,
            $orderBy,
            $orderway
        );

        $currencies = DS::sqlGetAllCurrency();
        $numberOfOrders = DS::sqlCountOrders();

        $this->context->controller->addJqueryUI('ui.datepicker');
        $this->context->smarty->assign('orders', $orders);
        $this->context->smarty->assign('currencies', $currencies);
        $this->context->smarty->assign('token', $token);
        $this->context->smarty->assign('countries', $countries);
        $this->context->smarty->assign('statuses', $statuses);
        $this->context->smarty->assign('module_dir', $this->_path);
        $this->context->smarty->assign('link', $this->context->link);
        $this->context->smarty->assign('namemodules', $this->name);
        $this->context->smarty->assign('filters', array(
            'id_order_state' => $id_order_state,
            'orderFilter_customer' => $orderFilter_customer,
            'orderFilter_country' => $orderFilter_country,
            'orderFilter_reference' => $orderFilter_reference,
            'orderFilter_id_order' => $orderFilter_id_order,
            'orderFilter_new' => $orderFilter_new,
            'orderFilter_payment' => $orderFilter_payment,
            'date_addA' => $date_addA,
            'date_addB' => $date_addB,
            'date_addC' => $date_addC,
            'date_addD' => $date_addD,
            'orderFilter_phone' => $orderFilter_phone,
            'orderFilter_email' => $orderFilter_email,
            'orderFilter_carrierName' => $orderFilter_carrierName,
            'orderFilter_total_paid_tax_incl' => $orderFilter_total_paid_tax_incl,
        ));
        $this->context->smarty->assign('numberOfOrders', $numberOfOrders);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/delivery_orders.tpl');

        return $msg.$output;
    }

    /**
     * Get days of week.
     */
    protected function getDaysOfWeek()
    {
        $days = array();
        $monday = $this->l('Monday');
        $tuesday = $this->l('Tuesday');
        $wednesday = $this->l('Wednesday');
        $thursday = $this->l('Thursday');
        $friday = $this->l('Friday');
        $saturday = $this->l('Saturday');
        $sunday = $this->l('Sunday');

        $days = array(
            array('day' => $monday, 'id' => 1),
            array('day' => $tuesday, 'id' => 2),
            array('day' => $wednesday, 'id' => 3),
            array('day' => $thursday, 'id' => 4),
            array('day' => $friday, 'id' => 5),
            array('day' => $saturday, 'id' => 6),
            array('day' => $sunday, 'id' => 7),
        );

        return $days;
    }

    protected function getExternalCostForCarrier($orderId)
    {
        $externalPrice = DS::sqlCarrierCost($orderId);

        return $externalPrice;
    }

    public function getOrderShippingCost($params, $shipping_cost)
    {
        if (Tools::isEmpty($params)) {
            return false;
        }

        if ((bool) Tools::isSubmit('dscarrier')) {
            $orderId = Tools::getValue('dscarrier');
        } else {
            $orderId = 0;
        }

        $extraPrice = $this->getExternalCostForCarrier($orderId);

        if (Context::getContext()->customer->logged == true) {
            /*
             * Send the details through the API
             * Return the price sent by the API
             */
            return (float) $shipping_cost + (float) $extraPrice;
        }

        return (float) $shipping_cost + (float) $extraPrice;
    }

    public function getOrderShippingCostExternal($params)
    {
        if (Tools::isEmpty($params)) {
            return false;
        } else {
            return true;
        }
    }

    protected function addCarrier()
    {
        $carrier = new Carrier();

        $carrier->name = $this->l('Shipping to your home');
        $carrier->is_module = true;
        $carrier->active = 1;
        $carrier->range_behavior = 1;
        $carrier->need_range = 1;
        $carrier->shipping_external = true;
        $carrier->range_behavior = 0;
        $carrier->external_module_name = $this->name;
        $carrier->shipping_method = 2;

        foreach (Language::getLanguages() as $lang) {
            $carrier->delay[$lang['id_lang']] = $this->l('Shipping to your home');
        }

        if ($carrier->add() == true) {
            @copy(dirname(__FILE__).'/views/img/carrier_image.jpg', _PS_SHIP_IMG_DIR_.'/'.(int) $carrier->id.'.jpg');
            Configuration::updateValue('DSDELIVERYHOURS_CARRIER_ID', (int) $carrier->id);

            return $carrier;
        }

        return false;
    }

    protected function addGroups($carrier)
    {
        $groups_ids = array();
        $groups = Group::getGroups(Context::getContext()->language->id);
        foreach ($groups as $group) {
            $groups_ids[] = $group['id_group'];
        }

        $carrier->setGroups($groups_ids);
    }

    protected function addRanges($carrier)
    {
        $range_price = new RangePrice();
        $range_price->id_carrier = $carrier->id;
        $range_price->delimiter1 = '0';
        $range_price->delimiter2 = '10000';
        $range_price->add();

        $range_weight = new RangeWeight();
        $range_weight->id_carrier = $carrier->id;
        $range_weight->delimiter1 = '0';
        $range_weight->delimiter2 = '10000';
        $range_weight->add();
    }

    protected function addZones($carrier)
    {
        $zones = Zone::getZones();

        foreach ($zones as $zone) {
            $carrier->addZone($zone['id_zone']);
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be loaded in the BO.
     */
    public function hookBackOfficeHeader()
    {
        if (Tools::isSubmit('configure')) {
            $ourModule = Tools::getValue('configure');
        }

        if ($ourModule == 'dsdeliveryhours') {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $controller = Tools::getValue('controller');

        if ($controller == 'order') {
            $this->context->controller->addJS($this->_path.'/views/js/front.js');
            $this->context->controller->addCSS($this->_path.'/views/css/front.css');
        }
    }

    public function hookUpdateCarrier($params)
    {
        /*
         * Not needed since 1.5
         * You can identify the carrier by the id_reference
        */
    }

    public function hookActionOrderStatusPostUpdate($params)
    {
        $orderID = $params['id_order'];
        $idCarrier = Configuration::get('DSDELIVERYHOURS_CARRIER_ID');
        $orderCarrier = DS::sqlCarrierByOrderID($orderID);        

        if ($idCarrier == $orderCarrier) {
            $status = $params['newOrderStatus']->id;
            $orderData = DS::sqlOrderByID($orderID);
            $clientDataForCustomer = DS::sqlGetCustomerByOrderIDCustomerLang($orderID);
            $defaultLang = Configuration::get('PS_LANG_DEFAULT');
            $clientDataForEmploye = DS::sqlGetCustomerByOrderIDOfficeLang($orderID, $defaultLang);
            $adminNotifyStatus = Configuration::get('DSDELIVERYHOURS_REMINDERTEAM_STATUS');
            $deliverNotifyStatus = Configuration::get('DSDELIVERYHOURS_REMINDERSUPPLIER_STATUS');
            $customerNotifyStatus = Configuration::get('DSDELIVERYHOURS_REMINDERCUSTOMER_STATUS');
            $adminNotifySend = Configuration::get('DSDELIVERYHOURS_EXTRAORDERS');
            $supplierNotifySend = Configuration::get('DSDELIVERYHOURS_EXTRASUPPLIER');
            $customerNotifySend = Configuration::get('DSDELIVERYHOURS_EXTRACUSTOMER');
            $version = DS::versionValidation();
            $template_path = $this->local_path.'mails/';

            if ($status == $adminNotifyStatus && $adminNotifySend == 0) {
                $subject = $this->l('New order has benn placed');
                $to = Configuration::get('PS_SHOP_EMAIL');
                $langID = $defaultLang;
                $orderProducts = DS::getOrderData($orderID, $langID);
                $orderSubData = DS::getOrderDataGlobal($orderID, $langID);
                $content = '';
                foreach ($orderProducts as $product) {
                    $content .= '<tr>';
                    $content .= '<td bgcolor="#f8f8f8" style="border:1px solid #D6D4D4;background-color: #fbfbfb;color: #333;font-family: Arial;font-size: 13px;padding: 10px;">
                        '.$product["product_reference"].'
                    </td>
                    <td bgcolor="#f8f8f8" style="border:1px solid #D6D4D4;background-color: #fbfbfb;color: #333;font-family: Arial;font-size: 13px;padding: 10px;">
                        '.$product["product_name"].'
                    </td>
                    <td bgcolor="#f8f8f8" style="border:1px solid #D6D4D4;background-color: #fbfbfb;color: #333;font-family: Arial;font-size: 13px;padding: 10px;">
                        '.Tools::displayPrice($product["unit_price_tax_incl"], $orderSubData['id_currency']).'
                    </td>
                    <td bgcolor="#f8f8f8" style="border:1px solid #D6D4D4;background-color: #fbfbfb;color: #333;font-family: Arial;font-size: 13px;padding: 10px;">
                        '.$product["product_quantity"].'
                    </td>
                    <td bgcolor="#f8f8f8" style="border:1px solid #D6D4D4;background-color: #fbfbfb;color: #333;font-family: Arial;font-size: 13px;padding: 10px;">
                        '.Tools::displayPrice($product["total_price_tax_incl"], $orderSubData['id_currency']).'
                    </td>';
                    $content .= '</tr>';
                }

                $array = array(                
                    "{id_order}" => $orderData[0]['id_order'],
                    "{order_name}" => $orderData[0]['reference'],
                    "{total_paid_tax_incl}" => Tools::displayPrice($orderData[0]['total_paid_tax_incl'], $orderSubData['id_currency']),
                    "{payment}" => $orderData[0]['payment'],
                    "{date}" => $orderData[0]['date_add'],
                    "{currency}" => $orderData[0]['currency'],
                    "{id_pdf}" => $orderData[0]['id_pdf'],
                    "{customer}" => $orderData[0]['customer'],
                    "{osname}" => $orderData[0]['osname'],
                    "{color}" => $orderData[0]['color'],
                    "{new}" => $orderData[0]['new'],
                    "{cname}" => $orderData[0]['cname'],
                    "{badge_success}" => $orderData[0]['badge_success'],
                    "{shop_name}" => $orderData[0]['shop_name'],
                    "{shipper_name}" => $orderData[0]['shipper_name'],
                    "{shipper_email}" => $orderData[0]['shipper_email'],
                    "{shipper_phone}" => $orderData[0]['shipper_phone'],
                    "{shipper_cost}" => $orderData[0]['shipper_cost'],
                    "{event_hour_start}" => $orderData[0]['event_hour_start'],
                    "{event_hour_stop}" => $orderData[0]['event_hour_stop'],
                    "{event_date}" => $orderData[0]['event_date'],
                    "{firstname}" => $clientDataForEmploye['firstname'],
                    "{lastname}" => $clientDataForEmploye['lastname'],
                    "{email}" => $clientDataForEmploye['email'],
                    "{d_company}" => $clientDataForEmploye['d_company'],
                    "{d_address1}" => $clientDataForEmploye['d_address1'],
                    "{d_address2}" => $clientDataForEmploye['d_address2'],
                    "{d_postcode}" => $clientDataForEmploye['d_postcode'],
                    "{d_city}" => $clientDataForEmploye['d_city'],
                    "{d_country}" => $clientDataForEmploye['d_country'],
                    "{d_phone}" => $clientDataForEmploye['d_phone'],
                    "{d_phone_mobile}" => $clientDataForEmploye['d_phone_mobile'],
                    "{i_company}" => $clientDataForEmploye['i_company'],
                    "{i_address1}" => $clientDataForEmploye['i_address1'],
                    "{i_address2}" => $clientDataForEmploye['i_address2'],
                    "{i_postcode}" => $clientDataForEmploye['i_postcode'],
                    "{i_city}" => $clientDataForEmploye['i_city'],
                    "{i_country}" => $clientDataForEmploye['i_country'],
                    "{i_phone}" => $clientDataForEmploye['i_phone'],
                    "{i_phone_mobile}" => $clientDataForEmploye['i_phone_mobile'],                    
                    '{products}' => $content,
                    '{total_tax_paid}' => $orderSubData[0]['sum_tax']
                );
                $template = 'admin176';


                $this->sendMail($langID, $subject, $array, $to, $template, $template_path);
            }

            if ($status == $deliverNotifyStatus && $supplierNotifySend == 0) {
                $subject = $this->l('The date of delivery of the order is approaching.');
                $to = DS::sqlShipperMailByOrderID($orderID);

                

                $array = array(                    
                    "{id_order}" => $orderData[0]['id_order'],
                    "{reference}" => $orderData[0]['reference'],
                    "{total_paid_tax_incl}" => $orderData[0]['total_paid_tax_incl'],
                    "{payment}" => $orderData[0]['payment'],
                    "{date_add}" => $orderData[0]['date_add'],
                    "{currency}" => $orderData[0]['currency'],
                    "{id_pdf}" => $orderData[0]['id_pdf'],
                    "{customer}" => $orderData[0]['customer'],
                    "{osname}" => $orderData[0]['osname'],
                    "{color}" => $orderData[0]['color'],
                    "{new}" => $orderData[0]['new'],
                    "{cname}" => $orderData[0]['cname'],
                    "{badge_success}" => $orderData[0]['badge_success'],
                    "{shop_name}" => $orderData[0]['shop_name'],
                    "{shipper_name}" => $orderData[0]['shipper_name'],
                    "{shipper_email}" => $orderData[0]['shipper_email'],
                    "{shipper_phone}" => $orderData[0]['shipper_phone'],
                    "{shipper_cost}" => $orderData[0]['shipper_cost'],
                    "{event_hour_start}" => $orderData[0]['event_hour_start'],
                    "{event_hour_stop}" => $orderData[0]['event_hour_stop'],
                    "{event_date}" => $orderData[0]['event_date'],
                    "{firstname}" => $clientDataForEmploye['firstname'],
                    "{lastname}" => $clientDataForEmploye['lastname'],
                    "{email}" => $clientDataForEmploye['email'],
                    "{d_company}" => $clientDataForEmploye['d_company'],
                    "{d_address1}" => $clientDataForEmploye['d_address1'],
                    "{d_address2}" => $clientDataForEmploye['d_address2'],
                    "{d_postcode}" => $clientDataForEmploye['d_postcode'],
                    "{d_city}" => $clientDataForEmploye['d_city'],
                    "{d_country}" => $clientDataForEmploye['d_country'],
                    "{d_phone}" => $clientDataForEmploye['d_phone'],
                    "{d_phone_mobile}" => $clientDataForEmploye['d_phone_mobile'],
                    "{i_company}" => $clientDataForEmploye['i_company'],
                    "{i_address1}" => $clientDataForEmploye['i_address1'],
                    "{i_address2}" => $clientDataForEmploye['i_address2'],
                    "{i_postcode}" => $clientDataForEmploye['i_postcode'],
                    "{i_city}" => $clientDataForEmploye['i_city'],
                    "{i_country}" => $clientDataForEmploye['i_country'],
                    "{i_phone}" => $clientDataForEmploye['i_phone'],
                    "{i_phone_mobile}" => $clientDataForEmploye['i_phone_mobile'],
                );

                if ($to == false) {
                    $to = Configuration::get('PS_SHOP_EMAIL');
                }

                $langID = $defaultLang;

                if ($version == 1) {
                    $template = 'shipper16';
                } elseif ($version == 2) {
                    $template = 'shipper17';
                } elseif ($version == 3) {
                    $template = 'shipper176';
                }

                $this->sendMail($langID, $subject, $array, $to, $template, $template_path);
            }

            if ($status == $customerNotifyStatus && $customerNotifySend == 0) {
                $subject = $this->l('Your order is on the way.');
                $to = $clientDataForCustomer['email'];
                $langID = DS::sqlGetLangByOrderID($orderID);
                $orderProducts = DS::getOrderData($orderID, $langID);

                $array = array(
                    "{id_order}" => $orderData[0]['id_order'],
                    "{reference}" => $orderData[0]['reference'],
                    "{total_paid_tax_incl}" => $orderData[0]['total_paid_tax_incl'],
                    "{payment}" => $orderData[0]['payment'],
                    "{date_add}" => $orderData[0]['date_add'],
                    "{currency}" => $orderData[0]['currency'],
                    "{id_pdf}" => $orderData[0]['id_pdf'],
                    "{customer}" => $orderData[0]['customer'],
                    "{osname}" => $orderData[0]['osname'],
                    "{color}" => $orderData[0]['color'],
                    "{new}" => $orderData[0]['new'],
                    "{cname}" => $orderData[0]['cname'],
                    "{badge_success}" => $orderData[0]['badge_success'],
                    "{shop_name}" => $orderData[0]['shop_name'],
                    "{shipper_name}" => $orderData[0]['shipper_name'],
                    "{shipper_email}" => $orderData[0]['shipper_email'],
                    "{shipper_phone}" => $orderData[0]['shipper_phone'],
                    "{shipper_cost}" => $orderData[0]['shipper_cost'],
                    "{event_hour_start}" => $orderData[0]['event_hour_start'],
                    "{event_hour_stop}" => $orderData[0]['event_hour_stop'],
                    "{event_date}" => $orderData[0]['event_date'],
                    "{firstname}" => $clientDataForCustomer['firstname'],
                    "{lastname}" => $clientDataForCustomer['lastname'],
                    "{email}" => $clientDataForCustomer['email'],
                    "{d_company}" => $clientDataForCustomer['d_company'],
                    "{d_address1}" => $clientDataForCustomer['d_address1'],
                    "{d_address2}" => $clientDataForCustomer['d_address2'],
                    "{d_postcode}" => $clientDataForCustomer['d_postcode'],
                    "{d_city}" => $clientDataForCustomer['d_city'],
                    "{d_country}" => $clientDataForCustomer['d_country'],
                    "{d_phone}" => $clientDataForCustomer['d_phone'],
                    "{d_phone_mobile}" => $clientDataForCustomer['d_phone_mobile'],
                    "{i_company}" => $clientDataForCustomer['i_company'],
                    "{i_address1}" => $clientDataForCustomer['i_address1'],
                    "{i_address2}" => $clientDataForCustomer['i_address2'],
                    "{i_postcode}" => $clientDataForCustomer['i_postcode'],
                    "{i_city}" => $clientDataForCustomer['i_city'],
                    "{i_country}" => $clientDataForCustomer['i_country'],
                    "{i_phone}" => $clientDataForCustomer['i_phone'],
                    "{i_phone_mobile}" => $clientDataForCustomer['i_phone_mobile'],
                    '{ordersProduct}' => $orderProducts,
                );

                if ($version == 1) {
                    $template = 'customer16';
                } elseif ($version == 2) {
                    $template = 'customer17';
                } elseif ($version == 3) {
                    $template = 'customer176';
                }

                $this->sendMail($langID, $subject, $array, $to, $template, $template_path);
            }
        }
    }

    protected function sendMail($langID, $subject, $array, $to, $template, $template_path)
    {
        $mode_smtp = 1;
        $die = false;
        $idShop = null;
        $bcc = null;
        $replyTo = null;
        $replyToName = null;

        Mail::send(
            $langID,
            $template,
            pSQL($subject),
            $array,
            pSQL($to),
            null,
            null,
            null,
            null,
            $mode_smtp,
            $template_path,
            $die,
            $idShop,
            $bcc,
            $replyTo,
            $replyToName
        );
    }

    public function hookDisplayCarrierExtraContent()
    {
        $actualDays = DS::sqlGetAllDays();
        $actualIntervals = DS::sqlGetFrontIntervals();
        $actualOrders = DS::sqlGetAllOrders();
        $daysOfWeek = $this->getDaysOfWeek();

        $this->context->smarty->assign('actualDays', $actualDays);
        $this->context->smarty->assign('actualIntervals', $actualIntervals);
        $this->context->smarty->assign('actualOrders', $actualOrders);
        $this->context->smarty->assign('daysOfWeek', $daysOfWeek);
        $output = $this->context->smarty->fetch($this->local_path.'views/templates/front/sendtable.tpl');

        return $output;
    }

    public function hookActionCarrierProcess($params)
    {
        $this->ajax = true;
        $CarrierIDour = (int) Configuration::get('DSDELIVERYHOURS_CARRIER_ID');
        $carrierIDnow = (int) Context::getContext()->cart->id_carrier;
        $cartID = (int) Context::getContext()->cart->id;

        DS::sqlDayEngine();
        DS::sqlMainEngine();

        if ($CarrierIDour == $carrierIDnow) {
            if (Tools::isSubmit('dscarrier')) {
                $carrierID = Tools::getValue('dscarrier');

                DS::sqlAddEvent($cartID, $carrierID);
            }
        }
    }

    public function hookActionValidateOrder($params)
    {
        $this->ajax = true;
        $CarrierIDour = (int) Configuration::get('DSDELIVERYHOURS_CARRIER_ID');
        $carrierIDnow = (int) Context::getContext()->cart->id_carrier;
        $cartID = (int) Context::getContext()->cart->id;

        if ($CarrierIDour != $carrierIDnow) {
            DS::sqlRemoveEvent($cartID);
        } else {
            DS::sqlRemoveUsed($cartID);
        }
    }

    public static function removeCarriers()
    {
        $idReference = Configuration::get('DSDELIVERYHOURS_CARRIER_ID');

        static::deleteZoneCarrier($idReference);
        static::deleteGroupsCarrier($idReference);
        static::deleteDeliveryCarrier($idReference);
        static::deletePriceMethod($idReference);

        $upsShippingCarrier = Carrier::getCarrierByReference($idReference);
        if ($upsShippingCarrier !== false && $upsShippingCarrier->name != null) {
            $upsShippingCarrier->delete();
        }
    }

    private static function deleteZoneCarrier($idCarrier)
    {
        $carrier = new Carrier($idCarrier);

        $zones = Zone::getZones(true);
        foreach ($zones as $z) {
            $carrier->deleteZone($z['id_zone']);
        }
    }

    private static function deleteGroupsCarrier($idCarrier)
    {
        $groups = Group::getGroups(true);
        foreach ($groups as $group) {
            $where = 'id_carrier = '.(int) $idCarrier.
                    ' AND id_group = '.(int) $group['id_group'];

            Db::getInstance()->delete('carrier_group', $where);
        }
    }

    private static function deleteDeliveryCarrier($idCarrier)
    {
        $carrier = new Carrier($idCarrier);
        $carrier->deleteDeliveryPrice('range_weight');
        $carrier->deleteDeliveryPrice('range_price');
    }

    private static function deletePriceMethod($idCarriers)
    {
        $where = '`id_carrier` = '.(int) $idCarriers;

        Db::getInstance()->delete('range_weight', $where);
        Db::getInstance()->delete('range_price', $where);
    }
}

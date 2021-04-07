<?php
/**
* 2007-2016 PrestaShop.
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
*  @copyright 2007-2016 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class DS
{
    public static $module = false;

    public static function init($module)
    {
        if (self::$module == false) {
            self::$module = $module;
        }

        return self::$module;
    }

    /**
     * Autoinsert SQL.
     */
    public static function sqlClearAfterMainConfig()
    {
        if (Db::getInstance()->delete('ds_deliveryhoursdays')) {
            $msg = (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'Previous Main Settings: days - delete success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            $msg = (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'Previous Main Settings: days - delete fail.',
                array(),
                'Admin.Dsdeliveryhours.Fail'
            ));
        }

        if (Db::getInstance()->delete('ds_deliveryhoursinterval')) {
            $msg = (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'Previous Main Settings: hours - delete success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            $msg = (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'Previous Main Settings: hours - delete fail.',
                array(),
                'Admin.Dsdeliveryhours.Fail'
            ));
        }

        if (Db::getInstance()->delete('ds_deliveryhoursrules')) {
            $msg = (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'Previous Scheduling - delete success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            $msg = (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'Previous Scheduling - delete fail.',
                array(),
                'Admin.Dsdeliveryhours.Fail'
            ));
        }

        if (Db::getInstance()->delete('ds_deliveryhoursorders')) {
            $msg = (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'Previous Main Settings: max orders - delete success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            $msg = (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'Previous Main Settings: max orders - delete fail.',
                array(),
                'Admin.Dsdeliveryhours.Fail'
            ));
        }

        if (Db::getInstance()->delete('ds_deliveryhoursused')) {
            $msg = (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'Previous Main Settings: available orders - delete success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            $msg = (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'Previous Main Settings: available orders - delete fail.',
                array(),
                'Admin.Dsdeliveryhours.Fail'
            ));
        }

        return $msg;
    }

    public static function sqlAddIntervals()
    {
        $sql = new DbQuery();
        $sql->select('main_hour_start');
        $sql->from('ds_deliveryhours', 'dh');
        $start = Db::getInstance()->getValue($sql);

        $sql = new DbQuery();
        $sql->select('main_interval');
        $sql->from('ds_deliveryhours', 'dh');
        $interval = Db::getInstance()->getValue($sql);

        $sql = new DbQuery();
        $sql->select('main_hour_stop');
        $sql->from('ds_deliveryhours', 'dh');
        $stop = Db::getInstance()->getValue($sql);

        $startT = strtotime($start);
        $intervalT = strtotime($interval);
        $stopT = strtotime($stop);
        $validatorT = strtotime('00:00:00');

        $intervalTimeT = $startT + $intervalT - $validatorT;

        if (Db::getInstance()->delete('ds_deliveryhoursinterval')) {
            $msg = (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'Interval - delete success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            $msg = (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'Interval - delete fail.',
                array(),
                'Admin.Dsdeliveryhours.Fail'
            ));
        }

        if (Db::getInstance()->insert('ds_deliveryhoursinterval', array('interval_time' => pSQL($start)))) {
            $msg = (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'First interval - insert success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            $msg = (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'First interval - insert fail.',
                array(),
                'Admin.Dsdeliveryhours.Fail'
            ));
        }

        while ($intervalTimeT <= $stopT) {
            $intervalTime = date('H:i:s', $intervalTimeT);

            if (Db::getInstance()->insert('ds_deliveryhoursinterval', array(
                'interval_time' => pSQL($intervalTime),
            ))) {
                $msg = (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                    'Interval - generation success.',
                    array(),
                    'Admin.Dsdeliveryhours.Success'
                ));
            } else {
                $msg = (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                    'Interval - generation fail.',
                    array(),
                    'Admin.Dsdeliveryhours.Error'
                ));
            }

            $intervalTimeT = $intervalTimeT + $intervalT - $validatorT;
        }

        return $msg;
    }

    public static function sqlAddDays()
    {
        $sql = new DbQuery();
        $sql->select('main_day_delay');
        $sql->from('ds_deliveryhours', 'dh');
        $delay = Db::getInstance()->getValue($sql);

        $sql = new DbQuery();
        $sql->select('main_day_limit');
        $sql->from('ds_deliveryhours', 'dh');
        $limit = Db::getInstance()->getValue($sql);

        $realLimit = $delay + $limit;

        if (Db::getInstance()->delete('ds_deliveryhoursdays')) {
            $msg = (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'Days - delete success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            $msg = (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'Days - delete fail.',
                array(),
                'Admin.Dsdeliveryhours.Fail'
            ));
        }

        for ($days = $delay; $days <= $realLimit; ++$days) {
            $dayDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + $days, date('Y')));

            $dayWeek = date('N', mktime(0, 0, 0, date('m'), date('d') + $days, date('Y')));

            if (Db::getInstance()->insert('ds_deliveryhoursdays', array(
                'days_date' => pSQL($dayDate),
                'days_week' => (int) $dayWeek,
            ))) {
                $msg = (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                    'Days - insert success.',
                    array(),
                    'Admin.Dsdeliveryhours.Success'
                ));
            } else {
                $msg = (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                    'Days - insert fail.',
                    array(),
                    'Admin.Dsdeliveryhours.Fail'
                ));
            }
        }

        return $msg;
    }

    public static function sqlAddOrders()
    {
        $sql = new DbQuery();
        $sql->select('id_deliveryhoursdays');
        $sql->from('ds_deliveryhoursdays', 'dhd');
        $sql->orderBy('id_deliveryhoursdays');
        $id_deliveryhoursdays = Db::getInstance()->ExecuteS($sql);

        $sql = '
        SELECT id_deliveryhoursinterval 
        FROM '._DB_PREFIX_.'ds_deliveryhoursinterval 
        WHERE id_deliveryhoursinterval < (
            SELECT MAX(id_deliveryhoursinterval) FROM '._DB_PREFIX_.'ds_deliveryhoursinterval
            ) 
        ORDER BY id_deliveryhoursinterval';
        $id_deliveryhoursinterval = Db::getInstance()->ExecuteS($sql);

        $sql = new DbQuery();
        $sql->select('main_order_number');
        $sql->from('ds_deliveryhours', 'dh');
        $orderNumber = Db::getInstance()->getValue($sql);

        foreach ($id_deliveryhoursdays as $days) {
            $daysI = (int) ($days['id_deliveryhoursdays']);
            foreach ($id_deliveryhoursinterval as $interval) {
                $intervalI = (int) ($interval['id_deliveryhoursinterval']);
                if (Db::getInstance()->insert(
                    'ds_deliveryhoursorders',
                    array(
                        array(
                            'id_deliveryhoursdays' => (int) $daysI,
                            'id_deliveryhoursinterval' => (int) $intervalI,
                            'id_deliveryhoursshipper' => 1,
                            'orders_number' => (int) $orderNumber,
                        ),
                    )
                ) == false) {
                    $msg = (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                        'Max orders - insert fail.',
                        array(),
                        'Admin.Dsdeliveryhours.Fail'
                    ));
                } else {
                    $msg = (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                        'Max orders - insert success.',
                        array(),
                        'Admin.Dsdeliveryhours.Success'
                    ));

                    $lastInsert = Db::getInstance()->Insert_ID();

                    if (Db::getInstance()->insert(
                        'ds_deliveryhoursused',
                        array(
                            array(
                                'id_deliveryhoursdays' => (int) $daysI,
                                'id_deliveryhoursorders' => (int) $lastInsert,
                                'id_deliveryhoursinterval' => (int) $intervalI,
                                'orders_number' => 0,
                            ),
                        )
                    ) == false) {
                        $msg = (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                            'Available orders - insert fail.',
                            array(),
                            'Admin.Dsdeliveryhours.Fail'
                        ));
                    } else {
                        $msg = (new Dsdeliveryhours())->displayConfirmation(
                            Context::getContext()->getTranslator()->trans(
                                'Available orders - insert success.',
                                array(),
                                'Admin.Dsdeliveryhours.Success'
                            )
                        );
                    }
                }
            }
        }

        return $msg;
    }

    /**
     * Configuration.
     */
    public static function sqlGetMainSettings()
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('ds_deliveryhours', 'dh');
        $result = Db::getInstance()->getRow($sql);

        return $result;
    }

    public static function sqlUpdateMainSettings(
        $mainHourStart,
        $mainHourStop,
        $mainInterval,
        $mainDayDelay,
        $mainDayLimit,
        $mainOrderNumber
    ) {
        if (Db::getInstance()->update(
            'ds_deliveryhours',
            array(
                'main_hour_start' => pSQL($mainHourStart),
                'main_hour_stop' => pSQL($mainHourStop),
                'main_interval' => pSQL($mainInterval),
                'main_day_delay' => (int) $mainDayDelay,
                'main_day_limit' => (int) $mainDayLimit,
                'main_order_number' => (int) $mainOrderNumber,
            )
        )) {
            return (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'Main Settings - update success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            return (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'Main Settings - update fail.',
                array(),
                'Admin.Dsdeliveryhours.Error'
            ));
        }
    }

    public static function sqlGetDefaultOrders()
    {
        $sql = new DbQuery();
        $sql->select('main_order_number');
        $sql->from('ds_deliveryhours', 'dh');
        $result = Db::getInstance()->getValue($sql);

        return $result;
    }

    /**
     * Intervals.
     */
    public static function sqlGetAllIntervals()
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('ds_deliveryhoursinterval', 'dhi');
        $sql->orderBy('id_deliveryhoursinterval');
        $result = Db::getInstance()->ExecuteS($sql);

        return $result;
    }

    /**
     * Days.
     */
    public static function sqlGetAllDays()
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('ds_deliveryhoursdays', 'dhd');
        $sql->orderBy('id_deliveryhoursdays');
        $result = Db::getInstance()->ExecuteS($sql);

        return $result;
    }

    public static function sqlGetFrontIntervals()
    {
        $sql = '
        SELECT A.id_deliveryhoursinterval, A.interval_time AS interval_time_start, B.interval_time AS interval_time_stop
        FROM '._DB_PREFIX_.'ds_deliveryhoursinterval AS A
        JOIN '._DB_PREFIX_.'ds_deliveryhoursinterval AS B
        ON A.id_deliveryhoursinterval +1 = B.id_deliveryhoursinterval';
        $result = Db::getInstance()->ExecuteS($sql);

        return $result;
    }

    /**
     * Orders.
     */
    public static function sqlGetAllOrders()
    {
        $sql = '
        SELECT *, 
        IF( A.orders_number > B.orders_number, 1, 0) AS ds_possible, A.orders_number - B.orders_number AS ds_quantity
        FROM '._DB_PREFIX_.'ds_deliveryhoursorders AS A
        JOIN '._DB_PREFIX_.'ds_deliveryhoursused AS B
        ON A.id_deliveryhoursorders = B.id_deliveryhoursorders
        ';
        $result = Db::getInstance()->ExecuteS($sql);

        return $result;
    }

    /**
     * Carries.
     */
    public static function sqlGetAllOurCarriers()
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('ds_deliveryhoursshipper', 'dhc');
        $sql->orderBy('id_deliveryhoursshipper');
        $result = Db::getInstance()->ExecuteS($sql);

        return $result;
    }

    public static function sqlGetOurCarrier($idDeliveryHoursCarrier)
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('ds_deliveryhoursshipper', 'dhc');
        $sql->where('dhc.id_deliveryhoursshipper = '.(int) $idDeliveryHoursCarrier);
        $result = Db::getInstance()->getRow($sql);

        return $result;
    }

    public static function sqlCarrierMail($idDeliveryHoursCarrier)
    {
        $sql = new DbQuery();
        $sql->select('shipper_email');
        $sql->from('ds_deliveryhoursshipper', 'dhc');
        $sql->where('id_deliveryhoursshipper = '.(int) $idDeliveryHoursCarrier);
        $result = Db::getInstance()->getValue($sql);

        return $result;
    }

    public static function sqlCarrierCost($idDeliveryHoursCarrier)
    {
        $sql = new DbQuery();
        $sql->select('shipper_cost');
        $sql->from('ds_deliveryhoursshipper', 'dhc');
        $sql->where('id_deliveryhoursshipper = '.(int) $idDeliveryHoursCarrier);

        $result = Db::getInstance()->getValue($sql);

        return $result;
    }

    public static function sqlAddOurCarrier(
        $carrierName,
        $carrierEmail,
        $carrierTel,
        $carrierDescription,
        $carrierAdress,
        $carrierVatNumber,
        $carrierCost
    ) {
        if (Db::getInstance()->insert(
            'ds_deliveryhoursshipper',
            array(
                'shipper_name' => pSQL($carrierName),
                'shipper_email' => pSQL($carrierEmail),
                'shipper_phone' => pSQL($carrierTel),
                'shipper_description' => pSQL($carrierDescription),
                'shipper_address' => pSQL($carrierAdress),
                'shipper_vat_number' => pSQL($carrierVatNumber),
                'shipper_cost' => (float) $carrierCost,
            )
        )) {
            return (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'New Shipper - addition success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            return (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'New Shipper - addition fail.',
                array(),
                'Admin.Dsdeliveryhours.Error'
            ));
        }
    }

    public static function sqlEditOurCarrier(
        $idDeliveryHoursCarrier,
        $carrierName,
        $carrierEmail,
        $carrierTel,
        $carrierDescription,
        $carrierAdress,
        $carrierVatNumber,
        $carrierCost
    ) {
        if (Db::getInstance()->update(
            'ds_deliveryhoursshipper',
            array(
                'shipper_name' => pSQL($carrierName),
                'shipper_email' => pSQL($carrierEmail),
                'shipper_phone' => pSQL($carrierTel),
                'shipper_description' => pSQL($carrierDescription),
                'shipper_address' => pSQL($carrierAdress),
                'shipper_vat_number' => pSQL($carrierVatNumber),
                'shipper_cost' => (float) $carrierCost,
            ),
            'id_deliveryhoursshipper = '.(int) $idDeliveryHoursCarrier
        )) {
            return (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'Shipper - update success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            return (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'Shipper - update fail.',
                array(),
                'Admin.Dsdeliveryhours.Error'
            ));
        }
    }

    public static function sqlDeleteCarrier($idDeliveryHoursCarrier)
    {
        if ((int) $idDeliveryHoursCarrier == 1) {
            return (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'You cannot remove default Shipper.',
                array(),
                'Admin.Dsdeliveryhours.Fail'
            ));
        }
        if (Db::getInstance()->delete(
            'ds_deliveryhoursshipper',
            'id_deliveryhoursshipper = '.(int) $idDeliveryHoursCarrier
        )) {
            return (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'Shipper - delete success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            return (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'Shipper - delete fail.',
                array(),
                'Admin.Dsdeliveryhours.Fail'
            ));
        }
    }

    /**
     * Schema.
     */
    public static function sqlGetAllDeliverySchedule()
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('ds_deliveryhoursrules', 'dhr');
        $sql->orderBy('id_deliveryhoursrules');
        $result = Db::getInstance()->ExecuteS($sql);

        return $result;
    }

    public static function getDeliveryDataSchedule($id_deliveryhoursrules)
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('ds_deliveryhoursrules', 'dhc');
        $sql->where('dhc.id_deliveryhoursrules = '.(int) $id_deliveryhoursrules);
        $result = Db::getInstance()->getRow($sql);

        return $result;
    }

    public static function sqlAddDeliverySchedule(
        $rulesDayID,
        $rulesStart,
        $rulesStop,
        $rulesIntervalStart,
        $rulesIntervalStop,
        $idDsDeliveryHoursCarrier,
        $rulesQuantity
    ) {
        if (Db::getInstance()->insert(
            'ds_deliveryhoursrules',
            array(
                'rules_day_ID' => (int) $rulesDayID,
                'rules_start' => pSQL($rulesStart),
                'rules_stop' => pSQL($rulesStop),
                'rules_interval_start' => (int) $rulesIntervalStart,
                'rules_interval_stop' => (int) $rulesIntervalStop,
                'id_deliveryhoursshipper' => (int) $idDsDeliveryHoursCarrier,
                'rules_quantity' => (int) $rulesQuantity,
            )
        )) {
            return (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'New Schedule - addition success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            return (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'New Schedule - addition fail.',
                array(),
                'Admin.Dsdeliveryhours.Error'
            ));
        }
    }

    public static function sqlEditDeliverySchedule(
        $idDeliveryHoursRules,
        $rulesDayId,
        $rulesStart,
        $rulesStop,
        $rulesIntervalStart,
        $rulesIntervalStop,
        $idDsDeliveryHoursCarrier,
        $rulesQuantity
    ) {
        if (Db::getInstance()->update(
            'ds_deliveryhoursrules',
            array(
                'rules_day_ID' => (int) $rulesDayId,
                'rules_start' => pSQL($rulesStart),
                'rules_stop' => pSQL($rulesStop),
                'rules_interval_start' => (int) $rulesIntervalStart,
                'rules_interval_stop' => (int) $rulesIntervalStop,
                'id_deliveryhoursshipper' => (int) $idDsDeliveryHoursCarrier,
                'rules_quantity' => (int) $rulesQuantity,
            ),
            'id_deliveryhoursrules = '.(int) $idDeliveryHoursRules
        )) {
            return (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'Schedule - update success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            return (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'Schedule - update fail.',
                array(),
                'Admin.Dsdeliveryhours.Fail'
            ));
        }
    }

    public static function sqlDeleteDeliverySchedule($idDeliveryHoursRules)
    {
        if (Db::getInstance()->delete(
            'ds_deliveryhoursrules',
            'id_deliveryhoursrules = '.(int) $idDeliveryHoursRules
        )) {
            return (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'Schedule - delete success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            return (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'Schedule - delete fail.',
                array(),
                'Admin.Dsdeliveryhours.Fail'
            ));
        }
    }

    /**
     * Events.
     */
    public static function sqlAddEvent($idCart, $idDeliveryHoursOrder)
    {
        $sql = new DbQuery();
        $sql->select('COUNT(*)');
        $sql->from('ds_deliveryhoursevents', 'dhc');
        $sql->where('dhc.id_cart = '.(int) $idCart);
        $ifCartExists = Db::getInstance()->getValue($sql);

        $sql = '
        SELECT B.interval_time AS event_hour_start, C.interval_time AS event_hour_stop, D.days_date AS event_date,
        E.shipper_name, E.shipper_email, E.shipper_phone, E.shipper_cost
        FROM '._DB_PREFIX_.'ds_deliveryhoursorders AS A
        JOIN '._DB_PREFIX_.'ds_deliveryhoursinterval AS B
        ON A.id_deliveryhoursinterval = B.id_deliveryhoursinterval
        JOIN '._DB_PREFIX_.'ds_deliveryhoursinterval AS C
        ON A.id_deliveryhoursinterval + 1 = C.id_deliveryhoursinterval
        JOIN '._DB_PREFIX_.'ds_deliveryhoursdays AS D
        ON A.id_deliveryhoursdays = D.id_deliveryhoursdays
        JOIN '._DB_PREFIX_.'ds_deliveryhoursshipper AS E
        ON A.id_deliveryhoursshipper = E.id_deliveryhoursshipper
        WHERE A.id_deliveryhoursorders = '.(int) $idDeliveryHoursOrder
        ;
        $fullEvent = Db::getInstance()->getRow($sql);

        if ($ifCartExists == 1) {
            if (Db::getInstance()->update(
                'ds_deliveryhoursevents',
                array(
                    'id_deliveryhoursorders' => (int) $idDeliveryHoursOrder,
                    'shipper_name' => pSQL($fullEvent['shipper_name']),
                    'shipper_email' => pSQL($fullEvent['shipper_email']),
                    'shipper_phone' => pSQL($fullEvent['shipper_phone']),
                    'shipper_cost' => pSQL($fullEvent['shipper_cost']),
                    'event_timestamp' => date('Y-m-d G:i:s'),
                    'event_hour_start' => pSQL($fullEvent['event_hour_start']),
                    'event_hour_stop' => pSQL($fullEvent['event_hour_stop']),
                    'event_date' => pSQL($fullEvent['event_date']),
                ),
                'id_cart = '.(int) $idCart
            )) {
                return (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                    'Delivery date changed.',
                    array(),
                    'Admin.Dsdeliveryhours.Success'
                ));
            } else {
                return (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                    'Delivery date change failed.',
                    array(),
                    'Admin.Dsdeliveryhours.Fail'
                ));
            }
        } else {
            if (Db::getInstance()->insert(
                'ds_deliveryhoursevents',
                array(
                    'id_cart' => (int) $idCart,
                    'id_deliveryhoursorders' => (int) $idDeliveryHoursOrder,
                    'shipper_name' => pSQL($fullEvent['shipper_name']),
                    'shipper_email' => pSQL($fullEvent['shipper_email']),
                    'shipper_phone' => pSQL($fullEvent['shipper_phone']),
                    'shipper_cost' => pSQL($fullEvent['shipper_cost']),
                    'event_timestamp' => date('Y-m-d G:i:s'),
                    'event_hour_start' => pSQL($fullEvent['event_hour_start']),
                    'event_hour_stop' => pSQL($fullEvent['event_hour_stop']),
                    'event_date' => pSQL($fullEvent['event_date']),
                )
            )) {
                return (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                    'Delivery date selected.',
                    array(),
                    'Admin.Dsdeliveryhours.Success'
                ));
            } else {
                return (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                    'Delivery date selection failed.',
                    array(),
                    'Admin.Dsdeliveryhours.Fail'
                ));
            }
        }
    }

    public static function sqlRemoveEvent($idCart)
    {
        if (Db::getInstance()->delete('ds_deliveryhoursevents', 'id_cart = '.(int) $idCart)) {
            return (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'Shipping method changed.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            return (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'Shipping method change failed.',
                array(),
                'Admin.Dsdeliveryhours.Fail'
            ));
        }
    }

    public static function sqlRemoveUsed($idCart)
    {
        $sql = new DbQuery();
        $sql->select('id_deliveryhoursorders');
        $sql->from('ds_deliveryhoursevents', 'dhc');
        $sql->where('dhc.id_cart = '.(int) $idCart);
        $idUsed = Db::getInstance()->getValue($sql);

        $sql = '
        UPDATE '._DB_PREFIX_.'ds_deliveryhoursused
        SET 
        orders_number = orders_number + 1
        WHERE
        id_deliveryhoursorders = '.(int) $idUsed
        ;

        if (Db::getInstance()->Execute($sql)) {
            return (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'Available orders - update success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            return (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'Available orders - update fail.',
                array(),
                'Admin.Dsdeliveryhours.Fail'
            ));
        }
    }

    /**
     * Main Engine.
     */
    public static function sqlMainEngine()
    {
        $sql = '
        UPDATE '._DB_PREFIX_.'ds_deliveryhoursorders AS O
        JOIN
        '._DB_PREFIX_.'ds_deliveryhoursdays AS D
        ON 
        O.id_deliveryhoursdays = D.id_deliveryhoursdays
        JOIN '._DB_PREFIX_.'ds_deliveryhoursrules AS R
        ON 
        R.rules_day_ID = D.days_week
        AND 
        D.days_date BETWEEN R.rules_start AND R.rules_stop
        AND
        O.id_deliveryhoursinterval BETWEEN R.rules_interval_start AND R.rules_interval_stop
        SET 
        O.id_deliveryhoursshipper = R.id_deliveryhoursshipper,
        orders_number = R.rules_quantity
        
        ';
        if (Db::getInstance()->Execute($sql)) {
            return (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'Max order and shipper - update success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            return (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'Max order and shipper - update fail.',
                array(),
                'Admin.Dsdeliveryhours.Fail'
            ));
        }
    }

    public static function sqlDayEngine()
    {
        $sql = '
        CREATE OR REPLACE VIEW '._DB_PREFIX_.'ds_view AS
        SELECT
        id_deliveryhoursdays 
        FROM
        '._DB_PREFIX_.'ds_deliveryhoursdays
        WHERE days_date < (SELECT CURDATE() + main_day_delay
        FROM '._DB_PREFIX_.'ds_deliveryhours)
        ';
        if (Db::getInstance()->Execute($sql)) {
            $msg = (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'Days template created.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            $msg = (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'Days template creation fail.',
                array(),
                'Admin.Dsdeliveryhours.Fail'
            ));
        }

        $sql = '
        DELETE 
        '._DB_PREFIX_.'ds_deliveryhoursdays, '._DB_PREFIX_.'ds_deliveryhoursused, '._DB_PREFIX_.'ds_deliveryhoursorders
        FROM
        '._DB_PREFIX_.'ds_deliveryhoursdays
        JOIN
        '._DB_PREFIX_.'ds_deliveryhoursused
        ON
        '._DB_PREFIX_.'ds_deliveryhoursdays.id_deliveryhoursdays 
        = '._DB_PREFIX_.'ds_deliveryhoursused.id_deliveryhoursdays
        JOIN
        '._DB_PREFIX_.'ds_deliveryhoursorders
        ON
        '._DB_PREFIX_.'ds_deliveryhoursorders.id_deliveryhoursdays 
        = '._DB_PREFIX_.'ds_deliveryhoursused.id_deliveryhoursdays
        JOIN 
        '._DB_PREFIX_.'ds_view
        ON
        '._DB_PREFIX_.'ds_view.id_deliveryhoursdays = '._DB_PREFIX_.'ds_deliveryhoursused.id_deliveryhoursdays
        ';
        if (Db::getInstance()->Execute($sql)) {
            $msg .= (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                'Past Days - delete success.',
                array(),
                'Admin.Dsdeliveryhours.Success'
            ));
        } else {
            $msg .= (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                'Past Days - delete fail.',
                array(),
                'Admin.Dsdeliveryhours.Fail'
            ));
        }

        $sql = new DbQuery();
        $sql->select('main_day_delay');
        $sql->from('ds_deliveryhours', 'dh');
        $delay = Db::getInstance()->getValue($sql);

        $sql = new DbQuery();
        $sql->select('main_day_limit');
        $sql->from('ds_deliveryhours', 'dh');
        $limit = Db::getInstance()->getValue($sql);

        $realLimit = $delay + $limit;

        $sql = new DbQuery();
        $sql->select('DATEDIFF(MAX(days_date), CURRENT_DATE) AS Datediff');
        $sql->from('ds_deliveryhoursdays', 'dhd');
        $last = (int) (Db::getInstance()->getValue($sql)) + 1;

        $sql = new DbQuery();
        $sql->select('main_order_number');
        $sql->from('ds_deliveryhours', 'dh');
        $orderNumber = Db::getInstance()->getValue($sql);

        $sql = '
        SELECT id_deliveryhoursinterval 
        FROM '._DB_PREFIX_.'ds_deliveryhoursinterval 
        WHERE id_deliveryhoursinterval < (
            SELECT MAX(id_deliveryhoursinterval) FROM '._DB_PREFIX_.'ds_deliveryhoursinterval
            ) 
        ORDER BY id_deliveryhoursinterval';
        $id_deliveryhoursinterval = Db::getInstance()->ExecuteS($sql);

        for ($days = $last; $days <= $realLimit; ++$days) {
            $dayDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + $days, date('Y')));

            $dayWeek = date('N', mktime(0, 0, 0, date('m'), date('d') + $days, date('Y')));

            if (Db::getInstance()->insert('ds_deliveryhoursdays', array(
                'days_date' => pSQL($dayDate),
                'days_week' => (int) $dayWeek,
            ))) {
                $msg = (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                    'New Days - insert success.',
                    array(),
                    'Admin.Dsdeliveryhours.Success'
                ));
            } else {
                $msg = (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                    'New Days - insert fail.',
                    array(),
                    'Admin.Dsdeliveryhours.Fail'
                ));
            }

            $lastInsert = Db::getInstance()->Insert_ID();

            foreach ($id_deliveryhoursinterval as $interval) {
                $intervalI = (int) ($interval['id_deliveryhoursinterval']);
                if (Db::getInstance()->insert(
                    'ds_deliveryhoursorders',
                    array(
                        array(
                            'id_deliveryhoursdays' => (int) $lastInsert,
                            'id_deliveryhoursinterval' => (int) $intervalI,
                            'id_deliveryhoursshipper' => 1,
                            'orders_number' => (int) $orderNumber,
                        ),
                    )
                ) == false) {
                    $msg = (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                        'Max orders: new days - additon fail.',
                        array(),
                        'Admin.Dsdeliveryhours.Fail'
                    ));
                } else {
                    $msg = (new Dsdeliveryhours())->displayConfirmation(Context::getContext()->getTranslator()->trans(
                        'Max orders: new days - additon success.',
                        array(),
                        'Admin.Dsdeliveryhours.Success'
                    ));

                    $lastInsertOrder = Db::getInstance()->Insert_ID();

                    if (Db::getInstance()->insert('ds_deliveryhoursused', array(
                        array(
                            'id_deliveryhoursdays' => (int) $lastInsert,
                            'id_deliveryhoursorders' => (int) $lastInsertOrder,
                            'id_deliveryhoursinterval' => (int) $intervalI,
                            'orders_number' => 0,
                        ),
                    )) == false) {
                        $msg = (new Dsdeliveryhours())->displayError(Context::getContext()->getTranslator()->trans(
                            'Available orders: new days - additon fail.',
                            array(),
                            'Admin.Dsdeliveryhours.Fail'
                        ));
                    } else {
                        $msg = (new Dsdeliveryhours())->displayConfirmation(
                            Context::getContext()->getTranslator()->trans(
                                'Available orders: new days - additon success.',
                                array(),
                                'Admin.Dsdeliveryhours.Success'
                            )
                        );
                    }
                }
            }
        }

        return $msg;
    }

    /**
     *Main Order.
     */
    public static function sqlDisplayOrders(
        $idOrder = false,
        $reference = false,
        $totalPaidTaxIncl = false,
        $payment = false,
        $dateAddFrom = false,
        $dateAddTo = false,
        $country = false,
        $orderState = false,
        $customer = false,
        $newCustomer = false,
        $carrierName = false,
        $carrierEmail = false,
        $carrierTel = false,
        $dateEventFrom = false,
        $dateEventTo = false,
        $orderField = 'id_order',
        $orderRef = 'asc'
    ) {
        if ($orderField === false) {
            $orderField = 'id_order';
        }

        if ($orderRef === false) {
            $orderRef = 'desc';
        }

        $orderFieldString = '"'.$orderField.'"';
        $orderRefString = '"'.$orderRef.'"';

        $orderString = $orderField.' '.$orderRef;

        if ($orderField == 'datedelivery' and $orderRef == 'asc') {
            $orderString = 'hours.event_date asc, hours.event_hour_start asc';
        }

        if ($orderField == 'datedelivery' and $orderRef == 'desc') {
            $orderString = 'hours.event_date desc, hours.event_hour_start desc';
        }

        if ($orderField == 'date' and $orderRef == 'asc') {
            $orderString = 'date_add asc';
        }

        if ($orderField == 'date' and $orderRef == 'desc') {
            $orderString = 'date_add desc';
        }

        if ($orderField == 'status' and $orderRef == 'asc') {
            $orderString = 'osname asc';
        }

        if ($orderField == 'status' and $orderRef == 'desc') {
            $orderString = 'osname desc';
        }

        $sql = new DbQuery();
        $sql->select(
            'SQL_CALC_FOUND_ROWS a.`id_order`,
            `reference`,
            `total_paid_tax_incl`,
            `payment`,
            a.`date_add` AS `date_add`'
        );
        $sql->select($orderFieldString.' AS orderField');
        $sql->select($orderRefString.' AS orderRef');
        $sql->select('a.id_currency');
        $sql->select('a.id_order AS id_pdf');
        $sql->select('CONCAT(LEFT(c.`firstname`, 1), ". ", c.`lastname`) AS `customer`');
        $sql->select('osl.`name` AS `osname`');
        $sql->select('os.`color`');
        $sql->select(
            'IF((SELECT so.id_order FROM `'._DB_PREFIX_.'orders` so 
            WHERE so.id_customer = a.id_customer AND so.id_order < a.id_order LIMIT 1) > 0, 0, 1) as new'
        );
        $sql->select('country_lang.name as cname');
        $sql->select('IF(a.valid, 1, 0) badge_success');
        $sql->select('shop.name as shop_name');
        $sql->select('hours.shipper_name as shipper_name');
        $sql->select('hours.shipper_email as shipper_email');
        $sql->select('hours.shipper_phone as shipper_phone');
        $sql->select('hours.shipper_cost as shipper_cost');
        $sql->select('hours.event_hour_start as event_hour_start');
        $sql->select('hours.event_hour_stop as event_hour_stop');
        $sql->select('hours.event_date as event_date');

        $sql->from('orders', 'a');

        $sql->leftJoin('customer', 'c', 'c.`id_customer` = a.`id_customer`');
        $sql->innerJoin('address', 'address', 'address.id_address = a.id_address_delivery');
        $sql->innerJoin('country', 'country', 'address.id_country = country.id_country');
        $sql->innerJoin(
            'country_lang',
            'country_lang',
            '(country.`id_country` = country_lang.`id_country` AND country_lang.`id_lang` = 1)'
        );
        $sql->leftJoin('order_state', 'os', '(os.`id_order_state` = a.`current_state`)');
        $sql->leftJoin(
            'order_state_lang',
            'osl',
            '(os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = 1)'
        );
        $sql->leftJoin('shop', 'shop', 'a.`id_shop` = shop.`id_shop`');
        $sql->leftJoin('ds_deliveryhoursevents', 'hours', 'a.`id_cart` = hours.`id_cart`');

        if (!($idOrder === false)) {
            $sql->where('a.`id_order` LIKE "%'.pSQL($idOrder).'%"');
        }

        if (!($reference === false)) {
            $sql->where('reference LIKE "%'.pSQL($reference).'%"');
        }

        if (!($totalPaidTaxIncl === false)) {
            $sql->where('total_paid_tax_incl = '.(int) $totalPaidTaxIncl);
        }

        if (!($payment === false)) {
            $sql->where('payment LIKE "%'.pSQL($payment).'%"');
        }

        if (!($dateAddFrom === false)) {
            $sql->where('a.`date_add` >= '.pSQL($dateAddFrom));
        }

        if (!($dateAddTo === false)) {
            $sql->where('a.`date_add` <= '.pSQL($dateAddTo));
        }

        if (!($country === false)) {
            $sql->where('country.`id_country` = '.(int) $country);
        }

        if (!($orderState === false)) {
            $sql->where('os.`id_order_state` = '.(int) $orderState);
        }

        if (!($customer === false)) {
            $sql->having('customer LIKE "%'.pSQL($customer).'%"');
        }

        if (!($newCustomer === false)) {
            $sql->having('new = '.(int) $newCustomer);
        }

        if (!($carrierName === false)) {
            $sql->where('shipper_name LIKE "%'.pSQL($carrierName).'%"');
        }

        if (!($carrierEmail === false)) {
            $sql->where('shipper_email LIKE "%'.pSQL($carrierEmail).'%"');
        }

        if (!($carrierTel === false)) {
            $sql->where('shipper_phone LIKE "%'.pSQL($carrierTel).'%"');
        }

        if (!($dateEventFrom === false)) {
            $sql->where('event_date >= '.pSQL($dateEventFrom));
        }

        if (!($dateEventTo === false)) {
            $sql->where('event_date <= '.pSQL($dateEventTo));
        }

        $sql->orderBy($orderString);

        return Db::getInstance()->ExecuteS($sql);
    }

    public static function sqlOrderByID($idOrder)
    {
        $sql = new DbQuery();
        $sql->select(
            'SQL_CALC_FOUND_ROWS a.`id_order`,
            `reference`,
            `total_paid_tax_incl`,
            `payment`,
            a.`date_add` AS `date_add`'
        );
        $sql->select('a.id_currency AS currency');
        $sql->select('a.id_order AS id_pdf');
        $sql->select('CONCAT(LEFT(c.`firstname`, 1), ". ", c.`lastname`) AS `customer`');
        $sql->select('osl.`name` AS `osname`');
        $sql->select('os.`color`');
        $sql->select(
            'IF((SELECT so.id_order FROM `'._DB_PREFIX_.'orders` so 
            WHERE so.id_customer = a.id_customer AND so.id_order < a.id_order LIMIT 1) > 0, 0, 1) as new'
        );
        $sql->select('country_lang.name as cname');
        $sql->select('IF(a.valid, 1, 0) badge_success');
        $sql->select('shop.name as shop_name');
        $sql->select('hours.shipper_name as shipper_name');
        $sql->select('hours.shipper_email as shipper_email');
        $sql->select('hours.shipper_phone as shipper_phone');
        $sql->select('hours.shipper_cost as shipper_cost');
        $sql->select('hours.event_hour_start as event_hour_start');
        $sql->select('hours.event_hour_stop as event_hour_stop');
        $sql->select('hours.event_date as event_date');

        $sql->from('orders', 'a');

        $sql->leftJoin('customer', 'c', 'c.`id_customer` = a.`id_customer`');
        $sql->innerJoin('address', 'address', 'address.id_address = a.id_address_delivery');
        $sql->innerJoin('country', 'country', 'address.id_country = country.id_country');
        $sql->innerJoin(
            'country_lang',
            'country_lang',
            '(country.`id_country` = country_lang.`id_country` AND country_lang.`id_lang` = 1)'
        );
        $sql->leftJoin('order_state', 'os', '(os.`id_order_state` = a.`current_state`)');
        $sql->leftJoin(
            'order_state_lang',
            'osl',
            '(os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = 1)'
        );
        $sql->leftJoin('shop', 'shop', 'a.`id_shop` = shop.`id_shop`');
        $sql->leftJoin('ds_deliveryhoursevents', 'hours', 'a.`id_cart` = hours.`id_cart`');

        $sql->where('a.`id_order` = '.(int) ($idOrder));

        return Db::getInstance()->ExecuteS($sql);
    }

    public static function sqlShipperMailByOrderID($idOrder)
    {
        $sql = new DbQuery();
        $sql->select('hours.shipper_email');

        $sql->from('orders', 'a');

        $sql->leftJoin('ds_deliveryhoursevents', 'hours', 'a.`id_cart` = hours.`id_cart`');

        $sql->where('a.`id_order` = '.(int) ($idOrder));

        $email = Db::getInstance()->getValue($sql);

        if ($email == '') {
            $email = false;
        }

        return $email;
    }

    public static function sqlCarrierByOrderID($idOrder)
    {
        $sql = new DbQuery();
        $sql->select('id_carrier');
        $sql->from('orders', 'a');
        $sql->where('a.`id_order` = '.(int) ($idOrder));
        $state = Db::getInstance()->getValue($sql);

        return $state;
    }

    public static function sqlStateByLang($idLang)
    {
        $sql = new DbQuery();
        $sql->select('id_order_state');
        $sql->select('name');
        $sql->from('order_state_lang', 'o');
        $sql->where('o.id_lang = '.(int) $idLang);
        $state = Db::getInstance()->ExecuteS($sql);

        return $state;
    }

    public static function sqlGetAllCurrency()
    {
        $sql = new DbQuery();
        $sql->select('id_currency');
        $sql->select('iso_code');
        $sql->from('currency', 'c');
        $currency = Db::getInstance()->ExecuteS($sql);

        return $currency;
    }

    public static function sqlGetAllCountryByLang($idLang)
    {
        $sql = new DbQuery();
        $sql->select('O.id_order');
        $sql->select('CL.id_country');
        $sql->select('CL.name');
        $sql->from('orders', 'O');
        $sql->innerJoin('address', 'A', 'O.id_address_delivery = A.id_address');
        $sql->innerJoin('country_lang', 'CL', 'A.id_country = CL.id_country');
        $sql->where('CL.id_lang = '.(int) $idLang);
        $sql->groupBy('CL.id_country');
        $country = Db::getInstance()->ExecuteS($sql);

        return $country;
    }

    public static function sqlCountOrders()
    {
        $sql = new DbQuery();
        $sql->select('COUNT(*)');
        $sql->from('orders');

        return Db::getInstance()->getValue($sql);
    }

    public static function versionValidation()
    {
        $presVersion = Tools::substr(_PS_VERSION_, 2);

        $firstPointPos = Tools::strpos($presVersion, '.');
        $secondPointPos = Tools::strpos($presVersion, '.', $firstPointPos + 1);

        $presVersionMain = (int) Tools::substr($presVersion, 0, $firstPointPos);
        $presVersionSub = (int) Tools::substr($presVersion, $firstPointPos + 1, $secondPointPos - $firstPointPos - 1);        

        switch (true) {
            case $presVersionMain < 6:
                $msg = false;
                break;
            case $presVersionMain == 6:
                $msg = 1;
                break;
            case $presVersionMain == 7 && $presVersionSub < 6:
                $msg = 2;
                break;
            case $presVersionMain == 7 && $presVersionSub > 5:
                $msg = 3;
                break;
            case $presVersionMain > 7:
                $msg = false;
                break;

                
        }
        return $msg;
    }

    public static function sqlGetCustomerByOrderIDCustomerLang($idOrder)
    {
        $sql = new DbQuery();
        $sql->select('C.firstname');
        $sql->select('C.lastname');
        $sql->select('C.email');
        $sql->select('A.company AS d_company');
        $sql->select('A.address1 AS d_address1');
        $sql->select('A.address2 AS d_address2');
        $sql->select('A.postcode AS d_postcode');
        $sql->select('A.city AS d_city');
        $sql->select('L.name AS d_country');
        $sql->select('A.phone AS d_phone');
        $sql->select('A.phone_mobile AS d_phone_mobile');
        $sql->select('I.company AS i_company');
        $sql->select('I.address1 AS i_address1');
        $sql->select('I.address2 AS i_address2');
        $sql->select('I.postcode AS i_postcode');
        $sql->select('I.city AS i_city');
        $sql->select('CL.name AS i_country');
        $sql->select('I.phone AS i_phone');
        $sql->select('I.phone_mobile AS i_phone_mobile');

        $sql->from('orders', 'O');

        $sql->innerJoin('customer', 'C', 'O.id_customer = C.id_customer');
        $sql->innerJoin('address', 'A', 'O.id_address_delivery = A.id_address');
        $sql->innerJoin('address', 'I', 'O.id_address_invoice = I.id_address');
        $sql->innerJoin('country_lang', 'L', 'A.id_country = L.id_country AND O.id_lang = L.id_lang');
        $sql->innerJoin('country_lang', 'CL', 'I.id_country = CL.id_country AND O.id_lang = L.id_lang');
        $sql->where('O.id_order = '.(int) $idOrder);

        $customer = Db::getInstance()->getRow($sql);

        return $customer;
    }

    public static function sqlGetCustomerByOrderIDOfficeLang($idOrder, $idLang)
    {
        $sql = new DbQuery();
        $sql->select('C.firstname');
        $sql->select('C.lastname');
        $sql->select('C.email');
        $sql->select('A.company AS d_company');
        $sql->select('A.address1 AS d_address1');
        $sql->select('A.address2 AS d_address2');
        $sql->select('A.postcode AS d_postcode');
        $sql->select('A.city AS d_city');
        $sql->select('L.name AS d_country');
        $sql->select('A.phone AS d_phone');
        $sql->select('A.phone_mobile AS d_phone_mobile');
        $sql->select('I.company AS i_company');
        $sql->select('I.address1 AS i_address1');
        $sql->select('I.address2 AS i_address2');
        $sql->select('I.postcode AS i_postcode');
        $sql->select('I.city AS i_city');
        $sql->select('CL.name AS i_country');
        $sql->select('I.phone AS i_phone');
        $sql->select('I.phone_mobile AS i_phone_mobile');

        $sql->from('orders', 'O');

        $sql->innerJoin('customer', 'C', 'O.id_customer = C.id_customer');
        $sql->innerJoin('address', 'A', 'O.id_address_delivery = A.id_address');
        $sql->innerJoin('address', 'I', 'O.id_address_invoice = I.id_address');
        $sql->innerJoin('country_lang', 'L', 'A.id_country = L.id_country AND '.(int) $idLang.' = L.id_lang');
        $sql->innerJoin('country_lang', 'CL', 'I.id_country = CL.id_country AND '.(int) $idLang.' = L.id_lang');
        $sql->where('O.id_order = '.(int) $idOrder);

        $customer = Db::getInstance()->getRow($sql);

        return $customer;
    }

    public static function sqlGetLangByOrderID($idOrder)
    {
        $sql = new DbQuery();
        $sql->select('id_lang');
        $sql->from('orders', 'O');
        $sql->where('O.id_order = '.(int) $idOrder);
        $lang = Db::getInstance()->getValue($sql);

        return $lang;
    }

    public static function getOrderData($idOrder, $idLang)
    {
        $sql = new DbQuery();

        $sql->select('O.id_order');
        $sql->select('O.product_id');
        $sql->select('O.product_name');
        $sql->select('O.product_quantity');
        $sql->select('O.product_quantity_in_stock');
        $sql->select('O.product_quantity_refunded');
        $sql->select('O.product_quantity_return');
        $sql->select('O.product_quantity_reinjected');
        $sql->select('O.product_price');
        $sql->select('O.reduction_percent');
        $sql->select('O.reduction_amount');
        $sql->select('O.reduction_amount_tax_incl');
        $sql->select('O.reduction_amount_tax_excl');
        $sql->select('O.group_reduction');
        $sql->select('O.product_quantity_discount');
        $sql->select('O.id_tax_rules_group');
        $sql->select('O.tax_computation_method');
        $sql->select('O.tax_name');
        $sql->select('O.tax_rate');
        $sql->select('O.ecotax');
        $sql->select('O.ecotax_tax_rate');
        $sql->select('O.discount_quantity_applied');
        $sql->select('O.total_price_tax_incl');
        $sql->select('O.total_price_tax_excl');
        $sql->select('O.unit_price_tax_incl');
        $sql->select('O.unit_price_tax_excl');
        $sql->select('O.total_shipping_price_tax_incl');
        $sql->select('O.total_shipping_price_tax_excl');
        $sql->select('O.purchase_supplier_price');
        $sql->select('O.original_product_price');
        $sql->select('O.original_wholesale_price');
        $sql->select('O.product_reference');
        $sql->select('I.id_image');
        $sql->select('L.link_rewrite');

        $sql->from('order_detail', 'O');

        $sql->innerJoin('product_attribute_image', 'I', 'I.id_product_attribute = O.product_attribute_id');
        $sql->innerJoin('product_lang', 'L', 'L.id_product = O.product_id');
        $sql->where('O.id_order = '.(int) $idOrder);
        $sql->where('L.id_lang = ' .(int) $idLang);

        $orderData = Db::getInstance()->executeS($sql);

        return $orderData;
    }

    public static function getOrderDataGlobal($idOrder, $idLang)
    {
        $sql = new DbQuery();

        $sql->select('O.total_products_wt');
        $sql->select('O.total_discounts');
        $sql->select('O.total_wrapping');
        $sql->select('O.total_shipping');
        $sql->select('(O.total_paid_tax_incl - total_paid_tax_excl) AS sum_tax');
        $sql->select('O.total_paid');
        $sql->select('O.id_currency');
        
        $sql->from('orders', 'O');

        $sql->where('O.id_order = '.(int) $idOrder);
        $sql->where('O.id_lang = ' .(int) $idLang);

        $orderData = Db::getInstance()->executeS($sql);

        return $orderData;
    }

}
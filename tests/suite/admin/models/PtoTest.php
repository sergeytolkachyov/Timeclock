<?php
/**
 * Tests the driver class
 *
 * PHP Version 5
 *
 * <pre>
 * Timeclock is a Joomla application to keep track of employee time
 * Copyright (C) 2007 Hunt Utilities Group, LLC
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * </pre>
 *
 * @category   Test
 * @package    JoomlaMock
 * @subpackage TestCase
 * @author     Scott Price <prices@hugllc.com>
 * @copyright  2008 Hunt Utilities Group, LLC
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    GIT: $Id: 80d1646885914757d9ec72932ebb27f448c52019 $
 * @link       https://dev.hugllc.com/index.php/Project:JoomlaMock
 */
namespace com_timeclock\tests\admin\models;
/** Base test class */
require_once __DIR__."/ModelTestBase.php";
/** Class under test */
require_once SRC_PATH."/com_timeclock/admin/models/pto.php";

/**
 * Test class for driver.
 * Generated by PHPUnit_Util_Skeleton on 2007-10-30 at 08:44:25.
 *
 * @category   Test
 * @package    JoomlaMock
 * @subpackage TestCase
 * @author     Scott Price <prices@hugllc.com>
 * @copyright  2008 Hunt Utilities Group, LLC
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link       https://dev.hugllc.com/index.php/Project:JoomlaMock
 */
class PtoTest extends ModelTestBase
{
    /** This is the model we are testing */
    protected $model = '\TimeclockModelsPto';
    /**
    * data provider for testGetItem
    *
    * @return array
    */
    public static function dataGetItem()
    {
        return array(
            "Get One" => array(
                array(
                    "id" => 2,
                ),  // Input array (Mocks $_REQUEST)
                null // Expected Return
            ),
            "No id given" => array(
                array(
                ), // Input array (Mocks $_REQUEST)
                null // Expected Return
            ),
        );
    }
    /**
    * data provider for testGetList
    *
    * @return array
    */
    public static function dataGetList()
    {
        return array(
            "ID given" => array(
                array(
                    "id" => 2,
                ), // Input array (Mocks $_REQUEST)
                array(
                    /*
                    array(
                        "timesheet_id" => 2,
                    ),
                    */
                ) // Expected Return
            ),
            "Get All" => array(
                array(
                ), // Input array (Mocks $_REQUEST)
                array(
                    /*
                    array(
                        "timesheet_id" => 5,
                    ),
                    array(
                        "timesheet_id" => 8,
                    ),
                    array(
                        "timesheet_id" => 1,
                    ),
                    array(
                        "timesheet_id" => 6,
                    ),
                    array(
                        "timesheet_id" => 2,
                    ),
                    array(
                        "timesheet_id" => 7,
                    ),
                    array(
                        "timesheet_id" => 4,
                    ),
                    */
                ) // Expected Return
            ),
        );
    }
    /**
    * data provider for testGetTotal
    *
    * @return array
    */
    public static function dataGetTotal()
    {
        return array(
            "ID Given" => array(
                array(
                    "id" => 2,
                ),  // Input array (Mocks $_REQUEST)
                0   // Expected Return
            ),
            "Nominal" => array(
                array(
                ), // Input array (Mocks $_REQUEST)
                0  // Expected Return
            ),
        );
    }
    /**
    * data provider for testGetTotal
    *
    * @return array
    */
    public static function dataCheckSortFields()
    {
        return array(
            "Empty Array" => array(
                array(
                ), // Fields given
                array(
                    'o.pto_id' => "JDEFAULT",
                ), // Expected return
            ),
            "Empty String" => array(
                "", // Fields given
                "o.pto_id", // Expected return
            ),
            "Good String" => array(
                "o.modified", // Fields given
                "o.modified", // Expected return
            ),
            "Good Array with some bad strings" => array(
                array(
                    "o.pto_id" => "ID",
                    "o.modified" => "Name",
                    "c.company" => "Company",
                    "injection" => "Code Injection",
                ), // Fields given
                array(
                    "o.pto_id" => "ID",
                    "o.modified" => "Name",
                ), // Expected return
            ),
        );
    }
    /**
    * data provider for testAccrual
    *
    * @return array
    */
    public static function dataCalcAccrual()
    {
        return array(
            array(
                array(
                    "id" => 42,
                ), // Input array (Mocks $_REQUEST)
                array(
                    "get.user.id"       => 44,
                    "get.user.name"     => "Manager",
                    "get.user.username" => "manager",
                    "get.user.guest"    => 0,
                ),  // The session information
                array(
                    "ptoEnable" => true,
                    "ptoAccrualRates" => 'FULLTIME:PARTTIME
                                            1:10:5
                                            6:15:7.5
                                            21:20:10
                                            99:25:12.5',
                    "ptoHoursPerDay" => 8,
                    "decimalPlaces" => 2,
                ),
                array(
                    42 => array(
                        'startDate' => "2000-09-01",
                        'endDate'   => '',
                        'status'    => 'FULLTIME',
                    ),
                ), // $userparams
                "2014-09-01",  // Start
                "2014-09-07",  // End
                42,            // id
                1.85,            // Expect
            ),
        );
    }
    /**
    * test the set routine when an extra class exists
    *
    * @param mixed  $input   The name of the variable to test.
    * @param mixed  $options The session information to set up
    * @param array  $config  The configuration to set up for the component
    * @param string $start   The date to start
    * @param string $end     The date to end
    * @param int    $id      The id of the user to accrue for
    * @param array  $expect  The expected return
    *
    * @return null
    *
    * @dataProvider dataCalcAccrual
    */
    public function testCalcAccrual(
        $input, $options, $config, $userconfig, $start, $end, $id, $expect
    ) {
        $this->setSession($options);
        $this->setInput($input);
        $this->setComponentConfig($config);
        $this->setUserConfig($userconfig);
        $model = $this->model;
        $obj = new $model();
        $ret = $obj->CalcAccrual($start, $end, $id);
        $this->assertSame($expect, $ret);
    }
    /**
    * data provider for testAccrual
    *
    * @return array
    */
    public static function dataSetAccrual()
    {
        return array(
            "Normal 1 period" => array(
                array(
                    "id" => 42,
                ), // Input array (Mocks $_REQUEST)
                array(
                    "get.user.id"       => 44,
                    "get.user.name"     => "Manager",
                    "get.user.username" => "manager",
                    "get.user.guest"    => 0,
                ),  // The session information
                array(
                    "ptoEnable" => true,
                    "ptoAccrualRates" => 'FULLTIME:PARTTIME
                                            1:10:5
                                            6:15:7.5
                                            21:20:10
                                            99:25:12.5',
                    "ptoHoursPerDay" => 8,
                    "decimalPlaces" => 2,
                    "ptoAccrualPeriod" => "week",
                ),
                array(
                    42 => array(
                        'startDate' => "2000-09-01",
                        'endDate'   => '',
                        'status'    => 'FULLTIME',
                    ),
                ), // $userparams
                "2014-01-06",  // Start
                "2014-01-12",  // End
                42,            // id
                true,            // Expect,
                array(
                    array(
                        'hours' => '3.08',
                        'created_by' => '44',
                        'valid_from' => '2014-01-12',
                        'valid_to' => '2014-12-31',
                        'notes' => 'Automatic Accrual',
                        'user_id' => '42',
                    ),
                ),              // ExpectDB
            ),
            "Year Boundry" => array(
                array(
                    "id" => 42,
                ), // Input array (Mocks $_REQUEST)
                array(
                    "get.user.id"       => 44,
                    "get.user.name"     => "Manager",
                    "get.user.username" => "manager",
                    "get.user.guest"    => 0,
                ),  // The session information
                array(
                    "ptoEnable" => true,
                    "ptoAccrualRates" => 'FULLTIME:PARTTIME
                                            1:10:5
                                            6:15:7.5
                                            21:20:10
                                            99:25:12.5',
                    "ptoHoursPerDay" => 8,
                    "decimalPlaces" => 2,
                    "ptoAccrualPeriod" => "week",
                ),
                array(
                    42 => array(
                        'startDate' => "2000-09-01",
                        'endDate'   => '',
                        'status'    => 'FULLTIME',
                    ),
                ), // $userparams
                "2013-12-30",  // Start
                "2014-01-05",  // End
                42,            // id
                true,            // Expect,
                array(
                    array(
                        'hours' => '1.23',
                        'created_by' => '44',
                        'valid_from' => '2013-12-31',
                        'valid_to' => '2013-12-31',
                        'notes' => 'Automatic Accrual',
                        'user_id' => '42',
                    ),
                    array(
                        'hours' => '1.85',
                        'created_by' => '44',
                        'valid_from' => '2014-01-05',
                        'valid_to' => '2014-12-31',
                        'notes' => 'Automatic Accrual',
                        'user_id' => '42',
                    ),
                ),              // ExpectDB
            ),
            "Normal 2 periods + extra" => array(
                array(
                    "id" => 42,
                ), // Input array (Mocks $_REQUEST)
                array(
                    "get.user.id"       => 44,
                    "get.user.name"     => "Manager",
                    "get.user.username" => "manager",
                    "get.user.guest"    => 0,
                ),  // The session information
                array(
                    "ptoEnable" => true,
                    "ptoAccrualRates" => 'FULLTIME:PARTTIME
                                            1:10:5
                                            6:15:7.5
                                            21:20:10
                                            99:25:12.5',
                    "ptoHoursPerDay" => 8,
                    "decimalPlaces" => 2,
                    "ptoAccrualPeriod" => "week",
                ),
                array(
                    42 => array(
                        'startDate' => "2000-09-01",
                        'endDate'   => '',
                        'status'    => 'FULLTIME',
                    ),
                ), // $userparams
                "2013-12-16",  // Start
                "2013-12-31",  // End
                42,            // id
                true,            // Expect,
                array(
                    array(
                        'hours' => '3.08',
                        'created_by' => '44',
                        'valid_from' => '2013-12-22',
                        'valid_to' => '2013-12-31',
                        'notes' => 'Automatic Accrual',
                        'user_id' => '42',
                    ),
                    array(
                        'hours' => '3.08',
                        'created_by' => '44',
                        'valid_from' => '2013-12-29',
                        'valid_to' => '2013-12-31',
                        'notes' => 'Automatic Accrual',
                        'user_id' => '42',
                    ),
                ),              // ExpectDB
            ),
            "Normal 2 periods" => array(
                array(
                    "id" => 42,
                ), // Input array (Mocks $_REQUEST)
                array(
                    "get.user.id"       => 44,
                    "get.user.name"     => "Manager",
                    "get.user.username" => "manager",
                    "get.user.guest"    => 0,
                ),  // The session information
                array(
                    "ptoEnable" => true,
                    "ptoAccrualRates" => 'FULLTIME:PARTTIME
                                            1:10:5
                                            6:15:7.5
                                            21:20:10
                                            99:25:12.5',
                    "ptoHoursPerDay" => 8,
                    "decimalPlaces" => 2,
                    "ptoAccrualPeriod" => "week",
                ),
                array(
                    42 => array(
                        'startDate' => "2000-09-01",
                        'endDate'   => '',
                        'status'    => 'FULLTIME',
                    ),
                ), // $userparams
                "2013-12-16",  // Start
                "2013-12-29",  // End
                42,            // id
                true,            // Expect,
                array(
                    array(
                        'hours' => '3.08',
                        'created_by' => '44',
                        'valid_from' => '2013-12-22',
                        'valid_to' => '2013-12-31',
                        'notes' => 'Automatic Accrual',
                        'user_id' => '42',
                    ),
                    array(
                        'hours' => '3.08',
                        'created_by' => '44',
                        'valid_from' => '2013-12-29',
                        'valid_to' => '2013-12-31',
                        'notes' => 'Automatic Accrual',
                        'user_id' => '42',
                    ),
                ),              // ExpectDB
            ),
        );
    }
    /**
    * test the set routine when an extra class exists
    *
    * @param mixed  $input    The name of the variable to test.
    * @param mixed  $options  The session information to set up
    * @param array  $config   The configuration to set up for the component
    * @param string $start    The date to start
    * @param string $end      The date to end
    * @param int    $id       The id of the user to accrue for
    * @param array  $expect   The expected return
    * @param array  $expectDB The expected database entry
    *
    * @return null
    *
    * @dataProvider dataSetAccrual
    */
    public function testSetAccrual(
        $input, $options, $config, $userconfig, $start, $end, $id, $expect, $expectDB
    ) {
        $this->setSession($options);
        $this->setInput($input);
        $this->setComponentConfig($config);
        $this->setUserConfig($userconfig);
        $model = $this->model;
        $obj = new $model();
        $ret = $obj->setAccrual($start, $end, $id);
        $this->assertSame($expect, $ret, "The return is wrong");

        $db = \JFactory::getDBO();
        $query = $db->getQuery(TRUE);
        $query->select('o.hours as hours, o.created_by as created_by, o.valid_from as valid_from,
            o.valid_to as valid_to, o.notes as notes, o.user_id as user_id');
        $query->from('#__timeclock_pto as o');
        $query->where("o.valid_from >= '$start'");
        $query->where("o.valid_from <= '$end'");
        $query->where("o.user_id = '$id'");
        $db->setQuery($query);
        $res = $db->loadAssocList();
        $this->assertEquals($expectDB, $res, "The database is wrong");

    }

}

?>
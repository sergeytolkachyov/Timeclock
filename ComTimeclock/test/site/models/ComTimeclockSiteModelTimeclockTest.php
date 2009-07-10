<?php
/**
 * Tests the driver class
 *
 * PHP Version 5
 *
 * <pre>
 * ComTimeclock is a Joomla application to keep track of employee time
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
 * @package    ComTimeclockTest
 * @subpackage Test
 * @author     Scott Price <prices@hugllc.com>
 * @copyright  2008 Hunt Utilities Group, LLC
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    SVN: $Id$
 * @link       https://dev.hugllc.com/index.php/Project:ComTimeclock:JoomlaUI
 */
/** Require the JoomlaMock stuff */
require_once dirname(__FILE__).'/../../JoomlaMock/joomla.php';
require_once dirname(__FILE__).'/../../JoomlaMock/testCases/JModelTest.php';
require_once dirname(__FILE__).'/../../../site/models/timeclock.php';

/**
 * Test class for driver.
 * Generated by PHPUnit_Util_Skeleton on 2007-10-30 at 08:44:25.
 *
 * @category   Test
 * @package    ComTimeclockTest
 * @subpackage Test
 * @author     Scott Price <prices@hugllc.com>
 * @copyright  2008 Hunt Utilities Group, LLC
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link       https://dev.hugllc.com/index.php/Project:ComTimeclock:JoomlaUI
 */
class ComTimeclockSiteModelTimeclockTest extends JModelTest
{
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return null
     *
     * @access protected
     */
    protected function setUp()
    {
        $this->sqlFile = array(
            dirname(__FILE__)."/../../../admin/install/timeclock_timesheet.sql",
            dirname(__FILE__)."/../../../admin/install/timeclock_users.sql",
            dirname(__FILE__)."/../../../admin/install/timeclock_prefs.sql",
        );
        $this->o = new TimeclockModelTimeclock();
        parent::setUp();
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @return null
     *
     * @access protected
     */
    protected function tearDown()
    {
        parent::tearDown();
        unset($this->o);
    }

    /**
     * Data provider
     *
     * @return array
     */
    public static function dataGetDataCache()
    {
        return array(
        );
    }
    /**
     * Data provider
     *
     * @return array
     */
    public static function dataStore()
    {
        return array(
        );
    }
    /**
     * Data provider
     *
     * @return array
     */
    public static function dataStoreRet()
    {
        return array(

            array(
                null,
                "store",
                false,
                array(),
                ""
            ),
            array(
                null,
                "store",
                true,
                array(
                    "id" => 1,
                    "date" => "2007-12-25",
                    "timesheet" => array(5 => array("hours1" => 5))
                ),
                ""
            ),
            array(
                "bind",
                "store",
                false,
                array(
                    "id" => 1,
                    "date" => "2007-12-25",
                    "timesheet" => array(5 => array("hours1" => 5))
                ),
                ""
            ),
            array(
                "check",
                "store",
                false,
                array(
                    "id" => 1,
                    "date" => "2007-12-25",
                    "timesheet" => array(5 => array("hours1" => 5))
                ),
                ""
            ),
            array(
                "store",
                "store",
                false,
                array(
                    "id" => 1,
                    "date" => "2007-12-25",
                    "timesheet" => array(5 => array("hours1" => 5))
                ),
                ""
            ),
        );
    }
    /**
     * Data provider
     *
     * @return array
     */
    public static function dataGetSetDate()
    {
        return array(
            array("2009-05-12", false, "2009-05-12"),
            array("2002-5-2", false, "2002-5-2"),
            array("2002-05-22 21:24:52", false, "2002-05-22"),
            array("2523422002-05-2225114", false, "2002-05-22"),
            array("2523422002-052-2225114", false, null),
            array(null, false, null),
            array("2523422002-052-2225114", true, date("Y-m-d")),
            array(null, true, date("Y-m-d")),
        );
    }
    /**
     * Tests get and set date
     *
     * @param string $date   The date to test
     * @param bool   $force  Force a valid date no matter what
     * @param string $expect The date we expect returned
     *
     * @dataProvider dataGetSetDate()
     * @return null
     */
    function testGetSetDate($date, $force, $expect)
    {
        $this->o->setDate($date, "date", $force);
        $ret = $this->o->get("date");
        $this->assertSame($expect, $ret);
    }

    /**
     * Data provider
     *
     * @return array
     */
    public static function dataSetProject()
    {
        return array(
            array("1002", 1002),
            array(null, null),
            array(0, null),
            array("asdf", null),
        );
    }

    /**
     * Tests get and set date
     *
     * @param mixed $proj   The project
     * @param int   $expect The date we expect returned
     *
     * @dataProvider dataSetProject()
     * @return null
     */
    function testSetProject($proj, $expect)
    {
        $this->o->setProject($proj);
        $ret = $this->readAttribute($this->o, "_project");
        $this->assertSame($expect, $ret);
    }

    /**
     * Data provider
     *
     * @return array
     */
    public static function dataGetSetPeriodDate()
    {
        return array(
            // Start Date
            array("2009-05-12", "month", "start", "2009-05-12"),
            array("2002-5-2", "year", "start", "2002-5-2"),
            array("2002-05-22 21:24:52", "month", "start", "2002-05-22"),
            array("2523422002-05-2225114", "month", "start", "2002-05-22"),
            array("2523422002-052-2225114", "month", "start", date("Y-m-01")),
            array(null, "month", "start", date("Y-m-01")),
            array(null, "asdf", "start", date("Y-m-01")),
            array(null, "year", "start", date("Y-01-01")),
            array(null, "day", "start", date("Y-m-d")),
            array(null, "payperiod", "start", "2008-03-10", "2008-3-20"),
            array(null, "payperiod", "start", "2008-02-25", "2008-03-01"),
            array(null, "quarter", "start", date("Y-01-01"), "2008-3-20"),
            array(null, "quarter", "start", date("Y-04-01"), "2008-6-20"),
            array(null, "quarter", "start", date("Y-07-01"), "2008-9-20"),
            array(null, "quarter", "start", date("Y-10-01"), "2008-11-20"),
            // End Date
            array("2009-05-12", "month", "end", "2009-05-12"),
            array("2002-5-2", "month", "end", "2002-5-2"),
            array("2002-05-22 21:24:52", "month", "end", "2002-05-22"),
            array("2523422002-05-2225114", "month", "end", "2002-05-22"),
            array("2523422002-052-2225114", "month", "end", date("Y-m-t")),
            array(null, "month", "end", date("Y-m-t")),
            array(null, "asdf", "end", date("Y-m-t")),
            array(null, "year", "end", date("Y-12-31")),
            array(null, "day", "end", date("Y-m-d")),
            array(null, "payperiod", "end", "2008-03-23", "2008-3-20"),
            array(null, "payperiod", "end", "2008-03-09", "2008-3-01"), // DST
            array(null, "quarter", "end", date("Y-03-31"), "2008-3-20"),
            array(null, "quarter", "end", date("Y-06-30"), "2008-6-20"),
            array(null, "quarter", "end", date("Y-09-30"), "2008-9-20"),
            array(null, "quarter", "end", date("Y-12-31"), "2008-11-20"),
        );
    }

    /**
     * Tests get and set date
     *
     * @param string $date   The date to test
     * @param string $type   The type to test (month, day, year, quarter, etc)
     * @param string $field  The field to save
     * @param string $expect The date we expect returned
     * @param string $today  What to tell set the current date to
     *
     * @dataProvider dataGetSetPeriodDate()
     * @return null
     */
    function testGetSetPeriodDate($date, $type, $field, $expect, $today=null)
    {
        $this->o->set($type, "type");
        if (!empty($today)) {
            $this->o->set($today, "date");
        }
        $this->o->setPeriodDate($date, $field);
        $ret = $this->o->get($field);
        $this->assertSame($expect, $ret);
    }

    /**
     * Data provider
     *
     * @return array
     */
    public static function dataGetPeriodDates()
    {
        return array(
            array(
                "2007-12-12",
                "2007-12-25",
                array(
                    "type" => "payperiod",
                    "unix" => array(
                        "date"    => mktime(
                            6,
                            0,
                            0,
                            date("m"),
                            date("d"),
                            date("Y")
                        ),
                        "start"   => 1197460800,
                        "end"     => 1198584000,
                        "prev"    => 1196251200,
                        "prevend" => 1197374400,
                        "next"    => 1198670400,
                        "nextend" => 1199793600,
                    ),
                    "date" => date("Y-m-d"),
                    "start" => "2007-12-12",
                    "end" => "2007-12-25",
                    "length" => 14,
                    "dates" => array(
                        "2007-12-12" => 1197460800,
                        "2007-12-13" => 1197547200,
                        "2007-12-14" => 1197633600,
                        "2007-12-15" => 1197720000,
                        "2007-12-16" => 1197806400,
                        "2007-12-17" => 1197892800,
                        "2007-12-18" => 1197979200,
                        "2007-12-19" => 1198065600,
                        "2007-12-20" => 1198152000,
                        "2007-12-21" => 1198238400,
                        "2007-12-22" => 1198324800,
                        "2007-12-23" => 1198411200,
                        "2007-12-24" => 1198497600,
                        "2007-12-25" => 1198584000,
                    ),
                    "prev"    => "2007-11-28",
                    "prevend" => "2007-12-11",
                    "next"    => "2007-12-26",
                    "nextend" => "2008-01-08",
                    "_done" => true,
                ),
            ),
        );
    }

    /**
     * Tests get and set date
     *
     * @param string $start  The date to test
     * @param string $end    The date to test
     * @param string $expect The date we expect returned
     * @param string $type   The type of period
     *
     * @dataProvider dataGetPeriodDates()
     * @return null
     */
    function testGetPeriodDates($start, $end, $expect, $type = "payperiod")
    {
        $this->o->setDate($start, "start");
        $this->o->setDate($end, "end");
        $this->o->set($type, "type");
        $ret = $this->o->getPeriodDates();
        $this->assertSame($expect, $ret);
    }
    /**
     * Data provider
     *
     * @return array
     */
    public static function dataGetHolidayPerc()
    {
        return array(
            array(
                array(),
                49,
                '2007-12-21',
                1,
            ),
            array(
                array(
                    "id" => 48,
                    "prefs" => array(
                        "admin_holidayperc" => 50,
                    ),
                ),
                48,
                '2007-12-21',
                0.5,
            ),
            array(
                array(
                    "id" => 47,
                    "prefs" => array(
                        "admin_holidayperc" => 100,
                    ),
                    "history" => array(
                        "admin_holidayperc" => array(
                            "2006-04-25" => 50,
                            "2008-05-12" => 90,
                            "2009-12-05" => 30,
                        ),
                    ),
                ),
                47,
                '2007-12-21',
                0.9,
            ),
            array(
                array(
                    "id" => 46,
                    "prefs" => array(
                        "admin_holidayperc" => 100,
                    ),
                    "history" => array(
                        "admin_holidayperc" => array(
                            "2006-04-25" => 50,
                            "2008-05-12" => 90,
                            "2009-12-05" => 30,
                        ),
                    ),
                ),
                46,
                '2008-05-12',
                0.3,
            ),


        );
    }
    /**
     * Tests get and set date
     *
     * @param array  $preload Data to preload into the database
     * @param int    $id      The user ID
     * @param string $date    The date to use
     * @param int    $expect  The expected return
     *
     * @dataProvider dataGetHolidayPerc()
     * @return null
     */
    function testGetHolidayPerc($preload, $id, $date, $expect)
    {
        $GLOBALS["JTable"]["load"][$id] = $preload;
        $ret = $this->o->getHolidayPerc($id, $date);
        $this->assertSame($expect, $ret);
    }

}

?>

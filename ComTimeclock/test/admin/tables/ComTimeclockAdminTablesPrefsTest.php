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
 * @copyright  2008-2009, 2011 Hunt Utilities Group, LLC
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    SVN: $Id$
 * @link       https://dev.hugllc.com/index.php/Project:ComTimeclock:JoomlaUI
 */
/** Require the JoomlaMock stuff */
require_once dirname(__FILE__).'/../../include.php';
require_once dirname(__FILE__).'/../../JoomlaMock/testCases/JTableTest.php';
require_once dirname(__FILE__).'/../../../admin/tables/timeclockprefs.php';

/**
 * Test class for driver.
 * Generated by PHPUnit_Util_Skeleton on 2007-10-30 at 08:44:25.
 *
 * @category   Test
 * @package    ComTimeclockTest
 * @subpackage Test
 * @author     Scott Price <prices@hugllc.com>
 * @copyright  2008-2009, 2011 Hunt Utilities Group, LLC
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link       https://dev.hugllc.com/index.php/Project:ComTimeclock:JoomlaUI
 */
class ComTimeclockAdminTablesPrefsTest extends JTableTest
{
    /** @var string The table we should be using */
    public $table = "#__timeclock_prefs";
    /** @var the Id string */
    public $id = "id";

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
            dirname(__FILE__)."/../../../admin/sql/timeclock_prefs.mysql.utf8.sql",
        );
        parent::setUp();
        $this->_db->setQuery("DELETE FROM #__timeclock_prefs");
        $this->_db->query();
        $this->o = new TableTimeclockPrefs($this->_db);
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
    public static function dataConstruct()
    {
        return array(
            array("#__timeclock_prefs", "id", null),
        );
    }

    /**
     * Data provider
     *
     * @return array
     */
    public static function dataEncodeDecode()
    {
        return array(
            array(array("Hello", "there")),
            array(new stdClass()),
            array("Hello"),
            array(1),
        );
    }
    /**
     * This tests the encode and decode parameters
     *
     * @param mixed $sample The sample to encode and decode
     *
     * @dataProvider dataEncodeDecode()
     * @return null
     */
    function testEncodeDecode($sample)
    {
        $encode = $this->o->encode($sample);
        $decode = $this->o->decode($encode);
        $this->assertEquals($sample, $decode);
    }
    /**
     * Data provider
     *
     * @return array
     */
    public static function dataStore()
    {
        return array(
            array(
                array(
                    "id" => 12,
                    "prefs" => array(1,2,3,4),
                ),
                array(
                    "id" => 12,
                    "prefs" => "YTo0OntpOjA7aToxO2k6MTtpOjI7aToyO2k6MztpOjM7aTo"
                        ."0O30=",
                    "published" => 0,
                    "startDate" => null,
                    "endDate" => null,
                    "manager" => 0,
                    "history" => "YTowOnt9",
                ),
            ),
        );
    }

    /**
     * Data provider
     *
     * @return array
     */
    public static function dataLoad()
    {
        return array(
            array(
                array(
                    15 => array(
                        "id" => 15,
                        "prefs" => "1:1,2:2,3:3,4:4",
                    ),
                ),
                15,
                "user",
                array(
                    "id" => 15,
                    "prefs" => array(1,2,3,4),
                    "published" => null,
                    "startDate" => null,
                    "endDate" => null,
                    "manager" => null,
                    "history" => array(),
                ),
            ),
        );
    }
    /**
     * This tests the encode and decode parameters
     *
     * @param array    $setup  Data to set into the class
     * @param int|null $oid    The optional ID
     * @param string   $type   "system" or "user"
     * @param array    $expect The data in the database to expect
     *
     * @dataProvider dataLoad()
     * @return null
     */
    function testLoad($setup, $oid, $type, $expect)
    {
        $GLOBALS["JTable"]["load"] = $setup;
        $this->o->load($oid);
        $ret = $this->objectToArray($this->o);
        $defaults = $this->readAttribute("TableTimeclockPrefs", "_defaults");
        $expect["prefs"] = array_merge($defaults, $expect["prefs"]);
        $this->assertSame($expect, $ret);
    }
    /**
    * Data provider
    *
    * @return array
    */
    public static function dataGetSetPref()
    {
        return array(
            array(
                "hello",
                12,
                "here",
                "here",
            ),
            array(
                "maxDailyHours",
                15,
                null,
                24,
            ),
            array(
                "admin_holidayperc",
                22,
                null,
                100,
            ),
            array(
                "hello",
                0,
                "here",
                null,
            ),
            array(
                "maxDailyHours",
                0,
                null,
                24,
            ),
            array(
                "userTypes",
                0,
                null,
                array(
                    "FULLTIME"   => "Full Time",
                    "PARTTIME"   => "Part Time",
                    "CONTRACTOR" => "Contractor",
                    "TEMPORARY"  => "Temporary",
                    "TERMINATED" => "Terminated",
                    "RETIRED"    => "Retired",
                    "UNPAID"     => "Unpaid Leave",
                ),
            ),
            array(
                "wCompCodes",
                0,
                "1234 code 1\n2458 code 2\n 5345 code 3",
                array(
                    0 => "Hours",
                ),
            ),
            array(
                "admin_holidayperc",
                0,
                null,
                null,
            ),
        );
    }

    /**
    * Tests setPref
    *
    * @param string $name   The name of the pref
    * @param int    $user   The user id to use
    * @param mixed  $value  The value of the pref
    * @param mixed  $expect The value we expect returned
    *
    * @return none
    * @dataProvider dataGetSetPref()
    */
    function testGetSetPref($name, $user, $value, $expect)
    {
        $u     = new JUser();
        $u->id = $user;

        $GLOBALS["JFactory"]["getUser"]["current"] =& $u;
        $GLOBALS["JFactory"]["getUser"][$user]     =& $u;

        if (!is_null($value)) {
            $this->o->setPref($name, $value, $user);
        }
        $ret = $this->o->getPref($name, $user);
        $this->assertSame($expect, $ret);
    }



    /**
    * Data provider
    *
    * @return array
    */
    public static function dataGetPrefSet()
    {
        return array(
            array(
                "hello",
                12,
                "nope",
                "here",
            ),
        );
    }

    /**
    * Tests setPref
    *
    * @param string $name   The name of the pref
    * @param int    $user   The user id to use
    * @param mixed  $expect The value of the pref
    * @param array  $preset The expected return value
    *
    * @return none
    * @dataProvider dataGetPrefSet()
    */
    function testGetPrefSet($name, $user, $expect, $preset)
    {
        $u     = new JUser();
        $u->id = $user;

        $GLOBALS["JFactory"]["getUser"]["current"] =& $u;
        $GLOBALS["JFactory"]["getUser"][$user]     =& $u;

        $this->o->setPref($name, $preset);
        $ret = $this->o->getPref($name);
        $this->o->setPref($name, $expect);
        $ret = $this->o->getPref($name);
        $this->assertSame($expect, $ret);
    }

}

?>
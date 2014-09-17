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
 * @version    SVN: $Id: 0344a6f8507818eb857f2a28a55814ba7794078c $
 * @link       https://dev.hugllc.com/index.php/Project:JoomlaMock
 */
namespace com_timeclock\tests\site\models;
/** Base test class */
require_once __DIR__."/ModelTestBase.php";
/** Class under test */
require_once SRC_PATH."/com_timeclock/site/models/addhours.php";

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
    class AddhoursTest extends ModelTestBase
{
    /** This is the model we are testing */
    protected $model = '\TimeclockModelsAddhours';
    /**
    * data provider for testGetList
    *
    * @return array
    */
    public static function dataGetList()
    {
        return array(
            "Super User" => array(
                array(
                    "date" => "2014-09-04",
                ), // Input array (Mocks $_REQUEST)
                array(
                    "get.user.id"       => 42,
                    "get.user.name"     => "Super User",
                    "get.user.username" => "admin",
                    "get.user.guest"    => 0,
                ),  // The session information
                array(
                    1 => array(
                        'timesheet_id' => '1',
                        'hours' => '8.0',
                        'worked' => '2014-09-04',
                        'project_id' => '1',
                        'notes' => 'Some stuff.',
                        'hours1' => '8.0',
                        'hours2' => '0.0',
                        'hours3' => '0.0',
                        'hours4' => '0.0',
                        'hours5' => '0.0',
                        'hours6' => '0.0',
                        'user_id' => '42',
                        'created_by' => '42',
                        'project' => 'Test1',
                        'project_type' => 'PROJECT',
                        'wcCode1' => '0',
                        'wcCode2' => '0',
                        'wcCode3' => '0',
                        'wcCode4' => '0',
                        'wcCode5' => '0',
                        'wcCode6' => '0',
                        'project_description' => 'This is a test project 1.',
                        'cat_id' => '0',
                        'cat_name' => "COM_TIMECLOCK_GENERAL",
                        'cat_description' => "COM_TIMECLOCK_GENERAL_DESC",
                        'user' => 'Super User',
                        'author' => 'Super User',
                    ),
                ) // Expected Return
            ),
            "Get All" => array(
                array(
                    "date" => "2014-09-03",
                ), // Input array (Mocks $_REQUEST)
                array(
                    "get.user.id"       => 44,
                    "get.user.name"     => "Manager",
                    "get.user.username" => "manager",
                    "get.user.guest"    => 0,
                ),  // The session information
                array(
                    2 => array(
                        'timesheet_id' => '7',
                        'hours' => '8.0',
                        'worked' => '2014-09-03',
                        'project_id' => '2',
                        'notes' => 'Stuffy Stuff',
                        'hours1' => '8.0',
                        'hours2' => '0.0',
                        'hours3' => '0.0',
                        'hours4' => '0.0',
                        'hours5' => '0.0',
                        'hours6' => '0.0',
                        'user_id' => '44',
                        'created_by' => '44',
                        'project' => 'Test2',
                        'project_type' => 'PROJECT',
                        'wcCode1' => '0',
                        'wcCode2' => '0',
                        'wcCode3' => '0',
                        'wcCode4' => '0',
                        'wcCode5' => '0',
                        'wcCode6' => '0',
                        'project_description' => 'This is a test project 2.',
                        'cat_id' => '0',
                        'cat_name' => "COM_TIMECLOCK_GENERAL",
                        'cat_description' => "COM_TIMECLOCK_GENERAL_DESC",
                        'user' => 'Manager',
                        'author' => 'Manager',
                    ),
                ) // Expected Return
            ),
        );
    }
    /**
    * test the set routine when an extra class exists
    *
    * @param mixed $input   The name of the variable to test.
    * @param array $options The options to give the mock session.
    * @param array $expects The expected return
    *
    * @return null
    *
    * @dataProvider dataGetList
    */
    public function testGetList($input, $options, $expects)
    {
        $this->setSession($options);
        $this->setInput($input);
        $model = $this->model;
        $obj = new $model();
        $ret = $obj->listItems();
        $check = array();
        $this->assertInternalType("array", $ret, "Return is not an array");
        foreach ($ret as $proj_id => $work) {
            if (is_array($work) && isset($expects[$proj_id]) && is_array($expects[$proj_id])) {
                foreach($work as $key => $return) {
                    if (isset($expects[$proj_id][$key]) && is_array($expects[$proj_id][$key])) {
                        $check[$proj_id][$key] = array();
                        foreach ($expects[$proj_id][$key] as $k => $v) {
                            $check[$proj_id][$key][$k] = $return->$k;
                        }
                    } else {
                        $return = is_object($return) ? get_object_vars($return) : $return;
                        $check[$proj_id][$key] = $return;
                    }
                }
            } else {
                $work = is_object($work) ? get_object_vars($work) : $work;
                $check[$proj_id] = $work;
            }
        }
        $this->assertEquals($expects, $check);
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
                array(
                ),  // The session information
                7   // Expected Return
            ),
            "Nominal" => array(
                array(
                ), // Input array (Mocks $_REQUEST)
                array(
                ),  // The session information
                7  // Expected Return
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
                    't.worked' => "JDEFAULT",
                ), // Expected return
            ),
            "Empty String" => array(
                "", // Fields given
                "t.worked", // Expected return
            ),
            "Good String" => array(
                "t.modified", // Fields given
                "t.modified", // Expected return
            ),
            "Good Array with some bad strings" => array(
                array(
                    "t.timesheet_id" => "ID",
                    "t.modified" => "Name",
                    "c.company" => "Company",
                    "injection" => "Code Injection",
                ), // Fields given
                array(
                    "t.timesheet_id" => "ID",
                    "t.modified" => "Name",
                ), // Expected return
            ),
        );
    }
    /**
    * data provider for testGet
    *
    * @return array
    */
    public static function dataGetState()
    {
        return array(
            "default" => array("_limit", "asdf", array(), array(), "asdf"),
            "Null" => array("_limit", null, array(), array(), null),
            "Class name" => array(
                null, null, array(), array(), "Joomla\Registry\Registry"
            ),
        );
    }

}

?>

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
 * @version    SVN: $Id: bb50ae32fcdac3cff02b501ec153d389d59df183 $
 * @link       https://dev.hugllc.com/index.php/Project:JoomlaMock
 */
namespace com_timeclock\tests\admin\models;
/** Base test class */
require_once __DIR__."/ModelTestBase.php";
/** Class under test */
require_once SRC_PATH."/com_timeclock/admin/models/project.php";

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
class ProjectTest extends ModelTestBase
{
    /** This is the model we are testing */
    protected $model = '\TimeclockModelsProject';
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
                ),   // Input array (Mocks $_REQUEST)
                array(
                    "project_id" => 2,
                ) // Expected return
            ),
            "No id given" => array(
                array(
                ),   // Input array (Mocks $_REQUEST)
                array(
                    "project_id" => 0,
                ) // Expected return
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
                ),   // Input array (Mocks $_REQUEST)
                array(
                    array(
                        "project_id" => 2,
                    ),
                ) // Expected return
            ),
            "Get All" => array(
                array(
                ),   // Input array (Mocks $_REQUEST)
                array(
                    0 => array(
                        "project_id" => 0,
                    ),
                    1 => array(
                        "project_id" => 1,
                    ),
                    2 => array(
                        "project_id" => 2,
                    ),
                    3 => array(
                        "project_id" => 3,
                    ),
                    4 => array(
                        "project_id" => 4,
                    ),
                    5 => array(
                        "project_id" => 5,
                    ),
                ) // Expected return
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
                ),   // Input array (Mocks $_REQUEST)
                6 // Expected return
            ),
            "Nominal" => array(
                array(
                ),  // Input array (Mocks $_REQUEST)
                6 // Expected return
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
                ),  // Fields given
                array(
                    'p.project_id' => "JDEFAULT",
                ), // Expected return
            ),
            "Empty String" => array(
                "", // Fields given
                "p.project_id", // Expected return
            ),
            "Good String" => array(
                "p.name", // Fields given
                "p.name", // Expected return
            ),
            "Good Array with some bad strings" => array(
                array(
                    "p.project_id" => "ID",
                    "p.name" => "Name",
                    "p.manager_id" => 1,
                    "injection" => "Code Injection",
                ), // Fields given
                array(
                    "p.project_id" => "ID",
                    "p.name" => "Name",
                    "p.manager_id" => 1,
                ), // Expected return
            ),
        );
    }
    /**
    * data provider for testUnpublish
    *
    * @return array
    */
    public static function dataListUserProjects()
    {
        return array(
            "ID given" => array(
                array(
                ),
                42,
                array(
                    1 => array(
                        "project_id" => 1,
                        "name" => "Test1",
                    ),
                    2 => array(
                        "project_id" => 2,
                        "name" => "Test2",
                    ),
                    3 => array(
                        "project_id" => 3,
                        "name" => "Test3",
                    ),
                    4 => array(
                        "project_id" => 4,
                        "name" => "Test4",
                    ),
                ),
            ),
            "ID from input" => array(
                array(
                    "id" => array(44),
                ),
                null,
                array(
                ),
            ),
            "No ID Given" => array(
                array(
                ),
                null,
                array(
                ),
            ),
        );
    }
    /**
    * test the set routine when an extra class exists
    *
    * @param array $input   The input to use
    * @param int   $id      The record id to use
    * @param array $expects The expected return
    *
    * @return null
    *
    * @dataProvider dataListUserProjects
    */
    public function testListUserProjects($input, $id, $expects)
    {
        $this->setInput($input);
        $model = $this->model;
        $obj = new $model();
        $ret = $obj->listUserProjects($id);
        $this->checkReturn($ret, $expects);
    }
    /**
    * data provider for testListProjectUsers
    *
    * @return array
    */
    public static function dataListProjectUsers()
    {
        return array(
            "ID given" => array(
                array(
                ),
                3,
                array(
                    42 => array(
                        "project_id" => 3,
                        "id" => 42,
                    ),
                    43 => array(
                        "project_id" => 3,
                        "id" => 43,
                    ),
                ),
            ),
            "ID from input" => array(
                array(
                    "id" => array(5),
                ),
                null,
                array(
                    99 => array(
                        "project_id" => 5,
                        "id" => 99,
                    ),
                    44 => array(
                        "project_id" => 5,
                        "id" => 44,
                    ),
                ),
            ),
            "Empty id" => array(
                array(
                ),
                null,
                array(
                ),
            ),
        );
    }
    /**
    * test the set routine when an extra class exists
    *
    * @param array $input   The input to use
    * @param int   $id      The record id to use
    * @param array $expects The expected return
    *
    * @return null
    *
    * @dataProvider dataListProjectUsers
    */
    public function testListProjectUsers($input, $id, $expects)
    {
        $this->setInput($input);
        $model = $this->model;
        $obj = new $model();
        $ret = $obj->listProjectUsers($id);
        $this->checkReturn($ret, $expects);
    }
    /**
    * data provider for testAddUsers
    *
    * @return array
    */
    public static function dataAddUsers()
    {
        return array(
            "ID given" => array(
                array(
                ),
                44,
                3,
                3,
                array(
                    array(
                        "project_id" => '3',
                        "user_id" => '42',
                    ),
                    array(
                        "project_id" => '3',
                        "user_id" => '43',
                    ),
                    array(
                        "project_id" => '3',
                        "user_id" => '44',
                    ),
                ),
            ),
            "ID from input" => array(
                array(
                    "id" => array(3),
                ),
                44,
                null,
                3,
                array(
                    array(
                        "project_id" => '3',
                        "user_id" => '42',
                    ),
                    array(
                        "project_id" => '3',
                        "user_id" => '43',
                    ),
                    array(
                        "project_id" => '3',
                        "user_id" => '44',
                    ),
                ),
            ),
            "Array given" => array(
                array(
                ),
                array(42, 44, 99),
                3,
                3,
                array(
                    array(
                        "project_id" => '3',
                        "user_id" => '42',
                    ),
                    array(
                        "project_id" => '3',
                        "user_id" => '43',
                    ),
                    array(
                        "project_id" => '3',
                        "user_id" => '44',
                    ),
                    array(
                        "project_id" => '3',
                        "user_id" => '99',
                    ),
                ),
            ),
        );
    }
    /**
    * test the set routine when an extra class exists
    *
    * @param array $input     The input to use
    * @param int   $id        The record id to use
    * @param int   $proj_id   The project ID to use
    * @param int   $search_id The project_id to search for
    * @param array $expect    The expected return
    *
    * @return null
    *
    * @dataProvider dataAddUsers
    */
    public function testAddUsers($input, $id, $proj_id, $search_id, $expect)
    {
        $this->setInput($input);
        $model = $this->model;
        $obj = new $model();
        $ret = $obj->addUsers($id, $proj_id);
        $db = \JFactory::getDBO();
        $db->setQuery(
            "SELECT * FROM `jos_timeclock_users` where project_id=".$search_id
        );
        $rows = $db->loadAssocList();
        $this->assertEquals($expect, $rows);
    }
    /**
    * data provider for testRemoveUsers
    *
    * @return array
    */
    public static function dataRemoveUsers()
    {
        return array(
            "ID given" => array(
                array(
                ),
                43,
                3,
                3,
                array(
                    array(
                        "project_id" => '3',
                        "user_id" => '42',
                    ),
                ),
            ),
            "ID from input" => array(
                array(
                    "id" => array(3),
                ),
                42,
                null,
                3,
                array(
                    array(
                        "project_id" => '3',
                        "user_id" => '43',
                    ),
                ),
            ),
            "Array given" => array(
                array(
                ),
                array(42, 44, 99),
                3,
                3,
                array(
                    array(
                        "project_id" => '3',
                        "user_id" => '43',
                    ),
                ),
            ),
        );
    }
    /**
    * test the set routine when an extra class exists
    *
    * @param array $input     The input to use
    * @param int   $id        The record id to use
    * @param int   $proj_id   The project ID to use
    * @param int   $search_id The project_id to search for
    * @param array $expect    The expected return
    *
    * @return null
    *
    * @dataProvider dataRemoveUsers
    */
    public function testRemoveUsers($input, $id, $proj_id, $search_id, $expect)
    {
        $this->setInput($input);
        $model = $this->model;
        $obj = new $model();
        $ret = $obj->removeUsers($id, $proj_id);
        $db = \JFactory::getDBO();
        $db->setQuery(
            "SELECT * FROM `jos_timeclock_users` where project_id=".$search_id
        );
        $rows = $db->loadAssocList();
        $this->assertEquals($expect, $rows);
    }
}

?>
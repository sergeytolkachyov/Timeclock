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
require_once dirname(__FILE__).'/../../JoomlaMock/testCases/JViewLegacyTest.php';
require_once dirname(__FILE__).'/../../../admin/views/projects/view.html.php';

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
class ComTimeclockAdminViewProjectsTest extends JViewLegacyTest
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
            dirname(__FILE__)."/../../../admin/sql/timeclock_projects.mysql.utf8.sql",
            dirname(__FILE__)."/../../../admin/sql/timeclock_users.mysql.utf8.sql",
            dirname(__FILE__)."/../../../admin/sql/timeclock_prefs.mysql.utf8.sql",
            dirname(__FILE__)."/../../../admin/sql/timeclock_timesheet.mysql.utf8.sql",
            dirname(__FILE__)."/../../../admin/sql/timeclock_customers.mysql.utf8.sql",
            dirname(__FILE__)."/../../admin/models/users.sql",
        );
        $this->o = new TimeclockAdminViewProjects();
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
    public static function dataDisplay()
    {
        return array(
            array("display", null),
            array("showList", null),
            array("form", null),
        );
    }

    /**
     * Data provider
     *
     * @return array
     */
    public static function dataAssignRef()
    {
        // $function, $key, $expect, $dbpreload=null, $post=null, $hash="post",
        return array(
            array(
                "showList",
                "lists",
                array(
                    "state" => "grid.state",
                    "order_Dir" => "DESC",
                    "order" => "t.id",
                    "search" => "hello",
                    "search_filter" => "p.name",
                    "search_options" => array(
                        0 => "select.option",
                        1 => "select.option",
                        2 => "select.option",
                        3 => "select.option",
                        4 => "select.option",
                    ),
                    "search_options_default" => "name",
                    "wCompCodes" => array(
                        0 => "Hours",
                    ),
                    "wCompEnable" => 0,
                ),
                null,
                array(
                    "filter_state" => "P",
                    "search" => "hello",
                ),
            ),
            array(
                "showList",
                "lists",
                array(
                    "state" => "grid.state",
                    "order_Dir" => "DESC",
                    "order" => "t.id",
                    "search" => "none",
                    "search_filter" => "m.name",
                    "search_options" => array(
                        0 => "select.option",
                        1 => "select.option",
                        2 => "select.option",
                        3 => "select.option",
                        4 => "select.option",
                    ),
                    "search_options_default" => "name",
                    "wCompCodes" => array(
                        0 => "Hours",
                    ),
                    "wCompEnable" => 0,
                ),
                null,
                array(
                    "filter_state" => "U",
                    "search" => "none",
                    "search_filter" => "m.name",
                ),
            ),
        );
    }

}

?>

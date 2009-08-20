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
 * @copyright  2008-2009 Hunt Utilities Group, LLC
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    SVN: $Id$
 * @link       https://dev.hugllc.com/index.php/Project:ComTimeclock:JoomlaUI
 */

/** Require the JoomlaMock stuff */
require_once dirname(__FILE__).'/../../JoomlaMock/joomla.php';
require_once dirname(__FILE__).'/../../JoomlaMock/testCases/JControllerTest.php';
/** Require the module under test */
require_once dirname(__FILE__).'/../../../site/controllers/preferences.php';

/**
 * Test class for driver.
 * Generated by PHPUnit_Util_Skeleton on 2007-10-30 at 08:44:25.
 *
 * @category   Test
 * @package    ComTimeclockTest
 * @subpackage Test
 * @author     Scott Price <prices@hugllc.com>
 * @copyright  2008-2009 Hunt Utilities Group, LLC
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link       https://dev.hugllc.com/index.php/Project:ComTimeclock:JoomlaUI
 */
class ComTimeclockSiteControllerPreferencesTest extends JControllerTest
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
        $this->o = new TimeclockControllerPreferences();
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
        );
    }

    /**
     * Data provider
     *
     * @return array
     */
    public static function dataRegisterTask()
    {
        return array(
        );
    }


    /**
     * Data provider
     *
     * @return array
     */
    public static function dataStoreTasks()
    {
        return array(
            array(
                "save",
                true,
                array(
                    "link" => "index.php?option=com_timeclock"
                             ."&controller=preferences",
                    "msg" => "Preferences Saved!"
                ),
                true
            ),
            array(
                "save",
                false,
                array(
                    "link" => "index.php?option=com_timeclock"
                             ."&controller=preferences",
                    "msg" => "Error Saving Preferences"
                ),
                true
            ),
            array(
                "save",
                false,
                array(
                    "link" => "index.php",
                    "msg" => "Bad form token.  Please try again."
                ),
                false
            ),
        );
    }


    /**
     * Tests to make sure the store tasks are redirecting properly
     *
     * @param string $task       the method name to call
     * @param bool   $storeRet   The return that "store" should give
     * @param array  $expect     The expected return from setRedirect
     * @param bool   $checkToken The return from JRequest::checkToken()
     *
     * @dataProvider dataStoreTasks()
     * @return null
     */
    public function testStoreTasks($task, $storeRet, $expect, $checkToken=true)
    {
        $GLOBALS["JModel"]["actionReturn"] = $storeRet;
        $GLOBALS["JRequest"]["checkToken"] = $checkToken;
        $this->o->$task();
        $this->assertSame($expect, $GLOBALS["JController"]["setRedirect"]);
    }

}

?>
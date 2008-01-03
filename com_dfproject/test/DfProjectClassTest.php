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
 * @package    TimeclockTest
 * @subpackage Test
 * @author     Scott Price <prices@hugllc.com>
 * @copyright  2007 Hunt Utilities Group, LLC
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    SVN: $Id$    
 * @link       https://dev.hugllc.com/index.php/Project:Timeclock
 */

// Call DfProjectClassTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "DfProjectClassTest::main");
}

/** The test case class */
require_once "PHPUnit/Framework/TestCase.php";
/** The test suite class */
require_once "PHPUnit/Framework/TestSuite.php";
require_once dirname(__FILE__).'/../dfproject.class.php';
require_once dirname(__FILE__).'/../../test/JoomlaMock/joomla.php';
require_once dirname(__FILE__).'/../../test/JoomlaMock/JoomlaTestCase.php';

/**
 * Test class for driver.
 * Generated by PHPUnit_Util_Skeleton on 2007-10-30 at 08:44:25.
 *
 * @category   Test
 * @package    TimeclockTest
 * @subpackage Test
 * @author     Scott Price <prices@hugllc.com>
 * @copyright  2007 Hunt Utilities Group, LLC
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link       https://dev.hugllc.com/index.php/Project:Timeclock
 */
class DfProjectClassTest extends JoomlaTestCase
{
    /**
     * Runs the test methods of this class.
     *
     * @return void
     *
     * @access public
     * @static
     */
    public static function main() 
    {
        include_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("DfProjectClassTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     *
     * @access protected
     */
    protected function setUp() 
    {
        global $database;
        parent::setUp();
        $this->o = new project();
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     *
     * @access protected
     */
    protected function tearDown() 
    {
        parent::tearDown();
        unset($this->o);
    }

    /**
     * Checks to make sure the table is set correctly
     *
     * @return void
     */
    public function testTable() 
    {
        $this->assertSame("#__dfproject", $this->readAttribute($this->o, "_tbl"));
    }
    /**
     * Checks to make sure the id is set correctly
     *
     * @return void
     */
    public function testId() 
    {
        $this->assertSame("id", $this->readAttribute($this->o, "_tbl_key"));
    }
    /**
     * Checks to make sure the id is set correctly
     *
     * @return void
     */
    public function testUserTable() 
    {
        $this->assertSame("#__dfproject_users", $this->readAttribute($this->o, "_users_tbl"));
    }
    /**
     * Checks to make sure the id is set correctly
     *
     * @return void
     */
    public function testWcTable() 
    {
        $this->assertSame("#__dfproject_workers_comp", $this->readAttribute($this->o, "_wc_tbl"));
    }

    /**
     * dataProvider for testFlushCache
     *
     * @return array
     */
    /*
    public static function dataFlushCache() 
    {
        return array(
            array(array(1,2,3,4), null, array()),
        );
    }
    */
    /**
     * test registerDriver
     *
     * @param mixed $date   The date to feed the function
     * @param bool  $expect The result to expect
     *
     * @return void
     *
     * @dataProvider dataFlushCache
     */
    /*
    public function testFlushCache($cache, $type, $expect) 
    {
        $_SESSION['DfProject'] = $cache;
        $this->o->flushCache($type);
        $this->assertSame($expect, $_SESSION['DfProject']);
    }
    */

}

// Call DfProjectClassTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "DfProjectClassTest::main") {
    DfProjectClassTest::main();
}

?>

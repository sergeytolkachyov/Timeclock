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
 * @version    SVN: $Id: 95da6790de129908943f3c30a5a83ac6bf9c84ed $
 * @link       https://dev.hugllc.com/index.php/Project:JoomlaMock
 */

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
class ComponentXmlTest extends PHPUnit_Framework_TestCase
{
    /** The option */
    public static $option;
    /** @var string The name of the xml file */
    static $xml = "timeclock.xml";

    /** @var string another place to get this file name */
    public $xmlfile = "timeclock.xml";

    /** @var string The name of the component */
    public $comName = "COM_TIMECLOCK";
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
        parent::setUp();
        $this->basedir = realpath(dirname(__FILE__)."/../../com_timeclock/");
    }
    /**
     * Data provider for testFiles
     *
     * @return array()
     */
    public static function dataFiles()
    {
        return self::getDataFiles(
            dirname(__FILE__)."/../../com_timeclock/".self::$xml
        );
    }

    /**
     * Data provider for testFiles
     *
     * @return array()
     */
    static public function dataFilePresent()
    {

        return array(
            array("site/LICENSE.TXT"),
        );
    }


    /**
     * Data provider for testFiles
     *
     * @return array()
     */
    static public function dataFilePresentXml()
    {
        $site = ComponentXmlTest::getFilesInDir(
            dirname(__FILE__)."/../../com_timeclock/site",
            true,
            ""
        );
        $admin = ComponentXmlTest::getFilesInDir(
            dirname(__FILE__)."/../../com_timeclock/admin",
            true,
            ""
        );
        $ret = array();
        foreach ($site as $file) {
            $ret[] = array("site", $file);
        }
        foreach ($admin as $file) {
            $ret[] = array("admin", $file);
        }
        return $ret;
    }
    /**
     * Tests the users name
     *
     * @return null
     *
     *
     */
    public function testName()
    {
        $xmlstr = file_get_contents($this->basedir."/".$this->xmlfile);
        $xml = new SimpleXMLElement($xmlstr);
        $this->assertSame(
            $this->comName, JText::_((string)$xml->name)
        );
    }

    /**
     * Tests the users name
     *
     * @return null
     *
     *
     */
    public function testVersion()
    {
        $xmlstr = file_get_contents($this->basedir."/".$this->xmlfile);
        $xml = new SimpleXMLElement($xmlstr);
        $version = trim((string)$xml["version"]);
        $this->assertSame("2.5", substr($version, 0, 3));
    }

    /**
     * Data provider for testName
     *
     * @param string $name The name of the xml file
     *
     * @return array()
     */
    static public function getDataFiles($name)
    {
        global $mainframe;
        $xmlstr = file_get_contents($name);
        $xml = new SimpleXMLElement($xmlstr);
        $folder = (string)$xml->files["folder"];
        foreach ($xml->files->filename as $file) {
            $ret[] = array($folder."/".(string)$file);
        }
        $folder = (string)$xml->administration->files["folder"];
        foreach ($xml->administration->files->filename as $file) {
            $ret[] = array($folder."/".(string)$file);
        }
        if (is_array($xml->install->sql->file)) {
            foreach ($xml->install->sql->file as $file) {
                $ret[] = array("admin/".(string)$file);
            }
        }
        if (is_array($xml->uninstall->sql->file)) {
            foreach ($xml->uninstall->sql->file as $file) {
                $ret[] = array("admin/".(string)$file);
            }
        }
        foreach ($xml->installfile as $file) {
            $ret[] = array((string)$file);
        }
        foreach ($xml->uninstallfile as $file) {
            $ret[] = array((string)$file);
        }
        $ret[] = array((string)$xml->installfile->filename);
        $ret[] = array((string)$xml->uninstallfile->filename);
        return $ret;
    }

    /**
     * Tests the users name
     *
     * @param string $file The file name to check
     *
     * @return null
     *
     * @dataProvider dataFiles()
     */
    public function testFiles($file)
    {
        $this->assertFileExists($this->basedir.DIRECTORY_SEPARATOR.$file);
    }


    /**
     * gets all of the PHP files in the directory
     *
     * @param string $dir       the directory to look in.
     * @param bool   $recursive Whether to recurse through the directories
     * @param string $fakedir   Internal use only
     *
     * @return array
     */
    static public function getFilesInDir($dir, $recursive=true, $fakedir="")
    {
        if ((substr($fakedir, -1) !== "/") && !empty($fakedir)) $fakedir .= "/";
        @$d = dir($dir);
        $filearray = array();
        while (is_object($d) && (false !== ($file = $d->read()))) {
            if (is_dir($dir."/".$file) && $recursive) {
                if (substr($file, 0, 1) == ".") continue;
                if (substr($file, 0, 4) == "test") continue;
                $filearray = array_merge($filearray, self::getFilesInDir($dir."/".$file, $recursive, $fakedir.$file));
                $filearray[] = $fakedir.$file."/index.html";
            } else {
                if (substr($file, -4) == ".php") $filearray[] = $fakedir.$file;
            }
        }
        return $filearray;
    }

    /**
     * Tests the users name
     *
     * @param string $file The file name to check
     *
     * @return null
     *
     * @dataProvider dataFilePresent()
     */
    public function testFilePresent($file)
    {
        $file = $this->basedir.DIRECTORY_SEPARATOR.$file;
        $this->assertFileExists(
            $file,
            "File $file does not exist"
        );
    }

    /**
     * Tests the users name
     *
     * @param string $dir  The directory
     * @param string $file The file name to check
     *
     * @return null
     *
     * @dataProvider dataFilePresentXml()
     */
    public function testFilePresentXml($dir, $file)
    {
        $xmlstr = file_get_contents($this->basedir."/".$this->xmlfile);
        $xml = new SimpleXMLElement($xmlstr);
        $files = array();
        $place = ($dir == "admin") ? $xml->administration->files->filename : $xml->files->filename;
        foreach ($place as $f) {
            $files[] = (string)$f;
        }
        $folders = array();
        $place = ($dir == "admin") ? $xml->administration->files->folder : $xml->files->folder;
        foreach ($place as $f) {
            $folders[] = (string)$f;
        }
        $sep = "";
        $fold = explode(DIRECTORY_SEPARATOR, $file);
        foreach ($fold as $d) {
            $folder = $sep.$d;
            $sep = DIRECTORY_SEPARATOR;
            if (array_search($folder, $folders) !== false) {
                $this->assertContains($folder, $folders);
                return;
            }
        }
        $this->assertContains($file, $files);
    }


    /**
     * Data provider for testName
     *
     * @param string $option the Option (component)
     *
     * @return array()
     */
    static public function dataQueries($option)
    {
        $base = dirname(__FILE__)."/../../com_timeclock/";
        $xmlstr = file_get_contents(
            $base.self::$xml
        );
        $xml = new SimpleXMLElement($xmlstr);
        $ret = array();
        foreach ($xml->install->sql->file as $q) {
            $ret[] = array(
                @file_get_contents($base."/admin/".$q), $base."/admin/".$q
            );
        }
        if (empty($ret)) {
            $ret[] = array(null);
        }
        return $ret;
    }

    /**
     * Tests the users name
     *
     * @param string $sql The file name to check
     *
     * @return null
     *
     * @dataProvider dataQueries()
     */
    public function testQueriesNotExists($sql)
    {
        if (is_string($sql)) {
            $this->assertContains(" IF NOT EXISTS ", $sql);
        }
    }
    /**
     * Tests the users name
     *
     * @param string $sql The file name to check
     *
     * @return null
     *
     * @dataProvider dataQueries()
     */
    public function testQueriesTable($sql)
    {
        if (is_string($sql)) {
            $this->assertContains("#__timeclock_", $sql);
        }
    }
    /**
     * Tests the users name
     *
     * @param string $sql The file name to check
     *
     * @return null
     *
     * @dataProvider dataQueries()
     */
    public function testQueriesCharset($sql)
    {
        if (is_string($sql)) {
            $this->assertContains("CHARSET=utf8", $sql);
        }
    }

}

?>

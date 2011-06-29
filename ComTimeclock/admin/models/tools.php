<?php
/**
 * This component is the user interface for the endpoints
 *
 * PHP Version 5
 *
 * <pre>
 * com_ComTimeclock is a Joomla! 1.6 component
 * Copyright (C) 2008-2009, 2011 Hunt Utilities Group, LLC
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
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA  02110-1301, USA.
 * </pre>
 *
 * @category   UI
 * @package    ComTimeclock
 * @subpackage Com_Timeclock
 * @author     Scott Price <prices@hugllc.com>
 * @copyright  2008-2009, 2011 Hunt Utilities Group, LLC
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    SVN: $Id$
 * @link       https://dev.hugllc.com/index.php/Project:ComTimeclock
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');
/** Include the project stuff */
$base      = dirname(JApplicationHelper::getPath("front", "com_timeclock"));
$adminbase = dirname(JApplicationHelper::getPath("admin", "com_timeclock"));

require_once $adminbase.DS.'tables'.DS.'timeclockcustomers.php';
require_once $adminbase.DS.'tables'.DS.'timeclockprefs.php';
require_once $adminbase.DS.'tables'.DS.'timeclockprojects.php';
require_once $adminbase.DS.'tables'.DS.'timeclockusers.php';
require_once $base.DS.'tables'.DS.'timeclocktimesheet.php';

/**
 * ComTimeclock model
 *
 * @category   UI
 * @package    ComTimeclock
 * @subpackage Com_Timeclock
 * @author     Scott Price <prices@hugllc.com>
 * @copyright  2008-2009, 2011 Hunt Utilities Group, LLC
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link       https://dev.hugllc.com/index.php/Project:ComTimeclock
 */
class TimeclockAdminModelTools extends JModel
{
    /** The ID to load */
    private $_id = -1;
    var $_allQuery = "SELECT c.*
                      FROM #__timeclock_customers AS c ";
    /**
    * Constructor that retrieves the ID from the request
    *
    * @return    void
    */
    function __construct()
    {
        parent::__construct();
        $this->_customers =& JTable::getInstance("TimeclockCustomers", "Table");
        $this->_prefs =& JTable::getInstance("TimeclockPrefs", "Table");
        $this->_projects =& JTable::getInstance("TimeclockProjects", "Table");
        $this->_users =& JTable::getInstance("TimeclockUsers", "Table");
        $this->_timesheet =& JTable::getInstance("TimeclockTimesheet", "Table");
        $this->_db =& JFactory::getDBO();

    }

    /**
    * This function goes through and checks all of the databases
    *
    * @return array The problem array
    */
    function convertPrefs()
    {
        $ret = array(
            "System Preferences" => $this->_convertSysPrefs(),
            "User Preferences" => $this->_convertUserPrefs(),
        );
        return $ret;
    }
    /**
    * This function goes through and checks the prefs
    *
    * @return array The problem array
    */
    private function _convertSysPrefs()
    {
        $test = array(
            "name" => "Converting System Prefs",
            "result" => true,
            "description" => "This converts the system preferences",
        );
        $component = JComponentHelper::getComponent("com_timeclock");
        $row = JTable::getInstance('extension');
        if ($row->load($component->id)) {
            $table = $this->getTable("TimeclockPrefs");
            $table->load(-1);
            $row->set('params', json_encode($table->prefs));
            $row->store();
        } else {
            $test["result"] = false;
        }

        return array($test);
    }
    /**
    * This function goes through and checks the prefs
    *
    * @return array The problem array
    */
    private function _convertUserPrefs()
    {
        $ret = $this->_convertPrefsGetUsers();
        foreach ((array)$ret as $row) {
            $test[] = $this->_convertUserPref($row);
        }
        return $test;
    }
    /**
    * This function goes through and checks the prefs
    *
    * @param array $user The user to convert
    *
    * @return array The problem array
    */
    private function _convertUserPref($user)
    {
        $test = array(
            "name" => $user["name"],
            "result" => true,
            "description" => "",
        );
        $table = $this->getTable("TimeclockPrefs");
        $table->load($user["id"]);
        foreach((array)$table->prefs as $okey => $value) {
            if (strpos($okey, "admin_") === 0) {
                $key = str_replace("admin_", "", $okey);
                $prefix = "admin.";
            } else if (strpos($okey, "admin_") === 0) {
                $key = str_replace("user_", "", $okey);
                $prefix = "user.";
            } else {
                continue;
            }
            if ($key === "ptoCarryOver") {
                foreach ((array)$value as $year => $amount) {
                    plgUserTimeclock::setParamValue(
                        $key."_".$year."_amount", $amount, $user["id"], $prefix
                    );
                }
                plgUserTimeclock::setParamValue(
                    $key, "array()", $user["id"], "admin."
                );

            } else if ($key === "ptoCarryOverExpire") {
                foreach ((array)$value as $year => $expire) {
                    plgUserTimeclock::setParamValue(
                        "ptoCarryOver_".$year."_expires", $expire, $user["id"], $prefix
                    );
                }
            } else {
                plgUserTimeclock::setParamValue(
                    $key, (string)$value, $user["id"], $prefix
                );
            }
            $test["description"] .= "$okey -> $key<br />";
        }
        $vals = array(
            "manager" => "manager", "startDate" => "startDate",
            "endDate" => "endDate", "published" => "active",
        );
        foreach ($vals as $old => $new) {
            $value = (string)$table->$old;
            if ($value == "0000-00-00") {
                $value = "";
            }
            plgUserTimeclock::setParamValue(
                $new, $value, $user["id"], "admin."
            );
            $test["description"] .= "$old -> $new<br />";
        }

        foreach((array)$table->history as $okey => $dates) {
            foreach((array)$dates as $date => $value) {
                $key = str_replace("admin_", "", $okey);
                $prefix = "history_";
                if ($key === "ptoCarryOver") {
                    foreach ((array)$value as $year => $amount) {
                        plgUserTimeclock::setParamValue(
                            $prefix.$key."*".$year."*amount_".$date, $amount, $user["id"], "admin."
                        );
                    }
                } else if ($key === "ptoCarryOverExpire") {
                    foreach ((array)$value as $year => $expire) {
                        plgUserTimeclock::setParamValue(
                            $prefix."ptoCarryOver*".$year."*expires_".$date, $expire, $user["id"], "admin."
                        );
                    }
                } else {
                    plgUserTimeclock::setParamValue(
                        $prefix.$key."_".$date, (string)$value, $user["id"], "admin."
                    );
                }
                plgUserTimeclock::setParamValue(
                    "history", "array()", $user["id"], "admin."
                );
                $test["description"] .= "$okey -> $prefix$key<br />";
            }
        }
        /*
            if (array_search($row["parent_type"], $valid_array) === false) {
                $test["result"] = false;
                $test["log"] .= "Project ".$row["name"]." has invalid parent "
                                .$row["parent_name"]."\n";
            }
        */
        return $test;
    }
    /**
    * This checks for users in categories.
    *
    * @return array The problem array
    */
    private function _convertPrefsGetUsers()
    {
        static $data;
        if (!is_array($data)) {
            $data = array();
            $sql = "SELECT id, name FROM #__users";
            $this->_db->setQuery($sql);
            $data = $this->_db->loadAssocList();
        }
        return $data;
    }
    /**
    * This function goes through and checks all of the databases
    *
    * @return array The problem array
    */
    function dbCheck()
    {
        $ret = array(
            "Preferences" => $this->_dbCheckPrefs(),
            "Customers" => $this->_dbCheckCustomers(),
            "Projects" => $this->_dbCheckProjects(),
            "Timesheets" => $this->_dbCheckTimesheets(),
            "Users" => $this->_dbCheckUsers(),
        );
        return $ret;
    }



    /**
    * This function goes through and checks the prefs
    *
    * @return array The problem array
    */
    private function _dbCheckPrefs()
    {
        $ret = array();
        return $ret;
    }

    /**
    * This function goes through and checks the prefs
    *
    * @return array The problem array
    */
    private function _dbCheckCustomers()
    {
        $ret = array();
        return $ret;
    }

    /**
    * This function goes through and checks the prefs
    *
    * @return array The problem array
    */
    private function _dbCheckProjects()
    {
        $ret = array();
        $ret[] = $this->_dbCheckProjectsBadType();
        $ret[] = $this->_dbCheckProjectsBadManager();
        return $ret;
    }
    /**
    * This function goes through and checks the prefs
    *
    * @return array The problem array
    */
    private function _dbCheckProjectsBadType()
    {
        $test = array(
            "name" => "Checking for Invalid Parent Types",
            "result" => true,
            "description" => "Fix: Please go into the project editor and select a "
                            ." valid parent project.",
        );
        $ret = $this->_dbCheckProjectsGetProjects();
        $valid_array = array("CATEGORY");
        foreach ((array)$ret as $row) {
            if (is_null($row["parent_type"])) {
                continue;
            }
            if (array_search($row["parent_type"], $valid_array) === false) {
                $test["result"] = false;
                $test["log"] .= "Project ".$row["name"]." has invalid parent "
                                .$row["parent_name"]."\n";
            }
        }
        return $test;
    }
    /**
    * This function goes through and checks the prefs
    *
    * @return array The problem array
    */
    private function _dbCheckProjectsBadManager()
    {
        $test = array(
            "name" => "Checking for Missing Managers",
            "result" => true,
            "description" => "Fix: Please go into the project editor and select a "
                            ." valid project manager.",
        );
        $ret = $this->_dbCheckProjectsGetProjects();

        foreach ((array)$ret as $row) {
            if (($row["manager"] != 0) && is_null($row["manager_name"])) {
                $test["result"] = false;
                $test["log"] .= "Project ".$row["name"]." has invalid parent "
                                .$row["parent_name"]."\n";
            }
        }
        return $test;
    }
    /**
    * This checks for users in categories.
    *
    * @return array The problem array
    */
    private function _dbCheckProjectsGetProjects()
    {
        static $data;
        if (!is_array($data)) {
            $sql = "SELECT p.*, u.name as manager_name, pp.type as parent_type,
                    pp.name as parent_name
                    FROM #__timeclock_projects as p
                    LEFT JOIN #__users as u
                    ON p.manager = u.id
                    LEFT JOIN #__timeclock_projects as pp
                    ON p.parent_id = pp.id";
            $this->_db->setQuery($sql);
            $data = $this->_db->loadAssocList();
        }
        return $data;
    }

    /**
    * This function goes through and checks the prefs
    *
    * @return array The problem array
    */
    private function _dbCheckTimesheets()
    {
        $ret = array();
        $ret[] = $this->_dbCheckTimesheetsNoDate();
        $ret[] = $this->_dbCheckTimesheetsBadProject();
        $ret[] = $this->_dbCheckTimesheetsBadUser();
        return $ret;
    }
    /**
    * This function goes through and checks the prefs
    *
    * @return array The problem array
    */
    private function _dbCheckTimesheetsBadProject()
    {
        $test = array(
            "name" => "Checking for Timesheets attached to non-existant project",
            "result" => true,
            "description" => "These should be fixed in the timesheet entry in the "
                ." administrator panel.  These will show up on reports and no where "
                ." else.",
        );
        $ret = $this->_dbCheckTimesheetsGetTimesheet(
            " p.name IS NULL "
        );
        foreach ((array)$ret as $row) {
            $test["result"] = false;
            $test["log"] .= "Record #".$row["id"];
            $test["log"] .= " (".$row["user_name"]." on ".$row["project_name"].") ";
            $test["log"] .= " has no attached project\n";
        }
        return $test;
    }
    /**
    * This function goes through and checks the prefs
    *
    * @return array The problem array
    */
    private function _dbCheckTimesheetsBadUser()
    {
        $test = array(
            "name" => "Checking for Timesheets attached to non-existant user",
            "result" => true,
            "description" => "These should be fixed in the timesheet entry in the "
                ." administrator panel.  These will show up on reports and no where "
                ." else.",
        );
        $ret = $this->_dbCheckTimesheetsGetTimesheet(
            " u.name IS NULL "
        );
        foreach ((array)$ret as $row) {
            $test["result"] = false;
            $test["log"] .= "Record #".$row["id"];
            $test["log"] .= " (".$row["user_name"]." on ".$row["project_name"].") ";
            $test["log"] .= " has no attached user\n";
        }
        return $test;
    }
    /**
    * This function goes through and checks the prefs
    *
    * @return array The problem array
    */
    private function _dbCheckTimesheetsNoDate()
    {
        $test = array(
            "name" => "Checking for Timesheets with no date",
            "result" => true,
            "description" => "These should be fixed in the timesheet entry in the "
                ." administrator panel.  These will show up on reports and no where "
                ." else.",
        );
        $ret = $this->_dbCheckTimesheetsGetTimesheet(
            " worked = '0000-00-00' "
        );
        foreach ((array)$ret as $row) {
            $test["result"] = false;
            $test["log"] .= "Record #".$row["id"];
            $test["log"] .= " (".$row["user_name"]." on ".$row["project_name"].") ";
            $test["log"] .= " has no date\n";
        }
        return $test;
    }
    /**
    * This checks for users in categories.
    *
    * @param string $where The where clause to use
    *
    * @return array The problem array
    */
    private function _dbCheckTimesheetsGetTimesheet($where=null)
    {
        static $data;
        if (!is_array($data[$where])) {
            $sql = "select t.*, u.name as user_name, p.name as project_name
                    from #__timeclock_timesheet as t
                    LEFT JOIN #__timeclock_projects as p
                    ON t.project_id = p.id
                    LEFT JOIN #__users as u
                    ON u.id = t.created_by ";
            if (!empty($where)) {
                $sql .= " WHERE ".$where;
            }
            $this->_db->setQuery($sql);
            $data[$where] = $this->_db->loadAssocList();
        }
        return $data[$where];
    }

    /**
    * This function goes through and checks the prefs
    *
    * @return array The problem array
    */
    private function _dbCheckUsers()
    {
        $ret = array();
        $ret[] = $this->_dbCheckUsersCategories();
        $ret[] = $this->_dbCheckUsersExist();
        $ret[] = $this->_dbCheckUsersProjExist();
        return $ret;
    }

    /**
    * This checks for users in categories.
    *
    * @return array The problem array
    */
    private function _dbCheckUsersGetUsers()
    {
        static $data;
        if (!is_array($data)) {
            $sql = "select u.*, p.*, u.id as proj_id, ju.name as user_name
                    from #__timeclock_users as u
                    LEFT JOIN #__timeclock_projects as p
                    ON u.id = p.id
                    LEFT JOIN #__users as ju
                    ON ju.id = u.user_id";
            $this->_db->setQuery($sql);
            $data = $this->_db->loadAssocList();
        }
        return $data;
    }
    /**
    * This checks for users in categories.
    *
    * @return array The problem array
    */
    private function _dbCheckUsersCategories()
    {
        $test = array(
            "name" => "Checking for users attached to categories",
            "result" => true,
            "description" => "If you edit the user in 'User Configurations' you can"
                ." remove them from the offending projects.",
        );
        $ret = $this->_dbCheckUsersGetUsers();
        foreach ((array)$ret as $row) {
            if ($row["type"] == "CATEGORY") {
                $test["result"] = false;
                $test["log"]   .= "User ".$row["user_name"]
                    ." found in ".$row["name"]."\n";
            }
        }
        return $test;
    }
    /**
    * This checks for users in categories.
    *
    * @return array The problem array
    */
    private function _dbCheckUsersExist()
    {
        $test = array(
            "name" => "Checking that all users attached to projects exist",
            "result" => true,
            "description" => "If this fails data is lost.  The database entries for "
                ." this should be removed with your favorite database tool.",
        );
        $ret = $this->_dbCheckUsersGetUsers();
        foreach ((array)$ret as $row) {
            if (is_null($row["user_name"])) {
                $test["result"] = false;
                $test["log"]   .= "User #".$row["user_id"]." does not exist.\n";
            }
        }
        return $test;
    }
    /**
    * This checks for users in categories.
    *
    * @return array The problem array
    */
    private function _dbCheckUsersProjExist()
    {
        $test = array(
            "name" => "Checking that all projects with users attached exist",
            "result" => true,
            "description" => "If this fails data is lost.  The database entries for "
                ." this should be removed with your favorite database tool.",
        );
        $ret = $this->_dbCheckUsersGetUsers();
        foreach ((array)$ret as $row) {
            if (is_null($row["id"])) {
                $test["result"] = false;
                $test["log"]   .= "Project #".$row["proj_id"]." does not exist.\n";
            }
        }
        return $test;
    }
}

?>

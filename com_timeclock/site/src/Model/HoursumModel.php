<?php
/**
 * This component is for tracking tim
 *
 * PHP Version 5
 *
 * <pre>
 * com_timeclock is a Joomla! 3.1 component
 * Copyright (C) 2023 Hunt Utilities Group, LLC
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
 * @category   Timeclock
 * @package    Timeclock
 * @subpackage com_timeclock
 * @author     Scott Price <prices@hugllc.com>
 * @copyright  2023 Hunt Utilities Group, LLC
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    GIT: $Id: 1d23523e3892a5809ebfd024ca10359070d0803a $
 * @link       https://dev.hugllc.com/index.php/Project:ComTimeclock
 */
namespace HUGLLC\Component\Timeclock\Site\Model;

defined( '_JEXEC' ) or die();

/**
 * Description Here
 *
 * @category   Timeclock
 * @package    Timeclock
 * @subpackage com_timeclock
 * @author     Scott Price <prices@hugllc.com>
 * @copyright  2023 Hunt Utilities Group, LLC
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link       https://dev.hugllc.com/index.php/Project:ComTimeclock
 */
class HoursumModel extends ReportModel
{    
    /** This is the type of report */
    protected $type = "hoursum";

    /**
    * Build query and where for protected _getList function and return a list
    *
    * @return array An array of results.
    */
    public function listItems()
    {
        $query = $this->_buildQuery();
        $query = $this->_buildWhere($query);
        $list  = $this->_getList($query);
        $users = $this->listUsers();
        $this->listProjects();
        $return = array(
            "total"       => 0,
        );
        $ids = array(
            "department"   => "department_id",
            "customer"     => "customer_id",
            "user_manager" => "user_manager_id",
            "proj_manager" => "proj_manager_id",
            "category"     => "cat_id",
            "project"      => "proj_id",
            "user"         => "user_id",
            "type"         => "project_type",
        );
        // Now add in stuff
        foreach ($list as $row) {
            $this->checkTimesheet($row);
            $user_id         = !is_null($row->user_id) ? (int)$row->user_id : (int)$row->worked_by;
            $proj_id         = (int)$row->project_id;

            
            $proj_manager_id = (int)$row->proj_manager_id;
            $user_manager_id = (isset($users[$user_id]->timeclock["manager"])) ? (int)$users[$user_id]->timeclock["manager"] : 0;
            $department_id   = (int)$row->department_id;
            $customer_id     = (int)$row->customer_id;
            $cat_id          = (int)$row->cat_id;
            $project_type    = $row->project_type;

            $this->extraUser($user_id);
            $this->extraUser($proj_manager_id);
            $this->extraUser($user_manager_id);

            foreach ($ids as $key => $var) {
                $return[$key]        = isset($return[$key]) ? $return[$key] : array();
                $return[$key][$$var] = isset($return[$key][$$var]) ? $return[$key][$$var] : 0;
                $return[$key][$$var] += $row->hours;
            }
            $return["total"]  += $row->hours;
            for ($i = 1; $i <= 6; $i++) {
                $hours = (float)$row->{"hours".$i};
                $code  = (int)$row->{"wcCode".$i};
                if ($hours != 0) {
                    $return["wcomp"][$code]  = isset($return["wcomp"][$code]) ? $return["wcomp"][$code] : 0;
                    $return["wcomp"][$code] += $hours;
                }
            }
        }
        return $return;
    }
}
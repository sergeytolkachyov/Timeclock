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
jimport("joomla.html.pane");

TimeclockHelper::title(JText::_("User Configuration: <small><small>[ ".$this->user->name." ]</small></small>"));
JToolBarHelper::apply("users.apply");
JToolBarHelper::save("users.save");
JToolBarHelper::cancel("users.cancel");

?>
<form action="index.php" method="post" id="adminForm" id="adminForm">
<div style="float: right; width: 30%;">
<?php
$pane = JPane::getInstance("sliders");
echo $pane->startPane("project-pane");
echo $pane->startPanel(JText::_(COM_TIMECLOCK_ADD_PROJECTS), "addproject-page");
?>
<div style="padding: 5px;">
<?php
array_shift($this->lists["projects"]);
if (count($this->lists["projects"])) {
    print JHTML::_("select.genericList", $this->lists["projects"], "projid[]", 'multiple="multiple"', 'value', 'text', 0);
    ?><br />
        <button onClick="this.form.task.value='users.addproject';this.form.submit();">Add Projects</button>
    <?php
} else {
    print JText::_(COM_TIMECLOCK_NO_PROJECTS);
}
?>
</div>
<?php
echo $pane->endPanel();
echo $pane->startPanel(JText::_(COM_TIMECLOCK_ADD_PROJECTS_FROM_USER), "adduserproject-page");
?>
<div style="padding: 5px;">
    <?php print JHTML::_("select.genericList", $this->lists["users"], "user_id", 'onChange="this.form.task.value=\'users.adduserproject\';this.form.submit();"', 'value', 'text', 0); ?>
</div>
<?php
echo $pane->endPanel();
echo $pane->startPanel(JText::_(COM_TIMECLOCK_REMOVE_PROJECTS), "project-page");
?>
<div style="padding: 5px;">
<?php
$options = array();
foreach ($this->lists["userProjects"] as $proj) {
     $options[] = JHTML::_("select.option", $proj->id, $proj->name);
}
print JHTML::_("select.genericList", $options, "remove_projid[]", 'multiple="multiple"', 'value', 'text', 0);
    ?><br />
        <button onClick="this.form.task.value='users.removeproject';this.form.submit();">Remove Projects</button>
</div>
<?php
echo $pane->endPanel();
echo $pane->endPane();
?>
</div>
<div>
    <table class="admintable">
        <tr>
            <td width="100" align="right" class="key">
                <label for="startDate">
                    <?php echo JText::_(COM_TIMECLOCK_START_DATE); ?>:
                </label>
            </td>
            <td style="white-space:nowrap;">
                <?php print JHTML::_("calendar", $this->row->startDate, "startDate", "startDate", "%Y-%m-%d", "");?>
            </td>
            <td>
                When this user starts
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="endDate">
                    <?php echo JText::_(COM_TIMECLOCK_END_DATE); ?>:
                </label>
            </td>
            <td style="white-space:nowrap;">
                <?php print JHTML::_("calendar", $this->row->endDate, "endDate", "endDate", "%Y-%m-%d", "");?>
            </td>
            <td>
                When this user leaves.  Leave blank if the user is still employed.
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="active">
                    <?php echo JText::_(COM_TIMECLOCK_ACTIVE); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("select.booleanList", "published", "", $this->row->published); ?>
            </td>
            <td>
                Is this user active in the timeclock.  'No' means they will not be able to access any
                sort of timeclock.
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="reports">
                    <?php echo JText::_(COM_TIMECLOCK_REPORTS); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("select.booleanList", "admin_reports", "", $this->row->prefs["admin_reports"]); ?>
            </td>
            <td>
                Can this user view reports.
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="manager">
                    <?php echo JText::_(COM_TIMECLOCK_MANAGER); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("select.genericList", $this->lists["manager"], "manager", '', 'value', 'text', $this->row->manager); ?>
            </td>
            <td>
                This is to set the supervisor for this user.  It is used in the reports.
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="type">
                    <?php echo JText::_(COM_TIMECLOCK_USER_STATUS); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("select.genericList", $this->lists["status"], "admin_status", "", 'value', 'text', $this->row->prefs["admin_status"]); ?>
            </td>
            <td>
                The status of the user
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="type">
                    <?php echo JText::_(COM_TIMECLOCK_PTO_CARRYOVER); ?>:
                </label>
            </td>
            <td>
                <?php foreach ($this->ptoCarryOver as $year => $value): ?>
                <div style="border: thin solid grey;">
                    <input type="text" name="admin_ptoCarryOver[<?php print $year; ?>]" size="7" maxlength="5" value="<?php print $value; ?>" />
                    <?php print JText::_(COM_TIMECLOCK_HOURS); ?>
                    <?php print JText::_(COM_TIMECLOCK_CARRIED_OVER_TO); ?>
                    <strong><?php print $year; ?></strong>
                    <div style="white-space: nowrap; margin-top: 0px;">
                        <?php print JText::_(COM_TIMECLOCK_EXPIRES); ?>
                        <?php print JHTML::_("calendar", $this->ptoCarryOverExpire[$year], "admin_ptoCarryOverExpire[$year]", "admin_ptoCarryOverExpire[$year]", "%Y-%m-%d", "");?>
                    </div>
                </div>
                <?php endforeach; ?>
            </td>
            <td>
                The amount of carryover and the date it expires.  The year listed is the year PTO
                is being carried into.
            </td>
        </tr>
<?php
if ($this->row->prefs["admin_status"] == "PARTTIME") {
    ?>
        <tr>
            <td width="100" align="right" class="key">
                <label for="holidayperc">
                    <?php echo JText::_(COM_TIMECLOCK_HOLIDAY_PAY); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("select.integerList", 0, 100, 10, "admin_holidayperc", "", $this->row->prefs["admin_holidayperc"]); ?>%
            </td>
            <td>
                The percentage of holiday pay this user gets
            </td>
        </tr>
    <?php
}
?>
        <tr>
            <td width="100" align="right" class="key" style="vertical-align:top;">
                <label for="projects">
                    <?php echo JText::_(COM_TIMECLOCK_PROJECTS); ?>:
                </label>
            </td>
            <td style="white-space: nowrap;">
<?php
foreach ($this->lists["userProjects"] as $proj) { ?>
                    <?php print sprintf("%04d", $proj->id).": ".$proj->name; ?><br />
    <?php
}
?>
            </td>
            <td>
                This is just a list of projects.
            </td>
        </tr>
        <tr>
            <td class="key" style="vertical-align:top;">
                <?php print JText::_(COM_TIMECLOCK_CHANGE_HISTORY); ?>:<br />
                (<?php print JText::_(COM_TIMECLOCK_OLD_VALUES); ?>)
            </td>
            <td colspan="2">
<?php
if (!is_array($this->row->history["timestamps"])) $this->row->history["timestamps"] = array();
krsort($this->row->history["timestamps"]);
foreach ($this->row->history["timestamps"] as $date => $user) { ?>
    <?php $index++; ?>
    <p >
        <div>
            <strong><?php print $user." <br /> ".$date; ?>:</strong>
            <a href="#" onClick="document.getElementById('effectiveDate<?php print $index; ?>').style.display='';document.getElementById('effectiveDate<?php print $index; ?>Set').value='1';">
                [<?php print JText::_(COM_TIMECLOCK_EDIT); ?>]
            </a>
        </div>
        <div id="effectiveDate<?php print $index; ?>" style="display: none;">
            <?php print JHTML::_("calendar", $date, "effectiveDate[$date]", "effectiveDate[$date]", "%Y-%m-%d %H:%M:%S", "");?>
            <input type="hidden" name="effectiveDateSet[<?php print $date; ?>]" id="effectiveDate<?php print $index; ?>Set" value="0" />
        </div>
    <?php
    foreach ($this->row->history as $key => $value) {
        if (!array_key_exists($date, $value)) continue;
        if ($key == "timestamps") continue;
        $p = $value[$date];
        if (is_array($p)) {
            $p = print_r($p, true);
        }
        print $key." = ".$p."<br />";
    }
    ?>
    </p>
    <?php
}
?>
            </td>
        </tr>
    </table>

</div>

<div class="clr"></div>
<input type="hidden" name="created" value="<?php print $this->row->created; ?>" />
<input type="hidden" name="created_by" value="<?php print $this->row->created_by; ?>" />
<input type="hidden" name="checked_out" value="<?php print $this->row->checked_out; ?>" />
<input type="hidden" name="checked_out_time" value="<?php print $this->row->checked_out_time; ?>" />

<input type="hidden" name="option" value="com_timeclock" />
<input type="hidden" name="id" value="<?php print $this->row->id; ?>" />
<input type="hidden" name="task" id="task" value="" />
<input type="hidden" name="controller" value="users" />
<?php print JHTML::_("form.token"); ?>
</form>

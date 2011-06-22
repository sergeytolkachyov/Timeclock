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

TimeclockHelper::title(JText::_(COM_TIMECLOCK_TIMECLOCK_PREFS));

?>
<form action="index.php" method="post" id="adminForm" name="adminForm">
<div>
<?php
    $pane = JPane::getInstance("tabs");
    echo $pane->startPane("config-pane");
    echo $pane->startPanel(JText::_(COM_TIMECLOCK_USER_SETTINGS), "user-page");
?>
    <table class="admintable">
        <tr>
            <td width="100" align="right" class="key">
                <label for="maxDailyHours">
                    <?php echo JText::_(COM_TIMECLOCK_MAX_DAILY_HOURS); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("select.integerList", 1, 24, 1, "prefs[maxDailyHours]", "", $this->prefs["maxDailyHours"]); ?>
            </td>
            <td>
                <?php print JText::_(COM_TIMECLOCK_MAX_DAILY_HOURS_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="decimalPlaces">
                    <?php echo JText::_(COM_TIMECLOCK_DECIMAL_PLACES); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("select.integerList", 0, 5, 1, "prefs[decimalPlaces]", "", $this->prefs["decimalPlaces"]); ?>
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_DECIMAL_PLACES_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="decimalPlaces">
                    <?php echo JText::_(COM_TIMECLOCK_MINIMUM_NOTE); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" size="10" maxlength="50" name="prefs[minNoteChars]" id="prefs_minNoteChars" value="<?php echo $this->prefs["minNoteChars"];?>" /> Characters
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_MINIMUM_NOTE_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key" style="vertical-align: top;">
                <label for="userTypes">
                    <?php echo JText::_(COM_TIMECLOCK_USER_TYPES); ?>:
                </label>
            </td>
            <td>
                <textarea class="text_area" type="text" name="prefs[userTypes]" id="prefs_userTypes" cols="50" rows="5"><?php echo $this->prefs["userTypes"];?></textarea>
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_USER_TYPES_DESC); ?>
            </td>
        </tr>
    </table>
<?php
    echo $pane->endPanel();
    echo $pane->startPanel(JText::_(COM_TIMECLOCK_TIMESHEET), "payperiod-pane");

    $firstViewPeriodStart = $this->prefs["firstViewPeriodStart"];
    if (empty($firstViewPeriodStart)) {
        $firstViewPeriodStart = $this->prefs["firstPayPeriodStart"];
    }
?>
    <table class="admintable">
        <tr>
            <td width="100" align="right" class="key">
                <label for="firstPayPeriodStart">
                    <?php echo JText::_(COM_TIMECLOCK_FIRST_PAY_PERIOD_START); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("calendar", $this->prefs["firstPayPeriodStart"], "prefs[firstPayPeriodStart]", "prefsfirstPayPeriodStart", "%Y-%m-%d", "");?>
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_FIRST_PAY_PERIOD_START_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="payPeriodType">
                    <?php echo JText::_(COM_TIMECLOCK_PAY_PERIOD_TYPE); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("select.genericList", $this->payPeriodTypeOptions, "prefs[payPeriodType]", "", 'value', 'text', $this->prefs["payPeriodType"]); ?>
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_PAY_PERIOD_TYPE_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="payPeriodLength">
                    <?php echo JText::_(COM_TIMECLOCK_PAY_PERIOD_LENGTH); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("select.integerList", 1, 31, 1, "prefs[payPeriodLengthFixed]", "", $this->prefs["payPeriodLengthFixed"]); ?>
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_PAY_PERIOD_LENGTH_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="TimesheetViewStyle">
                    <?php echo JText::_(COM_TIMECLOCK_TIMESHEET_VIEW_PERIOD); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("select.genericList", $this->timesheetViewOptions, "prefs[timesheetView]", "", 'value', 'text', $this->prefs["timesheetView"]); ?>
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_TIMESHEET_VIEW_PERIOD_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="viewPeriodLength">
                    <?php echo JText::_(COM_TIMECLOCK_VIEW_PERIOD_LENGTH); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("select.integerList", 1, 31, 1, "prefs[viewPeriodLengthFixed]", "", $this->prefs["viewPeriodLengthFixed"]); ?>
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_VIEW_PERIOD_LENGTH_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="firstViewPeriodStart">
                    <?php echo JText::_(COM_TIMECLOCK_FIRST_VIEW_PERIOD_START); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("calendar", $firstViewPeriodStart, "prefs[firstViewPeriodStart]", "prefsfirstViewPeriodStart", "%Y-%m-%d", "");?>
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_FIRST_VIEW_PERIOD_START_DESC); ?>
            </td>
        </tr>
    </table>
<?php
    echo $pane->endPanel();
    echo $pane->startPanel(JText::_(COM_TIMECLOCK_PAID_TIME_OFF), "pto-pane");
?>
    <table class="admintable">
        <tr>
            <td width="100" align="right" class="key">
                <label for="firstPayPeriodStart">
                    <?php echo JText::_(COM_TIMECLOCK_ACCRUE_PTO); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("select.booleanList", "prefs[ptoEnable]", "", $this->prefs["ptoEnable"]); ?>
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_ACCRUE_PTO_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key" style="vertical-align: top;">
                <label for="userTypes">
                    <?php echo JText::_(COM_TIMECLOCK_ACCRUAL_RATES); ?>:
                </label>
            </td>
            <td>
                <textarea class="text_area" type="text" name="prefs[ptoAccrualRates]" id="prefs_ptoAccrualRates" cols="50" rows="10"><?php echo $this->prefs["ptoAccrualRates"];?></textarea>
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_ACCRUAL_RATES_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="ptoAccrualWait">
                    <?php echo JText::_(COM_TIMECLOCK_DAYS_BEFORE_ACCRUAL_BEGINS); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" size="10" maxlength="100" name="prefs[ptoAccrualWait]" id="prefs_ptoAccrualWait" value="<?php echo $this->prefs["ptoAccrualWait"];?>" />
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_DAYS_BEFORE_ACCRUAL_BEGINS_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="ptoHoursPerDay">
                    <?php echo JText::_(COM_TIMECLOCK_PTO_HOURS_PER_DAY); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("select.integerList", 1, 24, 1, "prefs[ptoHoursPerDay]", "", $this->prefs["ptoHoursPerDay"]); ?>
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_PTO_HOURS_PER_DAY_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="ptoAccrualPeriod">
                    <?php echo JText::_(COM_TIMECLOCK_ACCRUAL_PERIOD); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("select.genericList", $this->ptoAccrualPeriodOptions, "prefs[ptoAccrualPeriod]", "", 'value', 'text', $this->prefs["ptoAccrualPeriod"]); ?>
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_ACCRUAL_PERIOD_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="ptoAccrualTime">
                    <?php echo JText::_(COM_TIMECLOCK_ACCRUAL_TIME); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("select.genericList", $this->ptoAccrualTimeOptions, "prefs[ptoAccrualTime]", "", 'value', 'text', $this->prefs["ptoAccrualTime"]); ?>
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_ACCRUAL_TIME_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="ptoCarryOverDefExpire">
                    <?php echo JText::_(COM_TIMECLOCK_DEFAULT_PTO_CARRYOVER_EXPIRATION); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" size="20" maxlength="20" name="prefs[ptoCarryOverDefExpire]" id="ptoCarryOverDefExpire" value="<?php echo $this->prefs["ptoCarryOverDefExpire"];?>" />
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_DEFAULT_PTO_CARRYOVER_EXPIRATION_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="ptoNegative">
                    <?php echo JText::_(COM_TIMECLOCK_ACCEPTABLE_NEGATIVE_PTO); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" size="10" maxlength="100" name="prefs[ptoNegative]" id="prefs_ptoNegative" value="<?php echo $this->prefs["ptoNegative"];?>" />
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_ACCEPTABLE_NEGATIVE_PTO_DESC); ?>
            </td>
        </tr>

    </table>
<?php
    echo $pane->endPanel();
    echo $pane->startPanel(JText::_(COM_TIMECLOCK_WORKERS_COMP), "wcomp-pane");
?>
    <table class="admintable">
        <tr>
            <td width="100" align="right" class="key">
                <label for="wCompEnable">
                    <?php echo JText::_(COM_TIMECLOCK_ENABLE); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("select.booleanList", "prefs[wCompEnable]", "", $this->prefs["wCompEnable"]); ?>
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_WC_ENABLE_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key" style="vertical-align: top;">
                <label for="wCompCodes">
                    <?php echo JText::_(COM_TIMECLOCK_CODES); ?>:
                </label>
            </td>
            <td>
                <textarea class="text_area" type="text" name="prefs[wCompCodes]" id="prefs_wCompCodes" cols="50" rows="5"><?php echo $this->prefs["wCompCodes"];?></textarea>
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_CODES_DESC); ?>
            </td>
        </tr>
    </table>
<?php
    echo $pane->endPanel();
    echo $pane->startPanel(JText::_(COM_TIMECLOCK_EXTRAS), "extras-pane");
?>
    <table class="admintable">
        <tr>
            <td width="100" align="right" class="key">
                <label for="wCompEnable">
                    <?php echo JText::_(COM_TIMECLOCK_JPGRAPH_PATH); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" size="50" maxlength="100" name="prefs[JPGraphPath]" id="prefs_JPGraphPath" value="<?php echo $this->prefs["JPGraphPath"];?>" />
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_JPGRAPH_PATH_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="timeclockDisable">
                    <?php echo JText::_(COM_TIMECLOCK_DISABLE_TIMECLOCK); ?>:
                </label>
            </td>
            <td>
                <?php print JHTML::_("select.booleanList", "prefs[timeclockDisable]", "", $this->prefs["timeclockDisable"]); ?>
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_DISABLE_TIMECLOCK_DESC); ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key" style="vertical-align: top;">
                <label for="prefs_timeclockDisableMessage">
                    <?php echo JText::_(COM_TIMECLOCK_DISABLE_MESSAGE); ?>:
                </label>
            </td>
            <td>
                <textarea class="text_area" type="text" name="prefs[timeclockDisableMessage]" id="prefs_timeclockDisableMessage" cols="50" rows="5"><?php echo $this->prefs["timeclockDisableMessage"];?></textarea>
            </td>
            <td>
                <?php echo JText::_(COM_TIMECLOCK_DISABLE_MESSAGE_DESC); ?>
            </td>
        </tr>
    </table>


<?php
    echo $pane->endPanel();
    echo $pane->endPane();
?>
</div>

<div class="clr"></div>

<input type="hidden" name="option" value="com_timeclock" />
<input type="hidden" name="id" value="-1" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="config" />
<?php print JHTML::_("form.token"); ?>
</form>

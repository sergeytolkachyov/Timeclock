<?php
/**
 * This component is the user interface for the endpoints
 *
 * PHP Version 5
 *
 * <pre>
 * com_ComTimeclock is a Joomla! 1.5 component
 * Copyright (C) 2008 Hunt Utilities Group, LLC
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
 * @copyright  2008 Hunt Utilities Group, LLC
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    SVN: $Id$    
 * @link       https://dev.hugllc.com/index.php/Project:ComTimeclock
 */

defined('_JEXEC') or die('Restricted access'); 

JHTML::_('behavior.tooltip');

$headerColSpan = 2;
$this->totals     = array();
if (empty($this->days)) $this->days = 7;

$headerColSpan    = ($this->period["length"]+2+($this->period["length"]/$this->days));

$document        =& JFactory::getDocument();
$document->setTitle("Add Hours for ".$this->user->get("name")." on ".JHTML::_('date', $this->date, $shortDateFormat));

?>

<form action="index.php" method="post" name="userform" autocomplete="off">
    <div class="componentheading">Add Hours</div>
    <table cellpadding="5" cellspacing="0" border="0" width="100%">
        <tr>
            <th>
                <?php print JText::_("Date");?>:
            </th>
            <td>
                <?php print JHTML::_("calendar", $this->date, "date", "date", "%Y-%m-%d", "");?>
            </td>
        </tr>
<?php
foreach ($this->projects as $cat) {
    if (($cat->mine == false) || !$cat->published) continue;
    if (!is_null($this->projid) && !array_key_exists($this->projid, $cat->subprojects)) continue;
    ?>
        <tr>
            <td class="sectiontableheader" colspan="<?php print $headerColSpan; ?>">
                <h2><?php print JText::_("Category").": ".JText::_($cat->name); ?></h2>
            </td>
        </tr>    
    <?php
    foreach ($cat->subprojects as $pKey => $proj) {
        if ($proj->mine == false) continue;
        if (!$proj->published) continue;
        if ($proj->noHours) continue;
        if (!is_null($this->projid) && !($this->projid == $proj->id)) continue;
        ?>
        <tr>
            <td class="sectiontableheader" colspan="<?php print $headerColSpan; ?>">
                <?php print JText::_("Project").": ".TimeclockController::formatProjId($proj->id)." ".JText::_($proj->name); ?>
            </td>
        </tr>    
        <tr>
            <th>
                <?php print JText::_("Hours");?>:
            </th>
            <td>
                <input class="text_area" type="text" id="timesheet_<?php print $proj->id;?>_hours" name="timesheet[<?php print $proj->id;?>][hours]" size="10" maxlength="10" value="<?php echo $this->data[$proj->id]->hours;?>" />
            </td>
        </tr>
        <tr>
            <th style="vertical-align: top;">
                 <?php echo JText::_('Notes'); ?>:
            </th>
            <td>
                <textarea class="text_area"  id="timesheet_<?php print $proj->id;?>_notes" name="timesheet[<?php print $proj->id;?>][notes]" cols="50" rows="5"><?php echo $this->data[$proj->id]->notes;?></textarea>
            </td>
        </tr>

        <?php        
    }
}



?>
    </table>
    <input type="hidden" name="referer" value="<?php print $this->referer; ?>" />
</form>

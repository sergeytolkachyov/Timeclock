<?php
/**
 * This component is the user interface for the endpoints
 *
 * PHP Version 5
 *
 * <pre>
 * com_ComTimeclock is a Joomla! 1.6 component
 * Copyright (C) 2014 Hunt Utilities Group, LLC
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
 * @copyright  2014 Hunt Utilities Group, LLC
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    SVN: $Id$
 * @link       https://dev.hugllc.com/index.php/Project:ComTimeclock
 */

defined('_JEXEC') or die('Restricted access');
$style = (isset($style)) ? $style : "";
//$style = "writing-mode: tb-rl; filter: flipv() fliph(); white-space: nowrap; vertical-align: center; height: 1.1em; ";
?>
        <tr>
            <th style="<?php print $this->cellStyle; ?>">
                <?php print JHTML::_('grid.sort', JText::_("COM_TIMECLOCK_PROJECT"), 'p.name', @$this->lists['order_Dir'], @$this->lists['order']); ?>
            </th>
            <?php foreach ($this->users as $user) : ?>
            <th width="1.1em" style="<?php print $this->cellStyle; ?>">
                <div style="<?php print $style; ?>"><?php print $user; ?></div>
            </th>
            <?php endforeach; ?>
            <th width="1.1em" style="<?php print $this->cellStyle; ?>">
                <div style="<?php print $style; ?>"><?php print JText::_("COM_TIMECLOCK_TOTAL"); ?></div>
            </th>
        </tr>
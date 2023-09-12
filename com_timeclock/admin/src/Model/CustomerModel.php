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
 * @version    GIT: $Id: a70fad7ecea96c148fd07befe386dd1bba7cfe4f $
 * @link       https://dev.hugllc.com/index.php/Project:ComTimeclock
 */
namespace HUGLLC\Component\Timeclock\Administrator\Model;

use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\Form\FormFactoryInterface;


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
class CustomerModel extends AdminModel
{
    /**
     * The prefix to use with controller messages.
     *
     * @var    string
     * @since  1.6
     */
    protected $text_prefix = 'COM_TIMECLOCK';

    /**
     * Constructor.
     *
     * @param   array                 $config       An array of configuration options (name, state, dbo, table_path, ignore_request).
     * @param   MVCFactoryInterface   $factory      The factory.
     * @param   FormFactoryInterface  $formFactory  The form factory.
     *
     * @since   1.6
     * @throws  \Exception
     */
    public function __construct($config = [], MVCFactoryInterface $factory = null, FormFactoryInterface $formFactory = null)
    {
        parent::__construct($config, $factory, $formFactory);
    }
    /**
    * Build a query, where clause and return an object
    *
    * @param int $id The id of the record to get.
    */
    public function getItem($id = null)
    {
        $db = Factory::getDBO();

        $id = $id ? $id : Factory::getApplication()->getInput()->getInt("id");
        $query = $this->_buildQuery();
        $query->where('c.customer_id = ' . (int) $id);
        $db->setQuery($query);

        $item = $db->loadObject();

        return $item;
    }
    /**
    * Builds the query to be used by the model
    *
    * @return object Query object
    */
    protected function _buildQuery()
    {
        $db = Factory::getDBO();
        $query = $db->getQuery(TRUE);
        $query->select('c.customer_id, c.company, c.name, c.address1, c.address2,
                        c.city, c.state, c.zip, c.country, c.notes, c.checked_out,
                        c.checked_out_time, c.published, c.created_by, c.created,
                        c.modified, c.bill_pto');
        $query->from('#__timeclock_customers as c');
        $query->select('u.name as author');
        $query->leftjoin('#__users as u on c.created_by = u.id');
        $query->select('v.name as contact');
        $query->leftjoin('#__users as v on c.contact_id = v.id');
        return $query;
    }

    /**
     * Method to get the record form.
     *
     * @param   array    $data      Data for the form. [optional]
     * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not. [optional]
     *
     * @return  Form|boolean  A Form object on success, false on failure
     */
    public function getForm($data = [], $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_timeclock.customer', 'customer', ['control' => 'jform', 'load_data' => $loadData]);

        if (empty($form)) {
            return false;
        }
    }

}
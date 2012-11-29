<?php
/**
 * VF extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the VF ScheduledContent module to newer versions in the future.
 * If you wish to customize the VF ScheduledContent module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   VF
 * @package    VF_ScheduledContent
 * @copyright  Copyright (C) 2012 Vladimir Fishchenko
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Scheduled Content Data Collection
 *
 * @category   VF
 * @package    VF_ScheduledContent
 * @subpackage Model
 * @author     Vladimir Fishchenko <vladimir@fishchenko.com>
 */
class VF_ScheduledContent_Model_Resource_Data_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     * Init model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('scheduledContent/data');
    }

    /**
     * Add Filter by store
     *
     * @param int|Mage_Core_Model_Store $store
     *
     * @param bool                      $withAdmin
     *
     * @return Mage_Cms_Model_Mysql4_Page_Collection
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            if ($store instanceof Mage_Core_Model_Store) {
                $store = array($store->getId());
            }

            $this->getSelect()->join(
                array('store_table' => $this->getTable('scheduledContent/data_store')),
                'main_table.data_id = store_table.data_id',
                array()
            )
                ->where('store_table.store_id in (?)', ($withAdmin ? array(0, $store) : $store))
                ->group('main_table.data_id');

            $this->setFlag('store_filter_added', true);
        }

        return $this;
    }

    /**
     * Get SQL for get record count.
     * Extra group by strip added.
     *
     * @return Varien_Db_Select
     */
    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();

        $countSelect->reset(Zend_Db_Select::GROUP);

        return $countSelect;
    }
}

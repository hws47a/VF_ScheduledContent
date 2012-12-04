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
 * Scheduled Content Data Resource Model
 *
 * @category   VF
 * @package    VF_ScheduledContent
 * @subpackage Model
 * @author     Vladimir Fishchenko <vladimir@fishchenko.com>
 */
class VF_ScheduledContent_Model_Resource_Data extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Init the table
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('scheduledContent/data', null);
    }

    /**
     * Assign page to store views
     *
     * @param Mage_Core_Model_Abstract $object
     *
     * @return Mage_Core_Model_Mysql4_Abstract
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $condition = $this->_getWriteAdapter()->quoteInto('data_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('scheduledContent/data_store'), $condition);

        foreach ((array)$object->getData('stores') as $store) {
            $storeArray = array();
            $storeArray['data_id'] = $object->getId();
            $storeArray['store_id'] = $store;
            $this->_getWriteAdapter()->insert($this->getTable('scheduledContent/data_store'), $storeArray);
        }

        return parent::_afterSave($object);
    }

    /**
     * Load stores after model load
     *
     * @param Mage_Core_Model_Abstract $object
     *
     * @return \Mage_Core_Model_Mysql4_Abstract
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('scheduledContent/data_store'))
            ->where('data_id = ?', $object->getId());

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $storesArray = array();
            foreach ($data as $row) {
                $storesArray[] = $row['store_id'];
            }
            $object->setData('stores', $storesArray);
        }

        return parent::_afterLoad($object);
    }

    /**
     * Get all identifiers
     *
     * @return array
     */
    public function getAllIdentifiers()
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getMainTable(), 'identifier')
            ->group('identifier');
        return (array) $this->_getReadAdapter()->fetchCol($select, array('identifier'));
    }
}

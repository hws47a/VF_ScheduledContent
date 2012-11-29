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
 * Get Scheduled Content
 *
 * @category   VF
 * @package    VF_ScheduledContent
 * @subpackage Block
 * @author     Vladimir Fishchenko <vladimir@fishchenko.com>
 */
class VF_ScheduledContent_Block_Data extends Mage_Core_Block_Template
{
    /**
     * Get Current Data
     *
     * @param Zend_Date $currentDate
     *
     * @return VF_ScheduledContent_Model_Data
     */
    protected function _getCurrentData(Zend_Date $currentDate)
    {
        /** @var $model VF_ScheduledContent_Model_Data */
        $model = Mage::getModel('scheduledContent/data');

        /** @var $collection VF_ScheduledContent_Model_Resource_Data_Collection */
        $collection = $model->getCollection();
        //add current store + all stores filter
        $collection->addStoreFilter(Mage::app()->getStore(), true);
        //apply dates filter
        $currentDate = $currentDate->get(Varien_Date::DATE_INTERNAL_FORMAT);
        $collection->addFieldToFilter('start_at', array('lteq' => $currentDate))
            ->addFieldToFilter('end_at', array('gteq' => $currentDate));
        //apply identifier filter
        $collection->addFieldToFilter('identifier', $this->getDataId());
        //order by start_id and limit 1
        $collection->addOrder('start_at', 'ASC')
            ->setPageSize(1)
            ->setCurPage(1);
        if ($collection->count()) {
            $model = $collection->getFirstItem();
        }

        return $model;
    }

    /**
     * Get Cached Content
     *
     * @param Zend_Date $currentDate
     *
     * @return string
     */
    protected function _getCachedContent(Zend_Date $currentDate)
    {
        $cacheId = 'SCHEDULED_CONTENT_' . $this->getDataId()
            . '_' . $currentDate->get(Varien_Date::DATE_INTERNAL_FORMAT);
        $content = Mage::app()->getCache()->load($cacheId);
        if (!$content) {
            $content = (string) $this->_getCurrentData($currentDate)->getContent();
            Mage::app()->getCache()->save($content, $cacheId,
                array(Mage_Core_Block_Abstract::CACHE_GROUP), 86400);
        }

        return $content;
    }

    /**
     * to Html content
     *
     * @return string
     */
    protected function _toHtml()
    {
        $currentData = Mage::app()->getLocale()->date();

        return $this->_getCachedContent($currentData);
    }
}

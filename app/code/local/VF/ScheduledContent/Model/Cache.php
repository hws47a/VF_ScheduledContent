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
 * @copyright  Copyright (C) 2012 Vladimir Fishchenko (http://fishchenko.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Scheduled Content data caching
 *
 * @category   VF
 * @package    VF_ScheduledContent
 * @subpackage Model
 * @author     Vladimir Fishchenko <vladimir@fishchenko.com>
 */
class VF_ScheduledContent_Model_Cache extends Mage_Core_Model_Abstract
{
    /**
     * Get cache id by data_id
     *
     * @param string $dataId
     *
     * @return string
     */
    protected function _getCacheId($dataId)
    {
        $currentDate = Mage::app()->getLocale()->date()->get(Varien_Date::DATE_INTERNAL_FORMAT);

        return 'SCHEDULED_CONTENT_' . $dataId . '_' . $currentDate;
    }

    /**
     * Get data from cache for block with dataId
     *
     * @param $dataId
     *
     * @return false|mixed
     */
    public function getCacheByDataId($dataId)
    {
        return Mage::app()->getCache()->load($this->_getCacheId($dataId));
    }

    /**
     * Save cache data for dataId block
     *
     * @param $content
     * @param $dataId
     *
     * @return bool
     */
    public function saveData($content, $dataId)
    {
        return Mage::app()->getCache()->save(
            $content,
            $this->_getCacheId($dataId),
            array(Mage_Core_Block_Abstract::CACHE_GROUP),
            86400
        );
    }

    /**
     * Clear cache for block with dataId
     *
     * @param $dataId
     *
     * @return bool
     */
    public function clearByDataId($dataId)
    {
        return Mage::app()->getCache()->remove($this->_getCacheId($dataId));
    }
}

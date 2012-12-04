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
 * Scheduled Content Data Model
 *
 * @category   VF
 * @package    VF_ScheduledContent
 * @subpackage Model
 * @author     Vladimir Fishchenko <vladimir@fishchenko.com>
 */
class VF_ScheduledContent_Model_Data extends Mage_Core_Model_Abstract
{
    /**
     * Init the resource
     *
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('scheduledContent/data');
    }

    /**
     * Get all identifiers
     *
     * @return array
     */
    public function getAllIdentifiers()
    {
        return (array) $this->_getResource()->getAllIdentifiers();
    }
}

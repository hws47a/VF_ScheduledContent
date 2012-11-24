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
 * Scheduled Content Data Edit Form Container
 *
 * @category   VF
 * @package    VF_ScheduledContent
 * @subpackage Block
 * @author     Vladimir Fishchenko <vladimir@fishchenko.com>
 */
class VF_ScheduledContent_Block_Adminhtml_Data_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init grid container
     */
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_data';
        $this->_blockGroup = 'scheduledContent';
    }

    /**
     * Get container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        $data = Mage::registry('current_scheduledContent_data');
        if ($data) {
            return $this->__('Edit Item #%d', $this->escapeHtml($data->getId()));
        } else {
            return $this->__('New Item');
        }
    }
}

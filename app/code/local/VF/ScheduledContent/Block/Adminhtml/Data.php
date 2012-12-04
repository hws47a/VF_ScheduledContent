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
 * Scheduled Content Data Grid Container
 *
 * @category   VF
 * @package    VF_ScheduledContent
 * @subpackage Block
 * @author     Vladimir Fishchenko <vladimir@fishchenko.com>
 */
class VF_ScheduledContent_Block_Adminhtml_Data extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Init grid container
     */
    public function __construct()
    {
        $this->_addButton('clear_cache', array(
            'label'     => $this->__('Apply All'),
            'onclick'   => 'setLocation(\'' . $this->getApplyAllUrl() .'\')',
            'class'     => 'save',
        ));

        parent::__construct();
        $this->_controller = 'adminhtml_data';
        $this->_blockGroup = 'scheduledContent';
        $this->_headerText = $this->__('Scheduled Content Data');
    }

    /**
     * Get Apply All Blocks Data Url
     *
     * @return string
     */
    public function getApplyAllUrl()
    {
        return $this->getUrl('*/*/applyAll');
    }
}

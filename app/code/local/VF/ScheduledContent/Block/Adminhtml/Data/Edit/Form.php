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
 * Scheduled Content Data Edit Form
 *
 * @category   VF
 * @package    VF_ScheduledContent
 * @subpackage Block
 * @author     Vladimir Fishchenko <vladimir@fishchenko.com>
 */
class VF_ScheduledContent_Block_Adminhtml_Data_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare the form
     *
     * @return Mage_Adminhtml_Block_Widget_Form|void
     */
    protected function _prepareForm()
    {
        //add form
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id', null))),
            'method' => 'post'
        ));
        $form->setUseContainer(true);
        $this->setForm($form);

        $data = Mage::registry('current_scheduledContent_data');

        //add fieldset
        $fieldSet = $form->addFieldset(
            'main_field_set',
            array('legend' => $this->__('Main Content'))
        );

        $fieldSet->addField('identifier', 'text', array(
            'label'     => $this->__('Identifier'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'identifier'
        ));

        // Add store multiple select
        if (!Mage::app()->isSingleStoreMode()) {
            $fieldSet->addField('stores', 'multiselect', array(
                'name'      => 'stores[]',
                'label'     => Mage::helper('cms')->__('Store View'),
                'title'     => Mage::helper('cms')->__('Store View'),
                'required'  => true,
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true)
            ));
        } else {
            $fieldSet->addField('stores', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            $data->setStores(Mage::app()->getStore(true)->getId());
        }

        $fieldSet->addField('content', 'textarea', array(
            'label'     => $this->__('Content'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'content'
        ));

        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(
            Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
        );

        $fieldSet->addField('start_at', 'date', array(
            'label'     => $this->__('Start At'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'start_at',
            'format'    => $dateFormatIso,
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
        ));

        $fieldSet->addField('end_at', 'date', array(
            'label'     => $this->__('End At'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'end_at',
            'format'    => $dateFormatIso,
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
        ));

        if ($data) {
            $form->setValues($data->getData());
        }

        parent::_prepareForm();
    }
}

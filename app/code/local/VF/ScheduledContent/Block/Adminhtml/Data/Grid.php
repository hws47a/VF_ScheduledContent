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
 * ScheduledContent Data Grid
 *
 * @category   VF
 * @package    VF_ScheduledContent
 * @subpackage Block
 * @author     Vladimir Fishchenko <vladimir@fishchenko.com>
 */
class VF_ScheduledContent_Block_Adminhtml_Data_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Init grid
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('dataGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);

        $this->setModelPath('scheduledContent/data');
        $this->setIdFieldName(Mage::getModel($this->getModelPath())->getResource()->getIdFieldName());
    }

    /**
     * prepare collection for grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel($this->getModelPath())->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid columns
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn($this->getIdFieldName(), array(
            'header'    => $this->__('ID'),
            'align'     => 'right',
            'width'     => '50px',
            'type'      => 'int',
            'index'     => $this->getIdFieldName()
        ));

        $this->addColumn('identifier', array(
            'header'    => $this->__('Identifier'),
            'align'     => 'left',
            'type'      => 'text',
            'index'     => 'identifier'
        ));

        $this->addColumn('content', array(
            'header'    => $this->__('Content'),
            'align'     => 'left',
            'type'      => 'text',
            'index'     => 'content'
        ));

        $this->addColumn('start_at', array(
            'header'    => $this->__('Start At'),
            'align'     => 'left',
            'type'      => 'date',
            'index'     => 'start_at'
        ));

        $this->addColumn('end_at', array(
            'header'    => $this->__('End At'),
            'align'     => 'left',
            'type'      => 'date',
            'index'     => 'end_at'
        ));

        return parent::_prepareColumns();
    }

    /**
     * get the row url for edit
     *
     * @param $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * prepare mass action methods
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField($this->getIdFieldName());
        $this->getMassactionBlock()->setFormFieldName('item');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'    => $this->__('Delete'),
            'url'      => $this->getUrl('*/*/massDelete'),
            'confirm'  => $this->__('Are you sure?')
        ));

        return parent::_prepareMassaction();
    }

    /**
     * get the grid url for ajax updates
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}

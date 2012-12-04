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
 * Scheduled Content Data CRUD Controller
 *
 * @category   VF
 * @package    VF_ScheduledContent
 * @subpackage controllers
 * @author     Vladimir Fishchenko <vladimir@fishchenko.com>
 */
class VF_ScheduledContent_Adminhtml_ScheduledContentController extends Mage_Adminhtml_Controller_Action
{
    protected $_model = 'scheduledContent/data';

    /**
     * Init layout
     *
     * @return VF_ScheduledContent_Adminhtml_ScheduledContentController
     */
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('custom_modules/scheduled_content')
            ->_addBreadcrumb($this->__('ScheduledContent Data'), $this->__('ScheduledContent Data'));
        $this->_title($this->__('ScheduledContent Data'));

        return $this;
    }

    /**
     * Show grid
     *
     * @return void
     */
    public function indexAction()
    {
        $this->_initAction()
        ->renderLayout();
    }

    /**
     * Edit item action
     *
     * @return void
     */
    public function editAction()
    {
        $modelId = intval($this->getRequest()->getParam('id', 0));
        $error = false;
        if ($modelId) {
            $model = Mage::getModel($this->_model)->load($modelId);
            if ($model->getId()) {
                $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
                if ($data) {
                    $model->setData($data)->setId($modelId);
                }
                Mage::register('current_scheduledContent_data', $model);
            } else {
                $this->_getSession()->addError($this->__('Item doesn\'t exist'));
                $error = true;
            }
        }

        if ($error) {
            $this->_redirectError($this->_getRefererUrl());
        } else {
            $this->_initAction();
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->renderLayout();
        }
    }

    /**
     * New item action
     *
     * @return void
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save menu item action
     *
     * @return void
     */
    public function saveAction()
    {
        $error = false;

        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel($this->_model);

            $modelId = intval($this->getRequest()->getParam('id', 0));
            if ($modelId) {
                $model->load($modelId);
            }

            $this->_getSession()->setFormData($data);

            try {
                $this->_saveModel($data, $model);

                $this->_getSession()->addSuccess($this->__('Item was successfully saved.'));
                $this->_getSession()->setFormData(false);

                if ($this->getRequest()->getParam('apply', false)) {
                    /** @var $cacheModel VF_ScheduledContent_Model_Cache */
                    $cacheModel = Mage::getModel('scheduledContent/cache');
                    $cleared = $cacheModel->clearByDataId($model->getIdentifier());
                    if ($cleared) {
                        $this->_getSession()->addSuccess($this->__('Changes have been applied.'));
                    } else {
                        $this->_getSession()->addError($this->__('Error while applying changes.'));
                    }
                }

            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $error = true;
            } catch (Exception $e) {
                $this->_getSession()->addError($this->__('Error while saving item'));
                Mage::logException($e);
                $error = true;
            }
        } else {
            $this->_getSession()->addError($this->__('No data found to save'));
        }

        if (!$error && isset($model) && $model->getId()) {
            // The following line decides if it is a "save" or "save and continue"
            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
            } else {
                $this->_redirect('*/*/');
            }
        } else {
            $this->_redirectReferer();
        }
    }

    /**
     * Save Model
     *
     * @param array                     $data
     * @param Mage_Core_Model_Abstract  $model
     */
    protected function _saveModel($data = array(), Mage_Core_Model_Abstract $model)
    {
        $data = $this->_filterDates($data, array('start_at', 'end_at'));

        $modelId = $model->getId();
        $model->setData($data);

        if ($modelId) {
            $model->setId($modelId);
        }

        $model->save();

        if (!$model->getId()) {
            Mage::throwException($this->__('Error saving item'));
        }
    }

    /**
     * Delete item action
     *
     * @return mixed
     */
    public function deleteAction()
    {
        if ($modelId = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel($this->_model);
                $model->setId($modelId);
                $model->delete();
                $this->_getSession()->addSuccess($this->__('Item has been deleted.'));
                $this->_redirect('*/*/');

                return;
            }
            catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));

                return;
            }
        }
        $this->_getSession()->addError($this->__('Unable to find the item to delete.'));
        $this->_redirect('*/*/');
    }

    /**
     * Load grid for ajax action
     *
     * @return void
     */
    public function gridAction()
    {
        $this->loadLayout()
            ->renderLayout();
    }

    /**
     * Mass delete items action
     *
     * @return void
     */
    public function massDeleteAction()
    {
        $modelIds = $this->getRequest()->getParam('item');
        if (!is_array($modelIds)) {
            $this->_getSession()->addError($this->__('Please select item(s).'));
        } else {
            try {
                foreach ($modelIds as $modelId) {
                    Mage::getSingleton($this->_model)
                        ->load($modelId)
                        ->delete();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were deleted.', count($modelIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/');
    }

    public function applyAllAction()
    {
        $cleared = 0;

        $identifiers = Mage::getModel($this->_model)->getAllIdentifiers();
        if (!empty($identifiers)) {
            /** @var $cacheModel VF_ScheduledContent_Model_Cache */
            $cacheModel = Mage::getModel('scheduledContent/cache');
            foreach ($identifiers as $_dataId) {
                $cleared += (int)$cacheModel->clearByDataId($_dataId);
            }
        }

        if ($cleared) {
            $this->_getSession()->addSuccess($this->__('%d data blocks applied', $cleared));
        } else {
            $this->_getSession()->addWarning($this->__('Nothing cleared'));
        }

        $this->_redirect('*/*/');
    }
}

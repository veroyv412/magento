<?php
/**
 * Created by JetBrains PhpStorm.
 * User: veritto
 * Date: 3/4/13
 * Time: 3:25 PM
 * To change this template use File | Settings | File Templates.
 */
class Summa_Brand_Adminhtml_BrandController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        // Let's call our initAction method which will set some basic params for each action
        $this->_initAction()
            ->renderLayout();
    }

    public function newAction()
    {
        // We just forward the new action to a blank edit form
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_initAction();

        // Get id if available
        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('summa_brand/brand');

        if ($id) {
            // Load record
            $model->load($id);

            // Check if record is loaded
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This brand no longer exists.'));
                $this->_redirect('*/*/');

                return;
            }
        }

        $this->_title($model->getId() ? $model->getName() : $this->__('New Brand'));

        $data = Mage::getSingleton('adminhtml/session')->getBrandData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('summa_brand', $model);

        $this->_initAction()
            ->_addBreadcrumb($id ? $this->__('Edit Brand') : $this->__('New Brand'), $id ? $this->__('Edit Brand') : $this->__('New Brand'))
            ->_addContent($this->getLayout()->createBlock('summa_brand/adminhtml_brand_edit')->setData('action', $this->getUrl('*/*/save')))
            ->renderLayout();
    }

    public function saveAction()
    {
        if ($postData = $this->getRequest()->getPost()) {
            $model = Mage::getSingleton('summa_brand/brand');
            $model->setData($postData);

            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The Brand has been saved.'));
                $this->_redirect('*/*/');

                return;
            }
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this brand.'));
            }

            Mage::getSingleton('adminhtml/session')->setBrandData($postData);
            $this->_redirectReferer();
        }
    }

    public function messageAction()
    {
        $data = Mage::getModel('summa_brand/brand')->load($this->getRequest()->getParam('id'));
        echo $data->getContent();
    }

    /**
     * Initialize action
     *
     * Here, we set the breadcrumbs and the active menu
     *
     * @return Mage_Adminhtml_Controller_Action
     */
    protected function _initAction()
    {
        $this->loadLayout()
        // Make the active menu match the menu config nodes (without 'children' inbetween)
            ->_setActiveMenu('summa_brand')
            ->_title($this->__('Brand'))
            ->_addBreadcrumb($this->__('Brand'), $this->__('Brand'))
            ->_addBreadcrumb($this->__('Manage Brands'), $this->__('Manage Brands'));

        return $this;
    }

    /**
     * Check currently called action by permissions for current user
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        //return Mage::getSingleton('admin/session')->isAllowed('sales/foo_bar_baz');
        return true;
    }
}
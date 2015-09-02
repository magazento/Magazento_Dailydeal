<?php
/*
 *  Created on Dec 6, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Dailydeal_Admin_ItemController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        
        if (Mage::helper('dailydeal')->versionUseAdminTitle()) {
            $this->_title($this->__('DAILY DEAL'));
        }
        
        
        $this->loadLayout()
                ->_setActiveMenu('magazento/dailydeal')
                ->_addBreadcrumb(Mage::helper('dailydeal')->__('Dailydeal'), Mage::helper('dailydeal')->__('Dailydeal'))
                ->_addBreadcrumb(Mage::helper('dailydeal')->__('Dailydeal Items'), Mage::helper('dailydeal')->__('Dailydeal Items'))
        ;
        return $this;
    }
    
    /**
     * Categories part
     *
     */
    public function categoriesAction() {
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('dailydeal/admin_item_edit_tab_categories')->toHtml()
        );
    }

    public function categoriesJsonAction() {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('dailydeal/admin_item_edit_tab_categories')
                ->getCategoryChildrenJson($this->getRequest()->getParam('category'))
        );
    }
    
    public function updatecategoriesAction() {
        if ($id = $this->getRequest()->getParam('category_id')) {
            Mage::getModel('dailydeal/category')->refreshCategories($id);
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('dailydeal')->__('Categories was successfully updated'));            
        }
        $this->_redirect('*/*/');
        return;
    }  
    
    /**
     * Reviews part
     */    
    public function reviewsAction() {
        
        $this->loadLayout();
        $this->getLayout()->getBlock('reviews.grid');
        $this->renderLayout();
    }

    public function reviewsgridAction() {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('dailydeal/admin_item_Edit_tab_tabhoriz_reviews', 'reviews.grid')
                ->toHtml()
        );        
    }
    /**
     * Related part
     */    
    public function relatedAction() {
        
        $this->loadLayout();
        $this->getLayout()->getBlock('related.grid');
        $this->renderLayout();
    }

    public function relatedgridAction() {

        $this->loadLayout();
        $this->getLayout()->getBlock('related.grid');
        $this->renderLayout();
    }
    
    /**
     * Assigned part
     */    
    public function assignedAction() {
        $this->loadLayout();
        $this->getLayout()->getBlock('assigned.grid');
        $this->renderLayout();
    }

    public function assignedgridAction() {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('dailydeal/admin_item_Edit_tab_tabhoriz_assigned', 'assigned.grid')
                ->toHtml()
        );            
    }
    
    public function indexAction() {

        $this->_initAction()
                ->_addContent($this->getLayout()->createBlock('dailydeal/admin_item'))
                ->renderLayout();
    }
    
    public function newAction() {
        $this->_forward('edit');
    }

    public function editAction() {
        
        $id = $this->getRequest()->getParam('item_id');
        
        $model = Mage::getModel('dailydeal/item');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dailydeal')->__('This item no longer exists'));
                $this->_redirect('*/*/');
                return;
            }
        }
        
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        
        Mage::register('dailydeal_item', $model);
        
        
        $this->loadLayout(array('default', 'editor'))
            ->_setActiveMenu('cms/dailydeal');

        $this->getLayout()->getBlock('head')
            ->setCanLoadExtJs(true)
            ->setCanLoadRulesJs(true)
            ->addItem('js', 'magazento_dailydeal/adminhtml/tabs.js');        
        
        $this-> _addBreadcrumb($id ? Mage::helper('dailydeal')->__('Edit Item') : Mage::helper('dailydeal')->__('New Item'), $id ? Mage::helper('dailydeal')->__('Edit Item') : Mage::helper('dailydeal')->__('New Item'))
                ->_addContent($this->getLayout()->createBlock('dailydeal/admin_item_edit')->setData('action', $this->getUrl('*/admin_item/save')))
                ->_addLeft($this->getLayout()->createBlock('dailydeal/admin_item_edit_tabs'))
                ->renderLayout();
    }
    

    public function deleteAction() {
        if ($id = $this->getRequest()->getParam('item_id')) {
            try {
                $model = Mage::getModel('dailydeal/item');
                $model->load($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('dailydeal')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('item_id' => $id));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dailydeal')->__('Unable to find a item to delete'));
        $this->_redirect('*/*/');
    }


    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('dailydeal/item');
    }

    public function wysiwygAction() {
        $elementId = $this->getRequest()->getParam('element_id', md5(microtime()));
        $content = $this->getLayout()->createBlock('adminhtml/catalog_helper_form_wysiwyg_content', '', array(
                    'editor_element_id' => $elementId
                ));
        $this->getResponse()->setBody($content->toHtml());
    }



    public function massStatusAction()
    {
        $itemIds = $this->getRequest()->getParam('massaction');
        if(!is_array($itemIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($itemIds as $itemId) {
                    $model = Mage::getSingleton('dailydeal/item')
                        ->load($itemId)
                        ->setIs_active($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($itemIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    public function massCheckoutAction()
    {
        $itemIds = $this->getRequest()->getParam('massaction');
        if(!is_array($itemIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($itemIds as $itemId) {
                    $model = Mage::getSingleton('dailydeal/item')
                        ->load($itemId)
                        ->setOn_checkout($this->getRequest()->getParam('checkout'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($itemIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    
   public function massDeleteAction() {
        $itemIds = $this->getRequest()->getParam('massaction');
        if(!is_array($itemIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dailydeal')->__('Please select item(s)'));
        } else {
            try {
                foreach ($itemIds as $itemId) {
                    $mass = Mage::getModel('dailydeal/item')->load($itemId);
                    $mass->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('dailydeal')->__(
                        'Total of %d record(s) were successfully deleted', count($itemIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function statusAction() {
        if ($id = $this->getRequest()->getParam('item_id')) {
            $status_id = $this->getRequest()->getParam('status_id');
                try {
                    $model = Mage::getModel('dailydeal/item');
                    $model->load($id);
                    $model->setStatus($status_id);
                    $model->save();
                    $this->_redirect('*/*/');
                    return;
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                    $this->_redirect('*/*/', array('item_id' => $id));
                    return;
                }
        }
        $this->_redirect('*/*/');
    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('dailydeal/item');
            
            
            
//            var_dump($data);
//            exit();
            
            // Assigned items goes down
            
            if (isset($data['related_prodlist'])) {
                $data['products'] = $data['related_prodlist'];
            }
            if (isset($data['assigned_prodlist'])) {
                $data['assignedproducts'] = $data['assigned_prodlist'];
            }
            if (isset($data['in_products'])) $data['in_products'] = true;
                
                
            if (isset($data['assigned_reviewslist'])) {
                $data['assignedreviews'] = $data['assigned_reviewslist'];
            }
            
            $model->setData($data);
            try {
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('dailydeal')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('item_id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('item_id' => $this->getRequest()->getParam('item_id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
}
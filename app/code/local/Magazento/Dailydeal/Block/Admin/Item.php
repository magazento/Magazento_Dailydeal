<?php
/*
 *  Created on Dec 6, 2012
 *  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
 *  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
 *  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
 */
?>
<?php

class Magazento_Dailydeal_Block_Admin_Item extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    
    public function __construct()
    {
        
        $this->_controller = 'admin_item';
        $this->_blockGroup = 'dailydeal';
        $this->_headerText = Mage::helper('dailydeal')->__('Magazento Daily Deal');
        $this->_addButtonLabel = Mage::helper('dailydeal')->__('Add Deal');
        parent::__construct();

        $this->setTemplate('widget/grid/container.phtml');

        $this->_addButton('add', array(
            'label'     => $this->getAddButtonLabel(),
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/new') .'\')',
            'class'     => 'add',
        ));
    }
    
}

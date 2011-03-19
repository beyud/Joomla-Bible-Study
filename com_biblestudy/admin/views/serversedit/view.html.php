<?php

/**
 * @version     $Id
 * @package     com_biblestudy
 * @license     GNU/GPL
 */
//No Direct Access
defined('_JEXEC') or die();
require_once (JPATH_ADMINISTRATOR  .DS. 'components' .DS. 'com_biblestudy' .DS. 'lib' .DS. 'biblestudy.defines.php');
jimport('joomla.application.component.view');

class biblestudyViewServersedit extends JView {

    protected $form;
    protected $item;
    protected $state;
    protected $admin;

    function display($tpl = null) {
        $this->form = $this->get("Form");
        $this->item = $this->get("Item");
        $this->state = $this->get("State");

 //Load the Admin settings
        $this->loadHelper('params');
        $this->admin = BsmHelper::getAdmin();
        
        $this->setLayout("form");
        $this->addToolbar();
        parent::display($tpl);
    }

    protected function addToolbar() {
        $isNew = ($this->item->id < 1);
        $title = $isNew ? JText::_('JBS_CMN_NEW') : JText::_('JBS_CMN_EDIT');
        JToolBarHelper::title(JText::_('JBS_SVR_SERVER_EDIT') . ': <small><small>[' . $title . ']</small></small>', 'servers.png');
        JToolBarHelper::save('serversedit.save');
        if ($isNew)
			JToolBarHelper::cancel('serversedit.cancel', 'JTOOLBAR_CANCEL'); 
		else {
			JToolBarHelper::apply('serversedit.apply');
            JToolBarHelper::cancel('serversedit.cancel', 'JTOOLBAR_CLOSE');            
        }
		JToolBarHelper::divider();
		JToolBarHelper::help('biblestudy', true);
    }

}
?>
<?php


// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );


class biblestudyViewmedialist extends JView
{
	/**
	 * Medialist view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		global $mainframe, $option; 
		$params = &JComponentHelper::getParams($option);
		JToolBarHelper::title(   JText::_( 'Media Manager' ), 'generic.png' );
		//This checks the Preferences file to see if the admin is allowing rows to be deleted 
		
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		//JToolBarHelper::preferences('com_biblestudy', '550');
		jimport( 'joomla.i18n.help' );
		JToolBarHelper::help( 'biblestudy.media', true );

		// Get data from the model
		$items		= & $this->get( 'Data');

		$this->assignRef('items',		$items);

		parent::display($tpl);
	}
}
?>
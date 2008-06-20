<?php


// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );


class biblestudyViewmessagetypeedit extends JView
{
	
	function display($tpl = null)
	{
		
		$messagetypeedit		=& $this->get('Data');
		$isNew		= ($messagetypeedit->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Message Type Edit' ).': <small><small>[ ' . $text.' ]</small></small>' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
		jimport( 'joomla.i18n.help' );
		JToolBarHelper::help( 'biblestudy.messagetype', true );

		$this->assignRef('messagetypeedit',		$messagetypeedit);

		parent::display($tpl);
	}
}
?>
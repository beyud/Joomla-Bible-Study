<?php


// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
require_once (JPATH_ROOT  .DS. 'components' .DS. 'com_biblestudy' .DS. 'lib' .DS. 'biblestudy.images.class.php');
jimport( 'joomla.application.component.view' );


class biblestudyViewteacheredit extends JView
{
	
	function display($tpl = null)
	{
		$document =& JFactory::getDocument();
		$document->addScript(JURI::base().'components/com_biblestudy/js/jquery.js');
		$document->addScript(JURI::base().'components/com_biblestudy/js/noconflict.js');
		$document->addScript(JURI::base().'components/com_biblestudy/js/biblestudy.js');
		JHTML::_('stylesheet', 'icons.css', JURI::base().'components/com_biblestudy/css/');
		$teacheredit		=& $this->get('Data');
		$admin=& $this->get('Admin');
		$admin_params = new JParameter($admin[0]->params);
		$isNew		= ($teacheredit->id < 1);
		$editor =& JFactory::getEditor();
		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Teacher Edit' ).': <small><small>[ ' . $text.' ]</small></small>', 'teachers.png' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			JToolBarHelper::apply();
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
		jimport( 'joomla.i18n.help' );
		JToolBarHelper::help( 'biblestudy', true );
		
		$images = new jbsImages();
		$directory = $images->getTeacherImageFolder(); //dump ($directory, 'directory: ');
		$teacherImagePath = JPATH_SITE .DS. $directory;
		$teacherImageList = JFolder::files($teacherImagePath, null, null, null, array('index.html'));

		array_unshift($teacherImageList, '- '.JText::_('No Image').' -');
		
		foreach($teacherImageList as $key=>$value) {
			$teacherImageOptions[] = JHTML::_('select.option', $value, $value);
		}
		$teacherImageOptions[0]->value = 0; //Set the value of the "- No Image -" to 0. Makes it easier for jquery
		
		$lists['teacher_thumbnail'] = JHTML::_('select.genericlist',  $teacherImageOptions, 'teacher_thumbnail', 'class="imgChoose" size="1"', 'value', 'text',  $teacheredit->teacher_thumbnail);
		$lists['teacher_image'] = JHTML::_('select.genericlist',  $teacherImageOptions, 'teacher_image', 'class="imgChoose" size="1"', 'value', 'text', $teacheredit->teacher_image);
		
// build the html select list for ordering
	$query = 'SELECT ordering AS value, ordering AS text'
	. ' FROM #__bsms_teachers'
	. ' WHERE catid = '. (int) $teacheredit->catid	. ' ORDER BY ordering'
	;
	$lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $teacheredit->published);
	$lists['list_show'] = JHTML::_('select.booleanlist', 'list_show', 'class="inputbox"', $teacheredit->list_show);
	$lists['ordering'] 			= JHTML::_('list.specificordering',  $teacheredit, $teacheredit->id, $query, 1 );	
		$this->assignRef( 'editor', $editor );
		$this->assignRef('teacheredit',		$teacheredit);
		$this->assignRef('lists', $lists);
		$this->assignRef('admin_params', $admin_params);
		$this->assignRef('directory', $directory);
		parent::display($tpl);
	}
}
?>
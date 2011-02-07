<?php

/**
 * @version     $Id: foldersedit.php 1466 2011-01-31 23:13:03Z bcordis $
 * @package     com_biblestudy
 * @license     GNU/GPL
 */
//No Direct Access
defined('_JEXEC') or die();

    jimport('joomla.application.component.controllerform');

    abstract class controllerClass extends JControllerForm {

    }

class biblestudyControllerfoldersedit extends controllerClass
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	protected $view_list = 'folderslist';
	 
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
	}

	/**
	 * display the edit form
	 * @return void
	 */
	function legacyedit()
	{
		JRequest::setVar( 'view', 'foldersedit' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function legacysave()
	{
		$model = $this->getModel('foldersedit');
		
		if ($model->store($post)) {
			$msg = JText::_( 'JBS_FLD_FOLDER_SAVED' );
		} else {
			$msg = JText::_( 'JBS_FLD_ERROR_SAVING_FOLDER' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_biblestudy&view=folderslist';
		$this->setRedirect($link, $msg);
	}

	/**
	 * apply a record
	 * @return void
	 */
	function legacyapply()
	{
		$model = $this->getModel('foldersedit');
		$cid 	= JRequest::getVar( 'id', 1, 'post', 'int' );		
		if ($model->store($post)) {
			$msg = JText::_( 'JBS_FLD_FOLDER_SAVED' );
		} else {
			$msg = JText::_( 'JBS_FLD_ERROR_SAVING_FOLDER' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_biblestudy&controller=foldersedit&task=edit&cid[]='.$cid.'';
		$this->setRedirect($link, $msg);
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function legacyremove()
	{
		$model = $this->getModel('foldersedit');
		if(!$model->delete()) {
			$msg = JText::_( 'JBS_FLD_ERROR_DELETING_FOLDER' );
		} else {
			$msg = JText::_( 'JBS_FLD_FOLDERS_DELETED' );
		}

		$this->setRedirect( 'index.php?option=com_biblestudy&view=folderslist', $msg );
	}
function legacypublish()
	{
		$mainframe =& JFactory::getApplication();

		$cid 	= JRequest::getVar( 'cid', array(0), 'post', 'array' );

		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'JBS_CMN_SELECT_ITEM_PUBLISH' ) );
		}

		$model = $this->getModel('foldersedit');
		if(!$model->publish($cid, 1)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_biblestudy&view=folderslist' );
	}


	function legacyunpublish()
	{
		$mainframe =& JFactory::getApplication();

		$cid 	= JRequest::getVar( 'cid', array(0), 'post', 'array' );

		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'JBS_CMN_SELECT_ITEM_UNPUBLISH' ) );
		}

		$model = $this->getModel('foldersedit');
		if(!$model->publish($cid, 0)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_biblestudy&view=folderslist' );
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function legacycancel()
	{
		$msg = JText::_( 'JBS_CMN_OPERATION_CANCELLED' );
		$this->setRedirect( 'index.php?option=com_biblestudy&view=folderslist', $msg );
	}
}
?>
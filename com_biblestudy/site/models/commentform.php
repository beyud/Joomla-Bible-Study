<?php
/**
 * Part of Joomla BibleStudy Package
 *
 * @package    BibleStudy.Admin
 * @copyright  (C) 2007 - 2013 Joomla Bible Study Team All rights reserved
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://www.JoomlaBibleStudy.org
 * */
// No Direct Access
defined('_JEXEC') or die;

// Base this model on the backend version.
// --require_once JPATH_ADMINISTRATOR . '/components/com_biblestudy/models/comment.php';
JLoader::register('BiblestudyModelComment', JPATH_ADMINISTRATOR . '/components/com_biblestudy/models/comment.php');
/**
 * Comment model class
 *
 * @package  BibleStudy.Admin
 * @since    7.0.0
 */
class BiblestudyModelCommentform extends BiblestudyModelComment
{

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('site');

		// Load state from the request.
		$pk = $app->input->getInt('a_id');
		$this->setState('comment.id', $pk);

		$option = $app->input->get('option', '', 'cmd');
		$app    = JFactory::getApplication();
		$app->setUserState($option . 'comment.id', $pk);

		$return = $app->input->get('return', null, 'base64');
		$this->setState('return_page', base64_decode($return));

		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);

		$this->setState('layout', $app->input->get('layout'));
	}

	/**
	 * Method to get a single record.
	 *
	 * @param   integer $pk  The id of the primary key.
	 *
	 * @return  mixed    Object on success, false on failure.
	 */
	public function getItem($pk = null)
	{
		// Initialise variables.
		$pk = (int) (!empty($pk)) ? $pk : $this->getState('comment.id');

		// Get a row instance.
		$table = $this->getTable();

		// Attempt to load the row.
		$return = $table->load($pk);

		// Check for a table object error.
		if ($return === false)
		{
			return false;
		}

		$properties = $table->getProperties(1);
		$value      = JArrayHelper::toObject($properties, 'JObject');

		return $value;
	}

	/**
	 * Get the return URL.
	 *
	 * @return  string    The return URL.
	 *
	 * @since    1.6
	 */
	public function getReturnPage()
	{
		return base64_encode($this->getState('return_page'));
	}

}

<?php
/**
 * @package    BibleStudy.Admin
 * @copyright  2007 - 2013 Joomla Bible Study Team All rights reserved
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://www.JoomlaBibleStudy.org
 */
defined('_JEXEC') or die;

JLoader::register('JBSMDbHelper', JPATH_ADMINISTRATOR . '/components/com_biblestudy/helpers/dbhelper.php');

/**
 * Update for 8.1.0 class
 *
 * @package  BibleStudy.Admin
 * @since    8.1.0
 */
class JBSM810Update
{
	/**
	 * Call Script for Updates of 8.1.0
	 *
	 * @return bool
	 */
	public function update810()
	{
		self::updatetemplates();

		return true;
	}

	/**
	 * Update Templates to work with 8.1.0 that cannot be don doing normal sql file.
	 *
	 * @return void
	 */
	public function updatetemplates()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id, title, prarams')
			->from('#__bsms_templates');
		$db->setQuery($query);
		$data = $db->loadObjectList();
		foreach ($data as $d)
		{
			// Load Table Data.
			JTable::addIncludePath(JPATH_COMPONENT . '/tables');
			$table = JTable::getInstance('Template', 'Table', array('dbo' => $db));

			try
			{
				$table->load($d->id);
			}
			catch (Exception $e)
			{
				echo 'Caught exception: ', $e->getMessage(), "\n";
			}

			// Store the table to invoke defaults of new params

			$table->store();
		}
	}


}

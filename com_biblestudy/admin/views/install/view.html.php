<?php
/**
 * @package    BibleStudy.Admin
 * @copyright  (C) 2007 - 2011 Joomla Bible Study Team All rights reserved
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://www.JoomlaBibleStudy.org
 * */
// No Direct Access
defined('_JEXEC') or die;

JLoader::register(
	'Com_BiblestudyInstallerScript',
	JPATH_ADMINISTRATOR . '/components/com_biblestudy/biblestudy.script.php'
);

/**
 * JView class for Install
 *
 * @package  BibleStudy.Admin
 * @since    7.1.0
 */
class BiblestudyViewInstall extends JViewLegacy
{
	public $msg;

	public $jbsname;

	public $jbstype;

	public $status;

	/**
	 * Display
	 *
	 * @param   string  $tpl  Template to display
	 *
	 * @return null
	 */
	public function display($tpl = null)
	{

		$input         = new JInput;
		$this->msg     = $input->get('msg', '', 'post');
		$this->jbsname = $input->get('jbsname');
		$this->jbstype = $input->get('jbstype');

		if ($this->jbsname === null || $this->jbstype === null)
		{
			JFactory::getApplication()->enqueueMessage(JText::_('JBS_INS_WARNING_INSTALL'), 'warning');
			$input->set('hidemainmenu', true);

			return false;
		}
		JHTML::stylesheet('media/com_biblestudy/css/general.css');

		// Install systems setup files
		$this->installsetup();

		// Remove old files
		$installer = new Com_BiblestudyInstallerScript;
		$installer->deleteUnexistingFiles();

		$this->addToolbar();

		// Set the document
		$this->setDocument();

		// Display the template
		return parent::display($tpl);
	}

	/**
	 * Add Toolbar to page
	 *
	 * @since 7.0.0
	 *
	 * @return null
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);
		JToolBarHelper::help('biblestudy', true);
		JToolBarHelper::title(JText::_('JBS_CMN_INSTALL'), 'administration');
	}

	/**
	 * Add the page title to browser.
	 *
	 * @since    7.1.0
	 *
	 * @return null
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::sprintf('JBS_TITLE_INSTALL', $this->jbstype, $this->jbsname));
	}

	/**
	 * Setup Array for install System
	 *
	 * @since 7.0.0
	 *
	 * @return null
	 */
	protected function installsetup()
	{
		$installation_queue = array(
			// Example: modules => { (folder) => { (module) => { (position), (published) } }* }*
			'modules' => array(
				'admin' => array(),
				'site'  => array(
					'biblestudy'         => 0,
					'biblestudy_podcast' => 0,
				)
			),
			// Example: plugins => { (folder) => { (element) => (published) }* }*
			'plugins' => array(
				'finder' => array(
					'biblestudy' => 1,
				),
				'search' => array(
					'biblestudysearch' => 0,
				),
				'system' => array(
					'jbsbackup'  => 0,
					'jbspodcast' => 0,
				)
			)
		);

		// -- General settings

		jimport('joomla.installer.installer');
		$db                    = JFactory::getDBO();
		$this->status          = new JObject;
		$this->status->modules = array();
		$this->status->plugins = array();

		// Modules installation
		if (count($installation_queue['modules']))
		{
			foreach ($installation_queue['modules'] as $folder => $modules)
			{
				if (count($modules))
				{
					foreach ($modules as $module => $modulePreferences)
					{
						// Was the module already installed?
						$sql = 'SELECT COUNT(*) FROM #__modules WHERE `module`=' . $db->Quote('mod_' . $module);
						$db->setQuery($sql);
						$result                  = $db->loadResult();
						$this->status->modules[] = array(
							'name'   => 'mod_' . $module,
							'client' => $folder,
							'result' => $result
						);
					}
				}
			}
		}
		// Plugins installation
		if (count($installation_queue['plugins']))
		{
			foreach ($installation_queue['plugins'] as $folder => $plugins)
			{
				if (count($plugins))
				{
					foreach ($plugins as $plugin => $published)
					{
						$query = "SELECT COUNT(*) FROM  #__extensions WHERE element=" . $db->Quote(
							$plugin
						) . " AND folder=" . $db->Quote($folder);
						$db->setQuery($query);
						$result                  = $db->loadResult();
						$this->status->plugins[] = array(
							'name'   => 'plg_' . $plugin,
							'group'  => $folder,
							'result' => $result
						);
					}
				}
			}
		}
	}

}

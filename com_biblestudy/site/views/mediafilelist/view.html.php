<?php
/**
 * @package    BibleStudy.Site
 * @copyright  (C) 2007 - 2011 Joomla Bible Study Team All rights reserved
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://www.JoomlaBibleStudy.org
 * */
// No Direct Access
defined('_JEXEC') or die;
require_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components/com_biblestudy/helpers/biblestudy.php';
JLoader::register('JBSAdmin', JPATH_ADMINISTRATOR . '/components/com_biblestudy/lib/biblestudy.admin.class.php');
JLoader::register('JBSMParams', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/params.php');

jimport('joomla.application.component.helper');
jimport('joomla.html.toolbar');

/**
 * View class for MediaFilelist
 *
 * @property mixed document
 * @package  BibleStudy.Site
 * @since    7.0.0
 */
class BiblestudyViewMediafilelist extends JViewLegacy
{

	/**
	 * Items
	 *
	 * @var JObject
	 */
	protected $items;

	/**
	 * Pagination
	 *
	 * @var array
	 */
	protected $pagination;

	/**
	 * State
	 *
	 * @var object
	 */
	protected $state;

	public $canDo;

	public $mediatypes;

	/**
	 * @var object
	 */
	protected  $admin;

	/**
	 * @var JRegistry
	 */
	protected  $params;

	public $pageclass_sfx;
	public $newlink;

	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	public function display($tpl = null)
	{
		$app              = JFactory::getApplication();
		$this->canDo      = JBSMHelper::getActions('', 'mediafilesedit');
		$this->state      = $this->get('State');
		$this->items      = $this->get('Items');
		$this->mediatypes = $this->get('Mediatypes');
		$this->pagination = $this->get('Pagination');
		$this->admin      = JBSMParams::getAdmin();
		$document         = JFactory::getDocument();
		$document->addStyleSheet(JURI::base() . 'media/com_biblestudy/css/icons.css');

		// Check for errors
		if (count($errors = $this->get('Errors')))
		{
			$app->enqueueMessage(implode("\n", $errors), 'error');

			return;
		}

		if (!$this->canDo->get('core.edit'))
		{
			$app->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'error');

			return;
		}

		// Create a shortcut to the parameters.
		$params = & $this->state->params;
		$params->merge($this->admin->params);
		$this->admin->params->merge($params);
		$this->params = $params;

		// Render the toolbar on the page. rendering it here means that it is displayed on every view of your component.
		// Puts a new record link at the top of the form
		if ($this->canDo->get('core.create'))
		{
			$this->newlink = '<a href="index.php?option=com_biblestudy&view=mediafile&task=mediafile.edit">' . JText::_('JBS_CMN_NEW') . '</a>';
		}

		// Escape strings for HTML output
		$this->pageclass_sfx = htmlspecialchars($params->get('pageclass_sfx'));

		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 *
	 * @return void
	 */
	protected function _prepareDocument()
	{
		$app     = JFactory::getApplication();
		$menus   = $app->getMenu();
		$pathway = $app->getPathway();
		$title   = null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();

		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', JText::_('JBS_FORM_EDIT_ARTICLE'));
		}

		$title = $this->params->def('page_title', '');
		$title .= ' : ' . JText::_('JBS_TITLE_MEDIA_FILES');

		if ($app->getCfg('sitename_pagetitles', 0) == 1)
		{
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2)
		{
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}
		$this->document->setTitle($title);

		$pathway = $app->getPathWay();
		$pathway->addItem($title, '');

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
			'study.studytitle'     => JText::_('JBS_CMN_STUDY_TITLE'),
			'mediatype.media_text' => JText::_('JBS_MED_MEDIA_TYPE'),
			'mediafile.filename'   => JText::_('JBS_MED_FILENAME'),
			'mediafile.published'  => JText::_('JSTATUS'),
			'mediafile.id'         => JText::_('JGRID_HEADING_ID')
		);
	}

}
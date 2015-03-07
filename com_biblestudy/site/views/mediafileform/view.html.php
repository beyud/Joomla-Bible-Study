<?php
/**
 * Part of Joomla BibleStudy Package
 *
 * @package    BibleStudy.Admin
 * @copyright  2007 - 2015 (C) Joomla Bible Study Team All rights reserved
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://www.JoomlaBibleStudy.org
 * */
// No Direct Access
defined('_JEXEC') or die;

use Joomla\Registry\Registry;
/**
 * View class for MediaFile
 *
 * @property mixed document
 * @package  BibleStudy.Site
 * @since    7.0.0
 */
class BiblestudyViewMediafileform extends JViewLegacy
{

	/** @var object */
	public $canDo;

	/** @var Registry */
	public $admin_params;

	/** @var Registry */
	public $params;

	/** @var object */
	protected $form;

	/** @var object */
	protected $media_form;

	/** @var object */
	protected $item;

	/** @var Registry */
	protected $state;

	/** @var object */
	protected $admin;

	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	public function display($tpl = null)
	{
		$this->form         = $this->get("Form");
		$this->media_form   = $this->get("MediaForm");
		$this->item         = $this->get("Item");
		$this->state        = $this->get("State");
		$this->canDo        = JBSMBibleStudyHelper::getActions($this->item->id, 'mediafile');
		$this->admin_params = $this->state->get('admin');


		// Needed to load the article field type for the article selector
		JFormHelper::addFieldPath(JPATH_ADMINISTRATOR . '/components/com_content/models/fields/modal');

		$this->canDo = JBSMBibleStudyHelper::getActions($this->item->id, 'mediafilesedit');

		$this->params = $this->state->template->params;

		$language = JFactory::getLanguage();
		$language->load('', JPATH_ADMINISTRATOR, null, true);

		if (!$this->canDo->get('core.edit'))
		{
			JFactory::getApplication()->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'error');

			return;
		}

		$db = JFactory::getDBO();

		// Get server for upload dropdown
		$query = $db->getQuery(true);
		$query->select('id as value, server_name as text')->from('#__bsms_servers')->where('published=1')->order('server_name asc');
		$db->setQuery($query);
		$db->execute();
		$server              = array(
			array(
				'value' => '',
				'text'  => JText::_('JBS_MED_SELECT_SERVER')
			),
		);
		$serverlist          = array_merge($server, $db->loadObjectList());
		$idsel               = "'SWFUpload_0'";
		$ref1                = JHTML::_('select.genericList', $serverlist, 'upload_server', 'class="inputbox" onchange="showupload(' . $idsel . ')"'
			. '', 'value', 'text', ''
		);
		$this->upload_server = $ref1;

		$this->setLayout('edit');

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
		if (JBSPAGETITLE)
		{
			$title = $this->params->def('page_title', '');
		}
		else
		{
			$title = JText::_('JBS_CMN_JOOMLA_BIBLE_STUDY');
		}
		$isNew = ($this->item->id == 0);
		$state = $isNew ? JText::_('JBS_CMN_NEW') : JText::sprintf('JBS_CMN_EDIT', $this->form->getValue('studytitle'));
		$title .= ' : ' . $state;

		if ($app->get('sitename_pagetitles', 0) == 1)
		{
			$title = JText::sprintf('JPAGETITLE', $app->get('sitename'), $title);
		}
		elseif ($app->get('sitename_pagetitles', 0) == 2)
		{
			$title = JText::sprintf('JPAGETITLE', $title, $app->get('sitename'));
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

}

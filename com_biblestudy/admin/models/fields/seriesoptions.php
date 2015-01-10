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

// Import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Books List Form Field class for the Joomla Bible Study component
 *
 * @package  BibleStudy.Admin
 * @since    7.0.0
 */
class JFormFieldSeriesoptions extends JFormFieldList
{

	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'Seriesoptions';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return      array           An array of JHtml options.
	 */
	protected function getOptions()
	{
		$options[] = JHtml::_('select.option', '5', JText::_('JBS_TPL_TITLE_BRACE'));
		$options[] = JHtml::_('select.option', '10', JText::_('JBS_TPL_DATE_BRACE'));
		$options[] = JHtml::_('select.option', '7', JText::_('JBS_TPL_TEACHER_BRACE'));
		$options[] = JHtml::_('select.option', '8', JText::_('JBS_TPL_TITLE_TEACHER_BRACE'));
		$options[] = JHtml::_('select.option', '1', JText::_('JBS_TPL_SCRIPTURE1_BRACE'));
		$options[] = JHtml::_('select.option', '2', JText::_('JBS_TPL_SCRIPTURE2_BRACE'));
		$options[] = JHtml::_('select.option', '3', JText::_('JBS_TPL_SECONDARY_REFERENCES_BRACE'));
		$options[] = JHtml::_('select.option', '4', JText::_('JBS_TPL_DURATION_BRACE'));
		$options[] = JHtml::_('select.option', '25', JText::_('JBS_TPL_SERIES_THUMBNAIL_BRACE'));
		$options[] = JHtml::_('select.option', '6', JText::_('JBS_TPL_STUDY_INTRO_BRACE'));
		$options[] = JHtml::_('select.option', '12', JText::_('JBS_TPL_HITS_BRACE'));
		$options[] = JHtml::_('select.option', '13', JText::_('JBS_TPL_STUDYNUMBER_BRACE'));
		$options[] = JHtml::_('select.option', '14', JText::_('JBS_TPL_TOPIC_BRACE'));
		$options[] = JHtml::_('select.option', '15', JText::_('JBS_TPL_LOCATION_BRACE'));
		$options[] = JHtml::_('select.option', '16', JText::_('JBS_TPL_MESSAGETYPE_BRACE'));
		$options[] = JHtml::_('select.option', '17', JText::_('JBS_TPL_DETAILS_TEXT_BRACE'));
		$options[] = JHtml::_('select.option', '18', JText::_('JBS_TPL_DETAILS_TEXT_PDF'));
		$options[] = JHtml::_('select.option', '19', JText::_('JBS_TPL_DETAILS_PDF'));
		$options[] = JHtml::_('select.option', '20', JText::_('JBS_TPL_MEDIA_BRACE'));
		$options[] = JHtml::_('select.option', '22', JText::_('JBS_TPL_STORE_BRACE'));
		$options[] = JHtml::_('select.option', '23', JText::_('JBS_TPL_FILESIZE_BRACE'));
		$options[] = JHtml::_('select.option', '28', JText::_('JBS_TPL_MEDIA_PLAYS'));
		$options[] = JHtml::_('select.option', '29', JText::_('JBS_TPL_MEDIA_DOWNLOADS'));
		$options   = array_merge(parent::getOptions(), $options);

		return $options;
	}

}

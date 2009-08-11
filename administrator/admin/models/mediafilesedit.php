<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class biblestudyModelmediafilesedit extends JModel {
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	var $_admin;
	function __construct()
	{
		parent::__construct();
		$admin = $this->getAdmin();
		$this->_admin_params = new JParameter($admin[0]->params);
		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}


	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}


	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__bsms_mediafiles '.
					'  WHERE id = '.$this->_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			//TF added these
			$today = date("Y-m-d H:i:s");
			$this->_data->published = 1;
			$this->_data->media_image = ($this->_admin_params->get('media') != 'Use Default' ? $this->_admin_params->get('media') : null);
			$this->_data->server = ($this->_admin_params->get('server') > 0 ? $this->_admin_params->get('server') : null);
			$this->_data->path = ($this->_admin_params->get('path') > 0 ? $this->_admin_params->get('path') : null);
			$this->_data->special =($this->_admin_params->get('target') != 'No default' ? $this->_admin_params->get('target') : null);;
			$this->_data->filename = null;
			$this->_data->size = null;
			$this->_data->podcast_id = ($this->_admin_params->get('podcast') > 0 ? $this->_admin_params->get('podcast') : null);
			$this->_data->internal_viewer = ($this->_admin_params->get('avr') > 0 ? $this->_admin_params->get('avr') : null);
			$this->_data->mediacode = null;
			$this->_data->ordering = null;
			$this->_data->study_id = null;
			$this->_data->createdate = $today;
			$this->_data->link_type = ($this->_admin_params->get('download') > 0 ? $this->_admin_params->get('download') : null);
			$this->_date->hits = null;
			$this->_data->mime_type = ($this->_admin_params->get('mime') > 0 ? $this->_admin_params->get('mime') : null);
			$this->_data->docManCategory = null;
			$this->_data->docManItem = null;
			$this->_data->articleSection = null;
			$this->_data->articleCategory = null;
			$this->_data->articleTitle = null;
			$this->_data->comment = null;
				
		}
		return $this->_data;
	}

	/**
	 * Method to store a record
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @todo Need to check the current order of the studies for that particular
	 * study, so that it doesn't default to 0, buecause that will break the
	 * ordering functionality.
	 */
	function store()
	{
		$row =& $this->getTable();

		$data = JRequest::get( 'post' );
		//This checks to see if the user has uploaded a file instead of just entered one in the box. It replaces the filename with the name of the uploaded file
		$file = JRequest::getVar('file', null, 'files', 'array' );
		$filename_upload = strtolower($file['name']);
		if (isset($filename_upload)){
			$name_bak = $data['filename'];
			$data['filename'] = $filename_upload;
		}
		if ($filename_upload == ''){$data['filename'] = $name_bak;}
		//$data['filename'] = str_replace(' ','_',$data['filename']);
		$badchars = array(' ', '`', '@', '^', '!', '#', '$', '%', '*', '(', ')', '[', ']', '{', '}', '~', '?', '/', '>', '<', ',', '|', '\\', ';', ':');
		$data['filename'] = str_replace($badchars, '_', $data['filename']);
		$data['filename'] = str_replace('&', '_and_', $data['filename']);
		$data['mediacode'] = str_replace('"',"'",$data['mediacode']);
		//$data['mediacode'] = JRequest::getVar( 'mediacode', '', 'post', 'string', JREQUEST_ALLOWRAW );
		// Bind the form fields to the  table
		//dump($data);
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the  record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the table to the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			//			$this->setError( $row->getErrorMsg() );
			return false;
		}

		return true;
	}

	/**
	 * Method to delete record(s)
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$row =& $this->getTable();

		if (count( $cids ))
		{
			foreach($cids as $cid) {
				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
			}
		}
		return true;
	}
	function publish($cid = array(), $publish = 1)
	{

		if (count( $cid ))
		{
			$cids = implode( ',', $cid );

			$query = 'UPDATE #__bsms_mediafiles'
			. ' SET published = ' . intval( $publish )
			. ' WHERE id IN ( '.$cids.' )'
				
			;
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
	}
	/**
	 * Method to move a mediafile listing
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function move($direction)
	{
		$row =& $this->getTable();
		if (!$row->load($this->_id)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$row->move( $direction, ' study_id = '.(int) $row->study_id.' AND published >= 0 ' )) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}

	/**
	 * Method to move a mediafile listing
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function saveorder($cid = array(), $order)
	{
		$row =& $this->getTable();
		$groupings = array();

		// update ordering values
		for( $i=0; $i < count($cid); $i++ )
		{
			$row->load( (int) $cid[$i] );
			// track categories
			$groupings[] = $row->study_id;

			if ($row->ordering != $order[$i])
			{
				$row->ordering = $order[$i];
				if (!$row->store()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
			}
		}

		// execute updateOrder for each parent group
		$groupings = array_unique( $groupings );
		foreach ($groupings as $group){
			$row->reorder('study_id = '.(int) $group);
		}

		return true;
	}

	function getAdmin()
	{
		if (empty($this->_admin)) {
			$query = 'SELECT params'
			. ' FROM #__bsms_admin'
			. ' WHERE id = 1';
			$this->_admin = $this->_getList($query);
		}
		return $this->_admin;
	}

	
	/**
	 * @desc Functions to satisfy the ajax requests
	 */
	function getdocManCategories() {
		$query = "SELECT id, title FROM #__categories
				  WHERE `section` = 'com_docman' AND `published`=1";
		return $this->_getList($query);
	}

	function getdocManCategoryItems($catId) {
		$query = "SELECT id, dmname as name FROM #__docman
				  WHERE `catid`='$catId' AND `published`=1";
		return json_encode($this->_getList($query));
	}

	function getArticlesSections(){
		$query = "SELECT id, title FROM #__sections WHERE `published` = 1";
		return $this->_getList($query);
	}

	function getArticlesSectionCategories($secId) {
		$query = "SELECT id, title FROM #__categories WHERE `section` = '$secId' AND `published` = 1";
		return json_encode($this->_getList($query));
	}

	function getCategoryItems($catId) {
		$query = "SELECT id, title FROM #__content WHERE `state` = 1 AND `catid` = '$catId'";
		return json_encode($this->_getList($query));
	}
}
?>

<?php
/**
 * BibleStudy Download Class
 *
 * @package        BibleStudy.Site
 * @copyright  (C) 2007 - 2013 Joomla Bible Study Team All rights reserved
 * @license        http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link           http://www.JoomlaBibleStudy.org
 * */
// No Direct Access
defined('_JEXEC') or die;

jimport('joomla.environment.response');

/**
 * BibleStudy Download Class
 *
 * @package  BibleStudy.Site
 * @since    7.0.0
 */
class Dump_File
{

	/**
	 * Method to send file to browser
	 *
	 * @param   int  $mid  ID of media
	 *
	 * @since 6.1.2
	 * @return null
	 *
	 * @throws string
	 */
	public function download($mid)
	{
		// Clears file status cache
		clearstatcache();

		$this->hitDownloads((int) $mid);
		$input    = new JInput;
		$template = $input->get('t', '1', 'int');
		$db       = JFactory::getDBO();

		// Get the template so we can find a protocol
		$query = $db->getQuery(true);
		$query->select('id, params')->from('#__bsms_templates')->where('id = ' . $template);
		$db->setQuery($query);
		$template = $db->loadObject();

		// Convert parameter fields to objects.
		$registry = new JRegistry;
		$registry->loadString($template->params);
		$params = $registry;

		$protocol = $params->get('protocol', '//');
		$query    = $db->getQuery(true);
		$query->select('#__bsms_mediafiles.*,'
			. ' #__bsms_servers.id AS ssid, #__bsms_servers.server_path AS spath,'
			. ' #__bsms_folders.id AS fid, #__bsms_folders.folderpath AS fpath,'
			. ' #__bsms_mimetype.id AS mtid, #__bsms_mimetype.mimetype')
			->from('#__bsms_mediafiles')
			->leftJoin('#__bsms_servers ON (#__bsms_servers.id = #__bsms_mediafiles.server)')
			->leftJoin('#__bsms_folders ON (#__bsms_folders.id = #__bsms_mediafiles.path)')
			->leftJoin('#__bsms_mimetype ON (#__bsms_mimetype.id = #__bsms_mediafiles.mime_type)')
			->where('#__bsms_mediafiles.id = ' . $mid);
		$db->setQuery($query, 0, 1);

		$media = $db->LoadObject();
		JResponse::clearHeaders();
		$server        = $media->spath;
		$path          = $media->fpath;
		$filename      = $media->filename;
		$size          = $media->size;
		$download_file = $protocol . $server . $path . $filename;
		/** @var $download_file object */
		$getsize = $this->getRemoteFileSize($download_file);

		if (!$size || ($size != $getsize && $getsize != false))
		{
				$size = $getsize;
		}

		@set_time_limit(0);
		ignore_user_abort(false);
		ini_set('output_buffering', 0);
		ini_set('zlib.output_compression', 0);

		// Bytes per chunk (10 MB)
		$chunk = 10 * 1024 * 1024;

		$fh = fopen($download_file, "rb");

		if ($fh === false)
		{
			echo "Unable to open file";
		}

		// Clean the output buffer, Added to fix ZIP file corruption
		@ob_end_clean();
		@ob_start();

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
		header('Expires: 0');
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false);
		header('Pragma: public');
		header("Content-Transfer-Encoding: binary");
		header('Content-Length: ' . $getsize);

		// Repeat reading until EOF
		while (!feof($fh))
		{
			echo fread($fh, $chunk);
			@ob_flush();
			@flush();
		}
		fclose($fh);
		exit;
	}

	/**
	 * Method tho track Downloads
	 *
	 * @param   int  $mid  Media ID
	 *
	 * @return  boolean
	 *
	 * @throws  string
	 * @since   7.0.0
	 */
	protected function hitDownloads($mid)
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->update('#__bsms_mediafiles')->set('downloads = downloads + 1')->where('id = ' . $mid);
		$db->setQuery($query);
		$db->execute();

		return true;
	}

	/**
	 * Method to get file size
	 *
	 * @param   object  $url  URL
	 *
	 * @return  boolean
	 */
	protected function getRemoteFileSize($url)
	{
		$parsed = parse_url($url);
		$host   = $parsed["host"];
		$fp     = null;

		if (function_exists('fsockopen'))
		{
			$fp = @fsockopen($host, 80, $errno, $errstr, 20);
		}
		if (!$fp)
		{
			return false;
		}
		else
		{
			@fputs($fp, "HEAD $url HTTP/1.1\r\n");
			@fputs($fp, "HOST: $host\r\n");
			@fputs($fp, "Connection: close\r\n\r\n");
			$headers = "";

			while (!@feof($fp))
			{
				$headers .= @fgets($fp, 128);
			}
		}
		@fclose($fp);
		$return      = false;
		$arr_headers = explode("\n", $headers);

		foreach ($arr_headers as $header)
		{
			$s = "Content-Length: ";

			if (substr(strtolower($header), 0, strlen($s)) == strtolower($s))
			{
				$return = trim(substr($header, strlen($s)));
				break;
			}
		}

		return $return;
	}

}

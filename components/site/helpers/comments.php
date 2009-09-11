<?php defined('_JEXEC') or die();

function getComments($params, $row, $Itemid)
{
		$database	= & JFactory::getDBO();
		$editor =& JFactory::getEditor();
		
		$query = 'SELECT c.* FROM #__bsms_comments AS c WHERE c.published = 1 AND c.study_id = '.$row->id.' ORDER BY c.comment_date ASC';
				//dump ($query, 'row');
		$database->setQuery($query);
		$commentsresult = $database->loadObjectList();
		$pageclass_sfx = $params->get('pageclass_sfx');
		$Itemid = JRequest::getVar('Itemid');
		$commentjava = "javascript:ReverseDisplay('comments')";
		$comments = '<strong><a class="heading'.$pageclass_sfx.'" href="'.$commentjava.'">>>'.JText::_('Show/Hide Comments').'<<</a>
		<div id="comments" style="display:none;"></strong><br />';
if (count($commentsresult)) {
$comments .= '
		<table id="bslisttable" cellspacing="0"><thead><tr class="lastrow"><th id="commentshead" class="row1col1">
		'.JText::_('Comments').'</th></tr></thead>';

		foreach ($commentsresult as $comment){

		$comment_date_display = JHTML::_('date',  $comment->comment_date, JText::_('DATE_FORMAT_LC3') , '$offset' );
		$comments .= '<tbody>';
		$comments .= '<tr><td><strong>'.$comment->full_name.'</strong> <i> - '.$comment_date_display.'</i></td></tr><tr><td>'.JText::_('Comment: ').$comment->comment_text.'</td></tr><tr><td><hr /></td></tr>';
		}//end of foreach
		
		$comments .= '</td></tr></tbody></table>';
	} // End of if(count($commentsresult))
		
		
		
		

		
		$comments .= '<table id="commentssubmittable">';
		
		$user =& JFactory::getUser();
		//$this->assignRef('thestudy',$this->studydetails->study_id);
		$comment_access = $params->get('comment_access');
		$comment_user = $user->usertype;
		if (!$comment_user) { $comment_user = 0;}
		if ($comment_access > $comment_user){$comments .= '<tr><td><strong>'.JText::_('You must be registered to post comments').'</strong></td></tr>';}else{
		$comments .= '<tr><td>';
		if ($user->name){$full_name = $user->name; } else {$full_name = ''; } 
		if ($user->email) {$user_email = $user->email;} else {$user_email = '';}
		
		$comments .= '<form action="index.php" method="post"><strong>'
		.JText::_('Post a Comment').'</strong></td></tr>
		<tr><td>'.JText::_('First & Last Name: ').
		'</td><td><input class="text_area" size="50" type="text" name="full_name" id="full_name" value="'.$full_name.'" /></td></tr>
		<tr><td>'.JText::_('Email (Not displayed): ').'</td><td><input class="text_area" type="text" size="50" name="user_email" id="user_email" value="'.$user->email.'" /></td></tr>
		<tr><td>'.JText::_('Comment: ').'</td>';
		//$comments .= $editor->display('comment_text', 'comment_text', '100%', '400', '70', '15').'</td></tr></table>';	
		$comments .= '<td><textarea class="text_area" cols="20" rows="4" style="width:400px" name="comment_text" id="comment_text"></textarea></td></tr></table>';
//dump ($params->get('use_captcha'), 'captch: ');
		if ($params->get('use_captcha') > 0) { 
		
		// Begin captcha . Thanks OSTWigits 
		//Must be installed. Here we check that
		if (JPluginHelper::importPlugin('system', 'captcha'))
			{ 								
				$comments .= '<table><tr><td>'.JText::_('Enter the text in the picture').'&nbsp
				<input name="word" type="text" id="word" value="" style="vertical-align:middle" size="10">&nbsp;
				<img src="'.JURI::base().'index.php?option=com_biblestudy&view=studydetails&controller=studydetails&task=displayimg">
				</td></tr>';
			} 
			else 
			{ 
				$comments .= JText::_('Captcha plugin not installed. Please inform site administrator'); 
			} //end of check for OSTWigit plugin							
		
			} // end of if for use of captcha
		//dump ($params->get('comment_publish'));
		$comments .=  '<tr><td>
		<input type="hidden" name="study_id" id="study_id" value="'.$row->id.'" />
		<input type="hidden" name="task" value="comment" />
		<input type="hidden" name="option" value="com_biblestudy" />
		<input type="hidden" name="published" id="published" value="'.$params->get('comment_publish').'"  />
		<input type="hidden" name="view" value="studydetails" />
		<input type="hidden" name="controller" value="studydetails" />
		<input type="hidden" name="comment_date" id="comment_date" value="'.date('Y-m-d H:i:s').'"  />
		<input type="hidden" name="study_detail_id" id="study_detail_id" value="'.$row->id.'"  />
		<input type="hidden" name="Itemid" id="Itemid" value="'.$Itemid.'" />
		<input type="submit" class="button" id="button" value="Submit"  />
		</form></div>';
		} //End of if $comment_access < $comment_user
		//} //End of show_comments on for submit form
		$comments .= '</td></tr></table>';
        
	return $comments;
}
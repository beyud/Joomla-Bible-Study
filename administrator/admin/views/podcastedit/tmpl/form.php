<?php defined('_JEXEC') or die('Restricted access'); ?>
		<script language="javascript" type="text/javascript">
		<!--
		function submitbutton(pressbutton)
		{
			var form = document.adminForm;
			if (pressbutton == 'cancel')
			{
				submitform( pressbutton );
				return;
			}
			// do field validation
			if (form.title.value == "")
			{
				alert( "<?php echo JText::_( 'JBS_PDC_ENTER_PODCAST_TITLE', true ); ?>" );
			}
			else if (form.website.value == "")
			{
				alert( "<?php echo JText::_( 'JBS_PDC_ENTER_WEBSITE', true ); ?>" );
			}
			else if (form.filename.value == "")
			{
				alert( "<?php echo JText::_( 'JBS_PDC_ENTER_XML_FILENAME', true ); ?>" );
			}
			else
			{
				submitform( pressbutton );
			}
		}
        </script>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'JBS_PDC_PODCAST_DETAILS' ); ?></legend>


	<table cellpadding="5" class="admintable">
	<?php if ($this->podcastedit->id) {?>
	<?php $link = JRoute::_( 'index.php?option=com_biblestudy&view=podcastedit&controller=podcastedit&task=writeXMLFile&cid='. $this->podcastedit->id.'&itemidlinkview='.$this->admin_params->get('itemidlinkview','studieslist').'&itemidlinktype='.$this->admin_params->get('itemidlinktype',1).'&itemidlinknumber='.$this->admin_params->get('itemidlinknumber',1) );?>

	<?php } ?>
	<tr>
        <td class="key"><b><?php echo JText::_( 'JBS_CMN_PUBLISHED' ); ?></b></td>
		<td><?php echo $this->lists['published'];?></td>
	</tr>
	<tr>
        <td class="key"><b><?php echo JText::_( 'JBS_PDC_PODCAST_NAME' ); ?></b></td>
		<td><input class="text_area" type="text" name="title" id="title" size="100" maxlength="100" value="<?php echo $this->podcastedit->title;?>" /></td>
	</tr>
	<tr>
		<td class="key"><b><?php echo JText::_( 'JBS_PDC_NUM_RECORDS_INCLUDE' ); ?></b></td>
		<td><input class="text_area" type="text" name="podcastlimit" id="podcastlimit" size="5" maxlength="3" value="<?php echo $this->podcastedit->podcastlimit;?>" /></td>
	</tr>
	<tr>
        <td class="key"><b><?php echo JText::_( 'JBS_PDC_WEBSITE_URL' ); ?></b></td>
		<td><input class="text_area" type="text" name="website" id="website" size="100" maxlength="100" value="<?php echo $this->podcastedit->website;?>" /></td>
	</tr>
	<tr>
        <td class="key"><b><?php echo JText::_( 'JBS_PDC_PODCAST_DESCRIPTION' ); ?></b></td>
		<td><textarea cols="57" class="text_area" name="description" id="description" ><?php echo $this->podcastedit->description;?></textarea></td>
	</tr>
	<tr>
        <td class="key"><b><?php echo JText::_( 'JBS_PDC_IMAGE_URL' ); ?></b></td>
		<td><input class="text_area" type="text" name="image" id="image" size="100" maxlength="130" value="<?php echo $this->podcastedit->image;?>" /></td>
	</tr>
	<tr>
        <td class="key"><b><?php echo JText::_( 'JBS_CMN_IMAGE_HEIGHT_PIXELS' ); ?></b></td>
		<td><input class="text_area" type="text" name="imageh" id="imageh" size="5" maxlength="3" value="<?php echo $this->podcastedit->imageh;?>" /></td>
	</tr>
	<tr>
        <td class="key"><b><?php echo JText::_( 'JBS_CMN_IMAGE_WIDTH_PIXELS' ); ?></b></td>
		<td><input class="text_area" type="text" name="imagew" id="imagew" size="5" maxlength="3" value="<?php echo $this->podcastedit->imagew;?>" /></td>
	</tr>
	<tr>
        <td class="key"><b><?php echo JText::_( 'JBS_PDC_PODCAST_AUTHOR' ); ?></b></td>
		<td><input class="text_area" type="text" name="author" id="author" size="100" maxlength="100" value="<?php echo $this->podcastedit->author;?>" /></td>
	</tr>
	<tr>
        <td class="key"><b><?php echo JText::_( 'JBS_PDC_PODCAST_LOGO' ); ?></b></td>
		<td><input class="text_area" type="text" name="podcastimage" id="podcastimage" size="100" maxlength="130" value="<?php echo $this->podcastedit->podcastimage;?>" /></td>
	</tr>
	<tr>
        <td class="key"><b><?php echo JText::_( 'JBS_PDC_PODCAST_SEARCH_WORDS' ); ?></b></td>
		<td><input class="text_area" type="text" name="podcastsearch" id="podcastsearch" size="100" maxlength="100" value="<?php echo $this->podcastedit->podcastsearch;?>" /></td>
	</tr>
	<tr>
        <td class="key"><b><?php echo JText::_( 'JBS_PDC_PODCAST_XML_FILENAME' ); ?></b></td>
		<td><input class="text_area" type="text" name="filename" id="filename" size="100" maxlength="150" value="<?php echo $this->podcastedit->filename;?>" /></td>
	</tr>
    <tr>
        <td class="key"><b><?php echo JText::_( 'JBS_PDC_TEMPLATE_FOR_DETAILS_VIEW_LINK' ); ?></b></td>
		<td><?php echo $this->lists['templates'];?></td>
	</tr>
	<tr>
        <td class="key"><b><?php echo JText::_( 'JBS_PDC_PODCAST_LANGUAGE' ); ?></b></td>
		<td><input class="text_area" type="text" name="language" id="language" size="5" maxlength="10" value="<?php echo $this->podcastedit->language;?>" /></td>
	</tr>
	<tr>
        <td class="key"><b><?php echo JText::_( 'JBS_PDC_EDITORS_NAME' ); ?></b></td>
		<td><input class="text_area" type="text" name="editor_name" id="editor_name" size="100" maxlength="150" value="<?php echo $this->podcastedit->editor_name;?>" /></td>
	</tr>
	<tr>
        <td class="key"><b><?php echo JText::_( 'JBS_PDC_EDITORS_EMAIL' ); ?></b></td>
		<td><input class="text_area" type="text" name="editor_email" id="editor_email" size="100" maxlength="150" value="<?php echo $this->podcastedit->editor_email;?>" /></td>
	</tr>
    <tr>
        <td class="key"><b><?php echo JText::_('JBS_PDC_EPISODE_TITLE');?></b></td>
        <td><select name="episodetitle" id="episodetitle" class="inputbox" size="1">
        	<option value="z"><?php echo '- '.JText::_('JBS_CMN_SELECT_ITEM').' -';?></option>
        	<option <?php if ($this->podcastedit->episodetitle == 0) {echo 'selected ';}?>value="0"><?php echo JText::_('JBS_PDC_SCRIPTURE_TITLE');?></option>
			<option <?php if ($this->podcastedit->episodetitle == 1) {echo 'selected ';}?>value="1"><?php echo JText::_('JBS_PDC_TITLE_ONLY');?></option>
			<option <?php if ($this->podcastedit->episodetitle == 2) {echo 'selected ';}?>value="2"><?php echo JText::_('JBS_PDC_SCRIPTURE_ONLY');?></option>
			<option <?php if ($this->podcastedit->episodetitle == 3) {echo 'selected ';}?>value="3"><?php echo JText::_('JBS_PDC_TITLE_SCRIPTURE');?></option>
			<option <?php if ($this->podcastedit->episodetitle == 4) {echo 'selected ';}?>value="4"><?php echo JText::_('JBS_PDC_DATE_SCRIPTURE_TITLE');?></option>
            <option <?php if ($this->podcastedit->episodetitle == 5) {echo 'selected ';}?>value="5"><?php echo JText::_('JBS_CMN_CUSTOM');?></option>
    		</select>

        </td>
    </tr>
    <tr>
    	<td class="key"><b><?php echo JText::_('JBS_CMN_CUSTOM');?></b></td>
        <td><input class="text_area" type="text" name="custom" id="custom" size="200" value="<?php echo $this->podcastedit->custom;?>" /></td>
    </tr>
	</table>
	</fieldset>
</div>
<?php if ($this->podcastedit->id) {
$params = &JComponentHelper::getParams($option);?>
	<div class="editcell">
	<fieldset class="adminlist">
		<legend><?php echo JText::_( 'JBS_PDC_EPISODE_THIS_PODCAST' ); ?></legend>
	<table class="admintable" width=100%><tr></tr>

	<thead><tr><th><?php echo JText::_('JBS_CMN_EDIT_MEDIA_FILE');?></th>
	<th><?php echo JText::_('JBS_CMN_MEDIA_CREATE_DATE');?></th>
	<th><?php echo JText::_('JBS_CMN_SCIPTURE');?></th>
	<th><?php echo JText::_('JBS_PDC_EDIT_STUDY');?></th>
	<th><?php echo JText::_('JBS_CMN_TEACHER');?></th>
	</tr></thead>

	<?php

	//$episodes = $this->episodes;
	if (!$this->episodes) { ?>
		<tr>
			<td><?php echo JText::_( 'JBS_PDC_NO_MEDIA_IN_PODCAST' ); ?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<?php
	} else {
		$k = 0;
		for ($i=0, $n=count( $this->episodes ); $i < $n; $i++)
		{
		$episode = $this->episodes[$i];
		//$row = $episodes[$i];
		//foreach ($episodes as $episode) {
		$link2 = JRoute::_( 'index.php?option=com_biblestudy&controller=mediafilesedit&task=edit&cid[]='. $episode->mfid );
		$scripture = JText::sprintf($episode->bookname).' '.$episode->chapter_begin;  // santon 2010-12-05 No book->no phrase; no chapter->no number
		$study = JRoute::_('index.php?option=com_biblestudy&controller=studiesedit&task=edit&cid[]='. $episode->study_id);?>
		<tr class="<?php echo "row$k"; ?>">
			<td><a href="<?php echo $link2; ?>"><?php echo $episode->filename;?></a></td>
			<td><?php echo $episode->createdate;?></td>
			<td><?php echo $scripture;?></td>
			<td><a href="<?php echo $study;?>"><?php echo $episode->studytitle;?></a></td>
			<td><?php echo $episode->teachername;?></td>
		</tr>
		<?php
			$k = 1 - $k;
		}
	}
	?>
 </table>
	<?php } ?>
 </fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_biblestudy" />
<input type="hidden" name="id" value="<?php echo $this->podcastedit->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="podcastedit" />
</form>


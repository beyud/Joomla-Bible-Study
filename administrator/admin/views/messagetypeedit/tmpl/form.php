<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="messagetype">
					<?php echo JText::_( 'Message Type' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="message_type" id="message_type" size="32" maxlength="250" value="<?php echo $this->messagetypeedit->message_type;?>" />
			</td>
		</tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_biblestudy" />
<input type="hidden" name="id" value="<?php echo $this->messagetypeedit->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="messagetypeedit" />
</form>

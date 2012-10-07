<?php defined('_JEXEC') or die('Restricted access');
$mainframe =& JFactory::getApplication();
?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
        <tr>
        <td width="100" class="key"><label for="published"><?php echo JText::_( 'Published' ); ?></label></td>
        <td > <?php echo $this->lists['published'];
		?>
          </td>
      </tr>

		<tr>
			<td width="100" align="right" class="key">
				<label for="name">
                                        <?php echo JText::_( 'Name' ); ?>
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="name" id="name" size="32" maxlength="250" value="<?php echo $this->shareedit->name;?>" />
			</td>
        </tr>
<?php if ($this->shareedit->id > 0) { ?>

        <tr><td class="key">
        <label for="image">
        <?php echo JText::_('Image');?>
        </td><td>

        <?php
		$isweb = stristr($this->params->get('shareimage'), 'http');
		if ($isweb) { echo '<img src="'.$this->params->get('shareimage').'">';}
		else {echo '<img src="'.$mainframe->getCfg('live_site').DS.$this->params->get('shareimage').'">';}
		?>
        </td></tr>
<?php } ?>

    <tr><td class="key">
		<label for="parameters">
		<?php echo JText::_('Parameters');?>
		</label>
		</td>

		<td>
		<?php
		jimport('joomla.html.pane');
	$pane =& JPane::getInstance( 'sliders' );

echo $pane->startPane( 'content-pane' );

echo $pane->startPanel( JText::_( 'General' ), 'GENERAL' );
echo $this->params->render( 'params' );
echo $pane->endPanel();
echo $pane->endPane();
?>
</td></tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_biblestudy" />
<input type="hidden" name="id" value="<?php echo $this->shareedit->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="shareedit" />
<input type="hidden" name="catid" value="1" />
</form>
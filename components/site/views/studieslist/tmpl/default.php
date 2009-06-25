<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die(); ?>

<?php 
global $mainframe, $option;
JHTML::_('behavior.tooltip');
$message = JRequest::getVar('msg');
$database = & JFactory::getDBO();
$teacher_menu = $this->params->get('teacher_id', 1);
$topic_menu = $this->params->get('topic_id', 1);
$book_menu = $this->params->get('booknumber', 101);
$location_menu = $this->params->get('locations', 1);
$series_menu = $this->params->get('series_id', 1);
$messagetype_menu = $this->params->get('messagetype', 1);
//$params = $mainframe->getPageParameters();
$document =& JFactory::getDocument();
$document->addScript(JURI::base().'components'.DS.'com_biblestudy'.DS.'tooltip.js');
$document->addStyleSheet(JURI::base().'components'.DS.'com_biblestudy'.DS.'tooltip.css');
$document->addStyleSheet(JURI::base().'components'.DS.'com_biblestudy'.DS.'assets'.DS.'css'.DS.'biblestudy.css');
$params = $this->params;
	$user =& JFactory::getUser();
	$entry_user = $user->get('gid');
	if (!$entry_user) { $entry_user = 0;}
	$entry_access = $this->params->get('entry_access');
	if (!$entry_access) {$entry_access = 23;}
	$allow_entry = $this->params->get('allow_entry_study');
	//dump ($entry_access, 'entry_access: ');
	if (($allow_entry > 0) && ($entry_access <= $entry_user)) 
			{?>
			<table><tr><td align="center"><?php echo '<h2>'.$message.'</h2>';?></td></tr></table>
			<?php 
			$studiesedit_call = JView::loadHelper('studiesedit');
			$studiesedit = getStudiesedit($row, $params);
			echo $studiesedit;
			}

$listingcall = JView::loadHelper('listing');

?>
<form action="<?php echo str_replace("&","&amp;",$this->request_url); ?>" method="post" name="adminForm">

<!--<tbody><tr>-->
  <div id="biblestudy" class="noRefTagger"> <!-- This div is the container for the whole page -->
  
    <div id="header">
      <h1 class="componentheading">
<?php
     if ($this->params->get( 'show_page_image' ) >0) {
     $pimagew = $this->params->get('pimagew');
     $pimageh = $this->params->get('pimageh');
     if ($pimagew) {$width = $pimagew;} else {$width = 24;}
     if ($pimageh) {$height = $pimageh;} else {$height= 24;}
     ?>
      <img src="<?php echo JURI::base().$this->params->get('page_image');?>" alt="<?php echo $this->params->get('page_title'); ?>" width="<?php echo $width;?>" height="<?php echo $height;?>" />
    <?php //End of column for logo
    }
    ?>
    <?php
if ( $this->params->get( 'show_page_title' ) >0 ) {
    echo $this->params->get('page_title');
    }
	?>
      </h1>
<?php if ($params->get('show_teacher_list') > 0)
	{	
	$teacher_call = JView::loadHelper('teacher');
	$teacher = getTeacher($params, $row->teacher_id);
	if ($teacher) {echo $teacher;}
	}?>    
    </div><!--header-->
    <div id="bsdropdownmenu">

<?php 

if ($this->params->get('show_locations_search') > 0 && !($location_menu)) { echo $this->lists['locations'];}

if ($this->params->get('show_book_search') >0 && !($book_menu) ){ echo $this->lists['books'];  }
 
if ($this->params->get('show_teacher_search') > 0 && !($teacher_menu)) { echo $this->lists['teacher_id'];  }   
	
if ($this->params->get('show_series_search') > 0 && !($series_menu)){ echo $this->lists['seriesid'];  }   
	
if ($this->params->get('show_type_search') > 0 && !($messagetype_menu)) { echo $this->lists['messagetypeid'];  }   
	
if ($this->params->get('show_year_search') > 0){ echo $this->lists['studyyear'];  }   
	
if ($this->params->get('show_order_search') > 0) { echo $this->lists['orders'];}
  
if ($this->params->get('show_topic_search') > 0) {  echo $this->lists['topics'];}

?>


    </div><!--dropdownmenu-->
     <table id="bslisttable" cellspacing="0">
     <?php 
	 
     $headerCall = JView::loadHelper('header');
     $header = getHeader($row, $params);
     echo $header;
     ?>
      <tbody>

        <?php 
 //This sets the alternativing colors for the background of the table cells
 $class1 = 'bsodd';
 $class2 = 'bseven';
 $oddeven = $class1;

 foreach ($this->items as $row) { //Run through each row of the data result from the model
	if($oddeven == $class1){ //Alternate the color background
	$oddeven = $class2;
	} else {
	$oddeven = $class1;
	}

	$listing = getListing($row, $params, $oddeven);
 	echo $listing;
 }
 ?>
 </tbody></table>
<div class="listingfooter" >
	<?php 
      
      echo $this->pagination->getPagesLinks();
      echo $this->pagination->getPagesCounter();
      //echo $this->pagination->getListFooter(); ?>
</div> <!--end of bsfooter div-->
  </div><!--end of bspagecontainer div-->
  <input name="option" value="com_biblestudy" type="hidden">

  <input name="task" value="" type="hidden">
  <input name="boxchecked" value="0" type="hidden">
  <input name="controller" value="studieslist" type="hidden">
</form>


<?php
// predefine some vars

$msg = '';
$showFields = array();

//$tz_list=array('Select Continent');
//foreach($tz as $k=>$v){ $tz_list[(string)$v->offset]=floor((string)$v->offset/3600); }

if(isset($this->edit_id) && $this->edit_id){
	echo form_open_multipart('event/edit/'.$this->edit_id);
	$sub	='Save Edits';
	$title	='Edit Event: <a style="text-decoration:none" href="/event/view/'.$detail[0]->ID.'">'.$detail[0]->event_name.'</a>';
	$curr_img = $detail[0]->event_icon;
	menu_pagetitle('Edit Event: '.$detail[0]->event_name);
}else{ 
	echo form_open_multipart('event/add'); 
	$sub	= 'Add Event';
	$title	= 'Add Event';
	$curr_img='none.gif';
	menu_pagetitle('Add an Event');
}

echo '<h2>'.$title.'</h2>';
?>
<script type="text/javascript" src="/inc/js/event.js"></script>

<?php if (!empty($msg) || !empty($this->form_validation->error_string)): ?>
<?php 
	if(!empty($this->form_validation->error_string)){ $msg.=$this->form_validation->error_string; }
	$this->load->view('msg_info', array('msg' => $msg)); 
?>
<?php endif; ?>

<div class="box">
    <div class="row">
    	<label for="event_name">Event Name:</label>
	<?php echo form_input('event_name',$this->input->post('event_name')); ?>
    </div>
    <div class="clear"></div>
	<div class="row">
    	<label for="event_icon">Event Icon:</label>
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td style="padding-right:10px">
				<img src="/inc/img/event_icons/<?php echo $curr_img; ?>"/>
			</td>
			<td style="vertical-align:top">
				<input type="file" name="event_icon" size="20" /><br/><br/>
				<span style="color:#3567AC;font-size:11px">
			<b>Please Note:</b> Only icons that are 90 pixels by 90 pixels will be accepted!<br/>
				Allowed types: gif, jpg, png
			</td>
		</tr>
		</table>
	</span>
    </div>
    <div class="clear"></div>
    <div class="row">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr><td>
    	<label for="event_start">Event Start:</label>
	<?php
	foreach(range(1,12) as $v){
	    $m=date('M',mktime(0,0,0,$v,1,date('Y')));
	    $start_mo[$v]=$m; }
	foreach(range(1,32) as $v){ $start_day[$v]=$v; }
	foreach(range($min_start_yr,date('Y')+5) as $v){ $start_yr[$v]=$v; }
	echo form_dropdown('start_mo',  $start_mo,  $this->input->post('start_mo'),    'id="start_mo"');
	echo form_dropdown('start_day', $start_day, $this->input->post('start_day'),   'id="start_day"');
	echo form_dropdown('start_yr',  $start_yr,  $this->input->post('start_yr'),    'id="start_yr"');
    echo form_datepicker('start_day', 'start_mo', 'start_yr');
	?>
	&nbsp;&nbsp;
	</td>
	<td>
    	<label for="event_end">Event End:</label>
	<?php
	foreach(range(1,12) as $v){
	    $m=date('M',mktime(0,0,0,$v,1,date('Y')));
	    $end_mo[$v]=$m; }
	foreach(range(1,32) as $v){ $end_day[$v]=$v; }
	foreach(range($min_end_yr,date('Y')+5) as $v){ $end_yr[$v]=$v; }
	echo form_dropdown('end_mo',$end_mo,$this->input->post('end_mo'));
	echo form_dropdown('end_day',$end_day,$this->input->post('end_day'));
	echo form_dropdown('end_yr',$end_yr,$this->input->post('end_yr'));
    echo form_datepicker('end_day', 'end_mo', 'end_yr');
	?>
	</td></tr>
	</table>
    </div>
    <div class="clear"></div>
	<div class="row">
    	<label for="event_description">Event Description:</label>
	<?php
	$arr=array(
		'name'	=> 'event_desc',
		'cols'	=> 45,
		'rows'	=> 12,
		'value'	=> $this->input->post('event_desc')
	);
	echo form_textarea($arr);
	?>
    </div>
    <div class="clear"></div>
	<div class="row">
	<label for="event_icon">Is the event private?</label>
	<?php
		$ev_y=($this->input->post('event_private')=='Y') ? true : false;
		$ev_n=($this->input->post('event_private')=='N') ? true : false;
		//if(empty($this->input->post('event_private'))){ $ev_n=true; }

		echo form_radio('event_private','Y',$ev_y).' Yes'; 
		echo form_radio('event_private','N',$ev_n).' No'; 
	?>
	</div>
    <div class="clear"></div>
    <div class="row">
    	<label for="event_loc">Venue name:</label>
	<?php echo form_input(
        array('name'=>'event_loc',
            'id'=>'event_loc'
            ),$this->input->post('event_loc')); ?>
    </div>
    <div class="clear"></div>

	<div class="row">
		<label for="geo">Event Location</label>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td>
			<?php
			if (is_numeric($this->input->post('event_lat')) && $this->input->post('event_lat') != '') {
				$lat  = $this->input->post('event_lat');
				$long = $this->input->post('event_long');
				$zoom = 13;
			} else {
				$lat  = 0;
				$long = 0;
				$zoom = 0;
			}
			?>
			<input type="hidden" name="map_latitude" id="map_latitude" value="<?php echo $lat; ?>"/>
			<input type="hidden" name="map_longitude" id="map_longitude" value="<?php echo $long; ?>"/>
			<input type="hidden" name="map_zoom" id="map_zoom" value="<?php echo $zoom; ?>"/>
			
			<input type="hidden" name="event_lat" id="event_lat" value="<?php echo $lat; ?>"/>
			<input type="hidden" name="event_long" id="event_long" value="<?php echo $long; ?>"/>
			
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td style="padding-right:5px">
					<div id="map_canvas" style="width: 300px; height: 300px"></div>
				</td>
				<td style="vertical-align:top">
					Address Search:<br/>
					<?php 
						$attr = array(
							'id' 	=> 'addr',
							'name' 	=> 'addr',
							'size'	=> 10,
							'value'	=> $this->input->post('addr'),
							'style'	=> 'width: 250px'
						);
						echo form_input($attr); 
					?>
					<button type="button" onclick="addr_search();">Search</button>
					<br/><br/><br/>
					<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td style="padding-right:8px"><b>Latitude</b></td>
						<td id="output_latitude"></td>
					</tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr>
						<td style="padding-right:8px"><b>Longitude</b></td>
						<td id="output_longitude"></td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
			
			<script type="text/javascript" src="/inc/js/event_google_map.js"></script>
			</td>
		</tr>
		</table>
	</div>

    <div class="row">
    	<label for="event_tz_cont">Event Timezone:</label>
		<?php echo custom_timezone_menu('event_tz', $this->input->post('event_tz_cont'), $this->input->post('event_tz_place') ); ?>
	<span style="color:#3567AC;font-size:11px">For more information on locations and 
	their time zone, see <a href="http://en.wikipedia.org/wiki/List_of_time_zones">this
	page on Wikipedia</a></span>
    </div>
    <div class="clear"></div>
	<div class="row">
		<table cellpadding="5" cellspacing="5" border="0">
    	<tr>
			<td style="padding-right:10px">
			<label for="event_stub">Event Stub</label>
    		<?php echo form_input(array('name' => 'event_stub', 'id' => 'event_stub','maxlength' => 30	), $this->input->post('event_stub')); ?>
			<span style="color:#3567AC;font-size:11px">Max length 30 characters</span>
			</td>
    		<td style="vertical-align:middle">
				<span style="color:#3567AC;font-size:11px" id="stub_display">
				<?php if(!empty($this->input->post('event_stub'))){ 
					echo '<a href="http://joind.in/event/'.$this->input->post('event_stub').'">http://joind.in/event/'.$this->input->post('event_stub').'</a>'; } ?>
				</span><br/>
		</tr></table>
        <div class="clear"></div>
    </div>
	<div class="clear"></div>
    <div class="row">
    	<label for="event_link">Event Link(s):</label>
	<?php echo form_input('event_href',$this->input->post('event_href')); ?><br/>
    </div>
    <div class="clear"></div>
    <div class="row">
    	<label for="event_hashtag">Event Hashtag(s):</label>
	<?php echo form_input('event_hashtag',$this->input->post('event_hashtag')); ?>
	<span style="color:#3567AC;font-size:11px">Seperate tags with commas</span>
    </div>
    <div class="clear"></div>
    
    <?php
    	if($this->input->post('cfp_checked'))
    		$showFields[] = 'cfp-fields-toggle-link';
    ?>
    
	<h4>Call for Papers <a id="cfp-fields-toggle-link" class="fieldset-toggle" href="#">show</a></h4>
	<fieldset id="cfp-fields">
	<div class="row">
		<?php 
			$js='onClick="toggleCfpDates()"';
			echo form_checkbox('is_cfp','1',$this->input->post('cfp_checked'),$js); 
		?> Yes, we're going to have a Call for Papers
		<br/><br/>
        <label for="start">Call for Papers Start Date</label>
	<?php
		/*foreach(range(1,12) as $v){ $end_mo[$v]=$v; }
		foreach(range(1,32) as $v){ $end_day[$v]=$v; }
		foreach(range(date('Y'),date('Y')+5) as $v){ $end_yr[$v]=$v; }*/

	    foreach(range(1,12) as $v){ $cfp_start_mo[$v]=strftime('%B', strtotime('2000-' . $v . '-01')); }
    	foreach(range(1,31) as $v){ $cfp_start_day[$v]=sprintf('%02d', $v); }
    	foreach(range(date('Y'),date('Y')+5) as $v){ $cfp_start_yr[$v]=$v; }

		$js=($this->input->post('cfp_checked')==1) ? '' : 'disabled';
		
		echo form_dropdown('cfp_start_mo',$cfp_start_mo,date('m',$this->input->post('event_cfp_start')),'id="cfp_start_mo" '.$js);
		echo form_dropdown('cfp_start_day',$cfp_start_day,date('d',$this->input->post('event_cfp_start')),'id="cfp_start_day" '.$js);
		echo form_dropdown('cfp_start_yr',$cfp_start_yr,date('Y',$this->input->post('event_cfp_start')),'id="cfp_start_yr" '.$js);
        echo form_datepicker('cfp_start_day', 'cfp_start_mo', 'cfp_start_yr');
		?>
	 <div class="clear"></div>
    </div>
 	<div class="row">
        <label for="start">Call for Papers End Date</label>
	<?php
		/*foreach(range(1,12) as $v){ $end_mo[$v]=$v; }
		foreach(range(1,32) as $v){ $end_day[$v]=$v; }
		foreach(range(date('Y'),date('Y')+5) as $v){ $end_yr[$v]=$v; }*/

	    foreach(range(1,12) as $v){ $cfp_end_mo[$v]=strftime('%B', strtotime('2000-' . $v . '-01')); }
    	foreach(range(1,31) as $v){ $cfp_end_day[$v]=sprintf('%02d', $v); }
    	foreach(range(date('Y'),date('Y')+5) as $v){ $cfp_end_yr[$v]=$v; }

		echo form_dropdown('cfp_end_mo',$cfp_end_mo,date('m',$this->input->post('event_cfp_end')),'id="cfp_end_mo" '.$js);
		echo form_dropdown('cfp_end_day',$cfp_end_day,date('d',$this->input->post('event_cfp_end')),'id="cfp_end_day" '.$js);
		echo form_dropdown('cfp_end_yr',$cfp_end_yr,date('Y',$this->input->post('event_cfp_end')),'id="cfp_end_yr" '.$js);
        echo form_datepicker('cfp_end_day', 'cfp_end_mo', 'cfp_end_yr');
		?>
	 <div class="clear"></div>
    </div>

	<div class="row">
		<label for="cfp-url-location">Call for Papers URL Location</label>
		<?php echo form_input('cfp_url',$this->input->post('event_cfp_url'),'id="cfp_url"'); ?>
		<div class="clear"></div>
	</div>
	</fieldset>

    <div class="row">
    	<?php echo form_submit('sub',$sub); ?>
    </div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
$(document).ready(function(){ 
	JI_event.init(); 
	var fields = null;
	JI_event.hideFieldsets(fields); 
	
	var showFields = <?php echo json_encode($showFields); ?>;
	
	for(var x = 0; x < showFields.length; x++)
		$('#' + showFields[x]).click();
})
</script>
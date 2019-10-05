<?php
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
	global $wpdb;

	$table_name4  = $wpdb->prefix . "totalsoft_cal_types";
	$TotalSoftCalCount = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE id>%d", 0));
?>
<script type="text/javascript">
	jQuery(document).ready(function () {
		jQuery('#TS_Calendar_Media_Insert').on('click', function () {
			var id = jQuery('#TS_Calendar_Media_Select option:selected').val();
			window.send_to_editor('[Total_Soft_Cal id="' + id + '"]');
			tb_remove();
			return false;
		});
	});
</script>
<form method="POST">
	<div id="TSCalendar" style="display: none;">
		<?php
			$new_calendar_link = admin_url('admin.php?page=Total_Soft_Cal');
			$new_calendar_link_n = wp_nonce_url( '', 'edit-menu_', 'TS_CalEv_Nonce' );

			if ($TotalSoftCalCount && !empty($TotalSoftCalCount)) { ?>
				<h3>Select The Calendar</h3>
				<select id="TS_Calendar_Media_Select">
					<?php
						foreach ($TotalSoftCalCount as $TotalSoftCalCount1)
						{
							?> <option value="<?php echo $TotalSoftCalCount1->id; ?>"> <?php echo $TotalSoftCalCount1->TotalSoftCal_Name; ?> </option> <?php
						}
					?>
				</select>
				<button class='button primary' id='TS_Calendar_Media_Insert'>Insert Calendar</button>
			<?php } else {
				printf('<p>%s<a class="button" href="%s">%s</a></p>', 'You have not created any calendars yet' . '<br>', $new_calendar_link . $new_calendar_link_n, 'Create New Calendar');
			}
		?>
	</div>
</form>
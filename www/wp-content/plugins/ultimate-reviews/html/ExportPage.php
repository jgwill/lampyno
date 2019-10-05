<div class="wrap">

	<div class="ewd-urp-admin-styling-section ewd-urp-admin-import-export <?php echo $URP_Full_Version; ?>">
		<div class="ewd-urp-admin-styling-subsection">
			<div class="ewd-urp-admin-styling-subsection-label"><?php _e('To CSV', 'ultimate-reviews'); ?></div>
			<div class="ewd-urp-admin-styling-subsection-content">
				<div class="ewd-urp-admin-styling-subsection-content-each">
					<p style="margin-top: 0;">Export reviews to CSV using the button below.</p>
					<form method="post" action="admin.php?page=EWD-URP-Options&DisplayPage=Export&Action=EWD_URP_Export_To_Excel">
						<input type='hidden' name='Format_Type' value='CSV' />
						<table class="form-table"></table>
						<p class="submit"><input type="submit" name="Export_Submit" id="submit" class="button button-primary" value="Export to CSV" <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /></p>
					</form>
				</div>
			</div>
		</div>
		<div class="ewd-urp-admin-styling-subsection">
			<div class="ewd-urp-admin-styling-subsection-label"><?php _e('To Spreadsheet', 'ultimate-reviews'); ?></div>
			<div class="ewd-urp-admin-styling-subsection-content">
				<div class="ewd-urp-admin-styling-subsection-content-each">
					<p style="margin-top: 0;">Export reviews to Spreadsheet using the button below.</p>
					<form method="post" action="admin.php?page=EWD-URP-Options&DisplayPage=Export&Action=EWD_URP_Export_To_Excel">
						<input type='hidden' name='Format_Type' value='XLS' />
						<table class="form-table"></table>
						<p class="submit"><input type="submit" name="Export_Submit" id="submit" class="button button-primary" value="Export to Spreadsheet" <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /></p>
					</form>
				</div>
			</div>
		</div>
		<?php if ($URP_Full_Version != "Yes") { ?>
			<div class="ewd-urp-premium-options-table-overlay">
				<div class="ewd-urp-unlock-premium">
					<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Reviews Premium">
					<p>Access this section by by upgrading to premium</p>
					<a href="https://www.etoilewebdesign.com/plugins/ultimate-reviews/#buy" class="ewd-urp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
				</div>
			</div>
		<?php } ?>
	</div>

</div>
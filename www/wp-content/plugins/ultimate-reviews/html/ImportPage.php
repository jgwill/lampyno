<div class="wrap">

	<div class="ewd-urp-admin-styling-section ewd-urp-admin-import-export <?php echo $URP_Full_Version; ?>">
		<div class="ewd-urp-admin-styling-subsection">
			<?php if ($URP_Full_Version != "Yes") { ?>
				<p>Upgrade to the premium version to use some of these features</p>
			<?php } ?>
		</div>
		<div class="ewd-urp-admin-styling-subsection">
			<div class="ewd-urp-admin-styling-subsection-label"><?php _e('From WooCommerce', 'ultimate-reviews'); ?></div>
			<div class="ewd-urp-admin-styling-subsection-content">
				<div class="ewd-urp-admin-styling-subsection-content-each">
					<p style="margin-top: 0;">Import reviews from WooCommerce using the button below.</p>
					<a href='admin.php?page=EWD-URP-Options&DisplayPage=WooCommerceImport&Action=EWD_URP_WooCommerceImport'>
					<button class="button button-primary">Import</button>
					</a>
				</div>
			</div>
		</div>
		<div class="ewd-urp-admin-styling-subsection">
			<div class="ewd-urp-admin-styling-subsection-label"><?php _e('From Spreadsheet', 'ultimate-reviews'); ?></div>
			<div class="ewd-urp-admin-styling-subsection-content">
				<div class="ewd-urp-admin-styling-subsection-content-each">
					<form method="post" action="admin.php?page=EWD-URP-Options&DisplayPage=WooCommerceImport&Action=EWD_URP_ImportReviewsFromSpreadsheet" enctype="multipart/form-data">
						<?php wp_nonce_field('URP_Admin_Action', 'URP_Admin_Action'); ?>
						<div class="form-field form-required">
							<label for="Reviews_Spreadsheet"><?php _e("Spreadsheet Containing Reviews", 'ultimate-reviews') ?></label><br />
							<input name="Reviews_Spreadsheet" id="Reviews_Spreadsheet" type="file" value=""/>
						</div>
						<p class="submit"><input type="submit" name="Import_Submit" id="submit" class="button button-primary" value="Import Spreadsheet Reviews"  <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/></p>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
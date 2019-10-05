<div class="wrap">
<div class="Header"><h2><?php _e("Ultimate Reviews", 'ultimate-reviews') ?></h2></div>		

<?php if ($URP_Full_Version != "Yes" or get_option("EWD_URP_Trial_Happening") == "Yes") { ?>
	<div class="ewd-urp-dashboard-new-upgrade-banner">
		<div class="ewd-urp-dashboard-banner-icon"></div>
		<div class="ewd-urp-dashboard-banner-buttons">
			<a class="ewd-urp-dashboard-new-upgrade-button" href="http://www.etoilewebdesign.com/plugins/ultimate-reviews/#buy" target="_blank">UPGRADE NOW</a>
		</div>
		<div class="ewd-urp-dashboard-banner-text">
			<div class="ewd-urp-dashboard-banner-title">
				GET FULL ACCESS WITH OUR PREMIUM VERSION
			</div>
			<div class="ewd-urp-dashboard-banner-brief">
				Let visitors submit reviews of your products services or events
			</div>
		</div>
	</div>
<?php } ?>

<?php EWD_URP_Add_Header_Bar("Yes"); ?>

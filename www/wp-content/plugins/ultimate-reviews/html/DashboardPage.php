<!-- Upgrade to pro link box -->
<!-- TOP BOX-->

<?php global $wpdb;

if (isset($_POST['hide_urp_review_box_hidden'])) {update_option('EWD_URP_Hide_Dash_Review_Ask', sanitize_text_field($_POST['hide_urp_review_box_hidden']));}
$hideReview = get_option('EWD_URP_Hide_Dash_Review_Ask');
$Ask_Review_Date = get_option('EWD_URP_Ask_Review_Date');
if ($Ask_Review_Date == "") {$Ask_Review_Date = get_option("EWD_URP_Install_Time") + 3600*24*4;}

$args = array(
	'post_type' => 'urp_review',
	'orderby' => 'meta_value_num',
	'meta_key' => 'urp_view_count'
);

$Dashboard_Reviews_Query = new WP_Query($args);
$Dashboard_Reviews = $Dashboard_Reviews_Query->get_posts();
?>

<!-- START NEW DASHBOARD -->

<div id="ewd-urp-dashboard-content-area">

	<div id="ewd-urp-dashboard-content-left">

		<?php if ($URP_Full_Version != "Yes" or get_option("EWD_URP_Trial_Happening") == "Yes") { ?>
			<div class="ewd-urp-dashboard-new-widget-box ewd-widget-box-full">
				<div class="ewd-urp-dashboard-new-widget-box-top">
					<form method="post" action="admin.php?page=EWD-URP-Options" class="ewd-urp-dashboard-key-widget">
						<input class="ewd-urp-dashboard-key-widget-input" name="Key" type="text" placeholder="<?php _e('Enter Product Key Here', 'ultimate-reviews'); ?>">
						<input class="ewd-urp-dashboard-key-widget-submit" name="EWD_URP_Upgrade_To_Full" type="submit" value="<?php _e('UNLOCK PREMIUM', 'ultimate-reviews'); ?>">
						<div class="ewd-urp-dashboard-key-widget-text">Don't have a key? Use the <a href="http://www.etoilewebdesign.com/plugins/ultimate-reviews/#buy" target="_blank">Upgrade Now</a> button above to purchase and unlock all premium features.</div>
					</form>
				</div>
			</div>
		<?php } ?>

		<div class="ewd-urp-dashboard-new-widget-box ewd-widget-box-full" id="ewd-urp-dashboard-support-widget-box">
			<div class="ewd-urp-dashboard-new-widget-box-top">Get Support<span id="ewd-urp-dash-mobile-support-down-caret">&nbsp;&nbsp;&#9660;</span><span id="ewd-urp-dash-mobile-support-up-caret">&nbsp;&nbsp;&#9650;</span></div>
			<div class="ewd-urp-dashboard-new-widget-box-bottom">
				<ul class="ewd-urp-dashboard-support-widgets">
					<li>
						<a href="https://www.youtube.com/watch?v=IxM1mizhzek&list=PLEndQUuhlvSpw3HQakJHj4G0F0Gyc-CtU" target="_blank">
							<img src="<?php echo plugins_url( '../images/ewd-support-icon-youtube.png', __FILE__ ); ?>">
							<div class="ewd-urp-dashboard-support-widgets-text">YouTube Tutorials</div>
						</a>
					</li>
					<li>
						<a href="https://wordpress.org/plugins/ultimate-reviews/#faq" target="_blank">
							<img src="<?php echo plugins_url( '../images/ewd-support-icon-faqs.png', __FILE__ ); ?>">
							<div class="ewd-urp-dashboard-support-widgets-text">Plugin FAQs</div>
						</a>
					</li>
					<li>
						<a href="https://wordpress.org/support/plugin/ultimate-reviews" target="_blank">
							<img src="<?php echo plugins_url( '../images/ewd-support-icon-forum.png', __FILE__ ); ?>">
							<div class="ewd-urp-dashboard-support-widgets-text">Support Forum</div>
						</a>
					</li>
					<li>
						<a href="https://www.etoilewebdesign.com/plugins/ultimate-reviews/documentation-ultimate-reviews/" target="_blank">
							<img src="<?php echo plugins_url( '../images/ewd-support-icon-documentation.png', __FILE__ ); ?>">
							<div class="ewd-urp-dashboard-support-widgets-text">Documentation</div>
						</a>
					</li>
				</ul>
			</div>
		</div>

		<div class="ewd-urp-dashboard-new-widget-box ewd-widget-box-full" id="ewd-urp-dashboard-optional-table">
			<div class="ewd-urp-dashboard-new-widget-box-top">Reviews Summary<span id="ewd-urp-dash-optional-table-down-caret">&nbsp;&nbsp;&#9660;</span><span id="ewd-urp-dash-optional-table-up-caret">&nbsp;&nbsp;&#9650;</span></div>
			<div class="ewd-urp-dashboard-new-widget-box-bottom">
				<table class='ewd-urp-overview-table wp-list-table widefat fixed striped posts'>
					<thead>
						<tr>
							<th><?php _e("Title", 'EWD_ABCO'); ?></th>
							<th><?php _e("Views", 'EWD_ABCO'); ?></th>
							<th><?php _e("Review Rating", 'EWD_ABCO'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
							if (sizeOf($Dashboard_Reviews) == 0) {echo "<tr><td colspan='3'>" . __("No reviews to display yet. Create a review and then view it for it to be displayed here.", 'ultimate-reviews') . "</td></tr>";}
							else {
								foreach ($Dashboard_Reviews as $Dashboard_Review) { ?>
									<tr>
										<td><a href='post.php?post=<?php echo $Dashboard_Review->ID;?>&action=edit'><?php echo $Dashboard_Review->post_title; ?></a></td>
										<td><?php echo get_post_meta($Dashboard_Review->ID, 'urp_view_count', true); ?></td>
										<td><?php echo get_post_meta($Dashboard_Review->ID, 'EWD_URP_Overall_Score', true); ?></td>
									</tr>
								<?php }
							}
						?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="ewd-urp-dashboard-new-widget-box <?php echo ( ($hideReview != 'Yes' and $Ask_Review_Date < time()) ? 'ewd-widget-box-two-thirds' : 'ewd-widget-box-full' ); ?>">
			<div class="ewd-urp-dashboard-new-widget-box-top">What People Are Saying</div>
			<div class="ewd-urp-dashboard-new-widget-box-bottom">
				<ul class="ewd-urp-dashboard-testimonials">
					<?php $randomTestimonial = rand(0,2);
					if($randomTestimonial == 0){ ?>
						<li id="ewd-urp-dashboard-testimonial-one">
							<img src="<?php echo plugins_url( '../images/dash-asset-stars.png', __FILE__ ); ?>">
							<div class="ewd-urp-dashboard-testimonial-title">"Wonderful Solution. 1st-rate Support"</div>
							<div class="ewd-urp-dashboard-testimonial-author">- @lbdee</div>
							<div class="ewd-urp-dashboard-testimonial-text">This plugin adds serious value to WordPress/WooCommerce. Just as impressive is the support which is as responsive as the plugin... <a href="https://wordpress.org/support/topic/wonderful-solution-1st-rate-support/" target="_blank">read more</a></div>
						</li>
					<?php }
					if($randomTestimonial == 1){ ?>
						<li id="ewd-urp-dashboard-testimonial-two">
							<img src="<?php echo plugins_url( '../images/dash-asset-stars.png', __FILE__ ); ?>">
							<div class="ewd-urp-dashboard-testimonial-title">"Great support"</div>
							<div class="ewd-urp-dashboard-testimonial-author">- @aniadealemania</div>
							<div class="ewd-urp-dashboard-testimonial-text">Very nice and helpful support. Thanks guys! <a href="https://wordpress.org/support/topic/great-support-1286/" target="_blank">read more</a></div>
						</li>
					<?php }
					if($randomTestimonial == 2){ ?>
						<li id="ewd-urp-dashboard-testimonial-three">
							<img src="<?php echo plugins_url( '../images/dash-asset-stars.png', __FILE__ ); ?>">
							<div class="ewd-urp-dashboard-testimonial-title">"Great Plugin, greater support"</div>
							<div class="ewd-urp-dashboard-testimonial-author">- @jstjames</div>
							<div class="ewd-urp-dashboard-testimonial-text">The plugin worked exactly as described and when my team needed help installing/figuring something out, they were quick to respond... <a href="https://wordpress.org/support/topic/great-plugin-greater-support-4/" target="_blank">read more</a></div>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>

		<?php if($hideReview != 'Yes' and $Ask_Review_Date < time()){ ?>
			<div class="ewd-urp-dashboard-new-widget-box ewd-widget-box-one-third">
				<div class="ewd-urp-dashboard-new-widget-box-top">Leave a review</div>
				<div class="ewd-urp-dashboard-new-widget-box-bottom">
					<div class="ewd-urp-dashboard-review-ask">
						<img src="<?php echo plugins_url( '../images/dash-asset-stars.png', __FILE__ ); ?>">
						<div class="ewd-urp-dashboard-review-ask-text">If you enjoy this plugin and have a minute, please consider leaving a 5-star review. Thank you!</div>
						<a href="https://wordpress.org/plugins/ultimate-reviews/#reviews" class="ewd-urp-dashboard-review-ask-button" target="_blank">LEAVE A REVIEW</a>
						<form action="admin.php?page=EWD-URP-Options" method="post">
							<input type="hidden" name="hide_urp_review_box_hidden" value="Yes">
							<input type="submit" name="hide_urp_review_box_submit" class="ewd-urp-dashboard-review-ask-dismiss" value="I've already left a review">
						</form>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if ($URP_Full_Version != "Yes" or get_option("EWD_URP_Trial_Happening") == "Yes") { ?>
			<div class="ewd-urp-dashboard-new-widget-box ewd-widget-box-full" id="ewd-urp-dashboard-guarantee-widget-box">
				<div class="ewd-urp-dashboard-new-widget-box-top">
					<div class="ewd-urp-dashboard-guarantee">
						<div class="ewd-urp-dashboard-guarantee-title">14-Day 100% Money-Back Guarantee</div>
						<div class="ewd-urp-dashboard-guarantee-text">If you're not 100% satisfied with the premium version of our plugin - no problem. You have 14 days to receive a FULL REFUND. We're certain you won't need it, though. Lorem ipsum dolor sitamet, consectetuer adipiscing elit.</div>
					</div>
				</div>
			</div>
		<?php } ?>

	</div> <!-- left -->

	<div id="ewd-urp-dashboard-content-right">

		<?php if ($URP_Full_Version != "Yes" or get_option("EWD_URP_Trial_Happening") == "Yes") { ?>
			<div class="ewd-urp-dashboard-new-widget-box ewd-widget-box-full" id="ewd-urp-dashboard-get-premium-widget-box">
				<div class="ewd-urp-dashboard-new-widget-box-top">Get Premium</div>
				<?php if(get_option("EWD_URP_Trial_Happening") == "Yes"){ 
					$trialExpireTime = get_option("EWD_URP_Trial_Expiry_Time");
					$currentTime = time();
					$trialTimeLeft = $trialExpireTime - $currentTime;
					$trialTimeLeftDays = ( date("d", $trialTimeLeft) ) - 1;
					$trialTimeLeftHours = date("H", $trialTimeLeft);
					?>
					<div class="ewd-urp-dashboard-new-widget-box-bottom">
						<div class="ewd-urp-dashboard-get-premium-widget-trial-time">
							<div class="ewd-urp-dashboard-get-premium-widget-trial-days"><?php echo $trialTimeLeftDays; ?><span>days</span></div>
							<div class="ewd-urp-dashboard-get-premium-widget-trial-hours"><?php echo $trialTimeLeftHours; ?><span>hours</span></div>
						</div>
						<div class="ewd-urp-dashboard-get-premium-widget-trial-time-left">LEFT IN TRIAL</div>
					</div>
				<?php } ?>
				<div class="ewd-urp-dashboard-new-widget-box-bottom">
					<div class="ewd-urp-dashboard-get-premium-widget-features-title"<?php echo ( get_option("EWD_URP_Trial_Happening") == "Yes" ? "style='padding-top: 20px;'" : ""); ?>>GET FULL ACCESS WITH OUR PREMIUM VERSION AND GET:</div>
					<ul class="ewd-urp-dashboard-get-premium-widget-features">
						<li>Search &amp; Review Summary Shortcodes</li>
						<li>WooCommerce Integration</li>
						<li>Admin &amp; Review Reminder Emails</li>
						<li>Advanced Display Options</li>
						<li>+ More</li>
					</ul>
					<a href="http://www.etoilewebdesign.com/plugins/ultimate-reviews/#buy" class="ewd-urp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					<?php if (!get_option("EWD_URP_Trial_Happening")) { ?>
						<form method="post" action="admin.php?page=EWD-URP-Options">
							<input name="Key" type="hidden" value='EWD Trial'>
							<input name="EWD_URP_Upgrade_To_Full" type="hidden" value='EWD_URP_Upgrade_To_Full'>
							<button class="ewd-urp-dashboard-get-premium-widget-button ewd-urp-dashboard-new-trial-button">GET FREE 7-DAY TRIAL</button>
						</form>
					<?php } ?>
				</div>
			</div>
		<?php } ?>

		<div class="ewd-urp-dashboard-new-widget-box ewd-widget-box-full">
			<div class="ewd-urp-dashboard-new-widget-box-top">Goes Great With</div>
			<div class="ewd-urp-dashboard-new-widget-box-bottom">
				<ul class="ewd-urp-dashboard-other-plugins">
					<li>
						<a href="https://wordpress.org/plugins/ultimate-product-catalogue/" target="_blank"><img src="<?php echo plugins_url( '../images/ewd-upcp-icon.png', __FILE__ ); ?>"></a>
						<div class="ewd-urp-dashboard-other-plugins-text">
							<div class="ewd-urp-dashboard-other-plugins-title">Product Catalog</div>
							<div class="ewd-urp-dashboard-other-plugins-blurb">Enables you to display your business's products in a clean and efficient manner.</div>
						</div>
					</li>
					<li>
						<a href="https://wordpress.org/plugins/ultimate-faqs/" target="_blank"><img src="<?php echo plugins_url( '../images/ewd-ufaq-icon.png', __FILE__ ); ?>"></a>
						<div class="ewd-urp-dashboard-other-plugins-text">
							<div class="ewd-urp-dashboard-other-plugins-title">Ultimate FAQs</div>
							<div class="ewd-urp-dashboard-other-plugins-blurb">An easy-to-use FAQ plugin that lets you create, order and publicize FAQs, with many styles and options!</div>
						</div>
					</li>
				</ul>
			</div>
		</div>

	</div> <!-- right -->	

</div> <!-- ewd-urp-dashboard-content-area -->

<?php if ($URP_Full_Version != "Yes" or get_option("EWD_URP_Trial_Happening") == "Yes") { ?>
	<div id="ewd-urp-dashboard-new-footer-one">
		<div class="ewd-urp-dashboard-new-footer-one-inside">
			<div class="ewd-urp-dashboard-new-footer-one-left">
				<div class="ewd-urp-dashboard-new-footer-one-title">What's Included in Our Premium Version?</div>
				<ul class="ewd-urp-dashboard-new-footer-one-benefits">
					<li>Review Search Shortcode</li>
					<li>Review Summary Shortcode</li>
					<li>Replace WooCommerce Reviews Tab</li>
					<li>Replace WooCommerce Ratings Stars</li>
					<li>Admin Notifications</li>
					<li>Review Reminder Emails</li>
					<li>Admin Approval of Reviews</li>
					<li>Require Login</li>
					<li>Schema Microdata</li>
					<li>Multiple Review Layouts</li>
					<li>Advanced Display Options</li>
				</ul>
			</div>
			<div class="ewd-urp-dashboard-new-footer-one-buttons">
				<a class="ewd-urp-dashboard-new-upgrade-button" href="http://www.etoilewebdesign.com/plugins/ultimate-reviews/#buy" target="_blank">UPGRADE NOW</a>
			</div>
		</div>
	</div> <!-- ewd-urp-dashboard-new-footer-one -->
<?php } ?>	
<div id="ewd-urp-dashboard-new-footer-two">
	<div class="ewd-urp-dashboard-new-footer-two-inside">
		<img src="<?php echo plugins_url( '../images/ewd-logo-white.png', __FILE__ ); ?>" class="ewd-urp-dashboard-new-footer-two-icon">
		<div class="ewd-urp-dashboard-new-footer-two-blurb">
			At Etoile Web Design, we build reliable, easy-to-use WordPress plugins with a modern look. Rich in features, highly customizable and responsive, plugins by Etoile Web Design can be used as out-of-the-box solutions and can also be adapted to your specific requirements.
		</div>
		<ul class="ewd-urp-dashboard-new-footer-two-menu">
			<li>SOCIAL</li>
			<li><a href="https://www.facebook.com/EtoileWebDesign/" target="_blank">Facebook</a></li>
			<li><a href="https://twitter.com/EtoileWebDesign" target="_blank">Twitter</a></li>
			<li><a href="https://www.etoilewebdesign.com/blog/" target="_blank">Blog</a></li>
		</ul>
		<ul class="ewd-urp-dashboard-new-footer-two-menu">
			<li>SUPPORT</li>
			<li><a href="https://www.youtube.com/watch?v=IxM1mizhzek&list=PLEndQUuhlvSpw3HQakJHj4G0F0Gyc-CtU" target="_blank">YouTube Tutorials</a></li>
			<li><a href="https://wordpress.org/support/plugin/ultimate-reviews" target="_blank">Forums</a></li>
			<li><a href="http://www.etoilewebdesign.com/plugins/ultimate-reviews/documentation-ultimate-reviews/" target="_blank">Documentation</a></li>
			<li><a href="https://wordpress.org/plugins/ultimate-reviews/#faq" target="_blank">FAQs</a></li>
		</ul>
	</div>
</div> <!-- ewd-urp-dashboard-new-footer-two -->

<!-- END NEW DASHBOARD -->

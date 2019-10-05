<!-- Upgrade to pro link box -->
<!-- TOP BOX-->
<?php
	//start review box
	if (isset($_POST['hide_ufaq_review_box_hidden'])) {update_option('EWD_URP_Hide_Dash_Review_Ask', $_POST['hide_ufaq_review_box_hidden']);}
	$hideReview = get_option('EWD_URP_Hide_Dash_Review_Ask');
	$Ask_Review_Date = get_option('EWD_URP_Ask_Review_Date');
	if ($Ask_Review_Date == "") {$Ask_Review_Date = time() - 3600*24;}

	$Install_Time = get_option("EWD_URP_Install_Time");
?>

<div id="fade" class="ewd-urp-dark_overlay"></div>

<div id="ewd-dashboard-top" class="metabox-holder">
<?php if ($EWD_URP_Full_Version != "Yes") { ?>
<div id="side-sortables" class="metabox-holder ">
	<div id="upcp_pro" class="postbox " >
		<div class="handlediv" title="Click to toggle"></div><h3 class='hndle'><span><?php _e("Full Version", 'ultimate-reviews') ?></span></h3>
		<div class="inside">
			<ul><li><a href="http://www.etoilewebdesign.com/plugins/ultimate-reviews/"><?php _e("Upgrade to the full version ", 'ultimate-reviews'); ?></a><?php _e("to take advantage of all the available features of Ultimate Reviews for Wordpress!", 'ultimate-reviews'); ?></li></ul>
			<h3 class='hndle'><span><?php _e("What you get by upgrading:", 'ultimate-reviews') ?></span></h3>
				<ul>
					<li>Control who reviews by requiring email confirmation or login.</li>
					<li>WooCommerce integration, to let you create more detailed reviews for your products.</li>
					<li>Two extra review formats, admin notifications when a review is received, and dozens of styling and labeling options!</li>
					<li>Access to email support.</li>
				</ul>
			<div class="full-version-form-div">
				<form action="edit.php?post_type=urp_review" method="post">
					<div class="form-field form-required">
						<label for="Key"><?php _e("Product Key", 'ultimate-reviews') ?></label>
						<input name="Key" type="text" value="" size="40" />
					</div>							
					<input type="submit" name="EWD_URP_Upgrade_To_Full" value="<?php _e('Upgrade', 'ultimate-reviews') ?>">
				</form>
			</div> 
		</div>
	</div>
	</div>
<?php } ?>

<?php if (get_option("EWD_URP_Update_Flag") == "Yes" or get_option("EWD_URP_Install_Flag") == "Yes") {?>
	<div id="side-sortables" class="metabox-holder ">
		<div id="EWD_URP_pro" class="postbox " >
			<div class="handlediv" title="Click to toggle"></div>
			<h3 class='hndle'><span><?php _e("Thank You!", 'ultimate-reviews') ?></span></h3>
		 	<div class="inside">
				<?php  if (get_option("EWD_URP_Install_Flag") == "Yes") { ?><ul><li><?php _e("Thanks for installing the Ultimate Reviews plugin.", 'ultimate-reviews'); ?><br> <a href='https://www.youtube.com/channel/UCZPuaoetCJB1vZOmpnMxJNw'><?php _e("Subscribe to our YouTube channel ", 'ultimate-reviews'); ?></a> <?php _e("for tutorial videos on this and our other plugins!", 'ultimate-reviews');?> </li></ul>
				<?php } else { ?><ul><li><?php _e("Thanks for upgrading to version 1.2.7!", 'ultimate-reviews'); ?><br> <a href='https://wordpress.org/support/plugin/ultimate-reviews/reviews/'><?php _e("Please rate our plugin", 'ultimate-reviews'); ?></a> <?php _e("if you find Ultimate Reviews useful!", 'ultimate-reviews');?> </li></ul><?php } ?>
											
				<?php /* if (get_option("EWD_URP_Install_Flag") == "Yes") { ?><ul><li><?php _e("Thanks for installing the Ultimate Product Catalogue Plugin.", 'ultimate-reviews'); ?><br> <a href='http://www.facebook.com/EtoileWebDesign'><?php _e("Follow us on Facebook", 'ultimate-reviews'); ?></a> <?php _e("to suggest new features or hear about upcoming ones!", 'ultimate-reviews');?> </li></ul>
				<?php } else { ?><ul><li><?php _e("Thanks for upgrading to version 2.2.9!", 'ultimate-reviews'); ?><br> <a href='http://www.facebook.com/EtoileWebDesign'><?php _e("Follow us on Facebook", 'ultimate-reviews'); ?></a> <?php _e("to suggest new features or hear about upcoming ones!", 'ultimate-reviews');?> </li></ul><?php } */ ?>
											
				<?php /* if (get_option("EWD_URP_Install_Flag") == "Yes") { ?><ul><li><?php _e("Thanks for installing the Ultimate Product Catalogue Plugin.", 'ultimate-reviews'); ?><br> <a href='http://www.facebook.com/EtoileWebDesign'><?php _e("Follow us on Facebook", 'ultimate-reviews'); ?></a> <?php _e("to suggest new features or hear about upcoming ones!", 'ultimate-reviews');?>  </li></ul>
				<?php } else { ?><ul><li><?php _e("Thanks for upgrading to version 3.0.16!", 'ultimate-reviews'); ?><br> <a href='http://wordpress.org/support/view/plugin-reviews/ultimate-product-catalogue'><?php _e("Please rate our plugin", 'ultimate-reviews'); ?></a> <?php _e("if you find the Ultimate Product Catalogue Plugin useful!", 'ultimate-reviews');?> </li></ul><?php } */ ?>
											
				<?php /* if (get_option("EWD_URP_Install_Flag") == "Yes") { ?><ul><li><?php _e("Thanks for installing the Ultimate Product Catalogue Plugin.", 'ultimate-reviews'); ?><br> <a href='http://www.facebook.com/EtoileWebDesign'><?php _e("Follow us on Facebook", 'ultimate-reviews'); ?></a> <?php _e("to suggest new features or hear about upcoming ones!", 'ultimate-reviews');?>  </li></ul>
				<?php } else { ?><ul><li><?php _e("Thanks for upgrading to version 3.4.8!", 'ultimate-reviews'); ?><br> <a href='http://wordpress.org/plugins/order-tracking/'><?php _e("Try out order tracking plugin ", 'ultimate-reviews'); ?></a> <?php _e("if you ship orders and find the Ultimate Product Catalogue Plugin useful!", 'ultimate-reviews');?> </li></ul><?php } */ ?>

				<?php /* if (get_option("EWD_URP_Install_Flag") == "Yes") { ?><ul><li><?php _e("Thanks for installing the Ultimate Product Catalogue Plugin.", 'ultimate-reviews'); ?><br> <a href='http://www.facebook.com/EtoileWebDesign'><?php _e("Follow us on Facebook", 'ultimate-reviews'); ?></a> <?php _e("to suggest new features or hear about upcoming ones!", 'ultimate-reviews');?>  </li></ul>
				<?php } else { ?><ul><li><?php _e("Thanks for upgrading to version 2.3.9!", 'ultimate-reviews'); ?><br> <a href='http://wordpress.org/support/topic/error-hunt'><?php _e("Please let us know about any small display/functionality errors. ", 'ultimate-reviews'); ?></a> <?php _e("We've noticed a couple, and would like to eliminate as many as possible.", 'ultimate-reviews');?> </li></ul><?php } */ ?>
											
				<?php /* if (get_option("EWD_URP_Install_Flag") == "Yes") { ?><ul><li><?php _e("Thanks for installing the Ultimate Product Catalogue Plugin.", 'ultimate-reviews'); ?><br> <a href='https://www.youtube.com/channel/UCZPuaoetCJB1vZOmpnMxJNw'><?php _e("Check out our YouTube channel ", 'ultimate-reviews'); ?></a> <?php _e("for tutorial videos on this and our other plugins!", 'ultimate-reviews');?> </li></ul>
				<?php } elseif ($Full_Version == "Yes") { ?><ul><li><?php _e("Thanks for upgrading to version 3.5.0!", 'ultimate-reviews'); ?><br> <a href='http://www.facebook.com/EtoileWebDesign'><?php _e("Follow us on Facebook", 'ultimate-reviews'); ?></a> <?php _e("to suggest new features or hear about upcoming ones!", 'ultimate-reviews');?> </li></ul>
				<?php } else { ?><ul><li><?php _e("Thanks for upgrading to version 3.4!", 'ultimate-reviews'); ?><br> <?php _e("Love the plugin but don't need the premium version? Help us speed up product support and development by donating. Thanks for using the plugin!", 'ultimate-reviews');?>
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="AQLMJFJ62GEFJ">
						<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
						</li></ul>
				<?php } */ ?>

			</div>
		</div>
	</div>
	<?php  
	update_option('EWD_URP_Update_Flag', "No");
	update_option('EWD_URP_Install_Flag', "No"); 
} 
?>


	<div id="ewd-dashboard-box-orders" class="ewd-urp-dashboard-box" >
	  	<div class="ewd-dashboard-box-icon"><img src="http://www.etoilewebdesign.com/DevelopmentFour/wp-content/uploads/2016/06/ewd-urp-buttonsicons-01.png"/>
	  	</div>
		<div class="ewd-dashboard-box-value-and-field-container">
		  <div class="ewd-dashboard-box-value"><span class="displaying-num"><?php echo $wpdb->num_rows; ?></span>
		  </div>
		  <div class="ewd-dashboard-box-field">orders
		  </div>
		</div>
	</div>
	<div id="ewd-dashboard-box-links" class="ewd-urp-dashboard-box" >
	  	<div class="ewd-dashboard-box-icon"><img src="http://www.etoilewebdesign.com/DevelopmentFour/wp-content/uploads/2016/06/ewd-urp-buttonsicons-02.png"/>
	  	</div>
		<div class="ewd-dashboard-box-value-and-field-container">
		  <div class="ewd-dashboard-box-value">103
		  </div>
		  <div class="ewd-dashboard-box-field">links clicked
		  </div>
		</div>
	</div>
	<div id="ewd-dashboard-box-views" class="ewd-urp-dashboard-box" >
	  	<div class="ewd-dashboard-box-icon"><img src="http://www.etoilewebdesign.com/DevelopmentFour/wp-content/uploads/2016/06/ewd-urp-buttonsicons-03.png"/>
	  	</div>
		<div class="ewd-dashboard-box-value-and-field-container">
		  <div class="ewd-dashboard-box-value">984
		  </div>
		  <div class="ewd-dashboard-box-field">views
		  </div>
		</div>
	</div>

	<div id="ewd-dashboard-box-support" class="ewd-urp-dashboard-box" >
		<div class="ewd-dashboard-box-icon"><img src="http://www.etoilewebdesign.com/DevelopmentFour/wp-content/uploads/2016/06/ewd-urp-buttonsicons-04.png"/>
	  	</div>
		<div class="ewd-dashboard-box-value-and-field-container">
		  	<div class="ewd-dashboard-box-support-value">
			<form id="form1" runat="server">
			<a href="javascript:void(0)" onclick="document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'">Click here for support</a>
		  		</div>
			</div>
		</div>
	<div id="light" class="ewd-urp-bright_content">
            <asp:Label ID="lbltext" runat="server" Text="Hey there!"></asp:Label>
            <a href="javascript:void(0)" onclick="document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">Close</a>
		</br>
		<h2>Need help?</h2>
		<p>You may find the information you need with our support tools.</p>
		<a href="https://www.youtube.com/playlist?list=PLEndQUuhlvSqa6Txwj1-Ohw8Bj90CIRl0"><img src="http://www.etoilewebdesign.com/DevelopmentFour/wp-content/uploads/2016/06/support_icons_ewd-urp-01.png"/></a>
		<a href="https://www.youtube.com/playlist?list=PLEndQUuhlvSqa6Txwj1-Ohw8Bj90CIRl0"><h4>Youtube Tutorials</h4></a>
		<p>Our tutorials show you the basics of setting up your plugin, to the more specific utilization of our features.</p>
		<a href="https://wordpress.org/support/plugin/order-tracking"><img src="http://www.etoilewebdesign.com/DevelopmentFour/wp-content/uploads/2016/06/support_icons_ewd-urp-03.png"/></a>
		<a href="https://wordpress.org/support/plugin/order-tracking"><h4>WordPress Forum</h4></a>
		<p>We make sure to answer your questions within a 24hrs frame during our business days. Search within our threads to find your answers. If it has not been addressed, please create a new thread!</p>
		<a href="http://www.etoilewebdesign.com/plugins/order-tracking/documentation-order-tracking/"><img src="http://www.etoilewebdesign.com/DevelopmentFour/wp-content/uploads/2016/06/support_icons_ewd-urp-02.png"/></a>		
		<a href="http://www.etoilewebdesign.com/plugins/order-tracking/documentation-order-tracking/"><h4>Documentation</h4></a>
		<p>Most information concerning the installation, the shortcodes and the features are found within our documentation page.</p>
        </div>
        <div id="fade" class="ewd-urp-dark_overlay">
        </div>
	</form>

<!--END TOP BOX-->
</div>

<!--Middle box-->
<div class="ewd-dashboard-middle">
<div id="col-full">
<h3 class="ewd-urp-dashboard-h3">Orders Summary</div>
<div>
<?php echo get_option('plugin_error'); ?>
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>

<?php 
			if (isset($_GET['Page'])) {$Page = $_GET['Page'];}
			else {$Page = 1;}
			
			$Sql = "SELECT * FROM $EWD_URP_orders_table_name WHERE Order_Display='Yes' ";
				if (isset($_GET['OrderBy']) and $_GET['DisplayPage'] == "Dashboard") {$Sql .= "ORDER BY " . $_GET['OrderBy'] . " " . $_GET['Order'] . " ";}
				else {$Sql .= "ORDER BY Order_Number ";}
				$Sql .= "LIMIT " . ($Page - 1)*20 . ",20";
				$myrows = $wpdb->get_results($Sql);
				$TotalOrders = $wpdb->get_results("SELECT Order_ID FROM $EWD_URP_orders_table_name WHERE Order_Display='Yes'");
				$Number_of_Pages = ceil($wpdb->num_rows/20);
				$Current_Page_With_Order_By = "admin.php?page=ewd-urp-options&DisplayPage=Dashboard";
				if (isset($_GET['OrderBy'])) {$Current_Page_With_Order_By .= "&OrderBy=" .$_GET['OrderBy'] . "&Order=" . $_GET['Order'];}?>

<form action="admin.php?page=ewd-urp-options&ewd-urpAction=EWD_URP_MassAction" method="post">    

<table class="wp-list-table widefat fixed tags sorttable ewd-urp-dasboard-table" cellspacing="0">
		<thead id="ewd-urp-dashboard-thead">
		<tr>
			<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
				<input type="checkbox" /></th><th scope='col' id='field-name' class='manage-column column-name sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Number" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=ewd-urp-options&DisplayPage=Dashboard&OrderBy=Order_Number&Order=DESC'>";}
					else {echo "<a href='admin.php?page=ewd-urp-options&DisplayPage=Dashboard&OrderBy=Order_Number&Order=ASC'>";} 
				?>
					<span><?php _e("Order Number", 'ultimate-reviews') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<th scope='col' id='type' class='manage-column column-type sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=ewd-urp-options&DisplayPage=Dashboard&OrderBy=Order_Name&Order=DESC'>";}
					else {echo "<a href='admin.php?page=ewd-urp-options&DisplayPage=Dashboard&OrderBy=Order_Name&Order=ASC'>";} 
				?>
					<span><?php _e("Name", 'ultimate-reviews') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Status" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=ewd-urp-options&DisplayPage=Dashboard&OrderBy=Order_Status&Order=DESC'>";}
					else {echo "<a href='admin.php?page=ewd-urp-options&DisplayPage=Dashboard&OrderBy=Order_Status&Order=ASC'>";} 
				?>
					<span><?php _e("Status", 'ultimate-reviews') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<?php if (in_array("Customer_Notes", $Order_Information)) { ?>
				<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
					<?php 
						if ($_GET['OrderBy'] == "Order_Status" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=ewd-urp-options&DisplayPage=Dashboard&OrderBy=Order_Customer_Notes&Order=DESC'>";}
						else {echo "<a href='admin.php?page=ewd-urp-options&DisplayPage=Dashboard&OrderBy=Order_Customer_Notes&Order=ASC'>";} 
					?>
						<span><?php _e("Customer Notes", 'ultimate-reviews') ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
			<?php } ?>
			<th scope='col' id='required' class='manage-column column-users sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "Order_Status_Updated" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=ewd-urp-options&DisplayPage=Dashboard&OrderBy=Order_Status_Updated&Order=DESC'>";}
					else {echo "<a href='admin.php?page=ewd-urp-options&DisplayPage=Dashboard&OrderBy=Order_Status_Updated&Order=ASC'>";} 
				?>
					<span><?php _e("Updated", 'ultimate-reviews') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
		</tr>
	</thead>

	<tbody id="ewd-urp-dashboard-tbody" class='list:tag'>
		
		 <?php
				if ($myrows) { 
	  			  foreach ($myrows as $Order) {
								echo "<tr id='Order" . $Order->Order_ID ."'>";
								echo "<th scope='row' class='check-column'>";
								echo "<input type='checkbox' name='Orders_Bulk[]' value='" . $Order->Order_ID ."' />";
								echo "</th>";
								echo "<td class='name column-name'>";
								echo "<strong>";
								echo "<a class='row-title' href='admin.php?page=ewd-urp-options&ewd-urpAction=EWD_URP_Order_Details&Selected=Order&Order_ID=" . $Order->Order_ID ."' title='Edit " . $Order->Order_Number . "'>" . $Order->Order_Number . "</a></strong>";
								echo "<br />";
								echo "<div class='row-actions'>";
								echo "<span class='delete'>";
								echo "<a class='delete-tag' href='admin.php?page=ewd-urp-options&ewd-urpAction=EWD_URP_HideOrder&DisplayPage=Dashboard&Order_ID=" . $Order->Order_ID ."'>" . __("Hide", 'ultimate-reviews') . "</a>";
		 						echo "</span>";
								echo "</div>";
								echo "<div class='hidden' id='inline_" . $Order->Order_ID ."'>";
								echo "<div class='number'>" . stripslashes($Order->Order_Number) . "</div>";
								echo "</div>";
								echo "</td>";
								echo "<td class='name column-name'>" . stripslashes($Order->Order_Name) . "</td>";
								echo "<td class='status column-status'>" . stripslashes($Order->Order_Status) . "</td>";
								if (in_array("Customer_Notes", $Order_Information)) {echo "<td class='customer-notes column-notes'>" . stripslashes($Order->Order_Customer_Notes) . "</td>";}
								echo "<td class='updated column-updated'>" . stripslashes($Order->Order_Status_Updated) . "</td>";
								echo "</tr>";
						}
				}
		?>

	</tbody>
</table>

<div class="tablenav bottom">
		<div class="alignright actions">
				<select name='action' class="ewd-urp-dashboard-select">
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'ultimate-reviews') ?></option>
						<?php if (!is_array($Statuses_Array)) {$Statuses_Array = array();}
							foreach ($Statuses_Array as $Status_Array_Item) { ?>
							<option value='<?php echo $Status_Array_Item['Status']; ?>'><?php echo $Status_Array_Item['Status']; ?></option>
						<?php } ?>
						<option value='hide'><?php _e("Hide Order", 'ultimate-reviews') ?></option>
						<option value='delete'><?php _e("Delete", 'ultimate-reviews') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action ewd-urp-dashboard-submit" value="<?php _e('Apply', 'ultimate-reviews') ?>"  />
		</div>
		<!--<div class='tablenav-pages <?php if ($Number_of_Pages == 1) {echo "one-page";} ?>'>
				<span class="displaying-num"><?php echo $wpdb->num_rows; ?> <?php _e("items", 'ultimate-reviews') ?></span>
				<span class='pagination-links'>
						<a class='first-page <?php if ($Page == 1) {echo "disabled";} ?>' title='Go to the first page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=1'>&laquo;</a>
						<a class='prev-page <?php if ($Page <= 1) {echo "disabled";} ?>' title='Go to the previous page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=<?php echo $Page-1;?>'>&lsaquo;</a>
						<span class="paging-input"><?php echo $Page; ?> <?php _e("of", 'ultimate-reviews') ?> <span class='total-pages'><?php echo $Number_of_Pages; ?></span></span>
						<a class='next-page <?php if ($Page >= $Number_of_Pages) {echo "disabled";} ?>' title='Go to the next page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=<?php echo $Page+1;?>'>&rsaquo;</a>
						<a class='last-page <?php if ($Page == $Number_of_Pages) {echo "disabled";} ?>' title='Go to the last page' href='<?php echo $Current_Page_With_Order_By . "&Page=" . $Number_of_Pages; ?>'>&raquo;</a>
				</span>
		</div>-->
</div>

</form>

<br class="clear" />
</div>
</div>

<?php if ($Ask_Review_Date < time() and $Install_Time < time() - 3600*24*4) { ?>
<div id='ewd-ufaq-review-ask-overlay'></div>
<div class='ewd-ufaq-review-ask-popup'>
	<div class='ewd-ufaq-review-ask-title'><?php _e('Thank You!', 'EWD_UFAQ'); ?></div>
	<div class='ewd-ufaq-review-ask-content'>
		<p><?php _e('We wanted to thank the users of our plugins for all of their great reviews recently.', 'EWD_UFAQ'); ?></p>
		<p><?php _e('Your positive feedback and constructive suggestions on how to improve our plugins make coming in to work every day worth it for us.', 'EWD_UFAQ'); ?></p>
		<p><strong><?php _e("Haven't had a chance to leave a review yet? You can do so at:", 'EWD_UFAQ'); ?></strong></p>
		<a href='https://wordpress.org/support/plugin/ultimate-faqs/reviews/' target="_blank" class='ewd-ufaq-review-ask-content-link'>Leave a Review!</a>
	</div>
	<div class='ewd-ufaq-review-ask-footer-links'>
		<div class='ewd-ufaq-hide-review-ask' id="ewd-ufaq-hide-review-ask-week" data-askreviewdelay='7'><?php _e('Ask me in a week', 'EWD_UFAQ'); ?></div>
		<div class='ewd-ufaq-hide-review-ask' id="ewd-ufaq-hide-review-ask-never" data-askreviewdelay='2000'><?php _e('Never ask me again', 'EWD_UFAQ'); ?></div>
	</div>
</div>
<?php } ?>
<!-- END MIDDLE BOX -->

<!-- FOOTER BOX -->
<!-- A list of the products in the catalogue -->
<div class="ewd-dashboard-footer">
<div id='ewd-dashboard-updates' class='ewd-urp-updates postbox upcp-postbox-collapsible'>
<h3 class='hndle ewd-urp-dashboard-h3' id='ewd-recent-changes'><?php _e("Recent Changes", 'UPCP'); ?> <i class="fa fa-cog" aria-hidden="true"></i></h3>
<div class='ewd-dashboard-content' ><?php echo get_option('UPCP_Changelog_Content'); ?></div>
</div>

<div id='ewd-dashboard-blog' class='ewd-urp-blog postbox upcp-postbox-collapsible'>
<h3 class='hndle ewd-urp-dashboard-h3'>News <i class="fa fa-rss" aria-hidden="true"></i></h3>
<div class='ewd-dashboard-content'><?php echo get_option('UPCP_Blog_Content'); ?></div>
</div>

<div id="ewd-dashboard-plugins" class='ewd-urp-plugins postbox upcp-postbox-collapsible' >
	<h3 class='hndle ewd-urp-dashboard-h3'><span><?php _e("Goes great with:", 'UPCP') ?></span><i class="fa fa-plug" aria-hidden="true"></i></h3>
	<div class="inside">
		<div class="ewd-dashboard-plugin-icons">
			<div style="width:50%">
				<a target='_blank' href='https://wordpress.org/plugins/ultimate-product-catalogue/'><img style="width:100%" src='http://www.etoilewebdesign.com/wp-content/uploads/2015/12/UPCP_Icons-07-300x300.png'/></a>
			</div>
			<div>
				<h3>Product Catalog</h3> <p>Enables you to display your business's products in a clean and efficient manner.</p>
			</div>
			
		</div>
		<div class="ewd-dashboard-plugin-icons">
			<div style="width:50%">
				<a target='_blank' href='https://wordpress.org/plugins/ultimate-reviews/'><img style="width:100%" src='http://www.etoilewebdesign.com/DevelopmentFour/wp-content/uploads/2016/04/URP_Icons-03.png'/></a>
			</div>
			<div>
				<h3>Ultimate Reviews</h3><p>Let visitors submit reviews and display them right in the tabbed page layout!</p>
			</div>
			
		</div>
	</div>
</div>
</div>
</div>


<?php
function UPCP_Get_EWD_Blog() {
	if (!function_exists('curl_version')) {return;}
	
	$Update_URL = 'http://www.etoilewebdesign.com/Dashboard/UPCP.html';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $Update_URL);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$response = curl_exec($ch);
	curl_close($ch);

	update_option('UPCP_Blog_Content', $response);
}

function UPCP_Get_Changelog() {
	$Readme_URL = UPCP_CD_PLUGIN_PATH . 'readme.txt';
	$Readme = file_get_contents($Readme_URL);

	$Changes_Start = strpos($Readme, "== Changelog ==") + 15;
	$Changes_Section = substr($Readme, $Changes_Start);

	$Changes_Text = substr($Changes_Section, 0, strposX($Changes_Section, "=", 5));

	$Changes_Text = str_replace("= ", "<h3>", $Changes_Text);
	$Changes_Text = str_replace(" =", "</h3>", $Changes_Text);

	update_option('UPCP_Changelog_Content', $Changes_Text);
}

function strposX($haystack, $needle, $number){
    if($number == '1'){
        return strpos($haystack, $needle);
    }elseif($number > '1'){
        return strpos($haystack, $needle, strposX($haystack, $needle, $number - 1) + strlen($needle));
    }else{
        return error_log('Error: Value for parameter $number is out of range');
    }
}

?>
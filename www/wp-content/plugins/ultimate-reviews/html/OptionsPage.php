<?php
$Custom_CSS = get_option("EWD_URP_Custom_CSS");
$Maximum_Score = get_option("EWD_URP_Maximum_Score");
$Review_Style = get_option("EWD_URP_Review_Style");
$Review_Score_Input = get_option("EWD_URP_Review_Score_Input");
$Review_Image = get_option("EWD_URP_Review_Image");
$Review_Video = get_option("EWD_URP_Review_Video");
$Review_Category = get_option("EWD_URP_Review_Category");
$Review_Filtering = get_option("EWD_URP_Review_Filtering");
if (!is_array($Review_Filtering)) {$Review_Filtering = array();}
$Submit_Review_Toggle = get_option("EWD_URP_Submit_Review_Toggle");
$Allow_Reviews = get_option("EWD_URP_Allow_Reviews");
$Review_Categories_Array = get_option("EWD_URP_Review_Categories_Array");
$Autocomplete_Product_Names = get_option("EWD_URP_Autocomplete_Product_Names");
$Restrict_Product_Names = get_option("EWD_URP_Restrict_Product_Names");
$Product_Name_Input_Type = get_option("EWD_URP_Product_Name_Input_Type");
$UPCP_Integration = get_option("EWD_URP_UPCP_Integration");
$Product_Names_Array = get_option("EWD_URP_Product_Names_Array");
$Link_To_Post = get_option("EWD_URP_Link_To_Post");
$Display_Author = get_option("EWD_URP_Display_Author");
$Display_Date = get_option("EWD_URP_Display_Date");
$Display_Time = get_option("EWD_URP_Display_Time");
$Display_Categories = get_option("EWD_URP_Display_Categories");
$Author_Click_Filter = get_option("EWD_URP_Author_Click_Filter");
$Flag_Inappropriate = get_option("EWD_URP_Flag_Inappropriate");
$Review_Comments = get_option("EWD_URP_Review_Comments");
$Review_Character_Limit = get_option("EWD_URP_Review_Character_Limit");
$Email_On_Submission = get_option("EWD_URP_Email_On_Submission");
$Reviews_Per_Page = get_option("EWD_URP_Reviews_Per_Page");
$Pagination_Location = get_option("EWD_URP_Pagination_Location");
$Show_TinyMCE = get_option("EWD_URP_Show_TinyMCE");

$Review_Format = get_option("EWD_URP_Review_Format");
$Summary_Statistics = get_option("EWD_URP_Summary_Statistics");
$Summary_Clickable = get_option("EWD_URP_Summary_Clickable");
$Display_Microdata = get_option("EWD_URP_Display_Microdata");
$Pretty_Permalinks = get_option("EWD_URP_Pretty_Permalinks");
$Review_Weights = get_option("EWD_URP_Review_Weights");
$Review_Karma = get_option("EWD_URP_Review_Karma");
$Use_Captcha = get_option("EWD_URP_Use_Captcha");
$Infinite_Scroll = get_option("EWD_URP_Infinite_Scroll");
$Thumbnail_Characters = get_option("EWD_URP_Thumbnail_Characters");
$Read_More_AJAX = get_option("EWD_URP_Read_More_AJAX");
$Admin_Notification = get_option("EWD_URP_Admin_Notification");
$Admin_Email_Address = get_option("EWD_URP_Admin_Email_Address");
$Admin_Approval = get_option("EWD_URP_Admin_Approval");
$Require_Email = get_option("EWD_URP_Require_Email");
$Email_Confirmation = get_option("EWD_URP_Email_Confirmation");
$Display_On_Confirmation = get_option("EWD_URP_Display_On_Confirmation");
$One_Review_Per_Product_Person = get_option("EWD_URP_One_Review_Per_Product_Person");
$Review_Blacklist = get_option("EWD_URP_Review_Blacklist");
$Require_Login = get_option("EWD_URP_Require_Login");
$Login_Options = get_option("EWD_URP_Login_Options");
if (!is_array($Login_Options)) {$Login_Options = array();}

$Replace_WooCommerce_Reviews = get_option("EWD_URP_Replace_WooCommerce_Reviews");
$WooCommerce_Review_Submit_First = get_option("EWD_URP_WooCommerce_Review_Submit_First");
$Only_WooCommerce_Products = get_option("EWD_URP_Only_WooCommerce_Products");
$WooCommerce_Review_Types = get_option("EWD_URP_WooCommerce_Review_Types");
$Override_WooCommerce_Theme = get_option("EWD_URP_Override_WooCommerce_Theme");
$Display_WooCommerce_Verified = get_option("EWD_URP_Display_WooCommerce_Verified");
$WooCommerce_Maximum_Days = get_option("EWD_URP_WooCommerce_Maximum_Days");
$Match_WooCommerce_Categories = get_option("EWD_URP_Match_WooCommerce_Categories");
$WooCommerce_Category_Product_Reviews = get_option("EWD_URP_WooCommerce_Category_Product_Reviews");
$Reminders_Array = get_option("EWD_URP_Reminders_Array");
if (!is_array($Reminders_Array)) {$Reminders_Array = array();}
$Email_Messages_Array = get_option("EWD_URP_Email_Messages_Array");
if (!is_array($Email_Messages_Array)) {$Email_Messages_Array = array();}

$WordPress_Login_URL = get_option("EWD_URP_WordPress_Login_URL");
$FEUP_Login_URL = get_option("EWD_URP_FEUP_Login_URL");
$Facebook_App_ID = get_option("EWD_URP_Facebook_App_ID");
$Facebook_Secret = get_option("EWD_URP_Facebook_Secret");
$Twitter_Key = get_option("EWD_URP_Twitter_Key");
$Twitter_Secret = get_option("EWD_URP_Twitter_Secret");

$InDepth_Reviews = get_option("EWD_URP_InDepth_Reviews");
$Review_Categories_Array = get_option("EWD_URP_Review_Categories_Array");

$Group_By_Product = get_option("EWD_URP_Group_By_Product");
$Group_By_Product_Order = get_option("EWD_URP_Group_By_Product_Order");
$Ordering_Type = get_option("EWD_URP_Ordering_Type");
$Order_Direction = get_option("EWD_URP_Order_Direction");

$Display_Numerical_Score = get_option("EWD_URP_Display_Numerical_Score");
$Reviews_Skin = get_option("EWD_URP_Reviews_Skin");
$Review_Group_Separating_Line = get_option("EWD_URP_Review_Group_Separating_Line");
$InDepth_Layout = get_option("EWD_URP_InDepth_Layout");
$Reviews_Read_More_Style = get_option("EWD_URP_Read_More_Style");

$Posted_Label = get_option("EWD_URP_Posted_Label");
$By_Label = get_option("EWD_URP_By_Label");
$On_Label = get_option("EWD_URP_On_Label");
$Score_Label = get_option("EWD_URP_Score_Label");
$Explanation_Label = get_option("EWD_URP_Explanation_Label");
$Submit_Product_Label = get_option("EWD_URP_Submit_Product_Label");
$Submit_Author_Label = get_option("EWD_URP_Submit_Author_Label");
$Submit_Author_Comment_Label = get_option("EWD_URP_Submit_Author_Comment_Label");
$Submit_Title_Label = get_option("EWD_URP_Submit_Title_Label");
$Submit_Title_Comment_Label = get_option("EWD_URP_Submit_Title_Comment_Label");
$Submit_Score_Label = get_option("EWD_URP_Submit_Score_Label");
$Submit_Review_Label = get_option("EWD_URP_Submit_Review_Label");
$Submit_Cat_Score_Label = get_option("EWD_URP_Submit_Cat_Score_Label");
$Submit_Explanation_Label = get_option("EWD_URP_Submit_Explanation_Label");
$Submit_Button_Label = get_option("EWD_URP_Submit_Button_Label");
$Submit_Success_Message = get_option("EWD_URP_Submit_Success_Message");
$Submit_Draft_Message = get_option("EWD_URP_Submit_Draft_Message");
$Review_For_Label = get_option("EWD_URP_Review_For_Label");
$Categories_Label_Label = get_option("EWD_URP_Categories_Label_Label");
$Filter_Button_Label = get_option("EWD_URP_Filter_Button_Label");
$Filter_Product_Name_Label = get_option("EWD_URP_Filter_Product_Name_Label");
$Filter_All_Label = get_option("EWD_URP_Filter_All_Label");
$Filter_Review_Score_Label = get_option("EWD_URP_Filter_Review_Score_Label");
$Filter_Review_Author_Label = get_option("EWD_URP_Filter_Review_Author_Label");
$Submit_Reviewer_Email_Address_Label = get_option("EWD_URP_Submit_Reviewer_Email_Address_Label");
$Submit_Reviewer_Email_Address_Instructions_Label = get_option("EWD_URP_Submit_Reviewer_Email_Address_Instructions_Label");
$Submit_Image_Number_Label = get_option("EWD_URP_Submit_Image_Number_Label");
$Summary_Average_Score_Label = get_option("EWD_URP_Summary_Average_Score_Label");
$Summary_Ratings_Label = get_option("EWD_URP_Summary_Ratings_Label");

$urp_Review_Title_Font = get_option("EWD_urp_Review_Title_Font");
$urp_Review_Title_Font_Size = get_option("EWD_urp_Review_Title_Font_Size");
$urp_Review_Title_Font_Color = get_option("EWD_urp_Review_Title_Font_Color");
$urp_Review_Title_Margin = get_option("EWD_urp_Review_Title_Margin");
$urp_Review_Title_Padding = get_option("EWD_urp_Review_Title_Padding");
$urp_Review_Content_Font = get_option("EWD_urp_Review_Content_Font");
$urp_Review_Content_Font_Size = get_option("EWD_urp_Review_Content_Font_Size");
$urp_Review_Content_Font_Color = get_option("EWD_urp_Review_Content_Font_Color");
$urp_Review_Content_Margin = get_option("EWD_urp_Review_Content_Margin");
$urp_Review_Content_Padding = get_option("EWD_urp_Review_Content_Padding");
$urp_Review_Postdate_Font = get_option("EWD_urp_Review_Postdate_Font");
$urp_Review_Postdate_Font_Size = get_option("EWD_urp_Review_Postdate_Font_Size");
$urp_Review_Postdate_Font_Color = get_option("EWD_urp_Review_Postdate_Font_Color");
$urp_Review_Postdate_Margin = get_option("EWD_urp_Review_Postdate_Margin");
$urp_Review_Postdate_Padding = get_option("EWD_urp_Review_Postdate_Padding");
$urp_Review_Score_Font = get_option("EWD_urp_Review_Score_Font");
$urp_Review_Score_Font_Size = get_option("EWD_urp_Review_Score_Font_Size");
$urp_Review_Score_Font_Color = get_option("EWD_urp_Review_Score_Font_Color");
$urp_Review_Score_Margin = get_option("EWD_urp_Review_Score_Margin");
$urp_Review_Score_Padding = get_option("EWD_urp_Review_Score_Padding");

$urp_Summary_Stats_Color = get_option("EWD_urp_Summary_Stats_Color");
$urp_Simple_Bar_Color = get_option("EWD_urp_Simple_Bar_Color");
$urp_Color_Bar_High = get_option("EWD_urp_Color_Bar_High");
$urp_Color_Bar_Medium = get_option("EWD_urp_Color_Bar_Medium");
$urp_Color_Bar_Low = get_option("EWD_urp_Color_Bar_Low");
$urp_Review_Background_Color = get_option("EWD_urp_Review_Background_Color");
$urp_Review_Header_Background_Color = get_option("EWD_urp_Review_Header_Background_Color");
$urp_Review_Content_Background_Color = get_option("EWD_urp_Review_Content_Background_Color");

$urp_Read_More_Button_Background_Color = get_option("EWD_urp_Read_More_Button_Background_Color");
$urp_Read_More_Button_Text_Color = get_option("EWD_urp_Read_More_Button_Text_Color");
$urp_Read_More_Button_Hover_Background_Color = get_option("EWD_urp_Read_More_Button_Hover_Background_Color");
$urp_Read_More_Button_Hover_Text_Color = get_option("EWD_urp_Read_More_Button_Hover_Text_Color");

$urp_Image_Style_Background_Color = get_option("EWD_urp_Image_Style_Background_Color");
$urp_Circle_Graph_Background_Color = get_option("EWD_urp_Circle_Graph_Background_Color");
$urp_Circle_Graph_Fill_Color = get_option("EWD_urp_Circle_Graph_Fill_Color");

$urp_Email_Reminder_Background_Color = get_option("EWD_urp_Email_Reminder_Background_Color");
$urp_Email_Reminder_Inner_Color = get_option("EWD_urp_Email_Reminder_Inner_Color");
$urp_Email_Reminder_Text_Color = get_option("EWD_urp_Email_Reminder_Text_Color");
$urp_Email_Reminder_Button_Background_Color = get_option("EWD_urp_Email_Reminder_Button_Background_Color");
$urp_Email_Reminder_Button_Text_Color = get_option("EWD_urp_Email_Reminder_Button_Text_Color");
$urp_Email_Reminder_Button_Background_Hover_Color = get_option("EWD_urp_Email_Reminder_Button_Background_Hover_Color");
$urp_Email_Reminder_Button_Text_Hover_Color = get_option("EWD_urp_Email_Reminder_Button_Text_Hover_Color");

$UWPM_Banner_Time = get_option("EWD_URP_UWPM_Ask_Time");
if ($UWPM_Banner_Time == "") {$UWPM_Banner_Time = 0;}

$Display_Tab = (isset($_POST['Display_Tab']) ? $_POST['Display_Tab'] : '');
?>

<div class="wrap urp-options-page-tabbed">
	<div class="urp-options-submenu-div">
		<ul class="urp-options-submenu urp-options-page-tabbed-nav">
			<li><a id="Basic_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == '' or $Display_Tab == 'Basic') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Basic');">Basic</a></li>
			<li><a id="Premium_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Premium') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Premium');">Premium</a></li>
			<li><a id="WooCommerce_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'WooCommerce') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('WooCommerce');">WooCommerce</a></li>
			<li><a id="Fields_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Fields') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Fields');">Fields</a></li>
			<li><a id="Order_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Order') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Order');">Ordering</a></li>
			<li><a id="Labelling_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Labelling') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Labelling');">Labelling</a></li>
			<li><a id="Styling_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Styling') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Styling');">Styling</a></li>
		</ul>
	</div>


	<div class="urp-options-page-tabbed-content">
		<form method="post" action="admin.php?page=EWD-URP-Options&DisplayPage=Options&Action=EWD_URP_UpdateOptions">
			<?php wp_nonce_field('URP_Admin_Action', 'URP_Admin_Action'); ?>
			<input type='hidden' name='Display_Tab' value='<?php echo $Display_Tab; ?>' />
			<div id='Basic' class='urp-option-set <?php echo ( ($Display_Tab == '' or $Display_Tab == 'Basic') ? '' : 'urp-hidden' ); ?>'>
				<h2 id='label-basic-options' class='urp-options-page-tab-title'>Basic Options</h2>
				<br />

				<div class="ewd-urp-shortcode-reminder">
					<div class="ewd-urp-shortcode-reminder-inside"><?php _e('To display reviews, place the <strong>[ultimate-reviews]</strong> shortcode on a page', 'ultimate-reviews'); ?></div>
					<div class="ewd-urp-shortcode-reminder-inside"><?php _e('To allow visitors to submit a review, place the <strong>[submit-review]</strong> shortcode on a page', 'ultimate-reviews'); ?></div>
				</div>

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('General', 'ultimate-reviews'); ?></div>

				<table class="form-table">
					<tr>
						<th scope="row">Custom CSS</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Custom CSS</span></legend>
								<label title='Custom CSS'></label><textarea class='ewd-urp-textarea' name='custom_css'> <?php echo $Custom_CSS; ?></textarea><br />
								<p>You can add custom CSS styles for your reviews in the box above.</p>
							</fieldset>
						</td>
					</tr>

					<tr>
						<th scope="row">Maximum Review Score</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Maximum Review Score</span></legend>
								<input type='text' name='maximum_score' value='<?php echo $Maximum_Score; ?>' />
								<p>What should the maximum score be on the review form? Common values are 100 for the 'percentage' review style, and 5 or 10 for the other styles.</p>
							</fieldset>
						</td>
					</tr>

					<tr>
						<th scope="row">Review Style</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Review Style</span></legend>
								<label title='Points' class='ewd-urp-admin-input-container'><input type='radio' name='review_style' value='Points' <?php if($Review_Style == "Points") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Points</span></label><br />
								<label title='Percentage' class='ewd-urp-admin-input-container'><input type='radio' name='review_style' value='Percentage' <?php if($Review_Style  == "Percentage") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Percentage</span></label><br />
								<p>What style should the submit-review form use to collect reviews?</p>
							</fieldset>
						</td>
					</tr>

					<tr>
						<th scope="row">Review Score Input</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Review Score Input</span></legend>
								<label title='Text' class='ewd-urp-admin-input-container'><input type='radio' name='review_score_input' value='Text' <?php if($Review_Score_Input == "Text") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Text</span></label><br />
								<label title='Select' class='ewd-urp-admin-input-container'><input type='radio' name='review_score_input' value='Select' <?php if($Review_Score_Input  == "Select") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Select</span></label><br />
								<label title='Stars' class='ewd-urp-admin-input-container'><input type='radio' name='review_score_input' value='Stars' <?php if($Review_Score_Input  == "Stars") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Stars</span></label><br />
								<p>What type of input should be used for review scores in the submit-review shortcode?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Review Image</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Review Image</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='review_image' value='Yes' <?php if($Review_Image == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='review_image' value='No' <?php if($Review_Image  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="review_image" <?php if($Review_Image == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should there be a field for the reviewer to upload an image of what they're reviewing?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Review Video</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Review Video</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='review_video' value='Yes' <?php if($Review_Video == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='review_video' value='No' <?php if($Review_Video  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="review_video" <?php if($Review_Video == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should there be a field for the reviewer to embed a video with their review from an external site (YouTube, Vimeo, etc.)?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Review Category</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Review Category</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='review_category' value='Yes' <?php if($Review_Category == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='review_category' value='No' <?php if($Review_Category  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="review_category" <?php if($Review_Category == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should the reviewer be able to select a category for their review?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Review Filtering</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Review Filtering</span></legend>
								<label title='Score' class='ewd-urp-admin-input-container'><input type='checkbox' name='review_filtering[]' value='Score' <?php if(in_array("Score", $Review_Filtering)) {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-checkbox'></span> <span>Review Score</span></label><br />
								<label title='Name' class='ewd-urp-admin-input-container'><input type='checkbox' name='review_filtering[]' value='Name' <?php if(in_array("Name", $Review_Filtering)) {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-checkbox'></span> <span>Product Name</span></label><br />
								<label title='Author' class='ewd-urp-admin-input-container'><input type='checkbox' name='review_filtering[]' value='Author' <?php if(in_array("Author", $Review_Filtering)) {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-checkbox'></span> <span>Review Author</span></label><br />
								<p>Should visitors be able to filter reviews by product name, score or review author?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Shortcode Builder</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Shortcode Builder</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='show_tinymce' value='Yes' <?php if($Show_TinyMCE == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='show_tinymce' value='No' <?php if($Show_TinyMCE  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="show_tinymce" <?php if($Show_TinyMCE == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should a shortcode builder be added to the tinyMCE toolbar in the page editor?</p>
							</fieldset>
						</td>
					</tr>
				</table>

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('Functionality', 'ultimate-reviews'); ?></div>

				<table class="form-table">
					<tr>
						<th scope="row">Submit Review Toggle</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Submit Review Toggle</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='submit_review_toggle' value='Yes' <?php if($Submit_Review_Toggle == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='submit_review_toggle' value='No' <?php if($Submit_Review_Toggle  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="submit_review_toggle" <?php if($Submit_Review_Toggle == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should the submit review form be hidden until a button is clicked to show it?</p>
							</fieldset>
						</td>
					</tr>
					<!--<tr>
						<th scope="row">Post/Page/Category Reviews</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Post/Page/Category Reviews</span></legend>
								<label title='Posts'><input type='checkbox' name='allow_reviews[]' value='Posts' <?php if(in_array("Posts", $Allow_Reviews)) {echo "checked='checked'";} ?> /> <span>Posts</span></label><br />
								<label title='Pages'><input type='checkbox' name='allow_reviews[]' value='Pages' <?php if(in_array("Pages", $Allow_Reviews)) {echo "checked='checked'";} ?> /> <span>Pages</span></label><br />
								<label title='Categories'><input type='checkbox' name='allow_reviews[]' value='Categories' <?php if(in_array("Categories", $Allow_Reviews)) {echo "checked='checked'";} ?> /> <span>Categories</span></label><br />
								<p>Allow visitors to leave reviews for posts, pages or categories.</p>
							</fieldset>
						</td>
					</tr>-->
					<tr>
						<th scope="row">Autocomplete Product Names</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Autocomplete Product Names</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='autocomplete_product_names' value='Yes' <?php if($Autocomplete_Product_Names == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='autocomplete_product_names' value='No' <?php if($Autocomplete_Product_Names  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="autocomplete_product_names" <?php if($Autocomplete_Product_Names == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should the names of the available products display in an auto-complete box when a visitor starts typing? Products need to be entered in the list below or UPCP Integration has to be turned on for this to work.</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Link To Post</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Link To Post</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='link_to_post' value='Yes' <?php if($Link_To_Post == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='link_to_post' value='No' <?php if($Link_To_Post  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="link_to_post" <?php if($Link_To_Post == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should the review title link to the single post page for the review?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Flag Inappropriate Content</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Flag Inappropriate Content</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='flag_inappropriate' value='Yes' <?php if($Flag_Inappropriate == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='flag_inappropriate' value='No' <?php if($Flag_Inappropriate  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="flag_inappropriate" <?php if($Flag_Inappropriate == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should visitors be able to flag content as inappropriate, so that admins can then review it?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Review Author Links</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Review Author Links</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='author_click_filter' value='Yes' <?php if($Author_Click_Filter == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='author_click_filter' value='No' <?php if($Author_Click_Filter  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="author_click_filter" <?php if($Author_Click_Filter == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should the author's name be clickable, so that visitors can see other reviews by the same author?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Allow Review Comments</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Allow Review Comments</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='review_comments' value='Yes' <?php if($Review_Comments == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='review_comments' value='No' <?php if($Review_Comments  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="review_comments" <?php if($Review_Comments == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should comments be allowed, if they "Allow Comments" box for individual reviews is selected from the edit review screen?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Review Character Limit</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Review Character Limit</span></legend>
								<input type='text' name='review_character_limit' value='<?php echo $Review_Character_Limit; ?>' />
								<p>What should be the limit on the number of characters in a review? Leave blank for unlimited characters.</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Submission Thank You Email</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Submission Thank You Email</span></legend>
								<?php 
									$plugin = "ultimate-wp-mail/Main.php";
									$UWPM_Installed = is_plugin_active($plugin);
									if ($UWPM_Installed) {
										$UWPM_Emails = get_posts(array('post_type' => 'uwpm_mail_template', 'posts_per_page' => -1));
										echo "<select name='email_on_submission'>";
										foreach ($UWPM_Emails as $Email) {
											echo "<option value='-" . $Email->ID . "' " . (($Email_On_Submission * -1) == $Email->ID ? 'selected' : '') . ">" . $Email->post_title . "</option>";
										}
										echo "</select>";
										echo "<p>What email should be sent out when a review is submitted? This option only works if 'Author Email' is one of your submitted fields.</p>";
									}
									else {
										echo "<p>You can use the <a href='https://wordpress.org/plugins/ultimate-wp-mail/' target='_blank'>Ultimate WP Mail plugin</a> to create a custom email that is sent whenever a review is submitted.</p>";
									}
								?>
							</fieldset>
						</td>
					</tr>
				</table>

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('Products Available for Review', 'ultimate-reviews'); ?></div>

				<table class="form-table">
					<tr>
						<th scope="row">Restrict Product Names</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Restrict Product Names</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='restrict_product_names' value='Yes' <?php if($Restrict_Product_Names == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='restrict_product_names' value='No' <?php if($Restrict_Product_Names  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="restrict_product_names" <?php if($Restrict_Product_Names == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should the names of the products be restricted to only those specified?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Product Name Input Type</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Product Name Input Type</span></legend>
								<label title='Text' class='ewd-urp-admin-input-container'><input type='radio' name='product_name_input_type' value='Text' <?php if($Product_Name_Input_Type == "Text") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Text</span></label><br />
								<label title='Dropdown' class='ewd-urp-admin-input-container'><input type='radio' name='product_name_input_type' value='Dropdown' <?php if($Product_Name_Input_Type  == "Dropdown") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Dropdown</span></label><br />
								<p>Should the product name input be a text field or a dropdown (select) field? (Select only works if UPCP integration is turned on or "Products List" is filled in below)</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">UPCP Integration</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>UPCP Integration</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='upcp_integration' value='Yes' <?php if($UPCP_Integration == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='upcp_integration' value='No' <?php if($UPCP_Integration  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="upcp_integration" <?php if($UPCP_Integration == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should the product names be taken from the Ultimate Reviewsue Plugin if the names are being restricted or the product name input type is set to "Dropdown"? (Ultimate Reviewsue plugin needs to be installed to work correctly)</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Products List</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Products List</span></legend>
								<table id='ewd-urp-product-list-table'>
									<thead>
										<tr>
											<th class="ewd-urp-admin-no-info-button">Product Name</th>
											<th class="ewd-urp-admin-no-info-button"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$Counter = 0;
										if (!is_array($Product_Names_Array)) {$Product_Names_Array = array();}
										foreach ($Product_Names_Array as $Product_Name_Item) {
											echo "<tr id='ewd-urp-product-list-item-" . $Counter . "'>";
											echo "<td class='ewd-urp-move-cursor'><input type='hidden' name='Product_List_" . $Counter . "_Name' value='" . $Product_Name_Item['ProductName'] . "'/>" . $Product_Name_Item['ProductName'] . "</td>";
											echo "<td><a class='ewd-urp-delete-product-list-item' data-productid='" . $Counter . "'>Delete</a></td>";
											echo "</tr>";
											$Counter++;
										}
										echo "<tr><td colspan='1'><a class='ewd-urp-add-product-list-item ewd-urp-new-admin-add-button' data-nextid='" . $Counter . "'>&plus; " . __('ADD', 'ultimate-reviews') . "</a></td></tr>";
										?>
									</tbody>
								</table>
								<p>If UPCP integration is set to "No", and the product names are restricted or the input type is set to "Dropdown", the list of products above will be used to restrict the possible product names.</p>
							</fieldset>
						</td>
					</tr>
				</table>

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('Display and Layout', 'ultimate-reviews'); ?></div>

				<table class="form-table">
					<tr>
						<th scope="row">Display Author Name</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Display Author Name</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='display_author' value='Yes' <?php if($Display_Author == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='display_author' value='No' <?php if($Display_Author  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="display_author" <?php if($Display_Author == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should the author's name be posted with the review?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Display Date Submitted</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Display Date Submitted</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='display_date' value='Yes' <?php if($Display_Date == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='display_date' value='No' <?php if($Display_Date  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="display_date" <?php if($Display_Date == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should the date the review was submitted be posted with the review?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Display Time Submitted</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Display Time Submitted</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='display_time' value='Yes' <?php if($Display_Time == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='display_time' value='No' <?php if($Display_Time  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="display_time" <?php if($Display_Time == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should the time the review was submitted be posted along with the date of the review?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Display Categories</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Display Categories</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='display_categories' value='Yes' <?php if($Display_Categories == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='display_categories' value='No' <?php if($Display_Categories  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="display_categories" <?php if($Display_Categories == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should the review's categories be posted with the review?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Reviews Per Page</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Reviews Per Page</span></legend>
								<input type='text' name='reviews_per_page' value='<?php echo $Reviews_Per_Page; ?>' />
								<p>Set the maximum number of reviews that should be displayed at one time.</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Pagination Location</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Pagination Location</span></legend>
								<label title='Top' class='ewd-urp-admin-input-container'><input type='radio' name='pagination_location' value='Top' <?php if($Pagination_Location  == "Top") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Top</span></label><br />
								<label title='Bottom' class='ewd-urp-admin-input-container'><input type='radio' name='pagination_location' value='Bottom' <?php if($Pagination_Location  == "Bottom") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Bottom</span></label><br />
								<label title='Both' class='ewd-urp-admin-input-container'><input type='radio' name='pagination_location' value='Both' <?php if($Pagination_Location  == "Both") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Both</span></label><br />
								<p>Where should the pagination controls be located, if there are more reviews than the maximum per page?</p>
							</fieldset>
						</td>
					</tr>
				</table>
			</div>

			<div id='Premium' class='urp-option-set <?php echo ( ($Display_Tab == 'Premium') ? '' : 'urp-hidden' ); ?>'>
				<h2 id='label-premium-options' class='urp-options-page-tab-title'>Premium Options</h2>

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('General', 'ultimate-reviews'); ?></div>

				<table class="form-table ewd-urp-premium-options-table">
					<tr>
						<th scope="row">Review Format</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Review Format</span></legend>
								<label title='Standard' class='ewd-urp-admin-input-container'><input type='radio' name='review_format' value='Standard' <?php if($Review_Format == "Standard") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Standard</span></label><br />
								<label title='Expandable' class='ewd-urp-admin-input-container'><input type='radio' name='review_format' value='Expandable' <?php if($Review_Format == "Expandable") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Expandable</span></label><br />
								<label title='Thumbnail' class='ewd-urp-admin-input-container'><input type='radio' name='review_format' value='Thumbnail' <?php if($Review_Format == "Thumbnail") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Thumbnail</span></label><br />
								<label title='Thumbnail Masonry' class='ewd-urp-admin-input-container'><input type='radio' name='review_format' value='Thumbnail_Masonry' <?php if($Review_Format == "Thumbnail_Masonry") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Thumbnail Masonry</span></label><br />
								<label title='Image' class='ewd-urp-admin-input-container'><input type='radio' name='review_format' value='Image' <?php if($Review_Format == "Image") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Image</span></label><br />
								<label title='Image Masonry' class='ewd-urp-admin-input-container'><input type='radio' name='review_format' value='Image_Masonry' <?php if($Review_Format == "Image_Masonry") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Image Masonry</span></label><br />
								<p></p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Captcha</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Captcha</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='use_captcha' value='Yes' <?php if($Use_Captcha == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='use_captcha' value='No' <?php if($Use_Captcha == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="use_captcha" <?php if($Use_Captcha == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should Captcha be added to the submit review form to prevent spamming? (requires image-creation support for your PHP installation)</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Weighted Reviews</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Weighted Reviews</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='review_weights' value='Yes' <?php if($Review_Weights == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='review_weights' value='No' <?php if($Review_Weights == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="review_weights" <?php if($Review_Weights == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should reviews be weighted when the average rating is calculated, so that some reviews count more? These weights can be set below the review's content when turned on.</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Review Karma</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Review Karma</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='review_karma' value='Yes' <?php if($Review_Karma == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='review_karma' value='No' <?php if($Review_Karma == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="review_karma" <?php if($Review_Karma == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should visitors be allowed to vote up or down reviews that they find or don't find useful? ("Did you find this review helpful?")<br />Uses cookies to make it more difficult to vote up or down multiple times.</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Infinite Scroll</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Infinite Scroll</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='infinite_scroll' value='Yes' <?php if($Infinite_Scroll == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='infinite_scroll' value='No' <?php if($Infinite_Scroll  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="infinite_scroll" <?php if($Infinite_Scroll == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>If there are more than the maximum number of reviews per page displayed, should the next page of reviews be loaded automatically by AJAX so that the page doesn't need to be reloaded? This may not work if you also have a review widget displaying on the same page.</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Include Microdata</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Include Microdata</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='display_microdata' value='Yes' <?php if($Display_Microdata == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='display_microdata' value='No' <?php if($Display_Microdata == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="display_microdata" <?php if($Display_Microdata == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should microdata be added to the reviews when they're displayed? Microdata helps search engine to display your reviews in a more helpful format (<a href='http://www.htmlgoodies.com/html5/Web-Developer-Tutorial-HTML5-Microdata-3920016.htm#fbid=UWk0EObAqCE' target='_blank'>Find out more</a>).</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Pretty Permalinks</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Pretty Permalinks</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='pretty_permalinks' value='Yes' <?php if($Pretty_Permalinks == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='pretty_permalinks' value='No' <?php if($Pretty_Permalinks == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="pretty_permalinks" <?php if($Pretty_Permalinks == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should an SEO friendly permalink structure be used for the link to this Review?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Admin Notification Email</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Admin Notification Email</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='admin_notification' value='Yes' <?php if($Admin_Notification == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='admin_notification' value='No' <?php if($Admin_Notification  == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="admin_notification" <?php if($Admin_Notification == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should an email be sent to the WordPress admin?</p>
							</fieldset>
						</td>
					</tr>
					<tr class="ewd-urp-admin-conditional-admin-notification-option<?php echo ( ($Admin_Notification == 'Yes') ? '' : ' urp-hidden' ); ?>">
						<th scope="row">Admin Email Address</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Admin Email Address</span></legend>
								<input type='text' name='admin_email_address' value='<?php echo $Admin_Email_Address; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								<p>The email address admin notifications should be sent to, if "Admin Notification Email" is enabled. Leave blank to use the default WordPress admin email.</p>
							</fieldset>
						</td>
					</tr>
					<?php if ($URP_Full_Version != "Yes") { ?>
						<tr class="ewd-urp-premium-options-table-overlay">
							<th colspan="2">
								<div class="ewd-urp-unlock-premium">
									<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Reviews Premium">
									<p>Access this section by by upgrading to premium</p>
									<a href="https://www.etoilewebdesign.com/plugins/ultimate-reviews/#buy" class="ewd-urp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
								</div>
							</th>
						</tr>
					<?php } ?>
				</table>

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('Display Features', 'ultimate-reviews'); ?></div>

				<table class="form-table ewd-urp-premium-options-table">
					<tr>
						<th scope="row">Summary Statistics</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Summary Statistics</span></legend>
								<label title='Full' class='ewd-urp-admin-input-container'><input type='radio' name='summary_statistics' value='Full' <?php if($Summary_Statistics == "Full") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Full</span></label><br />
								<label title='Limited' class='ewd-urp-admin-input-container'><input type='radio' name='summary_statistics' value='Limited' <?php if($Summary_Statistics == "Limited") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Limited</span></label><br />
								<label title='None' class='ewd-urp-admin-input-container'><input type='radio' name='summary_statistics' value='None' <?php if($Summary_Statistics  == "None") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>None</span></label><br />
								<p>Should a summary of the reviews be displayed at the top? (average score, etc.)<br>This feature may not work as expected with in-depth reviews and/or pagination.</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Clickable Summary Stats</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Clickable Summary Stats</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='summary_clickable' value='Yes' <?php if($Summary_Clickable == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='summary_clickable' value='No' <?php if($Summary_Clickable == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="summary_clickable" <?php if($Summary_Clickable == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should visitors be able to click on the summary statistic bars ("Summary Statistics" must be set to "Full") to view all reviews with that score?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Thumbnail Characters</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Thumbnail Characters</span></legend>
								<input type='text' name='thumbnail_characters' value='<?php echo $Thumbnail_Characters; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								<p>What is the maximum number of characters that should be shown in the preview in thumbnail format?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Thumbnail 'Read More' AJAX</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Thumbnail 'Read More' AJAX</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='read_more_ajax' value='Yes' <?php if($Read_More_AJAX == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='read_more_ajax' value='No' <?php if($Read_More_AJAX  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="read_more_ajax" <?php if($Read_More_AJAX == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>If you have selected the "Thumbnail" format, should the content be loaded on the same page when clicking "Read More"?</p>
							</fieldset>
						</td>
					</tr>
					<?php if ($URP_Full_Version != "Yes") { ?>
						<tr class="ewd-urp-premium-options-table-overlay">
							<th colspan="2">
								<div class="ewd-urp-unlock-premium">
									<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Reviews Premium">
									<p>Access this section by by upgrading to premium</p>
									<a href="https://www.etoilewebdesign.com/plugins/ultimate-reviews/#buy" class="ewd-urp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
								</div>
							</th>
						</tr>
					<?php } ?>
				</table>

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('Restrictions', 'ultimate-reviews'); ?></div>

				<table class="form-table ewd-urp-premium-options-table">
					<tr>
						<th scope="row">Require Admin Approval</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Require Admin Approval</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='admin_approval' value='Yes' <?php if($Admin_Approval == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='admin_approval' value='No' <?php if($Admin_Approval  == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="admin_approval" <?php if($Admin_Approval == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should new reviews have their status set to 'draft' until an admin decides to publish them?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Require Author Email</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Require Author Email</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='require_email' value='Yes' <?php if($Require_Email == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='require_email' value='No' <?php if($Require_Email  == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="require_email" <?php if($Require_Email == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Do reviewers have to include their email address (not publicly displayed) when they post a review?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Require Email Confirmation</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Require Email Confirmation</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='email_confirmation' value='Yes' <?php if($Email_Confirmation == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='email_confirmation' value='No' <?php if($Email_Confirmation  == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="email_confirmation" <?php if($Email_Confirmation == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Do reviewers have to confirm their email address before their review is displayed?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Display Form on Confirmation</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Display Form on Confirmation</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='display_on_confirmation' value='Yes' <?php if($Display_On_Confirmation == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='display_on_confirmation' value='No' <?php if($Display_On_Confirmation  == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="display_on_confirmation" <?php if($Display_On_Confirmation == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should the submit review form be displayed when someone is confirming their email address?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">One Review per Person/Product</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>One Review per Person/Product</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='one_review_per_product_person' value='Yes' <?php if($One_Review_Per_Product_Person == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='one_review_per_product_person' value='No' <?php if($One_Review_Per_Product_Person  == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="one_review_per_product_person" <?php if($One_Review_Per_Product_Person == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should users be restricted to leaving one review per product? Uses cookies to track which products a user has reviewed.</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Review Blacklist</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Review Blacklist</span></legend>
								<textarea type='text' name='review_blacklist' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>><?php echo $Review_Blacklist; ?></textarea>
								<p>Enter a comma-separated list of terms that you want to exclude from being allowed to leave a review. This can include IP addresses that you want to block, names, email addresses, keywords, etc.</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Require Login</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Require Login</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='require_login' value='Yes' <?php if($Require_Login == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='require_login' value='No' <?php if($Require_Login == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="require_login" <?php if($Require_Login == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Do reviewers have to log in before they can post a review?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Login Options</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Login Options</span></legend>
								<label title='WordPress' class='ewd-urp-admin-input-container'><input id='ewd-urp-wordpress-login-option' type='checkbox' name='login_options[]' value='WordPress' <?php if(in_array("WordPress", $Login_Options)) {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-urp-admin-checkbox'></span> <span>WordPress</span></label><br />
								<label title='FEUP' class='ewd-urp-admin-input-container'><input id='ewd-urp-feup-login-option' type='checkbox' name='login_options[]' value='FEUP' <?php if(in_array("FEUP", $Login_Options)) {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-urp-admin-checkbox'></span> <span><a href='https://wordpress.org/plugins/front-end-only-users/'>Front-End Only Users</a></span></label><br />
								<label title='Twitter' class='ewd-urp-admin-input-container'><input id='ewd-urp-twitter-login-option' type='checkbox' name='login_options[]' value='Twitter' <?php if(in_array("Twitter", $Login_Options)) {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-urp-admin-checkbox'></span> <span>Twitter</span></label><br />
								<label title='Facebook' class='ewd-urp-admin-input-container'><input id='ewd-urp-facebook-login-option' type='checkbox' name='login_options[]' value='Facebook' <?php if(in_array("Facebook", $Login_Options)) {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-urp-admin-checkbox'></span> <span>Facebook</span></label><br />
								<p>What methods should users be able to use to log in before posting a review?<br /><strong>WARNING: "Verified Buyers" in the "WooCommerce" options section will override this option.</strong></p>
							</fieldset>
						</td>
					</tr>
					<tr class='ewd-urp-wordpress-login-option ewd-urp-woocommerce-login-option'>
						<th scope="row">WordPress Login URL</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>WordPress Login URL</span></legend>
								<input type='text' name='wordpress_login_url' value='<?php echo $WordPress_Login_URL; ?>' />
								<p>The URL of your WordPress login page.</p>
							</fieldset>
						</td>
					</tr>
					<tr class='ewd-urp-feup-login-option'>
						<th scope="row">FEUP Login URL</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>FEUP Login URL</span></legend>
								<input type='text' name='feup_login_url' value='<?php echo $FEUP_Login_URL; ?>' />
								<p>The URL of your Front-End Only Users login page.</p>
							</fieldset>
						</td>
					</tr>
					<tr class='ewd-urp-facebook-login-option'>
						<th scope="row">Facebook App ID</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Facebook App ID</span></legend>
								<input type='text' name='facebook_app_id' value='<?php echo $Facebook_App_ID; ?>' />
								<p>The App ID displayed when you created the Facebook API application request.<br />
								Check out <a href='https://www.youtube.com/watch?v=txCfgVmsR7g'> this tutorial</a> if you need help getting an App ID or App Secret.</p>
							</fieldset>
						</td>
					</tr>
					<tr class='ewd-urp-facebook-login-option'>
						<th scope="row">Facebook Secret</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Facebook Secret</span></legend>
								<input type='text' name='facebook_secret' value='<?php echo $Facebook_Secret; ?>' />
								<p>The secret displayed when you created the Facebook API application request.</p>
							</fieldset>
						</td>
					</tr>
					<tr class='ewd-urp-twitter-login-option'>
						<th scope="row">Twitter Key</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Twitter Key</span></legend>
								<input type='text' name='twitter_key' value='<?php echo $Twitter_Key; ?>' />
								<p>The key displayed when you created the Twitter API application request.<br />
								Check out <a href='https://www.youtube.com/watch?v=9ckccMDhtQI'> this tutorial</a> if you need help getting an App ID or App Secret.</p>
							</fieldset>
						</td>
					</tr>
					<tr class='ewd-urp-twitter-login-option'>
						<th scope="row">Twitter Secret</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Twitter Secret</span></legend>
								<input type='text' name='twitter_secret' value='<?php echo $Twitter_Secret; ?>' />
								<p>The secret displayed when you created the Twitter API application request.</p>
							</fieldset>
						</td>
					</tr>
					<?php if ($URP_Full_Version != "Yes") { ?>
						<tr class="ewd-urp-premium-options-table-overlay">
							<th colspan="2">
								<div class="ewd-urp-unlock-premium">
									<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Reviews Premium">
									<p>Access this section by by upgrading to premium</p>
									<a href="https://www.etoilewebdesign.com/plugins/ultimate-reviews/#buy" class="ewd-urp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
								</div>
							</th>
						</tr>
					<?php } ?>
				</table>
			</div>

			<div id='WooCommerce' class='urp-option-set <?php echo ( ($Display_Tab == 'WooCommerce') ? '' : 'urp-hidden' ); ?>'>
				<h2 id='label-premium-options' class='urp-options-page-tab-title'>WooCommerce Options (Premium)</h2>

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('Settings', 'ultimate-reviews'); ?></div>

				<table class="form-table ewd-urp-premium-options-table <?php echo $URP_Full_Version; ?>">
					<tr>
						<th scope="row">Replace WooCommerce Reviews</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Replace WooCommerce Reviews</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='replace_woocommerce_reviews' value='Yes' <?php if($Replace_WooCommerce_Reviews == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='replace_woocommerce_reviews' value='No' <?php if($Replace_WooCommerce_Reviews == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="replace_woocommerce_reviews" <?php if($Replace_WooCommerce_Reviews == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should the "Reviews" tab on the WooCommerce product page use Ultimate Reviews instead of the default WooCommerce system?</p>
							</fieldset>
						</td>
					</tr>

					<tr class="ewd-urp-admin-conditional-wc-options<?php echo ($Replace_WooCommerce_Reviews != 'Yes' ? ' urp-hidden' : ''); ?>">
						<th scope="row">Submit Review on Top</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Submit Review on Top</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='woocommerce_review_submit_first' value='Yes' <?php if($WooCommerce_Review_Submit_First == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='woocommerce_review_submit_first' value='No' <?php if($WooCommerce_Review_Submit_First == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="woocommerce_review_submit_first" <?php if($WooCommerce_Review_Submit_First == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should the "Submit Review" form be displayed above a product's reviews in WooCommerce?</p>
							</fieldset>
						</td>
					</tr>

					<tr class="ewd-urp-admin-conditional-wc-options<?php echo ($Replace_WooCommerce_Reviews != 'Yes' ? ' urp-hidden' : ''); ?>">
						<th scope="row">Only Review WooCommerce Products</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Only Review WooCommerce Products</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='only_woocommerce_products' value='Yes' <?php if($Only_WooCommerce_Products == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='only_woocommerce_products' value='No' <?php if($Only_WooCommerce_Products == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="only_woocommerce_products" <?php if($Only_WooCommerce_Products == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should visitors only be able to leave reviews for WooCommerce products, and no other products?</p>
							</fieldset>
						</td>
					</tr>

					<tr class="ewd-urp-admin-conditional-wc-options<?php echo ($Replace_WooCommerce_Reviews != 'Yes' ? ' urp-hidden' : ''); ?>">
						<th scope="row">WooCommerce Review Type</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>WooCommerce Review Type</span></legend>
								<label title='Default' class='ewd-urp-admin-input-container'><input type='radio' name='woocommerce_review_types[]' value='Default' <?php if(in_array("Default", $WooCommerce_Review_Types)) {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Default</span></label><br />
								<div class='ewd-urp-option-divider'></div>
								<label title='Date' class='ewd-urp-admin-input-container'><input type='checkbox' name='woocommerce_review_types[]' value='Date' <?php if(in_array("Date", $WooCommerce_Review_Types)) {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-urp-admin-checkbox'></span> <span>Most recent reviews</span></label><br />
								<label title='Rating' class='ewd-urp-admin-input-container'><input type='checkbox' name='woocommerce_review_types[]' value='Rating' <?php if(in_array("Rating", $WooCommerce_Review_Types)) {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-urp-admin-checkbox'></span> <span>Top reviews</span></label><br />
								<label title='Karma' class='ewd-urp-admin-input-container'><input type='checkbox' name='woocommerce_review_types[]' value='Karma' <?php if(in_array("Karma", $WooCommerce_Review_Types)) {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-urp-admin-checkbox'></span> <span>Most voted reviews ("Review Karma" in "Premium" options must be set to "Yes")</span></label><br />
								<p>How should WooCommerce reviews be organized?</p>
							</fieldset>
						</td>
					</tr>

					<tr class="ewd-urp-admin-conditional-wc-options<?php echo ($Replace_WooCommerce_Reviews != 'Yes' ? ' urp-hidden' : ''); ?>">
						<th scope="row">Override Product Page Ratings</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Override Product Page Ratings</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='override_woocommerce_theme' value='Yes' <?php if($Override_WooCommerce_Theme == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='override_woocommerce_theme' value='No' <?php if($Override_WooCommerce_Theme == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="override_woocommerce_theme" <?php if($Override_WooCommerce_Theme == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should the ratings area under the product name on the WooCommerce product page use the ratings from our plugin, instead of those from the default WooCommerce reviews?</p>
							</fieldset>
						</td>
					</tr>

					<tr class="ewd-urp-admin-conditional-wc-options<?php echo ($Replace_WooCommerce_Reviews != 'Yes' ? ' urp-hidden' : ''); ?>">
						<th scope="row">Verified Buyers Only</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Verified Buyers</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='verified_buyers' value='Yes' <?php if(in_array("WooCommerce", $Login_Options)) {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='verified_buyers' value='No' <?php if(!in_array("WooCommerce", $Login_Options)) {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="verified_buyers" <?php if(in_array("WooCommerce", $Login_Options)) {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should only verified buyers be allowed to leave reviews?</p>
							</fieldset>
						</td>
					</tr>

					<!--
					<tr class="ewd-urp-admin-conditional-wc-options<?php echo ($Replace_WooCommerce_Reviews != 'Yes' ? ' urp-hidden' : ''); ?>">
						<th scope="row">Display Verified Symbol</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Verified Buyers</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='display_woocommerce_verified' value='Yes' <?php if($Display_WooCommerce_Verified == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='display_woocommerce_verified' value='No' <?php if($Display_WooCommerce_Verified == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="display_woocommerce_verified" <?php if($Display_WooCommerce_Verified == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should a "Verified" symbol be displayed next to reviews submitted by verified buyers?</p>
							</fieldset>
						</td>
					</tr>
					-->

					<tr class='ewd-urp-woocommerce-login-option ewd-urp-admin-conditional-wc-options<?php echo ($Replace_WooCommerce_Reviews != 'Yes' ? ' urp-hidden' : ''); ?>'>
						<th scope="row">WooCommerce Minimum Days Since Purchase</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>WooCommerce Minimum Days Since Purchase</span></legend>
								<input type='text' name='woocommerce_minimum_days' value='<?php echo $WooCommerce_Minimum_Days; ?>' />
								<p>The minimum days a customer needs to wait after making a purchase before they can review, if using verified buyers.</p>
							</fieldset>
						</td>
					</tr>

					<tr class='ewd-urp-woocommerce-login-option ewd-urp-admin-conditional-wc-options<?php echo ($Replace_WooCommerce_Reviews != 'Yes' ? ' urp-hidden' : ''); ?>'>
						<th scope="row">WooCommerce Maximum Days Since Purchase</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>WooCommerce Maximum Days Since Purchase</span></legend>
								<input type='text' name='woocommerce_maximum_days' value='<?php echo $WooCommerce_Maximum_Days; ?>' />
								<p>The maximum days after a purchase that a customer can leave a review, if using verified buyers.</p>
							</fieldset>
						</td>
					</tr>

					<tr class="ewd-urp-admin-conditional-wc-options<?php echo ($Replace_WooCommerce_Reviews != 'Yes' ? ' urp-hidden' : ''); ?>">
						<th scope="row">Match WooCommerce Categories</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Match WooCommerce Categories</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='match_woocommerce_categories' value='Yes' <?php if($Match_WooCommerce_Categories == "Yes") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='match_woocommerce_categories' value='No' <?php if($Match_WooCommerce_Categories == "No") {echo "checked='checked'";} ?> <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="match_woocommerce_categories" <?php if($Match_WooCommerce_Categories == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should review categories match the product categories in WooCommerce, and automatically attach a product's categories to reviews of that product?</p>
							</fieldset>
						</td>
					</tr>

					<tr class='ewd-urp-woocommerce-login-option ewd-urp-admin-conditional-wc-options<?php echo ($Replace_WooCommerce_Reviews != 'Yes' ? ' urp-hidden' : ''); ?>'>
						<th scope="row">Display Related Reviews</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Display Related Reviews</span></legend>
								<input type='text' name='woocommerce_category_product_reviews' value='<?php echo $WooCommerce_Category_Product_Reviews; ?>' />
								<p>Display reviews for other products in the same category (or categories) if there are less than the number of reviews above. Use 0 to never display reviews for other products.</p>
							</fieldset>
						</td>
					</tr>
					<?php if ($URP_Full_Version != "Yes") { ?>
						<tr class="ewd-urp-premium-options-table-overlay">
							<th colspan="2">
								<div class="ewd-urp-unlock-premium">
									<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Reviews Premium">
									<p>Access this section by by upgrading to premium</p>
									<a href="https://www.etoilewebdesign.com/plugins/ultimate-reviews/#buy" class="ewd-urp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
								</div>
							</th>
						</tr>
					<?php } ?>
				</table>

				<br />

				<div class="ewd-urp-admin-section-heading ewd-urp-admin-conditional-wc-options<?php echo ($Replace_WooCommerce_Reviews != 'Yes' ? ' urp-hidden' : ''); ?>"><?php _e('Review Reminder Emails', 'ultimate-reviews'); ?></div>

				<table class="form-table ewd-urp-premium-options-table ewd-urp-admin-conditional-wc-options" <?php echo ($Replace_WooCommerce_Reviews != 'Yes' ? ' style="display: none;"' : ''); ?>>
					<tr>
						<th scope="row"><?php _e('Review Reminders', 'ultimate-reviews'); ?></th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Review Reminders</span></legend>
								<table id='ewd-urp-reminders-table'>
									<thead>
										<tr>
											<th class="ewd-urp-admin-no-info-button"><?php _e('Email to Send', 'ultimate-reviews'); ?></th>
											<th class="ewd-urp-admin-no-info-button"><?php _e('Reminder Interval', 'ultimate-reviews'); ?></th>
											<th class="ewd-urp-admin-no-info-button"><?php _e('Reminder Unit', 'ultimate-reviews'); ?></th>
											<th class="ewd-urp-admin-no-info-button"><?php _e('Status', 'ultimate-reviews'); ?></th>
											<th class="ewd-urp-admin-no-info-button"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$Counter = 0;
										$Max_ID = 0;
										foreach ($Reminders_Array as $Reminder_Item) { ?>
											<tr id='ewd-urp-reminder-row-<?php echo $Counter; ?>'>
												<td><select name='Reminder_<?php echo $Counter; ?>_Email_To_Send' >
													<?php foreach ($Email_Messages_Array as $Email_Message_Item) { ?>
														<option value="<?php echo $Email_Message_Item['ID']; ?>" <?php if ($Email_Message_Item['ID'] == $Reminder_Item['Email_To_Send']) {echo "selected='selected'";} ?>><?php echo $Email_Message_Item['Name'] ?></option>
													<?php } ?>
													<?php 
														$plugin = "ultimate-wp-mail/Main.php";
														$UWPM_Installed = is_plugin_active($plugin);
														if ($UWPM_Installed) {
															$UWPM_Emails = get_posts(array('post_type' => 'uwpm_mail_template', 'posts_per_page' => -1));
															echo '<optgroup label="Ultimate WP Mail">';
															foreach ($UWPM_Emails as $Email) { 
																echo '<option value="-' . $Email->ID . '" ' . ($Email->ID == ($Reminder_Item['Email_To_Send'] * -1) ? 'selected' : '') . '>' . $Email->post_title . '</option>';
															}
															echo '</optgroup>';
														}
													?>
												</select></td>
												<td><select name='Reminder_<?php echo $Counter; ?>_Reminder_Interval' >
													<option value='0' <?php if ($Reminder_Item['Reminder_Interval'] == 0) {echo "selected='selected'";} ?>>Immediate</option>
													<option value='1' <?php if ($Reminder_Item['Reminder_Interval'] == 1) {echo "selected='selected'";} ?>>1</option>
													<option value='2' <?php if ($Reminder_Item['Reminder_Interval'] == 2) {echo "selected='selected'";} ?>>2</option>
													<option value='3' <?php if ($Reminder_Item['Reminder_Interval'] == 3) {echo "selected='selected'";} ?>>3</option>
													<option value='4' <?php if ($Reminder_Item['Reminder_Interval'] == 4) {echo "selected='selected'";} ?>>4</option>
													<option value='5' <?php if ($Reminder_Item['Reminder_Interval'] == 5) {echo "selected='selected'";} ?>>5</option>
													<option value='6' <?php if ($Reminder_Item['Reminder_Interval'] == 6) {echo "selected='selected'";} ?>>6</option>
													<option value='7' <?php if ($Reminder_Item['Reminder_Interval'] == 7) {echo "selected='selected'";} ?>>7</option>
													<option value='8' <?php if ($Reminder_Item['Reminder_Interval'] == 8) {echo "selected='selected'";} ?>>8</option>
													<option value='9' <?php if ($Reminder_Item['Reminder_Interval'] == 9) {echo "selected='selected'";} ?>>9</option>
													<option value='10' <?php if ($Reminder_Item['Reminder_Interval'] == 10) {echo "selected='selected'";} ?>>10</option>
													<option value='11' <?php if ($Reminder_Item['Reminder_Interval'] == 11) {echo "selected='selected'";} ?>>11</option>
													<option value='12' <?php if ($Reminder_Item['Reminder_Interval'] == 12) {echo "selected='selected'";} ?>>12</option>
													<option value='13' <?php if ($Reminder_Item['Reminder_Interval'] == 13) {echo "selected='selected'";} ?>>13</option>
													<option value='14' <?php if ($Reminder_Item['Reminder_Interval'] == 14) {echo "selected='selected'";} ?>>14</option>
													<option value='15' <?php if ($Reminder_Item['Reminder_Interval'] == 15) {echo "selected='selected'";} ?>>15</option>
													<option value='16' <?php if ($Reminder_Item['Reminder_Interval'] == 16) {echo "selected='selected'";} ?>>16</option>
													<option value='17' <?php if ($Reminder_Item['Reminder_Interval'] == 17) {echo "selected='selected'";} ?>>17</option>
													<option value='18' <?php if ($Reminder_Item['Reminder_Interval'] == 18) {echo "selected='selected'";} ?>>18</option>
													<option value='19' <?php if ($Reminder_Item['Reminder_Interval'] == 19) {echo "selected='selected'";} ?>>19</option>
													<option value='20' <?php if ($Reminder_Item['Reminder_Interval'] == 20) {echo "selected='selected'";} ?>>20</option>
													<option value='21' <?php if ($Reminder_Item['Reminder_Interval'] == 21) {echo "selected='selected'";} ?>>21</option>
													<option value='22' <?php if ($Reminder_Item['Reminder_Interval'] == 22) {echo "selected='selected'";} ?>>22</option>
													<option value='23' <?php if ($Reminder_Item['Reminder_Interval'] == 23) {echo "selected='selected'";} ?>>23</option>
												</select></td>
												<td><select name='Reminder_<?php echo $Counter; ?>_Reminder_Unit' >
													<option value='Hours' <?php if ($Reminder_Item['Reminder_Unit'] == "Hours") {echo "selected='selected'";} ?>>Hour(s)</option>
													<option value='Days' <?php if ($Reminder_Item['Reminder_Unit'] == "Days") {echo "selected='selected'";} ?>>Day(s)</option>
													<option value='Weeks' <?php if ($Reminder_Item['Reminder_Unit'] == "Weeks") {echo "selected='selected'";} ?>>Week(s)</option>
												</select></td>
												<td><select name='Reminder_<?php echo $Counter; ?>_Status_Trigger' >
													<?php
														if (function_exists('wc_get_order_statuses')) {$Statuses = wc_get_order_statuses();}
														else {$Statuses = array();}
														foreach ($Statuses as $key => $Status) {
													?>
														<option value='<?php echo $key; ?>' <?php if ($Reminder_Item['Status_Trigger'] == $key) {echo "selected='selected'";} ?>><?php echo $Status; ?></option>
													<?php } ?>
												</select></td>
												<td><input type='hidden' name='Reminder_<?php echo $Counter; ?>_ID' value='<?php echo $Reminder_Item['ID']; ?>' /><a class='ewd-urp-delete-reminder-item' data-remindercounter='<?php echo $Counter; ?>'>Delete</a></td>
											</tr>
											<?php $Counter++;
											$Max_ID = max($Max_ID, $Reminder_Item['ID']);
										}
										$Max_ID++;
										 ?>
										<tr><td colspan='4'><a class='ewd-urp-add-reminder-item ewd-urp-new-admin-add-button' data-nextcounter='<?php echo $Counter; ?>' data-maxid='<?php echo $Max_ID; ?>'>&plus; <?php _e('ADD', 'ultimate-reviews'); ?></a></td></tr>
									</tbody>
								</table>
								<ul>
									<li>Create as many reminders as you'd like using the table above.</li>
									<li>Reminder Interval and Unit combine to set the amount of time after an order has been set to the selected status before a reminder to review is sent out.</li>
									<li>Reminders can be stopped for a specific order by going to the WooCommerce "Orders" tab and unselecting the "Send Reminders" checkbox.</li>
									<li>Alternatively, reminders will automatically stop if "Review Codes" are required for your site, and the code for a specific order is used.</li>
								</ul>
							</fieldset>
						</td>
					</tr>
					<?php if (time() > $UWPM_Banner_Time and !$UWPM_Installed) { ?>
						<tr><td colspan='2'>
							<div class="ewd-urp-uwpm-banner">
								<div class="ewd-urp-uwpm-banner-remove"><span>X</span></div>
								<div class="ewd-urp-uwpm-banner-icon">
									<img src='<?php echo EWD_URP_CD_PLUGIN_URL . "/images/ewd-uwpm-icon.png"; ?>' />
								</div>
								<div class="ewd-urp-uwpm-banner-text">
									<div class="ewd-urp-uwpm-banner-title">
										<?php _e("Customize Your Emails With", 'ultimate-reviews'); ?>
										<span>Ultimate WP Mail</span>
									</div>
									<ul>
										<li>Completely FREE</li>
										<li>Uses Shortcodes and Variables</li>
										<li>Integrates Seamlessly</li>
										<li>Custom Subject Lines For Each Email</li>
										<li>Visual Builder</li>
										<li>An Easy Email Experience</li>
									</ul>
									<div class="ewd-urp-clear"></div>
								</div>
								<div class="ewd-urp-uwpm-banner-buttons">
									<a class="ewd-urp-uwpm-banner-download-button" href='plugin-install.php?s=ultimate+wp+mail&tab=search&type=term'>
										<?php _e("Download Now", 'ultimate-reviews'); ?>
									</a>
									<span class="ewd-urp-uwpm-banner-reminder"><? _e("Remind Me Later", 'ultimate-reviews'); ?></span>
								</div>
								<div class="ewd-urp-clear"></div>
							</div>
						</td></tr>
					<?php } ?>
					<tr>
						<th scope="row"><?php _e('Email Messages', 'ultimate-reviews'); ?></th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Email Messages</span></legend>
							<table id='ewd-urp-email-messages-table'>
								<tr>
									<th class="ewd-urp-admin-no-info-button"><?php _e('Message Subject', 'ultimate-reviews'); ?></th>
									<th class="ewd-urp-admin-no-info-button"><?php _e('Message', 'ultimate-reviews'); ?></th>
									<th class="ewd-urp-admin-no-info-button"></th>
									<th class="ewd-urp-admin-no-info-button"></th>
									<th class="ewd-urp-admin-no-info-button"></th>
								</tr>
								<?php
									$Counter = 0;
									$Max_ID = 0;
									foreach ($Email_Messages_Array as $Email_Message_Item) {
										echo "<tr id='ewd-urp-email-message-" . $Counter . "'>";
											echo "<td><input class='ewd-urp-array-text-input' type='text' name='Email_Message_" . $Counter . "_Name' value='" . $Email_Message_Item['Name']. "'/></td>";
											echo "<td colspan='3'><textarea class='ewd-urp-array-textarea' name='Email_Message_" . $Counter . "_Body' rows='5'>" . stripslashes($Email_Message_Item['Message']) . "</textarea></td>";
											echo "<td><input type='hidden' name='Email_Message_" . $Counter . "_ID' value='" . $Email_Message_Item['ID'] . "' /><a class='ewd-urp-delete-message' data-messagecounter='" . $Counter . "'>Delete</a></td>";
										echo "</tr>";
										$Counter++;
										$Max_ID = max($Max_ID, $Email_Message_Item['ID']);
									}
									$Max_ID++;
									echo "<tr><td colspan='3'><a class='ewd-urp-add-email ewd-urp-new-admin-add-button' data-nextcounter='" . $Counter . "' data-maxid='" . $Max_ID . "'>&plus; " . __('ADD', 'ultimate-reviews') . "</a></td></tr>";
								?>
							</table>
							<ul>
								<li>What should be in the messages sent to users?</li>
								<li>You can use [section]...[/section] and [footer]...[/footer] to split up the content of your email. You can also include a link button, like so: [button link='LINK_URL_GOES_HERE']BUTTON_TEXT[/button], and a link to review each individual item in an order with:[review-items link='LINK_URL_TO_SUBMIT_REVIEW_PAGE']</li>
								<!-- <li>You can also put [purchase-date] or [review-code] (if "Review Code" is one of the login options you have selected) into the message body or subject, to put in the date of the purchase or the review code for the purchase, respectively.</li> -->
								<li>You can also put [purchase-date] or into the message body or subject, to put in the date of the purchase or the review code for the purchase, respectively.</li>
								<li>Use the area below to send yourself a sample email.</li>
							</ul>
							</fieldset>
						</td>
					</tr>

					<tr>
						<th scope="row">Send Sample Email</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Send Sample Email</span></legend>
								<div class="ewd-urp-send-sample-email-labels">Select Email:</div>
								<select class='ewd-urp-email-selector'>
									<?php foreach ($Email_Messages_Array as $Email_Message_Item) { ?>
										<option value="<?php echo $Email_Message_Item['ID']; ?>"><?php echo $Email_Message_Item['Name']; ?></option>
									<?php } ?>
								</select><br/>
								<div class="ewd-urp-send-sample-email-labels">Email Address:</div>
								<input type='text' class='ewd-urp-test-email-address' />
								<p><button type='button' class='ewd-urp-send-test-email'>Send Sample Email</button></p>
								<p>Make sure that you click the "Save Changes" button below before sending the test message, to receive the most recent version of your email.</p>
							</fieldset>
						</td>
					</tr>
					<?php if ($URP_Full_Version != "Yes") { ?>
						<tr class="ewd-urp-premium-options-table-overlay">
							<th colspan="2">
								<div class="ewd-urp-unlock-premium">
									<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Reviews Premium">
									<p>Access this section by by upgrading to premium</p>
									<a href="https://www.etoilewebdesign.com/plugins/ultimate-reviews/#buy" class="ewd-urp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
								</div>
							</th>
						</tr>
					<?php } ?>
				</table>

				<br />

				<div class="ewd-urp-admin-section-heading ewd-urp-admin-conditional-wc-options<?php echo ($Replace_WooCommerce_Reviews != 'Yes' ? ' urp-hidden' : ''); ?>"><?php _e('Reminder Email Styling', 'ultimate-reviews'); ?></div>

				<div class="ewd-urp-admin-styling-section ewd-urp-admin-conditional-wc-options" <?php echo ($Replace_WooCommerce_Reviews != 'Yes' ? ' style="display: none;"' : ''); ?>>
					<div class="ewd-urp-admin-styling-subsection">
						<div class="ewd-urp-admin-styling-subsection-label"><?php _e('Email', 'ultimate-reviews'); ?></div>
						<div class="ewd-urp-admin-styling-subsection-content">
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Colors', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Background', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_email_reminder_background_color' value='<?php echo $urp_Email_Reminder_Background_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Inner Background', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_email_reminder_inner_color' value='<?php echo $urp_Email_Reminder_Inner_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Text', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_email_reminder_text_color' value='<?php echo $urp_Email_Reminder_Text_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="ewd-urp-admin-styling-subsection">
						<div class="ewd-urp-admin-styling-subsection-label"><?php _e('Button', 'ultimate-reviews'); ?></div>
						<div class="ewd-urp-admin-styling-subsection-content">
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Colors', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Background', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_email_reminder_button_background_color' value='<?php echo $urp_Email_Reminder_Button_Background_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Text', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_email_reminder_button_text_color' value='<?php echo $urp_Email_Reminder_Button_Text_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Hover Colors', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Background', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_email_reminder_button_background_hover_color' value='<?php echo $urp_Email_Reminder_Button_Background_Hover_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Text', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_email_reminder_button_text_hover_color' value='<?php echo $urp_Email_Reminder_Button_Text_Hover_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
								</div>
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

			<div id='Fields' class='urp-option-set <?php echo ( ($Display_Tab == 'Fields') ? '' : 'urp-hidden' ); ?>'>

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('Review Field Options', 'ultimate-reviews'); ?></div>

				<table class="form-table ewd-urp-premium-options-table <?php echo $URP_Full_Version; ?>">
					<!-- <tr>
						<th>Review Categories</th>
					</tr> -->
					<tr>
						<th class="ewd-urp-fields-page-th">In-Depth Reviews</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>In-Depth Reviews</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='indepth_reviews' value='Yes' <?php if($InDepth_Reviews == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='indepth_reviews' value='No' <?php if($InDepth_Reviews  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="indepth_reviews" <?php if($InDepth_Reviews == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should the reviews have multiple parts (set in the table below) rather than just an overall score?</p>
							</fieldset>
						</td>
					</tr>
					<?php if ($URP_Full_Version != "Yes") { ?>
						<tr class="ewd-urp-premium-options-table-overlay">
							<th colspan="2">
								<div class="ewd-urp-unlock-premium">
									<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Reviews Premium">
									<p>Access this section by by upgrading to premium</p>
									<a href="https://www.etoilewebdesign.com/plugins/ultimate-reviews/#buy" class="ewd-urp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
								</div>
							</th>
						</tr>
					<?php } ?>
				</table>

				<div class="ewd-urp-clear"></div>

				<div class="ewd-urp-choose-fields-explanation ewd-urp-admin-conditional-fields-options<?php echo ($InDepth_Reviews != 'Yes' ? ' urp-hidden' : ''); ?>">
					<ul>
						<li>Use the table below to add fields to your submit review form (requires that in-depth reviews be enabled).</li>
						<li>You can drag and drop the elements in the table to arrange the order in which they will appear.</li>
						<li>The "Review Line" field type will add a new in-depth category that visitors can rate and that will count towards the overall score (ex: Appearance, Value, etc.).</li>
						<li>For the "Radio" and "Checkbox" field types, supply a comma-separated list of your desired input values in the "Options" column.</li>
					</ul>
				</div>

				<br />

				<div class="ewd-urp-admin-section-heading ewd-urp-admin-conditional-fields-options<?php echo ($InDepth_Reviews != 'Yes' ? ' urp-hidden' : ''); ?>"><?php _e('In-Depth Review Fields', 'ultimate-reviews'); ?></div>

				<table class="form-table ewd-urp-premium-options-table ewd-urp-admin-conditional-fields-options"<?php echo ($InDepth_Reviews != 'Yes' ? ' style="display: none;"' : ''); ?>>
					<tr>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Review Categories</span></legend>
								<table id='ewd-urp-review-categories-table'>
									<thead>
										<tr>
											<th class="ewd-urp-admin-no-info-button"><?php _e('Field Name', 'ultimate-reviews'); ?></th>
											<th class="ewd-urp-admin-no-info-button"><?php _e('Required?', 'ultimate-reviews'); ?></th>
											<th class="ewd-urp-admin-no-info-button"><?php _e('Allow Explanation', 'ultimate-reviews'); ?></th>
											<th class="ewd-urp-admin-no-info-button"><?php _e('Type', 'ultimate-reviews'); ?></th>
											<th class="ewd-urp-admin-no-info-button"><?php _e('Filterable', 'ultimate-reviews'); ?></th>
											<th class="ewd-urp-admin-no-info-button"><?php _e('Options', 'ultimate-reviews'); ?></th>
											<th class="ewd-urp-admin-no-info-button"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$Counter = 0;
										if (!is_array($Review_Categories_Array)) {$Review_Categories_Array = array();}
										foreach ($Review_Categories_Array as $Review_Category_Item) {
											echo "<tr id='ewd-urp-review-category-row-" . $Counter . "' class='ui-sortable-handle'>";
											if ($Review_Category_Item['CategoryType'] != "Default") {echo "<td><input type='text' name='Review_Category_" . $Counter . "_Name' value='" . $Review_Category_Item['CategoryName'] . "'/></td>";}
											else {echo "<td><input type='hidden' name='Review_Category_" . $Counter . "_Name' value='" . $Review_Category_Item['CategoryName'] . "'/>" . $Review_Category_Item['CategoryName'] . "</td>";}
											if ($Review_Category_Item['CategoryName'] == "Review" or $Review_Category_Item['CategoryName'] == "Reviewer Email (if applicable)") {
												echo "<td><input type='hidden' name='Review_Category_" . $Counter . "_Required' value='Yes' />Yes</td>";
											}
											else { echo "<td><select name='Review_Category_" . $Counter . "_Required'/>"; ?>
												<option value='No' <?php if ($Review_Category_Item['CategoryRequired'] == "No") {echo "selected='selected'";} ?> >No</option>
												<option value='Yes' <?php if ($Review_Category_Item['CategoryRequired'] == "Yes") {echo "selected='selected'";} ?> >Yes</option>
												<?php echo "</select></td>";
											}
											if ($Review_Category_Item['CategoryType'] != "Default") {
												echo "<td><select name='Review_Category_" . $Counter . "_Explanation'>";
												echo "<option value='No' " . ($Review_Category_Item['ExplanationAllowed'] == 'No' ? 'selected' : '') . ">" . __("No", 'ultimate-reviews') . "</option>";
												echo "<option value='Yes' " . ($Review_Category_Item['ExplanationAllowed'] == 'Yes' ? 'selected' : '') . ">" . __("Yes", 'ultimate-reviews') . "</option>";
												echo "</td>";
											}
											else {echo "<td><input type='hidden' name='Review_Category_" . $Counter . "_Explanation' value='" . $Review_Category_Item['ExplanationAllowed'] ."'/>N/A</td>";}
											echo "<td><input type='hidden' name='Review_Category_" . $Counter . "_Type' value='" . ($Review_Category_Item['CategoryType'] == "" ? "ReviewItem" : $Review_Category_Item['CategoryType']) ."'/>" . ($Review_Category_Item['CategoryType'] == 'ReviewItem' ? 'Review Line' : $Review_Category_Item['CategoryType']) . "</td>";
											if ($Review_Category_Item['CategoryType'] != "Default" and $Review_Category_Item['CategoryType'] != "ReviewItem") {
												if ($URP_Full_Version == "Yes") {
													echo "<td><select name='Review_Category_" . $Counter . "_Filterable'>"; ?>
													<option value='No' <?php if ($Review_Category_Item['Filterable'] == "No") {echo "selected='selected'";} ?> >No</option>
													<option value='Yes' <?php if ($Review_Category_Item['Filterable'] == "Yes") {echo "selected='selected'";} ?> >Yes</option>
													<?php echo "</select></td>";
												}
												else {
													echo "<td><input type='hidden' name='Review_Category_" . $Counter . "_Filterable' value='No' />Premium required</td>";
												}
											}
											else {echo "<td>N/A</td>";}
											if (!isset($Review_Category_Item['Options'])) {
												 $Review_Category_Item['Options'] = '';
											}
											if ($Review_Category_Item['CategoryType'] == "Dropdown" or $Review_Category_Item['CategoryType'] == "Checkbox" or $Review_Category_Item['CategoryType'] == "Radio") {echo "<td><input type='text' name='Review_Category_" . $Counter . "_Options' value='" . $Review_Category_Item['Options'] . "' /></td>";}
											else {echo "<td></td>";}
											if ($Review_Category_Item['CategoryType'] != "Default") {echo "<td><input type='hidden' name='Review_Category_Order_" . $Counter . "' value='" . $Counter . "' /><a class='ewd-urp-delete-review-category' data-reviewid='" . $Counter . "'>Delete</a></td>";}
											else {echo "<td><input type='hidden' name='Review_Category_Order_" . $Counter . "' value='" . $Counter . "' /></td>";}
											echo "</tr>";
											$Counter++;
										}
										echo "</tbody>";
										echo "<tfoot><tr><td colspan='6'><a class='ewd-urp-add-review-category ewd-urp-new-admin-add-button' data-nextid='" . $Counter . "'>&plus; " . __('ADD', 'ultimate-reviews') . "</a></td></tr></tfoot>";
										?>
								</table>
								<!--
								<p>If in-depth reviews is set to 'Yes', what categories should the reviewers be grading? (ex: Appearance, Value, etc.)<br />
								You can require certain fields and, if you're using the premium version, add in text or textarea fields that don't count in the review score but can be used to add information to a review (ex: which location did you shop at? which associate served you? etc.).</p>
								-->
							</fieldset>
						</td>
					</tr>
					<?php if ($URP_Full_Version != "Yes") { ?>
						<tr class="ewd-urp-premium-options-table-overlay">
							<th colspan="2">
								<div class="ewd-urp-unlock-premium">
									<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Reviews Premium">
									<p>Access this section by by upgrading to premium</p>
									<a href="https://www.etoilewebdesign.com/plugins/ultimate-reviews/#buy" class="ewd-urp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
								</div>
							</th>
						</tr>
					<?php } ?>
				</table>
			</div>

			<div id='Order' class='urp-option-set <?php echo ( ($Display_Tab == 'Order') ? '' : 'urp-hidden' ); ?>'>

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('Order Options', 'ultimate-reviews'); ?></div>

				<table class="form-table ewd-urp-premium-options-table">
					<tr>
						<th scope="row">Group By Product</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Group By Product</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='group_by_product' value='Yes' <?php if($Group_By_Product == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='group_by_product' value='No' <?php if($Group_By_Product  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="group_by_product" <?php if($Group_By_Product == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>If the product_name attribute is left blank, should the reviews be grouped by the product they review?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Group By Product Direction</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Group By Product Direction</span></legend>
								<label title='ASC' class='ewd-urp-admin-input-container'><input type='radio' name='group_by_product_order' value='ASC' <?php if($Group_By_Product_Order == "ASC") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Ascending</span></label><br />
								<label title='DESC' class='ewd-urp-admin-input-container'><input type='radio' name='group_by_product_order' value='DESC' <?php if($Group_By_Product_Order  == "DESC") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Descending</span></label><br />
								<p>If products are grouped by name, should they be grouped in ascending or descending order?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Ordering Type</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Ordering Type</span></legend>
								<label title='Date' class='ewd-urp-admin-input-container'><input type='radio' name='ordering_type' value='Date' <?php if($Ordering_Type == "Date") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Submitted Date</span></label><br />
								<label title='Karma' class='ewd-urp-admin-input-container'><input type='radio' name='ordering_type' value='Karma' <?php if($Ordering_Type  == "Karma") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Review Karma (Not possible if grouping by product name)</span></label><br />
								<label title='Rating' class='ewd-urp-admin-input-container'><input type='radio' name='ordering_type' value='Rating' <?php if($Ordering_Type  == "Rating") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Rating (Not possible if grouping by product name)</span></label><br />
								<label title='Title' class='ewd-urp-admin-input-container'><input type='radio' name='ordering_type' value='Title' <?php if($Ordering_Type  == "Title") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Review Title</span></label><br />
								<p>What type of ordering should be used for the reviews?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Order Direction</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Order Direction</span></legend>
								<label title='ASC' class='ewd-urp-admin-input-container'><input type='radio' name='order_direction' value='ASC' <?php if($Order_Direction == "ASC") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Ascending</span></label><br />
								<label title='DESC' class='ewd-urp-admin-input-container'><input type='radio' name='order_direction' value='DESC' <?php if($Order_Direction  == "DESC") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Descending</span></label><br />
								<p>Should the ordering be ascending or descending?</p>
							</fieldset>
						</td>
					</tr>
					<?php if ($URP_Full_Version != "Yes") { ?>
						<tr class="ewd-urp-premium-options-table-overlay">
							<th colspan="2">
								<div class="ewd-urp-unlock-premium">
									<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Reviews Premium">
									<p>Access this section by by upgrading to premium</p>
									<a href="https://www.etoilewebdesign.com/plugins/ultimate-reviews/#buy" class="ewd-urp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
								</div>
							</th>
						</tr>
					<?php } ?>
				</table>
			</div>

			<div id='Labelling' class='urp-option-set <?php echo ( ($Display_Tab == 'Labelling') ? '' : 'urp-hidden' ); ?>'>
				<h2 id='label-order-options' class='urp-options-page-tab-title'>Labelling Options (Premium)</h2>

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('Review Content', 'ultimate-reviews'); ?></div>

				<div class="ewd-urp-admin-styling-section <?php echo $URP_Full_Version; ?>">
					<div class="ewd-urp-admin-styling-subsection">
						<p>Replace the default text on review pages</p>
						<div class="ewd-admin-labelling-section">
							<label>
								<p><?php _e("Posted", 'ultimate-reviews')?></p>
								<input type='text' name='posted_label' value='<?php echo $Posted_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
							<label>
								<p><?php _e("By", 'ultimate-reviews')?></p>
								<input type='text' name='by_label' value='<?php echo $By_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
							<label>
								<p><?php _e("On", 'ultimate-reviews')?></p>
								<input type='text' name='on_label' value='<?php echo $On_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
							<label>
								<p><?php _e("Score", 'ultimate-reviews')?></p>
								<input type='text' name='score_label' value='<?php echo $Score_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
							</label>
							<label>
								<p><?php _e("Explanation", 'ultimate-reviews')?></p>
								<input type='text' name='explanation_label' value='<?php echo $Explanation_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
							<label>
								<p><?php _e("Review for", 'ultimate-reviews')?></p>
								<input type='text' name='review_for_label' value='<?php echo $Review_For_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
							<label>
								<p><?php _e("'Categories' Label", 'ultimate-reviews')?></p>
								<input type='text' name='categories_label_label' value='<?php echo $Categories_Label_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
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

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('Filtering Area', 'ultimate-reviews'); ?></div>

				<div class="ewd-urp-admin-styling-section <?php echo $URP_Full_Version; ?>">
					<div class="ewd-urp-admin-styling-subsection">
						<p>Replace the default text in the filtering area</p>
						<div class="ewd-admin-labelling-section">
							<label>
								<p><?php _e("Filter (button)", 'ultimate-reviews')?></p>
								<input type='text' name='filter_button_label' value='<?php echo $Filter_Button_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
							<label>
								<p><?php _e("Product Name", 'ultimate-reviews')?></p>
								<input type='text' name='filter_product_name_label' value='<?php echo $Filter_Product_Name_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
							<label>
								<p><?php _e("All", 'ultimate-reviews')?></p>
								<input type='text' name='filter_all_label' value='<?php echo $Filter_All_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
							<label>
								<p><?php _e("Review Score", 'ultimate-reviews')?></p>
								<input type='text' name='filter_review_score_label' value='<?php echo $Filter_Review_Score_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
							<label>
								<p><?php _e("Review Author", 'ultimate-reviews')?></p>
								<input type='text' name='filter_review_author_label' value='<?php echo $Filter_Review_Author_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
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

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('Submit Reviews', 'ultimate-reviews'); ?></div>

				<div class="ewd-urp-admin-styling-section <?php echo $URP_Full_Version; ?>">
					<div class="ewd-urp-admin-styling-subsection">
						<p>Replace the default text on the submit review page</p>
						<div class="ewd-admin-labelling-section">
							<label>
								<p><?php _e("Product Name", 'ultimate-reviews')?></p>
								<input type='text' name='submit_product_label' value='<?php echo $Submit_Product_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
							<label>
								<p><?php _e("Review Author", 'ultimate-reviews')?></p>
								<input type='text' name='submit_author_label' value='<?php echo $Submit_Author_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
							<label>
								<p><?php _e("Author 'Comment'", 'ultimate-reviews')?></p>
								<input type='text' name='submit_author_comment_label' value='<?php echo $Submit_Author_Comment_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
							</label>
							<label>
								<p><?php _e("Review Title", 'ultimate-reviews')?></p>
								<input type='text' name='submit_title_label' value='<?php echo $Submit_Title_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
							<label>
								<p><?php _e("Title 'Comment'", 'ultimate-reviews')?></p>
								<input type='text' name='submit_title_comment_label' value='<?php echo $Submit_Title_Comment_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
							</label>
							<label>
								<p><?php _e("Overall Score", 'ultimate-reviews')?></p>
								<input type='text' name='submit_score_label' value='<?php echo $Submit_Score_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
							</label>
							<label>
								<p><?php _e("Review", 'ultimate-reviews')?></p>
								<input type='text' name='submit_review_label' value='<?php echo $Submit_Review_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
							</label>
							<label>
								<p><?php _e("Category 'Score'", 'ultimate-reviews')?></p>
								<input type='text' name='submit_cat_score_label' value='<?php echo $Submit_Cat_Score_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
							</label>
							<label>
								<p><?php _e("Category 'Explanation'", 'ultimate-reviews')?></p>
								<input type='text' name='submit_explanation_label' value='<?php echo $Submit_Explanation_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
							</label>
							<label>
								<p><?php _e("'Send Review' Button", 'ultimate-reviews')?></p>
								<input type='text' name='submit_button_label' value='<?php echo $Submit_Button_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
							</label>
							<label>
								<p><?php _e("Reviewer's Email Address", 'ultimate-reviews')?></p>
								<input type='text' name='submit_reviewer_email_address_label' value='<?php echo $Submit_Reviewer_Email_Address_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
							</label>
							<label>
								<p><?php _e("Email Address Instructions", 'ultimate-reviews')?></p>
								<input type='text' name='submit_reviewer_email_address_instructions_label' value='<?php echo $Submit_Reviewer_Email_Address_Instructions_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
							</label>
							<label>
								<p><?php _e("Image Number", 'ultimate-reviews')?></p>
								<input type='text' name='submit_image_number_label' value='<?php echo $Submit_Image_Number_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
							</label>
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

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('Reviews Summary', 'ultimate-reviews'); ?></div>

				<div class="ewd-urp-admin-styling-section <?php echo $URP_Full_Version; ?>">
					<div class="ewd-urp-admin-styling-subsection">
						<p>Replace the default text in the reviews summary area</p>
						<div class="ewd-admin-labelling-section">
							<label>
								<p><?php _e("Average Score", 'ultimate-reviews')?></p>
								<input type='text' name='summary_average_score_label' value='<?php echo $Summary_Average_Score_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
							<label>
								<p><?php _e("Ratings", 'ultimate-reviews')?></p>
								<input type='text' name='summary_ratings_label' value='<?php echo $Summary_Ratings_Label; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
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

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('Messages', 'ultimate-reviews'); ?></div>

				<div class="ewd-urp-admin-styling-section <?php echo $URP_Full_Version; ?>">
					<div class="ewd-urp-admin-styling-subsection">
						<p>Replace the default text in messages</p>
						<div class="ewd-admin-labelling-section">
							<label>
								<p><?php _e("Submit Success Message", 'ultimate-reviews')?></p>
								<input type='text' name='submit_success_message' class='ewd-urp-message-input' value='<?php echo $Submit_Success_Message; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
							<label>
								<p><?php _e("Submit Draft Add On Message", 'ultimate-reviews')?></p>
								<input type='text' name='submit_draft_message' class='ewd-urp-message-input' value='<?php echo $Submit_Draft_Message; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?>/>
							</label>
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


			<div id='Styling' class='urp-option-set <?php echo ( ($Display_Tab == 'Styling') ? '' : 'urp-hidden' ); ?>'>
				<h2 id='label-styling-options' class='urp-options-page-tab-title'>Styling Options</h2>

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('General', 'ultimate-reviews'); ?></div>

				<table class="form-table ewd-urp-premium-options-table">
					<tr>
						<th scope="row">Display Score</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Display Score</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='display_numerical_score' value='Yes' <?php if($Display_Numerical_Score == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='display_numerical_score' value='No' <?php if($Display_Numerical_Score  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="display_numerical_score" <?php if($Display_Numerical_Score == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Should review score be shown beside the review?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Reviews Skin Style</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Reviews Skin Style</span></legend>
								<label title='Basic' class='ewd-urp-admin-input-container'><input type='radio' name='reviews_skin' value='Basic' <?php if($Reviews_Skin == "Basic") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>None</span></label><br />
								<label title='SimpleStars' class='ewd-urp-admin-input-container'><input type='radio' name='reviews_skin' value='SimpleStars' <?php if($Reviews_Skin  == "SimpleStars") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Simple Stars</span></label><img class="review-skin-img" src="<?php echo plugins_url("ultimate-reviews/images/review_star.PNG"); ?>"> <br />
								<label title='Thumbs' class='ewd-urp-admin-input-container'><input type='radio' name='reviews_skin' value='Thumbs' <?php if($Reviews_Skin  == "Thumbs") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Thumbs</span></label><img class="review-skin-img" src="<?php echo plugins_url("ultimate-reviews/images/review_thumbs.PNG"); ?>"> <br />
								<label title='Hearts' class='ewd-urp-admin-input-container'><input type='radio' name='reviews_skin' value='Hearts' <?php if($Reviews_Skin  == "Hearts") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Hearts</span></label><img class="review-skin-img" src="<?php echo plugins_url("ultimate-reviews/images/review_hearts.PNG"); ?>"> <br />
								<label title='SimpleBar' class='ewd-urp-admin-input-container'><input type='radio' name='reviews_skin' value='SimpleBar' <?php if($Reviews_Skin  == "SimpleBar") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Simple Bar</span></label><img class="review-skin-img" src="<?php echo plugins_url("ultimate-reviews/images/review_bar.PNG"); ?>"> <br />
								<label title='ColorBar' class='ewd-urp-admin-input-container'><input type='radio' name='reviews_skin' value='ColorBar' <?php if($Reviews_Skin  == "ColorBar") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Color Bar</span></label><div class="review-skin-bar-div"><img class="review-skin-img-bar" src="<?php echo plugins_url("ultimate-reviews/images/review_color_bar_red.PNG"); ?>">
								<img class="review-skin-img-bar" src="<?php echo plugins_url("ultimate-reviews/images/review_color_bar_yellow.PNG"); ?>"><img class="review-skin-img-bar" src="<?php echo plugins_url("ultimate-reviews/images/review_color_bar_green.PNG"); ?>"></div> <br/>
								<label title='Circle' class='ewd-urp-admin-input-container'><input type='radio' name='reviews_skin' value='Circle' <?php if($Reviews_Skin  == "Circle") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Small Circle Graph</span></label><br />
								<label title='TextCircle' class='ewd-urp-admin-input-container'><input type='radio' name='reviews_skin' value='TextCircle' <?php if($Reviews_Skin  == "TextCircle") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Circle Graph with Score</span></label><br />
								<p>What styling skin should the reviews use?</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Review Group Separating Line</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>Review Group Separating Line</span></legend>
								<div class="ewd-urp-admin-hide-radios">
									<label title='Yes'><input type='radio' name='review_group_separating_line' value='Yes' <?php if($Review_Group_Separating_Line == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
									<label title='No'><input type='radio' name='review_group_separating_line' value='No' <?php if($Review_Group_Separating_Line  == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
								</div>
								<label class="ewd-urp-admin-switch">
									<input type="checkbox" class="ewd-urp-admin-option-toggle" data-inputname="review_group_separating_line" <?php if($Review_Group_Separating_Line == "Yes") {echo "checked='checked'";} ?>>
									<span class="ewd-urp-admin-switch-slider round"></span>
								</label>		
								<p>Add a separating line between each group of reviews (must have "Group By Product" enabled).</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">In-Depth Review Categories Layout</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>In-Depth Review Categories Layout</span></legend>
								<label title='Regular' class='ewd-urp-admin-input-container'><input type='radio' name='indepth_layout' value='Regular' <?php if($InDepth_Layout == "Regular") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Regular</span></label><br />
								<label title='Alternating' class='ewd-urp-admin-input-container'><input type='radio' name='indepth_layout' value='Alternating' <?php if($InDepth_Layout  == "Alternating") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Alternating Background Color</span></label><br />
								<p>Choose a layout for the display of the different categories when in-depth reviews are enabled.</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">"Read More" Style</th>
						<td>
							<fieldset><legend class="screen-reader-text"><span>"Read More" Style</span></legend>
								<label title='StandardLink' class='ewd-urp-admin-input-container'><input type='radio' name='read_more_style' value='StandardLink' <?php if($Reviews_Read_More_Style == "StandardLink") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Standard Link</span></label><br />
								<label title='Button' class='ewd-urp-admin-input-container'><input type='radio' name='read_more_style' value='Button' <?php if($Reviews_Read_More_Style  == "Button") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Button</span></label><br />
								<p>In the thumbnail review format, should the "read more" text be a standard link or a button?</p>
							</fieldset>
						</td>
					</tr>
					<?php if ($URP_Full_Version != "Yes") { ?>
						<tr class="ewd-urp-premium-options-table-overlay">
							<th colspan="2">
								<div class="ewd-urp-unlock-premium">
									<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Reviews Premium">
									<p>Access this section by by upgrading to premium</p>
									<a href="https://www.etoilewebdesign.com/plugins/ultimate-reviews/#buy" class="ewd-urp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
								</div>
							</th>
						</tr>
					<?php } ?>
				</table>

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('Premium Styling Options', 'ultimate-reviews'); ?></div>

				<div class="ewd-urp-admin-styling-section">
					<div class="ewd-urp-admin-styling-subsection">
						<div class="ewd-urp-admin-styling-subsection-label"><?php _e('Review Title', 'ultimate-reviews'); ?></div>
						<div class="ewd-urp-admin-styling-subsection-content">
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Font Color', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"></div>
										<input type='text' class='urp-spectrum' name='urp_review_title_font_color' value='<?php echo $urp_Review_Title_Font_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Font Family', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<input type='text' name='urp_review_title_font' class='ewd-urp-admin-font-size' placeholder='ex: Ariel,Times,etc' value='<?php echo $urp_Review_Title_Font; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Font Size', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<input type='text' name='urp_review_title_font_size' class='ewd-urp-admin-font-size' placeholder='ex: 10px, 1em,etc.' value='<?php echo $urp_Review_Title_Font_Size; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Margin', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<input type='text' name='urp_review_title_margin' class='ewd-urp-admin-font-size' placeholder='ex: 10px, 1em,etc.' value='<?php echo $urp_Review_Title_Margin; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Padding', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<input type='text' name='urp_review_title_padding' class='ewd-urp-admin-font-size' placeholder='ex: 10px, 1em,etc.' value='<?php echo $urp_Review_Title_Padding; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								</div>
							</div>
						</div>
					</div>
					<div class="ewd-urp-admin-styling-subsection">
						<div class="ewd-urp-admin-styling-subsection-label"><?php _e('Review Content', 'ultimate-reviews'); ?></div>
						<div class="ewd-urp-admin-styling-subsection-content">
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Font Color', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"></div>
										<input type='text' class='urp-spectrum' name='urp_review_content_font_color' value='<?php echo $urp_Review_Content_Font_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Font Family', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<input type='text' name='urp_review_content_font' class='ewd-urp-admin-font-size' placeholder='ex: Ariel,Times,etc' value='<?php echo $urp_Review_Content_Font; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Font Size', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<input type='text' name='urp_review_content_font_size' class='ewd-urp-admin-font-size' placeholder='ex: 10px, 1em,etc.' value='<?php echo $urp_Review_Content_Font_Size; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Margin', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<input type='text' name='urp_review_content_margin' class='ewd-urp-admin-font-size' placeholder='ex: 10px, 1em,etc.' value='<?php echo $urp_Review_Content_Margin; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Padding', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<input type='text' name='urp_review_content_padding' class='ewd-urp-admin-font-size' placeholder='ex: 10px, 1em,etc.' value='<?php echo $urp_Review_Content_Padding; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								</div>
							</div>
						</div>
					</div>
					<div class="ewd-urp-admin-styling-subsection">
						<div class="ewd-urp-admin-styling-subsection-label"><?php _e('Review Post Date', 'ultimate-reviews'); ?></div>
						<div class="ewd-urp-admin-styling-subsection-content">
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Font Color', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"></div>
										<input type='text' class='urp-spectrum' name='urp_review_postdate_font_color' value='<?php echo $urp_Review_Postdate_Font_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Font Family', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<input type='text' name='urp_review_postdate_font' class='ewd-urp-admin-font-size' placeholder='ex: Ariel,Times,etc' value='<?php echo $urp_Review_Postdate_Font; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Font Size', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<input type='text' name='urp_review_postdate_font_size' class='ewd-urp-admin-font-size' placeholder='ex: 10px, 1em,etc.' value='<?php echo $urp_Review_Postdate_Font_Size; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Margin', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<input type='text' name='urp_review_postdate_margin' class='ewd-urp-admin-font-size' placeholder='ex: 10px, 1em,etc.' value='<?php echo $urp_Review_Postdate_Margin; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Padding', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<input type='text' name='urp_review_postdate_padding' class='ewd-urp-admin-font-size' placeholder='ex: 10px, 1em,etc.' value='<?php echo $urp_Review_Postdate_Padding; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								</div>
							</div>
						</div>
					</div>
					<div class="ewd-urp-admin-styling-subsection">
						<div class="ewd-urp-admin-styling-subsection-label"><?php _e('Review Score', 'ultimate-reviews'); ?></div>
						<div class="ewd-urp-admin-styling-subsection-content">
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Font Color', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"></div>
										<input type='text' class='urp-spectrum' name='urp_review_score_font_color' value='<?php echo $urp_Review_Score_Font_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Font Family', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<input type='text' name='urp_review_score_font' class='ewd-urp-admin-font-size' placeholder='ex: Ariel,Times,etc' value='<?php echo $urp_Review_Score_Font; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Font Size', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<input type='text' name='urp_review_score_font_size' class='ewd-urp-admin-font-size' placeholder='ex: 10px, 1em,etc.' value='<?php echo $urp_Review_Score_Font_Size; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Margin', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<input type='text' name='urp_review_score_margin' class='ewd-urp-admin-font-size' placeholder='ex: 10px, 1em,etc.' value='<?php echo $urp_Review_Score_Margin; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Padding', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<input type='text' placeholder='ex: 10px, 1em,etc.' class='ewd-urp-admin-font-size' name='urp_review_score_padding' value='<?php echo $urp_Review_Score_Padding; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
								</div>
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

				<br />

				<div class="ewd-urp-admin-section-heading"><?php _e('Colors', 'ultimate-reviews'); ?></div>

				<div class="ewd-urp-admin-styling-section">
					<div class="ewd-urp-admin-styling-subsection">
						<div class="ewd-urp-admin-styling-subsection-label"><?php _e('Review Colors', 'ultimate-reviews'); ?></div>
						<div class="ewd-urp-admin-styling-subsection-content">
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Summary Statistics', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"></div>
										<input type='text' class='urp-spectrum' name='urp_summary_stats_color' value='<?php echo $urp_Summary_Stats_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Simple Bar', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"></div>
										<input type='text' class='urp-spectrum' name='urp_simple_bar_color' value='<?php echo $urp_Simple_Bar_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Color Bar', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('High', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_color_bar_high' value='<?php echo $urp_Color_Bar_High; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Medium', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_color_bar_medium' value='<?php echo $urp_Color_Bar_Medium; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Low', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_color_bar_low' value='<?php echo $urp_Color_Bar_Low; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Backgrounds', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Review Container', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_review_background_color' value='<?php echo $urp_Review_Background_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Review Header', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_review_header_background_color' value='<?php echo $urp_Review_Header_Background_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Review Content', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_review_content_background_color' value='<?php echo $urp_Review_Content_Background_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="ewd-urp-admin-styling-subsection">
						<div class="ewd-urp-admin-styling-subsection-label"><?php _e('Read More Button', 'ultimate-reviews'); ?></div>
						<div class="ewd-urp-admin-styling-subsection-content">
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Colors', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Background', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_read_more_button_background_color' value='<?php echo $urp_Read_More_Button_Background_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Text', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_read_more_button_text_color' value='<?php echo $urp_Read_More_Button_Text_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
								</div>
							</div>
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Hover Colors', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Background', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_read_more_button_hover_background_color' value='<?php echo $urp_Read_More_Button_Hover_Background_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Text', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_read_more_button_hover_text_color' value='<?php echo $urp_Read_More_Button_Hover_Text_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="ewd-urp-admin-styling-subsection">
						<div class="ewd-urp-admin-styling-subsection-label"><?php _e('Image Review Style', 'ultimate-reviews'); ?></div>
						<div class="ewd-urp-admin-styling-subsection-content">
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Background Color', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"></div>
										<input type='text' class='urp-spectrum' name='urp_image_style_background_color' value='<?php echo $urp_Image_Style_Background_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="ewd-urp-admin-styling-subsection">
						<div class="ewd-urp-admin-styling-subsection-label"><?php _e('Circle Graph', 'ultimate-reviews'); ?></div>
						<div class="ewd-urp-admin-styling-subsection-content">
							<div class="ewd-urp-admin-styling-subsection-content-each">
								<div class="ewd-urp-admin-styling-subsection-content-label"><?php _e('Colors', 'ultimate-reviews'); ?></div>
								<div class="ewd-urp-admin-styling-subsection-content-right">
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Background', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_circle_graph_background_color' value='<?php echo $urp_Circle_Graph_Background_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
									<div class="ewd-urp-admin-styling-subsection-content-color-picker">
										<div class="ewd-urp-admin-styling-subsection-content-color-picker-label"><?php _e('Fill', 'ultimate-reviews'); ?></div>
										<input type='text' class='urp-spectrum' name='urp_circle_graph_fill_color' value='<?php echo $urp_Circle_Graph_Fill_Color; ?>' <?php if ($URP_Full_Version != "Yes") {echo "disabled";} ?> />
									</div>
								</div>
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

			<p class="submit"><input type="submit" name="Options_Submit" id="submit" class="button button-primary" value="Save Changes"  /></p></form>

		</div>
	</div>

<?php
	$Custom_CSS = get_option("EWD_UFAQ_Custom_CSS");
	$FAQ_Toggle = get_option("EWD_UFAQ_Toggle");
	$FAQ_Category_Toggle = get_option("EWD_UFAQ_Category_Toggle");
	$FAQ_Category_Accordion = get_option("EWD_UFAQ_Category_Accordion");
	$Expand_Collapse_All = get_option("EWD_UFAQ_Expand_Collapse_All");
	$FAQ_Accordion = get_option("EWD_UFAQ_FAQ_Accordion");
	$Hide_Categories = get_option("EWD_UFAQ_Hide_Categories");
	$Hide_Tags = get_option("EWD_UFAQ_Hide_Tags");
	$Scroll_To_Top = get_option("EWD_UFAQ_Scroll_To_Top");
	$Display_All_Answers = get_option("EWD_UFAQ_Display_All_Answers");
	$Display_Author = get_option("EWD_UFAQ_Display_Author");
    $Display_Date = get_option("EWD_UFAQ_Display_Date");
    $Display_Back_To_Top = get_option("EWD_UFAQ_Display_Back_To_Top");
    $Include_Permalink = get_option("EWD_UFAQ_Include_Permalink");
	$Permalink_Type = get_option("EWD_UFAQ_Permalink_Type");
	$Show_TinyMCE = get_option("EWD_UFAQ_Show_TinyMCE");
	$Comments_On = get_option("EWD_UFAQ_Comments_On");
	$Access_Role = get_option("EWD_UFAQ_Access_Role");

	$Display_Style = get_option("EWD_UFAQ_Display_Style");
	$FAQ_Number_Of_Columns = get_option("EWD_UFAQ_FAQ_Number_Of_Columns");
	$Responsive_Columns = get_option("EWD_UFAQ_Responsive_Columns");
	$Color_Block_Shape = get_option("EWD_UFAQ_Color_Block_Shape");
	$FAQs_Per_Page = get_option("EWD_UFAQ_FAQs_Per_Page");
	$Page_Type = get_option("EWD_UFAQ_Page_Type");
	$FAQ_Ratings = get_option("EWD_UFAQ_FAQ_Ratings");
	$WooCommerce_FAQs = get_option("EWD_UFAQ_WooCommerce_FAQs");
	$Use_Product = get_option("EWD_UFAQ_Use_Product");
	$Reveal_Effect = get_option("EWD_UFAQ_Reveal_Effect");
	$Pretty_Permalinks = get_option("EWD_UFAQ_Pretty_Permalinks");
    $Allow_Proposed_Answer = get_option("EWD_UFAQ_Allow_Proposed_Answer");
    $Submit_Custom_Fields = get_option("EWD_UFAQ_Submit_Custom_Fields");
    $Submit_Question_Captcha = get_option("EWD_UFAQ_Submit_Question_Captcha");
    $Submitted_Default_Category = get_option("EWD_UFAQ_Submitted_Default_Category");
    $Admin_Question_Notification = get_option("EWD_UFAQ_Admin_Question_Notification");
    $Admin_Notification_Email = get_option("EWD_UFAQ_Admin_Notification_Email");
	$Submit_FAQ_Email = get_option("EWD_UFAQ_Submit_FAQ_Email");
	$FAQ_Auto_Complete_Titles = get_option("EWD_UFAQ_Auto_Complete_Titles");
	$Highlight_Search_Term = get_option("EWD_UFAQ_Highlight_Search_Term");
	$Slug_Base = get_option("EWD_UFAQ_Slug_Base");
	$Socialmedia_String = get_option("EWD_UFAQ_Social_Media");
    $Socialmedia = explode(",", $Socialmedia_String);
    $FAQ_Elements = get_option("EWD_UFAQ_FAQ_Elements");

	$Group_By_Category = get_option("EWD_UFAQ_Group_By_Category");
	$Group_By_Category_Count = get_option("EWD_UFAQ_Group_By_Category_Count");
	$Group_By_Order_By = get_option("EWD_UFAQ_Group_By_Order_By");
	$Group_By_Order = get_option("EWD_UFAQ_Group_By_Order");
	$Order_By_Setting = get_option("EWD_UFAQ_Order_By");
	$Order_Setting = get_option("EWD_UFAQ_Order");

	$FAQ_Fields_Array = get_option("EWD_UFAQ_FAQ_Fields");
	$Hide_Blank_Fields = get_option("EWD_UFAQ_Hide_Blank_Fields");

	$Posted_Label = get_option("EWD_UFAQ_Posted_Label");
	$By_Label = get_option("EWD_UFAQ_By_Label");
	$On_Label = get_option("EWD_UFAQ_On_Label");
	$Category_Label = get_option("EWD_UFAQ_Category_Label");
	$Tag_Label = get_option("EWD_UFAQ_Tag_Label");
	$Enter_Question_Label = get_option("EWD_UFAQ_Enter_Question_Label");
	$Search_Label = get_option("EWD_UFAQ_Search_Label");
	$Permalink_Label = get_option("EWD_UFAQ_Permalink_Label");
	$Back_To_Top_Label = get_option("EWD_UFAQ_Back_To_Top_Label");
	$WooCommerce_Tab_Label = get_option("EWD_UFAQ_WooCommerce_Tab_Label");
	$Share_FAQ_Label = get_option("EWD_UFAQ_Share_FAQ_Label");
	$Find_FAQ_Helpful_Label = get_option("EWD_UFAQ_Find_FAQ_Helpful_Label");
	$Search_Placeholder_Label = get_option("EWD_UFAQ_Search_Placeholder_Label");

	$Thank_You_Submit_Label = get_option("EWD_UFAQ_Thank_You_Submit_Label");
	$Submit_Question_Label = get_option("EWD_UFAQ_Submit_Question_Label");
	$Please_Fill_Form_Below_Label = get_option("EWD_UFAQ_Please_Fill_Form_Below_Label");
	$Send_Question_Label = get_option("EWD_UFAQ_Send_Question_Label");
	$Question_Title_Label = get_option("EWD_UFAQ_Question_Title_Label");
	$What_Question_Being_Answered_Label = get_option("EWD_UFAQ_What_Question_Being_Answered_Label");
	$Proposed_Answer_Label = get_option("EWD_UFAQ_Proposed_Answer_Label");
	$Review_Author_Label = get_option("EWD_UFAQ_Review_Author_Label");
	$What_Name_With_Review_Label = get_option("EWD_UFAQ_What_Name_With_Review_Label");
	$Retrieving_Results = get_option("EWD_UFAQ_Retrieving_Results");
	$No_Results_Found_Text = get_option("EWD_UFAQ_No_Results_Found_Text");

	$UFAQ_Styling_Default_Bg_Color = get_option("EWD_UFAQ_Styling_Default_Bg_Color");
	$UFAQ_Styling_Default_Font_Color = get_option("EWD_UFAQ_Styling_Default_Font_Color");
	$UFAQ_Styling_Default_Border_Size = get_option("EWD_UFAQ_Styling_Default_Border_Size");
	$UFAQ_Styling_Default_Border_Color = get_option("EWD_UFAQ_Styling_Default_Border_Color");
	$UFAQ_Styling_Default_Border_Radius = get_option("EWD_UFAQ_Styling_Default_Border_Radius");
	$UFAQ_Styling_Toggle_Symbol_Size = get_option("EWD_UFAQ_Styling_Toggle_Symbol_Size");
	$UFAQ_Styling_Block_Bg_Color = get_option("EWD_UFAQ_Styling_Block_Bg_Color");
	$UFAQ_Styling_Block_Font_Color = get_option("EWD_UFAQ_Styling_Block_Font_Color");
	$UFAQ_Styling_List_Font = get_option("EWD_UFAQ_Styling_List_Font");
	$UFAQ_Styling_List_Font_Size = get_option("EWD_UFAQ_Styling_List_Font_Size");
	$UFAQ_Styling_List_Font_Color = get_option("EWD_UFAQ_Styling_List_Font_Color");
	$UFAQ_Styling_List_Margin = get_option("EWD_UFAQ_Styling_List_Margin");
	$UFAQ_Styling_List_Padding = get_option("EWD_UFAQ_Styling_List_Padding");

	$UFAQ_Styling_Question_Font = get_option("EWD_UFAQ_Styling_Question_Font");
	$UFAQ_Styling_Question_Font_Size = get_option("EWD_UFAQ_Styling_Question_Font_Size");
	$UFAQ_Styling_Question_Font_Color = get_option("EWD_UFAQ_Styling_Question_Font_Color");
	$UFAQ_Styling_Question_Margin = get_option("EWD_UFAQ_Styling_Question_Margin");
	$UFAQ_Styling_Question_Padding = get_option("EWD_UFAQ_Styling_Question_Padding");
	$UFAQ_Styling_Question_Icon_Top_Margin = get_option("EWD_UFAQ_Styling_Question_Icon_Top_Margin");
	$UFAQ_Styling_Answer_Font = get_option("EWD_UFAQ_Styling_Answer_Font");
	$UFAQ_Styling_Answer_Font_Size = get_option("EWD_UFAQ_Styling_Answer_Font_Size");
	$UFAQ_Styling_Answer_Font_Color = get_option("EWD_UFAQ_Styling_Answer_Font_Color");
	$UFAQ_Styling_Answer_Margin = get_option("EWD_UFAQ_Styling_Answer_Margin");
	$UFAQ_Styling_Answer_Padding = get_option("EWD_UFAQ_Styling_Answer_Padding");
	$UFAQ_Styling_Postdate_Font = get_option("EWD_UFAQ_Styling_Postdate_Font");
	$UFAQ_Styling_Postdate_Font_Size = get_option("EWD_UFAQ_Styling_Postdate_Font_Size");
	$UFAQ_Styling_Postdate_Font_Color = get_option("EWD_UFAQ_Styling_Postdate_Font_Color");
	$UFAQ_Styling_Postdate_Margin = get_option("EWD_UFAQ_Styling_Postdate_Margin");
	$UFAQ_Styling_Postdate_Padding = get_option("EWD_UFAQ_Styling_Postdate_Padding");
	$UFAQ_Styling_Category_Heading_Font = get_option("EWD_UFAQ_Styling_Category_Heading_Font");
	$UFAQ_Styling_Category_Heading_Font_Size = get_option("EWD_UFAQ_Styling_Category_Heading_Font_Size");
	$UFAQ_Styling_Category_Heading_Font_Color = get_option("EWD_UFAQ_Styling_Category_Heading_Font_Color");
	$UFAQ_Styling_Category_Font = get_option("EWD_UFAQ_Styling_Category_Font");
	$UFAQ_Styling_Category_Font_Size = get_option("EWD_UFAQ_Styling_Category_Font_Size");
	$UFAQ_Styling_Category_Font_Color = get_option("EWD_UFAQ_Styling_Category_Font_Color");
	$UFAQ_Styling_Category_Margin = get_option("EWD_UFAQ_Styling_Category_Margin");
	$UFAQ_Styling_Category_Padding = get_option("EWD_UFAQ_Styling_Category_Padding");

	$UFAQ_Styling_Category_Heading_Type = get_option("EWD_UFAQ_Styling_Category_Heading_Type");
	$UFAQ_Styling_FAQ_Heading_Type = get_option("EWD_UFAQ_Styling_FAQ_Heading_Type");
	$Toggle_Symbol = get_option("EWD_UFAQ_Toggle_Symbol");

	if (isset($_POST['Display_Tab'])) {$Display_Tab = $_POST['Display_Tab'];}
	else {$Display_Tab = "";}
?>
<div class="wrap ufaq-options-page-tabbed">
	<div class="ufaq-options-submenu-div">
		<ul class="ufaq-options-submenu ufaq-options-page-tabbed-nav">
			<li><a id="Basic_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == '' or $Display_Tab == 'Basic') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Basic');">Basic</a></li>
			<li><a id="Premium_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Premium') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Premium');">Premium</a></li>
			<li><a id="Order_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Order') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Order');">Ordering</a></li>
			<li><a id="Fields_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Fields') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Fields');">Fields</a></li>
			<li><a id="Labelling_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Labelling') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Labelling');">Labelling</a></li>
			<li><a id="Styling_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Styling') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Styling');">Styling</a></li>
		</ul>
	</div>


<div class="ufaq-options-page-tabbed-content">

<form method="post" action="admin.php?page=EWD-UFAQ-Options&DisplayPage=Options&Action=EWD_UFAQ_UpdateOptions">
<?php wp_nonce_field( 'EWD_UFAQ_Save_Options', 'EWD_UFAQ_Save_Options_Nonce' );  ?>

<input type='hidden' name='Display_Tab' value='<?php echo $Display_Tab; ?>' />

	<div id='Basic' class='ufaq-option-set<?php echo ( ($Display_Tab == '' or $Display_Tab == 'Basic') ? '' : ' ufaq-hidden' ); ?>'>
	<h2 id='label-basic-options' class='ufaq-options-page-tab-title'>Basic Options</h2>
	<br />

	<div class="ewd-ufaq-shortcode-reminder">
		<?php _e('<strong>REMINDER:</strong> To display FAQs, place the <strong>[ultimate-faqs]</strong> shortcode on a page', 'ultimate-faqs'); ?>
	</div>

	<br />

	<div class="ewd-ufaq-admin-section-heading"><?php _e('General', 'ultimate-faqs'); ?></div>

	<table class="form-table">
	<tr>
	<th scope="row">Custom CSS</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Custom CSS</span></legend>
		<label title='Custom CSS'><textarea class='ewd-ufaq-textarea' name='custom_css'> <?php echo $Custom_CSS; ?></textarea></label><br />
		<p>You can add custom CSS styles for your FAQs in the box above.</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Scroll To Top</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Scroll To Top</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes' class='ewd-ufaq-admin-input-container'><input type='radio' name='scroll_to_top' value='Yes' <?php if($Scroll_To_Top == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span>Yes</span></label><br />
				<label title='No' class='ewd-ufaq-admin-input-container'><input type='radio' name='scroll_to_top' value='No' <?php if($Scroll_To_Top == "No") {echo "checked='checked'";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="scroll_to_top" <?php if($Scroll_To_Top == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should the browser scroll to the top of the FAQ when it's opened?</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Show Editor Helper</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Show Editor Helper</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes' class='ewd-ufaq-admin-input-container'><input type='radio' name='show_tinymce' value='Yes' <?php if($Show_TinyMCE == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span>Yes</span></label><br />
				<label title='No' class='ewd-ufaq-admin-input-container'><input type='radio' name='show_tinymce' value='No' <?php if($Show_TinyMCE == "No") {echo "checked='checked'";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="show_tinymce" <?php if($Show_TinyMCE == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should the shortcode builder be shown above the WordPress page/post editor, in the toolbar buttons?</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Turn On Comment Support</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Turn On Comment Support</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='comments_on' value='Yes' <?php if($Comments_On == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='comments_on' value='No' <?php if($Comments_On == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="comments_on" <?php if($Comments_On == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should comment support be turned on, so that if the "Allow Comments" checkbox is selected for a given FAQ, comments are shown in the FAQ list?</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Include Permalink</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Include Permalink</span></legend>
			<label title='No' class='ewd-ufaq-admin-input-container'><input type='radio' name='include_permalink' value='No' <?php if($Include_Permalink == "No") {echo "checked='checked'";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span>None</span></label><br />
			<label title='Text' class='ewd-ufaq-admin-input-container'><input type='radio' name='include_permalink' value='Text' <?php if($Include_Permalink == "Text") {echo "checked='checked'";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span>Just Text</span></label><br />
			<label title='Icon' class='ewd-ufaq-admin-input-container'><input type='radio' name='include_permalink' value='Icon' <?php if($Include_Permalink == "Icon") {echo "checked='checked'";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span>Just Icon</span></label><br />
			<label title='Yes' class='ewd-ufaq-admin-input-container'><input type='radio' name='include_permalink' value='Yes' <?php if($Include_Permalink == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span>Both Text and Icon</span></label><br />
			<p>Display permalink to each question? If so, text, icon or both?</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Permalink Destination</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Permalink Destination/span></legend>
		<label title='SamePage' class='ewd-ufaq-admin-input-container'><input type='radio' name='permalink_type' value='SamePage' <?php if($Permalink_Type == "SamePage") {echo "checked='checked'";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span>Main FAQ Page</span></label><br />
		<label title='IndividualPage' class='ewd-ufaq-admin-input-container'><input type='radio' name='permalink_type' value='IndividualPage' <?php if($Permalink_Type == "IndividualPage") {echo "checked='checked'";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span>Individual FAQ Page</span></label><br />
		<p>Should the permalink link to the main FAQ page or the individual FAQ page?</p>
		</fieldset>
	</td>
	</tr>
	<tr>
		<th scope="row"><?php _e("Set Access Role", 'ultimate-faqs')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span>Set Access Role</span></legend>
			<label title='Access Role'>
				<select name='access_role'>
					<option value="administrator"<?php if($Access_Role == "administrator") {echo " selected=selected";} ?>>Administrator</option>
					<option value="delete_others_pages"<?php if($Access_Role == "delete_others_pages") {echo " selected=selected";} ?>>Editor</option>
					<option value="delete_published_posts"<?php if($Access_Role == "delete_published_posts") {echo " selected=selected";} ?>>Author</option>
					<option value="delete_posts"<?php if($Access_Role == "edit_posts") {echo " selected=selected";} ?>>Contributor</option>
					<option value="read"<?php if($Access_Role == "read") {echo " selected=selected";} ?>>Subscriber</option>
				</select>
			</label>
			<p><?php _e("Which level of user should have access to FAQs, Settings, etc.?", 'ultimate-faqs')?></p>
			</fieldset>
		</td>
		</tr>
	</table>

	<br />

	<div class="ewd-ufaq-admin-section-heading"><?php _e('Functionality', 'ultimate-faqs'); ?></div>

	<table class="form-table">
	<tr>
	<th scope="row">FAQ Toggle</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>FAQ Toggle</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='faq_toggle' value='Yes' <?php if($FAQ_Toggle == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='faq_toggle' value='No' <?php if($FAQ_Toggle == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="faq_toggle" <?php if($FAQ_Toggle == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should the FAQs hide/open when they are clicked? </p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">FAQ Accordion</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>FAQ Accordion</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='faq_accordion' value='Yes' <?php if($FAQ_Accordion == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='faq_accordion' value='No' <?php if($FAQ_Accordion == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="faq_accordion" <?php if($FAQ_Accordion == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should the FAQs accordion? (Only one FAQ is open at a time, requires FAQ Toggle)</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">FAQ Category Toggle</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>FAQ Category Toggle</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='faq_category_toggle' value='Yes' <?php if($FAQ_Category_Toggle == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='faq_category_toggle' value='No' <?php if($FAQ_Category_Toggle == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="faq_category_toggle" <?php if($FAQ_Category_Toggle == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should the FAQ categories hide/open when they are clicked, if FAQs are being grouped by category ("Group FAQs by Category" in the "Ordering" area)? </p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">FAQ Category Accordion</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>FAQ Category Accordion</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='faq_category_accordion' value='Yes' <?php if($FAQ_Category_Accordion == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='faq_category_accordion' value='No' <?php if($FAQ_Category_Accordion == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="faq_category_accordion" <?php if($FAQ_Category_Accordion == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should it only be possible to open one FAQ category at a time, if FAQ categories are being toggled ("FAQ Category Toggle" must be set to "Yes" above)? </p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">FAQ Expand/Collapse All</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>FAQ Expand/Collapse All</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='expand_collapse_all' value='Yes' <?php if($Expand_Collapse_All == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='expand_collapse_all' value='No' <?php if($Expand_Collapse_All == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="expand_collapse_all" <?php if($Expand_Collapse_All == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should there be a control to open and close all FAQs simultaneously?</p>
		</fieldset>
	</td>
	</tr>
	</table>

	<br />

	<div class="ewd-ufaq-admin-section-heading"><?php _e('Display', 'ultimate-faqs'); ?></div>

	<table class="form-table">
	<tr>
	<th scope="row">Hide Categories</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Hide Categories</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='hide_categories' value='Yes' <?php if($Hide_Categories == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='hide_categories' value='No' <?php if($Hide_Categories == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="hide_categories" <?php if($Hide_Categories == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should the categories for each FAQ be hidden?</p>
		</fieldset>
	</td>
	</tr>

	<tr>
	<th scope="row">Hide Tags</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Hide Tags</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='hide_tags' value='Yes' <?php if($Hide_Tags == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='hide_tags' value='No' <?php if($Hide_Tags == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="hide_tags" <?php if($Hide_Tags == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should the tags for each FAQ be hidden?</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Display All Answers</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Display All Answers</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='display_all_answers' value='Yes' <?php if($Display_All_Answers == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='display_all_answers' value='No' <?php if($Display_All_Answers == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="display_all_answers" <?php if($Display_All_Answers == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should all answers be displayed when the page loads? (Careful if FAQ Accordion is on)</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Display Post Author</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Display Post Author</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='display_author' value='Yes' <?php if($Display_Author == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='display_author' value='No' <?php if($Display_Author == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="display_author" <?php if($Display_Author == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should the display name of the post's author be displayed beneath the FAQ title?</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Display Post Date</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Display Post Date</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='display_date' value='Yes' <?php if($Display_Date == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='display_date' value='No' <?php if($Display_Date == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="display_date" <?php if($Display_Date == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should the date the post was created be displayed beneath the FAQ title?</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Display 'Back to Top'</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Display 'Back to Top'</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='display_back_to_top' value='Yes' <?php if($Display_Back_To_Top == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='display_back_to_top' value='No' <?php if($Display_Back_To_Top == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="display_back_to_top" <?php if($Display_Back_To_Top == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should a link to return to the top of the page be added to each FAQ post?</p>
		</fieldset>
	</td>
	</tr>
	</table>
	</div>

	<div id='Premium' class='ufaq-option-set<?php echo ( $Display_Tab == 'Premium' ? '' : ' ufaq-hidden' ); ?>'>
	<h2 id='label-premium-options' class='ufaq-options-page-tab-title'>Premium Options</h2>

	<br />

	<div class="ewd-ufaq-admin-section-heading"><?php _e('Display', 'ultimate-faqs'); ?></div>

	<table class="form-table ewd-ufaq-premium-options-table">
	<tr>
	<th scope="row">FAQ Display Style</th>
	<td>
	<fieldset><legend class="screen-reader-text"><span>FAQ Display Style</span></legend>
	<label title='Default Style' class='ewd-ufaq-admin-input-container'><input type='radio' name='display_style' value='Default' <?php if($Display_Style == "Default") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-ufaq-admin-radio-button'></span> <span>Default</span></label><br />
	<label title='Block Style' class='ewd-ufaq-admin-input-container'><input type='radio' name='display_style' value='Block' <?php if($Display_Style == "Block") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-ufaq-admin-radio-button'></span> <span>Block</span></label><br />
	<label title='Border Block Style' class='ewd-ufaq-admin-input-container'><input type='radio' name='display_style' value='Border_Block' <?php if($Display_Style == "Border_Block") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-ufaq-admin-radio-button'></span> <span>Border Block</span></label><br />
	<label title='Contemporary Style' class='ewd-ufaq-admin-input-container'><input type='radio' name='display_style' value='Contemporary' <?php if($Display_Style == "Contemporary") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-ufaq-admin-radio-button'></span> <span>Contemporary</span></label><br />
	<label title='List Style' class='ewd-ufaq-admin-input-container'><input type='radio' name='display_style' value='List' <?php if($Display_Style == "List") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-ufaq-admin-radio-button'></span> <span>List</span></label><br />
	<label title='Minimalist Style' class='ewd-ufaq-admin-input-container'><input type='radio' name='display_style' value='Minimalist' <?php if($Display_Style == "Minimalist") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-ufaq-admin-radio-button'></span> <span>Minimalist</span></label><br />
	<p>Which theme should be used to display the FAQ's?</p>
	</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Number of Columns</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Number of Columns</span></legend>
			<label title='One' class='ewd-ufaq-admin-input-container'><input type='radio' name='faq_number_of_columns' value='One' <?php if($FAQ_Number_Of_Columns == "One") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span><?php _e('One', 'ultimate-faqs'); ?></span></label><br />
			<label title='Two' class='ewd-ufaq-admin-input-container'><input type='radio' name='faq_number_of_columns' value='Two' <?php if($FAQ_Number_Of_Columns == "Two") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span><?php _e('Two', 'ultimate-faqs'); ?></span></label><br />
			<label title='Three' class='ewd-ufaq-admin-input-container'><input type='radio' name='faq_number_of_columns' value='Three' <?php if($FAQ_Number_Of_Columns == "Three") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span><?php _e('Three', 'ultimate-faqs'); ?></span></label><br />
			<label title='Four' class='ewd-ufaq-admin-input-container'><input type='radio' name='faq_number_of_columns' value='Four' <?php if($FAQ_Number_Of_Columns == "Four") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span><?php _e('Four', 'ultimate-faqs'); ?></span></label><br />
			<p>In how many columns would you like your FAQs to display?</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Responsive Columns</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Responsive Columns</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='responsive_columns' value='Yes' <?php if($Responsive_Columns == "Yes") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='responsive_columns' value='No' <?php if($Responsive_Columns == "No") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="responsive_columns" <?php if($Responsive_Columns == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>If you have more than one column, would you like them to be responsive? If this option is disabled, the number of columns will remain the same on all screen sizes.</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Reveal Effect</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Reveal Effect</span></legend>
			<label title='Reveal Effect'>
				<select name="reveal_effect" <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> >
			  		<option value="none" <?php if($Reveal_Effect == "none") {echo "selected=selected";} ?> >None</option>
					<option value="blind" <?php if($Reveal_Effect == "blind") {echo "selected=selected";} ?> >Blind</option>
			  		<option value="bounce" <?php if($Reveal_Effect == "bounce") {echo "selected=selected";} ?> >Bounce</option>
			  		<option value="clip" <?php if($Reveal_Effect == "clip") {echo "selected=selected";} ?> >Clip</option>
			  		<option value="drop" <?php if($Reveal_Effect == "drop") {echo "selected=selected";} ?> >Drop</option>
			  		<option value="explode" <?php if($Reveal_Effect == "explode") {echo "selected=selected";} ?> >Explode</option>
			  		<option value="fade" <?php if($Reveal_Effect == "fade") {echo "selected=selected";} ?> >Fade</option>
			  		<option value="fold" <?php if($Reveal_Effect == "fold") {echo "selected=selected";} ?> >Fold</option>
			  		<option value="highlight" <?php if($Reveal_Effect == "highlight") {echo "selected=selected";} ?> >Highlight</option>
			  		<option value="puff" <?php if($Reveal_Effect == "puff") {echo "selected=selected";} ?> >Puff</option>
			  		<option value="pulsate" <?php if($Reveal_Effect == "pulsate") {echo "selected=selected";} ?> >Pulsate</option>
			  		<option value="shake" <?php if($Reveal_Effect == "shake") {echo "selected=selected";} ?> >Shake</option>
			  		<option value="size" <?php if($Reveal_Effect == "size") {echo "selected=selected";} ?> >Size</option>
			  		<option value="slide" <?php if($Reveal_Effect == "slide") {echo "selected=selected";} ?> >Slide</option>
				</select>
			</label>	
			<p>How should FAQ's be displayed when their titles are clicked?</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">FAQs Per Page</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>FAQs Per Page</span></legend>
		<input type='text' name='faqs_per_page' value='<?php echo $FAQs_Per_Page; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> size='60'/>
		<p>How many FAQs should be displayed on each page? (Leave blank to display all FAQs)</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">FAQ Page Type</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>FAQ Page Type</span></legend>
		<label title='Distinct' class='ewd-ufaq-admin-input-container'><input type='radio' name='page_type' value='Distinct' <?php if($Page_Type == "Distinct") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-ufaq-admin-radio-button'></span> <span>Distinct Pages</span></label><br />
		<label title='Load More' class='ewd-ufaq-admin-input-container'><input type='radio' name='page_type' value='Load_More' <?php if($Page_Type == "Load_More") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-ufaq-admin-radio-button'></span> <span>Load More Button</span></label><br />
		<label title='Infinite Scroll' class='ewd-ufaq-admin-input-container'><input type='radio' name='page_type' value='Infinite_Scroll' <?php if($Page_Type == "Infinite_Scroll") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-ufaq-admin-radio-button'></span> <span>Infinite Scroll</span></label><br />
		<p>If FAQs are in pages, how should pages load?</p>
		</fieldset>
	</td>
	</tr>
	<?php if ($UFAQ_Full_Version != "Yes") { ?>
		<tr class="ewd-ufaq-premium-options-table-overlay">
			<th colspan="2">
				<div class="ewd-ufaq-unlock-premium">
					<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate FAQ Premium">
					<p>Access this section by by upgrading to premium</p>
					<a href="https://www.etoilewebdesign.com/license-payment/?Selected=UFAQ&Quantity=1" class="ewd-ufaq-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
				</div>
			</th>
		</tr>
	<?php } ?>
	</table>

	<br />

	<div class="ewd-ufaq-admin-section-heading"><?php _e('General', 'ultimate-faqs'); ?></div>

	<table class="form-table ewd-ufaq-premium-options-table">
	<tr>
	<th scope="row">FAQ Ratings</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>FAQ Ratings</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='faq_ratings' value='Yes' <?php if($FAQ_Ratings == "Yes") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='faq_ratings' value='No' <?php if($FAQ_Ratings == "No") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="faq_ratings" <?php if($FAQ_Ratings == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should visitors be able to up or down vote FAQs to let others know if they found them helpful?</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Pretty Permalinks</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Pretty Permalinks</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='pretty_permalinks' value='Yes' <?php if($Pretty_Permalinks == "Yes") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='pretty_permalinks' value='No' <?php if($Pretty_Permalinks == "No") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="pretty_permalinks" <?php if($Pretty_Permalinks == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should an SEO friendly permalink structure be used for the link to the FAQ?</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">FAQ Auto Complete Titles</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>FAQ Auto Complete Titles</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='faq_auto_complete_titles' value='Yes' <?php if($FAQ_Auto_Complete_Titles == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='faq_auto_complete_titles' value='No' <?php if($FAQ_Auto_Complete_Titles == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="faq_auto_complete_titles" <?php if($FAQ_Auto_Complete_Titles == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should the FAQ Titles auto complete when using the FAQ search shortcode?</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">FAQ Slug Base</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>FAQ Slug Base</span></legend>
			<label><input type='text' name='slug_base' value='<?php echo $Slug_Base; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> size='60'/></label>
			<p>This option can be used to change the slug base for all FAQ posts. Be sure to go to "Settings" -> "Permalinks" in the WordPress sidebar and hit "Save Changes" to avoid 404 errors.</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Social Media Option</th>
	<td>
	    <fieldset><legend class="screen-reader-text"><span>Social Media Option</span></legend>
	        <label title='Facebook' class='ewd-ufaq-admin-input-container'><input type='checkbox' name='Socialmedia[]' value='Facebook' <?php if(in_array("Facebook", $Socialmedia)) {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-checkbox'></span> <span>Facebook</span></label><br />
	        <label title='Name' class='ewd-ufaq-admin-input-container'><input type='checkbox' name='Socialmedia[]' value='Google'  <?php if(in_array("Google", $Socialmedia)) {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-checkbox'></span> <span>Google</span></label><br />
	        <label title='Twitter' class='ewd-ufaq-admin-input-container'><input type='checkbox' name='Socialmedia[]' value='Twitter' <?php if(in_array("Twitter", $Socialmedia)) {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-checkbox'></span> <span>Twitter</span></label><br />
	        <label title='Linkedin' class='ewd-ufaq-admin-input-container'><input type='checkbox' name='Socialmedia[]' value='Linkedin' <?php if(in_array("Linkedin", $Socialmedia)) {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-checkbox'></span> <span>Linkedin</span></label><br />
	        <label title='Pinterest' class='ewd-ufaq-admin-input-container'><input type='checkbox' name='Socialmedia[]' value='Pinterest' <?php if(in_array("Pinterest", $Socialmedia)) {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-checkbox'></span> <span>Pinterest</span></label><br />
	        <label title='Email' class='ewd-ufaq-admin-input-container'><input type='checkbox' name='Socialmedia[]' value='Email' <?php if(in_array("Email", $Socialmedia)) {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-checkbox'></span> <span>Email</span></label><br />
	        <div style='display:none;'><label title='Blank'><input type='checkbox' name='Socialmedia[]' value='Blank' checked='checked'/> <span>Blank</span></label></div>
	    </fieldset>
	</td>
	</tr>
	<?php if ($UFAQ_Full_Version != "Yes") { ?>
		<tr class="ewd-ufaq-premium-options-table-overlay">
			<th colspan="2">
				<div class="ewd-ufaq-unlock-premium">
					<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate FAQ Premium">
					<p>Access this section by by upgrading to premium</p>
					<a href="https://www.etoilewebdesign.com/license-payment/?Selected=UFAQ&Quantity=1" class="ewd-ufaq-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
				</div>
			</th>
		</tr>
	<?php } ?>
	</table>

	<br />

	<div class="ewd-ufaq-admin-section-heading"><?php _e('WooCommerce', 'ultimate-faqs'); ?></div>

	<table class="form-table ewd-ufaq-premium-options-table <?php echo $UFAQ_Full_Version; ?>">
	<tr>
	<th scope="row">WooCommerce FAQs</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>WooCommerce FAQs</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='woocommerce_faqs' value='Yes' <?php if($WooCommerce_FAQs == "Yes") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='woocommerce_faqs' value='No' <?php if($WooCommerce_FAQs == "No") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="woocommerce_faqs" <?php if($WooCommerce_FAQs == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should FAQs for a given product be displayed as an extra tab on the WooCommerce product page?<br/> For this to work correctly, an FAQ category needs to be created with the same name as a given WooCommerce product.</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Use WooCommerce Product Object</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Use WooCommerce Product Object</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='use_product' value='Yes' <?php if($Use_Product == "Yes") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='use_product' value='No' <?php if($Use_Product == "No") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="use_product" <?php if($Use_Product == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should the FAQ tab be set up using the WooCommerce product object, as in the WC documentation, or just using the ID of the page?</p>
		</fieldset>
	</td>
	</tr>
	<?php if ($UFAQ_Full_Version != "Yes") { ?>
		<tr class="ewd-ufaq-premium-options-table-overlay">
			<th colspan="2">
				<div class="ewd-ufaq-unlock-premium">
					<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate FAQ Premium">
					<p>Access this section by by upgrading to premium</p>
					<a href="https://www.etoilewebdesign.com/license-payment/?Selected=UFAQ&Quantity=1" class="ewd-ufaq-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
				</div>
			</th>
		</tr>
	<?php } ?>
	</table>

	<br />

	<div class="ewd-ufaq-admin-section-heading"><?php _e('Submit FAQ', 'ultimate-faqs'); ?></div>

	<table class="form-table ewd-ufaq-premium-options-table">
	<tr>
	<th scope="row">Allow Proposed Answer</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Allow Proposed Answer</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='allow_proposed_answer' value='Yes' <?php if($Allow_Proposed_Answer == "Yes") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='allow_proposed_answer' value='No' <?php if($Allow_Proposed_Answer == "No") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="allow_proposed_answer" <?php if($Allow_Proposed_Answer == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>When using the user-submitted question shortcode, should users be able to propose an answer to the question they're submitting?</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Submit Custom Fields</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Submit Custom Fields</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='submit_custom_fields' value='Yes' <?php if($Submit_Custom_Fields == "Yes") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='submit_custom_fields' value='No' <?php if($Submit_Custom_Fields == "No") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="submit_custom_fields" <?php if($Submit_Custom_Fields == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>When using the user-submitted question shortcode, should users be able to fill in custom fields for the question they're submitting? File type custom fields cannot be submitted for security reasons.</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Submit Question Captcha</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Submit Question Captcha</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='submit_question_captcha' value='Yes' <?php if($Submit_Question_Captcha == "Yes") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='submit_question_captcha' value='No' <?php if($Submit_Question_Captcha == "No") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="submit_question_captcha" <?php if($Submit_Question_Captcha == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>When using the user-submitted question shortcode, should a captcha field be added to the form to reduce the volume of spam FAQs?</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Default Category</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Default Category</span></legend>
			<label title='Default Category'>
				<select name="submitted_default_category" <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> >
			  		<option value="none" <?php if($Submitted_Default_Category == "none") {echo "selected=selected";} ?> >None</option>
					<?php
					$faqCategories = get_terms([
						'taxonomy' => 'ufaq-category',
						'hide_empty' => false,
					]);
					foreach($faqCategories as $faqCategory){
						?>
						<option value="<?php echo $faqCategory->slug; ?>" <?php if($Submitted_Default_Category == $faqCategory->slug) {echo "selected=selected";} ?> ><?php echo $faqCategory->name; ?></option>
						<?php
					}
					?>
				</select>
			</label>	
			<p>Which category should submitted questions default to?</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Admin Question Notification</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Admin Question Notification</span></legend>
			<div class="ewd-ufaq-admin-hide-radios">
				<label title='Yes'><input type='radio' name='admin_question_notification' value='Yes' <?php if($Admin_Question_Notification == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
				<label title='No'><input type='radio' name='admin_question_notification' value='No' <?php if($Admin_Question_Notification == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
			</div>
			<label class="ewd-ufaq-admin-switch">
				<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="admin_question_notification" <?php if($Admin_Question_Notification == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-ufaq-admin-switch-slider round"></span>
			</label>		
			<p>Should an email be sent to the site administrator when a question is submitted?</p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row">Admin Notification Email</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span>Admin Notification Email</span></legend>
			<label><input type='text' name='admin_notification_email' value='<?php echo $Admin_Notification_Email; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> size='60'/></label>
			<p>What email address should the notifications be sent to if "Admin Question Notifications" are set to "Yes" above? If blank, the default WordPress admin email will be used.</p>
		</fieldset>
	</td>
	</tr>
	<tr>
		<th scope="row">FAQ Submitted Thank You E-mail</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span>FAQ Submitted Thank You E-mail</span></legend>
				<?php 
					$plugin = "ultimate-wp-mail/Main.php";
					$UWPM_Installed = is_plugin_active($plugin);
					if ($UWPM_Installed) {
						$UWPM_Emails = get_posts(array('post_type' => 'uwpm_mail_template', 'posts_per_page' => -1));
						echo "<label>";
						echo "<select name='submit_faq_email'>";
						echo "<option value='0'>" . __("None", 'ultimate-faqs') . "</option>";
						foreach ($UWPM_Emails as $Email) {
							echo "<option value='" . $Email->ID . "' " . ($Submit_FAQ_Email == $Email->ID ? 'selected' : '') . ">" . $Email->post_title . "</option>";
						}
						echo "</select>";
						echo "</label>";
						echo "<p>What email should be sent out when an FAQ is submitted?</p>";
					}
					else {
						echo "<p>You can use the <a href='https://wordpress.org/plugins/ultimate-wp-mail/' target='_blank'>Ultimate WP Mail plugin</a> to create a custom email that is sent whenever an FAQ is submitted.</p>";
					}
				?>
			</fieldset>
		</td>
	</tr>
	<?php if ($UFAQ_Full_Version != "Yes") { ?>
		<tr class="ewd-ufaq-premium-options-table-overlay">
			<th colspan="2">
				<div class="ewd-ufaq-unlock-premium">
					<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate FAQ Premium">
					<p>Access this section by by upgrading to premium</p>
					<a href="https://www.etoilewebdesign.com/license-payment/?Selected=UFAQ&Quantity=1" class="ewd-ufaq-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
				</div>
			</th>
		</tr>
	<?php } ?>
	</table>

	<br />

	<div class="ewd-ufaq-admin-section-heading"><?php _e('FAQ Elements Order (if toggled on)', 'ultimate-faqs'); ?></div>

	<table class='ewd-ufaq-elements-table ewd-ufaq-premium-options-table'>
		<!-- <thead>
			<tr>
				<th><?php _e("Element (if toggled on)", 'ultimate-faqs'); ?></th>
			</tr>
		</thead> -->
		<tbody>
			<?php foreach ($FAQ_Elements as $Order => $FAQ_Element) { ?>
				<tr class='ewd-ufaq-element'>
					<td><input type='hidden' name='Element_<?php echo $Order; ?>' value='<?php echo $FAQ_Element; ?>' /><span class='ewd-ufaq-element-name'><?php echo $FAQ_Element; ?></span></td>
				</tr>
			<?php } ?>
		</tbody>
		<?php if ($UFAQ_Full_Version != "Yes") { ?>
			<tr class="ewd-ufaq-premium-options-table-overlay">
				<th colspan="2">
					<div class="ewd-ufaq-unlock-premium">
						<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate FAQ Premium">
						<p>Access this section by by upgrading to premium</p>
						<a href="https://www.etoilewebdesign.com/license-payment/?Selected=UFAQ&Quantity=1" class="ewd-ufaq-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					</div>
				</th>
			</tr>
		<?php } ?>
	</table>
	</div>

	<div id='Order' class='ufaq-option-set<?php echo ( $Display_Tab == 'Order' ? '' : ' ufaq-hidden' ); ?>'>
		<h2 id='label-order-options' class='ufaq-options-page-tab-title'>Ordering Options</h2>

		<br />

		<div class="ewd-ufaq-admin-section-heading"><?php _e('Settings', 'ultimate-faqs'); ?></div>

		<table class="form-table">
		<tr>
		<th scope="row">Group FAQs by Category</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span>Group FAQs by Category</span></legend>
				<div class="ewd-ufaq-admin-hide-radios">
					<label title='Yes'><input type='radio' name='group_by_category' value='Yes' <?php if($Group_By_Category == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
					<label title='No'><input type='radio' name='group_by_category' value='No' <?php if($Group_By_Category == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
				</div>
				<label class="ewd-ufaq-admin-switch">
					<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="group_by_category" <?php if($Group_By_Category == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-ufaq-admin-switch-slider round"></span>
				</label>		
				<p>Should FAQs be grouped by category, or should all categories be mixed together?</p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row">Display FAQ Category Count</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span>Display FAQ Category Count</span></legend>
				<div class="ewd-ufaq-admin-hide-radios">
					<label title='Yes'><input type='radio' name='group_by_category_count' value='Yes' <?php if($Group_By_Category_Count == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
					<label title='No'><input type='radio' name='group_by_category_count' value='No' <?php if($Group_By_Category_Count == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
				</div>
				<label class="ewd-ufaq-admin-switch">
					<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="group_by_category_count" <?php if($Group_By_Category_Count == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-ufaq-admin-switch-slider round"></span>
				</label>		
				<p>If FAQs are grouped by category, should the number of FAQs in a category be displayed beside the category name?</p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row">Sort Categories</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span>Sort Categories</span></legend>
			<label title='Group By Order By'></label>

			<select name="group_by_order_by" <?php if ($UFAQ_Full_Version != "Yes"  and get_option("EWD_UFAQ_Install_Version") < 1.6) {echo "disabled";} ?> >
		  		<option value="name" <?php if($Group_By_Order_By == "name") {echo "selected=selected";} ?> >Name</option>
					<option value="count" <?php if($Group_By_Order_By == "count") {echo "selected=selected";} ?> >FAQ Count</option>
		  		<option value="slug" <?php if($Group_By_Order_By == "slug") {echo "selected=selected";} ?> >Slug</option>
			</select>

			<p>How should FAQ categories be ordered? (Only used if "Group FAQs by Category" above is set to "Yes"). Please note, this is a premium feature.</p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row">Sort Categories Ordering</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span>Sort Categories Ordering</span></legend>
				<label title='Ascending' class='ewd-ufaq-admin-input-container'><input type='radio' name='group_by_order' value='ASC' <?php if($Group_By_Order == "ASC") {echo "checked='checked'";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span>Ascending</span></label><br />
				<label title='Descending' class='ewd-ufaq-admin-input-container'><input type='radio' name='group_by_order' value='DESC' <?php if($Group_By_Order == "DESC") {echo "checked='checked'";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span>Descending</span></label><br />
				<p>How should FAQ categories be ordered? (Only used if "Group FAQs by Category" above is set to "Yes")</p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row">FAQ Ordering</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span>FAQ Ordering</span></legend>
			<label title='FAQ Ordering'></label>

			<select name="order_by_setting" <?php if ($UFAQ_Full_Version != "Yes" and get_option("EWD_UFAQ_Install_Version") < 1.6) {echo "disabled";} ?> >
		  		<option value="date" <?php if($Order_By_Setting == "date") {echo "selected=selected";} ?> >Created Date</option>
				<option value="title" <?php if($Order_By_Setting == "title") {echo "selected=selected";} ?> >Title</option>
		  		<option value="modified" <?php if($Order_By_Setting == "modified") {echo "selected=selected";} ?> >Modified Date</option>
		  		<option value="set_order" <?php if($Order_By_Setting == "set_order") {echo "selected=selected";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> >Selected Order (using Order table)</option>
			</select>

			<p>How should individual FAQs be ordered? <?php if (get_option("EWD_UFAQ_Install_Version") >= 1.6) {?> Please note, this is a premium feature. <?php } ?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row">FAQ Order Setting</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span>Sort Categories Ordering</span></legend>
				<label title='Yes' class='ewd-ufaq-admin-input-container'><input type='radio' name='order_setting' value='ASC' <?php if($Order_Setting == "ASC") {echo "checked='checked'";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span>Ascending</span></label><br />
				<label title='No' class='ewd-ufaq-admin-input-container'><input type='radio' name='order_setting' value='DESC' <?php if($Order_Setting == "DESC") {echo "checked='checked'";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span>Descending</span></label><br />
				<p>Should FAQ be ascending or descending order, based on the ordering criteria above?</p>
			</fieldset>
		</td>
		</tr>
		</table>

		<br />

		<div class="ewd-ufaq-admin-section-heading"><?php _e('Order Table', 'ultimate-faqs'); ?></div>

		<div class="ewd-ufaq-admin-styling-section">
			<div class="ewd-ufaq-admin-styling-subsection">

				<div class='ufaq-order-table'>
				<p><?php _e("Drag and drop the posts below to reorder them, if you have 'Selected Order' set for the 'FAQ Ordering' option", 'ultimate-faqs'); ?></p>
				<!--<div id="col-right">
					<div class="col-wrap">
					<div id="add-page" class="postbox metabox-holder" >
					<div class="inside">
					<div id="posttype-page" class="posttypediv">-->
					<div id="tabs-panel-posttype-page-most-recent" class="tabs-panel tabs-panel-active">

						<table class="wp-list-table widefat tags sorttable ewd-ufaq-list">
						    <thead>
						    	<tr>
						            <th><?php _e("Question", 'ultimate-faqs') ?></th>
						            <th><?php _e("Views", 'ultimate-faqs') ?></th>
						            <th><?php _e("Categories", 'ultimate-faqs') ?></th>
						            <th><?php _e("Tags", 'ultimate-faqs') ?></th>
						    	</tr>
						    </thead>
						    <tbody>
						    <?php
						    $params = array(
						    	'post_type' => 'ufaq',
						    	'posts_per_page' => -1,
						    	'meta_key' => 'ufaq_order',
						    	'orderby' => 'meta_value_num',
						    	'order' => 'ASC'
						    );
						    $FAQs = get_posts($params);
							if (empty($FAQs)) { echo "<div class='ewd-ufaq-row list-item'><p>No FAQs have been created<p/></div>"; }
							else {
						    	foreach ($FAQs as $FAQ) {
						    		$FAQ_Views = get_post_meta($FAQ->ID, 'ufaq_view_count', true);
						    		$FAQ_Categories = get_the_term_list($FAQ->ID, 'ufaq-category', '', ', ', '');
						    		$FAQ_Tags = get_the_term_list($FAQ->ID, 'ufaq-tag', '', ', ', '');
						    		echo "<tr id='ewd-ufaq-item-" . $FAQ->ID . "' class='ewd-ufaq-item'>";
						    	    echo "<td class='ufaq-title'>" . $FAQ->post_title . "</td>";
						    	    echo "<td class='ufaq-title'>" . $FAQ_Views . "</td>";
						    	    echo "<td class='ufaq-title'>" . $FAQ_Categories . "</td>";
						    	    echo "<td class='ufaq-title'>" . $FAQ_Tags . "</td>";
						    		echo "</tr>";
						    	}
							}?>
						    </tbody>
						    <tfoot>
						        <tr>
						            <th><?php _e("Question", 'ultimate-faqs') ?></th>
						            <th><?php _e("Views", 'ultimate-faqs') ?></th>
						            <th><?php _e("Categories", 'ultimate-faqs') ?></th>
						            <th><?php _e("Tags", 'ultimate-faqs') ?></th>
						        </tr>
						    </tfoot>
						</table>
					</div>
				</div>

			</div> <!-- ewd-ufaq-admin-styling-subsection -->
			<?php if ($UFAQ_Full_Version != "Yes") { ?>
				<div class="ewd-ufaq-premium-options-table-overlay">
					<div class="ewd-ufaq-unlock-premium">
						<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate FAQ Premium">
						<p>Access this section by by upgrading to premium</p>
						<a href="https://www.etoilewebdesign.com/license-payment/?Selected=UFAQ&Quantity=1" class="ewd-ufaq-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					</div>
				</div>
			<?php } ?>
		</div> <!-- ewd-ufaq-admin-styling-section -->

	</div>

	<div id='Fields' class='ufaq-option-set<?php echo ( $Display_Tab == 'Fields' ? '' : ' ufaq-hidden' ); ?>'>
	<h2 id='label-order-options' class='ufaq-options-page-tab-title'>Fields Options (Premium)</h2>

	<br />

	<div class="ewd-ufaq-admin-section-heading"><?php _e('Settings', 'ultimate-faqs'); ?></div>

	<table class="form-table ewd-ufaq-premium-options-table">
		<tr>
			<th scope="row">FAQ Custom Fields</th>
			<td>
				<fieldset><legend class="screen-reader-text"><span>FAQ Custom Fields</span></legend>
					<table id='ewd-ufaq-custom-fields-table'>
						<tr>
							<th class="ewd-ufaq-admin-no-info-button"></th>
							<th class="ewd-ufaq-admin-no-info-button">Field Name</th>
							<th class="ewd-ufaq-admin-no-info-button">Field Type</th>
							<th class="ewd-ufaq-admin-no-info-button">Field Values</th>
						</tr>
						<?php
						$Counter = 0;
						$Max_ID = 0;
						if (!is_array($FAQ_Fields_Array)) {$FAQ_Fields_Array = array();}
						foreach ($FAQ_Fields_Array as $FAQ_Field_Item) {
							echo "<tr id='ewd-ufaq-custom-field-row-" . $Counter . "'>";
							echo "<td><input type='hidden' name='Custom_Field_" . $Counter . "_ID' value='" . $FAQ_Field_Item['FieldID'] . "' /><a class='ewd-ufaq-delete-custom-field' data-fieldid='" . $Counter . "'>Delete</a></td>";
							echo "<td><input type='text' name='Custom_Field_" . $Counter . "_Name' value='" . $FAQ_Field_Item['FieldName'] . "'/></td>";
							echo "<td><select name='Custom_Field_" . $Counter . "_Type'>"; ?>
							<option value='text' <?php if ($FAQ_Field_Item['FieldType'] == "text") {echo "selected='selected'";} ?>>Text</option>
							<option value='textarea' <?php if ($FAQ_Field_Item['FieldType'] == "textarea") {echo "selected='selected'";} ?>>Text Area</option>
							<option value='select' <?php if ($FAQ_Field_Item['FieldType'] == "select") {echo "selected='selected'";} ?>>Select Box</option>
							<option value='radio' <?php if ($FAQ_Field_Item['FieldType'] == "radio") {echo "selected='selected'";} ?>>Radio Buttons</option>
							<option value='checkbox' <?php if ($FAQ_Field_Item['FieldType'] == "checkbox") {echo "selected='selected'";} ?>>Checkbox</option>
							<option value='file' <?php if ($FAQ_Field_Item['FieldType'] == "file") {echo "selected='selected'";} ?>>File</option>
							<option value='link' <?php if ($FAQ_Field_Item['FieldType'] == "link") {echo "selected='selected'";} ?>>Link</option>
							<option value='date' <?php if ($FAQ_Field_Item['FieldType'] == "date") {echo "selected='selected'";} ?>>Date</option>
							<option value='datetime' <?php if ($FAQ_Field_Item['FieldType'] == "datetime") {echo "selected='selected'";} ?>>Date/Time</option>
							<?php echo "</select></td>";
							echo "<td><input type='text' name='Custom_Field_" . $Counter . "_Values' value='" . $FAQ_Field_Item['FieldValues'] . "'/></td>";
							echo "</tr>";
							$Counter++;
							$Max_ID = max($Max_ID, $FAQ_Field_Item['FieldID']);
						}
						$Max_ID++;
						echo "<tr><td colspan='4'><a class='ewd-ufaq-add-custom-field' data-nextid='" . $Counter . "' data-maxid='" . $Max_ID . "'>Add</a></td></tr>";
						?>
					</table>
					<p>Should any extra fields be added to the FAQs?<br />
					The "Field Values" should be a comma-separated list of values for the select, radio or checkbox field types (no extra spaces after the comma)<br />
					For security reasons, file fields cannot be included in the submit FAQ form.</p>
				</fieldset>
			</td>
		</tr>
		<tr>
			<th scope="row">Hide Blank Fields</th>
			<td>
				<fieldset><legend class="screen-reader-text"><span>Hide Blank Fields</span></legend>
					<div class="ewd-ufaq-admin-hide-radios">
						<label title='Yes' class='ewd-ufaq-admin-input-container'><input type='radio' name='hide_blank_fields' value='Yes' <?php if($Hide_Blank_Fields == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span>Yes</span></label><br />
						<label title='No' class='ewd-ufaq-admin-input-container'><input type='radio' name='hide_blank_fields' value='No' <?php if($Hide_Blank_Fields == "No") {echo "checked='checked'";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span>No</span></label><br />
					</div>
				<label class="ewd-ufaq-admin-switch">
					<input type="checkbox" class="ewd-ufaq-admin-option-toggle" data-inputname="hide_blank_fields" <?php if($Hide_Blank_Fields == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-ufaq-admin-switch-slider round"></span>
				</label>		
					<p>Should field labels be hidden if a field hasn't been filled out for a particular FAQ?</p>
				</fieldset>
			</td>
		</tr>
		<?php if ($UFAQ_Full_Version != "Yes") { ?>
			<tr class="ewd-ufaq-premium-options-table-overlay">
				<th colspan="2">
					<div class="ewd-ufaq-unlock-premium">
						<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate FAQ Premium">
						<p>Access this section by by upgrading to premium</p>
						<a href="https://www.etoilewebdesign.com/license-payment/?Selected=UFAQ&Quantity=1" class="ewd-ufaq-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					</div>
				</th>
			</tr>
		<?php } ?>
	</table>
	</div>


	<div id='Labelling' class='ufaq-option-set<?php echo ( $Display_Tab == 'Labelling' ? '' : ' ufaq-hidden' ); ?>'>
		<h2 id='label-order-options' class='ufaq-options-page-tab-title'>Labelling Options</h2>

		<br />

		<div class="ewd-ufaq-admin-section-heading"><?php _e('FAQ Page and Search', 'ultimate-faqs'); ?></div>

		<div class="ewd-ufaq-admin-styling-section">
			<div class="ewd-ufaq-admin-styling-subsection">
				<p>Replace the default text on the FAQ page and FAQ search page</p>
				<div class="ewd-admin-labelling-section">
					<label>
						<p><?php _e("Posted", 'ultimate-faqs')?></p>
						<input type='text' name='posted_label' value='<?php echo $Posted_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("By", 'ultimate-faqs')?></p>
						<input type='text' name='by_label' value='<?php echo $By_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("On", 'ultimate-faqs')?></p>
						<input type='text' name='on_label' value='<?php echo $On_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("Categories", 'ultimate-faqs')?></p>
						<input type='text' name='category_label' value='<?php echo $Category_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
					</label>
					<label>
						<p><?php _e("Tags", 'ultimate-faqs')?></p>
						<input type='text' name='tag_label' value='<?php echo $Tag_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("Permalink", 'ultimate-faqs')?></p>
						<input type='text' name='permalink_label' value='<?php echo $Permalink_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("Back To Top", 'ultimate-faqs')?></p>
						<input type='text' name='back_to_top_label' value='<?php echo $Back_To_Top_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("WooCommerce Tab Label", 'ultimate-faqs')?></p>
						<input type='text' name='woocommerce_tab_label' value='<?php echo $WooCommerce_Tab_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("Share Label", 'ultimate-faqs')?></p>
						<input type='text' name='share_faq_label' value='<?php echo $Share_FAQ_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("Did you find this FAQ helpful?", 'ultimate-faqs')?></p>
						<input type='text' name='find_faq_helpful_label' value='<?php echo $Find_FAQ_Helpful_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("Enter your question", 'ultimate-faqs')?></p>
						<input type='text' name='enter_question_label' value='<?php echo $Enter_Question_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("Search Placeholder", 'ultimate-faqs')?></p>
						<input type='text' name='search_placeholder_label' value='<?php echo $Search_Placeholder_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("Search Button", 'ultimate-faqs')?></p>
						<input type='text' name='search_label' value='<?php echo $Search_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("Retrieving Results", 'ultimate-faqs')?></p>
						<input type='text' name='retrieving_results' value='<?php echo $Retrieving_Results; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("No results FAQ's contained the term '%s'", 'ultimate-faqs')?></p>
						<input type='text' name='no_results_found_text' value='<?php echo $No_Results_Found_Text; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
				</div>
			</div>
			<?php if ($UFAQ_Full_Version != "Yes") { ?>
				<div class="ewd-ufaq-premium-options-table-overlay">
					<div class="ewd-ufaq-unlock-premium">
						<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate FAQ Premium">
						<p>Access this section by by upgrading to premium</p>
						<a href="https://www.etoilewebdesign.com/license-payment/?Selected=UFAQ&Quantity=1" class="ewd-ufaq-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					</div>
				</div>
			<?php } ?>
		</div>

		<br />

		<div class="ewd-ufaq-admin-section-heading"><?php _e('FAQ Submit Page', 'ultimate-faqs'); ?></div>

		<div class="ewd-ufaq-admin-styling-section">
			<div class="ewd-ufaq-admin-styling-subsection">
				<p>Replace the default text on the FAQ submit page</p>
				<div class="ewd-admin-labelling-section">
					<label>
						<p><?php _e("Thank you for submitting an FAQ", 'ultimate-faqs')?></p>
						<input type='text' name='thank_you_submit_label' value='<?php echo $Thank_You_Submit_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("Submit a Question", 'ultimate-faqs')?></p>
						<input type='text' name='submit_question_label' value='<?php echo $Submit_Question_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("Please fill out the form below to submit a question.", 'ultimate-faqs')?></p>
						<input type='text' name='please_fill_form_below_label' value='<?php echo $Please_Fill_Form_Below_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("Send Question", 'ultimate-faqs')?></p>
						<input type='text' name='send_question_label' value='<?php echo $Send_Question_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("Question Title", 'ultimate-faqs')?></p>
						<input type='text' name='question_title_label' value='<?php echo $Question_Title_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("What question is being answered?", 'ultimate-faqs')?></p>
						<input type='text' name='what_question_being_answered_label' value='<?php echo $What_Question_Being_Answered_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("Proposed Answer", 'ultimate-faqs')?></p>
						<input type='text' name='proposed_answer_label' value='<?php echo $Proposed_Answer_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("Question Author", 'ultimate-faqs')?></p>
						<input type='text' name='review_author_label' value='<?php echo $Review_Author_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
					<label>
						<p><?php _e("What name should be displayed with your question?", 'ultimate-faqs')?></p>
						<input type='text' name='what_name_with_review_label' value='<?php echo $What_Name_With_Review_Label; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?>/>
					</label>
				</div>
			</div>
			<?php if ($UFAQ_Full_Version != "Yes") { ?>
				<div class="ewd-ufaq-premium-options-table-overlay">
					<div class="ewd-ufaq-unlock-premium">
						<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate FAQ Premium">
						<p>Access this section by by upgrading to premium</p>
						<a href="https://www.etoilewebdesign.com/license-payment/?Selected=UFAQ&Quantity=1" class="ewd-ufaq-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					</div>
				</div>
			<?php } ?>
		</div>

	</div>
	<div id='Styling' class='ufaq-option-set<?php echo ( $Display_Tab == 'Styling' ? '' : ' ufaq-hidden' ); ?>'>
		<h2 id='label-order-options' class='ufaq-options-page-tab-title'>Styling Options (Premium)</h2>

		<br />

		<div class="ewd-ufaq-admin-section-heading"><?php _e('Toggle Symbol', 'ultimate-faqs'); ?></div>

		<div class="ewd-ufaq-admin-styling-section">
			<div class="ewd-ufaq-admin-styling-subsection">
				<div class="ewd-ufaq-admin-styling-subsection-label"><?php _e('Choose Font Icon', 'ultimate-faqs'); ?></div>
				<div class="ewd-ufaq-admin-styling-subsection-content">
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<fieldset class="ewdAdminIconChoice">
							<label class='ewd-ufaq-admin-input-container'><input type='radio' name='toggle_symbol' value='A' <?php if ($Toggle_Symbol == "A") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span class='ufaq-toggle-symbol'>a  A</span></label>
							<label class='ewd-ufaq-admin-input-container'><input type='radio' name='toggle_symbol' value='B' <?php if ($Toggle_Symbol == "B") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span class='ufaq-toggle-symbol'>b  B</span></label>
							<label class='ewd-ufaq-admin-input-container'><input type='radio' name='toggle_symbol' value='C' <?php if ($Toggle_Symbol == "C") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span class='ufaq-toggle-symbol'>c  C</span></label>
							<label class='ewd-ufaq-admin-input-container'><input type='radio' name='toggle_symbol' value='D' <?php if ($Toggle_Symbol == "D") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span class='ufaq-toggle-symbol'>d  D</span></label>
							<label class='ewd-ufaq-admin-input-container'><input type='radio' name='toggle_symbol' value='E' <?php if ($Toggle_Symbol == "E") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span class='ufaq-toggle-symbol'>e  E</span></label>
							<label class='ewd-ufaq-admin-input-container'><input type='radio' name='toggle_symbol' value='F' <?php if ($Toggle_Symbol == "F") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span class='ufaq-toggle-symbol'>f  F</span></label>
							<label class='ewd-ufaq-admin-input-container'><input type='radio' name='toggle_symbol' value='G' <?php if ($Toggle_Symbol == "G") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span class='ufaq-toggle-symbol'>g  G</span></label>
							<label class='ewd-ufaq-admin-input-container'><input type='radio' name='toggle_symbol' value='H' <?php if ($Toggle_Symbol == "H") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span class='ufaq-toggle-symbol'>h  H</span></label>
							<label class='ewd-ufaq-admin-input-container'><input type='radio' name='toggle_symbol' value='I' <?php if ($Toggle_Symbol == "I") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span class='ufaq-toggle-symbol'>i  I</span></label>
							<label class='ewd-ufaq-admin-input-container'><input type='radio' name='toggle_symbol' value='J' <?php if ($Toggle_Symbol == "J") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span class='ufaq-toggle-symbol'>j  J</span></label>
							<label class='ewd-ufaq-admin-input-container'><input type='radio' name='toggle_symbol' value='K' <?php if ($Toggle_Symbol == "K") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span class='ufaq-toggle-symbol'>k  K</span></label>
							<label class='ewd-ufaq-admin-input-container'><input type='radio' name='toggle_symbol' value='L' <?php if ($Toggle_Symbol == "L") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span class='ufaq-toggle-symbol'>l  L</span></label>
							<label class='ewd-ufaq-admin-input-container'><input type='radio' name='toggle_symbol' value='M' <?php if ($Toggle_Symbol == "M") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span class='ufaq-toggle-symbol'>m  M</span></label>
							<label class='ewd-ufaq-admin-input-container'><input type='radio' name='toggle_symbol' value='N' <?php if ($Toggle_Symbol == "N") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span class='ufaq-toggle-symbol'>n  N</span></label>
							<label class='ewd-ufaq-admin-input-container'><input type='radio' name='toggle_symbol' value='O' <?php if ($Toggle_Symbol == "O") {echo "checked='checked'";} ?> <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> /><span class='ewd-ufaq-admin-radio-button'></span> <span class='ufaq-toggle-symbol'>o  O</span></label>
						</fieldset>
					</div>
				</div>
			</div>
			<div class="ewd-ufaq-admin-styling-subsection">
				<div class="ewd-ufaq-admin-styling-subsection-label"><?php _e('Styling', 'ultimate-faqs'); ?></div>
				<div class="ewd-ufaq-admin-styling-subsection-content">
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Colors', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<div class="ewd-ufaq-admin-styling-subsection-content-color-picker">
								<div class="ewd-ufaq-admin-styling-subsection-content-color-picker-label"><?php _e('Icon Background', 'ultimate-faqs'); ?></div>
								<input type='text' class='ewd-ufaq-spectrum' name='ufaq_styling_default_bg_color' value='<?php echo $UFAQ_Styling_Default_Bg_Color; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
							</div>
							<div class="ewd-ufaq-admin-styling-subsection-content-color-picker">
								<div class="ewd-ufaq-admin-styling-subsection-content-color-picker-label"><?php _e('Icon', 'ultimate-faqs'); ?></div>
								<input type='text' class='ewd-ufaq-spectrum' name='ufaq_styling_default_font_color' value='<?php echo $UFAQ_Styling_Default_Font_Color; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
							</div>
							<div class="ewd-ufaq-admin-styling-subsection-content-color-picker">
								<div class="ewd-ufaq-admin-styling-subsection-content-color-picker-label"><?php _e('Icon Border', 'ultimate-faqs'); ?></div>
								<input type='text' class='ewd-ufaq-spectrum' name='ufaq_styling_default_border_color' value='<?php echo $UFAQ_Styling_Default_Border_Color; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
							</div>
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Icon Font Size', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_toggle_symbol_size' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Toggle_Symbol_Size; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Border Size', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_default_border_size' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Default_Border_Size; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Border Radius', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_default_border_radius' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Default_Border_Radius; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
				</div>
			</div>
			<?php if ($UFAQ_Full_Version != "Yes") { ?>
				<div class="ewd-ufaq-premium-options-table-overlay">
					<div class="ewd-ufaq-unlock-premium">
						<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate FAQ Premium">
						<p>Access this section by by upgrading to premium</p>
						<a href="https://www.etoilewebdesign.com/license-payment/?Selected=UFAQ&Quantity=1" class="ewd-ufaq-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					</div>
				</div>
			<?php } ?>
		</div>

		<br />

		<div class="ewd-ufaq-admin-section-heading"><?php _e('Themes', 'ultimate-faqs'); ?></div>

		<div class="ewd-ufaq-admin-styling-section">
			<div class="ewd-ufaq-admin-styling-subsection">
				<div class="ewd-ufaq-admin-styling-subsection-label"><?php _e('Block &amp; Border Block Themes', 'ultimate-faqs'); ?></div>
				<div class="ewd-ufaq-admin-styling-subsection-content">
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Colors', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<div class="ewd-ufaq-admin-styling-subsection-content-color-picker">
								<div class="ewd-ufaq-admin-styling-subsection-content-color-picker-label"><?php _e('Background Color', 'ultimate-faqs'); ?></div>
								<input type='text' class='ewd-ufaq-spectrum' name='ufaq_styling_block_bg_color' value='<?php echo $UFAQ_Styling_Block_Bg_Color; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
							</div>
							<div class="ewd-ufaq-admin-styling-subsection-content-color-picker">
								<div class="ewd-ufaq-admin-styling-subsection-content-color-picker-label"><?php _e('Hover Font Color', 'ultimate-faqs'); ?></div>
								<input type='text' class='ewd-ufaq-spectrum' name='ufaq_styling_block_font_color' value='<?php echo $UFAQ_Styling_Block_Font_Color; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="ewd-ufaq-admin-styling-subsection">
				<div class="ewd-ufaq-admin-styling-subsection-label"><?php _e('List Theme Anchors', 'ultimate-faqs'); ?></div>
				<div class="ewd-ufaq-admin-styling-subsection-content">
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Color', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<div class="ewd-ufaq-admin-styling-subsection-content-color-picker">
								<div class="ewd-ufaq-admin-styling-subsection-content-color-picker-label"></div>
								<input type='text' class='ewd-ufaq-spectrum' name='ufaq_styling_list_font_color' value='<?php echo $UFAQ_Styling_List_Font_Color; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
							</div>
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Family', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_list_font' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_List_Font; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Size', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_list_font_size' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_List_Font_Size; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Margin', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_list_margin' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_List_Margin; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Padding', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_list_padding' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_List_Padding; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
				</div>
			</div>
			<?php if ($UFAQ_Full_Version != "Yes") { ?>
				<div class="ewd-ufaq-premium-options-table-overlay">
					<div class="ewd-ufaq-unlock-premium">
						<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate FAQ Premium">
						<p>Access this section by by upgrading to premium</p>
						<a href="https://www.etoilewebdesign.com/license-payment/?Selected=UFAQ&Quantity=1" class="ewd-ufaq-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					</div>
				</div>
			<?php } ?>
		</div>

		<br />

		<div class="ewd-ufaq-admin-section-heading"><?php _e('FAQ Elements', 'ultimate-faqs'); ?></div>

		<div class="ewd-ufaq-admin-styling-section">
			<div class="ewd-ufaq-admin-styling-subsection">
				<div class="ewd-ufaq-admin-styling-subsection-label"><?php _e('FAQ Question', 'ultimate-faqs'); ?></div>
				<div class="ewd-ufaq-admin-styling-subsection-content">
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Color', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<div class="ewd-ufaq-admin-styling-subsection-content-color-picker">
								<div class="ewd-ufaq-admin-styling-subsection-content-color-picker-label"></div>
								<input type='text' class='ewd-ufaq-spectrum' name='ufaq_styling_question_font_color' value='<?php echo $UFAQ_Styling_Question_Font_Color; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
							</div>
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Family', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_question_font' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Question_Font; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Size', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_question_font_size' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Question_Font_Size; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Margin', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_question_margin' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Question_Margin; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Padding', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_question_padding' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Question_Padding; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Toggle Symbol Top Margin', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_question_icon_top_margin' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Question_Icon_Top_Margin; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
				</div>
			</div>
			<div class="ewd-ufaq-admin-styling-subsection">
				<div class="ewd-ufaq-admin-styling-subsection-label"><?php _e('FAQ Answer', 'ultimate-faqs'); ?></div>
				<div class="ewd-ufaq-admin-styling-subsection-content">
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Color', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<div class="ewd-ufaq-admin-styling-subsection-content-color-picker">
								<div class="ewd-ufaq-admin-styling-subsection-content-color-picker-label"></div>
								<input type='text' class='ewd-ufaq-spectrum' name='ufaq_styling_answer_font_color' value='<?php echo $UFAQ_Styling_Answer_Font_Color; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
							</div>
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Family', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_answer_font' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Answer_Font; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Size', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_answer_font_size' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Answer_Font_Size; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Margin', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_answer_margin' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Answer_Margin; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Padding', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_answer_padding' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Answer_Padding; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
				</div>
			</div>
			<div class="ewd-ufaq-admin-styling-subsection">
				<div class="ewd-ufaq-admin-styling-subsection-label"><?php _e('FAQ Category, Tags', 'ultimate-faqs'); ?></div>
				<div class="ewd-ufaq-admin-styling-subsection-content">
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Color', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<div class="ewd-ufaq-admin-styling-subsection-content-color-picker">
								<div class="ewd-ufaq-admin-styling-subsection-content-color-picker-label"></div>
								<input type='text' class='ewd-ufaq-spectrum' name='ufaq_styling_category_font_color' value='<?php echo $UFAQ_Styling_Category_Font_Color; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
							</div>
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Family', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_category_font' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Category_Font; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Size', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_category_font_size' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Category_Font_Size; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Margin', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_category_margin' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Category_Margin; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Padding', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_category_padding' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Category_Padding; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
				</div>
			</div>
			<div class="ewd-ufaq-admin-styling-subsection">
				<div class="ewd-ufaq-admin-styling-subsection-label"><?php _e('FAQ Post Date', 'ultimate-faqs'); ?></div>
				<div class="ewd-ufaq-admin-styling-subsection-content">
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Color', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<div class="ewd-ufaq-admin-styling-subsection-content-color-picker">
								<div class="ewd-ufaq-admin-styling-subsection-content-color-picker-label"></div>
								<input type='text' class='ewd-ufaq-spectrum' name='ufaq_styling_postdate_font_color' value='<?php echo $UFAQ_Styling_Postdate_Font_Color; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
							</div>
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Family', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_postdate_font' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Postdate_Font; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Size', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_postdate_font_size' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Postdate_Font_Size; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Margin', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_postdate_margin' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Postdate_Margin; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Padding', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_postdate_padding' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Postdate_Padding; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
				</div>
			</div>
			<div class="ewd-ufaq-admin-styling-subsection">
				<div class="ewd-ufaq-admin-styling-subsection-label"><?php _e('Category Headings<br /><span class="notBold">(when "Group FAQs by Category" is enabled)</span>', 'ultimate-faqs'); ?></div>
				<div class="ewd-ufaq-admin-styling-subsection-content">
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Color', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<div class="ewd-ufaq-admin-styling-subsection-content-color-picker">
								<div class="ewd-ufaq-admin-styling-subsection-content-color-picker-label"></div>
								<input type='text' class='ewd-ufaq-spectrum' name='ufaq_styling_category_heading_font_color' value='<?php echo $UFAQ_Styling_Category_Heading_Font_Color; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
							</div>
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Family', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_category_heading_font' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Category_Heading_Font; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<div class="ewd-ufaq-admin-styling-subsection-content-label"><?php _e('Font Size', 'ultimate-faqs'); ?></div>
						<div class="ewd-ufaq-admin-styling-subsection-content-right">
							<input type='text' name='ufaq_styling_category_heading_font_size' class='ewd-ufaq-admin-font-size' value='<?php echo $UFAQ_Styling_Category_Heading_Font_Size; ?>' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
				</div>
			</div>
			<?php if ($UFAQ_Full_Version != "Yes") { ?>
				<div class="ewd-ufaq-premium-options-table-overlay">
					<div class="ewd-ufaq-unlock-premium">
						<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate FAQ Premium">
						<p>Access this section by by upgrading to premium</p>
						<a href="https://www.etoilewebdesign.com/license-payment/?Selected=UFAQ&Quantity=1" class="ewd-ufaq-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					</div>
				</div>
			<?php } ?>
		</div>

		<br />

		<div class="ewd-ufaq-admin-section-heading"><?php _e('FAQ Heading Types', 'ultimate-faqs'); ?></div>

		<div class="ewd-ufaq-admin-styling-section <?php echo $UFAQ_Full_Version; ?>">
			<div class="ewd-ufaq-admin-styling-subsection">
				<div class="ewd-ufaq-admin-styling-subsection-label"><?php _e('Category Heading Type', 'ultimate-faqs'); ?></div>
				<div class="ewd-ufaq-admin-styling-subsection-content">
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<label>
							<select name='ufaq_styling_category_heading_type' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> >
								<option value='h1' <?php if ($UFAQ_Styling_Category_Heading_Type == 'h1') {echo "selected='selected'";} ?>>H1</option>
								<option value='h2' <?php if ($UFAQ_Styling_Category_Heading_Type == 'h2') {echo "selected='selected'";} ?>>H2</option>
								<option value='h3' <?php if ($UFAQ_Styling_Category_Heading_Type == 'h3') {echo "selected='selected'";} ?>>H3</option>
								<option value='h4' <?php if ($UFAQ_Styling_Category_Heading_Type == 'h4') {echo "selected='selected'";} ?>>H4</option>
								<option value='h5' <?php if ($UFAQ_Styling_Category_Heading_Type == 'h5') {echo "selected='selected'";} ?>>H5</option>
								<option value='h6' <?php if ($UFAQ_Styling_Category_Heading_Type == 'h6') {echo "selected='selected'";} ?>>H6</option>
							</select>
						</label>
					</div>
				</div>
			</div>
			<div class="ewd-ufaq-admin-styling-subsection">
				<div class="ewd-ufaq-admin-styling-subsection-label"><?php _e('FAQ Heading Type', 'ultimate-faqs'); ?></div>
				<div class="ewd-ufaq-admin-styling-subsection-content">
					<div class="ewd-ufaq-admin-styling-subsection-content-each">
						<label>
							<select name='ufaq_styling_faq_heading_type' <?php if ($UFAQ_Full_Version != "Yes") {echo "disabled";} ?> >
								<option value='h1' <?php if ($UFAQ_Styling_FAQ_Heading_Type == 'h1') {echo "selected='selected'";} ?>>H1</option>
								<option value='h2' <?php if ($UFAQ_Styling_FAQ_Heading_Type == 'h2') {echo "selected='selected'";} ?>>H2</option>
								<option value='h3' <?php if ($UFAQ_Styling_FAQ_Heading_Type == 'h3') {echo "selected='selected'";} ?>>H3</option>
								<option value='h4' <?php if ($UFAQ_Styling_FAQ_Heading_Type == 'h4') {echo "selected='selected'";} ?>>H4</option>
								<option value='h5' <?php if ($UFAQ_Styling_FAQ_Heading_Type == 'h5') {echo "selected='selected'";} ?>>H5</option>
								<option value='h6' <?php if ($UFAQ_Styling_FAQ_Heading_Type == 'h6') {echo "selected='selected'";} ?>>H6</option>
							</select>
						</label>
					</div>
				</div>
			</div>
			<?php if ($UFAQ_Full_Version != "Yes") { ?>
				<div class="ewd-ufaq-premium-options-table-overlay">
					<div class="ewd-ufaq-unlock-premium">
						<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate FAQ Premium">
						<p>Access this section by by upgrading to premium</p>
						<a href="https://www.etoilewebdesign.com/license-payment/?Selected=UFAQ&Quantity=1" class="ewd-ufaq-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					</div>
				</div>
			<?php } ?>
		</div>



	</div>

</div>

<p class="submit"><input type="submit" name="Options_Submit" id="submit" class="button button-primary" value="Save Changes"  /></p></form>

	<?php /* </div><!-- /.tabs-panel -->
	</div><!-- /.posttypediv -->
	</div>
	</div>
	</div>
	</div><!-- col-right --> */ ?>
</div>
</div>

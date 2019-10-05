<?php
	$FAQ_Accordion = get_option("EWD_UFAQ_FAQ_Accordion");
	$FAQ_Toggle = get_option("EWD_UFAQ_Toggle");
	$Group_By_Category = get_option("EWD_UFAQ_Group_By_Category");
	$Order_By_Setting = get_option("EWD_UFAQ_Order_By");
?>
<div class='ewd-ufaq-welcome-screen'>
	<div class='ewd-ufaq-welcome-screen-header'>
		<h1><?php _e('Welcome to Ultimate FAQs', 'ultimate-faqs'); ?></h1>
		<p><?php _e('Thanks for choosing Ultimate FAQs! The following will help you get started with the setup by creating your first FAQ and category, as well as adding your FAQs to a page and configuring a few key options.', 'ultimate-faqs'); ?></p>
	</div>

	<div class='ewd-ufaq-welcome-screen-box ewd-ufaq-welcome-screen-categories ewd-ufaq-welcome-screen-open' data-screen='categories'>
		<h2><?php _e('1. Create Categories', 'ultimate-faqs'); ?></h2>
		<div class='ewd-ufaq-welcome-screen-box-content'>
			<p><?php _e('Categories let you organize your FAQs in a way that\'s easy for you - and your customers - to find.', 'ultimate-faqs'); ?></p>
			<div class='ewd-ufaq-welcome-screen-created-categories'>
				<div class='ewd-ufaq-welcome-screen-add-category-name ewd-ufaq-welcome-screen-box-content-divs'><label><?php _e('Category Name:', 'ultimate-faqs'); ?></label><input type='text' /></div>
				<div class='ewd-ufaq-welcome-screen-add-category-description ewd-ufaq-welcome-screen-box-content-divs'><label><?php _e('Category Description:', 'ultimate-faqs'); ?></label><textarea></textarea></div>
				<div class='ewd-ufaq-welcome-screen-add-category-button'><?php _e('Add Category', 'ultimate-faqs'); ?></div>
				<div class="ewd-ufaq-welcome-clear"></div>
				<div class="ewd-ufaq-welcome-screen-show-created-categories">
					<h3><?php _e('Created Categories:', 'ultimate-faqs'); ?></h3>
					<div class="ewd-ufaq-welcome-screen-show-created-categories-name"><?php _e('Name', 'ultimate-faqs'); ?></div>
					<div class="ewd-ufaq-welcome-screen-show-created-categories-description"><?php _e('Description', 'ultimate-faqs'); ?></div>
				</div>
			</div>
			<div class='ewd-ufaq-welcome-screen-next-button' data-nextaction='questions'><?php _e('Next', 'ultimate-faqs'); ?></div>
			<div class='ewd-ufaq-clear'></div>
		</div>
	</div>

	<div class='ewd-ufaq-welcome-screen-box ewd-ufaq-welcome-screen-questions' data-screen='questions'>
		<h2><?php _e('2. Questions & Answers', 'ultimate-faqs'); ?></h2>
		<div class='ewd-ufaq-welcome-screen-box-content'>
			<p><?php _e('Create your first set of questions and answers. Don\'t worry, you can always add more later.', 'ultimate-faqs'); ?></p>
			<div class='ewd-ufaq-welcome-screen-created-faqs'>
				<div class='ewd-ufaq-welcome-screen-add-faq-question ewd-ufaq-welcome-screen-box-content-divs'><label><?php _e('Questions:', 'ultimate-faqs'); ?></label><input type='text' /></div>
				<div class='ewd-ufaq-welcome-screen-add-faq-answer ewd-ufaq-welcome-screen-box-content-divs'><label><?php _e('Answer:', 'ultimate-faqs'); ?></label><textarea></textarea></div>
				<div class='ewd-ufaq-welcome-screen-add-faq-category ewd-ufaq-welcome-screen-box-content-divs'><label><?php _e('FAQ Category:', 'ultimate-faqs'); ?></label><select><option></option></select></div>
				<div class='ewd-ufaq-welcome-screen-add-faq-button'><?php _e('Add FAQ', 'ultimate-faqs'); ?></div>
				<div class="ewd-ufaq-welcome-clear"></div>
				<div class="ewd-ufaq-welcome-screen-show-created-faqs">
					<h3><?php _e('Created FAQs:', 'ultimate-faqs'); ?></h3>
					<div class="ewd-ufaq-welcome-screen-show-created-faq-question"><?php _e('Question', 'ultimate-faqs'); ?></div>
					<div class="ewd-ufaq-welcome-screen-show-created-faq-answer"><?php _e('Answer', 'ultimate-faqs'); ?></div>
					<div class="ewd-ufaq-welcome-screen-show-created-faq-category"><?php _e('Category', 'ultimate-faqs'); ?></div>
				</div>
			</div>
			<div class='ewd-ufaq-welcome-screen-previous-button' data-previousaction='categories'><?php _e('Previous', 'ultimate-faqs'); ?></div>
			<?php  if (isset($_GET['exclude'])) { ?><div class='ewd-ufaq-welcome-screen-finish-button'><a href='admin.php?page=EWD-UFAQ-Options'><?php _e('Finish', 'ultimate-faqs'); ?></a></div>
			<?php } else { ?><div class='ewd-ufaq-welcome-screen-next-button' data-nextaction='faq-page'><?php _e('Next', 'ultimate-faqs'); ?></div><?php } ?>
			<div class='ewd-ufaq-clear'></div>
		</div>
	</div>
<?php  if (!isset($_GET['exclude'])) { ?>
	<div class='ewd-ufaq-welcome-screen-box ewd-ufaq-welcome-screen-faq-page' data-screen='faq-page'>
		<h2><?php _e('3. Add an FAQ Page', 'ultimate-faqs'); ?></h2>
		<div class='ewd-ufaq-welcome-screen-box-content'>
			<p><?php _e('You can create a dedicated FAQ page below, or skip this step and add your FAQs to a page you\'ve already created manually.', 'ultimate-faqs'); ?></p>
			<div class='ewd-ufaq-welcome-screen-faq-page'>
				<div class='ewd-ufaq-welcome-screen-add-faq-page-name ewd-ufaq-welcome-screen-box-content-divs'><label><?php _e('Page Title:', 'ultimate-faqs'); ?></label><input type='text' value='FAQs' /></div>
				<div class='ewd-ufaq-welcome-screen-add-faq-page-button'><?php _e('Create Page', 'ultimate-faqs'); ?></div>
			</div>
			<div class="ewd-ufaq-welcome-clear"></div>
			<div class='ewd-ufaq-welcome-screen-next-button' data-nextaction='options'><?php _e('Next', 'ultimate-faqs'); ?></div>
			<div class='ewd-ufaq-welcome-screen-previous-button' data-previousaction='questions'><?php _e('Previous', 'ultimate-faqs'); ?></div>
			<div class='ewd-ufaq-clear'></div>
		</div>
	</div>

	<div class='ewd-ufaq-welcome-screen-box ewd-ufaq-welcome-screen-options' data-screen='options'>
		<h2><?php _e('4. Set Key Options', 'ultimate-faqs'); ?></h2>
		<div class='ewd-ufaq-welcome-screen-box-content'>
			<p><?php _e('Options can always be changed later, but here are a few that a lot of users want to set for themselves.', 'ultimate-faqs'); ?></p>
			<table class="form-table">
				<tr>
					<th><?php _e('FAQ Accordion', 'ultimate-faqs'); ?></th>
					<td>
						<div class='ewd-ufaq-welcome-screen-option'>
							<fieldset>
								<legend class="screen-reader-text"><span>FAQ Accordion</span></legend>
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
						</div>
					</td>
				</tr>
				<tr>
					<th><?php _e('FAQ Toggle', 'ultimate-faqs'); ?></th>
					<td>
						<div class='ewd-ufaq-welcome-screen-option'>
							<fieldset>
								<legend class="screen-reader-text"><span>FAQ Toggle</span></legend>
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
						</div>
					</td>
				</tr>
				<tr>
					<th><?php _e('Group FAQs by Category', 'ultimate-faqs'); ?></th>
					<td>
						<div class='ewd-ufaq-welcome-screen-option'>
							<fieldset>
								<legend class="screen-reader-text"><span>Group FAQs by Category</span></legend>
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
						</div>
					</td>
				</tr>
				<tr>
					<th><?php _e('FAQ Ordering', 'ultimate-faqs'); ?></th>
					<td>
						<div class='ewd-ufaq-welcome-screen-option'>
							<fieldset>
								<legend class="screen-reader-text"><span>FAQ Ordering</span></legend>
								<label title='FAQ Ordering'></label>

								<select name="order_by_setting">
					  				<option value="date" <?php if($Order_By_Setting == "date") {echo "selected=selected";} ?> >Created Date</option>
									<option value="title" <?php if($Order_By_Setting == "title") {echo "selected=selected";} ?> >Title</option>
					  				<option value="modified" <?php if($Order_By_Setting == "modified") {echo "selected=selected";} ?> >Modified Date</option>
								</select>

								<p>How should individual FAQs be ordered?</p>
							</fieldset>
						</div>
					</td>
				</tr>
			</table>

			<div class='ewd-ufaq-welcome-screen-save-options-button'><?php _e('Save Options', 'ultimate-faqs'); ?></div>
			<div class="ewd-ufaq-welcome-clear"></div>
			<div class='ewd-ufaq-welcome-screen-previous-button' data-previousaction='faq-page'><?php _e('Previous', 'ultimate-faqs'); ?></div>
			<div class='ewd-ufaq-welcome-screen-finish-button'><a href='admin.php?page=EWD-UFAQ-Options'><?php _e('Finish', 'ultimate-faqs'); ?></a></div>
			<div class='ewd-ufaq-clear'></div>
		</div>
	</div>
<?php } ?>
	<div class='ewd-ufaq-welcome-screen-skip-container'>
		<a href='admin.php?page=EWD-UFAQ-Options'><div class='ewd-ufaq-welcome-screen-skip-button'><?php _e('Skip Setup', 'ultimate-faqs'); ?></div></a>
	</div>
</div>
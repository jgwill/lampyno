<?php
	$Maximum_Score = get_option("EWD_URP_Maximum_Score");
	$Review_Score_Input = get_option("EWD_URP_Review_Score_Input");
	$Review_Category = get_option("EWD_URP_Review_Category");
	$Review_Filtering = get_option("EWD_URP_Review_Filtering");
	if (!is_array($Review_Filtering)) {$Review_Filtering = array();}
?>
<div class='ewd-urp-welcome-screen'>
	<div class='ewd-urp-welcome-screen-header'>
		<h1><?php _e('Welcome to Ultimate Reviews', 'ultimate-reviews'); ?></h1>
		<p><?php _e('Thanks for choosing Ultimate Reviews! The following will help you get started with the setup by creating pages to accept and display reviews, configuring a few key options, and creating some review categories.', 'ultimate-reviews'); ?></p>
	</div>

	<div class='ewd-urp-welcome-screen-box ewd-urp-welcome-screen-submit-review ewd-urp-welcome-screen-open' data-screen='submit-review'>
		<h2><?php _e('1. Submit Review Page', 'ultimate-reviews'); ?></h2>
		<div class='ewd-urp-welcome-screen-box-content'>
			<p><?php _e('You can create a dedicated submit review page below, or skip this step and add your submit review form to a page you\'ve already created manually.', 'ultimate-reviews'); ?></p>
			<div class='ewd-urp-welcome-screen-submit-review-page'>
				<div class='ewd-urp-welcome-screen-add-submit-review-page-name ewd-urp-welcome-screen-box-content-divs'><label><?php _e('Page Title:', 'ultimate-reviews'); ?></label><input type='text' value='Submit Review' /></div>
				<div class='ewd-urp-welcome-screen-add-submit-review-page-button'><?php _e('Create Page', 'ultimate-reviews'); ?></div>
			</div>
			<div class="ewd-urp-welcome-clear"></div>
			<div class='ewd-urp-welcome-screen-next-button' data-nextaction='display-review'><?php _e('Next', 'ultimate-reviews'); ?></div>
			<div class='ewd-urp-clear'></div>
		</div>
	</div>

	<div class='ewd-urp-welcome-screen-box ewd-urp-welcome-screen-display-review' data-screen='display-review'>
		<h2><?php _e('2. Display Reviews Page', 'ultimate-reviews'); ?></h2>
		<div class='ewd-urp-welcome-screen-box-content'>
			<p><?php _e('You can create a dedicated page for displaying reviews below, or skip this step and add your review display form to a page you\'ve already created manually.', 'ultimate-reviews'); ?></p>
			<div class='ewd-urp-welcome-screen-display-review-page'>
				<div class='ewd-urp-welcome-screen-add-display-review-page-name ewd-urp-welcome-screen-box-content-divs'><label><?php _e('Page Title:', 'ultimate-reviews'); ?></label><input type='text' value='Reviews' /></div>
				<div class='ewd-urp-welcome-screen-add-display-review-page-button'><?php _e('Create Page', 'ultimate-reviews'); ?></div>
			</div>
			<div class="ewd-urp-welcome-clear"></div>
			<div class='ewd-urp-welcome-screen-next-button' data-nextaction='options'><?php _e('Next', 'ultimate-reviews'); ?></div>
			<div class='ewd-urp-welcome-screen-previous-button' data-previousaction='submit-review'><?php _e('Previous', 'ultimate-reviews'); ?></div>
			<div class='ewd-urp-clear'></div>
		</div>
	</div>

	<div class='ewd-urp-welcome-screen-box ewd-urp-welcome-screen-options' data-screen='options'>
		<h2><?php _e('3. Set Key Options', 'ultimate-reviews'); ?></h2>
		<div class='ewd-urp-welcome-screen-box-content'>
			<p><?php _e('Options can always be changed later, but here are a few than a lot of users want to set for themselves.', 'ultimate-reviews'); ?></p>
			<table class="form-table">
				<tr>
					<th><?php _e('Maximum Review Score', 'ultimate-reviews'); ?></th>
					<td>
						<div class='ewd-urp-welcome-screen-option'>
							<fieldset>
								<legend class="screen-reader-text"><span>Maximum Review Score</span></legend>
								<input type='text' name='maximum_score' value='<?php echo $Maximum_Score; ?>' />
								<p>What should the maximum score be on the review form? Common values are 100 for the 'percentage' review style, and 5 or 10 for the other styles.</p>
							</fieldset>
						</div>
					</td>
				</tr>
				<tr>
					<th><?php _e('Review Score Input', 'ultimate-reviews'); ?></th>
					<td>
						<div class='ewd-urp-welcome-screen-option'>
							<fieldset>
								<legend class="screen-reader-text"><span>Review Score Input</span></legend>
									<label title='Text' class='ewd-urp-admin-input-container'><input type='radio' name='review_score_input' value='Text' <?php if($Review_Score_Input == "Text") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Text</span></label><br />
									<label title='Select' class='ewd-urp-admin-input-container'><input type='radio' name='review_score_input' value='Select' <?php if($Review_Score_Input  == "Select") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Select</span></label><br />
									<label title='Stars' class='ewd-urp-admin-input-container'><input type='radio' name='review_score_input' value='Stars' <?php if($Review_Score_Input  == "Stars") {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-radio-button'></span> <span>Stars</span></label><br />
									<p>What type of input should be used for review scores in the submit-review shortcode?</p>
								</fieldset>
						</div>
					</td>
				</tr>
				<tr>
					<th><?php _e('Review Category', 'ultimate-reviews'); ?></th>
					<td>
						<div class='ewd-urp-welcome-screen-option'>
							<fieldset>
								<legend class="screen-reader-text"><span>Review Category</span></legend>
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
						</div>
					</td>
				</tr>
				<tr>
					<th><?php _e('Review Filtering', 'ultimate-reviews'); ?></th>
					<td>
						<div class='ewd-urp-welcome-screen-option'>
							<fieldset>
								<legend class="screen-reader-text"><span>Review Filtering</span></legend>
									<label title='Score' class='ewd-urp-admin-input-container'><input type='checkbox' name='review_filtering[]' value='Score' <?php if(in_array("Score", $Review_Filtering)) {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-checkbox'></span> <span>Review Score</span></label><br />
									<label title='Name' class='ewd-urp-admin-input-container'><input type='checkbox' name='review_filtering[]' value='Name' <?php if(in_array("Name", $Review_Filtering)) {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-checkbox'></span> <span>Product Name</span></label><br />
									<label title='Author' class='ewd-urp-admin-input-container'><input type='checkbox' name='review_filtering[]' value='Author' <?php if(in_array("Author", $Review_Filtering)) {echo "checked='checked'";} ?> /><span class='ewd-urp-admin-checkbox'></span> <span>Review Author</span></label><br />
									<p>Should visitors be able to filter reviews by product name, score or review author?</p>
								</fieldset>
						</div>
					</td>
				</tr>
			</table>

			<div class='ewd-urp-welcome-screen-save-options-button'><?php _e('Save Options', 'ultimate-reviews'); ?></div>
			<div class="ewd-urp-welcome-clear"></div>
			<div class='ewd-urp-welcome-screen-previous-button' data-previousaction='tracking-page'><?php _e('Previous', 'ultimate-reviews'); ?></div>
			<div class='ewd-urp-welcome-screen-next-button' data-nextaction='categories'><?php _e('Next', 'ultimate-reviews'); ?></div>
			
			<div class='ewd-urp-clear'></div>
		</div>
	</div>

	<div class='ewd-urp-welcome-screen-box ewd-urp-welcome-screen-categories' data-screen='categories'>
		<h2><?php _e('4. Categories', 'ultimate-reviews'); ?></h2>
		<div class='ewd-urp-welcome-screen-box-content'>
			<p><?php _e('Categories let you organize your reviews in a way that\'s easy for you - and your customers - to find.', 'ultimate-reviews'); ?></p>
			<div class='ewd-urp-welcome-screen-created-categories'>
				<div class='ewd-urp-welcome-screen-add-category-name ewd-urp-welcome-screen-box-content-divs'><label><?php _e('Category Name:', 'ultimate-reviews'); ?></label><input type='text' /></div>
				<div class='ewd-urp-welcome-screen-add-category-description ewd-urp-welcome-screen-box-content-divs'><label><?php _e('Category Description:', 'ultimate-reviews'); ?></label><textarea></textarea></div>
				<div class='ewd-urp-welcome-screen-add-category-button'><?php _e('Add Category', 'ultimate-reviews'); ?></div>
				<div class="ewd-urp-welcome-clear"></div>
				<div class="ewd-urp-welcome-screen-show-created-categories">
					<h3><?php _e('Created Categories:', 'ultimate-reviews'); ?></h3>
					<div class="ewd-urp-welcome-screen-show-created-categories-name"><?php _e('Name', 'ultimate-reviews'); ?></div>
					<div class="ewd-urp-welcome-screen-show-created-categories-description"><?php _e('Description', 'ultimate-reviews'); ?></div>
				</div>
			</div>
			<div class='ewd-urp-welcome-screen-previous-button ewd-urp-welcome-screen-previous-button-not-top-margin' data-previousaction='options'><?php _e('Previous Step', 'ultimate-reviews'); ?></div>
			<div class='ewd-urp-welcome-screen-finish-button'><a href='admin.php?page=EWD-URP-Options'><?php _e('Finish', 'ultimate-faqs'); ?></a></div>
			<div class='clear'></div>
		</div>
	</div>

	<div class='ewd-urp-welcome-screen-skip-container'>
		<a href='admin.php?page=EWD-URP-Options'><div class='ewd-urp-welcome-screen-skip-button'><?php _e('Skip Setup', 'ultimate-reviews'); ?></div></a>
	</div>
</div>
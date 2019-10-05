<?php
 /**
 * Adds a box to the main column on the Post and Page edit screens.
 */

if(!function_exists('aw_ui_cm_add_custom_box')) 
{

	function aw_ui_cm_add_custom_box() {
		
		$screens = Monoframe::get_awesome_post_type();
		$context='advanced';
		if(class_exists('Monoframe'))
		{
			$context='monoframe_pre_editor';
		}
		foreach ( $screens as $screen ) {
			
			add_meta_box(
				'aw_ui_codemirror',
			   'UI Code',
				'aw_ui_codemirror_int',
				$screen,$context,'high'
			);
		}
	}
	add_action( 'add_meta_boxes', 'aw_ui_cm_add_custom_box' );

	/**
	 * Prints the box content.
	 *
	 * @param WP_Post $post The object for the current post/page.
	 */
	function aw_ui_codemirror_int( $post ) {

	  // Add an nonce field so we can check for it later.
	  wp_nonce_field( 'aw_ui_cm_custom_box', 'aw_ui_cm_custom_box_nonce' );

	  /*
	   * Use get_post_meta() to retrieve an existing value
	   * from the database and use the value for the form.
	   */
	//  $value = get_post_meta( $post->ID, '_my_meta_value_key', true );


	  echo'<style>
	  .postarea{display:none} 
	  .ace_editor.fullScreen {
			height: auto!important;
			width: auto!important;
			border: 0;
			margin: 0;
			position: fixed !important;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			z-index: 100000;
		}
		.fullScreen {
			overflow: hidden
		}</style>';
	  echo'<pre id="ace_ui_code" style="width:100%;height:30em" ></pre>';
	  $content=$post->post_content;
	  $content=str_replace('<','__lt__',$content);
	  echo '<textarea id="aw_ui_code" name="aw_ui_code" rows="20" cols="100" />'.$content.'</textarea>';

	wp_enqueue_script('ace', plugins_url( 'shortcodes/lib/ace/ace.js' , dirname(dirname(__FILE__) )));
	wp_enqueue_script('ace_ext', plugins_url( 'shortcodes/lib/ace/ext-language_tools.js' , dirname(dirname(__FILE__) )));
	wp_enqueue_script('awui_autocomplete', plugins_url( 'shortcodes/lib/ace/awui_autocomplete.js' ,dirname(dirname(__FILE__) ) ));

	echo "<script>
	window.onload = function() {
	ace.require('ace/ext/language_tools');
	var dom = ace.require('ace/lib/dom');

	//add command to all new editor instaces
	ace.require('ace/commands/default_commands').commands.push({
		name: 'Toggle Fullscreen',
		bindKey: 'F11',
		exec: function(editor) {
			var fullScreen = dom.toggleCssClass(document.body, 'fullScreen')
			if(fullScreen)
			{
				editor.setOption('maxLines', 44);
			}
			else
			{	
				editor.setOption('maxLines', 'Infinity');
			}	
			dom.setCssClass(editor.container, 'fullScreen', fullScreen)
			editor.setAutoScrollEditorIntoView(!fullScreen)
			editor.resize()
		}
	},
	{
		name: 'saveFileNoRefresh',
		bindKey: {
		win: 'Ctrl-S',
		mac: 'Command-S',
		sender: 'editor|cli'
		},
		exec: function(env, args, request) {
			var b = false;
				if(jQuery('input#update-no-refresh').length == 1){
					b=jQuery('input#update-no-refresh');
				}
				else if(jQuery('input#publish').length == 1)
				{
					b = jQuery('input#publish');
				}
				
				if(b != false)
				{
					b.click();
				}
		}
	},
	{
		name: 'saveFile',
		bindKey: {
		win: 'Ctrl-Shift-S',
		mac: 'Command-Shift-S',
		sender: 'editor|cli'
		},
		exec: function(env, args, request) {
			var b = false;
				if(jQuery('input#save-post').length == 1)
				{
					b = jQuery('input#save-post');
				}
				else if(jQuery('input#publish').length == 1)
				{
					b = jQuery('input#publish');
				}
				if(b != false)
				{
					//var n = e.target.nodeName.toLowerCase();
					//if(n == 'textarea' || n == 'input')
					//{
						b.click();
					//	return false;
					//}
				}
		}
	});

	var editor = ace.edit('ace_ui_code');
	var textarea = jQuery('#aw_ui_code');
	textarea.hide();

	editor.setTheme('ace/theme/merbivore_soft_awui');
	editor.getSession().setMode('ace/mode/awui');
	//autocomplete
		var Autocomplete = ace.require('ace/autocomplete').Autocomplete;
		editor.completer = new Autocomplete;
		//editor.completer.keyboardHandler.removeCommand('Tab');
		editor.completer.liveAutocompletionAutoSelect = true;
		editor.completer.exactMatch = true;
		
		var shifteditCompleter = {
			getCompletions : function (editor, session, pos, prefix, callback) {
				var completions = (new shiftedit.autocomplete).run(editor, session, pos, prefix, callback, prefix !== '');
				if (completions) {
					callback(null, completions)
				}
			},
			getDocTooltip : function (selected) {
				if (selected.doc) {
					return {
						docHTML : selected.doc
					}
				}
			}
		};
		editor.completers = [shifteditCompleter]


	editor.setOptions({
		maxLines: Infinity,
		enableBasicAutocompletion: true,
		enableSnippets: true,
		enableLiveAutocompletion: true,
		autoScrollEditorIntoView: true
	});
	editor.getSession().setUseWrapMode('true');
	editor.getSession().setTabSize(2);
	editor.getSession().setUseSoftTabs(true);
	var content=textarea.val();
	content=content.replace(/__lt__/g, '<');
	editor.getSession().setValue(content);
	textarea.val(editor.getSession().getValue());
	editor.getSession().on('change', function(){
	  textarea.val(editor.getSession().getValue());
	});		
	}	

	</script>";

	}

	/**
	 * When the post is saved, saves our custom data.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	function aw_ui_cm_save_postdata( $post_id ) {

	  /*
	   * We need to verify this came from the our screen and with proper authorization,
	   * because save_post can be triggered at other times.
	   */
	  global $aw_post_type;
	  // Check if our nonce is set.
	  if ( ! isset( $_POST['aw_ui_cm_custom_box_nonce'] ) )
		return $post_id;

	  $nonce = $_POST['aw_ui_cm_custom_box_nonce'];

	  // Verify that the nonce is valid.
	  if ( ! wp_verify_nonce( $nonce, 'aw_ui_cm_custom_box' ) )
		  return $post_id;

	  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
	  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		  return $post_id;

	  // Check the user's permissions. //,'aw2_component','aw2_module','aw2_page'
	  /*if ( 'aw_block' == $_POST['post_type'] || 'ui_block' == $_POST['post_type'] || 'aw2_query' == $_POST['post_type']|| 'aw2_component' == $_POST['post_type']|| 'aw2_module' == $_POST['post_type']|| 'aw2_page' == $_POST['post_type']|| 'aw2_core' == $_POST['post_type']|| 'aw2_data' == $_POST['post_type']) {*/
	  if ( in_array($_POST['post_type'], Monoframe::get_awesome_post_type())) {

		if ( ! current_user_can( 'edit_page', $post_id ) )
			return $post_id;

	  } else {
			return $post_id;
	  }

	  /* OK, its safe for us to save the data now. */

	  // Sanitize user input.
	  
	  // Update the meta field in the database.
	  // unhook this function so it doesn't loop infinitely
			remove_action('save_post', 'aw_ui_cm_save_postdata');

	  // Update post 37
	  $my_post = array(
		  'ID'           => $post_id,
		  'post_content' => $_POST['aw_ui_code']
	  );

	// Update the post into the database
	  wp_update_post( $my_post );

	  // re-hook this function
			add_action('save_post', 'aw_ui_cm_save_postdata');
	}
	add_action( 'save_post', 'aw_ui_cm_save_postdata' );

	add_action( 'post_submitbox_start', 'aw_ui_cm_custom_button' );

	function aw_ui_cm_custom_button(){
		global $post;

		if ( Monoframe::is_awesome_post_type($post)) 
		{
			if ( in_array( $post->post_status, array('publish', 'future', 'private') ) && 0 != $post->ID ) {
				echo "<div style='text-align:center;margin-bottom:10px;'><span id='uwrspin' class='spinner'></span><input type='button' class='button button-primary button-large' value='Update Without Refresh' id='update-no-refresh' onclick='save_aw_block()'></div>
				<script>
					function save_aw_block(){
						var aw_ui_code=jQuery('#aw_ui_code').val();
						var post_id=jQuery('#post_ID').val();
						jQuery('#uwrspin').addClass('is-active');
						jQuery.post(
							ajaxurl,
							{action:'aw2_codeeditor_update',aw_ui_code:jQuery('#aw_ui_code').val(),post_id:post_id},
							function(data){
									jQuery('#uwrspin').removeClass('is-active');
								}
							);
					}
				</script>
				
				";
			}
		}	
	}

	add_action('wp_ajax_aw2_codeeditor_update', 'ui_cm_save_without_refersh');
	function ui_cm_save_without_refersh(){
		  // Update post 37
		if(intval($_POST['post_id']))
		{  
			$my_post = array(
			  'ID'           => $_POST['post_id'],
			  'post_content' => $_POST['aw_ui_code']
			);

			// Update the post into the database
			wp_update_post( $my_post );
		}  
	}

}

add_action( 'cmb2_admin_init', 'aw2_studio_cmb2_metaboxes' );

function aw2_studio_cmb2_metaboxes(){

    /**
     * Initiate the metabox
     */
	$post_types=array( 'aw2_module' );
	$registered_apps = &aw2_library::get_array_ref('apps');
	foreach($registered_apps as $key=>$app) {
		$post_types[]=$app->default_modules;
	} 
    $cmb = new_cmb2_box( array(
        'id'            => 'additional-info ',
        'title'         => __( 'Additional Info', 'cmb2' ),
        'object_types'  => $post_types, // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
		'closed'     => true, // Keep the metabox closed by default
    ) );
//display title
//installation code
//form fileds
//help?
    // Regular text field
    $cmb->add_field( array(
        'name'       => __( 'Display Title', 'cmb2' ),
        'desc'       => __( 'Alternative or display title for your module, it is used at vaiours places if avilabe', 'cmb2' ),
        'id'         => '_display_title',
        'type'       => 'text'
    ) );

    $cmb->add_field( array(
		'name' => __( 'Dependency Installation Code', 'cmb2' ),
		'desc' => __( 'JSON object of all dependent modules', 'cmb2' ),
		'id'   => '_installation',
		'default' => '',
		'after_field' => 'Sample: {
    "install": [
        {
            "trigger": "lazy-load-js"
        },
        {
            "module": "support"
        }
    ]
}',
		'type' => 'textarea_code',
	) );
	
	$cmb->add_field( array(
		'name' => __( 'Local Parameter Fields', 'cmb2' ),
		'desc' => __( 'JSON obejct of CMB2 form fields for local variables used by this module', 'cmb2' ),
		'id'   => '_params',
		'default' => '',
		'after_field' => 'Sample: [
	{ "name":"Designation", "id" : "testimonial_designation", "desc":"custom class names that you want to apply the outer box", "type":"text" },
	{ "name":"Company Name", "id" : "testimonial_company", "desc":"custom class names that you want to apply the outer box", "type":"text" } 
]',
		'type' => 'textarea_code',
	) );
}
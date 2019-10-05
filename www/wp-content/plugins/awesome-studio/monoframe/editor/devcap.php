<?php
add_action('admin_init' ,'awesome_ui_cap');
function awesome_ui_cap(){
	 global $user_ID;
	add_action( 'show_user_profile', 'awesome_ui_user_profile_fields' );
	add_action( 'edit_user_profile', 'awesome_ui_user_profile_fields' );
	add_action( 'profile_update',  'awesome_ui_save_profile_update' );

	add_filter( 'manage_users_columns', 'awesome_ui_manage_users_columns' );
	add_filter( 'manage_users_custom_column', 'awesome_ui_manage_users_custom_column', 10, 3 );
 
   
}		

function remove_menus(){
  
 	if ( !current_user_can( 'develop_for_awesomeui' ) ) {
		remove_menu_page( 'edit.php?post_type=aw_block' );
		remove_menu_page( 'edit.php?post_type=ui_block' );
		remove_menu_page( 'edit.php?post_type=aw2_query' );
		remove_menu_page( 'edit.php?post_type=aw2_core' );
		remove_menu_page( 'edit.php?post_type=aw2_page' );
		remove_menu_page( 'edit.php?post_type=aw2_module' );
		remove_menu_page( 'edit.php?post_type=aw2_component' );
		remove_menu_page( 'edit.php?post_type=aw2_data' );
    }
  
}
add_action( 'admin_menu', 'remove_menus' );

function awesome_ui_save_profile_update( $user_id ) {
		global $wp_roles;
		if ( ! is_super_admin() && ! current_user_can( 'manage_options' ) )
			return;

		if ( empty( $user_id ) )
			return;
		//get user for adding/removing role
		$user = new WP_User( $user_id );
		
		if ( ! isset( $_POST['wpoets_dev_cap'] ) )
		{
			update_user_meta( $user->ID, 'develop_for_awesomeui', 'nope');
			$user->remove_cap( 'develop_for_awesomeui' );
			return;
		}

		//add new role to user
		if ( ! empty( $_POST['wpoets_dev_cap'] ) )
		{	
			update_user_meta( $user->ID, 'develop_for_awesomeui', 'yes');
			foreach($_POST['wpoets_dev_cap'] as $cap){
				$user->add_cap( $cap);
			}
		}
		return;
	}
	
function awesome_ui_user_profile_fields( $user ) {
		global $wp_roles;

		if ( ! is_super_admin() && ! current_user_can( 'manage_options' ) )
			return;
		//print_r($user);
		$checked='';
		if(user_can( $user->ID, 'develop_for_awesomeui' )	)
			$checked='checked="checked"';
			
		?>
		    <h3>Awesome UI Control</h3>
		    <table class="form-table">
		        <tr>
		            <th>
		                <label for="wpoets_dev_cap">Awesome UI Permissions</label>
					</th>
		            <td>
						<input type='checkbox' value='develop_for_awesomeui' name='wpoets_dev_cap[]' <?php echo $checked; ?> id='wpoets_dev_cap'>Grant Developer Access
		                <p class="description">This allows user to see and manage Awesome UI Components</p>
		            </td>
		        </tr>
		    </table>
		<?php
}
function awesome_ui_manage_users_columns( $columns ) {

	$columns[ 'wpoets_role' ] ='Awesome UI Role';
	return $columns;
}

function awesome_ui_manage_users_custom_column( $value, $column_name, $user_id ) {
	global $wp_roles;

	if ( 'wpoets_role' != $column_name )
		return $value;

	//$user = get_userdata( $user_id );
	if ( user_can( $user_id, 'develop_for_awesomeui' ) ) {
		$value='Developer Access';
	}

	return $value;
}

function awesome_ui_super_admin_control($caps, $cap, $user_id, $args){
	global $wp_roles;
	if(is_multisite()){
		if ($user_id != 0) {
			$develop=get_user_meta( $user_id, 'develop_for_awesomeui',true);
			if($cap=='develop_for_awesomeui' && $develop != 'yes') {
				//$role->add_cap($cap);
				 $caps[] = 'do_not_allow';
			}		
		}
	}
	return $caps;
}

add_filter('map_meta_cap', 'awesome_ui_super_admin_control', 10, 4);
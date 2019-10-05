<?php

aw2_library::add_shortcode('aw2','login_handler', 'awesome2_login_handler','Sign in a user');
function awesome2_login_handler($atts,$content=null,$shortcode){
	
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	extract( shortcode_atts( array(
		'main'          =>'',
		'type'      => ''
	), $atts) );
	
	$u=$_POST['username'];
	if($type=="email"){
		$user=get_user_by('email', $_POST['username']);
		if(!empty($user->user_login)){
			$u=$user->user_login;
		}
	}
 	$creds = array();
	$creds['user_login'] = $u;
	$creds['user_password'] = $_POST['pass'];
	
	if(array_key_exists('rememberme',$_POST))
		$creds['remember'] = true;

	$user = wp_signon( $creds, false );
	if ( is_wp_error($user) )
		$return_value= 'no';
	else
		$return_value= 'yes';
		
	if(aw2_library::set($atts,$return_value))return;
	return $return_value;
	
}

aw2_library::add_shortcode('aw2','reset_password', 'awesome2_reset_password','Reset password of the user');
function awesome2_reset_password($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	extract( shortcode_atts( array(
		'main'      => '',
		'pass'      => '',
		'email'		=> ''
	), $atts) );
	
	if($email=="" || $pass==""){
		return $return_value= 'no';
	}
 	$user = get_user_by( 'email', $email );
                
                $update_user = wp_update_user( array (
                        'ID' => $user->ID, 
                        'user_pass' => $pass
                    )
                );
                
                // if  update user return true then lets send user an email containing the new password
              
	if ( $update_user )
		$return_value= 'yes';
	else
		$return_value= 'no';
		
	if(aw2_library::set($atts,$return_value))return;
	return $return_value;
	
}

aw2_library::add_shortcode('aw2','register_handler', 'awesome2_register_handler','Register a new user');
function awesome2_register_handler($atts,$content=null,$shortcode)
{

if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;

	extract( shortcode_atts( array(
		'main'          =>'',
		'user_role'      => ''
	), $atts) );


	$user_login   	=   sanitize_user( $_POST['user_login'] );
	
	$user_pass   	=   esc_attr( $_POST['user_pass'] );
	$user_email     =   sanitize_email( $_POST['user_email'] );
	if($user_login=="" ){$user_login=sanitize_user($user_email);}
	$website    	=   esc_url( $_POST['website'] );
	$user_first 	=   sanitize_text_field( $_POST['user_first'] );
	$user_last  	=   sanitize_text_field( $_POST['user_last'] );
      
	$error=0;
	$errmsg="";
	if(username_exists($user_login)) {
		// Username already registered
		$errmsg.='<div>Username already taken</div>';
		$error=1;
	}
	if(!validate_username($user_login)) {
		// invalid username
		$errmsg.='<div>Invalid username</div>';
		$error=1;
	}
	if($user_login == '') {
		// empty username
		$errmsg.='<div>Please enter a username</div>';
		$error=1;
	}
	if(!is_email($user_email)) {
		//invalid email
		$errmsg.='<div>Invalid email</div>';
		$error=1;
	}
	if(email_exists($user_email)) {
		//Email address already registered
		$errmsg.='<div>Email already registered</div>';
		$error=1;
	}
	if($user_pass == '') {
		// passwords do not match
		$errmsg.='<div>Please enter a password</div>';
		$error=1;
	}
	if($error==1)
	{
		//if(aw2_library::set($atts,$errmsg))return;
		$return_value =$errmsg;
		if(aw2_library::set($atts,$return_value))return;
	return $return_value;
	}
	
	
	$new_user_id = wp_insert_user(array(
					'user_login'		=> $user_login,
					'user_pass'	 		=> $user_pass,
					'user_email'		=> $user_email,
					'first_name'		=> $user_first,
					'last_name'			=> $user_last,
					'user_registered'	=> date('Y-m-d H:i:s'),
					'user_url'			=> $website
				));
	if($user_role!=""){
		$u = new WP_User( $new_user_id );
		// Replace the current role with 'editor' role
		$u->set_role( $user_role );		
	}			
	
	
				
	foreach($_POST as $k => $v)
	{
		if(strstr( $k, "meta_" ))
		{
			add_user_meta( $new_user_id, $k,  $v, true  );
		}	
		
	}
	if ( $new_user_id ){
		wp_send_new_user_notifications( $new_user_id, $notify = 'admin' );	
		$return_value= 'yes';
	}else{
		$return_value= 'no';
	}	
	aw2_library::set('new_user_id',$new_user_id);
	if(aw2_library::set($atts,$return_value))return;
	return $return_value;
}	
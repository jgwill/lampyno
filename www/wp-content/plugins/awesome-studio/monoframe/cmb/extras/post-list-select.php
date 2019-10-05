<?php

/**
 * Gets a number of posts and displays them as options
 * @param  array $query_args Optional. Overrides defaults.
 * @return array             An array of options that matches the CMB2 options array
 */
function cmb2_get_post_options( $field ) {

	$query_args = $field->args['query_args'];
    $args = wp_parse_args( $query_args, array(
        'post_type'   => 'post'
    ) );

    $posts = get_posts( $args );

    $post_options = array('-1'=>'Select an option');
    if ( $posts ) {
        foreach ( $posts as $post ) {
          $post_options[ $post->post_name ] = $post->post_title;
        }
    }

    return $post_options;
}


/**
 * Gets registered post types and taxonomies
 * @param  array $query_args Optional. Overrides defaults.
 * @return array             An array of options that matches the CMB2 options array
 */
function cmb2_get_registered_objects( $field ) {

	$return_value=array();
	$object_type = $field->args['object_type'];

	if($object_type=="post_types"){
		$args = wp_parse_args( $field->args['args'], array(
		    '_builtin' => false
		));

		$post_types=get_post_types( $args, 'objects' );
		//util::var_dump($post_types);
		foreach($post_types as $key=>$post_type){
			$return_value[ $key ] = $post_type->labels->name;
		}
		return $return_value;
	}

	if($object_type=="taxonomies"){
		$args = wp_parse_args( $field->args['args'], array(
		    '_builtin' => false
		));


		$taxonomies = get_taxonomies( $args, 'objects' );
		foreach($taxonomies as $key=>$taxonomy){
			$return_value[ $key ] = $taxonomy->labels->name;
		}
		return $return_value;
	}

    return $return_value;
}


/**
 * Gets registered post types and taxonomies
 * @param  array $query_args Optional. Overrides defaults.
 * @return array             An array of options that matches the CMB2 options array
 */
function cmb2_get_user_roles( $field ) {

	global $wp_roles;

	$return_value=array();
	//$object_type = $field->args['object_type'];
    $roles = $wp_roles->get_names();
	foreach($roles as $key=>$role) {
		$return_value[ $key ] = $role;
	}
	return $return_value;
}

/**
 * Gets Mailchimp Lists
 * @param  array $query_args Optional. Overrides defaults.
 * @return array             An array of options that matches the CMB2 options array
 */
function monoframe_get_mailchimp_lists(){

	$transient_name = 'monomyth_mailchimp_list';
	$mailchimp_lists=array('select-list'=>'Select List');

		if(empty(aw2_library::get('site_settings.opt-mailchimp-api-key')))
			return $mailchimp_lists;

		$lists = get_transient( $transient_name );

		// got lists? if not, proceed with API call.
		if( ! is_array( $lists ) ) {

			// make api request for lists
			$api = new MC4WP_API( aw2_library::get('site_settings.opt-mailchimp-api-key') );
			$lists_data = $api->get_lists();

			if ( is_array( $lists_data ) ) {

				$lists = array();

				foreach ( $lists_data as $list ) {

					$lists["{$list->id}"] = (object) array(
						'id' => $list->id,
						'name' => $list->name,
						'subscriber_count' => $list->stats->member_count,
						'merge_vars' => array(),
						'interest_groupings' => array()
					);

					// only get interest groupings if list has some
					if( $list->stats->grouping_count > 0 ) {
						// get interest groupings
						$groupings_data = $api->get_list_groupings( $list->id );
						if ( $groupings_data ) {
							$lists["{$list->id}"]->interest_groupings = array_map( array( $this, 'strip_unnecessary_grouping_properties' ), $groupings_data );
						}
					}

				}

				// get merge vars for all lists at once
				$merge_vars_data = $api->get_lists_with_merge_vars( array_keys( $lists ) );
				if ( $merge_vars_data ) {
					foreach ( $merge_vars_data as $list ) {
						// add merge vars to list
						$lists["{$list->id}"]->merge_vars = $list->merge_vars ;
					}
				}

				// store lists in transients
				set_transient(  $transient_name, $lists, ( 24 * 3600 ) ); // 1 day
			}
		}

		foreach($lists as $list)
		{
			$mailchimp_lists[$list->id]=$list->name;
		}
		return $mailchimp_lists;
}


/**
 * Gets GetResponse Lists
 * @return array  An array of select options that matches the CMB2 options array
 */
function monoframe_get_response_lists(){

	$transient_name = 'monomyth_getresponse_list';
	$getresponse_lists = array( 'select-list' => 'Select GetResponse List' );

	if( empty ( aw2_library::get( 'site_settings.opt-getresponse-api-key' ) ) ) {
		return $getresponse_lists;
	}

	$lists = get_transient( $transient_name );

	// If Lists from transients is not an array then proceed with API call.
	if( ! is_array( $lists ) ) {
		$lists = array();

		// Make api request to retireve GetResponse lists.
		$getresponse_request = new GetResponse( aw2_library::get( 'site_settings.opt-getresponse-api-key' ) );

		// Get all GetResponse campaigns (lists).
		$lists_data = $getresponse_request->getCampaigns();

		// Check if getCampaigns retieves object, if yes which means there are lists available in GetResponse.
		if ( is_object( $lists_data ) ) {
			foreach ( $lists_data as $list ) {
				$lists["{$list->campaignId}"] = (object) array(
					'campaignId' => $list->campaignId,
					'name' => $list->name,
				);
		}

		// Store lists in transients For 1 day.
		set_transient( $transient_name, $lists, ( 24 * 3600 ) ); // 1 day
		}
	}

	foreach( $lists as $list ) {
		$getresponse_lists[ $list->campaignId ] = $list->name;
	}

	// Return Getresponse lists select options.
	return $getresponse_lists;
}

/**
 * Gets ElasticEmail Lists
 * @return array  An array of select options that matches the CMB2 options array
 */
function monoframe_elastic_email_lists(){

	$transient_name = 'monomyth_elasticemail_list';
	$elasticemail_lists = array( 'select-list' => 'Select Elastic Email List' );

	$plugin_path = dirname( plugin_dir_path( __DIR__ ) );

	// Include the ElasticEmailClient wrapper class.
	require_once ( $plugin_path . "/apis/ElasticEmailClient.php" );

	$api_key = aw2_library::get( "site_settings.opt-elasticemail-api-key" );
	$public_account_id = aw2_library::get( "site_settings.opt-elasticemail-public-account-id" );

	if( empty( $api_key ) || empty( $public_account_id ) ) {
		return $elasticemail_lists;
	}

	try {
		// Set the ElasticEmail Api Key. (Note: The API key is only required for setting the status of the contact)
		ElasticEmailClient\ApiClient::SetApiKey( $api_key );

		$lists = get_transient( $transient_name );

		// If Lists from transients is not an array then proceed with API call.
		if( ! is_array( $lists ) ) {
			$lists = array();

			// Make api request to retireve ElasticEmail lists.
			$elasticemail_list = new ElasticEmailClient\EEList();

			// Get all ElasticEmail (lists).
			$lists_data = $elasticemail_list->EElist();

	 // Check if ElasticEmail retrieves array, if yes which means there are lists available in ElasticEmail.
			if ( is_array( $lists_data ) ) {
				foreach ( $lists_data as $list ) {
					$lists["{$list->listid}"] = (object) array(
						'listid' => $list->listid,
						'listname' => $list->listname,
					);
			}

			// Store lists in transients For 1 day.
			set_transient( $transient_name, $lists, ( 24 * 3600 ) ); // 1 day
			}
		}
	} catch (Exception $elasticemail_api_error) {

		// If Exception is caught return empty list.
		return $elasticemail_lists;
	}

	// Build the ElasticEmail Dropdown list.
	foreach( $lists as $list ) {
		$elasticemail_lists[ $list->listname ] = $list->listname;
	}

	// Return ElasticEmail lists select options.
	return $elasticemail_lists;
}
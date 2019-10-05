<?php
aw2_library::add_shortcode('aw2','subscribe', 'awesome2_subscribe','Subscribe to third party newsletter service like mailchimp.');

function awesome2_subscribe($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;

	extract( shortcode_atts( array(
		'main' => null,
		'email' => null,
		'api_key' => null,
		'phone_no' => null,
		'senderid' => null,
		'campaign_id' => null,
		'list_id' => null,
		'list_name' => null,
		'public_account_id' => null
	), $atts, 'aw2_sms' ) );

	$return_val = '';
	if($main!=null){
		switch($main){
			case 'mailchimp':
				if(empty(aw2_library::get("site_settings.opt-mailchimp-api-key")))
					return 'Please Set Mailchimp API Key';
				/*
				$param = array('api_key' => aw2_library::get("site_settings.sms-api-key"),
					'phone_no' => '0'.$phone_no,
					'message' => aw2_library::parse_shortcode($content)
				); */

				$list_id=(isset($atts['list_id']) ? $atts['list_id'] :aw2_library::get("site_settings.opt-mailchimp-lists"));
				$email=(isset($atts['email']) ? $atts['email'] :'');
				$email_type=(isset($atts['email_type']) ? $atts['email_type'] :'html');
				$double_optin=(isset($atts['double_optin']) ? $atts['double_optin'] :false);
				$update_existing=(isset($atts['update_existing']) ? $atts['update_existing'] :true);
				$replace_interests=(isset($atts['replace_interests']) ? $atts['replace_interests'] :false);
				$send_welcome=(isset($atts['send_welcome']) ? $atts['send_welcome'] :false);

				$args=aw2_library::get_clean_args($content,$atts);
				$merge_vars=array_change_key_case($args, CASE_UPPER);

				$api_key=(isset($atts['api_key']) ? $atts['api_key'] :aw2_library::get("site_settings.opt-mailchimp-api-key"));
				$api = new MC4WP_API($api_key);
				$result = $api->subscribe( $list_id, $email, $merge_vars, $email_type,$double_optin, $update_existing, $replace_interests, $send_welcome);
				$return_val="";
				if ( $result !== true && $api->has_error() ) {
					$return_val=sprintf( 'MailChimp for WordPress : %s', date( 'Y-m-d H:i:s' ), $api->get_error_message() );
					error_log( $return_val );
				}

				return $return_val;
			break;

			case 'getresponse':
				if( empty( aw2_library::get( "site_settings.opt-getresponse-api-key" ) ) ) {
					return 'Please Set GetResponse API Key';
				}

				$email = ( isset( $atts['email'] ) ? $atts['email'] : '' );

				// Get the api key if passed from shortcode otherwise from get it from site settings.
				$getresponse_api_key = ( isset( $atts['api_key'] ) ? $atts['api_key'] : aw2_library::get( "site_settings.opt-getresponse-api-key" ) );

				// Get the campaign Id (List token from getresponse list/ contact )
				$getresponse_campaign_id = ( isset( $atts['campaign_id'] ) ? $atts['campaign_id'] : aw2_library::get( "site_settings.opt-getresponse-campaign-id" ) );

				$args = aw2_library::get_clean_args( $content, $atts );

				$getresponse_add_contact_params = array(
													'email'    => $email,
													'campaign' => array( 'campaignId' => $getresponse_campaign_id ),
												);

				// Lets create a GetResponse API Object.
				$getresponse_request = new GetResponse( $getresponse_api_key );

				// If args variable is not empty, which means JSON data is passed.
				if( ! empty( $args ) ) {

					// $args keys should be lower case since GetResponse expects it.
					$args = array_change_key_case( $args, CASE_LOWER );

					// Retrive all Custom fields both Predefined and custom created from Getresponse API.
					$getresponse_all_custom_fields = $getresponse_request->getCustomFields( array( 'fields' => 'name' ) );

					//customFieldValues is an aray for more information see https://github.com/GetResponse/getresponse-api-php
					$getresponse_add_contact_params['customFieldValues'] = array();

					// Loop through all the Custom fields from GetResponse and check if the key matches with data passed from JSON object.
					foreach( $getresponse_all_custom_fields as $getresponse_custom_field) {

						if( array_key_exists( $getresponse_custom_field->name, $args ) ) {
								$getresponse_add_contact_params['customFieldValues'][] = array(
																							'customFieldId' => $getresponse_custom_field->customFieldId,
																							'value' => array(
																								$args[ $getresponse_custom_field->name ]
																						)
								);
							}
					}
				}

				// Make the request to GetResponse for Adding a contact.
				$response = $getresponse_request->addContact( $getresponse_add_contact_params );

				/**
				 * If $response->code is not empty, then there is error.
				 */
				if ( ! empty( $response->code )  ) {
					// Log the Error message for debugging purposes.
					$return_val = sprintf('GetResponse Error for WordPress : %s, httpStatus=%s,  code=%s, codeDescription=%s, message=%s', date( 'Y-m-d H:i:s' ), $response->httpStatus, $response->code, $response->codeDescription, $response->message );
					error_log( $return_val );
				}

				$return_val = aw2_library::post_actions( 'all', $return_val, $atts );
				return $return_val;
			break;
			case 'sendinblue':

			break;
			case 'elasticemail':
				if( empty( aw2_library::get( "site_settings.opt-elasticemail-api-key" ) ) || empty( aw2_library::get( "site_settings.opt-elasticemail-public-account-id" ) ) ) {
					return 'Please Set Elastic Email API Key or Elastic Email Public Account Id';
				}

				$plugin_path = dirname( plugin_dir_path( __DIR__ ) );

				// Include the ElasticEmailClient wrapper class.
				require_once ($plugin_path."/monoframe/apis/ElasticEmailClient.php");

				// Get the api key if passed from shortcode otherwise from get it from site settings. API key is only needed for changing the Contact status to active.
				$api_key = ( isset( $atts['api_key'] ) ? $atts['api_key'] : aw2_library::get( "site_settings.opt-elasticemail-api-key" ) );

				$email = ( isset( $atts['email'] ) ? $atts['email'] : '' );

				// ElasticEmail expects List name for which the contact is to be added.
				$list_name = ( isset( $atts['list_name'] ) ? array( $atts['list_name'] ) : array( aw2_library::get( "site_settings.opt-elasticemail-list-name" ) ) );

				// Get all the args ( Passed as JSON object ).
				$args = aw2_library::get_clean_args( $content, $atts);

				// Public Account Id is used instead of, API key for Adding contact.
				$public_account_id = ( isset( $atts['public_account_id'] ) ? $atts['public_account_id'] : aw2_library::get( "site_settings.opt-elasticemail-public-account-id" ) );

				// If args variable is not empty, which means JSON data is passed.
				if( ! empty( $args ) ) {
					// $args keys should be lowercase since ElasticEmail expects it.
					$args = array_change_key_case( $args, CASE_LOWER );

					// If following default args are set, pass it to Add() contact nmethod of ElasticEmailClient.
					$public_list_id = ( isset( $args['public_list_id'] ) ? $args['public_list_id'] : array() );
					$title = ( isset( $args['title'] ) ? $args['title'] : null );
					$first_name = ( isset( $args['first_name'] ) ? $args['first_name'] : null );
					$last_name = ( isset( $args['last_name'] ) ? $args['last_name'] : null );
					$phone = ( isset( $args['phone'] ) ? $args['phone'] :null );
					$mobile_number = ( isset( $args['mob_no'] ) ? $args['mob_no'] : null );
					$notes = ( isset( $args['notes'] ) ? $args['notes'] : null );
					$gender = ( isset( $args['gender'] ) ? $args['gender'] : null );
					$birth_date = ( isset( $args['birth_date'] ) ? $args['birth_date'] : null );
					$city = ( isset( $args['city'] ) ? $args['city'] : null );
					$state = ( isset( $args['state'] ) ? $args['state'] : null );
					$postal_code = ( isset( $args['postal_code'] ) ? $args['postal_code'] : null );
					$country = ( isset( $args['country'] ) ? $args['country'] : null );
					$organization_name = ( isset( $args['organization_name'] ) ? $args['organization_name'] : null );
					$website = ( isset( $args['website'] ) ? $args['website'] : null );
					$annual_revenue = ( isset( $args['annual_revenue'] ) ? $args['annual_revenue'] : null );
					$industry = ( isset( $args['industry'] ) ? $args['industry'] : null );
					$number_of_employees = ( isset( $args['number_of_employees'] ) ? $args['number_of_employees'] : null );
					$source = ( isset( $args['source'] ) ? $args['source'] : null ); // ApiTypes\ContactSource::ContactApi
					$return_url = ( isset( $args['return_	url'] ) ? $args['return_url'] : null );
					$source_url = ( isset( $args['source_url'] ) ? $args['source_url'] : null );
					$activation_return_url = ( isset( $args['activation_return_url'] ) ? $args['activation_return_url'] : null );
					$activation_template = ( isset( $args['activation_template'] ) ? $args['activation_template'] : null );
					$send_activation = ( isset( $args['send_activation'] ) ? $args['send_activation'] : false );
					$consent_date = ( isset( $args['consent_date'] ) ? $args['consent_date'] : null );
					$consent_ip = ( isset( $args['consent_ip'] ) ? $args['consent_ip'] : null );
					$notify_email = ( isset( $args['notify_email'] ) ? $args['notify_email'] : null );

					// Elastic Email has following Contact meta data by default, additional metadata if required is to be passed to $args parameter of Add() method.
					$remove_keys_for_sending_extra_fields = array( 'first_name', 'last_name', 'phone', 'mob_no', 'city', 'state', 'postal_code', 'country', 'organization_name', 'website' );

					// Remove the default metadata of ElasticEmail contact. Additional metadata is to be passed to $args parameter of Add() method.
					foreach( $remove_keys_for_sending_extra_fields as $remove_key ) {
						if( array_key_exists( $remove_key, $args ) ) {
							unset( $args[ $remove_key ] );
						}
					}
				} else {
					$args = array();
				}

				// Create a new Contact object.
				$contact = new ElasticEmailClient\Contact();

				// Set the ElasticEmail Api Key. (Note: The API key is only required for setting the status of the contact)
				ElasticEmailClient\ApiClient::SetApiKey( $api_key );

				$return_val="";

				try {

					// Add the contact to ElasticEmail.
					$result = $contact->Add( $public_account_id,
											 $email,
											 $public_list_id,
											 $list_name,
											 $title,
											 $first_name,
											 $last_name,
											 $phone,
											 $mobile_number,
											 $notes,
											 $gender,
											 $birth_date,
											 $city,
											 $state,
											 $postal_code,
											 $country,
											 $organization_name,
											 $website,
											 $annual_revenue,
											 $industry,
											 $number_of_employees,
											 $source,
											 $return_url,
											 $source_url,
											 $activation_return_url,
											 $activation_template,
											 $send_activation,
											 $consent_date,
											 $consent_ip,
											 $args,
											 $notify_emails
											);

						// Make the status 'Active' of the newly created contact.
						$contact->ChangeStatus( 'Active', null, array( $email ) );

				} catch (Exception $elasticemail_api_error) {

					// If Exception is caught log it.
					$return_val = $elasticemail_api_error->getMessage();
					error_log( $return_val );
				}

				$return_val = aw2_library::post_actions( 'all', $return_val, $atts );
				return $return_val;

			break;
		}
	}
}
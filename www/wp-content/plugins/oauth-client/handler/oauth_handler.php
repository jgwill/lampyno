<?php

class Mo_OAuth_Hanlder {
	
	function getAccessToken($tokenendpoint, $grant_type, $clientid, $clientsecret, $code, $redirect_url){
		
		$response   = wp_remote_post( $tokenendpoint, array(
			'method'      => 'POST',
			'timeout'     => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => array(),
			'body'        => array(
				'grant_type'    => 'authorization_code',
				'code'          => $code,
				'client_id'     => $clientid,
				'client_secret' => $clientsecret,
				'redirect_uri'  => $redirect_url
			),
			'cookies'     => array(),
			'sslverify'   => false
		) );

		$response =  $response['body'] ;

		if(!is_array(json_decode($response, true))){
			echo "<b>Response : </b><br>";print_r($response);echo "<br><br>";
			exit("Invalid response received.");
		}
		
		$content = json_decode($response,true);
		if(isset($content["error_description"])){
			exit($content["error_description"]);
		} else if(isset($content["error"])){
			exit($content["error"]);
		} else if(isset($content["access_token"])) {
			$access_token = $content["access_token"];
		} else {
			echo "<b>Response : </b><br>";print_r($content);echo "<br><br>";
			exit('Invalid response received from OAuth Provider. Contact your administrator for more details.');
		}
		
		return $access_token;
	}
	
	function getResourceOwner($resourceownerdetailsurl, $access_token){
		$response   = wp_remote_post( $resourceownerdetailsurl, array(
			'method'      => 'GET',
			'timeout'     => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => array(
				'Authorization' => 'Bearer '.$access_token
			),
			'cookies'     => array(),
			'sslverify'   => false
		) );

		$response =  $response['body'];

		if(!is_array(json_decode($response, true))){
			echo "<b>Response : </b><br>";print_r($response);echo "<br><br>";
			exit("Invalid response received.");
		}
		
		$content = json_decode($response,true);
		if(isset($content["error_description"])){
			exit($content["error_description"]);
		} else if(isset($content["error"])){
			exit($content["error"]);
		}

		return $content;
	}
	
	function getResponse($url){
		$response = wp_remote_get($url, array(
			'method' => 'GET',
			'timeout' => 45,
			'redirection' => 5,
			'httpversion' => 1.0,
			'blocking' => true,
			'headers' => array(),
			'cookies' => array(),
			'sslverify' => false,
		));
		
		$response =  $response['body'];
		$content = json_decode($response,true);
		if(isset($content["error_description"])){
			exit($content["error_description"]);
		} else if(isset($content["error"])){
			exit($content["error"]);
		}
		
		return $content;
	}
	
}

?>
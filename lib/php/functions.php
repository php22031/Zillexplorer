<?php
/*
 * Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com
 */
 




//////////////////////////////////////////////////////////

function strip_0x($request) {
	
return ( substr($request, 0, 2) == '0x' ? ltrim($request, '0x') : $request );

}

//////////////////////////////////////////////////////////

function sanitize_request($request) {

$request = trim($request);
$request = htmlentities( $request , ENT_QUOTES );
//$request = mysql_real_escape_string($request); // Requires a db connection
$request = mysql_escape_string($request);

return $request;

}

//////////////////////////////////////////////////////////

function zill_node_api($request) {

return get_data('array', $request);

}

//////////////////////////////////////////////////////////
function get_data($mode, $request) {

global $version, $user_agent, $api_server, $api_timeout;

$cookie_jar = tempnam('/tmp','cookie');
	
// To avoid duplicate requests in current update session, AND cache data
$hash_check = ( $mode == 'array' ? md5(serialize($request)) : md5($request) );


	if ( !$_SESSION['api_cache'][$hash_check] ) {	
	
	$ch = curl_init( ( $mode == 'array' ? $api_server : '' ) );
	
		if ( $mode == 'array' ) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($request) );
		}
		elseif ( $mode == 'url' ) {
		curl_setopt($ch, CURLOPT_URL, $request);
		}
	
	curl_setopt($c, CURLOPT_COOKIEJAR, $cookie_jar);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
	
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $api_timeout);
	curl_setopt($ch, CURLOPT_TIMEOUT, $api_timeout);
	
	$data = curl_exec($ch);
	
		if ( !$data ) {
		$data = 'no';
		$_SESSION['get_data_error'] .= ' No data returned from request "' . $request . '" (with timeout configuration setting of ' . $api_timeout . ' seconds). <br /> ';
		}
		
		elseif ( preg_match("/coinmarketcap/i", $url) && !preg_match("/last_updated/i", $data) ) {
		$_SESSION['get_data_error'] .= '##REQUEST## data error response from '.$request.': <br /> =================================== <br />' . $data . ' <br /> =================================== <br />';
		}
	
	
	curl_close($ch);
	unlink($cookie_jar) or die("Can't unlink $cookie_jar");
	
	$_SESSION['api_cache'][$hash_check] = $data; // Cache API data for this update session
	
	// DEBUGGING ONLY
	//$_SESSION['get_data_error'] .= '##REQUEST## Requested data "' . $request . '". <br /> ';
	
	}
	else {
		
	$data = $_SESSION['api_cache'][$hash_check];
	
	// DEBUGGING ONLY
	//$_SESSION['get_data_error'] .= ' ##DUPLICATE## request ignored for data "' . $request . '". <br /> ';
	
	
	}
	
	
return $data;


}
//////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////

function trim_array($data) {

        foreach ( $data as $key => $value ) {
        $data[$key] = trim(remove_formatting($value));
        }
        
return $data;

}
//////////////////////////////////////////////////////////

function remove_formatting($data) {

$data = preg_replace("/ /i", "", $data); // Space
$data = preg_replace("/ /i", "", $data); // Tab
$data = preg_replace("/,/i", "", $data); // Comma
        
return $data;

}
//////////////////////////////////////////////////////////




?>
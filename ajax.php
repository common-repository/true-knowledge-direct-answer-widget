<?php
/*
 * This script simply wraps the call to the True Knowledge Direct Answer API using curl.
 */
// create new curl wrapper
$curl = curl_init();

// load wordpress config for options.
include_once('../../../wp-config.php');

// load the option
$data = get_option('tk_api_details');

// create the request url
$url = "http://api.trueknowledge.com/direct_answer?question=" . urlencode($_REQUEST['question']) . "&structured_reponse=0&api_account_id=" . $data['username'] . "&api_password=" . $data['password'];

// setup the curl options
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // API has redirects

// execute request and return response to browser
curl_exec($curl);

// close curl resource
curl_close($curl);

?>
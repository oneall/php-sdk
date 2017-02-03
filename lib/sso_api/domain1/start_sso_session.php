<?php
/**
 * Copyright 2011-2017 OneAll, LLC.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 *
 */

// HTTP Handler and Configuration
include '../../assets/config.php';

// Single Sign-On \ Start SSO Session for identity
// https://docs.oneall.com/api/resources/sso/identity/start-session/

// Identity token
$identity_token = 'a8acded5-db65-44ee-8e8e-2067057d1067';

// SSO Realm (If changed, they have also to be modified in check_sso_session.php on domain2)
$top_realm = 'vegetables';
$sub_realm = 'tomato';

// SSO session lifetime in seconds
$lifetime = 86400;

// Data Structure
$data = array(
	'request' => array(
		'sso_session' => array(
			'top_realm' => $top_realm,
			'sub_realm' => $sub_realm,
			'lifetime' => $lifetime 
		) 
	) 
);

// Encode structure
$request_structure_json = json_encode ($data);

// Make Request
$oneall_curly->put (SITE_DOMAIN . "/sso/sessions/identities/".$identity_token.".json", $request_structure_json);
$result = $oneall_curly->get_result ();

// Success
if ($result->http_code == 201)
{
	// Read the result
	$body = json_decode ($result->body);

	// Extract the SSO session token
	$sso_session_token = $body->response->result->data->sso_session->sso_session_token;
	
	// Build the redirect url
	$protocol = (!empty ($_SERVER ['HTTPS']) && $_SERVER ['HTTPS'] !== 'off' || $_SERVER ['SERVER_PORT'] == 443) ? "https://" : "http://";
	$url = $protocol . ($_SERVER ['HTTP_HOST'] . dirname ($_SERVER ['REQUEST_URI'])) . '/set_sso_session_cookie.php?sso_session_token=' . $sso_session_token;
		
	// Redirect to the page that sets the SSO cookie
	header ("Location: " . $url);
}
// Error
else
{
	echo "<h1>Error " . $result->http_code . "</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
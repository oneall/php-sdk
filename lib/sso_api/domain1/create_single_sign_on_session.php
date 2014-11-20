<?php
/**
 * Copyright 2012 OneAll, LLC.
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
include '../assets/config.php';

// User token
$user_token = 'b8551e23-49e0-4f1a-9f34-090011f67fb8';

// Identity token
$identity_token = '45de5526-5022-4019-9d47-ed02f04bdff5';

// SSO Realm
$top_realm = 'main';
$sub_realm = '';

// After how many seconds will the SSO session timeout?
$lifetime = 86400;

// Data Structure
$data = array (
	'request' => array (
		'sso_session' => array (
			'user_token' => $user_token,
			'identity_token' => $identity_token,
			'top_realm' => $top_realm,
			'sub_realm' => $sub_realm
		)
	)
);

// Encode structure
$request_structure_json = json_encode ($data);

// Make Request
$oneall_curly->put (SITE_DOMAIN . "/sso/sessions.json", $request_structure_json);
$result = $oneall_curly->get_result ();

//Success
if (in_array ($result->http_code, array (200, 201)))
{
	// Read the result
	$body = json_decode ($result->body);

	// Extract the SSO session token
	$sso_session_token = $body->response->result->data->sso_session->sso_session_token;

	// Build the redirect url
	$protocol = (! empty ($_SERVER ['HTTPS']) && $_SERVER ['HTTPS'] !== 'off' || $_SERVER ['SERVER_PORT'] == 443) ? "https://" : "http://";
	$url = $protocol . ($_SERVER ['SERVER_NAME'] . dirname ($_SERVER ['REQUEST_URI'])) . '/set_sso_session_cookie.php?sso_session_token=' . $sso_session_token;

	// Set the SSO cookie
	header ("Location: " . $url);
}
// Error
else
{
	echo "<h1>Error " . $result->http_code . "</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}

?>
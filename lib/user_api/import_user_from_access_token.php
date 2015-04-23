<?php
/**
 * Copyright 2014 OneAll, LLC.
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

// Users \ Import a user using his access token from a social network
// http://docs.oneall.com/api/resources/users/import-user/

// Facebook
// $provider_key = 'facebook';
// $provider_access_token_key = '<replace_by_your_access_token>';
// $provider_access_token_secret = ''; //Not used by Facebook

// Twitter
$provider_key = 'twitter';
$provider_access_token_key = ''; // Insert the access token> (Required)
$provider_access_token_secret = ''; // Insert the access token secret (Required)

//User
$user_token = ''; // Link the social network profile to this user_token (Optional)

// Message Structure
$structure = array (
	'request' => array (
		'user' => array (
			'action' => 'import_from_access_token',
			'user_token' => $user_token,
			'identity' => array (
				'source' => array (
					'key' => $provider_key,
					'access_token' => array (
						'key' => $provider_access_token_key,
						'secret' => $provider_access_token_secret
					)
				)
			)
		)
	)
);

// Encode structure
$structure_json = json_encode ($structure);

echo "<h1>Data</h1>";
echo "<pre>" . stripslashes (oneall_pretty_json::format_string ($structure_json)) . "</pre>";

// Make Request
$oneall_curly->put (SITE_DOMAIN . "/users.json", $structure_json);
$result = $oneall_curly->get_result ();

// Success
if ($result->http_code == 200)
{
	echo "<h1>Success " . $result->http_code . " (Existing user updated)</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
// Success
elseif ($result->http_code == 201)
{
	echo "<h1>Success " . $result->http_code . " (New user created)</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
// Error
else
{
	echo "<h1>Error " . $result->http_code . "</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}

?>
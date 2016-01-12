<?php
/**
 * Copyright 2015 OneAll, LLC.
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

// User \ Publish content to a user's social network account
// http://docs.oneall.com/api/resources/users/write-to-users-wall/

// Publish message for this user
$user_token = 'c1d82726-e81d-4e89-82af-fed19df8f64e';

// Publish message by using a publish_token (available on mobile devices)
$publish_token = '';

// Publish message on these social networks
$providers = array (
	'facebook'
);

// Message Structure
$message_structure = array (
	'request' => array (
		'message' => array (
			'action' => 'push_picture',				
			'parts' => array (
				'picture' => array (
					'url' => 'http://public.oneallcdn.com/img/oneall_header_logo.png',
					'caption' => 'My Picture',
					'target' => '10207703731045058'
				),
			),
			'providers' => $providers
		)
	)
);

// Encode structure
$request_structure_json = json_encode ($message_structure);

// Message
echo "<h1>Data</h1>";
echo "<pre>" . stripslashes (oneall_pretty_json::format_string ($request_structure_json)) . "</pre>";

// Use publish token (Available on mobile devices)
if (! empty ($publish_token))
{
	$oneall_curly->append_to_option ('HTTPHEADER', 'Authorization: OneAllPublishToken ' . $publish_token, true);
}

// Make Request
$oneall_curly->post (SITE_DOMAIN . "/users/" . $user_token . "/publish.json", $request_structure_json);
$result = $oneall_curly->get_result ();

// Success
if ($result->http_code == 200)
{
	echo "<h1>Success " . $result->http_code . "</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
// Error
else
{
	echo "<h1>Error " . $result->http_code . "</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}

?>
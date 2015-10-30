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

// Users \ Update a user stored the cloud-hosted database
// http://docs.oneall.com/api/resources/storage/users/update-user-details/

// Update the details of this user
$user_token = 'c32916bb-728f-468c-9e46-69527ec6b2d3';

// Message Structure
$structure = array (
	'request' => array (
		'user' => array (	
			'externalid' => '123456',
			'identity' => array (
				'emails' => array(
					array (
						'value' => 'test@test.de',
						'is_verified' => true						
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
$oneall_curly->post (SITE_DOMAIN . "/storage/users/".$user_token.".json", $structure_json);
$result = $oneall_curly->get_result ();

// Success
if ($result->http_code == 201)
{
	echo "<h1>Success " . $result->http_code . " (New cloud identity added)</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
// Success
elseif ($result->http_code == 200)
{
	echo "<h1>Success " . $result->http_code . " (Existing cloud identity updated)</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
// Error
else
{
	echo "<h1>Error " . $result->http_code . "</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}

?>
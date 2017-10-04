<?php
/**
 * Copyright 2016-Present OneAll, LLC.
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

// User Cloud Storage \ Update User
// https://docs.oneall.com/api/resources/storage/users/update-user/

// Identitiy structure available here:
// https://docs.oneall.com/api/basic/identity-structure/

// User Token
$user_token = '76ebb794-adbd-444c-98ad-322065455cdf';

// Replace Data?
$replace_data = false;

// Message Structure
$structure = array(
	'request' => array(
		'update_mode' => ($replace_data ? 'replace' : 'append'),
		'user' => array(
			'identity' => array(
				'name' => array(
					'givenName' => 'Max',
					'familyName' => 'Miller'
				),
				'customData' => array(
					'value' => 'blue',
					'indexed' => array(
						'yellow',
						'cyan'
					),
					'associative' => array(
						'a4' => 'yellow'
					),
					'nested' => array(
						'a' => array(
							'b' => 'brown',
							'c' => 'green'
						)
					)
				)
			)
		)
	)
)
;

// Encode structure
$structure_json = json_encode ($structure);

echo "<h1>Data</h1>";
echo "<pre>" . oneall_pretty_json::format_string ($structure_json) . "</pre>";

// Make Request
$oneall_curly->put (SITE_DOMAIN . "/storage/users/" . $user_token . ".json", $structure_json);
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

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

// User Cloud Storage \ Create User
// https://docs.oneall.com/api/resources/storage/users/create-user/

// Identitiy structure available here:
// https://docs.oneall.com/api/basic/identity-structure/

// Random (Just for testing !!!)
$rand = rand (100000, 999999);

// Encode structure
$structure_json = array(
	'request' => array(
		'user' => array(
			'login' => $rand . "@example.com",
			'password' => $rand,
			'identity' => array(
				'name' => array(
					'givenName' => 'John',
					'familyName' => 'Doe'
				),
				'customData' => array(
					'value' => 'red',
					'indexed' => array(
						'red',
						'green',
						'blue'
					),
					'associative' => array(
						'a1' => 'red',
						'a2' => 'green',
						'a3' => 'blue'
					),
					'nested' => array(
						'a' => array(
							'b' => 'black'
						)
					)
				)
			)
		)
	)
);

// Encode structure
$structure_json = json_encode ($structure_json);

echo "<h1>Data</h1>";
echo "<pre>" . oneall_pretty_json::format_string ($structure_json) . "</pre>";

// Make Request
$oneall_curly->post (SITE_DOMAIN . "/storage/users.json", $structure_json);
$result = $oneall_curly->get_result ();

// Success
if ($result->http_code == 201)
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
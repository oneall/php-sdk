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

// Relink an identity
// http://docs.oneall.com/api/resources/identities/relink-identity/

// The identity to relink
$identity_token = 'fce86b47-ead4-41ae-a903-0cfe7e86fd40';

// The new user to link the identity to
$user_token = 'e282604d-efc3-46b9-89d8-6287b50bb56f';

// Message Structure
$message_structure = array (
	'request' => array (
		'user' => array (
			'user_token' => $user_token
		)
	)
);

// Encode structure
$request_structure_json = json_encode ($message_structure);

// Message
echo "<h1>Data</h1>";
echo "<pre>" . stripslashes (oneall_pretty_json::format_string ($request_structure_json)) . "</pre>";

// Make Request
$oneall_curly->put (SITE_DOMAIN . "/identities/" . $identity_token . "/link.json", $request_structure_json);
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
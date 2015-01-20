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

// Synchronize an identity
// http://docs.oneall.com/api/resources/identities/synchronize-identity/

// The identity to synchronize
$identity_token = '4f7c6392-d287-4ae8-bfaa-ae4e9194d204';

// Update the user data?
$update_user_data = true;

// Enfore token update?
$force_token_update = true;

// Data Structure
$data = array (
	'request' => array (
		'synchronize' => array (
			'update_user_data' => $update_user_data,
			'force_token_update' => $force_token_update
		)
	)
);

// Encode structure
$request_structure_json = json_encode ($data);

// Message
echo "<h1>Data</h1>";
echo "<pre>" . stripslashes (oneall_pretty_json::format_string ($request_structure_json)) . "</pre>";

// Make Request
$oneall_curly->put (SITE_DOMAIN . "/identities/" . $identity_token . "/synchronize.json", $request_structure_json);
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
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

// User Cloud Storage \ User Lookup
// https://docs.oneall.com/api/resources/storage/users/lookup-user/

// Message Structure
$structure = array(
	'request' => array(
		'user' => array(
			'externalid' => 100000002,
			'login' => 'johnny',
			'password' => 'iaaU3WA6kFlR' 
		) 
	)
	 
);

// Encode structure
$structure_json = json_encode ($structure);

echo "<h1>Data</h1>";
echo "<pre>" . stripslashes (oneall_pretty_json::format_string ($structure_json)) . "</pre>";

// Make Request
$oneall_curly->post (SITE_DOMAIN . "/storage/users/user/lookup.json", $structure_json);
$result = $oneall_curly->get_result ();

// Success
if ($result->http_code == 200)
{
	echo "<h1>Success " . $result->http_code . " (User found)</h1>";
}
// Auth Error
elseif ($result->http_code == 401)
{
	echo "<h1>Error " . $result->http_code . " (Invalid Credentials)</h1>";
}
// Not found
elseif ($result->http_code == 404)
{
	echo "<h1>Error " . $result->http_code . " (No User found)</h1>";
}
// Error
else
{
	echo "<h1>Error " . $result->http_code . "</h1>";
}
echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
?>
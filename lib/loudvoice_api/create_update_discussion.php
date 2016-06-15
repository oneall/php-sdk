<?php
/**
 * Copyright 2016 OneAll, LLC.
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

// OK

// HTTP Handler and Configuration
include '../assets/config.php';

// Discussion API \ Create/Update a discussion for the given reference

// Unique reference (if it already exists, the corresponding discussion is updated instead)
$discussion_reference = '/product/shoes/sneaker/1';

// Automatically create a new discussion if the reference does not exist yet?
$allow_create_discussion_reference = true;

// Structure
$request_structure = array(
	'request' => array(
		'discussion' => array(
			'title' => 'My first discussion',
			'url' => 'http://www.oneall.com/',
			'discussion_reference' => $discussion_reference,
			'allow_create_discussion_reference' => $allow_create_discussion_reference 
		) 
	) 
);

// Encode structure
$request_structure_json = json_encode ($request_structure);

// Make Request
$oneall_curly->put (SITE_DOMAIN . "/loudvoice/discussions.json", $request_structure_json);
$result = $oneall_curly->get_result ();

// Message
echo "<h1>Data</h1>";
echo "<pre>" . stripslashes (oneall_pretty_json::format_string ($request_structure_json)) . "</pre>";

// Success - Discussion Already Exists
if ($result->http_code == 200)
{
	echo "<h1>Success " . $result->http_code . " (Discussion Already Exists)</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
// Success - New Discussion Created
elseif ($result->http_code == 201)
{
	echo "<h1>Success " . $result->http_code . " (Discussion Created)</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
// Error - Error
else
{
	echo "<h1>Error " . $result->http_code . "</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
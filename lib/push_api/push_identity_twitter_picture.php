<?php
/**
 * Copyright 2017 - Present OneAll, LLC.
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

// Push API \ Publish Picture On Twitter
// https://docs.oneall.com/api/resources/push/twitter/picture/

// Publish message for this identity
$identity_token = 'aff48bc8-0aa4-4a35-b3d8-293714d82468';

// Message structure
$message_structure = array (
	'request' => array (
		'push' => array (
			'picture' => array (
				'description' => 'OneAll Retina Logo',
				'url' => 'http://public.oneallcdn.com/img/oneall/logo_sni_retina.png',
			)
		)
	)
);

// Encode structure
$request_structure_json = json_encode ($message_structure);

// Message
echo "<h1>Data</h1>";
echo "<pre>" . oneall_pretty_json::format_string ($request_structure_json) . "</pre>";

// Make request
$oneall_curly->post (SITE_DOMAIN . "/push/identities/" . $identity_token . "/twitter/picture.json", $request_structure_json);
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

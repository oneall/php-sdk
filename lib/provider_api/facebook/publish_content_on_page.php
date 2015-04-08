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
include '../../assets/config.php';

// Publish content to a Facebook page
$page_token = 'db2b8ecb-baf7-41e4-9118-9f6d6082bf80';

// Message Structure
$message_structure = array (
	'request' => array (
		'page_message' => array (
			'parts' => array (
				'text' => array (
					'body' => 'The most powerful features of 30+ social networks consolidated in a single solution.'
				),
				'link' => array (
					'url' => 'https://www.oneall.com/',
					'name' => 'OneAll',
					'caption' => 'Social Media Integration',
					'description' => ' OneAll is a technology company offering a set of web-delivered tools and a Unified Social Network API to simplify the integration of 30+ social networks into business and personal websites.'
				),
				'picture' => array (
					'url' => 'https://secure.oneallcdn.com/img/oneall/128x128.png'
				)
			)
		)
	)
);

// Encode structure
$request_structure_json = json_encode ($message_structure);

// Message
echo "<h1>Data</h1>";
echo "<pre>" . stripslashes (oneall_pretty_json::format_string ($request_structure_json)) . "</pre>";

// Make Request
$oneall_curly->post (SITE_DOMAIN . "/providers/facebook/pages/" . $page_token . "/publish.json", $request_structure_json);
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
<?php
/**
 * Copyright 2014 OneAll, LLC.
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

// Social Sharing API \ Publish a message to one or more social networks
// hhttp://docs.oneall.com/api/resources/social-sharing/publish-new-message/

// Publish Message to this identity
$identity_token = '9b00dce7-7bd5-4356-947f-37190b673162';

// Message Structure
$message_structure = array (
	'request' => array (
		'sharing_message' => array (
			'parts' => array (
				'text' => array (
					'body' => 'http://www.oneall.com oneall simplifies the integration of social networks for Web 2.0 and SaaS companies http://www.oneall.com'
				),
				'picture' => array (
					'url' => 'http://oneallcdn.com/img/heading/slides/provider_grid.png'
				),
				'link' => array (
					'url' => 'http://www.oneall.com/',
					'name' => 'oneall.com',
					'caption' => 'Social Media Integration',
					'description' => 'Easily integrate social services like Facebook, Twitter, LinkedIn and Foursquare with your already-existing website.'
				),
				'flags' => array (
					'enable_tracking' => 1
				)
			),
			'publish_for_identity' => array (
				'identity_token' => $identity_token
			)
		)
	)
);

// Encode structure
$message_structure_json = json_encode ($message_structure);

// Make Request
$oneall_curly->post (SITE_DOMAIN . "/sharing/messages.json", $message_structure_json);
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
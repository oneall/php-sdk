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

// Publish message for this user_token
$user_token = '0738010c-7b89-41c2-a422-9392780204fd';

// Publish message to this networks
$providers = array (
	'twitter'
);

// Message Structure
$message_structure = array (
	'request' => array (
		'sharing_message' => array (
			'parts' => array (
				'text' => array (
					'body' => 'test'
				),
				'flags' => array (
					'enable_tracking' => 1
				)
			),
			'publish_for_user' => array (
				'user_token' => $user_token,
				'providers' => $providers
			)
		)
	)
);

// Encode structure
$message_structure_json = json_encode ($message_structure);

// Make Request
if ($oneall_curly->post (SITE_DOMAIN . "/sharing/messages.json", $message_structure_json))
{
	$result = $oneall_curly->get_result ();
	print_r (json_decode ($result->body));
}
// Error
else
{
	$result = $oneall_curly->get_result ();
	echo "Error: " . $result->http_info . "\n";
}

?>
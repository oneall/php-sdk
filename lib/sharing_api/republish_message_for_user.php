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

// Social Sharing API \ Re-Publish a previously published message
// http://docs.oneall.com/api/resources/social-sharing/re-publish-message/

//Republish this message
$sharing_message_token = 'c1d82726-e81d-4e89-82af-fed19df8f64e';

//Publish message for this user_token
$user_token = 'a96318d1-16a4-4461-8e7e-977d78665194';

//Publish message to this networks
$providers = array ();
$providers [] = 'facebook';
// $providers[] = 'twitter';
// $providers[] = 'linkedin';

//Message Structure
$message_structure = array (
	'request' => array (
		'sharing_message' => array (
			'publish_for_user' => array (
				'user_token' => $user_token,
				'providers' => $providers
			)
		)
	)
);

//Encode structure
$message_structure_json = json_encode ($message_structure);

//Post
echo "<h1>Posting</h1>";
echo "<pre>" . oneall_pretty_json::format_string ($message_structure_json) . "</pre>";

//Make Request
$oneall_curly->post (SITE_DOMAIN . "/sharing/messages/" . $sharing_message_token . ".json", $message_structure_json);
$result = $oneall_curly->get_result ();

//Success
if ($result->http_code == 200)
{
	echo "<h1>Success " . $result->http_code . "</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
//Error
else
{
	echo "<h1>Error " . $result->http_code . "</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
?>
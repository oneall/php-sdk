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

// Sharing Analytics API \ Initiate a new snapshot for shared content
// http://docs.oneall.com/api/resources/sharing-analytics/initiate-snapshot/

//The message to request a snapshot for
$sharing_message_token = 'de90f8e6-4369-4821-818a-d001524b3be4';

//Structure
$request_structure = array (
	'request' => array (
		'analytics' => array (
			'sharing' => array (
				'sharing_message_token' => $sharing_message_token
			)
		)
	)
);

//Encode structure
$request_structure_json = json_encode ($request_structure);

//Make Request
$oneall_curly->put (SITE_DOMAIN . "/sharing/analytics/snapshots.json", $request_structure_json);
$result = $oneall_curly->get_result ();

//Success
if ($result->http_code == 200)
{
	echo "<h1>Created " . $result->http_code . "</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
elseif ($result->http_code == 102)
{
	echo "<h1>Being Processed " . $result->http_code . "</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
//Error
else
{
	echo "<h1>Error " . $result->http_code . "</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}

?>
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
$sharing_message_token = 'b69595b6-0ad0-4fda-9538-05a38616f33d';

//The pingback uri
//	The OneAll API sends a request to this uri once the snapshot has been processed.
//	It has to be a public uri and you can use the snapshot_pingback_handler.php
//	from the examples to get an idea how it works
$pingback_uri = 'http://www.oneall.com/test/sdk/sharing_analytics_api/snapshot_pingback_handler.php';

//Structure
$request_structure = array (
	'request' => array (
		'analytics' => array (
			'sharing' => array (
				'sharing_message_token' => $sharing_message_token,
				'pingback_uri' => $pingback_uri
			)
		)
	)
);

//Encode structure
$request_structure_json = json_encode ($request_structure);

//Make Request
if ($oneall_curly->put (SITE_DOMAIN . "/sharing/analytics/snapshots.json", $request_structure_json))
{
	$result = $oneall_curly->get_result ();
	print_r (json_decode ($result->body));
}
//Error
else
{
	$result = $oneall_curly->get_result ();
	echo "Error: " . $result->http_info . "\n";
}

?>
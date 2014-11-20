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

// Shorturl API \ Create a new Shorturl
// http://docs.oneall.com/api/resources/shorturls/create-shorturl/

//The URL to shorten
$url = 'http://www.oneall.com';

//Request Structure
$message_structure = array (
	'request' => array (
		'shorturl' => array (
			'original_url' => $url
		)
	)
);

//Encode structure
$request_structure_json = json_encode ($message_structure);

// Message
echo "<h1>Data</h1>";
echo "<pre>" . stripslashes (oneall_pretty_json::format_string ($request_structure_json)) . "</pre>";

//Make Request
$oneall_curly->post (SITE_DOMAIN . "/shorturls.json", $request_structure_json);
$result = $oneall_curly->get_result ();

if ($result->http_code == 200)
{
	echo "<h1>Success ".$result->http_code."</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
//Error
else
{
	echo "<h1>Error ".$result->http_code."</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}

?>
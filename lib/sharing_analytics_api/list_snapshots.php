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

// Sharing Analytics API \ List all snapshots
// http://docs.oneall.com/api/resources/sharing-analytics/list-all-snapshots/

//The page to retrieve
$page = 1;

//Entries per page
$entries_per_page = 100;

//Newest first
$order_direction = 'asc';

//Only retrieve snapshot for this user_token
$user_token = 'a96318d1-16a4-4461-8e7e-977d78665194';

//Only retrieve snapshot for this identity_token
$identity_token = '3e2c84e9-44c4-441b-861b-9374e1c93d4e';


//API endpoint
$endpoint = SITE_DOMAIN . "/sharing/analytics/snapshots.json?page=" . $page . "&entries_per_page=" . $entries_per_page . "&order_direction=" . $order_direction;

//Add user_token filter
if ( ! empty ($user_token))
{
	$endpoint .= '&user_token='.$user_token;
}

//Add identity_token filter
if ( ! empty ($identity_token))
{
	$endpoint .= '&identity_token='.$identity_token;
}


//Make Request
$oneall_curly->get ($endpoint);
$result = $oneall_curly->get_result ();

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
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

// Users \ Read the details of a user
// http://docs.oneall.com/api/resources/users/read-user-details/

// Get the properties of this user
$user_token = 'c32916bb-728f-468c-9e46-69527ec6b2d3';

// The properties to retrieves
$properties = array ('emails');

// Make Request
$oneall_curly->get (SITE_DOMAIN . "/storage/users/" . $user_token . "/property.json?properties=".implode(";", $properties));
$result = $oneall_curly->get_result ();

//Success
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
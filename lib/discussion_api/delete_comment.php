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

// Discussion API \ Delete discussion
// http://docs.oneall.com/api/resources/discussions/delete-discussion/

// The comment to remove
$comment_token = 'abdf383f-f812-42d4-bedd-727365e0a0d7';

// Confirm deletion?
$confirm_deletion = 'true'; // true | false

// Recursively remove?
$delete_recursive = 'false'; // true | false

// Make Request
$oneall_curly->delete (SITE_DOMAIN . "/discussions/comments/" . $comment_token . ".json?confirm_deletion=" . $confirm_deletion . "&delete_recursive=" . $delete_recursive);
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
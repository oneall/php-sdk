<?php
/**
 * Copyright 2016 OneAll, LLC.
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

// OK

// HTTP Handler and Configuration
include '../assets/config.php';

// LoudVoice API \ Delete Comment

// The comment to remove
$comment_token = '078ecb30-4d34-4f4a-a058-2b106a4a8b1c';

// Confirm deletion?
$confirm_deletion = 'true'; // true | false
                            
// Delete sub-comments too or just move them up? 
$delete_sub_comments = 'true'; // true | false
                             
// Make Request
$oneall_curly->delete (SITE_DOMAIN . "/loudvoice/comments/" . $comment_token . ".json?confirm_deletion=" . $confirm_deletion . "&delete_sub_comments=" . $delete_sub_comments);
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
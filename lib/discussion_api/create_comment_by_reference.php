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

// Discussion API \ Create comment
// http://docs.oneall.com/api/resources/discussions/create-discussion/

// Add a comment for this discussion
$discussion_reference = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1';

// Allow creating new discussions?
$allow_create_discussion_reference = true;

// Add a sub comment for this comment (Optional)
$parent_comment_token = '';

// Comment by this identity (Optional)
$identity_token = ''; // 498ac3a3-ec9d-4a56-ba4a-0a3f3960145d';

// Comment by this author (Optional)
$author_token = ''; // 8e73e8ed-a21c-4d5e-a326-d0f3f3ddafb5';

// Comment by this author (Optional)
$author_reference = 'AUTHOR-123456789011';

// Identity
if (! empty ($identity_token))
{
	$request_structure = array (
		'request' => array (
			'discussion' => array (
				'discussion_reference' => $discussion_reference,
				'title' => '123'
			),
			'comment' => array (
				'parent_comment_token' => $parent_comment_token,
				'text' => 'My Comment ' . rand (),
				'author' => array (
					'identity_token' => $identity_token
				)
			)
		)
	);
}
// Author Token
elseif (! empty ($author_token))
{
	$request_structure = array (
		'request' => array (
			'discussion' => array (
				'allow_create_discussion_reference' => $allow_create_discussion_reference,
				'discussion_reference' => $discussion_reference,
				'title' => '123'
			),
			'comment' => array (
				'parent_comment_token' => $parent_comment_token,
				'text' => 'My Comment ' . rand (),
				'author' => array (
					'author_token' => $author_token
				)
			)
		)
	);
}
// Author Reference
elseif (! empty ($author_reference))
{
	$request_structure = array (
		'request' => array (
			'discussion' => array (
				'allow_create_discussion_reference' => $allow_create_discussion_reference,
				'discussion_reference' => $discussion_reference,
				'title' => '123'

			),
			'comment' => array (
				'parent_comment_token' => $parent_comment_token,
				'text' => 'My Comment ' . rand (),
				'author' => array (
					'author_reference' => $author_reference,
					'name' => 'John',
					'email' => 'john@doe.com',
					'description' => 'John is back',
					'picture_url' => 'http://www.exampl.com/johns-avatar.png'
				)
			)
		)
	);
}
// Guest
else
{
	$request_structure = array (
		'request' => array (
			'discussion' => array (
				'allow_create_discussion_reference' => $allow_create_discussion_reference,
				'discussion_reference' => $discussion_reference,
				'title' => '123'
			),
			'comment' => array (
				'parent_comment_token' => $parent_comment_token,
				'text' => 'My Comment ' . rand (),
				'author' => array (
					'name' => 'Claude Schlesser',
					'email' => 'claude@schlesser.lu',
					'description' => 'John is back',
					'picture_url' => 'http://www.exampl.com/johns-avatar.png'
				)
			)
		)
	);
}

// Encode structure
$request_structure_json = json_encode ($request_structure);

// Make Request
$oneall_curly->post (SITE_DOMAIN . "/discussions/comments.json", $request_structure_json);
$result = $oneall_curly->get_result ();

// Message
echo "<h1>Data</h1>";
echo "<pre>" . stripslashes (oneall_pretty_json::format_string ($request_structure_json)) . "</pre>";

// Success
if ($result->http_code == 200)
{
	echo "<h1>Result: " . $result->http_code . " (Comment Posted)</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
// Error
else
{
	echo "<h1>Result: " . $result->http_code . " (Error)</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}

?>
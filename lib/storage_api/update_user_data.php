<?php
/**
 * Copyright 2015 OneAll, LLC.
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

// Users \ Update a user stored the cloud-hosted database
// https://docs.oneall.com/api/resources/storage/users/update-user/

// User Token
$user_token = 'ca140e88-b9f3-4e5b-b0f7-50ccce229d44';

// Message Structure
$structure = array(
	'request' => array(
		'update_mode' => 'append',
		'user' => array(
			'externalid' => '100000001',
			'identity' => array(
				'preferredUsername' => null,
				'displayName' => 'john.doe',
				'profileUrl' => null,
				'thumbnailUrl' => null,
				'birthday' => '12/01/1979',
				'gender' => 'm',
				'utcOffset' => '3:30',
				'name' => array(
					'givenName' => 'John',
					'middleName' => 'Junior',
					'familyName' => 'Doe' 
				),
				'relationship' => array(
					'status' => 'married',
					'interested_in' => 'women' 
				),
				'languages' => array(
					array(
						'value' => 'French',
						'proficiency' => 'B1' 
					),
					array(
						'value' => 'English',
						'proficiency' => 'D1' 
					) 
				),
				'educations' => array(
					array(
						'value' => 'Princeton, NJ',
						'type' => 'University' 
					),
					array(
						'value' => 'Williamstown, MA',
						'type' => 'College' 
					) 
				),
				
				'interests' => array(
					array(
						'value' => 'The Lord of the Rings',
						'category' => 'Fantasy Novel' 
					),
					array(
						'value' => 'Star Wars',
						'category' => 'Movie' 
					) 
				),
				
				'addresses' => array(
					array(
						'streetAddress' => '1234 Brooklyn Street',
						'locality' => 'Dallas',
						'region' => 'TX',
						'postalCode' => '75201',
						'code' => 'USA' 
					) 
				),
				'emails' => array(
					array(
						'value' => 'jd@example.org',
						'is_verified' => false 
					) 
				),
				'likes' => array(
					array(
						'value' => 'Nirvana',
						'type' => 'music',
						'category' => 'Musician/Band ',
						'link' => 'http://www.nirvana.com/ ' 
					) 
				),
				'phoneNumbers' => array(
					array(
						'value' => '+123 12345678900',
						'type' => 'work' 
					) 
				),
				'organizations' => array(
					array(
						'name' => 'OneAll, Inc',
						'location' => 'Europe (Luxembourg)',
						'industry' => 'Software as a service',
						'title' => 'Developer',
						'description' => 'Coding and debugging',
						'department' => 'Information Technology ',
						'startDate' => '01/2011',
						'endDate' => '12/2016' 
					) 
				) 
			) 
		) 
	) 
);

// Encode structure
$structure_json = json_encode ($structure);

echo "<h1>Data</h1>";
echo "<pre>" . stripslashes (oneall_pretty_json::format_string ($structure_json)) . "</pre>";

// Make Request
$oneall_curly->put (SITE_DOMAIN . "/storage/users/" . $user_token . ".json", $structure_json);
$result = $oneall_curly->get_result ();

// Success
if ($result->http_code == 201)
{
	echo "<h1>Success " . $result->http_code . " (New cloud identity added)</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
// Success
elseif ($result->http_code == 200)
{
	echo "<h1>Success " . $result->http_code . " (Existing cloud identity updated)</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
// Error
else
{
	echo "<h1>Error " . $result->http_code . "</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}

?>
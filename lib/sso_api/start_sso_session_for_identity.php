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

// HTTP Handler and Configuration
include '../assets/config.php';

// SSO API \ Start SSO session
// http://docs.oneall.com/api/resources/sso/start-session/

// Start SSO session for this identity
$identity_token = '6f9622a4-57f0-40e6-bc50-bcba6a7499af';

// Make Request
$oneall_curly->put (SITE_DOMAIN . "/sso/sessions/identities/" . $identity_token . ".json");
$result = $oneall_curly->get_result ();

// Success
if ($result->http_code == 201)
{
	echo "<h1>Success " . $result->http_code . ", SSO Session started</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
// Error
else
{
	echo "<h1>Error " . $result->http_code . "</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}

?>
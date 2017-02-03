<?php
/**
 * Copyright 2011-2017 OneAll, LLC.
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

// SSO API \ Start SSO session for identity
// https://docs.oneall.com/api/resources/sso/identity/start-session/

// The identity for which you want to start the SSO session
$identity_token = 'a8acded5-db65-44ee-8e8e-2067057d1067';

// Make Request
$oneall_curly->put (SITE_DOMAIN . "/sso/sessions/identities/" . $identity_token . ".json");
$result = $oneall_curly->get_result ();

// Success
if ($result->http_code == 201)
{
	echo "<h1>Success " . $result->http_code . ", SSO Session Started</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
// Error
else
{
	echo "<h1>Error " . $result->http_code . "</h1>";
	echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
}
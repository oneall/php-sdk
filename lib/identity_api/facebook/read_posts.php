<?php
/**
 * Copyright 2011 - Present OneAll, LLC.
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
include '../../assets/config.php';

// Read the Facebook posts of an identity
// https://docs.oneall.com/api/resources/identities/facebook/list-posts/

// Get the Facebook posts of this identity
$identity_token = '051d81c0-2f3a-4bcf-88c6-592f56a97f3e';

// Make Request
$oneall_curly->get(SITE_DOMAIN . "/identities/" . $identity_token . "/facebook/posts.json");
$result = $oneall_curly->get_result();

// Success
if ($result->http_code == 200)
{
    echo "<h1>Success " . $result->http_code . "</h1>";
    echo "<pre>" . oneall_pretty_json::format_string($result->body) . "</pre>";
}
// Error
else
{
    echo "<h1>Error " . $result->http_code . "</h1>";
    echo "<pre>" . oneall_pretty_json::format_string($result->body) . "</pre>";
}
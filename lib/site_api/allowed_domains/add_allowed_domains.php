<?php
/**
 * Copyright 2017 OneAll, LLC.
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

// Add new allowed domains
// https://docs.oneall.com/api/resources/site/allowed-domains/

// Structure
$request_structure = array(
    'request' => array(
        'allowed_domains' => array(
            'www.mydomain1.com',
            'www.google.de',
            '*.mydomain3.com')));

// Encode structure
$request_structure_json = json_encode($request_structure);

// Make Request
$oneall_curly->put(SITE_DOMAIN . "/site/allowed-domains.json", $request_structure_json);
$result = $oneall_curly->get_result();

// Success
if (in_array($result->http_code, array(
    200,
    201)))
{
    echo "<h1>Created " . $result->http_code . "</h1>";
    echo "<pre>" . oneall_pretty_json::format_string($result->body) . "</pre>";
}
// Error
else
{
    echo "<h1>Error " . $result->http_code . "</h1>";
    echo "<pre>" . oneall_pretty_json::format_string($result->body) . "</pre>";
}

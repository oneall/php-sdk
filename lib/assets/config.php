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

// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// REPLACE WITH YOUR OWN ONEALL API CREDENTIALS
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
define ('SITE_SUBDOMAIN', 'subdomain');
define ('SITE_PUBLIC_KEY', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');
define ('SITE_PRIVATE_KEY', 'yyyyyyyy-yyyy-yyyy-yyyy-yyyyyyyyyyyy');

// OneAll Domain
define ('SITE_DOMAIN', 'https://' . SITE_SUBDOMAIN . '.api.oneall.com');

// Current folder
$current_folder = realpath (dirname (__FILE__));

// HTTP Transfer Handler
require $current_folder . '/includes/oneall_curly.php';

// JSON Formatting
require $current_folder . '/includes/oneall_pretty_json.php';

// Setup new connection
$oneall_curly = new oneall_curly ();
$oneall_curly->set_option ('USERPWD', SITE_PUBLIC_KEY . ':' . SITE_PRIVATE_KEY);

// Change to 1 to display the CURL output
$oneall_curly->set_option ('VERBOSE', 0);

// Enable SSL checks
$oneall_curly->set_option ('SSL_VERIFYPEER', 1);
?>
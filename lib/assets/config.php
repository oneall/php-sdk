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

// Current folder
$current_folder = realpath (dirname (__FILE__));

// Read configuration
$config = parse_ini_file ($current_folder . "/../config.ini", true);

// Select environment
$environment = (isset ($config ['environment']) ? trim ($config ['environment']) : null);
if (empty ($environment))
{
	die ("The environment needs to be set in the config.ini file");
}

// Read environment settings
$settings = (isset ($config [$environment]) ? $config [$environment] : null);
if (! is_array ($config [$environment]))
{
	die ("The environment [" . $environment . "] is not setup, please check the config.ini file");
}

// Site subdomain
$site_subdomain = (isset ($settings ['oneall_site_subdomain']) ? trim ($settings ['oneall_site_subdomain']) : null);
if (empty ($site_subdomain))
{
	die ("The [oneall_site_subdomain] is not setup for the environment [" . $environment . "], please check the config.ini file");
}

// Site private key
$site_private_key = (isset ($settings ['oneall_site_private_key']) ? trim ($settings ['oneall_site_private_key']) : null);
if (empty ($site_private_key))
{
	die ("The [oneall_site_private_key] is not setup for the environment [" . $environment . "], please check the config.ini file");
}

// Site public key
$site_public_key = (isset ($settings ['oneall_site_public_key']) ? trim ($settings ['oneall_site_public_key']) : null);
if (empty ($site_public_key))
{
	die ("The [oneall_site_public_key] is not setup for the environment [" . $environment . "], please check the config.ini file");
}

// Constants
define ('SITE_SUBDOMAIN', $site_subdomain);
define ('SITE_DOMAIN', 'https://' . $site_subdomain . '.api.oneall.com');
define ('SITE_PUBLIC_KEY', $site_public_key);
define ('SITE_PRIVATE_KEY', $site_private_key);

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
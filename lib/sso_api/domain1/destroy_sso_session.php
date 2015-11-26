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
include '../../assets/config.php';

//Extract oken
$identity_token = ( ! empty ($_REQUEST['identity_token']) ? $_REQUEST['identity_token'] : '');

?>
	<h2><a href="start_sso_session.php">Start New SSO Session</a></h2>
<?php 

// Make Request
if ( ! empty ($identity_token))
{
	// Make Request
	$oneall_curly->delete (SITE_DOMAIN . "/sso/sessions/identities/".$identity_token.".json?confirm_deletion=true");
	$result = $oneall_curly->get_result ();

	// Success
	if ($result->http_code == 200)
	{		
		echo "<h1>Success " . $result->http_code . " (Session Destroyed)</h1>";
		echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
	}
	// Error
	else
	{
		echo "<h1>Error " . $result->http_code . "</h1>";
		echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
	}
}
// No Token given
else
{
	?>
		<h1>Error</h1>
		<pre>No identity_token received: cannot remove SSO session</pre> 
	<?php 
}

?>
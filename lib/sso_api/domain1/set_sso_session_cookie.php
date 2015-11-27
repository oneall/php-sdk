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
$sso_session_token = ( ! empty ($_REQUEST['sso_session_token']) ? $_REQUEST['sso_session_token'] : '');

?>
	<h2><a href="start_sso_session.php">Start New SSO Session</a></h2>
<?php 

// Make Request
if ( ! empty ($sso_session_token))
{
	// Make Request
	$oneall_curly->get (SITE_DOMAIN . "/sso/sessions/".$sso_session_token.".json");
	$result = $oneall_curly->get_result ();

	// Success
	if ($result->http_code == 200)
	{		
		echo "<h1>Success " . $result->http_code . "</h1>";
		echo "<h2>The following SSO session has been started</h2>";
		echo "<pre>" . oneall_pretty_json::format_string ($result->body) . "</pre>";
		
		// Decode Result
		$json = json_decode ($result->body);
		
		// Extract SSO session data
		$sso_session_data = $json->response->result->data->sso_session;
				
		?>
			<script type="text/javascript">
			var _oneall = window._oneall || [];
			_oneall.push(['single_sign_on', 'do_register_sso_session', '<?php echo $sso_session_token; ?>']);
			(function() {
				var oa = document.createElement('script');
				oa.type = 'text/javascript';
				oa.async = true;
				oa.src = '<?php echo SITE_DOMAIN; ?>/socialize/library.js';
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(oa, s);
			})();
			</script>
			<h2><a href="destroy_sso_session.php?identity_token=<?php echo $sso_session_data->identity_token; ?>">Destroy this SSO Session</a></h2>
		<?php 
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
		<pre>No sso_session_token received: cannot set SSO session cookie</pre> 
	<?php 
}

?>
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

//Extract oken
$sso_session_token = ( ! empty ($_REQUEST['sso_session_token']) ? $_REQUEST['sso_session_token'] : '');

?>
<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8" />
			<title>SSO Set session cookie</title>
		</head>
		<body>
			<?php
				if (empty ($sso_session_token))
				{
					?>
						<strong>No sso_session_token received: cannot set SSO session cookie</strong>
					<?php
				}
				else
				{
					?>
						<script type="text/javascript">
							var _oneall = window._oneall || [];
							_oneall.push(['single_sign_on', 'set_sso_session_token', '<?php echo $sso_session_token; ?>']);
							_oneall.push(['single_sign_on', 'do_start_session']);

							(function() {
								var oa = document.createElement('script');
								oa.type = 'text/javascript';
								oa.async = true;
								oa.src = 'http://oneall.api.oneall.loc/socialize/library.js';
						    var s = document.getElementsByTagName('script')[0];
						    s.parentNode.insertBefore(oa, s);
						  })();
						</script>

						<strong>Cookie set for sso_session_token <?php echo $sso_session_token; ?></strong>
					<?php
				}
			?>
		</body>
	</html>
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

?>
<!DOCTYPE html>
		<html>
			<head>
				<meta charset="utf-8" />
				<title>Asynchronous Test</title>

				<script type="text/javascript">

					<!-- Compute the callback_uri //-->
					var pathname = window.location.pathname;
					var dir = pathname.substring(0, pathname.lastIndexOf('/'));
					var protocol = window.location.protocol;
					var path = protocol + '//' + window.location.host + dir + '/';
					var callback_uri = path + 'callback_handler.php';

				</script>

			</head>
			<body>
				<div id="oasl_container_a1"></div>

				<script type="text/javascript">

				var _oneall = window._oneall || [];
				_oneall.push(['single_sign_on', 'set_callback_uri', callback_uri]);
				_oneall.push(['single_sign_on', 'set_realm', 'main']);
				_oneall.push(['single_sign_on', 'do_start_session']);

				_oneall.push(['social_login', 'set_providers', ['facebook','google','twitter','yahoo']]);
				_oneall.push(['social_login', 'set_callback_uri', callback_uri]);
				_oneall.push(['social_login', 'set_callback_uri', callback_uri + '?origin=social_login']);
				_oneall.push(['social_login', 'do_render_ui', 'oasl_container_a1']);

			(function() {
				var oa = document.createElement('script');

				oa.type = 'text/javascript';
				oa.async = true;
				oa.src = 'http://oneall.api.oneall.loc/socialize/library.js';

		    var s = document.getElementsByTagName('script')[0];
		    s.parentNode.insertBefore(oa, s);
		  })();

		</script>
	</body>
</html>
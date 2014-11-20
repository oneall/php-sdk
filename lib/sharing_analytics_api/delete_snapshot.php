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

// HTTP Handler and Configuration
include '../assets/config.php';

// Sharing Analytics API \ Delete a Snapshot
// http://docs.oneall.com/api/resources/sharing-analytics/delete-snapshot/

//The snapshot to delete
$sharing_analytics_snapshot_token = '9cc247b0-01ef-4dfd-baca-9ef0ef29c4b1';

//Make Request
if ($oneall_curly->delete (SITE_DOMAIN . '/sharing/analytics/snapshots/' . $sharing_analytics_snapshot_token . '.json?confirm_deletion=true'))
{
	$result = $oneall_curly->get_result ();
	print_r (json_decode ($result->body));
}
//Error
else
{
	$result = $oneall_curly->get_result ();
	echo "Error: " . $result->http_info . "\n";
}

?>
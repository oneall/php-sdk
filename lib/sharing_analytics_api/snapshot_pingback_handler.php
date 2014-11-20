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

// Example for a Pingback Handler
// http://docs.oneall.com/api/resources/sharing-analytics/initiate-snapshot/

// This script is used by the example initiate_snapshot_with_pingback.php

// Debugging
$debug = true;
$debug_email = 'debug@oneall.com';

// Raw Result
$result_raw = file_get_contents ('php://input');
if ($debug)
{
	mail ($debug_email, '[OneAll] Snapshot Result Raw', print_r ($result_raw, true));
}

// Decoded Result
$result = json_decode ($result_raw);
if ($debug)
{
	mail ($debug_email, '[OneAll] Snapshot Result Decoded', print_r ($result, true));
}

// Check Result
if (is_object ($result) and property_exists ($result, 'response') and $result->response->request->status->code == 200)
{
	// Read Snapshot Token
	$sharing_analytics_snapshot = $result->response->result->data->sharing_analytics_snapshot->sharing_analytics_snapshot_token;

	// With this token you can now query the details of the snapshot - an example is provided in read_snapshot.php
	if ($debug)
	{
		mail ($debug_email, '[OneAll] Snapshot Ready', 'The snapshot ' . $sharing_analytics_snapshot . ' is ready');
	}
}

?>
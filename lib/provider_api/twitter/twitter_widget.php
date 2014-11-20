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

// Search hash
$hash = '#OneAll';

// Number of tweets
$num_tweets = '9';

// Connection Resource
$resource_uri = 'https://' . $site_domain . '.api.oneall.com/site/providers/twitter/tweets/search.json?search_by=hash&hash=' . urlencode ($hash) . '&count=' . $num_tweets;

// Setup connection
$curl = curl_init ();
curl_setopt ($curl, CURLOPT_URL, $resource_uri);
curl_setopt ($curl, CURLOPT_HEADER, 0);
curl_setopt ($curl, CURLOPT_USERPWD, SITE_PUBLIC_KEY . ":" . SITE_PRIVATE_KEY);
curl_setopt ($curl, CURLOPT_TIMEOUT, 15);
curl_setopt ($curl, CURLOPT_VERBOSE, 0);
curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt ($curl, CURLOPT_FAILONERROR, 0);

// Send request
$result = curl_exec ($curl);
$json = json_decode ($result);

// Extract Tweets
$tweets = array ();
if (isset ($json->response->result->data->tweets->entries))
{
	if (is_array ($json->response->result->data->tweets->entries))
	{
		$tweets = $json->response->result->data->tweets->entries;
	}
}

// Setup Sections
$tweet_middle_top = array_shift ($tweets);
$tweets_left = array_splice ($tweets, 0, 3);
$tweets_middle_bot = array_splice ($tweets, 0, 2);
$tweets_right = array_splice ($tweets, 0, 3);

// HTML for one tweet
function build_tweet_html ($tweet, $add_class = "")
{
	$html = '
			<div class="tweet' . (! empty ($add_class) ? ' ' . $add_class : '') . '">
				<div class="header">
					<div class="picture">
  				<img src="' . $tweet->user->image . '" />
  					</div>
  				<div class="title">
  					<div class="name">' . $tweet->user->name . '</div>
  					<div class="screen_name">@<a href="https://twitter.com/' . $tweet->user->screen_name . '" target="_blank">' . $tweet->user->screen_name . '</a></div>
					</div>
				</div>
				<div class="body">' . $tweet->text . '</div>
				<div class="footer">' . date ("j M", $tweet->date_creation) . '</div>
			</div>';
	return $html;
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-EN">
<head>
	<title>Twitter Widget</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<style type="text/css">
		body {
		  font-family: 'fs_albertlight', "Helvetica Neue", Helvetica, Arial, sans-serif;
		}

		#tweets {
		  color: #fff;
		  overflow: hidden;
		}

		#tweets .tweets_left,#tweets .tweets_right {
		  width: 255px;
		  float: left;
		}

		#tweets .tweets_middle {
		  width: 510px;
		  float: left;
		}

		.tweet {
		  width: 215px;
		  padding: 15px;
		  height: 215px;
		  float: left;
		  background-color: #3c9f45;
		  margin: 5px;
		}

		.tweet a {
		  color: #fff;
		  text-decoration: none;
		}

		.tweet.large {
		  width: 470px;
		  height: 470px;
		}

		.tweet .header {
		  float: left;
		  width: 100%;
		}

		.tweet .header .picture {
		  float: left;
		  width: 50px;
		}

		.tweet .header .title {
		  float: left;
		  width: 155px;
		  margin-left: 10px;
		  font-size: 15px;
		}

		.tweet.large .title {
		  font-size: 19px;
		}

		.tweet .header .title .name {
		  font-weight: bold;
		}

		.tweet .body {
		  float: left;
		  font-size: 14px;
		  margin: 10px 0;
		  width: 100%;
		  min-height: 130px;
		}

		.tweet.large .body {
		  font-size: 20px;
		  min-height: 340px;
		  margin: 20px 0;
		}

		.tweet .footer {
		  float: left;
		  width: 100%;
		  font-size: 13px;
		  font-weight: bold;
		}

		.tweet.large .footer {
		  font-size: 18px;
		}
  </style>
</head>
<body>
	<div id="tweets">
		<div class="tweets_left">
				<?php
				// Left Side
				foreach ($tweets_left as $tweet)
				{
					echo build_tweet_html ($tweet);
				}
				?>
			</div>

		<div class="tweets_middle">
				<?php
				// Middle Top
				echo build_tweet_html ($tweet_middle_top, 'large');

				// Middle Bottom
				foreach ($tweets_middle_bot as $tweet)
				{
					echo build_tweet_html ($tweet);
				}
				?>
			</div>

		<div class="tweets_right">
				<?php
				// Right Side
				foreach ($tweets_right as $tweet)
				{
					echo build_tweet_html ($tweet);
				}
				?>
			</div>
	</div>
</body>
</html>
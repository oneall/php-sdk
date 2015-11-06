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

// HTTP Library
class oneall_curly
{
	// Result
	private $result;

	// Options
	private $options;

	// ////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Constructor
	// ////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function __construct ($options = array ())
	{
		// Default Options
		$this->set_option ('USERAGENT', 'PHP SDK 1.0');
		$this->set_option ('TIMEOUT', 125);
		$this->set_option ('CONNECTTIMEOUT', 125);
		$this->set_option ('SSL_VERIFYPEER', 0);
		$this->set_option ('HEADER', 1);
		$this->set_option ('FAILONERROR', 0);
		$this->set_option ('RETURNTRANSFER', 1);
		$this->set_option ('MAXREDIRS', 5);

		// Custom Options
		if (is_array ($options) and count ($options) > 0)
		{
			foreach ($options as $key => $value)
			{
				$this->set_option ($key, $value);
			}
		}
	}

	// ////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Setter / Getter
	// ////////////////////////////////////////////////////////////////////////////////////////////////////////

	// Set an option
	public function set_option ($key, $value, $list = false)
	{
		$options = $this->get_options ();
		$options [$key] = ($list ? array (
			$value
		) : $value);
		$this->options = $options;
	}

	// Append to an option
	public function append_to_option ($key, $value, $list = false)
	{
		$options = $this->get_options ();
		if (! isset ($options [$key]))
		{
			$options [$key] = ($list ? array (
				$value
			) : $value);
		}
		else
		{
			if ($list)
			{
				if (! is_array ($options [$key]))
				{
					$options [$key] = array (
						$options [$key]
					);
				}
				$options [$key] [] = $value;
			}
			else
			{
				$options [$key] .= $value;
			}
		}
		$this->options = $options;
	}

	// Get the options
	public function get_options ()
	{
		return (is_array ($this->options) ? $this->options : array ());
	}

	// Set the result
	private function set_result ($status, $http_code = null, $http_info = null, $header = null, $headers = null, $header_size = null, $body = null)
	{
		$this->result = new stdClass ();
		$this->result->status = $status;
		$this->result->http_code = $http_code;
		$this->result->http_info = $http_info;
		$this->result->header = $header;
		$this->result->header_parts = $this->explode_header ($header);
		$this->result->headers = $headers;
		$this->result->header_size = $header_size;
		$this->result->body = $body;
	}

	// Return the result
	public function get_result ()
	{
		return $this->result;
	}

	// Return the parts of a given header
	private function explode_header ($header)
	{
		// Parts Container
		$parts = array ();

		// Loop through lines
		$lines = explode ("\r\n", $header);
		foreach ($lines as $line)
		{
			$line_parts = explode (':', $line, 2);
			if (count ($line_parts) == 2)
			{
				$key = strtolower (trim ($line_parts [0]));
				$value = trim ($line_parts [1]);
				$parts [$key] = $value;
			}
		}

		return $parts;
	}
	public function set_redirects ($enable, $max_redirects = 5)
	{
		$this->set_option ('FOLLOWLOCATION', $enable);
		$this->set_option ('MAXREDIRS', $max_redirects);
	}
	public function set_ssl_verification ($enable)
	{
		$this->set_option ('SSL_VERIFYPEER', $enable);
	}
	public function set_fast_catch ()
	{
		$this->set_redirects (true, 5);
		$this->set_ssl_verification (false);
	}

	// ////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Methods
	// ////////////////////////////////////////////////////////////////////////////////////////////////////////

	// Make a POST request
	public function post ($uri, $data = null)
	{
		// URI
		$this->set_option ('URL', $uri);

		// POST Method
		$this->set_option ('POST', 1);
		$this->append_to_option ('HTTPHEADER', 'Expect:', true);

		// POST Data
		if (! is_null ($data))
		{
			if (is_array ($data))
			{
				$post_values = array ();
				foreach ($data as $key => $value)
				{
					$post_values [] = $key . '=' . urlencode ($value);
				}
				$post_value = implode ("&", $post_values);
			}
			else
			{
				$post_value = trim ($data);
			}

			// Setup POST Data
			if (! empty ($post_value))
			{
				$this->set_option ('POSTFIELDS', $post_value);
			}
		}

		// Make Post
		return $this->request ();
	}

	// Make a DELETE request
	public function delete ($uri)
	{
		// URI
		$this->set_option ('URL', $uri);

		// Delete Arguments
		$this->set_option ('CUSTOMREQUEST', 'DELETE');

		// Make Request
		return $this->request ();
	}

	// Make a PUT request
	public function put ($uri, $data = null)
	{
		// URI
		$this->set_option ('URL', $uri);

		// PUT Arguments
		$this->set_option ('CUSTOMREQUEST', 'PUT');

		// Data
		if (! is_null ($data))
		{
			if (is_array ($data))
			{
				$post_values = array ();
				foreach ($data as $key => $value)
				{
					$post_values [] = $key . '=' . urlencode ($value);
				}
				$post_value = implode ("&", $post_values);
			}
			else
			{
				$post_value = trim ($data);
			}

			// Setup POST Data
			if (! empty ($post_value))
			{
				$this->set_option ('POSTFIELDS', $post_value);
			}
			else
			{
				$this->append_to_option ('HTTPHEADER', 'Content-length: 0', true);
			}
		}
		else
		{
			$this->append_to_option ('HTTPHEADER', 'Content-length: 0', true);
		}

		// Make Request
		return $this->request ();
	}

	// Make a GET request
	public function get ($uri)
	{
		// URI
		$this->set_option ('URL', $uri);

		// Arguments
		$this->set_option ('HTTPGET', 1);
		return $this->request ();
	}

	// Make a request
	private function request ()
	{
		// Initialize Curl
		$ci = curl_init ();

		// Set Options
		$options = $this->get_options ();
		foreach ($options as $key => $value)
		{
			curl_setopt ($ci, constant ('CURLOPT_' . $key), $value);
		}

		// Get response
		$response = curl_exec ($ci);

		// Get error
		$error_number = curl_errno ($ci);

		// Error
		if ($response === false or ! empty ($error_number))
		{
			// Get Information
			$error_text = curl_error ($ci);

			// Set resutl
			$this->set_result ('error', $error_number, $error_text);

			// Error
			return false;
		}
		// Success
		else
		{
			// Get Information
			$curl_info = curl_getinfo ($ci);

			// Get Header Size
			$header_size = $curl_info ['header_size'];

			// Multiple Headers (For 301 Redirects)
			$headers = preg_split('/\r\n\r\n/', trim (substr ($response, 0, $header_size)));

			// Only take last Header
			$headers_tmp = $headers;
			$header = array_pop ($headers_tmp);

			// Body
			$body = trim (substr ($response, $header_size));

			// Result
			$code = curl_getinfo ($ci, CURLINFO_HTTP_CODE);

			// Close connection
			curl_close ($ci);

			// Store request details
			$this->set_result ('success', $code, $curl_info, $header, $headers, $header_size, $body);

			//Done
			return true;
		}
	}
}

?>

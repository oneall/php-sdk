<?php

/**
 * @package      Oneall Single Sign-On
 * @copyright    Copyright 2017-Present http://www.oneall.com
 * @license      GNU/GPL 2 or later
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307,USA.
 *
 * The "GNU General Public License" (GPL) is available at http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Oneall\Client;

/**
 * Class Response
 *
 * @package Oneall\Client
 */
class Response
{
    /**
     * @var array Map of standard HTTP status code/reason phrases
     */
    private static $phrases = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-status',
        208 => 'Already Reported',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        511 => 'Network Authentication Required',
    ];

    /**
     * @var string
     */
    private $reasonPhrase = '';

    /**
     * @var int
     */
    private $statusCode = 200;

    /**
     * @var null|resource|string
     */
    private $body;

    /**
     * @var array Map of all registered headers, as original name => array of values
     */
    private $headers = [];

    /**
     * @var array Map of lowercase header name => original name at registration
     */
    private $headerNames = [];

    /**
     * @var string
     */
    private $protocol = '1.1';

    /**
     * @param int                  $status  Status code
     * @param array                $headers Response headers
     * @param string|null|resource $body    Response body
     * @param string               $version Protocol version
     * @param string|null          $reason  Reason phrase (when empty a default will be used based on the status code)
     */
    public function __construct($status = 200, array $headers = [], $body = null, $version = '1.1', $reason = null)
    {
        $this->statusCode = (int) $status;

        if ($body !== '' && $body !== null)
        {
            $this->body = $body;
        }

        $this->setHeaders($headers);

        $this->reasonPhrase = (string) $reason;
        if (empty($reason) && isset(self::$phrases[$this->statusCode]))
        {
            $this->reasonPhrase = self::$phrases[$this->statusCode];
        }

        $this->protocol = $version;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }

    /**
     * @return string
     */
    public function getProtocolVersion()
    {
        return $this->protocol;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param $header
     *
     * @return bool
     */
    public function hasHeader($header)
    {
        return isset($this->headerNames[strtolower($header)]);
    }

    /**
     * @param $header
     *
     * @return array|mixed
     */
    public function getHeader($header)
    {
        $header = strtolower($header);

        if (!isset($this->headerNames[$header]))
        {
            return [];
        }

        $header = $this->headerNames[$header];

        return $this->headers[$header];
    }

    /**
     * @param $header
     *
     * @return string
     */
    public function getHeaderLine($header)
    {
        return implode(', ', $this->getHeader($header));
    }

    /**
     * @return null|resource|string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param array $headers
     */
    private function setHeaders(array $headers)
    {
        $this->headerNames = $this->headers = [];
        foreach ($headers as $header => $value)
        {
            if (!is_array($value))
            {
                $value = [$value];
            }

            $value      = $this->trimValues($value);
            $normalized = strtolower($header);

            // if alredy set, we merge headers
            if (isset($this->headerNames[$normalized]))
            {
                $header                 = $this->headerNames[$normalized];
                $this->headers[$header] = array_merge($this->headers[$header], $value);
                continue;
            }
            // or we create new ones
            $this->headerNames[$normalized] = $header;
            $this->headers[$header]         = $value;
        }
    }

    /**
     * Trims whitespace/tab from the given values.
     *
     * @param string[] $values
     *
     * @return string[] trimmed values
     */
    private function trimValues(array $values)
    {
        foreach ($values as &$value)
        {
            $value = trim($value, " \t");
        }

        return $values;
    }
}

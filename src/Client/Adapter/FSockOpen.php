<?php

/**
 * @package      Oneall PHP SDK
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

namespace Oneall\Client\Adapter;

use Oneall\Client\AbstractClient;
use Oneall\Client\Response;

/**
 * Class FSockOpen
 *
 * @package Oneall\Client\Adapter
 */
class FSockOpen extends AbstractClient
{
    const SCHEME_SSL  = 'ssl';
    const SCHEME_HTTP = 'http';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'fsockopen';
    }

    /**
     * {@inheritdoc}
     */
    public function get($path = array())
    {
        return $this->request($path, 'GET', null);
    }

    /**
     * {@inheritdoc}
     */
    public function post($path, array $data)
    {
        return $this->request($path, 'POST', $data);
    }

    /**
     * {@inheritdoc}
     */
    public function put($path, array $data)
    {
        return $this->request($path, 'PUT', $data);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($path = array())
    {
        return $this->request($path, 'DELETE', null);
    }

    /**
     * {@inheritdoc}
     */
    public function getScheme()
    {
        if ($this->isSecure())
        {
            return self::SCHEME_SSL;
        }

        return '';
    }

    /**
     * @return int
     */
    protected function getPort()
    {
        if ($this->isSecure())
        {
            return 443;
        }

        return 80;
    }

    /**
     * @param string $path
     * @param string $method
     *
     * @return mixed
     */
    protected function request($path, $method, $data = null)
    {
        $errno = $errstr = null;

        // Create socket
        if (!$socket = fsockopen($this->getHost(), $this->getPort(), $errno, $errstr, $this->getTimeout()))
        {
            throw new \RuntimeException('Error while opening fsokopen : [' . $errno . ']' . trim($errstr));
        }
        if ($data)
        {
            $data = json_encode($data);
        }
        // Send request headers.
        fwrite($socket, strtoupper($method) . " " . $path . " HTTP/1.1\r\n");
        fwrite($socket, "Host: " . $this->getHost() . "\r\n");
        fwrite($socket, "Authorization: Basic " . $this->getAutorization() . "\r\n");
        if ($this->getUserAgent())
        {
            fwrite($socket, "User-Agent: " . $this->getUserAgent() . "\r\n");
        }

        // Add POST data ?
        if ($data)
        {
            fwrite($socket, "Content-length: " . strlen($data) . "\r\n");
        }
        fwrite($socket, "Connection: close\r\n\r\n");

        // Add POST data ?
        if ($data)
        {
            fwrite($socket, $data);
        }

        // Fetch response
        $rawResponse = '';
        while (!feof($socket))
        {
            $rawResponse .= fread($socket, 1024);
        }

        // Close connection
        fclose($socket);

        // Parse response
        list($responseHeader, $responseBody) = explode("\r\n\r\n", $rawResponse, 2);

        // Parse header
        $responseHeader = preg_split("/\r\n|\n|\r/", $responseHeader);
        list($headerProtocol, $headerCode, $headerStatusMessage) = explode(' ', trim(array_shift($responseHeader)), 3);

        $response = new Response($headerCode, $responseHeader, $responseBody, $headerProtocol, $headerStatusMessage);

        return $response;
    }

    /**
     * Build authorization header
     *
     * @return string
     */
    private function getAutorization()
    {
        return base64_encode($this->getPublicKey() . ":" . $this->getPrivateKey());
    }
}

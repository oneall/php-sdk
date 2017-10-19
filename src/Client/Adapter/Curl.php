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

namespace Oneall\Client\Adapter;

use Oneall\Client\AbstractClient;

/**
 * Class Curl
 *
 * @package Oneall\Client\Adapter
 */
class Curl extends AbstractClient
{
    /**
     * @var string
     */
    const SCHEME_HTTP = 'http';

    /**
     * @var string
     */
    const SCHEME_HTTPS = 'https';

    /**
     * @var array
     */
    private $options;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'curl';
    }

    /**
     * Curl constructor.
     *
     * @param string $subDomain
     * @param string $sitePublicKey
     * @param string $sitePrivateKey
     * @param bool   $isSecure
     * @param string $base
     */
    public function __construct($subDomain, $sitePublicKey, $sitePrivateKey, $isSecure = true, $base = 'oneall.com')
    {
        parent::__construct($subDomain, $sitePublicKey, $sitePrivateKey, $isSecure, $base);

        $this->initOptions();
    }

    /**
     * {@inheritdoc}
     */
    public function getScheme()
    {
        if ($this->isSecure())
        {
            return self::SCHEME_HTTPS;
        }

        return self::SCHEME_HTTP;
    }

    /**
     * {@inheritdoc}
     */
    public function get($path)
    {
        $this->initOptions();
        $this->setOption('HTTPGET', 1);

        return $this->request($path);
    }

    /**
     * {@inheritdoc}
     */
    public function post($path, array $data)
    {
        $this->initOptions();
        $this->setOption('POST', 1);
        $this->setOption('HTTPHEADER', 'Expect:', true);
        $this->setPostFields($data);

        //Make Post
        return $this->request($path);
    }

    /**
     * {@inheritdoc}
     */
    public function put($path, array $data)
    {
        $this->initOptions();
        $this->setOption('CUSTOMREQUEST', 'PUT');
        $this->setPostFields($data);

        //Make Request
        return $this->request($path);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($path)
    {
        $this->initOptions();
        $this->setOption('CUSTOMREQUEST', 'DELETE');

        return $this->request($path);
    }

    /**
     * @return \Oneall\Client\Response
     */
    private function request($path)
    {
        $curlHandler = curl_init();

        $url = $this->getHost() . $path;
        $this->setOption('URL', $url);

        $this->setCurlOptions($curlHandler, $this->getOptions());

        $response = curl_exec($curlHandler);
        $errorNumber = curl_errno($curlHandler);
        $curlInfo    = curl_getinfo($curlHandler);

        //Result
        $code = curl_getinfo($curlHandler, CURLINFO_HTTP_CODE);

        //Error
        if ($response === false OR !empty ($errorNumber))
        {
            // Client error
            $errorText = curl_error($curlHandler);
            throw new \RuntimeException('Error ' . $errorNumber . ' - ' . $errorText . ' /// ' . serialize($this->options));
        }

        //Close connection
        curl_close($curlHandler);

        //Get Header Size
        $headerSize = $curlInfo['header_size'];

        //Multiple Headers (For 301 Redirects)
        $headers   = preg_split('/\r\n\r\n/', trim(substr($response, 0, $headerSize)));
        $headerRaw = array_pop($headers);

        $version = $this->getHttpVersion($headerRaw);
        $reason  = $this->getHttpReason($headerRaw);
        $header  = $this->curlHeaderToArray($headerRaw);
        $body    = trim(substr($response, $headerSize));

        $response = new \Oneall\Client\Response($code, $header, $body, $version, $reason);

        return $response;
    }

    /**
     * Set an option
     *
     * @param string $key
     * @param string $value
     * @param bool   $list
     */
    private function setOption($key, $value, $list = false)
    {
        $options       = $this->getOptions();
        $options[$key] = ($list ? array($value) : $value);
        $this->options = $options;
    }

    /**
     * Append to an option
     *
     * @param string $key
     * @param string $value
     * @param bool   $list
     *
     * @return null
     */
    private function appendOption($key, $value, $list = false)
    {
        if (!isset ($this->options[$key]))
        {
            $this->options[$key] = ($list ? array($value) : $value);

            return null;
        }

        if ($list)
        {
            if (!is_array($this->options[$key]))
            {
                $this->options[$key] = array($this->options[$key]);
            }
            $this->options[$key][] = $value;

            return null;
        }

        $this->options[$key] .= $value;
    }

    /**
     * Get the options
     *
     * @return array
     */
    private function getOptions()
    {
        return (is_array($this->options) ? $this->options : array());
    }

    /**
     * TSet post values as json
     *
     * @param array $data
     *
     * @return string
     */
    protected function setPostFields(array $data)
    {
        $json = json_encode($data);

        $this->appendOption('HTTPHEADER', 'Content-Type: application/json', true);
        $this->setOption('POSTFIELDS', $json);

        return $json;
    }

    /**
     * Inject option into the curl handler. Add prefix 'CURLOPT_' to option name if required
     *
     * @param resource $curlHandler
     * @param array    $options
     */
    protected function setCurlOptions($curlHandler, $options)
    {
        foreach ($options AS $optionName => $value)
        {
            if (strpos($optionName, 'CURLOPT_') !== 0)
            {
                $optionName = 'CURLOPT_' . $optionName;
            }

            curl_setopt($curlHandler, constant($optionName), $value);
        }
    }

    /**
     * @param $string
     *
     * @return array
     */
    protected function curlHeaderToArray($string)
    {
        $headers = [];

        $split = preg_split('#\r\n#', trim($string));

        // remove first raw, containing HTTP version & repsonse code.
        unset($split[0]);

        foreach ($split as $part)
        {
            $name           = substr($part, 0, strpos($part, ':'));
            $value          = substr($part, strpos($part, ':') + 1);
            $headers[$name] = $value;
        }

        return $headers;
    }

    /**.
     * @param string $rawResponseHeader
     *
     * @return string|null null if version not found
     */
    protected function getHttpVersion($rawResponseHeader)
    {
        $version = null;

        if (preg_match('#^HTTP/(?P<version>[^ ]+) #', $rawResponseHeader, $match))
        {
            $version = $match['version'];
        }

        return $version;
    }

    /**.
     * @param string $rawResponseHeader
     *
     * @return string|null null if reason not found
     */
    protected function getHttpReason($rawResponseHeader)
    {
        $reason = null;

        if (preg_match('#^HTTP\/[^ ]+ \d+\s+(?P<reason>.+)\s*\r#', $rawResponseHeader, $match))
        {
            $reason = $match['reason'];
        }

        return $reason;
    }

    /**
     * Remove all options
     */
    protected function initOptions()
    {
        // empty all options
        $this->options = [];

        //Default Options
        $this->setOption('USERAGENT', 'Mozilla/5.0 (OneAll Curly) Gecko/20080311 Firefox/2.0.0.13');
        $this->setOption('TIMEOUT', 15);
        $this->setOption('CONNECTTIMEOUT', 15);
        $this->setOption('SSL_VERIFYPEER', 0);
        $this->setOption('CURLOPT_SSL_VERIFYHOST', 0);
        $this->setOption('HEADER', 1);
        $this->setOption('FAILONERROR', 0);
        $this->setOption('RETURNTRANSFER', 1);
        $this->setOption('FOLLOWLOCATION', 1);
        $this->setOption('MAXREDIRS', 5);
        $this->setOption('USERPWD', $this->getPublicKey() . ':' . $this->getPrivateKey());
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: xuchang
 * Date: 16/9/13
 * Time: 09:24
 */

namespace Slim\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;  

/**
 * Class RequestAssist
 * @package Oasis\Watch\Common\Utils
 */
class HttpAssistent
{

    public static function doPost($url, $params = [], $timeout = 10, $headers = [], $json = null)
    {

        return self::makeServerRequest($url, $params, $timeout, 'POST', $headers, $json);
    }

    public static function doGet($url, $timeout = 10, $headers = [])
    {

        return self::makeServerRequest($url, [], $timeout, "GET", $headers);
    }

    public static function doDel($url, $timeout = 10, $headers = [])
    {

        return self::makeServerRequest($url, [], $timeout, 'DELETE', $headers);
    }

    private static function makeServerRequest(
        $url,
        $params = [],
        $timeout = 10,
        $method,
        $headerData = [],
        $json = null

    )
    {

        $client = new Client();

        try {
            $result = $client->request(
                $method,
                $url,
                [
                    'http_errors' => false,
                    'headers'     => $headerData,
                    'form_params' => $params,
                    'timeout'     => $timeout,
                    'json'        => $json,
                ]
            );
        }
        catch (RequestException $e) {

            return false;
        }
        return $result->getBody()->getContents();
    }

}//class end

<?php
/**
 * Created by PhpStorm.
 * User: og
 * Date: 17/2/24
 * Time: 10:07
 */

namespace Slim\Utils;
 
use Slim\SlimPHP;
use Symfony\Component\HttpFoundation\Request;

class Page
{

    const PAGE_SIZE = 25;
    const PAGE_SITE = 6;


    public static function getPages(Request $request, $total)
    {

        $route       = $request->attributes->get('_route');
        $routeParams = $request->attributes->get('_route_params');

        parse_str($request->getQueryString(), $params);
        $params = array_merge($params, $routeParams);
        $page   = isset($params['page'])?$params['page']:1;

        $page_total = ceil($total / self::PAGE_SIZE);
        if ($page_total <= 1) {
            return false;
        }

        $data = [
            'page' => $page
        ];
        for ($i = 1; $i <= $page_total; $i++) {

            $params['page'] = $i;
            $url            = self::getPath($route, $params);
            if ((abs(($page - $i)) <= self::PAGE_SITE)) {
                $data['pages'][$i] = $url;
            }
        }

        if ($page > 1) {

            $params['page']   = 1;
            $data['first']    = self::getPath($route, $params);
            $params['page']   = $page - 1;
            $data['previous'] = self::getPath($route, $params);
        }

        if ($page < $page_total) {
            $params['page'] = $page + 1;
            $data['next']   = self::getPath($route, $params);
        }

        if ($page < $page_total) {
            $params['page'] = $page_total;
            $data['last']   = self::getPath($route, $params);
        }

        return $data;
    }

    public static function getPath($route, $paramss = [])
    { 
        return SlimPHP::app()->getHttpKernel()->path($route, $paramss);
    }
}

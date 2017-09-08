<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/9/1
 * Time: 11:10
 */

namespace Slim\Database;

use Doctrine\Common\Cache\MemcachedCache;
use Doctrine\ORM\Cache\DefaultCacheFactory;
use Doctrine\ORM\Cache\RegionsConfiguration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Slim\SlimPHP;

class Database
{

    /**
     * @return \Doctrine\ORM\EntityManager|null
     * @throws \Doctrine\ORM\ORMException
     */
    public static function getEntityManager()
    {

        static $entityManager = null;
        if ($entityManager instanceof EntityManager) {
            return $entityManager;
        }

        $memcache = self::getMemcache();
        $app      = SlimPHP::app();
        $config   = Setup::createAnnotationMetadataConfiguration(
            [PROJECT_DIR . "/src/Entities"],
            $app['debug'],
            $app['app.dir.data'] . "/proxies",
            $memcache,
            false /* do not use simple annotation reader, so that we can understand annotations like @ORM/Table */
        );
        $config->addEntityNamespace("", "Slim\\Entities");

        $regconfig = new RegionsConfiguration();
        $factory   = new DefaultCacheFactory($regconfig, $memcache);
        $config->setSecondLevelCacheEnabled();
        $config->getSecondLevelCacheConfiguration()->setCacheFactory($factory);

        $conn           = $app['app.db'];
        $conn["driver"] = "pdo_mysql";
        $entityManager  = EntityManager::create($conn, $config);

        return $entityManager;
    }

    /**
     * @return \Doctrine\Common\Cache\MemcachedCache
     */
    public static function getMemcache()
    {

        static $memcachedcache = null;
        if ($memcachedcache instanceof MemcachedCache) {
            return $memcachedcache;
        }
        $memcached      = SlimPHP::app()->getServiceId('memcached');
        $memcachedcache = new MemcachedCache();
        $memcachedcache->setMemcached($memcached);

        return $memcachedcache;
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/9/1
 * Time: 12:16
 */

namespace Slim\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Game
 * @package Oasis\Watch\Entities
 * @ORM\Entity()
 * @ORM\Table(name="games")
 */
class Game
{

    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="string", nullable=true, length=64)
     */
    protected $code;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $gameId;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=100)
     * the publish name of game
     */
    protected $name;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=100)
     * the chinese name of game
     */
    protected $zh_name;
    /**
     * language code like : tr,pt
     * @var string
     * @ORM\Column(type="string", nullable=true, length=100)
     */
    protected $lang;
    /**
     * @var int
     * @ORM\Column(type="integer",nullable=true,  options={"default":0})
     */
    protected $createTime;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    protected $domainName;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    protected $iconUrl;

    /**
     * @return string
     */
    public function getCode()
    {

        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {

        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getGameId()
    {

        return $this->gameId;
    }

    /**
     * @param int $gameId
     */
    public function setGameId($gameId)
    {

        $this->gameId = $gameId;
    }

    /**
     * @return string
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {

        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getZhName()
    {

        return $this->zh_name;
    }

    /**
     * @param string $zh_name
     */
    public function setZhName($zh_name)
    {

        $this->zh_name = $zh_name;
    }

    /**
     * @return string
     */
    public function getLang()
    {

        return $this->lang;
    }

    /**
     * @param string $lang
     */
    public function setLang($lang)
    {

        $this->lang = $lang;
    }

    /**
     * @return int
     */
    public function getCreateTime()
    {

        return $this->createTime;
    }

    /**
     * @param int $createTime
     */
    public function setCreateTime($createTime)
    {

        $this->createTime = $createTime;
    }

    /**
     * @return string
     */
    public function getDomainName()
    {

        return $this->domainName;
    }

    /**
     * @param string $domainName
     */
    public function setDomainName($domainName)
    {

        $this->domainName = $domainName;
    }

    /**
     * @return string
     */
    public function getIconUrl()
    {

        return $this->iconUrl;
    }

    /**
     * @param string $iconUrl
     */
    public function setIconUrl($iconUrl)
    {

        $this->iconUrl = $iconUrl;
    }
    
    
}

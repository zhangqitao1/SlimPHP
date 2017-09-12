<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/9/7
 * Time: 18:57
 */

namespace Slim\Entities;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package Slim\Entities
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{

    /**
     * @var integer
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=64)
     */
    private $username;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $password;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $enabled;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $accountNonExpired;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $credentialsNonExpired;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $accountNonLocked;
    /**
     * @var array
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $roles = [];

    public function __construct(
        $username, $password, array $roles = [], $enabled = true, $userNonExpired = true, $credentialsNonExpired = true,
        $userNonLocked = true
    )
    {

        if ('' === $username || null === $username) {
            throw new \InvalidArgumentException('The username cannot be empty.');
        }

        $this->username              = $username;
        $this->password              = $password;
        $this->enabled               = $enabled;
        $this->accountNonExpired     = $userNonExpired;
        $this->credentialsNonExpired = $credentialsNonExpired;
        $this->accountNonLocked      = $userNonLocked;
        $this->roles                 = $roles;
    }

    public function __toString()
    {

        return $this->getUsername();
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {

        return $this->roles;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {

        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {

        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonExpired()
    {

        return $this->accountNonExpired;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonLocked()
    {

        return $this->accountNonLocked;
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsNonExpired()
    {

        return $this->credentialsNonExpired;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {

        return $this->enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }

    /**
     * @param array  $roles
     */
    public function setRoles($roles)
    {

        $this->roles = $roles;
    }

    
}

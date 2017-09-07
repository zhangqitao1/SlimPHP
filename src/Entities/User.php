<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/9/7
 * Time: 18:57
 */

namespace Slim\Entities;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;

class User implements AdvancedUserInterface
{

    private $username;
    private $password;
    private $enabled;
    private $accountNonExpired;
    private $credentialsNonExpired;
    private $accountNonLocked;
    private $roles;

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
}

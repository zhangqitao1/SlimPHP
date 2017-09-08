<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/9/7
 * Time: 18:26
 */

namespace Slim\Providers;

use Slim\Entities\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{

    public function loadUserByUsername($username)
    {

        return new User($username, '$2y$10$3i9/lVd8UOFIJ6PAMFt8gu3/r5g0qeCJvoSlLCsvMTythye19F77a',['ADMIN_ROLE']);
    }

    /**
     * Refreshes the user for the account interface.
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     * @param UserInterface $user
     * @return UserInterface
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(UserInterface $user)
    {

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * Whether this provider supports the given user class.
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {

        return $class === 'Symfony\Component\Security\Core\User\User';
    }
}

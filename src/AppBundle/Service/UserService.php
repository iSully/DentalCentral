<?php
/**
 * Created by PhpStorm.
 * User: Sully
 * Date: 3/16/18
 * Time: 5:23 PM
 */

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class UserService
 * @package AppBundle\Service
 */
class UserService
{
    private $container;

    /**
     * UserService constructor.
     * @param $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return User|null
     */
    public function getUser() {
        return ($user = $this->container->get('security.token_storage')->getToken()->getUser(
        )) != null && $user != 'anon.' ? $user : null;
    }

    public function getRolesAsArray(){
        if ($this->getUser() === null){
            return [];
        }else {
            return $this->getUser()->getRoles();
        }
    }
}
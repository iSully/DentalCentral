<?php
/**
 * Created by PhpStorm.
 * User: Sully
 * Date: 3/16/18
 * Time: 5:01 PM
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table("users")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     */
    private $name;

    /**
     * @var Appointment[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Appointment", mappedBy="user")
     */
    private $appointments;

    /**
     * @var Appointment[]
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Appointment", mappedBy="staff")
     */
    private $staffAppointments;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
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



}
<?php
/**
 * Created by PhpStorm.
 * User: Sully
 * Date: 3/16/18
 * Time: 5:01 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Class User
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
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
     */
    protected $staffRole;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10)
     */
    private $phone;

    /**
     * @var Appointment[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Appointment", mappedBy="user")
     */
    private $appointments;

    /**
     * @var Appointment[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Appointment", mappedBy="dentist")
     */
    private $dentistAppointments;

    /**
     * @var Appointment[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Appointment", mappedBy="hygienist")
     */
    private $hygienistAppointments;

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
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return Appointment[]
     */
    public function getDentistAppointments()
    {
        $appointments = [];
        foreach ($this->dentistAppointments as $appointment) {
            if ($appointment->isActive()) {
                $appointments[] = $appointment;
            }
        }

        return $appointments;
    }


    /**
     * @param Appointment[] $dentistAppointments
     */
    public function setDentistAppointments($dentistAppointments)
    {
        $this->dentistAppointments = $dentistAppointments;
    }

    /**
     * @return Appointment[]
     */
    public function getHygienistAppointments()
    {
        $appointments = [];
        foreach($this->hygienistAppointments as $appointment){
            if($appointment->isActive()){
                $appointment[] = $appointment;
            }
        }
        return $appointments;
    }

    /**
     * @param Appointment[] $hygienistAppointments
     */
    public function setHygienistAppointments($hygienistAppointments)
    {
        $this->hygienistAppointments = $hygienistAppointments;
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
    public function getStaffRole()
    {
        return $this->staffRole;
    }

    /**
     * @param string $staffRole
     */
    public function setStaffRole($staffRole)
    {
        $this->staffRole = $staffRole;
    }

    /**
     * @return Appointment[]
     */
    public function getAppointments()
    {
        return $this->appointments;
    }

    /**
     * @param Appointment[] $appointments
     */
    public function setAppointments($appointments)
    {
        $this->appointments = $appointments;
    }

    public function isDentist()
    {
        return $this->getRole() === 'Dentist';
    }

    /**
     * @return string
     */
    public function getRole()
    {
        $roles = $this->getRoles();
        if (count($roles) > 0) {
            return ucwords(substr(strtolower($roles[0]), 5));
        }

        return 'Unknown';
    }

    public function isHygienist()
    {
        return $this->getRole() === 'Hygienist';
    }
}
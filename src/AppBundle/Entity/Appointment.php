<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Request\CancellationRequest;
use AppBundle\Entity\Request\ModificationRequest;
use Doctrine\ORM\Mapping as ORM;

/**
 * Appointment
 *
 * @ORM\Table(name="appointment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AppointmentRepository")
 */
class Appointment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="appointments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="dentistAppointments")
     * @ORM\JoinColumn(name="dentist_id", referencedColumnName="id")
     *
     */
    private $dentist;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="hygienistAppointments")
     * @ORM\JoinColumn(name="hygienist_id", referencedColumnName="id")
     *
     */
    private $hygienist;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime")
     */
    private $end;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var Notification[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notification", mappedBy="appointment")
     */
    private $notifications;

    /**
     * @var CancellationRequest
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Request\CancellationRequest", inversedBy="appointment")
     * @ORM\JoinColumn(name="cancel_id", referencedColumnName="id")
     */
    private $cancellationRequest;

    /**
     * @var ModificationRequest
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Request\ModificationRequest", inversedBy="appointment")
     * @ORM\JoinColumn(name="modification_id", referencedColumnName="id")
     */
    private $modificationRequest;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="integer")
     *
     * Determines if appointment is active or not
     */
    private $active;

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $start
     *
     * @return Appointment
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Appointment
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return User
     */
    public function getDentist()
    {
        return $this->dentist;
    }

    /**
     * @param User $dentist
     */
    public function setDentist($dentist)
    {
        $this->dentist = $dentist;
    }

    /**
     * @return User
     */
    public function getHygienist()
    {
        return $this->hygienist;
    }

    /**
     * @param User $hygienist
     */
    public function setHygienist($hygienist)
    {
        $this->hygienist = $hygienist;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     *
     * @return Appointment
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Appointment
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Notification[]
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @param Notification[] $notifications
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * @return CancellationRequest
     */
    public function getCancellationRequest()
    {
        return $this->cancellationRequest;
    }

    /**
     * @param CancellationRequest $cancellationRequest
     */
    public function setCancellationRequest($cancellationRequest)
    {
        $this->cancellationRequest = $cancellationRequest;
    }

    /**
     * @return ModificationRequest
     */
    public function getModificationRequest()
    {
        return $this->modificationRequest;
    }

    /**
     * @param ModificationRequest $modificationRequest
     */
    public function setModificationRequest($modificationRequest)
    {
        $this->modificationRequest = $modificationRequest;
    }
}


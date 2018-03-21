<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotificationRepository")
 */
class Notification
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var Appointment[]
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Appointment", inversedBy="notifications")
     * @ORM\JoinColumn(name="appointment_id", referencedColumnName="id")
     */
    private $appointment;


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
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Notification
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Appointment[]
     */
    public function getAppointment()
    {
        return $this->appointment;
    }

    /**
     * @param Appointment[] $appointment
     *
     * @return Notification
     */
    public function setAppointment($appointment)
    {
        $this->appointment = $appointment;

        return $this;
    }
}


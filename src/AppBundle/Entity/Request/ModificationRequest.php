<?php

namespace AppBundle\Entity\Request;

use AppBundle\Entity\Appointment;
use AppBundle\Entity\Request;
use Doctrine\ORM\Mapping as ORM;

/**
 * ModificationRequest
 *
 * @ORM\Table(name="request_modification_request")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Request\ModificationRequestRepository")
 */
class ModificationRequest extends Request
{
    /**
     * @var Appointment
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Appointment", mappedBy="modificationRequest")
     */
    private $appointment;

    /**
     * ModificationRequest constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return Appointment
     */
    public function getAppointment()
    {
        return $this->appointment;
    }

    /**
     * @param Appointment $appointment
     */
    public function setAppointment($appointment)
    {
        $this->appointment = $appointment;
    }
}


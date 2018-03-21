<?php

namespace AppBundle\Entity\Request;

use AppBundle\Entity\Appointment;
use AppBundle\Entity\Request;
use Doctrine\ORM\Mapping as ORM;

/**
 * CancellationRequest
 *
 * @ORM\Table(name="request_cancellation_request")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Request\CancellationRequestRepository")
 */
class CancellationRequest extends Request
{
    /**
     * @var Appointment
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Appointment", mappedBy="cancellationRequest")
     */
    private $appointment;

    /**
     * CancellationRequest constructor.
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


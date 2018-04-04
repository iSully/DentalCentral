<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class DashboardController
 * @package AppBundle\Controller
 *
 * @Route("/dashboard")
 */
class DashboardController extends Controller
{
    /**
     * Displays User Dashboard
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        $userRoles = $this->get('user_service')->getUser()->getRoles();
        $user = $this->get('user_service')->getUser();
        if ($user->isDentist()) {
            $appointments = $this->get('user_service')->getUser()->getDentistAppointments();
        } else {
            if ($user->isHygienist()) {
                $appointments = $this->get('user_service')->getUser()->getHygienistAppointments();
            } else {
                $appointments = $this->get('user_service')->getUser()->getAppointments();
            }
        }


        return $this->render('@App/dashboard.html.twig', ['appointments' => $appointments, 'user' => $user]);
    }

    public function cancelAction(Request $request, $appointmentId)
    {
        $appointment = $this->getDoctrine()->getRepository('AppBundle:Appointment')->find($appointmentId);
    }

    public function modifyAction(Request $request, $appointmentId)
    {
        $appointment = $this->getDoctrine()->getRepository('AppBundle:Appointment')->find($appointmentId);
    }

}

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
     * @Route("/", name="dashboard")
     */
    public function indexAction(Request $request)
    {
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

        //TODO: Add Upcoming Appointments Notification [Within 7 Days of Today]
        return $this->render(
            '@App/dashboard.html.twig',
            ['appointments' => $appointments, 'user' => $user]
        );
    }

    public function cancelAction(Request $request, $appointmentId)
    {
        $appointment = $this->getDoctrine()->getRepository('AppBundle:Appointment')->find($appointmentId);
    }

    public function modifyAction(Request $request, $appointmentId)
    {
        $appointment = $this->getDoctrine()->getRepository('AppBundle:Appointment')->find($appointmentId);
    }

    /**
     * @param Request $request
     *
     * @Route("/clear", name="clearCancelled")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeCancelledAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->get('user_service')->getUser();
        $repository = $this->getDoctrine()->getRepository("AppBundle:Appointment");
        $userAppointments = $repository->findBy(['user' => $user]);
        foreach ($userAppointments as $a) {
            if (!$a->isActive()) {
                $entityManager->remove($a);
            }
        }
        $entityManager->flush();

        return $this->redirectToRoute("dashboard");
    }

}

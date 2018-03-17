<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Appointment;
use AppBundle\Form\AppointmentForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AppointmentsController
 * @package AppBundle\Controller
 *
 * @Route("/appointments")
 */
class AppointmentsController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/list", name="list_appointments")
     */
    public function listAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var Appointment[] $appointments */
        $appointments = $entityManager->getRepository("AppBundle:Appointment")->findAll();

        return $this->render('@App/list_appointments.html.twig', array('appointments' => $appointments));
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/add")
     */
    public function addAction(Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $appointment = new Appointment();
        $form = $this->createForm(AppointmentForm::class, $appointment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($appointment);
            $entityManager->flush();
            return $this->redirectToRoute('list_appointments');
        }
        return $this->render('@App/add_appointment.html.twig', array('form' => $form->createView()));
    }
}

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

    /*
     * Checks for overlapping schedule events. Verification before adding to DB in addAction()
     */
    public function checkOverlap(Appointment $new, Appointment $existing)
    {
        return ($new->getStart() < $existing->getEnd() && $existing->getStart() < $new->getEnd());
    }


    /**
     * @param Request $request
     *
     */
    //TODO: DELETE APPOINTMENT FUNCTION
//    public function deleteAction(Request $request){
//        $entityManager = $this->getDoctrine()->getManager();
//        $repository = $entityManager->getRepository("AppBundle:Appointment");
//        $appointment = new Appointment();
//    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="appointments")
     */
    public function addAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository("AppBundle:Appointment");
        $appointment = new Appointment();
        $form = $this->createForm(AppointmentForm::class, $appointment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $appointmentId = null;
            
            //Updates Appointment info when edited on calendar
            //TODO: Resolve Overlapping
            if (($appointmentId = $request->get('appointment_id')) !== null && strlen($appointmentId) > 0) {
                $appointmentId = intval($appointmentId);

                $newAppointment = $appointment;
                $appointment = $repository->findOneBy(['id' => $appointmentId]);
                $appointment->setDentist($newAppointment->getDentist());
                $appointment->setUser($newAppointment->getUser());
                $appointment->setHygienist($newAppointment->getHygienist());
                $appointment->setStart($newAppointment->getStart());
                $appointment->setEnd($newAppointment->getEnd());
            }

            //Update repository to track and manage updated appointments
            $repository = $entityManager->getRepository("AppBundle:Appointment");

            $error = null;
            foreach ($repository->findAll() as $a) {
                //TODO: FIX THIS IF STATEMENT TO WORK FOR UPDATED APPOINTMENTS
                if ($appointmentId === null || $a->getId() !== $appointmentId) {
                    if ($a->getDentist()->getId() == $appointment->getDentist()->getId()) {
                        if ($this->checkOverlap($appointment, $a)) {
                            $error = 'Dentist is already working a shift at this time';
                        }
                    }

                    if ($error === null && $a->getHygienist()->getId() == $appointment->getHygienist()->getId()) {
                        if ($this->checkOverlap($appointment, $a)) {
                            // Manage error
                            $error = 'Hygienist is already working a shift at this time';
                        }
                    }
                    if ($error === null && $a->getUser()->getId() == $appointment->getUser()->getId()) {
                        if ($this->checkOverlap($appointment, $a)) {
                            $error = 'Client already has an appointment at this time';
                        }
                    }
                }
            }

            if ($error === null) {
                $entityManager->persist($appointment);
                $entityManager->flush();
            }

            return $this->redirectToRoute('appointments', ['error' => $error]);
        }

        /** @var Appointment[] $appointments */
        $appointments = $repository->findAll();

        return $this->render(
            '@App/appointments.html.twig',
            ['form' => $form->createView(), 'appointments' => $appointments, 'error' => $request->get('error')]
        );
    }
}

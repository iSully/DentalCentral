<?php
/**
 * Created by PhpStorm.
 * User: Sully
 * Date: 5/2/18
 * Time: 10:54 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\ContactFormSubmission;
use AppBundle\Form\ContactForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class DashboardController
 * @package AppBundle\Controller
 */
class ContactController extends Controller
{
    /**
     * @Route("/contact", name="email")
     *
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendEmail(Request $request, \Swift_Mailer $mailer)
    {
        $contactForm = new ContactFormSubmission();
        $form = $this->createForm(ContactForm::class, $contactForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = (new \Swift_Message('Hello Email'))
                ->setTo($this->getParameter('mailer_user'))
                ->setFrom($contactForm->getEmail())
                ->setBody(
                    $this->renderView(
                        '@App/contact_submission.html.twig',
                        [
                            'title' => $contactForm->getTitle(),
                            'name' => $contactForm->getName(),
                            'email' => $contactForm->getEmail(),
                            'message' => $contactForm->getMessage(),
                        ]
                    ),
                    'text/html'
                );

            $mailer->send($message);

            $this->get('session')->getFlashBag()->add('mail_confirmed', true);

            return $this->redirectToRoute('help');
        }

        return $this->render('@App/contact.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/help", name="help")
     */
    public function helpAction(Request $request)
    {
        $confirmed = $this->get('session')->getFlashBag()->get('mail_confirmed');
        if (isset($confirmed) && count($confirmed) > 0) {
            $confirmed = $confirmed[0];
        } else {
            $confirmed = false;
        }

        return $this->render('::help.html.twig', ['confirmed' => $confirmed]);
    }
}
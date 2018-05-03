<?php
/**
 * Created by PhpStorm.
 * User: Sully
 * Date: 5/2/18
 * Time: 10:54 PM
 */

namespace AppBundle\Controller;

use AppBundle\Form\ContactForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class DashboardController
 * @package AppBundle\Controller
 *
 * @Route("/contact")
 */
class ContactController extends Controller
{
    /**
     * @Route("/", name="email")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendEmail(Request $request)
    {
        $form = $this->createForm(ContactForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('email_confirm');
        }

        return $this->redirectToRoute('help');
    }


    /**
     * @param Request $request
     *
     * @Route("/confirm", name="email_confirm")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function confirmed(Request $request)
    {
        echo "<h1>Email Sent Successfully!</h1>";

        return $this->redirectToRoute("dashboard");
    }
}
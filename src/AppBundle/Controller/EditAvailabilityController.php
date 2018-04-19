<?php
/**
 * Created by PhpStorm.
 * User: Sully
 * Date: 4/10/18
 * Time: 11:45 AM
 */

namespace AppBundle\Controller;

use AppBundle\Form\EditAvailabilityForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EditProfileController
 * @package AppBundle\Controller
 *
 * @Route("/availability")
 */
class EditAvailabilityController extends Controller
{

    /**
     * @Route("/edit")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditAvailabilityForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

        }

        return $this->render('@App/edit_availability.html.twig', ['form' => $form->createView()]);
    }
}
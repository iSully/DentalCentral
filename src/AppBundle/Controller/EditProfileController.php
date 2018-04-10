<?php
/**
 * Created by PhpStorm.
 * User: Sully
 * Date: 4/10/18
 * Time: 11:45 AM
 */

namespace AppBundle\Controller;

use AppBundle\Form\EditProfileForm;
use AppBundle\Form\UserEditForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class EditProfileController
 * @package AppBundle\Controller
 *
 * @Route("/edit-profile")
 */
class EditProfileController extends Controller
{

    /**
     * @Route("/")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository("AppBundle:User")->findOneBy(['id' => $id]);
        $form = $this->createForm(EditProfileForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


        }

        return $this->render('@App/edit-profile.html.twig', ['form' => $form->createView()]);
    }
}
<?php
namespace App\Controller\Security;

use App\Form\Security\RegistrationForm;
use App\Entity\User;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends AbstractController
{

    /**
     * @Route("/register", name="new_user")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm( RegistrationForm::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            try {
                $entityManager->flush();
            }
            catch (UniqueConstraintViolationException $e)
            {
                return $this->redirectToRoute('fail', array('type'=>"registration",
                    'text' => "This name or email is already taken, try to enter differently"
                ));
            };
            return $this->redirectToRoute('success',array('type'=>"register"),301);
        }
        return $this->render(
            'security/register.html.twig',
            array('form' => $form->createView())
        );
    }
}
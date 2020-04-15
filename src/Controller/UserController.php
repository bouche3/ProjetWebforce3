<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/inscription")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $manager)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            if ($form->isValid()){
                //encryptage du mot de passe à partir de la config encoders de config/package/security.yaml
                $encodedPassword = $passwordEncoder->encodePassword(
                    $user,
                    $user->getPlainpassword()
                );

                $user->setPassword($encodedPassword);

                //On enregistre l'avatar s'il y en a un qui a été uploadé
                /**
                 * @var UploadedFile|null $avatar
                 */
                $avatar = $user->getAvatar();

                //Si une image a été uploadée
                if (!is_null($avatar)){
                    $filename = uniqid() . '.' . $avatar->guessExtension();

                    $avatar->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $user->setAvatar($filename);

                    dump($user);
                }

                $manager->persist($user);
                $manager->flush();

                $this->addFlash('success', 'Votre compte est créé');

                return $this->redirectToRoute('app_index_index');

            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render(
            'user/register.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/connexion")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        dump($_POST);

        if (!empty($error)){
            $this->addFlash('error', 'Identifiants incorrects');
        }

        return $this->render(
            'user/login.html.twig',
            [
                'last_username' => $lastUsername
            ]
        );
    }

    /**
     * @Route("/deconnexion")
     */
    public function logout()
    {
        //Rien à mettre, c'est le paramétrage de security qui va en fait s'en occuper : le logout va chercher la méthode à travers app_user_logout
    }
}

<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
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
     *
     * @Route("/forgotten_password")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function forgottenPassword(
        Request $request,
        MailerInterface $mailer,
        TokenGeneratorInterface $tokenGenerator) :Response
    {
        if($request->isMethod('POST'))
        {
            $email=$request->request->get('email');
            $entityManager=$this->getDoctrine()->getManager();
            $user=$entityManager->getRepository(User::class)->findOneByEmail($email);
            dump($user,$email);
            if($user==null)
            {
                $this->addFlash('danger','Email Inconnu');
                // return $this->redirectToRoute('app_user_login');
            }
            $token=$tokenGenerator->generateToken();
            try {
                $user->setResetToken($token);
                $entityManager->flush();
            }
            catch(\Exception $e)
            {
                $this->addFlash('warning',$e->getMessage());
                return $this->redirectToRoute('app_user_login');
            }
            $url=$this->generateUrl('app_reset_password',array('token'=>$token),UrlGeneratorInterface::ABSOLUTE_URL);
            $mail=new email();
            $mail
                ->subject('Forgot password')
                ->from('janest.demo@gmail.com')
                ->to($user->getEmail())
                ->html(" voici le token pour reseter votre mot de passe : " . $url,
                    'text/html')
            ;
            $mailer->send($mail);
            $this->addFlash('success','Mail envoyé');
            return $this->redirectToRoute('app_user_login');

        }
        return $this->render('user/forgotten_password.html.twig');


    }
    /**
     * @Route("/reset_password/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {

        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();

            $user = $entityManager->getRepository(User::class)->findOneByResetToken($token);
            /* @var $user User */

            if ($user === null) {
                $this->addFlash('danger', 'Token Inconnu');
                return $this->redirectToRoute('app_user_login');
            }

            $user->setResetToken($token);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $entityManager->flush();

            $this->addFlash('success', 'Mot de passe mis à jour');

            return $this->redirectToRoute('app_index_index');
        }else {

            return $this->render('user/reset_password.html.twig', ['token' => $token]);
        }

    }

    /**
     * @Route("/deconnexion")
     */
    public function logout()
    {
        //Rien à mettre, c'est le paramétrage de security qui va en fait s'en occuper : le logout va chercher la méthode à travers app_user_logout
    }
}

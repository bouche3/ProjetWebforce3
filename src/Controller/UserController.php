<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PassEditType;
use App\Form\RegistrationType;
use App\Form\UserInfoType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * Alexandre
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
     * Alexandre
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

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
     * Affichage des informations du membre, pour le membre connecté
     * @Route("/information/{id}", requirements={"id": "\d+"})
     * Alexandre
     */
    public function info(UserRepository $repository, $id)
    {
        //Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
        if(!$this->getUser()){
            $this->redirectToRoute('app_user_login');
        }

        //On essaye de récupérer les informations de l'utilisateur connecté via son id
        $user = $repository->findOneBy(['id' => $id]);

        //Si on ne trouve pas de correspondance, on jette une exception
        if (is_null($user)){
            throw new NotFoundHttpException();
        }


        return $this->render(
            'user/information.html.twig',
            [
                'user' => $user
            ]
        );
    }

    /**
     * Modification des informations du membre, pour le membre connecté
     * @Route("/informations/edit/{id}", requirements={"id": "\d+"})
     * Alexandre
     */
    public function infoEdit(Request $request, EntityManagerInterface $manager, $id)
    {

        //Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
        if(!$this->getUser()){
            $this->redirectToRoute('app_user_login');
        }

        //On récupère les informations de l'utilisateur pour alimenter le formulaire
        $user = $manager->find(User::class, $id);

        //Si on ne trouve pas de correspondance, on jette une exception
        if (is_null($user)){
            throw new NotFoundHttpException();
        }

        //On vérifie s'il y a un avatar existant ou pas
        $originalAvatar = null;
        if (!is_null($user->getAvatar())){
            //S'il existe on le met dans la variable originalAvatar
            $originalAvatar = $user->getAvatar();

            //Le champ de formulaire attend un objet File
            $user->setAvatar(
                new File($this->getParameter('upload_dir') . $user->getAvatar())
            );
        }

        $form = $this->createForm(UserInfoType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if ($form->isValid()) {

                //Lorsque le formulaire est soumis et validé, on gère l'image uploadée si elle existe
                /**
                 * @var UploadedFile|null $avatar
                 */
                $avatar = $user->getAvatar();
                //Si une image a été uploadée
                if (!is_null($avatar)){
                    //On renomme le fichier avec un identifiant unique
                    $filename = uniqid() . '.' . $avatar->guessExtension();
                    //On sauvegarde ce fichier dans le dossier définit dans les paramètres du projet
                    $avatar->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    //pour enregistrer le nom du fichier dans le champ image de la bdd
                    $user->setAvatar($filename);

                    //Dans le cas d'une modification, si on change l'image, on supprime dans le dossier image
                    //celle qui avait été uploadée
                    if (!is_null($originalAvatar)){
                        unlink($this->getParameter('upload_dir') . $originalAvatar);
                    }
                } else {
                    //Si aucun avatar n'a été uploadé
                    //on remet le nom de l'image venant de la bdd
                    $user->setAvatar($originalAvatar);
                }

                $manager->persist($user);
                $manager->flush();

                $this->addFlash('success', 'Les données ont été modifiées avec succès');

                return $this->redirectToRoute('app_user_info', ['id'=>$id]);
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render(
            'user/information_edit.html.twig',
            [
                'form' => $form->createView(),
                'original_avatar' => $originalAvatar
            ]
            );

    }

    /**
     * Modification du mot de passe pour le membre connecté
     * @Route("/informations/pass_edit/{id}", requirements={"id": "\d+"})
     * Alexandre
     */
    public function passEdit(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder, $id)
    {

        //On récupère les informations de l'utilisateur via son id
        $user = $manager->find(User::class, $id);

        //Si on ne trouve pas de correspondance, on jette une exception
        if (is_null($user)){
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(PassEditType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //On récupère le old password saisi
            $oldPassword = $request->request->get('pass_edit')['oldPassword'];

            // Si l'ancien mot de passe est bon
            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {

                $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPlainpassword());

                $user->setPassword($newEncodedPassword);

                $manager->persist($user);

                $manager->flush();

                $this->addFlash('success', 'Votre mot de passe à bien été changé');

                return $this->redirectToRoute('app_user_info', ['id' => $id]);

            } else {

                $this->addFlash('error', 'Ancien mot de passe incorrect');

            }

        }

        return $this->render(
            'user/information_pass_edit.html.twig',
            [
                'form' => $form->createView(),
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

<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\MemberEditType;
use App\Form\MemberType;
use App\Form\SearchMemberType;
use App\Form\UserInfoType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/**
 *
 *class MemberController
 * @package App\Controller\Admin
 * @route("/member")
 *
 */
class MemberController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function index(Request $request, UserRepository $repository)
    {
        $searchForm = $this->createForm(SearchMemberType::class);

        $searchForm->handleRequest($request);

        //les données par le formulaire
        dump($searchForm->getData());

        // toutes les members triées sur l'id
        //$memberDetails = $repository->findBy([], ['id' => 'ASC']);
        $memberDetails = $repository->search((array)$searchForm->getData());

        return $this->render(
            'admin/member/index.html.twig',

            [
                'memberDetails' => $memberDetails,
                'search_form' => $searchForm->createView()
            ]
        );
    }

    /**
     * @Route("/edition/{id}", defaults={"id": null}, requirements={"id": "\d+"})
     */
    public function addEdit(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder, $id)
    {
        $originalImage = null;
        if (is_null($id)) {
            //creation of the new member
            $member = new User();
            dump($member);

        }


        //creation of the form
        $form = $this->createForm(MemberType::class, $member,["validation_groups"=>['Default','create']]);
        //analysis of the query
        $form->handleRequest($request);
        dump($member);
        //if the form is submitted

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $encodedPassword = $passwordEncoder->encodePassword(
                    $member,
                    $member->getPlainpassword()
                );

                $member->setPassword($encodedPassword);
                //On enregistre l'avatar s'il y en a un qui a été uploadé
                /**
                 * @var UploadedFile|null $avatar
                 */
                $avatar = $member->getAvatar();


                //Si une avatar a été uploadée
                if (!is_null($avatar)) {
                    $filename = uniqid() . '.' . $avatar->guessExtension();

                    $avatar->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $member->setAvatar($filename);
                    // suppression de l'ancienne image en modification s'il y en a une
                    if (!is_null($originalImage)) {
                        unlink($this->getParameter('upload_dir') . $originalImage);
                    }
                } else {
                    // pour la modification, sans upload,
                    // on remet le nom de l'image venant de la bdd
                    $member->setAvatar($originalImage);
                }


                $manager->persist($member);
                $manager->flush();
                $this->addFlash('success', 'Le membre a bien été enregistré');
                return $this->redirectToRoute('app_admin_member_addedit');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render('admin/member/addEdit.html.twig',
            [
                'form' => $form->createView(),
                'original_image' => $originalImage
            ]
        );
      //  $form = $this->createForm(MemberType::class, $member)

    }

    /**
     * @Route("/modifyEdit/{id}", defaults={"id": null}, requirements={"id": "\d+"})
     */
    public function modifyEdit(Request $request, EntityManagerInterface $manager, $id)
    {

        //On récupère les informations de l'utilisateur pour alimenter le formulaire
        $member = $manager->find(User::class, $id);

        //Si on ne trouve pas de correspondance, on jette une exception
        if (is_null($member))
        {
            throw new NotFoundHttpException();
        }

        //On vérifie s'il y a un avatar existant ou pas
        $originalAvatar = null;
        if (!is_null($member->getAvatar()))
        {
            //S'il existe on le met dans la variable originalAvatar
            $originalAvatar = $member->getAvatar();

            //Le champ de formulaire attend un objet File
            $member->setAvatar(
                new File($this->getParameter('upload_dir') . $member->getAvatar())
            );
        }

        $form = $this->createForm(MemberEditType::class, $member);

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->isValid())
            {

                //Lorsque le formulaire est soumis et validé, on gère l'image uploadée si elle existe
                /**
                 * @var UploadedFile|null $avatar
                 */
                $avatar = $member->getAvatar();
                //Si une image a été uploadée
                if (!is_null($avatar)) {
                    //On renomme le fichier avec un identifiant unique
                    $filename = uniqid() . '.' . $avatar->guessExtension();
                    //On sauvegarde ce fichier dans le dossier définit dans les paramètres du projet
                    $avatar->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    //pour enregistrer le nom du fichier dans le champ image de la bdd
                    $member->setAvatar($filename);

                    //Dans le cas d'une modification, si on change l'image, on supprime dans le dossier image
                    //celle qui avait été uploadée
                    if (!is_null($originalAvatar)) {
                        unlink($this->getParameter('upload_dir') . $originalAvatar);
                    }
                } else {
                    //Si aucun avatar n'a été uploadé
                    //on remet le nom de l'image venant de la bdd
                    $member->setAvatar($originalAvatar);
                }

                $manager->persist($member);
                $manager->flush();

                $this->addFlash('success', 'Les données ont été modifiées avec succès');

                return $this->redirectToRoute('app_admin_member_index', ['id' => $id]);
            }
            else
                {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }

        }
        return $this->render(
            'admin/member/memberEdit.html.twig',
            [
                'form' => $form->createView(),
                'original_avatar' => $originalAvatar
            ]
        );
    }


    /**
     * @Route("/delete/{id}", requirements={"id": "\d+"})
     */
    public function delete(EntityManagerInterface $manager, User $user)
    {
        // suppression de l'avatar si l'member en a une
        if (!is_null($user->getAvatar())) {
            $avatar = $this->getParameter('upload_dir') . $user->getAvatar();

            if (file_exists($avatar)) {
                unlink($avatar);
            }
        }
           //suppression en BDD
            $manager->remove($user);
            $manager->flush();
            $this->addFlash('success',"Le membre a bien été supprimé");

        return $this->redirectToRoute('app_admin_member_index');

    }

}
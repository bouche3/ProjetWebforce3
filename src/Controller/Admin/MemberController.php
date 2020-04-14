<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\MemberType;
use App\Form\SearchMemberType;
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
 */
class MemberController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function index(Request $request,UserRepository $repository)
    {
        $searchForm=$this->createForm(SearchMemberType::class);

        $searchForm->handleRequest($request);

        //les données par le formulaire
        dump($searchForm->getData());

        // toutes les members triées sur l'id
       //$memberDetails = $repository->findBy([], ['id' => 'ASC']);
        $memberDetails=$repository->search((array)$searchForm->getData());

        return $this->render(
            'admin/member/index.html.twig',

            [
                'memberDetails' => $memberDetails,
                'search_form'=>$searchForm->createView()
            ]
        );
    }

    /**
     * @Route("/edition/{id}", defaults={"id": null}, requirements={"id": "\d+"})
     */
    public function edit(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder,$id)
    {
        $originalImage = null;
        if (is_null($id))
        {
            //creation of the new member
            $member = new User();
            dump($member);

        }
        else
            {
            //Modification of the member
            $member = $manager->find(User::class, $id);
            //if the id doesnt exist in the database
            if (is_null($member))
            {
                //404 - page not found error
                throw new NotFoundHttpException();
            }
            if(!is_null($member->getAvatar()))
            {
                //nom du fichier venant de la bdd
                $originalImage=$member->getAvatar();
                //le champ de formulaire attend un object file
                $member->setAvatar(
                    new File(
                        $this->getParameter('upload_dir').$member->getAvatar()
                    ));
            }
        }

        //creation of the form
        $form = $this->createForm(MemberType::class, $member);
        //analysis of the query
        $form -> handleRequest($request);
        dump($member);
        //if the form is submitted

        if ($form->isSubmitted())
        {
            if ($form->isValid())
            {

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
                if (!is_null($avatar)){
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
                }
             else {
                // pour la modification, sans upload,
                // on remet le nom de l'image venant de la bdd
                $member->setAvatar($originalImage);
            }


                $manager->persist($member);
                $manager->flush();
                $this->addFlash('success', 'Le member est bien enregistré');
                return $this->redirectToRoute('app_admin_member_index');
            }
            else
            {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render('admin/member/edit.html.twig',
            [
                'form' => $form->createView(),
                'original_image'=>$originalImage
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
            $this->addFlash('success',"Le membre est supprimée");

        return $this->redirectToRoute('app_admin_member_index');

    }

}
<?php


namespace App\Controller\Admin;


namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\MemberType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

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
    public function index()
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    /**
     * @Route("/edition/{id}", defaults={"id": null}, requirements={"id": "\d+"})
     */
    public function edit(Request $request, EntityManagerInterface $manager, $id)
    {
        if (is_null($id)) {
            //creation of the new member
            $member = new User();
            dump($member);

        } else
            {
            //Modification of the member
            $member = $manager->find(User::class, $id);
            //if the id doesnt exsist in the database
            if (is_null($member))
            {

                throw new NotFoundHttpException();
            }
        }

        //creation of the form
        $form = $this->createForm(MemberType::class, $member);
        //analysis of the query
        $form -> handleRequest($request);
        dump($member);
        //if the form is submitted
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $manager->persist($member);
                $manager->flush();
                $this->addFlash('success', 'Le member est bien enregistré');
                return $this->redirectToRoute('app_admin_member_index');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render('admin/member/edit.html.twig',
            [
                'form' => $form->createView()
            ]
        );

    }

    public function delete(EntityManagerInterface $manager, User $user )
    {
        if(!$user->getId()->isEmpty())
        {
            $this->addFlash('warning',"Le membre n'est pas disponible");
        }
        else
        {
            $manager->remove($user);
            $manager->flush();
            $this->addFlash('success',"Le membre est supprimée");
        }
        return $this->redirectToRoute('app_admin_member_index');

    }

}
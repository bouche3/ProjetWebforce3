<?php


namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentsearchType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class CommentController
 * @package App\Controller\Admin
 * @Route("/commentaires")
 **/
class CommentController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/article/{id}")
     */
    public function index(article $article)
    {
        return $this->render(
        'admin/comment/index.html.twig',
        [
        'article' => $article
        ]
        );
    }

    /**
     * @param Request $request
     * @param CommentRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/")
     */
    public function searchComment(Request $request,CommentRepository $repository)
    {
        $searchForm=$this->createForm(CommentsearchType::class);
        $searchForm->handleRequest($request);
        dump($request->getMethod());
        dump($searchForm->getData());
        dump($searchForm);
      //  $comments=$repository->findAll();
        $comments=$repository->search((array)$searchForm->getData());

        dump($comments);
             return $this->render(
            'admin/comment/commentspage.html.twig',
            [
                //'comment'=>$comment,
                'comments'=>$comments,
                'searchForm'=>$searchForm->createView()
            ]
        );

    }

    /**
     * @param EntityManagerInterface $manager
     * @param Comment $comment
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/supression/{id}")
     */
    public function delete(EntityManagerInterface $manager,Comment $comment)
    {
        $manager->remove($comment);
        $manager->flush();
        $this->addFlash('success','Le commentaire est supprimé');

        return $this->redirectToRoute(
            'app_admin_comment_searchcomment'
        );
    }

    /**
     * @Route("/modif/{id}", defaults={"id": null}, requirements={"id": "\d+"})
     *
     */
    public function modification(Request $request, EntityManagerInterface $manager,
                                 Comment $comment,CommentRepository $repository)
    {
        $article = $comment->getArticleid();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $manager->persist($comment);
                $manager->flush();

                $this->addFlash('success', 'Votre commentaire est enregistré');

                return $this->redirectToRoute(
                    'app_article_renderimagetemplate',
                    [
                        'id' => $article->getId()
                    ]
                );
            } else {
                $this->addFlash('error', 'Le formulaire contient erreurs');
            }

        }
        dump($comment);

        return $this->render(
            'admin/comment/modification.html.twig',
            [
                'comments'=>$comment,
                'article' => $article,
                'form' => $form->createView()
            ]

        );

    }

   }
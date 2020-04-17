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
 * @ROute("/commentaires")
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
     * @Route("/")
     */
    public function search(Request $request,
                          CommentRepository $repository)
    {
        $searchForm=$this->createForm(CommentsearchType::class);
        $searchForm->handleRequest($request);

        dump($searchForm->getData());
        $comments=$repository->findAll();
        $comment=$repository->search((array)$searchForm->getData());
             return $this->render(
            'admin/comment/commentspage.html.twig',
            [
                'comment'=>$comment,
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
            'app_admin_comment_index',
            [
                'id'=>$comment->getArticleid()->getId()
            ]
        );
    }
    /**
     * @Route("/edition/{id}", defaults={"id": null}, requirements={"id": "\d+"})
     */
    public function modification(Request $request, EntityManagerInterface $manager,
                                 Article $article,CommentRepository $repository,$id)
    {

        $commentModify=$manager->find(Comment::class,$id);

        $form = $this->createForm(CommentType::class, $commentModify);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $commentModify
                    ->setUserid($this->getuser())
                    ->setArticleid($article);

                $manager->persist($commentModify);
                $manager->flush();

                $this->addFlash('success', 'Votre commentaire est enregistré');

                return $this->redirectToRoute(
                    'app_admin_article_renderimagetemplate',
                    [
                        'id' => $article->getId()
                    ]
                );
            } else {
                $this->addFlash('error', 'Le formulaire contient erreurs');
            }

        }
        $modifyComments=$repository->findBy(['articleid' =>$id], ['id' => 'DESC']);

        return $this->render(
            'admin/comment/modification.html.twig',
            [

                'article' => $article,
                'comments'=>$modifyComments,
                'form' => $form->createView()
            ]

        );

    }

   }
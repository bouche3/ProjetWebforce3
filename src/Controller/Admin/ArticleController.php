<?php


namespace App\Controller\Admin;


use App\Entity\Article;
use App\Form\SearchArticleType;
use App\Form\TemplateType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class ArticleController
 * @package App\Controller\Admin
 *
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     * @param ArticleRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ArticleRepository $repository, Request $request)
    {

        $searchForm = $this->createForm(SearchArticleType::class);

        $searchForm->handleRequest($request);

        $articles = $repository->search((array)$searchForm->getData());

        return $this->render(
            'admin/article/index.html.twig',
            [
                'articles' => $articles,
                'search_form' => $searchForm->createView(),
            ]
            );
    }

    /**
     * @Route("/edition/{id}", defaults={"id": null}, requirements={"id": "\d+"})
     */
    public function addEditArticle(Request $request, EntityManagerInterface $manager, $id)
    {

        if(is_null($id)){
            $article = new Article();
            $article->setUserid($this->getUser());
        }
        else{
            $article = $manager->find(Article::class, $id);

            if(is_null($article)){
                throw new NotFoundHttpException();
            }
        }

        $form = $this->createForm(TemplateType::class, $article);
        $form->handleRequest($request);

        dump($article);

        if($form->isSubmitted()){
            if($form->isValid()){

                $manager->persist($article);
                $manager->flush();
                dump($article);

                if($article->getNameTemplate()->getId() == 1){
                    return $this->redirectToRoute(
                        'app_admin_article_renderarticleimage',
                    [
                        'id'=>$article->getId()
                    ]
                );
                }
                elseif($article->getNameTemplate()->getId() == 2){
                    return $this->redirectToRoute('app_index_index');
                }
                elseif ($article->getNameTemplate()){
                    return $this->redirectToRoute('app_index_index');
                }

            }
        }

        return $this->render(
            'admin/article/add_edit_article.html.twig',
            [
                'form'=>$form->createView()
            ]
            );
    }

    /**
     * @Route("/i/{id}", requirements={"id": "\d+"})
     */
    public function renderArticleImage()
    {

        return $this->render('admin/article/render_i_article.html.twig');
    }
}
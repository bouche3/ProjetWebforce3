<?php


namespace App\Controller\Admin;


use App\Entity\Article;
use App\Form\TemplateType;
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
     */
    public function index()
    {
        return $this->render('admin/article/index.html.twig');
    }

    /**
     * @Route("/edition/{id}", defaults={"id": null}, requirements={"id": "\d+"})
     */
    public function addEditArticle(Request $request, EntityManagerInterface $manager, $id)
    {

        if(is_null($id)){
            $article = new Article();
//            $article->setUserid($this->getUser());
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

//                $manager->persist($article);
//                $manager->flush();

                if($article->getNameTemplate() == 'Template orienté image'){
                    return $this->redirectToRoute('app_index_index');
                }
                elseif($article->getNameTemplate() == 'Template orienté texte'){
                    return $this->redirectToRoute('app_index_index');
                }
                elseif ($article->getNameTemplate() == 'Template orienté mixte'){
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
    public function renderArticle()
    {
        return $this->render('admin/article/render_i_article.html.twig');
    }
}
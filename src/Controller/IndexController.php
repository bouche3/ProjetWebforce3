<?php

namespace App\Controller;

use App\Form\SearchArticleIndexType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(Request $request, ArticleRepository $repository, PaginatorInterface $paginator)
    {
        $searchForm = $this->createForm(SearchArticleIndexType::class);
        $searchForm->handleRequest($request);
        dump($searchForm->getData());

        $donnees = $repository->searchIndex((array)$searchForm->getData());


        $articles = $paginator->paginate(
            $donnees, // on passe les données
            $request->query->getInt('page', 1), //  si jamais il n'y as pas de page en cour, page 1 par défaut
            2
        );
        dump($articles);

        return $this->render(
            'index/index.html.twig',
            [
                'articles'=>$articles,
                'search_form'=>$searchForm->createView()
            ]
        );
    }


}
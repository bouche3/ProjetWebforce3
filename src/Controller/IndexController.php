<?php

namespace App\Controller;

use App\Form\SearchArticleIndexType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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

    /**
     * @Route("/contact")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function contact(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);

        // pré-remplissage des champs si l'utilisateur est connecté
        if (!is_null($this->getUser())) {
            $form->get('name')->setData($this->getUser());
            $form->get('email')->setData($this->getUser()->getEmail());
        }

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $data = $form->getData();

                $mail = new Email();

                // renderView retourne le rendu d'un template
                // sous forme d'une chaîne de caractères
                $mailBody = $this->renderView(
                    'index/contact_body.html.twig',
                    [
                        'data' => $data
                    ]
                );

                $mail
                    ->subject('Nouveau message sur votre blog')
                    ->from('janest.demo@gmail.com')
                    ->to('rattelise.jlr@gmail.com')
                    ->replyTo($data['email'])
                    ->html($mailBody)
                ;

                $mailer->send($mail);

                $this->addFlash('success', 'Votre message est envoyé');

                 return $this->redirectToRoute('app_index_contact');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }

        }

        return $this->render(
            'index/contact.html.twig',
            [
                'form' => $form->createView()

            ]
        );
    }

}
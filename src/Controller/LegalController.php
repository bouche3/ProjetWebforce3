<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LegalController
 * @package App\Controller\Legal
 *
 * @Route("/mentions_legales")
 */
class LegalController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('legal/index.html.twig');
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CguController
 * @package App\Controller\Cgu
 *
 * @Route("/cgu")
 */
class CguController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('cgu/index.html.twig');
    }
}

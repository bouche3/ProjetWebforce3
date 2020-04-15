<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AboutController
 * @package App\Controller\About
 *
 * @Route("/apropos")
 */
class AboutController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render(
            'about/index.html.twig'
        );
    }
}

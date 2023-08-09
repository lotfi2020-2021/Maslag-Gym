<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DachboardController extends AbstractController
{
    /**
     * @Route("/dachboard", name="dachboard")
     */
    public function index(): Response
    {
        return $this->render('acuille.html.twig', [
            'controller_name' => 'DachboardController',
        ]);
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function index2(): Response
    {
        return $this->render('contact.html.twig', [

        ]);
    }

    /**
     * @Route("/service", name="service")
     */
    public function index4(): Response
    {
        return $this->render('service.html.twig', [

        ]);
    }
    /**
     * @Route("/menu", name="menu")
     */
    public function index5(): Response
    {
        return $this->render('menu.html.twig', [

        ]);
    }
    /**
     * @Route("/test", name="test")
     */
    public function test(): Response
    {
        return $this->render('userfront/test.html.twig', [

        ]);
    }
    /**
     * @Route("/erreur", name="erreur")
     */
    public function test5(): Response
    {
        return $this->render('erreur.html.twig', [

        ]);
    }

}

<?php


namespace App\Controller;



use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('OMGdddd');

    }

    /**
     * @Route("news/{slug}")
     */
    public function show($slug){
        $comments = ['test','twee','drie'];
        return $this->render("show.html.twig",[
            'title'  => ucwords(str_replace('-',' ',$slug)),
            'comments'  => $comments

        ]);
    }
}
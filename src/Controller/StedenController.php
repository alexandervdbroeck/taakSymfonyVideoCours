<?php


namespace App\Controller;
use App\service\Container;
use App\service\DatabaseService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StedenController extends AbstractController
{

    /**
     * @Route("/steden", name="app_steden")
     */
    public function steden()
    {
        $container = new Container();
        $dbService = $container->getDatabaseService();
        $cityArray = $dbService->getData('SELECT * FROM images');
        return $this->render("stedenField.html.twig", ["steden" => $cityArray]);
    }

    /**
     * @Route("/stad/{id}", name="app_stad")
     */
    public function stad($id)
    {
        $container = new Container();
        $dbService = $container->getDatabaseService();
        $cityArray = $dbService->getData('SELECT * FROM images where img_id ='.$id);
        return $this->render("stedenField.html.twig", ["steden" => $cityArray]);
    }

}
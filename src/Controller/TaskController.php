<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class TaskController extends AbstractController
{
     //        -        -        -        G E T   A L L   T A S K S        -        -        -
        /**
     * @Route("/api/taken".methods={"GET"})
     */
    public function getAllTasks()
    {
        // TODO - get the database response back

        return $this->json( [ 'test' => 'this is my little test'] );
    }

     //        -        -        -        G E T   1   T A S K   B Y   I D        -        -        -
        /**
     * @Route("/api/taak/{taskid}".methods={"GET"})
     */
    public function getOneTasks( $taskid )
    {
        // TODO - get the database response back

        return $this->json( [ 'test' => 'this is my little test'] );
    }
    
     //        -        -        -        A D D   1   T A S K        -        -        -
        /**
     * @Route("/api/taak/".methods={"POST"})
     */
    public function addOnelTasks()
    {
        // TODO - get the database response back

        return $this->json( [ 'test' => 'this is my little test'] );
    }

     //        -        -        -        E D I T   1   T A S K   B Y   I D        -        -        -
        /**
     * @Route("/api/taak/{taskid}".methods={"PUT"})
     */
    public function editOnelTasks()
    {
        // TODO - get the database response back

        return $this->json( [ 'test' => 'this is my little test'] );
    }

     //        -        -        -        D E L E T E   1   T A S K   B Y   I D        -        -        -
        /**
     * @Route("/api/taak/{taskid}".methods={"DELETE"})
     */
    public function deleteOnelTasks()
    {
        // TODO - get the database response back

        return $this->json( [ 'test' => 'this is my little test'] );
    }

}

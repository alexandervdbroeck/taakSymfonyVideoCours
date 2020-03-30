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
        $allTasks = $this->PDO->getData( 'SELECT * FROM taak' );

        return $this->json( $allTasks );
    }

     //        -        -        -        G E T   1   T A S K   B Y   I D        -        -        -
        /**
     * @Route("/api/taak/{taskid}".methods={"GET"})
     */
    public function getOneTasks( $taskid )
    {
     $task = $this->PDO->getData( 'SELECT * FROM taak where taa_id =' . $taskid );

        return $this->json( $task[0] );
    }
    
     //        -        -        -        A D D   1   T A S K        -        -        -
        /**
     * @Route("/api/taak/".methods={"POST"})
     */
    public function addOnelTasks()
    {
     $task = file_get_contents('php://input');
     $task= json_decode($task, true);
     $taskDate = htmlentities($task[ 'taa_datum' ], ENT_QUOTES);
     $taskDescr = htmlentities($task[ 'taa_omschr' ], ENT_QUOTES);

     $sql = "INSERT INTO taak SET taa_datum = '" . $taskDate. "', taa_omschr = '" . $taskDescr. "'";

     return $this->PDO->executeSQL($sql);
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
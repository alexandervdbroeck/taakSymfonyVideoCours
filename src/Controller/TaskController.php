<?php

namespace App\Controller;
use App\service\Container;
use PDO;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class TaskController extends AbstractController
{
     private $taskService;

     public function __construct()
     {
        $cont = new Container();
        $this->taskService = $cont->getTaskLoader();
         return new JsonResponse("succes");

     }


    //        -        -        -        D E L E T E   1   T A S K   B Y   I D        -        -        -
    /**
     * @Route("/api/taak/{taskid}", methods={"DELETE"})
     */
    public function deleteOnelTasks( $taskid )
    {
        $this->taskService->procesApiDeleteTaskById($taskid);
        return new JsonResponse("respons");
    }

     //        -        -        -        G E T   1   T A S K   B Y   I D        -        -        -
        /**
     * @Route("/api/taak/{taskid}", methods={"GET"})
     */
    public function getOneTasks( $taskid )
    {
        $this->taskService->procesApiGetTaskById($taskid);
//        return new JsonResponse("respons");
    }

    //        -        -        -        G E T   A L L   T A S K S        -        -        -
    /**
     * @Route("/api/taken", methods={"GET"})
     */
    public function getAllTasks()
    {
        $this->taskService->procesApiGetAllTasks();
        return new JsonResponse("succes");
    }

     //        -        -        -        A D D   1   T A S K        -        -        -
        /**
     * @Route("/api/taken/", methods={"POST"})
     */
    public function addOnelTasks()
    {
        $this->taskService->procesApiCreateNewtask();
    }

     //        -        -        -        E D I T   1   T A S K   B Y   I D        -        -        -
        /**
     * @Route("/api/taken/{taskid}", methods={"PUT"})
     */
    public function editOnelTasks( $taskid )
    {
        $this->taskService->procesApiUpdateTaskById($taskid);
        return new JsonResponse("succes");
    }




}

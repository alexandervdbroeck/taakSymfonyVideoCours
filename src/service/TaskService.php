<?php


namespace App\service;
use App\service\DatabaseService;
use App\service\ApiService;


class TaskService
{
    private $databaseService;
    private $apiController;

    public function __construct(DatabaseService $databaseService, ApiService $apiController)
    {
        $this->databaseService = $databaseService;
        $this->apiController = $apiController;
    }

    /**
     * @param $date
     * @return City[]
     */

    public function getTaskById($id)
    {

        $task = $this->databaseService->getData('SELECT * FROM taak where taa_id ='.$id);
        return $task[0];
    }


    public function getTasks()
    {
        $tasksData = $this->queryForTasks();

        $tasks = array();
        foreach ($tasksData as $taskData) {
            $tasks[] = $this->createTaskFromData($taskData);
        }

        return $tasks;
    }

    /**
     * @param array $taskData
     * @return Task
     */
    private function createTaskFromData(array $taskData)
    {
        $task = new Task();
        $task->setId($taskData['taa_id']);
        $task->setDatum($taskData['taa_datum']);
        $task->setOmschr($taskData['taa_omschr']);

        return $task;
    }

    /**
     * @return array
     */
    public function queryForTasks()
    {
        $taskArray = $this->databaseService->getData('SELECT * FROM taak order by taa_id desc');
        return $taskArray;
    }

    public function getTaskDescriptionByDate($date)
    {
        $i = 0;
        $taskArray = $this->databaseService->getData("SELECT * FROM taak WHERE taa_datum = '". $date . "'");

        if (!$taskArray) {
            return null;
        }

        foreach ($taskArray as $task)
        {
            $tasks[$i] = $this->createTaskFromData($task);
            $i++;
        }

        return $tasks;
    }

    /*------------------------------------------Api CALL Methods----------------------------------------------*/

    public function procesApiGetAllTasks()
    {

        $tasks = $this->queryForTasks();
        if(!isset($tasks)){
            $this->apiController->sendError(404,'no tasks Where found');

        }else
        {
            $nrOfTasks = count($tasks);
            $this->apiController->setNbrOfTasks($nrOfTasks);
            $this->apiController->sendSuccess('there where '.$nrOfTasks.' tasks found',$tasks);
        }
    }


    public function procesApiGetTaskById($taakId)
    {
        // init the headers
        $this->apiController->initApi("GET");
        // get the task and put in json
        $task = $this->getTaskById($taakId);

        if(!isset($task))
        {
            // if there are no tasks
            $this->apiController->sendError(404,'the task with id:'.$taakId.' was not found');
        }else
        {
            $this->apiController->sendSuccess('task with id:'.$taakId.' is loaded',$task);
        }

    }

    public function procesApiCreateNewtask()
    {
        // init the headers
//        $this->apiController->initApi("POST");
        // Get the data from the Json
        $data = $this->apiController->getDataInJsonFromApiRequest();
        if($this->checkTaskData($data)){
            if($data)
            {
                if($this->databaseService->executeSQL("INSERT INTO taak SET taa_datum=' ". $data->taa_datum."' , taa_omschr= '".$data->taa_omschr."'"))
                {

                    $this->apiController->sendSuccess('the task is loaded in the database', $this->queryForTasks());

                }else
                {
                    $this->apiController->sendError(422,'there was a error in loading your task');
                }
            }else
            {
                $this->apiController->sendError(422,'Can not read your Json from your api request');

            }
        }else{
            $this->apiController->sendError(422,'your task data is invalid');
        }


    }

    public function procesApiDeleteTaskById($taakId)
    {
        // init the headers
        $this->apiController->initApi("DELETE");
        // check if task exists
        $task = $this->getTaskById($taakId);
        if(isset($task))
        {
            if($this->databaseService->executeSQL("DELETE FROM taak WHERE taa_id =".$taakId))
            {

                $this->apiController->sendSuccess('your task with id:'.$taakId." is deleted",$this->queryForTasks());

            }else
            {
                $this->apiController->sendError(422,'there was a error in deleting your task');

            }
        }else
        {
            // The task was not found
            $this->apiController->sendError(422,'the task with id'.$taakId." does not exist");

        }

    }

    public function procesApiUpdateTaskById($taakId)
    {

        // init the headers
        $this->apiController->initApi("PUT");
        // Get the data from the Json
        $data = $this->apiController->getDataInJsonFromApiRequest();
        // get posted data

        if($this->databaseService->executeSQL("UPDATE taak SET taa_datum ='".$data->taa_datum."' , taa_omschr = '".$data->taa_omschr."' WHERE taa_id = ".$taakId))
        {
            $returndata  = $this->queryForTasks();
            $this->apiController->sendSuccess("your task with id:".$taakId."is updated",$returndata);


        }else
        {
            $this->apiController->sendError(422,'there was a error updating your task');

        }
    }

    private function checkTaskData($data){
        $checksOk = false;
        $checksOk = DateTime::createFromFormat("Y-m-d", $data->taa_datum);
        $checksOk = strlen($data->taa_omschr) <200? true: false;
        return $checksOk;
    }

}
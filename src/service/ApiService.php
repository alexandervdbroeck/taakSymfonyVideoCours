<?php


namespace App\service;


class ApiService
{
    private $success;
    private $httpStatusCode;
    private $messages = array();
    private $data;
    private $toCache = false;
    private $responseData = array();
    private $nbrOfTasks = 0;

    /**
     * @return int
     */
    public function getNbrOfTasks()
    {
        return $this->nbrOfTasks;
    }

    /**
     * @param int $nbrOfTasks
     */
    public function setNbrOfTasks($nbrOfTasks)
    {
        $this->nbrOfTasks = $nbrOfTasks;
    }

    /**
     * @return mixed
     */
    public function initApi($method)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: $method");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    public function getsuccess()
    {
        return $this->success;
    }

    /**
     * @param mixed $success
     */
    public function setsuccess($success)
    {
        $this->success = $success;
    }

    /**
     * @return mixed
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * @param mixed $httpStatusCode
     */
    public function setHttpStatusCode($httpStatusCode)
    {
        $this->httpStatusCode = $httpStatusCode;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param array $messages
     */
    public function addMessage($messages)
    {
        $this->messages[] = $messages;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return bool
     */
    public function isToCache()
    {
        return $this->toCache;
    }

    /**
     * @param bool $toCache
     */
    public function setToCache($toCache)
    {
        $this->toCache = $toCache;
    }

    /**
     * @return array
     */
    public function getResponseData()
    {
        return $this->responseData;
    }

    /**
     * @param array $responseData
     */
    public function setResponseData($responseData)
    {
        $this->responseData = $responseData;
    }

    public function checkAuthentication($user,$pw)
    {
//        if ($_SERVER['PHP_AUTH_USER'] !== $user OR $_SERVER['PHP_AUTH_PW'] !== $pw) {
//            $this->sendError(401,"auth fail");
//            return false;
//        }
        return true;
    }

    public function send()
    {

        // data type
        header('Content-Type: application/json;charset=utf-8');


        // use a cache of 60 sec.
        if($this->toCache)
        {
            header('Cache-Control:max-age=60');
        }else
        {
            header('Cache-Control: no-cache, no-store');
        }

        if(($this->success !== false && $this->success !== true)|| !is_numeric($this->httpStatusCode))
        {
            http_response_code(500);
            $this->responseData['statusCode'] = 500;
            $this->responseData['success'] = false;
            $this->addMessage("Response creation error");
            $this->responseData['messages']= $this->messages;
            $this->responseData['nbrOfTasks'] = $this->nbrOfTasks;
        }else
        {
            http_response_code($this->httpStatusCode);
            $this->responseData['statusCode'] = $this->httpStatusCode;
            $this->responseData['success'] = $this->success;
            $this->responseData['nbrOfTasks'] = $this->nbrOfTasks;
            $this->responseData['message'] = $this->messages;
            $this->responseData['data'] = $this->data;

        }

        echo json_encode($this->responseData);
    }

    public function getDataInJsonFromApiRequest()
    {
        $data = json_decode(file_get_contents("php://input"));
        return $data;
    }

    public function sendError($httpStatusCode,$message,$data= false)
    {
        $this->setsuccess(false);
        $this->setHttpStatusCode($httpStatusCode);
        if($data) $this->setData($data);
        $this->addMessage($message);
        $this->send();
    }

    public function sendSuccess($message, $data = false)
    {
        $this->setsuccess(true);
        $this->setHttpStatusCode(200);
        if($data) $this->setData($data);
        $this->addMessage($message);
        $this->send();
    }

}
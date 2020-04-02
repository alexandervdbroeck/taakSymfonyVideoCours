<?php

namespace App\service;
use PDO;
use App\service\DatabaseService;
use App\service\TaskService;
use App\service\ApiService;

class Container
{
    private $configuration;
    private $taskLoader;
    private $pdo;
    private $databaseService;
    private $apiController;

    public function __construct()
    {
        $pasw = new Passw();
        $this->configuration = $pasw->returnConfig() ;
    }

    /**
     * @return PDO
     */
    public function getPDO()
    {
        if ($this->pdo === null) {
            $this->pdo = new PDO(
                $this->configuration['db_dsn'],
                $this->configuration['db_user'],
                $this->configuration['db_pass']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $this->pdo;
    }

    public function getDatabaseService()
    {
        if ($this->databaseService === null) {
            $this->databaseService = new DatabaseService($this->getPDO());
        }

        return $this->databaseService;
    }



    public function getApiController()
    {
        if ($this->apiController === null) {
            $this->apiController = new ApiService();
        }

        return $this->apiController;
    }
    public function getTaskLoader()
    {
        if ($this->taskLoader === null) {
            $this->taskLoader = new TaskService($this->getDatabaseService(),$this->getApiController());
        }

        return $this->taskLoader;
    }




}
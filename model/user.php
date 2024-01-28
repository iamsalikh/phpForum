<?php
require 'database.php';

class User{
    private $dbConnection;

    public function __construct(Connection $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function registration()
    {

    }
}
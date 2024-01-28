<?php
class Connection
{
    private $host;
    private $user;
    private $password;
    private $dbname;
    public $conn;

    public function __construct()
    {
        $this->host = 'localhost';
        $this->user = 'root';
        $this->password = '';
        $this->dbname = 'forum_db';

        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);

        if($this->conn->connect_error){
            error_log('Connection error: ' . $this->conn->connect_error);
            throw new Exception('Connection error');
        }
    }

    public function close()
    {
        $this->conn->close();
    }
}
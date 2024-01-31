<?php
require 'database.php';

class Subject {
    private $dbConnection;

    public function __construct(Connection $dbConnection){
        $this->dbConnection = $dbConnection->conn;
    }

    public function createSubject($subjectName, $title, $userId){
        $subjectName = mysqli_real_escape_string($this->dbConnection, $subjectName);
        $title = mysqli_real_escape_string($this->dbConnection, $title);
        $userId = mysqli_real_escape_string($this->dbConnection, $userId);

        $stmt = $this->dbConnection->prepare("INSERT INTO tb_subject (subjectName, title, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param('ssi', $subjectName, $title, $userId);

        if ($stmt->execute()) {
            return $this->dbConnection->insert_id;
        } else {
            error_log('Ошибка при создании темы: ' . $stmt->error);
            return false;
        }
    }

    public function viewSubjects(){
        $query = "SELECT * FROM tb_subject ORDER BY id DESC";
        $result = $this->dbConnection->query($query);

        $subjects = [];
        if($result){
            while($row = $result->fetch_assoc()){
                $subjects[] = $row;
            }
        } else {
            error_log('Ошибка при получении тем: ' . $this->dbConnection->error);
        }
        return $subjects;
    }

    public function viewSubjectById($subjectId){
        $stmt = $this->dbConnection->prepare("SELECT * FROM tb_subject WHERE id = ?");
        $stmt->bind_param('i', $subjectId);
        $stmt->execute();
        $result = $stmt->get_result();

        $subject = $result->fetch_assoc();
        return $subject;
    }
}


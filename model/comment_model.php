<?php
require 'database.php';

class Comment {
    private $dbConnection;

    public function __construct(Connection $dbConnection){
        $this->dbConnection = $dbConnection->conn;
    }

    public function addComment($subjectId, $userId, $content, $timestamp){
        $stmt = $this->dbConnection->prepare("INSERT INTO tb_comment (subject_id, user_id, content, timestamp) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('iiss', $subjectId, $userId, $content, $timestamp);

        if($stmt->execute()){
            return $this->dbConnection->insert_id;
        } else {
            error_log('Ошибка при добавлении комментария: ' . $stmt->error);
            return false;
        }
    }

    public function viewCommentsBySubjectId($subjectId){
        $stmt = $this->dbConnection->prepare("SELECT * FROM tb_comment WHERE subject_id = ? ORDER BY timstamp DESC");
        $stmt->bind_param('i', $subjectId);
        $stmt->execute();
        $result = $stmt->get_result();

        $comments = [];
        while($row = $result->fetch_assoc()){
            $comments[] = $row;
        }
        return $comments;
    }

    public function deleteCommentByIdAndUserId($commentId, $userId){
        $stmt = $this->dbConnection->prepare("DELETE FROM tb_comment WHERE id = ? AND user_id = ?");
        $stmt->bind_param('ii', $commentId, $userId);
        if($stmt->execute()){
            if($stmt->affected_rows > 0){
                return 1;
            } else {
                return 10;
            }
        } else {
            error_log('Ошибка при удалении комментариев: ' . $stmt->error);
            return 100;
        }
    }
}
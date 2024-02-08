<?php
namespace phpForum\Controller;

require_once __DIR__ . '/../vendor/autoload.php';

use phpForum\Model\Comment;
use phpForum\Model\Connection;

if(isset($_POST['action'])) {
    $action = $_POST['action'];
    $commentController = new CommentController();

    if ($action == 'add') {
        $commentController->addComment($_POST);
    }
}

class CommentController{
    private $commentModel;

    public function __construct(){
        $conn = new Connection();
        $this->commentModel = new Comment($conn);
    }

    public function addComment($post){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($post['subjectId']) || !isset($post['content'])) {
            $_SESSION['error'] = 'Ошибка: Недостаточно данных для добавления комментария';
            header('Location: ../error_page.php');
            exit();
        }

        $subjectId = $post['subjectId'];
        $userId = $_SESSION['user_id'] ?? null;
        $content = $post['content'];
        $timestamp = date('Y-m-d H:i:s');

        $result = $this->commentModel->addComment($subjectId, $userId, $content, $timestamp);

        if ($result !== false) {
            header('Location: ../view/subject.php?id=' . $subjectId);
            exit();
        } else {
            $_SESSION['error'] = 'Не удалось добавить комментарий';
            header('Location: ../error_page.php');
            exit();
        }
    }

    public function viewCommentsBySubjectId($subjectId){
        $comments = $this->commentModel->viewCommentsBySubjectId($subjectId);
        return $comments;
    }

    public function deleteCommentByIdAndUserId($commentId, $userId){
        $deleteComment = $this->commentModel->deleteCommentByIdAndUserId($commentId, $userId);
        return $deleteComment;
    }
}
<?php
class CommentController {
    private $commentModel;

    public function __construct(Comment $commentController){
        $this->commentModel = $commentController;
    }

    public function addComment(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $subjectId = $_POST['subjectId'];
            $userId = $_POST['userId'];
            $content = $_POST['content'];
            $timestamp = $_POST['timestamp'];

            $result = $this->commentModel->addComment($subjectId, $userId, $content, $timestamp);
            if($result !== false){
                return true;
            } else {
                $_SESSION['error'] = 'Не удалось добавить комментарий';
                header('Location: error_page.php');
                exit();
            }
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
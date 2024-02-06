<?php
session_start();

require_once __DIR__ . '/../model/database.php';
require_once __DIR__ . '/../model/subject_model.php';

$action = $_POST['action'] ?? null;
$subjectController = new SubjectController();
if ($action == 'create') {
    $subjectController->createSubject($_POST);
}

class SubjectController {
    private $subjectModel;

    public function __construct() {
        $conn = new Connection();
        $this->subjectModel = new Subject($conn);
    }

    public function createSubject($post) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
            $subjectName = $post['subjectName'] ?? '';
            $title = $post['title'] ?? '';
            $user_id = $_SESSION['user_id'];

            $result = $this->subjectModel->createSubject($subjectName, $title, $user_id);
            if ($result !== false) {
                header('Location: /phpForum/index.php');
                exit();
            } else {
                $_SESSION['error'] = 'Не удалось создать тему.';
                header('Location: /phpForum/error_page.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'Вы должны войти в систему, чтобы создать тему.';
            header('Location: ../view/user_login.php');
            exit();
        }
    }

    public function viewSubjects() {
        $subjects = $this->subjectModel->viewSubjects();
        return $subjects;
    }

    public function viewSubjectById($subjectId) {
        $subject = $this->subjectModel->viewSubjectById($subjectId);
        return $subject;
    }
}
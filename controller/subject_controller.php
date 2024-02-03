<?php
class SubjectController {
    private $subjectModel;

    public function __construct(Subject $subjectModel){
        $this->subjectModel = $subjectModel;
    }

    public function createSubject() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subjectName = $_POST['subjectName'] ?? '';
            $title = $_POST['title'] ?? '';
            $userId = $_POST['userId'] ?? 0;

            $result = $this->subjectModel->createSubject($subjectName, $title, $userId);
            if ($result !== false) {
                return true;
            } else {
                $_SESSION['error'] = 'Не удалось создать тему.';
                header('Location: error_page.php'); // Укажите путь к странице ошибки
                exit();
            }
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
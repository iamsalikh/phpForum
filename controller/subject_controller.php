<?php
class SubjectController {
    private $subjectModel;

    public function __construct(Subject $subjectModel){
        $this->subjectModel = $subjectModel;
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subjectName = $_POST['subjectName'] ?? '';
            $title = $_POST['title'] ?? '';
            $userId = $_POST['userId'] ?? 0;

            $result = $this->subjectModel->createSubject($subjectName, $title, $userId);
            if ($result !== false) {
                header('Location: path_to_success_page.php');
                exit();
            } else {
                $_SESSION['error'] = 'Не удалось создать тему.';
                header('Location: error_page.php'); // Укажите путь к странице ошибки
                exit();
            }
        }
    }

    public function listSubjects() {
        $subjects = $this->subjectModel->viewSubjects();
        return $subjects;
    }

    public function show($subjectId) {
        $subject = $this->subjectModel->viewSubjectById($subjectId);
        return $subject;
    }
}
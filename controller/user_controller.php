<?php
class UserController {
    private $userModel;

    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';

            $result = $this->userModel->register($name, $username, $email, $password, $confirmPassword);

            if ($result == 1) {
                header('Location: index.php'); // Перенаправление на страницу успешной регистрации
                exit();
            } elseif ($result == 10) {
                echo "Пользователь с таким именем пользователя или электронной почтой уже существует.";
            } elseif ($result == 100) {
                echo "Введенные пароли не совпадают.";
            } else {
                echo "Произошла ошибка при регистрации пользователя.";
            }
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usernameemail = $_POST['usernameemail'] ?? '';
            $password = $_POST['password'] ?? '';

            $result = $this->userModel->login($usernameemail, $password);

            if ($result == 1) {
                // Вход успешен
                session_start();
                $_SESSION['user_id'] = $this->userModel->idUser();
                header('Location: index.php');
                exit();
            } elseif ($result == 10) {
                echo "Неверный пароль.";
            } elseif ($result == 100) {
                echo "Пользователь с таким именем или электронной почтой не найден.";
            } else {
                echo "Произошла ошибка при входе в систему.";
            }
        }
    }

    public function logout() {
        session_start();
        $_SESSION = array();
        session_destroy();
        header('Location: login.php');
        exit();
    }
}

<?php
namespace phpForum\Controller;

use phpForum\Model\User;
use phpForum\Model\Connection;

session_start();

$action = $_POST['action'] ?? '';
$userController = new UserController();
if($action == 'register'){
    $userController->register($_POST);
} elseif($action == 'login'){
    $userController->login($_POST);
} elseif ($action == 'logout'){
    $userController->logout();
} else {
    header('Location: /phpForum/error_page.php');
    exit();
}

class UserController {
    private $userModel;

    public function __construct() {
        $conn = new Connection();
        $this->userModel = new User($conn);
    }

    public function register($post) {
        $name = $post['name'] ?? '';
        $username = $post['username'] ?? '';
        $email = $post['email'] ?? '';
        $password = $post['password'] ?? '';
        $confirmPassword = $post['confirmPassword'] ?? '';

        $result = $this->userModel->register($name, $username, $email, $password, $confirmPassword);
        if ($result == 1) {
            $_SESSION['user_id'] = $this->userModel->idUser();
            header('Location: ../index.php');
            exit();
        } elseif ($result == 10) {
            echo
            "<script> 
            alert('Пользователь с таким именем пользователя или электронной почтой уже существует.'); 
            window.location.href='../view/user_register.php';
        </script>";
        } elseif ($result == 100) {
            echo
            "<script> 
            alert('Введенные пароли не совпадают.'); 
            window.location.href='../view/user_register.php';
        </script>";
        } else {
            echo
            "<script> 
            alert('Произошла ошибка при регистрации пользователя.'); 
            window.location.href='../view/user_register.php';
        </script>";
        }
    }

    public function login($post) {
        $usernameemail = $post['usernameemail'] ?? '';
        $password = $post['password'] ?? '';

        $result = $this->userModel->login($usernameemail, $password);

        if ($result == 1) {
            $_SESSION['user_id'] = $this->userModel->idUser();
            header('Location: ../index.php');
            exit();
        } elseif ($result == 10) {
            echo
            "<script> 
            alert('Неверный пароль.'); 
            window.location.href='../view/user_login.php';
        </script>";
        } elseif ($result == 100) {
            echo
            "<script> 
            alert('Пользователь с таким именем или электронной почтой не найден.'); 
            window.location.href='../view/user_login.php';
        </script>";
        } else {
            echo
            "<script> 
            alert('Произошла ошибка при входе в систему.'); 
            window.location.href='../view/user_login.php';
        </script>";
        }
    }

    public function logout() {
        session_start();
        $_SESSION = array();
        session_destroy();
        header('Location: ../view/user_login.php');
        exit();
    }
}

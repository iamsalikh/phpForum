<?php

class UserController {
    private $userModel;

    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }

    public function register() {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        $result = $this->userModel->register($name, $username, $email, $password, $confirmPassword);
        if ($result == 1){
            header("Location: index.php");
            exit();
        } elseif ($result == 10){
            echo 'Пользователь с таким именем пользователя или почтой уже существует.';
        } elseif ($result == 100){
            echo 'Введенные пароли не совпадают.';
        } else {
            echo 'Произошла ошибка при регистрации.';
        }
    }

    public function login(){
        $usernameemail = $_POST['usernameemail'];
        $password = $_POST['password'];

        $result = $this->userModel->login($usernameemail, $password);
        if ($result == 1){
            header('Location: index.php');
            exit();
        } elseif ($result == 10){
            echo 'Неверный пароль';
        } elseif ($result == 100){
            echo 'Пользователя с таким именем пользователя или почтой не найдена';
        }
    }

    public function logout(){
        session_destroy();
        if (isset($_COOKIE[session_name()])){
            setcookie(session_name(), '', time() - 42000, '/');
        }

        header('Location: login.php');
        exit();
    }
}
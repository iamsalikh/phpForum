<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
<div class="form-container">
    <form action="../controller/user_controller.php" method="post">
        <input type="hidden" name="action" value="login">
        <input type="text" name="usernameemail" placeholder="Имя пользователя или Электронная почта" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
        <a href="user_register.php">Register</a>
    </form>
</div>
</body>
</html>
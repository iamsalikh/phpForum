<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="./css/register.css">
</head>
<body>
<div class="form-container">
    <h2>Регистрация</h2>
    <form action="../controller/user_controller.php" method="post">
        <input type="hidden" name="action" value="register">
        <div>
            <label for="name">Имя:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="email">Электронная почта:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="confirmPassword">Подтвердите пароль:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
        </div>
        <button type="submit">Зарегистрироваться</button>
        <a href="user_login.php">Login</a>
    </form>
</div>
</body>
</html>
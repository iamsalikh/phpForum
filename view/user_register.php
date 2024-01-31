<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>
<body>
<h2>Форма Регистрации</h2>
<form action="" method="post">
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
</form>
</body>
</html>
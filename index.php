<?php
session_start();

require_once 'controller/subject_controller.php';
require_once 'model/user_model.php';
require_once 'model/database.php';

$conn = new Connection();
$select = new User($conn);

$user = null;
if(isset($_SESSION['user_id'])){
    $user = $select->selectUserById($_SESSION['user_id']);
}


$subjectsController = new SubjectController();
$subjects = $subjectsController->viewSubjects();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>phpForum</title>
    <link rel="stylesheet" href="view/css/index.css">
</head>
<body>
<div class="header">
    <h1>phpForum</h1>
    <div class="user-info">
        <?php if ($user): ?>
            <span class="username"><?= htmlspecialchars($user['username']); ?></span>
            <div class="user-menu">
                <form action="controller/user_controller.php" method="post">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit" class="logout-button">Выйти из системы</button>
                </form>
            </div>
        <?php else: ?>
            <a href="view/user_login.php" class="login-link">Login</a>
        <?php endif; ?>
    </div>
    <div class="links">
        <a href="index.php?action=viewSubjects">Forums</a>
    </div>
</div>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="controller/subject_controller.php" method="post">
                <input type="hidden" name="action" value="create">
                <input type="text" name="subjectName" placeholder="Name of your subject" class="form-control" required>
                <input type="text" name="title" placeholder="Write your subject" class="form-control" required>
                <button type="submit" class="btn btn-success">Add</button>
            </form>
        </div>
    </div>

    <div class="row justify-content-center">
        <?php foreach ($subjects as $subject): ?>
            <div class="col-md-8">
                <a href="view/subject.php?id=<?= htmlspecialchars($subject['id']) ?>" class="card-link">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($subject['subjectName']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($subject['title']) ?></p>
                            <p class="text-muted">Created by: <?= htmlspecialchars($select->getUsernameByUserId($subject['user_id'])) ?></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var username = document.querySelector('.username');
        var logoutMenu = document.querySelector('.user-menu');

        username.addEventListener('click', function (event) {
            event.stopPropagation();
            logoutMenu.style.display = logoutMenu.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', function (event) {
            if (!logoutMenu.contains(event.target)) {
                logoutMenu.style.display = 'none';
            }
        });
    });
</script>
</body>
</html>
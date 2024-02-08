<?php
require_once __DIR__ . '/../vendor/autoload.php';

session_start();


use phpForum\Model\User;
use phpForum\Model\Connection;
use phpForum\Model\Subject;
use phpForum\Model\Comment;

$conn = new Connection();
$userModel = new User($conn);

if(isset($_GET['id'])) {
    $subjectId = $_GET['id'];

    $subjectController = new Subject($conn);
    $subject = $subjectController->viewSubjectById($subjectId);

    $commentController = new Comment($conn);
    $comments = $commentController->viewCommentsBySubjectId($subjectId);
} else {
    echo
    "<script> alert('No subject ID provided.'); window.location.href = 'index.php'; </script>";
    exit;
}

$user = null;
if(isset($_SESSION['user_id'])){
    $user = $userModel->selectUserById($_SESSION['user_id']);
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Subject</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<div class="header">
    <h1>phpForum</h1>
    <div class="links">
        <a href="../index.php?action=viewSubjects">Forums</a>
        <div class="user-info">
            <?php if ($user): ?>
                <span class="username"><?= htmlspecialchars($user['username']); ?></span>
                <div class="user-menu">
                    <form action="../controller/UserController.php" method="post">
                        <input type="hidden" name="action" value="logout">
                        <button type="submit" class="logout-button">Выйти из системы</button>
                    </form>
                </div>
            <?php else: ?>
                <a href="user_login.php" class="login-link">Login</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container my-4">
    <div class="row justify-content-center">
        <?php if($subject): ?>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($subject['subjectName']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($subject['title']) ?></p>
                        <p class="text-muted">Created by: <?= htmlspecialchars($userModel->getUsernameByUserId($subject['user_id'])) ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="../controller/CommentController.php" method="post">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="subjectId" value="<?= htmlspecialchars($subjectId); ?>">
                <input type="hidden" name="userId" value="<?= isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id']): '' ?>">
                <input type="text" name="content" placeholder="Add your comment" class="form-control" required>
                <button type="submit" class="btn btn-success">Add</button>
            </form>

        </div>
    </div>
</div>

<div class="container my-4">
    <div class="row justify-content-center">
        <?php foreach ($comments as $comment): ?>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($userModel->getUsernameByUserId($comment['user_id'])) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($comment['content']) ?></p>
                        <p class="text-muted">Posted on: <?= date("Y-m-d H:i:s", strtotime($comment['timestamp'])) ?></p>
                    </div>
                </div>
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
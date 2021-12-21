<?php
require 'db.php';
session_start();
$post_id = (int)($_GET['id']);
$post = $connection->prepare("SELECT * FROM posts WHERE id=?");
$post->execute([$post_id]);
$post = $post->fetchAll();
$post = $post[0];
$owner = $connection->prepare("SELECT name FROM users WHERE id=?");
$owner->execute([$post['user_id']]);
$owner = $owner->fetchAll();
$owner = $owner[0];
?>

<?php require 'templates/head.html' ?>

<body>
    <?php require 'templates/header.php' ?>
    <link rel="stylesheet" href="css/post.css">
    <main>
        <div class="wrapper wrapper__main">
            <div class="main">
                <div class="main-text"><?= $post['title']; ?></div>
                <div class="post-info">
                    <div class="post-info__item post-info__item_owner">Владелец: <b><?= $owner['name'] ?></b></div>
                    <div class="post-info__item post-info__item_date">Дата загрузки: <b><?= $post['upload_date'] ?></b></div>
                    <div class="post-info__item post-info__item_description">Описание<br><br><?= $post['description'] ?></div>
                </div>
                <button class="download-button">Скачать файл</button>
            </div>
        </div>
    </main>
    <?php require 'templates/footer.html' ?>
    <?php require 'templates/forms.html' ?>
    <script src="js/forms.js"></script>
</body>

</html>
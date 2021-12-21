<?php require 'db.php' ?>
<?php session_start()?>
<?php

$query = "SELECT id FROM disciplines";
$all_disciplines = $connection->query($query);
$all_disciplines = $all_disciplines->fetchAll();

$disciplines_max_size = 3;
$query = "SELECT * FROM disciplines LIMIT $disciplines_max_size";
$disciplines = $connection->query($query);
$disciplines = $disciplines->fetchAll();

?>

<?php require 'templates/head.html' ?>

<body>
    <?php require 'templates/preloader.html' ?>
    <?php require 'templates/header.php' ?>
    <main>
        <div class="wrapper wrapper__main">
            <div class="main">
                <div class="main-text">Последние публикации</div>
                <div class="publications">
                    <?php
                    foreach ($disciplines as $discipline) :
                    ?>
                        <div class="publication-section">
                            <div class="publication-section__discipline"><?= $discipline['discipline_name'] ?></div>
                            <div class="publication-item-container">
                                <?php
                                $all_posts = $connection->prepare('SELECT id FROM posts WHERE discipline_id=?');
                                $all_posts->execute([$discipline['id']]);
                                $all_posts = $all_posts->fetchAll();
                                $posts_size = 6;

                                $offset = count($all_posts) - $posts_size;
                                if (count($all_posts) < $posts_size) {
                                    $posts_size = count($all_posts);
                                }
                                if ($offset < 0) {
                                    $offset = 0;
                                }

                                $id = $discipline['id'];
                                $query = "SELECT id, title, upload_date FROM posts WHERE discipline_id=$id LIMIT $posts_size OFFSET $offset";

                                $posts = $connection->query($query);


                                $posts = $posts->fetchAll();
                                $posts = array_reverse($posts);
                                foreach ($posts as $post) :
                                ?>
                                    <a href="post.php?id=<?= $post['id']; ?>" class="publication-item">
                                        <div class="publication-item__name"><?= $post['title']; ?></div>
                                        <div class="publication-item__date"><?= $post['upload_date']; ?></div>
                                        <div class="publication-item__link">Перейти</div>
                                    </a>
                                <?php endforeach; ?>
                                <?php if ($offset != 0) : ?>
                                    <div onclick="loadPosts(this)" class="more-posts-button" id="more_posts_button" data-disc_id="<?= $discipline['id'] ?>" data-page="1" data-max-page="<?= ceil(count($all_posts) / $posts_size) ?>">Загрузить еще</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="more-disciplines-button" id="more_disciplines_button" data-page="1" data-max-page="<?= ceil(count($all_disciplines) / $disciplines_max_size) ?>">Больше дисциплин</div>
            </div>
        </div>
    </main>
    <?php require 'templates/footer.html' ?>
    <?php require 'templates/forms.html' ?>
    <script src="js/preloader.js"></script>
    <script src="js/ajax.js"></script>
    <script src="js/forms.js"></script>
</body>

</html>
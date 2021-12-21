<?php
require "db.php";

$discipline_id = (int)($_GET['page']);

$query = "SELECT id FROM disciplines";
$all_disciplines = $connection->query($query);
$all_disciplines = $all_disciplines->fetchAll();

$offset_disc = $discipline_id - 1;

$disciplines_max_size = 1;
$query = "SELECT * FROM disciplines LIMIT $disciplines_max_size OFFSET $offset_disc";
$disciplines = $connection->query($query);
$disciplines = $disciplines->fetchAll();


foreach ($disciplines as $discipline) :
?>
    <div class="publication-section">
        <div class="publication-section__discipline"><?= $discipline['discipline_name'] ?></div>
        <div class="publication-item-container">
            <?php
            $all_posts = $connection->prepare("SELECT id FROM posts WHERE discipline_id=?");
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
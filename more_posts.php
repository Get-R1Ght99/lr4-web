<?php
require "db.php";

$current_page = (int)($_GET['page']);
$discipline_id = (int)($_GET['discipline_id']);

$posts_size = 6;

$all_posts = $connection->prepare('SELECT id FROM posts WHERE discipline_id=?');
$all_posts->execute([$discipline_id]);
$all_posts = $all_posts->fetchAll();

$offset = count($all_posts) - ($posts_size * $current_page);
if ((count($all_posts) - ($posts_size * ($current_page - 1))) < $posts_size) {
    $posts_size = (count($all_posts) - ($posts_size * ($current_page - 1)));
}
if ($offset < 0) {
    $offset = 0;
}

$query = "SELECT * FROM posts WHERE discipline_id=$discipline_id LIMIT $posts_size OFFSET $offset";
$posts = $connection->query($query);
$posts = $posts = array_reverse($posts->fetchAll());

foreach ($posts as $post) :
?>
    <a href="post.php?id=<?= $post['id']; ?>" class="publication-item">
        <div class="publication-item__name"><?= $post['title']; ?></div>
        <div class="publication-item__date"><?= $post['upload_date']; ?></div>
        <div class="publication-item__link">Перейти</div>
    </a>
<?php endforeach; ?>
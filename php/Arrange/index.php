<?php

require_once __DIR__ . '/../lib/mysql.php';
require_once __DIR__ . '/../lib/escape.php';

function listReviews($link)
{
    $reviews = [];

    // 並び順：降順
    if (isset($_POST['desc'])) $sql = 'SELECT title, author, status, score, summary, id FROM reviews order by id desc';
    // 並び順：昇順
    else $sql = 'SELECT title, author, status, score, summary, id FROM reviews order by id asc';

    $results = mysqli_query($link, $sql);

    while ($review = mysqli_fetch_assoc($results)) {
        $reviews[] = $review;
    }

    mysqli_free_result($results);

    return $reviews;
}

$link = dbConnect();
$reviews = listReviews($link);

$title = '読書ログ一覧';
$content = __DIR__ . '/views/index.php';
include __DIR__ . '/views/layout.php';

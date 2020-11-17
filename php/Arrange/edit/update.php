<?php

// レコードの更新

function updateReview($link, $review)
{
    $sql = <<<EOT
UPDATE reviews SET
title = "{$review['title']}",
author = "{$review['author']}",
status = "{$review['status']}",
score = "{$review['score']}",
summary = "{$review['summary']}"
WHERE id = "{$review['id']}";
EOT;

    $result = mysqli_query($link, $sql);
    if (!$result) {
        error_log('Error: fail to update review');
        error_log('Debugging error: ' . mysqli_error($link));
    }
}

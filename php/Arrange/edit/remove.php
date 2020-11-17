<?php

// レコードの削除

function removeReview($link, $review)
{
     // カラムを削除するSQL文
    // DELETE FROM文 WHERE句をつけなければテーブル内全てのデータを削除
    $sql = 'DELETE FROM reviews WHERE id = ' . $review['id'] . ';';

    $result = mysqli_query($link, $sql);
    if (!$result) {
        error_log('Error: fail to remove review');
        error_log('Debugging error: ' . mysqli_error($link));
    }
}

// require_once __DIR__ . '/../lib/mysql.php';

// // データベースへ接続
// $link = dbConnect();

// // カラムを削除するSQL文
// // DELETE FROM文 WHERE句をつけなければテーブル内全てのデータを削除
// $sql = 'DELETE FROM reviews WHERE id = ' . $review['id'] . ';';

// $result = mysqli_query($link, $sql);
// if (!$result) {
//     error_log('Error: fail to Delete Column');
//     error_log('Debugging error: ' . mysqli_error($link));
// }
// // データベース切断
// mysqli_close($link);
// // index.phpページへheader
// header("Location: index.php");

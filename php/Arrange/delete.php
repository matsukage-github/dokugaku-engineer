<?php

require_once __DIR__ . '/../lib/mysql.php';

// HTTPメソッドがPOSTだったら
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // POSTされたIDを変数に格納する
    $recodeId = $_POST['id'];

    // データベースへ接続
    $link = dbConnect();

    // データベースに登録されたデータを削除する

    // カラムを削除するSQL文
    // DELETE FROM文 WHERE句をつけなければテーブル内全てのデータを削除
    $sql = 'DELETE FROM reviews WHERE id = ' . $recodeId . ';';

    $result = mysqli_query($link, $sql);
    if (!$result) {
        error_log('Error: fail to Delete Column');
        error_log('Debugging error: ' . mysqli_error($link));
    }

    // データベース切断
    mysqli_close($link);
    // index.phpページへheader
    header("Location: index.php");

// もしエラーがあれば
}


// $title = '読書ログ一覧';
// $content = __DIR__ . '/views/index.php';
// include __DIR__ . '/views/layout.php';

// データ削除に失敗した場合
// index.phpページで「データの削除に失敗しました。」と赤文字でエラーメッセージ表示

// 11/12記述
// 現段階では削除ボタンをクリックすると全てのデータが削除される

// 改良すべき点
// 選択されたデータが削除されるようにする

// 方法
// DERETE FROM文にWHERE句を追加してデータIDに基づいて削除する
// データベースのデータIDの取得方法を調べる

// ↓↓↓↓↓ TECH ACADEMYマガジン参照 ↓↓↓↓↓
// <?php
// if (isset($_POST['add'])) {
//     echo '登録ボタンが押されました。' . PHP_EOL;
// } elseif (isset($_POST['update'])) {
//     echo '更新ボタンが押されました。' . PHP_EOL;
// } else {
//     echo '削除ボタンが押されました。' . PHP_EOL;
// }
// ?>

<!-- <form action="input.php" method="POST">
    <button type="submit" name="add">登録</button>
    <button type="submit" name="update">更新</button>
    <button type="submit" name="remove">削除</button>
</form> -->

<!-- formのPOSTメソッドで削除したいデータ（レコード）のidをdelete.phpへ渡す。 -->

<!-- buttonタブにnameを追加していけばnameで条件分岐して、削除、更新など拡張できる -->

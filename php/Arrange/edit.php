<?php

require_once __DIR__ . '/../lib/mysql.php';
require_once __DIR__ . '/edit/create.php';
require_once __DIR__ . '/edit/remove.php';
require_once __DIR__ . '/edit/update.php';

function validate($review)
{
    $errors = [];

    // 書籍名
    if (!strlen($review['title'])) {
        $errors['name'] = '書籍名を入力してください';
    } elseif (strlen($review['title']) > 255) {
        $errors['name'] = '255文字以内で入力してください';
    }
    // 著者名
    if (!strlen($review['author'])) {
        $errors['author'] = '著者名を入力してください';
    } elseif (strlen($review['author']) > 255) {
        $errors['author'] = '255文字以内で入力してください';
    }
    // 読書状況
    if (!in_array($review['status'], ['未読', '読んでる', '読了'])) {
        $errors['status'] = '読書状況は「未読」「読んでる」「読了」のいずれかを入力してください';
    }
    // 評価
    if ($review['score'] < 1 || $review['score'] > 5) {
        $errors['score'] = '評価は1~5の整数で入力してください';
    }
    // 感想
    if (!strlen($review['summary'])) {
        $errors['summary'] = '感想を入力してください';
    } elseif (strlen($review['summary']) > 1000) {
        $errors['summary'] = '1000文字以内で入力してください';
    }

    return $errors;
}

// HTTPメソッドがPOSTだったら
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /*
     * status（読書状況）が未入力のときに $_POST['status'] を呼び出すとエラーになるためその対策として処理を入れている
     * エラーになる理由は、ラジオボタンがチェックされていないとデータが送信されず、$_POST 内に status というキーが存在しないにも関わらず status キーにアクセスしようとするから
     * status が未入力のときにエラーにならないのであれば他の対処方法でも良い（読書状況のラジオボタンにデフォルトでチェックを入れておくなど）
     */
    $status = '';
    if (array_key_exists('status', $_POST)) {
        $status = $_POST['status'];
    }

    // データ登録時の$review['id']は空文字
    $id = '';
    if (array_key_exists('id', $_POST)) {
        $id = $_POST['id'];
    }

    // POSTされた会社情報を変数に格納する
    $review = [
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'status' => $status,
        'score' => $_POST['score'],
        'summary' => $_POST['summary'],
        'id' => $id
    ];

    // バリデーションする
    $errors = validate($review);

    // エラーがない場合
    if (!count($errors)) {

        // 読書ログ一覧で更新ボタンが押されたとき編集画面（入力フォーム）へ移行
        if (isset($_POST['update_translate'])) {
            $title = '読書ログ更新';
            $content = __DIR__ . '/views/new.php';
            include __DIR__ . '/views/layout.php';
        } else {
            $link = dbConnect();
            // データの登録
            if (isset($_POST['register'])) createReview($link, $review);
            // データの更新
            elseif (isset($_POST['update'])) updateReview($link, $review);
            // データの削除
            elseif (isset($_POST['remove'])) removeReview($link, $review);

            mysqli_close($link);
            // 一覧へ遷移
            header("Location: index.php");
        }
    } else {
        // もしエラーがあれば
        if (isset($_POST['register'])) $title = '読書ログ登録';
        else $title = '読書ログ更新';

        // 編集画面（入力フォーム）へ移行
        $content = __DIR__ . '/views/new.php';
        include __DIR__ . '/views/layout.php';
    }
}

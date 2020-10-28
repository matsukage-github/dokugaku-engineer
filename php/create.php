<?php

require_once __DIR__ . '/lib/mysql.php';

function createReview($link, $review)
{
    $sql = <<<EOT
INSERT INTO reviews (
    title,
    author,
    status,
    score,
    summary
) VALUES (
    "{$review['title']}",
    "{$review['author']}",
    "{$review['status']}",
    "{$review['score']}",
    "{$review['summary']}"
)
EOT;

    $result = mysqli_query($link, $sql);
    if (!$result) {
        error_log('Error: fail to create review');
        error_log('Debugging error: ' . mysqli_error($link));
    }
}

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

    // POSTされた会社情報を変数に格納する
    $review = [
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'status' => $status,
        'score' => $_POST['score'],
        'summary' => $_POST['summary']
    ];

    // バリデーションする
    $errors = validate($review);

    if (!count($errors)) {
        $link = dbConnect();
        createReview($link, $review);
        mysqli_close($link);
        header("Location: index.php");
    }
    // もしエラーがあれば
}

include 'views/new.php';

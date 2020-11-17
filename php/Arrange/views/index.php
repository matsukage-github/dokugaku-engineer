<a href="new.php" class="btn btn-primary mb-4">読書ログを登録する</a>

<form action="index.php" method="post" class="float-right mt-3">
    <button type="submit" name="aes" class="btn btn-light">↑昇順</button>
    <button type="submit" name="desc" class="btn btn-light">↓降順</button>
</form>

<main>
    <?php if (count($reviews) > 0) : ?>
        <?php foreach ($reviews as $review) : ?>
            <section class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="float-right">No.<?php echo escape($review['id']); ?></div>
                    <h2 class="card-title h4 text-dark mb-3">
                        <?php echo escape($review['title']); ?>
                    </h2>
                    <div class="small mb-3">
                        <?php echo escape($review['author']); ?>&nbsp;/&nbsp;<?php echo escape($review['status']); ?>&nbsp;/&nbsp;<?php echo escape($review['score']); ?>点
                    </div>
                    <p>
                        <?php echo nl2br(escape($review['summary'])); //nl2br 改行を反映 ?>
                    </p>
                    <!-- <form action="translate.php" method="post" class="text-right"> -->
                    <form action="edit.php" method="post" class="text-right">
                        <input type="hidden" name="id" value="<?php echo $review['id'] ?>">
                        <input type="hidden" name="title" value="<?php echo $review['title'] ?>">
                        <input type="hidden" name="author" value="<?php echo $review['author'] ?>">
                        <input type="hidden" name="status" value="<?php echo $review['status'] ?>">
                        <input type="hidden" name="score" value="<?php echo $review['score'] ?>">
                        <input type="hidden" name="summary" value="<?php echo $review['summary'] ?>">
                        <button type="submit" name="update_translate" class="btn btn-success">更新</button>
                        <button type="submit" name="remove" class="btn btn-danger" onclick="return columnDelete()">削除</button>
                    </form>
                </div>
            </section>
        <?php endforeach; ?>
    <?php else : ?>
        <p>読書ログが登録されていません。</p>
    <?php endif; ?>

</main>

<script type="text/javascript">
    function columnDelete() {
        var str = confirm('このデータを削除しますか？');
        return str;
    }
</script>

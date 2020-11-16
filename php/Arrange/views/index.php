<!-- <h1 class="h3 text-dark mb-4">読書ログの一覧</h1> -->
<a href="new.php" class="btn btn-primary mb-4">読書ログを登録する</a>
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
                    <!-- <div class="text-right">
                        <a href="delete.php" class="btn btn-danger" onclick="return columnDelete()">削除</a>
                    </div> -->
                    <form action="delete.php" method="post" class="text-right">
                        <!-- <input type="text" name="id" value=""> -->
                        <!-- <input type="submit" class="btn btn-danger" value="削除" onclick="return columnDelete()"> -->
                        <input type="hidden" value="<?php echo $review['id'] ?>" name="id">
                        <button type="submit" class="btn btn-danger" onclick="return columnDelete()">削除</button>
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

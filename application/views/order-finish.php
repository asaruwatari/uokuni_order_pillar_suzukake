<!-- お知らせ -->
<div class="alert alert-success text-center">
    ご注文ありがとうございました。<br>
</div>

<?php
// 日ループ
foreach ($dates as $date) {

    // 日曜日と土曜日の色設定
    switch (date('w', strtotime($date['date']))) {
        case 0:
            $color = '#f33';
            break;
        case 6:
            $color = '#33f';
            break;
        default :
            $color = 'inherit';
            break;
    }

    // 本日アイコン
    $today = date('Y-m-d') == $date['date'] ? '<span class="badge badge-danger">本日</span>' : '';
    ?>
    <div class="my-3">
        <div style="color: <?= h($color) ?>">
            <?= jp_mdw($date['date']) ?> <?= $today ?>
        </div>
        <div class="row">
            <?php
            // 注文ループ
            foreach ($date['times'] as $item_time_id => $data) {
                ?>
                <div class="col-3 text-right">
                    <?= h($item_time_options[$item_time_id]) ?>
                </div>
                <div class="col-9">
                    <?php
                    if (!empty($data['items'])) {
                        if (!empty($data['order'])) {
                            // 注文あり
                            ?>
                            <b><?= h(@$data['items'][$data['order']['item_id']]['name']) ?>
                                (<?= h(@$data['items'][$data['order']['item_id']]['item_type.name']) ?>)</b>
                            <?php
                        } else {
                            // 注文なし
                            ?>
                            <b>不要</b>
                            <?php
                        }
                    } else {
                        // 献立なし
                        ?>
                        <span class="text-muted">提供無し</span>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}
?>


<p>
    <a href="<?= h($dir) ?>order<?= @$get['date'] ? '?date='.h($get['date']) : '' ?>" class="btn btn-primary btn-block">注文画面へ戻る</a>
</p>

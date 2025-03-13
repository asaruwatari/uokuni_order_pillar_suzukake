
<div class="card mb-2">
    <div class="card-body text-center p-2">
        <a href="<?= h($dir.$class.'/'.$method.$prev) ?>" class="btn btn-primary btn-sm"><i class="fa fa-chevron-left fa-fw" aria-hidden="true"></i> 前月度</a>
        <span>　　<?= h($year) ?>年<?= h($month) ?>月度（<?= jp_date($from_date) ?>
            ～
            <?= jp_date($to_date) ?>）　　</span>
        <a href="<?= h($dir.$class.'/'.$method.$next) ?>" class="btn btn-primary btn-sm">次月度 <i class="fa fa-chevron-right fa-fw" aria-hidden="true"></i></a>
    </div>
</div>

<div class="card mb-2">
    <div class="card-body p-2">
        <a href="<?= h("{$dir}{$class}/total_sheet/?year={$year}&month={$month}") ?>" class="btn btn-primary btn-sm text-nowrap"><i class="fas fa-file-excel fa-fw"></i> Excel出力</a>
    </div>
</div>

<div class="alert alert-warning">
    無効な利用者は除外するため、利用者を無効にする際は締め処理以降に行ってください。<br>
    金額は現在のシステム設定の食単価(<?= number_format($system['price']) ?> 円)で計算されます。
</div>

<!-- 一覧 -->
<table class="table table-bordered table-striped table-hover table-sm">
    <?php
    foreach ($list as $i => $data) {

        if ($i % 50 == 0) {
            ?>
            <thead>
                <tr>
                    <th>職番</th>
                    <th>氏名</th>
                    <th>区分</th>
                    <th>食数</th>
                    <th>金額</th>
                </tr>
            </thead>
            <?php
        }
        ?>
        <tr>
            <td><?= h($data['user.code']) ?></td>
            <td><?= h($data["user.name"]) ?></td>
            <td><?= h($data['user_type.name']) ?></td>
            <td class="text-right"><?= number_format($data['qty']) ?> 食</td>
            <td class="text-right"><?= number_format($data['qty'] * $system['price']) ?> 円</td>
        </tr>
        <?php
    }
    ?>
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th class="text-right">合計</th>
            <td class="text-right"><?= number_format(array_sum(array_column($list, 'qty'))) ?> 食</td>
            <td class="text-right"><?= number_format(array_sum(array_column($list, 'qty')) * $system['price']) ?> 円</td>
        </tr>
    </thead>
</table>

<div class="card mb-2">
    <div class="card-body text-center p-2">
        <a href="<?= h($dir.$class.$prev) ?>" class="btn btn-primary btn-sm"><i class="fa fa-chevron-left fa-fw" aria-hidden="true"></i> 前週</a>
        <span>　　<?= jp_date_week($date) ?>　　</span>
        <a href="<?= h($dir.$class.$next) ?>" class="btn btn-primary btn-sm">次週 <i class="fa fa-chevron-right fa-fw" aria-hidden="true"></i></a>
    </div>
</div>

<div class="alert alert-warning">
    <a href="javascript: window.location.reload();" class="btn btn-warning btn-sm">最新の状態に更新する</a>
    　<b><?= date('Y年n月j日 H:i:s') ?></b> 時点の情報です。最新の情報を表示するには「最新の状態に更新する」ボタンをクリックしてください。
</div>

<!-- 一覧 -->
<table class="table table-bordered table-striped table-hover table-sm">
    <thead>
        <tr>
            <th style="width:1%"></th>
            <th>日付</th>
            <th>提供時間</th>
            <th>区分</th>
            <th>献立</th>
            <th>合計食数</th>
            <!--<th>金額</th>-->
        </tr>
    </thead>
    <?php
    // 日付ループ
    foreach ($datas as $data) {

        // 商品区分ループ
        foreach ($item_types as $item_type) {

            // 日曜日と土曜日の背景色
            switch (date('w', strtotime($data['date']))) {
                case 0:
                    $color = '#ffdfdf';
                    break;
                case 6:
                    $color = '#dfefff';
                    break;
                default :
                    $color = '#fff';
                    break;
            }
            // 本日アイコン
            $today = date('Y-m-d') == $data['date'] ? '<span class="badge badge-danger">本日</span>' : '';
            ?>
            <tr style="background-color: <?= h($color) ?>">
                <?php
                if ($item_type['id'] == 1) {
                    ?>
                    <td rowspan="<?= count($item_types) ?>"><a href="<?= h("{$dir}{$class}/date/?date={$data['date']}") ?>" class="btn btn-primary btn-sm py-0 px-1 my-0 text-nowrap">詳細</a></td>
                    <td rowspan="<?= count($item_types) ?>"><?= jp_mdw($data['date']) ?> <?= $today ?></td>
                    <?php
                }
                $field = "datas[{$data['date']}][{$item_type['id']}]";
                ?>
                <td class="text-nowrap"><?= h($item_type['item_time.name']) ?></td>
                <td class="text-nowrap"><?= h($item_type['name']) ?></td>
                <td><?= h(@$data['items'][$item_type['id']]['name']) ?></td>
                <td class="text-right"><?= h(@$data['items'][$item_type['id']]['order_qty']) ?></td>
                <!--<td class="text-right"><?= h(@number_format($data['items'][$item_type['id']]['price'])) ?></td>-->
            </tr>
            <?php
        }
        ?>
        <?php
    }
    ?>
</table>
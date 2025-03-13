<div class="card mb-2">
    <div class="card-body text-center p-2">
        <?= jp_date_week($get['date']) ?>
    </div>
</div>

<div class="card mb-2">
    <div class="card-body p-2">
        <a href="<?= h("{$dir}{$class}/date_sheet/?date={$get['date']}") ?>" class="btn btn-primary btn-sm text-nowrap"><i class="fas fa-file-excel fa-fw"></i> Excel出力</a>
        <a href="<?= h("{$dir}{$class}/date_check_sheet/?date={$get['date']}") ?>" class="btn btn-primary btn-sm text-nowrap" target="_blank"><i class="fas fa-file-pdf fa-fw"></i> 受取チェック表出力</a>
    </div>
</div>

<div class="alert alert-warning">
    削除：受注情報を完全に削除し、集計にも含まれなくなります。利用者側では「不要」（＝注文しなかった状態）になります。<br>
    キャンセル：受注情報は残りますが集計には含まれなくなります。利用者側では「キャンセル済」と表示されます。受取チェック表に表示されません。<br>
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
            <th>提供時間</th>
            <th>職番</th>
            <th>氏名</th>
            <th>区分</th>
            <th>献立</th>
            <th>注文日時</th>
            <th>注文IP</th>
            <th>キャンセル</th>
            <th>備考</th>
            <th>更新日時</th>
            <th style="width:1%"></th>
        </tr>
    </thead>

    <?php
    foreach ($list as $count => $data) {
        ?>
        <tr>
            <td class="text-nowrap"><a href="<?= h("{$dir}{$class}/edit/{$data['id']}") ?>" class="btn btn-primary btn-sm py-0 px-1 my-0 text-nowrap">編集</a></td>
            <td><?= h($data['item_time.name']) ?></td>
            <td><?= h($data['user.code']) ?></td>
            <td><?= h($data['user.name']) ?></td>
            <td><?= h($data['item_type.name']) ?></td>
            <td><?= h($data['item.name']) ?></td>
            <td><?= h($data['created_at']) ?></td>
            <td><?= h($data['ip']) ?></td>
            <td><?= h($data['canceled_flag'] ? '✔' : '') ?></td>
            <td><?= h($data['remarks']) ?></td>
            <td><?= h($data['updated_at']) ?></td>
            <td><a href="<?= h("{$dir}{$class}/delete/{$data['id']}") ?>" class="btn btn-danger btn-sm py-0 px-1 my-0 text-nowrap delete">削除</a></td>
        </tr>
        <?php
    }
    ?>
</table>

<?php $this->load->view($dir.'elements/back') ?>

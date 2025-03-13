<div class="alert alert-info">
    献立を入力すると注文可能になり、未入力の場合は注文できません。<br>
    すでに注文が入っている献立を未入力に変更しても、注文情報は削除されませんので管理サイトから手動で削除を行ってください。（利用者側からは削除や変更ができません）<br>
</div>

<div class="card mb-2">
    <div class="card-body text-center p-2">
        <a href="<?= h($dir.$class.$prev) ?>" class="btn btn-primary btn-sm"><i class="fa fa-chevron-left fa-fw" aria-hidden="true"></i> 前月</a>
        <span>　　<?= h($year) ?>年 <?= h($month) ?>月　　</span>
        <a href="<?= h($dir.$class.$next) ?>" class="btn btn-primary btn-sm">次月 <i class="fa fa-chevron-right fa-fw" aria-hidden="true"></i></a>
    </div>
</div>

<form method="post" class="form-horizontal box edit" autocomplete="off" novalidate>
    <?php $this->load->view($dir.'forms/csrf') ?>

    <!-- 一覧 -->
    <table class="table table-bordered table-striped table-hover table-sm">

        <?php
        // 日付ループ
        $i = 0;
        foreach ($datas as $data) {
            if ($i++ % 3 == 0) {
                ?>
                <thead>
                    <tr>
                        <th>日付</th>
                        <th>提供時間</th>
                        <th>区分</th>
                        <th>献立</th>
                        <th>更新日時</th>
                    </tr>
                </thead>
                <?php
            }
            // 商品区分ループ
            foreach ($item_types as $item_type) {

                // 日曜日と土曜日の背景色設定
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
                ?>
                <tr style="background-color: <?= h($color) ?>">
                    <?php
                    if ($item_type['id'] == 1) {
                        ?>
                        <td rowspan="<?= count($item_types) ?>"><?= jp_mdw($data['date']) ?></td>
                        <?php
                    }
                    $field = "datas[{$data['date']}][{$item_type['id']}]";
                    ?>
                    <td class="text-nowrap" style="vertical-align: middle"><?= h($item_type['item_time.name']) ?></td>
                    <td class="text-nowrap" style="vertical-align: middle"><?= h($item_type['name']) ?></td>
                    <td class="<?= form_error("{$field}[name]") ? 'has-error' : '' ?>">
                        <input type="hidden" name="<?= h($field) ?>[id]" value="<?= set_value("{$field}[id]", isset($data['items'][$item_type['id']]['id']) ? $data['items'][$item_type['id']]['id'] : '') ?>">
                        <input type="hidden" name="<?= h($field) ?>[date]" value="<?= $data['date'] ?>">
                        <input type="hidden" name="<?= h($field) ?>[item_type_id]" value="<?= $item_type['id'] ?>" class="item_type_id">
                        <input type="text" name="<?= h($field) ?>[name]" value="<?= set_value("{$field}[name]", isset($data['items'][$item_type['id']]['name']) ? $data['items'][$item_type['id']]['name'] : '') ?>" class="form-control form-control-sm" style="display:inline-block; width:20em  !important;">
                        <?= form_error("{$field}[name]") ? '<span class="help-block">'.form_error("{$field}[name]").'</span>' : '' ?>
                    </td>
                    <td class="text-nowrap" style="vertical-align: middle">
                        <?= h(@$data['items'][$item_type['id']]['updated_at']) ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            <?php
        }
        ?>
    </table>
    <button type="submit" class="btn btn-warning btn-block btn-sm">保存する</button>
</form>




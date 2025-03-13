<div class="alert alert-secondary">
    <?= h($system['deadline_day']) ?>日前の<?= h(jp_time($system['deadline_hour'])) ?>まで注文や変更ができます。<br>
    献立を選択し [注文を保存する] ボタンで保存してください。<br>
</div>

<!-- ページャ -->
<div class="row">
    <div class="col-4">
        <?php
        if ($prev) {
            ?><a href="<?= h($dir.$class.$prev) ?>" class="btn btn-primary"><i class="fas fa-chevron-left fa-fw" aria-hidden="true"></i> 前週</a><?php
        }
        ?>
    </div>
    <div class="col-4 text-center">
    </div>
    <div class="col-4 text-right">
        <?php
        if ($next) {
            ?><a href="<?= h($dir.$class.$next) ?>" class="btn btn-primary">次週 <i class="fas fa-chevron-right fa-fw" aria-hidden="true"></i></a><?php
        }
        ?>
    </div>
</div>

<hr>

<!-- 注文フォーム -->
<form method="post" class="form">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

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
        <div>
            <h5 class="h5" style="color: <?= h($color) ?>"><?= jp_mdw($date['date']) ?> <?= $today ?></h5>
            <?php
            // メニュー表示
            // 注文枠ループ
            foreach ($date['times'] as $item_time_id => $data) {
                ?>
                <div class="row">
                    <!-- 提供時間 -->
                    <div class="col-sm-3 text-right">
                        <label class="col-form-label">
                            <?= h($item_time_options[$item_time_id]) ?>
                        </label>
                    </div>
                    <!-- 献立 -->
                    <div class="col-sm-9">
                        <!-- キャンセル表示 -->
                        <?php
                        if ($data['items']) {
                            // 献立あり
                            $field = "orders[{$date['date']}][{$item_time_id}]";
                            ?>
                            <!-- メニュー選択肢 -->
                            <div class="form-group">
                                <?php
                                // キャンセル済
                                if (!empty($data['order']['canceled_flag'])) {
                                    // キャンセル表示
                                    ?>
                                    <input type="text" class="form-control" value="キャンセル済" disabled>
                                    <?php
                                } else {
                                    // キャンセルではない
                                    // 締め切り時間チェック
                                    $deadline = strtotime("{$date['date']} {$system['deadline_hour']} -{$system['deadline_day']} day");

                                    if ($deadline < now()) {
                                        // 締め切り後
                                        ?>
                                        <input type="text" class="form-control" value="<?= h(@$data['order']['id'] ? $data['items'][$data['order']['item_id']]['name']."(".$data['items'][$data['order']['item_id']]['item_type.name'].")" : '不要') ?>" disabled>
                                        <?php
                                    } else {
                                        // 締め切り前
                                        ?>
                                        <input type="hidden" name="<?= h($field) ?>[id]" value="<?= set_value("{$field}][id]", @$data['order']['id']) ?>">
                                        <!-- 献立プルウダウン表示 -->
                                        <select name="<?= h($field) ?>[item_id]" class="form-control <?= form_error($field) ? 'is-invalid' : '' ?>">
                                            <option value="">不要</option>
                                            <?php
                                            foreach ($data['items'] as $item) {
                                                ?>
                                                <option value="<?= $item['id'] ?>" <?= set_select("{$field}[item_id]", $item['id'], @$data['order']['item_id'] == $item['id']) ?>><?= h($item['name']) ?> (<?= $item['item_type.name'] ?>)</option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <?php
                                    }
                                    ?>
                                    <!-- エラー表示 -->
                                    <?= form_error($field) ? '<span class="invalid-feedback">'.form_error($field).'</span>' : '' ?>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        } else {
                            // 献立なし
                            ?>
                            <label class="col-form-label">
                                提供なし
                            </label>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <hr>
        <?php
    }
    ?>

    <button class="btn btn-warning btn-block">注文を保存する</button>

</form>

<hr>

<!-- ページャ -->
<div class="row">
    <div class="col-4">
        <?php
        if ($prev) {
            ?><a href="<?= h($dir.$class.$prev) ?>" class="btn btn-primary"><i class="fas fa-chevron-left fa-fw" aria-hidden="true"></i> 前週</a><?php
        }
        ?>
    </div>
    <div class="col-4 text-center">
    </div>
    <div class="col-4 text-right">
        <?php
        if ($next) {
            ?><a href="<?= h($dir.$class.$next) ?>" class="btn btn-primary">次週 <i class="fas fa-chevron-right fa-fw" aria-hidden="true"></i></a><?php
            }
            ?>
    </div>
</div>

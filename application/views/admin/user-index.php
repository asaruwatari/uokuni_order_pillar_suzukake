<!-- 絞込フォーム -->
<form method="get" class="card mb-2" autocomplete="off" novalidate>
    <div class="card-body p-1 form-inline">
        <div class="form-group m-1">
            <input type="text" name="code" class="form-control form-control-sm" value="<?= h(@$get['code']) ?>" placeholder="職番">
        </div>
        <div class="form-group m-1">
            <input type="text" name="name" class="form-control form-control-sm" value="<?= h(@$get['name']) ?>" placeholder="氏名">
        </div>
        <div class="form-group m-1">
            <?= form_dropdown('user_type_id', ['' => '-区分-'] + $user_type_options, @$get['user_type_id'], 'class="form-control form-control-sm"') ?>
        </div>
        <div class="form-group m-1">
            <?= form_dropdown('deleted_flag', ['' => '-状態-', 0 => '有効', 1 => '無効'], @$get['deleted_flag'], 'class="form-control form-control-sm"') ?>
        </div>
        <div class="form-group m-1">
            <button type="submit" class="btn btn-primary btn-sm mx-1 change_action" data-action="<?= h($dir.$class) ?>"><i class="fas fa-search fa-fw" aria-hidden="true"></i>絞込表示</button>
            <button type="submit" class="btn btn-primary btn-sm mx-1 change_action" data-action="<?= h("{$dir}{$class}/export") ?>"><i class="fas fa-file-excel fa-fw" aria-hidden="true"></i>Excel出力</button>
            <a class="btn btn-dark btn-sm mx-1" href="<?= h($dir.$class) ?>"><i class="fas fa-times fa-fw" aria-hidden="true"></i>絞込解除</a>
        </div>
    </div>
</form>

<div class="alert alert-warning">
    無効の利用者は、注文サイトにログインできなくなり、受注集計にも表示されなくなります。<br>
    <br>
    ■ Excel入力の注意点<br>
    ・Excel出力ボタンから出力したExcelをひな型にしてください。（列の追加・削除・入替はできません）<br>
    ・「職番」が存在する場合は上書き、存在しない場合は追加します。（＝追加・変更したい情報のみアップロードが可能です）<br>
    ・「パスワード」が空欄の場合は現在のパスワードを維持し、入力されている場合は変更します。<br>
    ・「更新日時」は反映しません。（実際に更新された日時になります）<br>
    ・エラーが発生した場合、エラーが発生していない利用者情報を含め情報を更新しません。<br>
</div>

<?php $this->load->view($dir.'elements/add_file') ?>

<!-- 一覧 -->
<table class="table table-bordered table-striped table-hover table-sm">
    <?php
    foreach (@$list as $count => $data) {
        // ヘッダ行表示
        if ($count % 20 == 0) {
            ?>
            <thead>
                <tr>
                    <th width="1%"></th>
                    <th>職番</th>
                    <th>氏名</th>
                    <th>区分</th>
                    <th>無効</th>
                    <th>更新日時</th>
                </tr>
            </thead>
            <?php
        }
        ?>
        <tr>
            <td><a href="<?= h("{$dir}{$class}/edit/{$data['id']}") ?>" class="btn btn-primary btn-sm py-0 px-1 my-0 text-nowrap">編集</a></td>
            <td><?= h($data['code']) ?></td>
            <td><?= h($data['name']) ?></td>
            <td><?= h($data['user_type.name']) ?></td>
            <td><?= $data['deleted_flag'] ? '無効' : ''; ?></td>
            <td><?= $data['updated_at'] ?></td>
        </tr>
        <?php
    }
    ?>
</table>

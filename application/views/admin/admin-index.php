<?php $this->load->view($dir.'elements/add') ?>

<div class="alert alert-warning">
    管理者：すべての機能が利用できます。<br>
    利用者：システム管理は利用できません。<br>
</div>

<!-- 一覧 -->
<table class="table table-bordered table-striped table-hover table-sm">
    <thead>
        <tr>
            <th width="1%"></th>
            <th>区分</th>
            <th>氏名</th>
            <th>ログインID</th>
            <th>無効</th>
            <th>更新日時</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach (@$list as $data) {
            ?><tr>
                <td><a href="<?= h("{$dir}{$class}/edit/{$data['id']}") ?>" class="btn btn-primary btn-sm py-0 px-1 my-0 text-nowrap">編集</a></td>
                <td><?= h($data['admin_type.name']) ?></td>
                <td><?= h($data['name']) ?></td>
                <td><?= h($data['code']) ?></td>
                <td><?= $data['deleted_flag'] ? '無効' : ''; ?></td>
                <td><?= h($data['updated_at']) ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>

<form method="post" class="form-horizontal" autocomplete="off" novalidate>
    <table class="table table-bordered">
        <tr>
            <th>社員番号</th>
            <td><?= h($login_user['code']) ?></td>
        </tr>
        <tr>
            <th>氏名</th>
            <td><?= h($login_user['name']) ?></td>
        </tr>
        <tr>
            <th>会社名</th>
            <td><?= h($login_user['company.name']) ?></td>
        </tr>
        <tr>
            <th>標準配達先</th>
            <td class="row">
                <div class="col-xs-12">
                    <?php
                    $this->load->view($dir.'forms/csrf');
                    $this->load->view($dir.'forms/select', ['field' => 'delivery_id', 'options' => ['' => ''] + $delivery_options]);
                    ?>
                </div>
            </td>
        </tr>
    </table>
    <button type="submit" class="btn btn-warning btn-block btn-lg">保存する</button>
</form>



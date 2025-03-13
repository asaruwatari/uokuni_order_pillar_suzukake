
<div class="alert alert-warning">
    単価は締集計情報出力時に参照されますので、単価を変更する場合は締め処理後に変更してください。
</div>

<form method="post" class="form-horizontal box edit" autocomplete="off" novalidate>
    <?php
    $this->load->view($dir.'forms/csrf');
    $this->load->view($dir.'forms/hidden', ['field' => 'id']);
    $this->load->view($dir.'forms/number', ['field' => 'price']);
    $this->load->view($dir.'forms/number', ['field' => 'deadline_day']);
    $this->load->view($dir.'forms/time', ['field' => 'deadline_hour']);

    $this->load->view($dir.'forms/string', ['field' => 'updated_at', 'label' => '更新日時']);
    $this->load->view($dir.'forms/submit', ['label' => '保存する']);
    ?>
</form>
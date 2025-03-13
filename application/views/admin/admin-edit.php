<form method="post" class="form-horizontal box edit" autocomplete="off" novalidate>
    <?php
    $this->load->view($dir.'forms/csrf');
    $this->load->view($dir.'forms/hidden', ['field' => 'id']);
    $this->load->view($dir.'forms/select', ['field' => 'admin_type_id', 'options' => ['' => ''] + $admin_type_options]);
    $this->load->view($dir.'forms/text', ['field' => 'name']);
    $this->load->view($dir.'forms/text', ['field' => 'code']);
    $this->load->view($dir.'forms/password', ['field' => 'password']);
    $this->load->view($dir.'forms/flag', ['field' => 'deleted_flag']);
    $this->load->view($dir.'forms/string', ['field' => 'updated_at', 'label' => '更新日時']);
    $this->load->view($dir.'forms/submit', ['label' => '保存する']);
    ?>
</form>

<?php $this->load->view($dir.'elements/back') ?>

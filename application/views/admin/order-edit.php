<form method="post" class="form-horizontal box edit" autocomplete="off" novalidate>
    <?php
    $this->load->view($dir.'forms/csrf');
    $this->load->view($dir.'forms/hidden', ['field' => 'id']);
    $this->load->view($dir.'forms/select_hidden', ['field' => 'user_id', 'options' => $user_options]);
    $this->load->view($dir.'forms/hidden', ['field' => 'date']);
    $this->load->view($dir.'forms/select', ['field' => 'item_id', 'options' => $item_options]);
    $this->load->view($dir.'forms/string', ['field' => 'created_at', 'label' => '注文日時']);
    $this->load->view($dir.'forms/string', ['field' => 'ip']);
//    $this->load->view($dir.'forms/string', ['field' => 'received_at']);
//    $this->load->view($dir.'forms/string', ['field' => 'received_ip']);
    $this->load->view($dir.'forms/flag', ['field' => 'canceled_flag']);
    $this->load->view($dir.'forms/textarea', ['field' => 'remarks']);
    $this->load->view($dir.'forms/string', ['field' => 'updated_at', 'label' => '更新日時']);
    $this->load->view($dir.'forms/submit', ['label' => '保存する']);
    ?>
</form>

<?php $this->load->view($dir.'elements/back') ?>

<!-- メッセージ表示 -->
<?php
if ($messages = $this->session->userdata('message')) {
    $this->session->unset_userdata('message');
    ?>
    <div class="alert alert-success">
        <?= implode("<br>\n", $messages) ?>
    </div>
    <?php
}
?>
<!-- エラー表示 -->
<?php
if ($messages = $this->session->userdata('error')) {
    $this->session->unset_userdata('error');
    ?>
    <div class="alert alert-danger">
        <?= implode("<br>\n", $messages) ?>
        <!--<?= validation_errors() ?>-->
    </div>
    <?php
}
?>

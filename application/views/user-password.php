<p class="alert alert-info">
    パスワードを変更する場合は新しいパスワードを入力してください。<br>
    パスワードは半角でアルファベットと数字を各1文字以上含む8文字以上を入力してください。
</p>

<form method="post" class="form-horizontal" autocomplete="off" novalidate>
    <?php
    $this->load->view($dir.'forms/csrf');
    $this->load->view($dir.'forms/password', ['field' => 'password']);
    $this->load->view($dir.'forms/password', ['field' => 'password_conf']);
    $this->load->view($dir.'forms/submit', ['label' => 'パスワードを変更する']);
    ?>
</form>

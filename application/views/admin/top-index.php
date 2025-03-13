<main>
    <!-- ロゴ -->
    <div class="text-center">
        <img src="assets/images/logo.gif" class="center-block logo">
    </div>
    <!-- タイトル -->
    <h1 class="h3 text-center"><?= h($title) ?></h1>

    <!-- エラーメッセージ -->
    <?php $this->view($dir.'elements/message') ?>

    <!-- ログインフォーム -->
    <form method="post" autocomplete="off" novalidate>
        <?php $this->load->view($dir.'forms/csrf') ?>

        <div class="form-group <?= form_error('code') ? 'has-error' : '' ?>">
            <input type="text" class="form-control" name="code" value="<?= set_value('code') ?>" placeholder="ログインID">
            <div class="help-block text-danger"><?= form_error('code') ?></div>
        </div>

        <div class="form-group <?= form_error('password') ? 'has-error' : '' ?>">
            <input type="password" class="form-control" name="password" placeholder="パスワード">
            <div class="help-block text-danger"><?= form_error('password') ?></div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">ログイン</button>
        </div>
    </form>
</main>

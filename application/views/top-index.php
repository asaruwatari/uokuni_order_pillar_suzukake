<main id="login" class="container-fluid">

    <!-- タイトル -->
    <h1 class="h3 text-center mb-5">
        <!-- ロゴ -->
        <img src="assets/<?= h($dir) ?>images/logo.gif" class="img-fluid"><br>

        <?= h(SYSTEM_NAME) ?><br>
        注文サイト
    </h1>

    <!-- エラーメッセージ -->
    <?php $this->view($dir.'elements/message') ?>

    <!-- ログインフォーム -->
    <form method="post" novalidate>
        <?php $this->load->view($dir.'forms/csrf') ?>

        <div class="form-group">
            <input type="text" class="form-control <?= form_error('code') ? 'is-invalid' : '' ?>" name="code" value="<?= set_value('code') ?>" placeholder="職番">
            <?= form_error('code') ? '<span class="invalid-feedback">'.form_error('code').'</span>' : '' ?>
        </div>

        <div class="form-group">
            <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>" name="password" placeholder="パスワード">
            <?= form_error('password') ? '<span class="invalid-feedback">'.form_error('password').'</span>' : '' ?>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">ログイン</button>
        </div>
    </form>

</main>

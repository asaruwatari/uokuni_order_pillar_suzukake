<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="robots" content="noindex">
        <meta name="theme-color" content="">
        <meta name="format-detection" content="telephone=no">
        <title><?= h($title) ?></title>
        <base href="<?= site_url() ?>">
        <!-- jQuery -->
        <script src="//code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script src="//cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="//stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <!-- Bootbox -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
        <!-- Font -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
        <!-- footerFixed -->
        <script src="assets/<?= h($dir) ?>js/jquery.footerFixed-modified.js"></script>
        <!-- App -->
        <link rel="stylesheet" href="assets/<?= h($dir) ?>css/main.css?<?= time() ?>">
        <script src="assets/<?= h($dir) ?>js/main.js?<?= time() ?>"></script>
    </head>

    <body>

        <?php $this->view($dir.'elements/loading') ?>

        <!-- ヘッダー -->
        <header style="background-color: <?= h(ADMIN_COLOR) ?>">
            <div class="logo">
                <a href="<?= h($dir) ?>"><?= SYSTEM_NAME ?></a>
            </div>
            <div class="menu">
                <div class="float-left">
                    <h1><?= h($title) ?></h1>
                </div>
                <div class="float-right">
                    <a href="<?= h($dir.'admin/password') ?>" class="btn btn-light btn-sm py-0 px-1 my-0"><i class="fas fa-user fa-fw"></i> <?= h($login_user['name']) ?></a>&nbsp;&nbsp;

                    <a href="<?= h($dir.'top/logout') ?>" class="btn btn-warning btn-sm py-0 px-1 my-0 logout"><i class="fas fa-sign-out-alt fa-fw"></i> ログアウト</a>
                </div>
            </div>
        </header>

        <!-- ナビ -->
        <nav>
            <ul>
                <li class="header">受注管理</li>
                <li><a href="<?= h($dir."order") ?>" class="<?= @$menu_id == ADMIN_MENU_ORDER ? 'on' : '' ?>">受注</a></li>
                <li><a href="<?= h($dir."order/total") ?>" class="<?= @$menu_id == ADMIN_MENU_ORDER_TOTAL ? 'on' : '' ?>">受注集計</a></li>
                <li class="header">献立管理</li>
                <li><a href="<?= h($dir."item") ?>" class="<?= @$menu_id == ADMIN_MENU_ITEM ? 'on' : '' ?>">献立</a></li>
                <li class="header">パスワード変更</li>
                <li><a href="<?= h($dir.'admin/password') ?>" class="<?= @$menu_id == ADMIN_MENU_PASSWORD ? 'on' : '' ?>">パスワード変更</a></li>
                <?php
                // 管理者のみ表示
                if ($login_user['admin_type_id'] == ADMIN_TYPE_ADMIN) {
                    ?>
                    <li class="header">システム管理</li>
                    <li><a href="<?= h($dir."user") ?>" class="<?= @$menu_id == ADMIN_MENU_USER ? 'on' : '' ?>">利用者</a></li>
                    <li><a href="<?= h($dir.'admin') ?>" class="<?= @$menu_id == ADMIN_MENU_ADMIN ? 'on' : '' ?>">管理者</a></li>
                    <li><a href="<?= h($dir.'system') ?>" class="<?= @$menu_id == ADMIN_MENU_SYSTEM ? 'on' : '' ?>">システム設定</a></li>
                    <li><a href="<?= h($dir.'system/info') ?>" class="<?= @$menu_id == ADMIN_MENU_SYSTEM_INFO ? 'on' : '' ?>">システム情報</a></li>
                    <?php
                }
                ?>
            </ul>
        </nav>

        <!-- メイン -->
        <main>

            <!-- メインコンテンツ -->
            <article id="main">
                <?php $this->view($dir.'elements/message') ?>
                <?= $content ?>
            </article>

            <!-- フッター -->
            <footer id="footer">
                <?= COPYRIGHT ?>
                <div class="float-right hidden-xs"> Version <?= VERSION ?> </div>
            </footer>

        </main>

    </body>
</html>

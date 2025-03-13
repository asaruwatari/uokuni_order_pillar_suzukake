<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="robots" content="noindex">
        <meta name="format-detection" content="telephone=no">
        <title><?= h($title) ?></title>
        <base href="<?= site_url() ?>">
        <!-- jQuery -->
        <script src="//code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/<?= h($dir) ?>css/print.css">
        <link rel="stylesheet" href="assets/<?= h($dir) ?>css/bootstrap-print.css">
        <script src="//stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <!-- Font -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- App -->
        <link rel="stylesheet" href="assets/<?= h($dir) ?>css/main.css?<?= time() ?>">
        <link rel="stylesheet" href="assets/<?= h($dir) ?>css/manual.css?<?= time() ?>">
        <script src="assets/<?= h($dir) ?>js/main.js?<?= time() ?>"></script>
        <!-- footerFixed -->
        <script src="assets/<?= h($dir) ?>js/jquery.footerFixed-modified.js"></script>
        <!-- bootbox -->
        <script src="assets/<?= h($dir) ?>js/bootbox.min.js"></script>
        <!-- zooming -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/zooming/2.1.1/zooming.min.js"></script>
    </head>

    <body id="manual">
        <!-- ヘッダー -->
        <header>
            <div class="menu">
                <div class="pull-left">
                    <h1><?= h($title) ?></h1>
                </div>
                <div class="pull-right">
                    <a href="<?= h($dir.'manual/') ?>" class="btn btn-default btn-sm"><i class="fas fa-book fa-fw"></i> マニュアルTOP</a>&nbsp;&nbsp;&nbsp;
                    <a href="javascript:;" class="btn btn-default btn-sm" onclick="window.close();"><i class="fas fa-times fa-fw"></i></a>
                </div>
            </div>
        </header>

        <!-- メイン -->
        <main>

            <!-- メインコンテンツ -->
            <article id="main">
                <?= $content ?>
            </article>

            <!-- フッター -->
            <footer id="footer">
                <?= COPYRIGHT ?>
                <div class="pull-right hidden-xs"> Version <?= VERSION ?> </div>
            </footer>
        </main>
        <script>
            // Listen to images after DOM content is fully loaded
            document.addEventListener('DOMContentLoaded', function () {
                new Zooming({
                    // options...
                }).listen('.img-zoomable');
            })
        </script>
    </body>
</html>

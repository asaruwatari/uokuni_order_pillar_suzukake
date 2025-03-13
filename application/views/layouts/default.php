<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="robots" content="noindex">
        <meta name="theme-color" content="">
        <meta name="format-detection" content="telephone=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= h($title) ?></title>
        <base href="<?= site_url() ?>">
        <!-- jQuery -->
        <script src="//code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script src="//cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="//stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="assets/<?= h($dir) ?>css/print.css">
        <link rel="stylesheet" href="assets/<?= h($dir) ?>css/bootstrap-print.css">
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
        <?= $content ?>
    </body>

    <!-- フッター -->
    <footer id="footer" class="text-center">
        <?= COPYRIGHT ?>
    </footer>
</html>

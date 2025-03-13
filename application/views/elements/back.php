<?php
// $urlで指定されていればそのURLへリンク
// 指定されていなければsessionに記録されたURLへリンク
// sessionに記録されていなければ同コントローラのindexへリンク
if (empty($url)) {
    $CI  = & get_instance();
    $url = $CI->get_back_url();
}
?>
<div class="hidden-print" style="margin-top:2em">
    <a href="<?= site_url($url) ?>" class="btn btn-block btn-default btn-lg"><span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span> <?= h(@$text ?: '前画面に戻る') ?></a>
</div>

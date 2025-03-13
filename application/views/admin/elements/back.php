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
    <a href="<?= site_url($url) ?>"><i class="fas fa-arrow-circle-left fa-fw"></i> <?= h(@$text ?: '前画面に戻る') ?></a>
</div>

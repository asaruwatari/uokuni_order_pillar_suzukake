<?php
// URI のどのセグメントにページ番号が含まれるか
$config['uri_segment'] = 3;
// ページ番号の前後に表示したい "数字" リンクの数
$config['num_links'] = 5;
// ページ番号を使用
$config['use_page_numbers'] = FALSE;
// パラメータにクエリストリングを使用するか
$config['page_query_string'] = TRUE;
// パラメータにクエリストリングの名前
$config['query_string_segment']  = 'o'; //デフォルトは「per_page」だが長いし「offset」の方が正しいので変更

//?
$config['reuse_query_string'] = FALSE;
// ページ数の値に付けるプレフィックスとサフィックス
$config['prefix'] = '';
$config['suffix'] = '';
//?
$config['use_global_url_suffix'] = FALSE;

// 囲みのマークアップ
$config['full_tag_open'] = '<ul class="pagination">'."\n";
$config['full_tag_close'] = "\n</ul>\n";
// 最初のページへのリンク
$config['first_link'] = '最初';
$config['first_tag_open']  = '<li class="page-item">';
$config['first_tag_close'] = '</li>';
// 最後のページへのリンク
$config['last_link'] = '最後';
$config['last_tag_open']   = '<li class="page-item">';
$config['last_tag_close'] = '</li>';
// "次" のページへのリンク
$config['next_link'] = '&gt;';
$config['next_tag_open']   = '<li class="page-item previous">';
$config['next_tag_close'] = '</li>';
// "前" のページへのリンク
$config['prev_link'] = '&lt;';
$config['prev_tag_open']   = '<li class="page-item next">';
$config['prev_tag_close'] = '</li>';
// "現在のページ" のページ番号
$config['cur_tag_open']    = '<li class="page-item active"><a class="page-link">';
$config['cur_tag_close'] = '</a></li>';
// "数字" のページリンク
$config['num_tag_open']    = '<li class="page-item">';
$config['num_tag_close'] = '</li>';
// ページ移動リンク
$config['display_pages'] = TRUE;

// アンカータグのクラス名(V3廃止)
//$config['anchor_class'] = '';
// アンカータグの要素
$config['attributes'] = ['class' => 'page-link'];


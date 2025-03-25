<?php
/* アプリ用定数設定 */

// 名称
define('SYSTEM_NAME', 'すずかけ寮食事予約');
// バージョン
define('VERSION', '1.0.0');
// コピーライト
define('COPYRIGHT', 'Copyright &copy; Uokuni Food Services Co.,Ltd.');
// 管理画面色
define('ADMIN_COLOR', '#637D9F');

/* アプリ変数設定 */

// パスワード用ソルト
$config['salt'] = 'qfmcyohkvmsrp6bsv3gdkjzntm0jgj1p';

/**
 *  定数設定
 */
// 月締め開始日
define('MONTH_START_DAY', 0);
// 注文表示最大日
define('ORDER_VIEW_MAX_DAY', 7 * 2); // 2週間
define('ORDER_VIEW_LAST_DAY', 7 * 15); // 15週間
// 注文一覧日数
define('ORDER_VIEW_DAY', 7);

/*
 * 管理者区分
 */
define('ADMIN_TYPE_ADMIN', 1);
define('ADMIN_TYPE_USER', 2);

/*
 * 公開サイト メニュー
 */
define('DEFAULT_MENU_ORDER', 11);
define('DEFAULT_MENU_ORDER_CLAIM', 12);
define('DEFAULT_MENU_ORDER_HISTORY', 13);

define('DEFAULT_MENU_PASSWORD', 21);

/*
 * 管理サイト メニュー
 */
define('ADMIN_MENU_ORDER', 11);
define('ADMIN_MENU_ORDER_TOTAL', 12);

define('ADMIN_MENU_ITEM', 21);

define('ADMIN_MENU_USER', 31);
define('ADMIN_MENU_ADMIN', 32);
define('ADMIN_MENU_PASSWORD', 33);

define('ADMIN_MENU_SYSTEM', 98);
define('ADMIN_MENU_SYSTEM_INFO', 99);

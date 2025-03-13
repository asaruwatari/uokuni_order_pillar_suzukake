<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['base_url']            = 'https://'.$_SERVER["HTTP_HOST"].dirname($_SERVER['SCRIPT_NAME']).'/';
$config['index_page']          = '';
$config['uri_protocol']        = 'AUTO';
$config['url_suffix']          = '';
$config['language']            = 'japanese';
$config['charset']             = 'UTF-8';
$config['enable_hooks']        = FALSE;
$config['subclass_prefix']     = 'MY_';
$config['composer_autoload']   = FALSE;
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';


$config['enable_query_strings'] = FALSE;
$config['controller_trigger']   = 'c';
$config['function_trigger']     = 'm';
$config['directory_trigger']    = 'd';

$config['allow_get_array'] = TRUE;

$config['log_threshold']        = 1;
$config['log_path']             = realpath(BASEPATH.'../tmp/logs').'/';
$config['log_file_extension']   = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format']      = 'Y-m-d H:i:s';

$config['error_views_path'] = '';

$config['cache_path']         = realpath(BASEPATH.'../tmp/cache');
$config['cache_query_string'] = FALSE;

$config['encryption_key'] = '1518730774c0f3ff5c5de11829f72176';

$config['sess_driver']             = 'files';
$config['sess_cookie_name']        = 'ci_session';
$config['sess_expiration']         = 0; // ブラウザ閉じるとログアウト
$config['sess_save_path']          = realpath(BASEPATH.'../tmp/sessions'); // セッションファイルの位置をシステム内に変更
$config['sess_match_ip']           = FALSE;
$config['sess_time_to_update']     = 60 * 60 * 8;
$config['sess_regenerate_destroy'] = FALSE;

$config['cookie_prefix']   = '';
$config['cookie_domain']   = '';
$config['cookie_path']     = dirname($_SERVER['SCRIPT_NAME']) == '/' ? '/' : dirname($_SERVER['SCRIPT_NAME']).'/';
$config['cookie_secure']   = TRUE;
$config['cookie_httponly'] = TRUE;

$config['standardize_newlines'] = FALSE;

$config['global_xss_filtering'] = FALSE;

$config['csrf_protection']   = true;
$config['csrf_token_name']   = 'csrf_test_name';
$config['csrf_cookie_name']  = 'csrf_cookie_name';
$config['csrf_expire']       = 60 * 60 * 8;
$config['csrf_regenerate']   = FALSE;
$config['csrf_exclude_uris'] = '';

$config['compress_output'] = FALSE;

$config['time_reference'] = 'local';

$config['rewrite_short_tags'] = FALSE;

$config['proxy_ips'] = '';

// テンポラリの位置をシステム内に変更
putenv('TMPDIR='.realpath(BASEPATH.'../tmp'));

// 8時間放置したらログアウト
ini_set('session.gc_maxlifetime', 60 * 60 * 8);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);

<table class="table table-bordered table-sm">
    <tr>
        <th style="width:20%">OS</th>
        <td><?= php_uname() ?></td>
    </tr>
    <tr>
        <th>WEBサーバー</th>
        <td><?= $_SERVER['SERVER_SOFTWARE'] ?></td>
    </tr>
    <tr>
        <th>PHP (SAPI)</th>
        <td>PHP <?= phpversion() ?> (<?= php_sapi_name() ?>)</td>
    </tr>
    <tr>
        <th>CodeIgniter</th>
        <td>CodeIgniter <?= CI_VERSION ?></td>
    </tr>
    <tr>
        <th>CI_ENV</th>
        <td><?= getenv('CI_ENV') ?></td>
    </tr>
    <tr>
        <th>DBサーバー</th>
        <td><?= $this->db->platform() ?> <?= $this->db->version() ?></td>
    </tr>
    <tr>
        <th>DBホスト</th>
        <td><?= $this->db->hostname ?></td>
    </tr>
    <tr>
        <th>DB</th>
        <td><?= $this->db->database ?></td>
    </tr>
</table>

<table class="table table-bordered table-sm">
    <tr>
        <th style="width:20%">CPU平均負荷 (1分 / 5分 / 15分)</th>
        <td><?= implode(' / ', sys_getloadavg()) ?></td>
    </tr>
    <tr>
        <th>ストレージ</th>
        <td><?= number_format((disk_total_space(APPPATH) - disk_free_space(APPPATH)) / 1024 / 1024 / 1024) ?> / <?= number_format(disk_total_space(APPPATH) / 1024 / 1024 / 1024) ?>GB</td>
    </tr>
    <tr>
        <th>PHP</th>
        <td>memory peak <?= round(memory_get_peak_usage() / (1024 * 1024), 2) ?>MB</td>
    </tr>
</table>

<h2 class="h4">PHP</h2>
<table class="table table-bordered table-sm">
    <tr>
        <th style="width:20%">PHP Extensions</th>
        <td colspan="2"><?= implode("\n", get_loaded_extensions()) ?></td>
    </tr>
    <tr>
        <th>display_errors</th>
        <td><?= ini_get('display_errors') ?></td>
        <td>エラーを画面表示するか 本番環境 0</td>
    </tr>
    <tr>
        <th>short_open_tag</th>
        <td><?= ini_get('short_open_tag') ?></td>
        <td></td>
    </tr>
    <tr>
        <th>default_charset</th>
        <td><?= ini_get('default_charset') ?></td>
        <td>UTF-8 が設定されている事</td>
    </tr>
    <tr>
        <th>mbstring.language</th>
        <td><?= ini_get('mbstring.language') ?></td>
        <td>Japanese が設定されている事</td>
    </tr>
    <tr>
        <th>mbstring.internal_encoding</th>
        <td><?= ini_get('mbstring.internal_encoding') ?></td>
        <td>UTF-8 が設定されている事</td>
    </tr>
    <tr>
        <th>date.timezone</th>
        <td><?= ini_get('date.timezone') ?></td>
        <td>Asia/Tokyo が設定されている事</td>
    </tr>
    <tr>
        <th>memory_limit</th>
        <td><?= ini_get('memory_limit') ?></td>
        <td></td>
    </tr>
    <tr>
        <th>post_max_size</th>
        <td><?= ini_get('post_max_size') ?></td>
        <td></td>
    </tr>
    <tr>
        <th>upload_max_filesize</th>
        <td><?= ini_get('upload_max_filesize') ?></td>
        <td></td>
    </tr>
    <tr>
        <th>max_input_vars</th>
        <td><?= ini_get('max_input_vars') ?></td>
        <td></td>
    </tr>
    <tr>
        <th>sys_get_temp_dir</th>
        <td><?= sys_get_temp_dir() ?></td>
        <td></td>
    </tr>
    <tr>
        <th>sys_temp_dir</th>
        <td><?= ini_get('sys_temp_dir') ?></td>
        <td></td>
    </tr>
    <tr>
        <th>upload_tmp_dir</th>
        <td><?= ini_get('upload_tmp_dir') ?></td>
        <td></td>
    </tr>
    <tr>
        <th>session.save_path</th>
        <td><?= ini_get('session.save_path') ?></td>
        <td></td>
    </tr>
    <tr>
        <th>session.cookie_lifetime</th>
        <td><?= ini_get('session.cookie_lifetime') ?></td>
        <td></td>
    </tr>
    <tr>
        <th>session.cookie_domain</th>
        <td><?= ini_get('session.cookie_domain') ?></td>
        <td></td>
    </tr>
    <tr>
        <th>session.cookie_path</th>
        <td><?= ini_get('session.cookie_path') ?></td>
        <td></td>
    </tr>
    <tr>
        <th>session.cookie_secure</th>
        <td><?= ini_get('session.cookie_secure') ?></td>
        <td></td>
    </tr>
    <tr>
        <th>session.cookie_httponly</th>
        <td><?= ini_get('session.cookie_httponly') ?></td>
        <td></td>
    </tr>
    <tr>
        <th>session.gc_maxlifetime</th>
        <td><?= ini_get('session.gc_maxlifetime') ?></td>
        <td></td>
    </tr>
    <tr>
        <th>session.gc_probability</th>
        <td><?= ini_get('session.gc_probability') ?></td>
        <td></td>
    </tr>
    <tr>
        <th>session.gc_divisor</th>
        <td><?= ini_get('session.gc_divisor') ?></td>
        <td></td>
    </tr>
</table>

<h2 class="h4">MySQL</h2>
<table class="table table-bordered table-sm">
    <tr>
        <th style="width:20%">character_set_client</th>
        <td><?= $db_variables['character_set_client']['Value'] ?></td>
        <td></td>
    </tr>
    <tr>
        <th>character_set_connection</th>
        <td><?= $db_variables['character_set_connection']['Value'] ?></td>
        <td></td>
    </tr>
    <tr>
        <th>character_set_results</th>
        <td><?= $db_variables['character_set_results']['Value'] ?></td>
        <td></td>
    </tr>
    <tr>
        <th>character_set_database</th>
        <td><?= $db_variables['character_set_database']['Value'] ?></td>
        <td></td>
    </tr>
    <tr>
        <th>character_set_server</th>
        <td><?= $db_variables['character_set_server']['Value'] ?></td>
        <td>utf8mb4 推奨</td>
    </tr>
    <tr>
        <th>sql_mode</th>
        <td><?= $db_variables['sql_mode']['Value'] ?></td>
        <td></td>
    </tr>
    <tr>
        <th>max_allowed_packet</th>
        <td><?= $db_variables['max_allowed_packet']['Value'] / 1024 / 1024 / 1024 ?>GB</td>
        <td></td>
    </tr>
    <tr>
        <th>innodb_file_per_table</th>
        <td><?= $db_variables['innodb_file_per_table']['Value'] ?></td>
        <td>ON 推奨</td>
    </tr>
    <tr>
        <th>innodb_large_prefix</th>
        <td><?= $db_variables['innodb_large_prefix']['Value'] ?></td>
        <td></td>
    </tr>
    <tr>
        <th>innodb_file_format</th>
        <td><?= $db_variables['innodb_file_format']['Value'] ?></td>
        <td>Barracuda 推奨</td>
    </tr>
    <tr>
        <th>innodb_default_row_format</th>
        <td><?= $db_variables['innodb_default_row_format']['Value'] ?></td>
        <td>dynamic 推奨</td>
    </tr>
    <tr>
        <th>innodb_buffer_pool_size</th>
        <td><?= $db_variables['innodb_buffer_pool_size']['Value'] / 1024 / 1024 ?>MB</td>
        <td></td>
    </tr>
    <tr>
        <th>innodb_log_file_size</th>
        <td><?= $db_variables['innodb_log_file_size']['Value'] / 1024 / 1024 ?>MB</td>
        <td></td>
    </tr>
    <tr>
        <th>innodb_log_buffer_size</th>
        <td><?= $db_variables['innodb_log_buffer_size']['Value'] / 1024 / 1024 ?>MB</td>
        <td></td>
    </tr>
    <tr>
        <th>sort_buffer_size</th>
        <td><?= $db_variables['sort_buffer_size']['Value'] / 1024 / 1024 ?>MB</td>
        <td></td>
    </tr>
    <tr>
        <th>read_rnd_buffer_size</th>
        <td><?= $db_variables['read_rnd_buffer_size']['Value'] / 1024 / 1024 ?>MB</td>
        <td></td>
    </tr>
    <tr>
        <th>join_buffer_size</th>
        <td><?= $db_variables['join_buffer_size']['Value'] / 1024 / 1024 ?>MB</td>
        <td></td>
    </tr>
    <tr>
        <th>read_buffer_size</th>
        <td><?= $db_variables['read_buffer_size']['Value'] / 1024 / 1024 ?>MB</td>
        <td></td>
    </tr>
    <tr>
        <th>key_buffer_size</th>
        <td><?= $db_variables['key_buffer_size']['Value'] / 1024 / 1024 ?>MB</td>
        <td></td>
    </tr>
    <tr>
        <th>query_cache_size</th>
        <td><?= $db_variables['query_cache_size']['Value'] / 1024 / 1024 ?>MB</td>
        <td></td>
    </tr>
    <tr>
        <th>default_password_lifetime</th>
        <td><?= $db_variables['default_password_lifetime']['Value'] ?></td>
        <td>パスワード有効日数 0 にする事</td>
    </tr>
    <tr>
        <th>explicit_defaults_for_timestamp</th>
        <td><?= $db_variables['explicit_defaults_for_timestamp']['Value'] ?></td>
        <td>ON=TIMESTAMP型に暗黙的なデフォルト値が設定されなくなる</td>
    </tr>
    <tr>
        <th>expire_logs_days</th>
        <td><?= $db_variables['expire_logs_days']['Value'] ?></td>
        <td>バイナリログ保存日数</td>
    </tr>
</table>

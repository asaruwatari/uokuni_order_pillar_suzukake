<?php
/**
 * 基底コントローラ
 *
 * @package    Common
 * @subpackage Controller
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class MY_Controller extends CI_Controller
{
    /**
     * レイアウト
     *
     * @var string
     */
    public $layout = 'default';

    /**
     * テンプレート
     *
     * @var string
     */
    public $template = '';

    /**
     * ページタイトル
     *
     * @var string
     */
    public $title = '';

    /**
     * コンストラクタ
     *
     * @param void
     */
    public function __construct()
    {
        parent::__construct();

        // セッション開始
        $this->load->library('session');

        // 現在日時をセット(システム一時的に変更した現在日時)
        $this->load->vars('systemtime', $this->get_systemtime());

        // Viewでパス情報を簡単に得るためにアサイン
        $this->load->vars('dir', $this->router->directory);
        $this->load->vars('class', $this->router->class);
        $this->load->vars('method', $this->router->method);

        // ViewでGET引数を簡単に得るためにアサイン
        $this->load->vars('get', $this->input->get());
    }

    /*
     * レイアウト機能
     *
     * layoutsディレクトリ内の指定ファイルViewのレイアウトとし
     * $content部分にURLに対応するViewを表示する機能
     * Codeigniterには実装されていないため作成
     */
    /**
     * レイアウト機能を用いページを表示する
     *
     * _outputメソッドはCIの標準機能、コントローラ終了後自動的にコールされる
     *
     * @param void
     * @return void
     */
    public function _output()
    {
        $directory = $this->router->directory;

        // コンテンツ
        $class  = $this->router->class ? $this->router->class : 'top';
        $method = $this->router->method ? $this->router->method : 'index';

        // レイアウト
        $layout = $this->layout ? $this->layout : 'default';

        // テンプレート
        $template = $this->template ? $this->template : $directory.$class.'-'.$method;

        $this->load->vars('title', $this->title);
        $this->load->vars('content', $this->load->view($template, '', true));
        echo $this->load->view($directory.'layouts/'.$layout, '', true);
    }

    /*
     * URL履歴機能
     *
     * ブラウザの戻るではなくユニークなURLの履歴を記憶し
     * 正確に戻るために使用する
     */
    /**
     * 戻り先URLを初期化する
     *
     * @param void
     * @return bool
     */
    public function unset_back_url()
    {
        $module = $this->router->directory.'_back_url';
        return $this->session->unset_userdata($module);
    }

    /**
     * 戻り先URLを保存する
     *
     * モジュール単位で記憶する
     *
     * @param void
     * @return bool
     */
    public function set_back_url()
    {
        // 当画面のキー（同じURLの記録があるか判別するため）
        $key = $this->router->class.'/'.$this->router->method;
        // 当画面のURL
        $url = uri_string().($_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : '');
        if (empty($url)) {
            $url = '/';
        }

        // セッションから履歴配列を得る
        $module = $this->router->directory.'_back_url';
        $urls   = $this->session->userdata($module);

        // 履歴配列が存在するか
        if (!is_array($urls)) {
            // 履歴初期化
            $urls = array();
        }

        // キーがあれば消す
        //unset($urls[$key]);
        // 履歴に現在のページがあればそれまでの履歴を削除する
        if (true === array_key_exists($key, $urls)) {
            // 配列ポインタ初期化
            reset($urls);
            // キーの次までポインタを進める
            foreach ($urls as $h_key => $h_url) {
                unset($urls[$h_key]);
                // キーが一致すればループを抜ける
                if ($key == $h_key) {
                    break;
                }
            }
        }
        // 配列の先頭に積む(連想配列なのでarray_unshiftは使えない)
        $urls = array($key => $url) + $urls;

        // 配列をセッションに保存する
        return $this->session->set_userdata($module, $urls);
    }

    /**
     * 戻り先URLを得る
     *
     * @param void
     * @return string
     */
    public function get_back_url()
    {
        // 当画面のキー（同じURLの記録があるか判別するため）
        //$key = $this->router->class.'/'.$this->router->method;
        // セッションから配列を得る
        $module = $this->router->directory.'_back_url';
        $urls   = $this->session->userdata($module);

        // 直前のURLを得る
        $back_url = array_shift($urls); // この画面
        $back_url = array_shift($urls); // 前の画面
        // 履歴が無ければコントローラ直下を返す
        if (empty($back_url)) {
            $back_url = $this->router->directory.$this->router->class;
        }

        return $back_url;
    }

    /*
     * フラッシュメッセージ
     *
     * Sessionライブラリのflashdataは画面を遷移しないと取り出せないため
     * バリデーションなど画面遷移を伴わない場合使用できないため独自で実装
     */
    /**
     * メッセージをセッションから取得する
     *
     * @param $text メッセージ
     * @return void
     */
    public function set_message($text)
    {
        $messages = $this->session->userdata('message');
        if (empty($messages)) {
            $messages = array();
        }
        $messages[] = $text;
        $this->session->set_userdata('message', $messages);
    }

    /**
     * メッセージをセッションに記録する
     *
     * @param void
     * @return string
     */
    public function get_message()
    {
        $text = $this->session->userdata('message');
        $this->session->unset_userdata('message');
        return $text;
    }

    /**
     * エラーメッセージをセッションに記録する
     *
     * @param $text メッセージ
     * @return void
     */
    public function set_error($text)
    {
        $messages = $this->session->userdata('error');
        if (empty($messages)) {
            $messages = array();
        }
        $messages[] = $text;
        $this->session->set_userdata('error', $messages);

        // ログ
        $backtrace = debug_backtrace();
        log_message('error', 'App: '.$_SERVER['REMOTE_ADDR'].' ['.$text.'] '.$backtrace[0]['file'].' '.$backtrace[0]['line'].' ['.$_SERVER['HTTP_USER_AGENT'].']');
    }

    /**
     * エラーメッセージをセッションから取得する
     *
     * @param void
     * @return string
     */
    public function get_error()
    {
        $text = $this->session->userdata('error');
        $this->session->unset_userdata('error');
        return $text;
    }

    /*
     * 時間制御
     *
     * テスト等のためシステム内の時間を任意に設定する
     */

    /*
     * システム日時を設定する
     *
     * @param void
     * @return bool
     */
    public function set_systemtime($dateime)
    {
        return set_cookie('systemtime', $dateime, 0);
    }

    /*
     * システム日時を得る
     *
     * @param void
     * @return bool
     */
    public function get_systemtime()
    {
        return get_cookie('systemtime') ?: time();
    }

    /*
     * システム日時を削除する
     *
     * @param void
     * @return bool
     */
    public function delete_systemtime()
    {
        return delete_cookie('systemtime');
    }

    /*
     * システム日付を得る
     *
     * @param void
     * @return bool
     */
    public function get_date()
    {
        return date('Y-m-d', get_cookie('systemtime') ?: time());
    }

    /*
     * システム日時を得る
     *
     * @param void
     * @return bool
     */
    public function get_datetime()
    {
        return date('Y-m-d H:i:s', get_cookie('systemtime') ?: time());
    }

    /**
     * POSTし結果を得る
     *
     * @param type $url
     * @param type $data
     */
    protected function post($url, $data)
    {
        $curl   = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    /*
     * 共通処理
     */
    /**
     * 設定ファイルからバリデーションルール連想配列を得る
     *
     * @param type $name バリデーションルール名
     * @return array バリデーションルール
     */
    protected function get_validation_rules($name = null)
    {
        // バリデーションルール名の指定がなければクラス名
        $name = $name ?: $this->router->class;

        $this->config->load('validation_rules', true);
        $rules = $this->config->item($name, 'validation_rules');
        // fieldをキーに設定する（手動で行うのは煩雑なため）
        return $rules ? array_column($rules, null, 'field') : array();
    }

    /**
     * ページネーションを設定する
     *
     * @param integer $total_rows
     * @param integer $row_count
     * @return void
     */
    protected function init_pagination($total_rows, $row_count)
    {
        $this->load->library('pagination');

        // クエリストリング調整
        $query = $this->input->get();
        // paginationも(query_string_segment)を付けるので除外しておく
        // V3でquery_string_segmentがprotectedになったのでoを直指定
        unset($query['o']);
        $query = $query ? http_build_query($query) : '';

        $base_url = $this->router->directory.$this->router->class.'/'.$this->router->method;

        // ページネーション初期化
        $config = array(
            'base_url'   => $base_url.'/?'.$query,
            'total_rows' => $total_rows,
            'per_page'   => $row_count,
            //'uri_segment' => $this->uri_segment,
        );
        $this->pagination->initialize($config);
    }

    /**
     * クラス名からモデル名を得る
     *
     * @param void
     * @return string モデル名
     */
    protected function get_model_name($model_name = null)
    {
        return empty($model_name) ? ucfirst(get_class($this)).'_model' : ucfirst($model_name).'_model';
    }

    /**
     * CSVファイル出力
     *
     * @param $filename 出力ファイル名
     * @param $fields   項目名の配列(添え字がフィールド名の連想配列)
     * @param $items	情報の配列(添え字がフィールド名の連想配列)
     * @return void
     */
    protected function download_csv_file($filename, $fields, $items)
    {
        // 一時ファイル作成
        $tmp_file = tempnam(sys_get_temp_dir(), '');

        // CSVデータ取得
        $this->load->library('Csv');
        $this->csv->open($tmp_file);
        $this->csv->set($fields);
        foreach ($items as $item) {
            $data = array();
            foreach ($fields as $key => $name) {
                $data[] = isset($item[$key]) ? $item[$key] : '';
            }
            $this->csv->set($data);
        }
        $this->csv->close();

        // 変数に入れファイルは削除
        $data = file_get_contents($tmp_file);
        unlink($tmp_file);

        // 出力
        $this->load->helper('download');
        force_download($filename, $data);
    }

    /**
     * 画像ファイルを正方形にトリミングする
     * 要GD
     *
     * @param string $source_file
     * @param integer $dest_size
     * @return bool
     */
    protected function trim_square_image($source_file, $dest_size)
    {
        // 元画像のサイズ取得
        $source_image   = imagecreatefromstring(file_get_contents($source_file));
        $source_image_w = imagesx($source_image);
        $source_image_h = imagesy($source_image);

        // 画像の抽出部分算出
        $source_min_size = min($source_image_w, $source_image_h);
        $source_x        = floor(($source_image_w - $source_min_size) / 2);
        $source_y        = floor(($source_image_h - $source_min_size) / 2);

        // 画像作成
        $dest_image = imagecreatetruecolor($dest_size, $dest_size);
        // 再サンプリング（切り抜き）
        imagecopyresampled($dest_image, $source_image, 0, 0, $source_x, $source_y, $dest_size, $dest_size, $source_min_size, $source_min_size);
        // 拡張子で関数名定義
        switch (pathinfo($source_file, PATHINFO_EXTENSION)) {
            case 'png':
                $function = 'imagepng';
                break;
            case 'jpg':
            case 'jpeg':
                $function = 'imagejpeg';
                break;
            case 'gif':
                $function = 'imagegif';
                break;
        }
        // 画像変換
        $result = $function($dest_image, $source_file);

        // 削除
        imagedestroy($source_image);
        imagedestroy($dest_image);
        return $result;
    }

    /**
     * 自動メールを送信する
     *
     * @param integer $id 自動メールID
     * @param string $to 送信先
     * @param array $data 送信データ
     * @return bool
     */
    protected function send_automail($id, $to, $data)
    {
        // 自動返信メールテンプレート取得
        $this->load->model($this->router->directory.'Automail_model');
        $template = $this->Automail_model->get_by_id($id);

        // メール送信
        $this->load->library('email');
        $this->email->from($template['from']);
        $this->email->to($to);
        $this->email->cc($template['cc']);
        $this->email->bcc($template['bcc']);
        $this->email->subject($this->email->replace($data, $template['subject']));
        $this->email->message($this->email->replace($data, $template['body']));
        return $this->email->send();
    }

    /**
     * 削除フラグ選択肢を得る
     *
     * @return array
     */
    protected function get_deleted_options()
    {
        return array(
            0 => '',
            1 => '削除',
        );
    }

    /**
     * 都道府県選択肢を得る
     *
     * @param void
     * @return array
     */
    protected function get_prefecture_options()
    {
        return [
            '北海道'  => '北海道', '青森県'  => '青森県', '岩手県'  => '岩手県', '宮城県'  => '宮城県', '秋田県'  => '秋田県',
            '山形県'  => '山形県', '福島県'  => '福島県', '茨城県'  => '茨城県', '栃木県'  => '栃木県', '群馬県'  => '群馬県',
            '埼玉県'  => '埼玉県', '千葉県'  => '千葉県', '東京都'  => '東京都', '神奈川県' => '神奈川県', '新潟県'  => '新潟県',
            '富山県'  => '富山県', '石川県'  => '石川県', '福井県'  => '福井県', '山梨県'  => '山梨県', '長野県'  => '長野県',
            '岐阜県'  => '岐阜県', '静岡県'  => '静岡県', '愛知県'  => '愛知県', '三重県'  => '三重県', '滋賀県'  => '滋賀県',
            '京都府'  => '京都府', '大阪府'  => '大阪府', '兵庫県'  => '兵庫県', '奈良県'  => '奈良県', '和歌山県' => '和歌山県',
            '鳥取県'  => '鳥取県', '島根県'  => '島根県', '岡山県'  => '岡山県', '広島県'  => '広島県', '山口県'  => '山口県',
            '徳島県'  => '徳島県', '香川県'  => '香川県', '愛媛県'  => '愛媛県', '高知県'  => '高知県', '福岡県'  => '福岡県',
            '佐賀県'  => '佐賀県', '長崎県'  => '長崎県', '熊本県'  => '熊本県', '大分県'  => '大分県', '宮崎県'  => '宮崎県',
            '鹿児島県' => '鹿児島県', '沖縄県'  => '沖縄県'];
    }

    /**
     * 一覧画面 基底メソッド
     *
     * @param integer $per_page	ページあたりの表示数（1以上でページング）
     * @param array $conditions 抽出条件
     * @param string $model_name モデル名
     * @param string $validation_name 使用するバリデーション名
     * @param string $method_name データを取得するメソッド名
     * @return bool
     */
    protected function general_index($per_page = 0, $conditions = [], $model_name = null, $validation_name = null, $method_name = 'get_list_data', $condition_required_flag = false)
    {
        // 呼び出し元メソッド名
        $caller_function = debug_backtrace()[1]['function'];

        // 選択肢設定(継承先コントローラで用意)
        if (true === is_callable(array($this, 'set_options'))) {
            $this->set_options();
        }

        // バリデーションルール名の指定がなければクラス名
        $validation_name = $validation_name ?: $this->router->class;

        // バリデーションルール取得
        $validation_rules = $this->get_validation_rules($validation_name);

        // モデル定義
        // モデル名が無ければクラス名から作成する
        $model_name = $this->get_model_name($model_name);
        $this->load->model($this->router->directory.$model_name);

        // 条件にGET内容を追加
        $conditions += $this->input->get();

        // 条件必須で条件が無いならデータを取得せずViewへ
        if ($condition_required_flag && empty($conditions)) {
            return;
        }

        // $per_pageが設定されていればページネーション設定
        if ($per_page) {
            $per_page   = (int) $this->input->get('per_page') ?: $per_page;
            // ページネーションあり
            // 読み飛ばす数を取得（ページネーションから引数oで渡される）
            $offset     = (int) $this->input->get('o');
            // 情報取得
            $list       = $this->$model_name->$method_name($per_page, $offset, $conditions);
            $total_rows = $this->$model_name->total_rows;
            // ページネーション初期化
            $this->init_pagination($total_rows, $per_page);
            // Viewにアサイン
            $this->load->vars('pagination', ['total_rows' => $total_rows, 'rows_from' => $offset + 1, 'rows_to' => $offset + count($list)]);
        } else {
            // ページネーションなし
            // 情報取得
            $list = $this->$model_name->$method_name(null, null, $conditions);
        }

        // フック：アサイン前
        $function = $caller_function.'_hook_before_assign';
        if (true === is_callable(array($this, $function))) {
            if (false === $this->$function($list, $validation_rules)) {
                return false;
            }
        }

        // Viewにアサイン
        $this->load->vars('list', $list);
        // バリデーションルールアサイン
        $this->load->vars('validation_rules', $validation_rules);

        return true;
    }

    /**
     * 編集画面 基底メソッド
     *
     * @param int $id 対象のID
     * @param array $conditions 抽出条件
     * @param array $default_value 初期値
     * @param string $model_name 使用するモデル名
     * @param string $validation_name 使用するバリデーション名
     * @param string $method_name データを取得するメソッド名
     * @return bool
     */
    protected function general_edit($id = null, $conditions = [], $default_value = [], $model_name = null, $validation_name = null, $method_name = 'get_edit_data')
    {
        // 呼び出し元メソッド名
        $caller_function = debug_backtrace()[1]['function'];

        // 選択肢設定(各コントローラで用意)
        if (true === is_callable([$this, 'set_options'])) {
            $this->set_options();
        }

        // バリデーションルール名の指定がなければクラス名
        $validation_name = $validation_name ?: $this->router->class;

        // バリデーションルール取得
        $validation_rules = $this->get_validation_rules($validation_name);

        // モデル生成
        $model_name = $this->get_model_name($model_name);
        $this->load->model($this->router->directory.$model_name);

        // 情報取得
        if ($id) {
            // 編集
            if (false == $data = $this->$model_name->$method_name(['id' => $id] + (array) $conditions)) {
                // 情報が取れない
                exit;
            }
        } else {
            // 新規
            $data = $default_value;
        }
        // フック：アサイン前
        $function = $caller_function.'_hook_before_assign';
        if (true === is_callable([$this, $function])) {
            if (false === $this->$function($data, $validation_rules)) {
                return false;
            }
        }

        // フォーム初期値アサイン
        $this->load->vars('data', $data);
        // バリデーションルールアサイン
        $this->load->vars('validation_rules', $validation_rules);

        // POST確認
        if (!$post = $this->input->post()) {
            // POSTしていない
            return;
        }

        // バリデーション
        $this->load->library('form_validation');
        // フック：バリデーション前
        $function = $caller_function.'_hook_before_validation';
        if (true === is_callable([$this, $function])) {
            if (false === $this->$function($data, $validation_rules, $post)) {
                return false;
            }
        }
        // バリデーション実行
        $this->form_validation->set_data($post);
        $this->form_validation->set_rules($validation_rules);
        // フック：バリデーション
        $function = $caller_function.'_hook_validation';
        if (true === is_callable([$this, $function])) {
            if (false === $this->$function($data, $validation_rules, $post)) {
                return false;
            }
        }
        if (false === $this->form_validation->run()) {
            $this->set_error(lang('message_validation_error'));
            return false;
        }

        // フック：保存前
        $function = $caller_function.'_hook_before_save';
        if (true === is_callable([$this, $function])) {
            if (false === $this->$function($data, $validation_rules, $post)) {
                return false;
            }
        }

        // バリデーションルールにある項目のみにする
        //$post = array_intersect_key($post, $validation_rules);
        // 保存
        if (false === $this->$model_name->set($id, $post)) {
            // 保存失敗
            $this->set_error(lang('message_save_error'));
            return false;
        }

        // フック：保存後
        $function = $caller_function.'_hook_after_save';
        if (true === is_callable([$this, $function])) {
            if (false === $this->$function($data, $validation_rules, $post)) {
                return false;
            }
        }

        // 完了
        $this->set_message(lang('message_saved'));

        return true;
    }

    /**
     * 削除処理 基底メソッド
     *
     * @param mixed $id 対象のID
     * @param array $conditions 条件
     * @param string $model_name モデル名
     */
    protected function general_delete($id, $conditions = [], $model_name = null)
    {
        // 使用メモリ、実行時間を無制限に設定
        ini_set('memory_limit', -1);
        set_time_limit(0);

        if (empty($id)) {
            $this->set_error('対象が選択されていません');
            return false;
        }

        // 削除
        $model_name = $this->get_model_name($model_name);
        $this->load->model($this->router->directory.$model_name);
        if (false === $this->$model_name->delete(['id' => $id] + (array) $conditions)) {
            // 失敗
            $this->set_error(lang('message_delete_error'));
            return false;
        }
        // 成功
        $this->set_message(lang('message_deleted'));
        return true;
    }

    /**
     * パスワード変更画面 基底メソッド
     *
     * @param	integer	$id	対象のID
     */
    protected function general_change_password($id)
    {
        // バリデート設定
        $validation_rules = array(
            'password'      => array(
                'field' => 'password',
                'label' => 'パスワード',
                'rules' => 'required|password',
                'guide' => '英数を各1文字以上含む8文字以上',
            ),
            'password_conf' => array(
                'field' => 'password_conf',
                'label' => 'パスワード(確認)',
                'rules' => 'required|matches[password]',
                'guide' => 'パスワードと同じ文字を入力',
            ),
        );
        $this->load->vars('validation_rules', $validation_rules);

        // POST確認
        if (!$post = $this->input->post()) {
            return;
        }

        // バリデーション
        $this->load->library('form_validation');
        $this->form_validation->set_rules($validation_rules);
        if (false === $this->form_validation->run()) {
            $this->set_error(lang('message_validation_error'));
            return false;
        }

        // 保存
        $model_name = $this->get_model_name();
        $this->load->model($this->router->directory.$model_name);
        $data       = ['password' => $post['password']]; // setは参照渡しのため一旦変数に入れる
        if (false === $this->$model_name->set($id, $data)) {
            $this->set_error(lang('message_save_error'));
            return false;
        }

        // 保存成功
        $this->set_message(lang('message_saved'));
        return true;
    }

    /**
     * CSV出力
     *
     * @param array $fields	フィールド配列
     * @param array $conditions 絞込条件
     * @param string $file_name ファイル名
     * @param string $model_name モデル名
     * @return void
     */
    protected function general_export($fields, $conditions = [], $file_name = null, $model_name = null)
    {
        // 使用メモリ、実行時間を無制限に設定
        ini_set('memory_limit', -1);
        set_time_limit(0);

        // ファイル名が無ければクラス名から作成する
        $file_name = $file_name ?: strtolower(get_class($this)).'.csv';

        // モデル名が無ければクラス名から作成する
        $model_name = $this->get_model_name($model_name);

        // 条件にGET内容を追加
        $conditions += $this->input->get();

        // 情報取得
        $this->load->model($this->router->directory.$model_name);
        $data = $this->$model_name->get_export_data($conditions);

        // CSV出力
        $this->download_csv_file($file_name, $fields, $data);
    }

    /**
     * Excel出力
     *
     * @param array $fields	フィールド配列
     * @param array $conditions 絞込条件
     * @param string $filename ファイル名
     * @param string $model_name モデル名
     * @return void
     */
    protected function general_export_excel($fields, $conditions = [], $filename = null, $model_name = null)
    {
        // 使用メモリ、実行時間を無制限に設定
        ini_set('memory_limit', -1);
        set_time_limit(0);

        // ファイル名が無ければクラス名から作成する
        $filename = $filename ?: strtolower(get_class($this)).'.xlsx';

        // モデル名が無ければクラス名から作成する
        $model_name = $this->get_model_name($model_name);

        // 条件にGET内容を追加
        $conditions += $this->input->get();

        // 情報取得
        $this->load->model($this->router->directory.$model_name);
        $list = $this->$model_name->get_export_data($conditions);

        $this->load->vars('filename', $filename);
        $this->load->vars('fields', $fields);
        $this->load->vars('list', $list);
    }

    /**
     * CSV入力
     *
     * @param array $columns カラム
     * @param array $params パラメータ
     * @param array $header_number ヘッダ行数
     * @param string $model_name モデル名
     * @return void
     */
    protected function general_import_csv($columns = [], $params = [], $header_number = 1, $model_name = null)
    {
        // 使用メモリ、実行時間を無制限に設定
        ini_set('memory_limit', -1);
        set_time_limit(0);

        // 呼び出し元メソッド名
        $caller_function = debug_backtrace()[1]['function'];

        // モデル名が無ければクラス名から作成する
        $model_name = $this->get_model_name($model_name);

        // ファイルアップロード
        $this->load->library('upload', [
            'upload_path'   => sys_get_temp_dir(),
            'allowed_types' => 'csv',
        ]);
        if (false === $this->upload->do_upload("file")) {
            $this->set_error($this->upload->display_errors());
            return false;
        }
        $upload = $this->upload->data();

        // CSVから保存用の配列を作成する
        $this->load->library('csv');
        $this->csv->open($upload['full_path']);
        $this->csv->get(); //ヘッダを捨てる

        $data       = [];
        $line_count = 1;
        $error_flag = false;

        while ($line = $this->csv->get()) {
            // 行数カウント
            $line_count++;

            // 保存情報配列を作成
            $function = $caller_function.'_make_data';
            $result   = $this->$function($line, $data, $line_count, $columns, $params);
            // エラー確認
            if (false === $result) {
                $error_flag = true;
            }
        }

        // CSVファイルクローズ(しないと消せない)
        $this->csv->close();
        // CSVファイル削除
        unlink($upload['full_path']);

        // エラー確認
        if (true === $error_flag) {
            // エラー
            $this->set_error('インポートを中止しました');
            redirect($this->get_back_url());
        }

        // 保存
        $this->load->model($this->router->directory.$model_name);
        if (false === $this->$model_name->import($data)) {
            // エラー
            $this->set_error('インポートに失敗しました');
            redirect($this->get_back_url());
            exit;
        }

        // 完了
        $this->set_message('インポートを完了しました');
        redirect($this->get_back_url());
        exit;
    }

    /**
     * Excel入力
     *
     * @param array $params	パラメータ
     * @param array $header_number ヘッダ行数
     * @param string $model_name モデル名
     * @return void
     */
    protected function general_import_excel($params = [], $header_number = 1, $model_name = null)
    {
        // 使用メモリ、実行時間を無制限に設定
        ini_set('memory_limit', -1);
        set_time_limit(0);

        // 呼び出し元メソッド名
        $caller_function = debug_backtrace()[1]['function'];

        // モデル名が無ければクラス名から作成する
        $model_name = $this->get_model_name($model_name);

        // ファイルアップロード
        $this->load->library('upload', [
            'upload_path'   => sys_get_temp_dir(),
            'allowed_types' => 'xlsx',
        ]);
        if (false === $this->upload->do_upload("file")) {
            $this->set_error($this->upload->display_errors());
            return false;
        }
        $upload = $this->upload->data();

        // アップロードしたExcelファイルを読み込む
        $this->load->library("PHPExcel");
        $reader = PHPExcel_IOFactory::createReader('Excel2007');
        // データのみを読み込む
        $reader->setReadDataOnly(true);
        // ロードするシートを設定する
        $reader->setLoadSheetsOnly($reader->listWorksheetNames($upload['full_path'])[0]);
        $book   = $reader->load($upload['full_path']);
        $sheet  = $book->getActiveSheet();

        // Excelのデータを取得
        $lines = $sheet->toArray("", false, false, true);
        // 見出し行を削除
        array_splice($lines, 0, $header_number);

        $data       = [];
        $line_count = $header_number;
        $error_flag = false;

        foreach ($lines as $line) {
            // 行数カウント
            $line_count++;

            // 保存情報配列を作成
            $function = $caller_function.'_make_data';
            $result   = $this->$function($line, $data, $line_count, $params);
            // エラー確認
            if (false === $result) {
                $error_flag = true;
            }
        }

        // メモリの解放
        $book->disconnectWorksheets();
        unset($book);

        // エラー確認
        if (true === $error_flag) {
            // エラー
            $this->set_error('インポートを中止しました');
            redirect($this->get_back_url());
        }

        // 保存
        $this->load->model($this->router->directory.$model_name);
        if (false === $this->$model_name->import($data)) {
            // エラー
            $this->set_error('インポートに失敗しました');
            redirect($this->get_back_url());
            exit;
        }

        // 完了
        $this->set_message('インポートを完了しました');
        redirect($this->get_back_url());
        exit;
    }

    /**
     * 画像ファイル登録と削除
     *
     * カラム名は image番号
     * ファイル項目名は image番号_file
     * 削除フラグ項目名は image番号_delete_flag
     *
     * @param array $data レコード
     * @param string $column_name カラム名
     * @param int $image_number 画像数
     * @param string $dir 画像保存ディレクトリ
     * @param string $allowed_types アップロード許可拡張子
     * @param string $max_width アップロード可能横ピクセル数
     * @param string $max_height アップロード可能縦ピクセル数
     * @param bool $trim_size トリミングサイズ
     * @param string $model_name モデル名
     * @return bool
     */
    protected function general_upload_image(&$data, $column_name, $image_number, $dir, $allowed_types, $max_width = 0, $max_height = 0, $trim_size = 0, $model_name = null)
    {
        $model_name = $this->get_model_name($model_name);

        $image_post = [];
        $result     = true;

        // 画像数分ループ
        for ($i = 1; $i <= $image_number; $i++) {
            $column_name = 'image'.$i;

            /*
             *  画像削除処理
             */
            if (!empty($data[$column_name]) && $this->input->post($column_name.'_delete_flag')) {
                // ファイルはないがテーブルの情報だけ残った場合の事を考えunlinkの結果は確認しない
                @unlink($dir.'/'.$data[$column_name]);
                // ファイル名削除
                $image_post[$column_name] = '';
            }

            /*
             *  画像アップロード処理
             */
            // アップロードあるか確認
            if (empty($_FILES["{$column_name}_file"]['tmp_name'])) {
                continue;
            }
            // POSTでアップロードされたか確認
            if (false === is_uploaded_file($_FILES["{$column_name}_file"]['tmp_name'])) {
                continue;
            }
            // アップロードファイルを一時ファイルに保存
            $this->load->library('upload', [
                'upload_path'   => sys_get_temp_dir(),
                'allowed_types' => $allowed_types,
                'max_width'     => $max_width,
                'max_height'    => $max_height,
            ]);
            if (false === $this->upload->do_upload("{$column_name}_file")) {
                $this->set_error($this->upload->display_errors());
                return false;
            }
            $upload = $this->upload->data();

            $file_name = "item_{$data['id']}_{$i}{$upload['file_ext']}";
            //    if ($file_name) {
            //        // ファイル名指定あり：アップロードファイルから拡張子を取得しファイル名作成
            //        $file_name = $file_name.$upload['file_ext'];
            //    } else {
            //        // ファイル名指定なし：実ファイル名を使用
            //        $file_name = $upload['file_name'];
            //    }
            // ファイル保存
            if (false === rename($upload['full_path'], $dir.'/'.$file_name)) {
                $this->set_error('画像のアップロードに失敗しました');
                unlink($upload['full_path']);
                return false;
            }

            // サイズ指定があれば正方形にトリミング
            if ($trim_size) {
                if (false === $this->trim_square_image($dir.'/'.$file_name, $trim_size)) {
                    $this->set_error('トリミングに失敗しました');
                    return false;
                }
            }

            // ファイル名更新
            $image_post[$column_name] = $file_name;

            // ファイル名が違う場合旧ファイルを削除
            if (!empty($data[$column_name]) && $data[$column_name] != $file_name) {
                @unlink($dir.'/'.$data[$column_name]);
            }
        }

        // レコード更新
        // TODO レコード更新でエラーになると画像ファイルだけが更新されてしまう
        if ($image_post) {
            if (false === $this->$model_name->update($data['id'], $image_post)) {
                // 保存失敗
                $this->set_error(lang('message_save_error'));
                return false;
            }
        }

        return true;
    }

    /**
     * リストに沿いキーを変更した配列を得る
     *
     * @param array $source
     * @param array $key_list
     * @return array
     */
    public function array_key_change(&$source, &$key_list)
    {
        // リストに沿い配列のキーを変更する
        $new_array = [];
        foreach ($source as $key => $value) {
            // 変換リストにキーがあれば変換後のキーにする
            if (array_key_exists($key, $key_list)) {
                $key = $key_list[$key];
            }
            $new_array[$key] = $value;
        }
        return $new_array;
    }

    /*
     *
     * このアプリケーション用
     *
     */
    /**
     * 問い合わせ商品一覧テキストを得る
     *
     * @param array $itemDatas
     * @param array $items
     * @return text
     */
    protected function get_text($itemDatas, $items)
    {
        $template = "----------------------------------------------------------------\r\n";
        foreach ($itemDatas as $key => $itemData) {
            $template .= "[品番]	 ".$itemData['code']."\r\n".
                "[商品名]   ".$itemData['maker'].' '.$itemData['name']."\r\n".
                "[単価]   ".number_format($itemData['price'])."円\r\n".
                "[内容]   ".$items[$key]['remark']."\r\n".
                "----------------------------------------------------------------\r\n";
        }
        return $template;
    }

    /**
     * 受注内容テキストを得る
     *
     * @param array $shop
     * @param array $order
     * @param bool $estimate_flag
     * @return text
     */
    protected function get_order_text($shop, $order, $estimate_flag = false)
    {
        $template = "================================================================================\r\n".
            "[店舗名]　　　　 {$shop['name']}\r\n".
            "[受注番号]　　　 {$order['code']}\r\n".
            "[受注日時]　　　 {$order['created_at']}\r\n".
            "\r\n".
            "■お客様情報\r\n";
        if ($order['user_code']) {
            $template .= "[{$shop['user_code_name']}]";
            for ($i = 1 + mb_strlen($shop['user_code_name']); $i <= 7; $i++) {
                $template .= "　";
            }
            $template .= " {$order['user_code']}\r\n";
        }
        $template .= "[学部・学年]　　 {$order['department']} {$order['year']}年生\r\n".
            "[氏名]　　　　　 {$order['name']}({$order['kana']}) 様\r\n".
            "[住所]　　　　　 〒{$order['zip']} {$order['prefecture']} {$order['address1']} {$order['address2']}\r\n".
            "[電話番号]　　　 {$order['tel']}\r\n".
            "[メールアドレス] {$order['email']}\r\n".
            "\r\n";

        // 支払方法
        $template .= "[支払方法]　　　 {$order['payment.name']}\r\n".
            //"[配送方法]　　　 {$order['shipping.name']}\r\n".
            "\r\n";

        // 送付先情報
        $template .= "■送付先情報\r\n".
            "[氏名]　　　　　 {$order['shipping_name']}({$order['shipping_kana']}) 様\r\n".
            "[住所]　　　　　 〒{$order['shipping_zip']} {$order['shipping_prefecture']} {$order['shipping_address1']} {$order['shipping_address2']}\r\n".
            "[電話番号]　　　 {$order['shipping_tel']}\r\n".
            "\r\n".
            "[備考]　　　　　 {$order['message']}\r\n".
            "\r\n";

        // 商品情報
        $template .= "■商品情報\r\n";
        foreach ($order['items'] as $item) {
            $template .= strtoupper($shop['url']).$item['view_code'].": ".$item['maker'].' '.$item['name'].' '.$item['model']."\r\n".
                '　'.sprintf("% 7s", number_format($item['price'] + $item['tax_price']))." 円 x ".
                sprintf("% 2s", number_format($item['qty'])).$item['unit']." = ".
                sprintf("% 7s", number_format(($item['price'] + $item['tax_price']) * $item['qty']))." 円\r\n";
        }

        // 注文の場合のみ
        if (!$estimate_flag) {
            // 送料・手数料
            // 送料がある時だけ表記
            if ($order['shipping_price']) {
                $template .= "送料（税込）　　　　".sprintf("% 7s", number_format($order['shipping_price'] + $order['shipping_tax_price']))." 円\r\n";
            }

            // 手数料がある時だけ表記
            if ($order['charge_price']) {
                $template .= "手数料（税込）　　　".sprintf("% 7s", number_format($order['charge_price'] + $order['charge_tax_price']))." 円\r\n";
            }

            $template .= "--------------------------------------------------\r\n";
            $template .= "お支払金額（税込）　".sprintf("% 7s", number_format($order['amount_price']))." 円\r\n";
            $template .= "\r\n";
        }
        $template .= "================================================================================\r\n";

        return $template;
    }

}

/**
 * 公開サイト用 基底コントローラ
 *
 * @package    Default
 * @subpackage Controller
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class Default_controller extends MY_Controller
{
    /**
     * コンストラクタ
     *
     * @param void
     */
    public function __construct()
    {
        parent::__construct();

        /*
         * 認証
         */
        $this->load->library('auth', array('name' => $this->router->directory));

        // topクラス以外は未ログインならログインページへ
        if ($this->router->class != 'top') {
            if (false === $this->auth->is_login()) {
                redirect(base_url($this->router->directory));
            }
            // ユーザー情報をセット
            $this->load->model($this->router->directory.'User_model');
            $this->load->vars('login_user', $this->User_model->get_by_id($this->auth->get()));
        }
    }

}

/**
 * 管理サイト用 基底コントローラ
 *
 * @package    Admin
 * @subpackage Controller
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class Admin_controller extends MY_Controller
{
    /**
     * コンストラクタ
     *
     * @param void
     */
    public function __construct()
    {
        parent::__construct();

        /*
         * 認証
         */
        // topクラス以外は全て認証を行う
        $this->load->library('auth', array('name' => $this->router->directory));
        if ($this->router->class != 'top') {
            // 未ログインならログインページへ
            if (false === $this->auth->is_login()) {
                redirect(base_url($this->router->directory));
            }
            // ユーザー情報をセット
            $this->load->model($this->router->directory.'Admin_model');
            $this->load->vars('login_user', $this->Admin_model->get_by_id($this->auth->get()));
        }
    }

    /**
     * 受注メールを送信する
     *
     * @param array $orderIds 受注ID
     * @param array $mail メール情報
     * @return bool
     */
    protected function send_order_mail($orderIds, $mail)
    {
        // 受注情報取得
        $this->load->model($this->router->directory.'Order_model');
        if (!$orders = $this->Order_model->gets_with_items($orderIds)) {
            return false;
        }

        // 注文ループ
        foreach ($orders as $order) {

            // 店舗情報取得
            $this->load->model($this->router->directory.'Shop_model');
            if (!$shop = $this->Shop_model->get_by_id($order['shop_id'])) {
                return false;
            }

            // メールアドレスがある場合は送信
            if ($order['email']) {
                // 置き換え情報設定
                $data = $order + ['order' => $this->get_order_text($shop, $order)];
                // メール送信
                $this->load->library('email');
                $this->email->clear();
                $this->email->to($order['email']);
                $this->email->from($mail['from']);
                $this->email->cc($mail['cc']);
                $this->email->bcc($mail['bcc']);
                $this->email->subject($this->email->replace($data, $mail['subject']));
                $this->email->message($this->email->replace($data, $mail['body']));
                $this->email->send();
            }
        }
        return true;
    }

}

/**
 * API用 基底コントローラ
 *
 * @package    Api
 * @subpackage Controller
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class Api_controller extends CI_Controller
{
    protected $result = [
        'status'   => null,
        'messages' => [],
        'result'   => [],
    ];
    protected $query;

    /**
     * コンストラクタ
     *
     * @param void
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model($this->router->directory.'Api_log_model');
        $this->Api_log_model->add('START');

        // システム情報
        $this->load->model('System_model');
        $system = $this->System_model->get_by_id(1);

        // IPチェック
        $api_ip = $system['api_ip'];
        if ($api_ip != $this->input->ip_address()) {
            // 許可されていないIP
            $this->Api_log_model->add('IP ERROR '.$this->input->ip_address());
            exit;
        }

        // POST取得
        //$this->query = json_decode($this->input->raw_input_stream, true);
        $this->query = $this->input->post();

        // APIキーチェック
        $api_key = $system['api_key'];
        if ($api_key != $this->query['api_key']) {
            // APIキー不一致
            $this->Api_log_model->add('API KEY ERROR '.$this->query['api_key']);
            exit;
        }
    }

    /**
     * 返却
     */
    protected function response($data = '')
    {
        $this->result['result'] = $data;

        $this->Api_log_model->add('END');

        // 結果出力
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($this->result, JSON_PRETTY_PRINT);
        exit;
    }

}

/*
 * 汎用関数
 */
/**
 * 整数に丸めた価格を得る
 *
 * @param integer $price
 * @param integer $rate
 * @param integer $type
 * @return integer
 */
function get_round_price($price, $rate, $type)
{
    switch ($type) {
        default:
        case TAX_ROUND_TYPE_FLOOR:
            // 切捨て
            $price = (int) floor($price * $rate / 100);
            break;
        case TAX_ROUND_TYPE_ROUND:
            // 四捨五入
            $price = (int) floor($price * $rate / 100 + 0.5);
            break;
        case TAX_ROUND_TYPE_CEIL:
            // 切り上げ
            $price = (int) ceil($price * $rate / 100);
            break;
    }
    return $price;
}

/**
 * 割引・割増した価格を得る
 * 100円単位に切り上げる
 *
 * @param type $price
 * @param type $sale_rate
 * @return type
 */
function get_sale_price($price, $sale_rate = 0)
{
    return ceil($price * (100 + $sale_rate) / 100 / 100) * 100;
}

/**
 * 整数に丸めた価格の率を得る
 *
 * @param integer $price
 * @param integer $rate
 * @param integer $type
 * @return integer
 */
function get_tax_from_intax($price, $rate, $type)
{
    switch ($type) {
        default:
        case TAX_ROUND_TYPE_FLOOR:
            // 切捨て
            $price = (int) floor($price / (1 + $rate / 100) * ($rate / 100));
            break;
        case TAX_ROUND_TYPE_ROUND:
            // 四捨五入
            $price = (int) floor($price / (1 + $rate / 100) * ($rate / 100) + 0.5);
            break;
        case TAX_ROUND_TYPE_CEIL:
            // 切り上げ
            $price = (int) ceil($price / (1 + $rate / 100) * ($rate / 100));
            break;
    }

    return $price;
}

/**
 * 多次元配列を1次元配列にする
 *
 * @param array $arr
 * @return array
 */
function array_flatten(array $arr)
{
    return iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($arr)), false);
}

/**
 * 3次元配列からキーが配列文字列の1次元連想配列を得る
 *
 * 多次元配列の値をset_valueの初期値にする場合に使用
 *
 * 例）
 * array(
 *     'items' => array(
 *         0 => array(
 *             'item' => 'test1',
 *             'qty' => '1',
 *         ),
 *         1 => array(
 *             'item' => 'test2',
 *             'qty' => '3',
 *         ),
 *     ),
 * );
 *
 * array(
 *     'items[0][item]' => 'test1',
 *     'items[0][qty]' => '1',
 *     'items[1][item]' => 'test2',
 *     'items[1][qty]' => '3',
 * );
 *
 * @param array
 * @return void
 */
function get_assoc_array($data)
{
    $result = array();
    foreach ($data as $name => $row) {
        foreach ($row as $num => $array) {
            foreach ($array as $key => $value) {
                $result["{$name}[{$num}][{$key}]"] = $value;
            }
        }
    }
    return $result;
}

/**
 * 2次元配列から値のない要素を削除する
 *
 * @param type $data
 * @return type
 */
function array_delete_empty($data)
{
    $result = [];
    foreach ($data as $item) {
        if (array_filter($item)) {
            $result[] = $item;
        }
    }
    return $result;
}

/**
 * array_column
 *
 * PHP5.5未満用の互換関数
 * 2次元配列のみ対応
 *
 * @param target_data 値を取り出したい多次元配列
 * @param column_key  値を返したいカラム
 * @param index_key   返す配列のインデックスとして使うカラム
 * @return array      入力配列の単一のカラムを表す値の配列
 */
if (!function_exists('array_column')) {
    function array_column($target_data, $column_key, $index_key = null)
    {
        if (is_array($target_data) === false || count($target_data) === 0) return false;

        $result = array();
        foreach ($target_data as $array) {
            if (array_key_exists($column_key, $array) === false) continue;
            if (is_null($index_key) === false && array_key_exists($index_key, $array) === true) {
                $result[$array[$index_key]] = $array[$column_key];
                continue;
            }
            $result[] = $array[$column_key];
        }

        if (count($result) === 0) return false;
        return $result;
    }

}
/**
 * html_escapeのラッパー
 *
 * @param type $var
 * @param type $double_encode
 */
function h($var, $double_encode = true)
{
    return html_escape($var, $double_encode);
}

/**
 * スペースなし全角文字に変換する
 *
 * @param string $str 文字列
 * @return string
 */
function to_nospace_zenkaku($str)
{
    // スペース削除、全角変換
    $converted_str = str_replace("　", "", mb_convert_kana($str, 'KVRNS'));

    // 結果取得
    return $converted_str;
}

/**
 * ハイフンなし半角に変換する
 *
 * @param string $str 文字列
 * @return string
 */
function to_nohyphen_hankaku($str)
{
    // ハイフン削除、半角変換
    $converted_str = str_replace(['-', 'ー', '‐', '‑', '–', '—', '―', '−', 'ｰ'], "", mb_convert_kana($str, 'as'));

    // 結果取得
    return $converted_str;
}

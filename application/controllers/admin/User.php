<?php
/**
 * 利用者
 *
 * @package    Admin
 * @subpackage Controller
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class User extends Admin_controller
{
    public $title  = '利用者';
    public $layout = 'loggedin';

    /**
     * コンストラクタ
     *
     * @param void
     */
    public function __construct()
    {
        parent::__construct();

        // メニュー番号
        $this->load->vars('menu_id', ADMIN_MENU_USER);

        // 管理者のみ
        if ($this->load->get_var('login_user')['admin_type_id'] != ADMIN_TYPE_ADMIN) {
            exit;
        }
    }

    /**
     * 一覧画面
     *
     * @param void
     */
    public function index()
    {
        // タイトル
        $this->title .= '一覧';

        // 戻るURL初期化
        $this->unset_back_url();
        // 戻るURLセット
        $this->set_back_url();

        // 一覧画面処理
        $this->general_index();
    }

    /**
     * 編集画面
     *
     * @param integer $id ID
     */
    public function edit($id = null)
    {
        // タイトル
        $this->title .= '編集';

        // 戻るURLセット
        $this->set_back_url();

        // 編集画面処理
        if (true !== $this->general_edit($id)) {
            return;
        }

        // 前画面にリダイレクト
        redirect($this->get_back_url());
    }

    protected function edit_hook_before_assign(&$data, &$validation_rules)
    {
        // 編集ならパスワードの必須削除
        if ($data) {
            $validation_rules['password']['rules'] = str_replace('required|', '', $validation_rules['password']['rules']);
        }
    }

    /**
     * 選択肢アサイン
     *
     * @param void
     * @return void
     */
    protected function set_options()
    {
        // 区分
        $this->load->model($this->router->directory.'User_type_model');
        $this->load->vars('user_type_options', $this->User_type_model->get_options());
    }

    /**
     * Excel出力
     *
     * @param void
     */
    public function export()
    {
        $this->layout = 'excel';

        $fields     = [];
        $conditions = [];
        $file_name  = "user_".date("Ymd-His").".xlsx";

        $this->general_export_excel($fields, $conditions, $file_name);
    }

    /**
     * Excel入力処理
     *
     * @param void
     */
    public function import()
    {
        // キー定義
        $fields = [
            'code', //社員番号
            'name', //氏名
            'user_type_id', //区分
            'password', //パスワード
            'deleted_flag', //削除フラグ
            'updated_at', //更新日時
        ];

        $this->load->model($this->router->directory.'User_model');

        // データ作成に必要な情報をセット
        $this->load->model($this->router->directory.'User_type_model');
        $params = [
            'fields'            => $fields,
            'user_type_options' => $this->User_type_model->get_options(),
        ];

        // バリデーションライブラリロード
        $this->load->library('form_validation');

        // インポート処理
        $this->general_import_excel($params, 1);

        // 前画面へリダイレクト
        redirect($this->get_back_url());
    }

    public function import_make_data(&$line, &$data, &$line_count, &$params)
    {
        $result_flag = true;
        $item        = null;

        // 行から連想配列を作成
        if (false === $item = array_combine($params['fields'], $line)) {
            // 項目数が一致しない
            $this->set_error($line_count.'行目：項目数が違います');
            return false;
        }
        // 区分をIDに変換
        $user_type_id = array_search($item['user_type_id'], $params['user_type_options']);
        // 利用者ID取得
        $user         = $this->User_model->get_by_code($item['code']);

        // バリデーション
        // Excel内で社員番号が重複
        if (isset($data[$item['code']])) {
            $this->set_error($line_count."行目：職番 {$item['code']} が重複しています");
            $result_flag = false;
        }
        // 区分が特定できない
        if (false === $user_type_id) {
            $this->set_error($line_count."行目：区分 {$item['user_type_id']} が見つかりません");
            $result_flag = false;
        }
        // 編集ならパスワードの必須削除
        $validation_rules = $this->get_validation_rules('user');
        if ($user['id']) {
            $validation_rules['password']['rules'] = str_replace('required|', '', $validation_rules['password']['rules']);
        }

        // 保存情報作成
        $item['id']           = $user['id'];
        $item['user_type_id'] = $user_type_id;
        unset($item['updated_at']);

        $this->form_validation->reset_validation();
        $this->form_validation->set_rules($validation_rules);
        $this->form_validation->set_data($item);
        if (false === $this->form_validation->run()) {
            // バリデーションエラー
            $this->set_error($this->form_validation->error_string($line_count.'行目：'));
            $result_flag = false;
        }

        if (empty($item['password'])) {
            // 未入力
            // 現在のパスワードをセット
            $item['password'] = $user['password'];
        } else {
            // 入力
            // 入力のパスワードのハッシュをセット
            $item['password'] = $this->User_model->get_hash($item['password']);
        }

        // 保存情報
        $data[$item['code']] = $item;

        return $result_flag;
    }

}

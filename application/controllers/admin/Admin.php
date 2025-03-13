<?php
/**
 * 管理者管理
 *
 * @package    Admin
 * @subpackage Controller
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class Admin extends Admin_controller
{
    public $title  = '管理者';
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
        $this->load->vars('menu_id', ADMIN_MENU_ADMIN);
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

        // 管理者のみ
        if ($this->load->get_var('login_user')['admin_type_id'] != ADMIN_TYPE_ADMIN) {
            exit;
        }

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

        // 管理者のみ
        if ($this->load->get_var('login_user')['admin_type_id'] != ADMIN_TYPE_ADMIN) {
            exit;
        }

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
        $this->load->model($this->router->directory.'Admin_type_model');
        $this->load->vars('admin_type_options', $this->Admin_type_model->get_options());
    }

    /**
     * パスワード変更
     *
     * @param void
     */
    public function password()
    {
        $this->title = 'パスワード変更';

        // メニュー番号
        $this->load->vars('menu_id', ADMIN_MENU_PASSWORD);

        // 戻るURL初期化
        $this->unset_back_url();
        // 戻るURLセット
        $this->set_back_url();

        // パスワード変更処理
        $this->general_change_password($this->auth->get());
    }

}

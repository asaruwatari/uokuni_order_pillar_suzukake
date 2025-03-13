<?php
/**
 * システムページ
 *
 * @package    Admin
 * @subpackage Controller
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class System extends Admin_controller
{
    public $title  = "システム";
    public $layout = 'loggedin';

    /**
     * コンストラクタ
     *
     * @param void
     */
    public function __construct()
    {
        parent::__construct();

        // 管理者のみ
        if ($this->load->get_var('login_user')['admin_type_id'] != ADMIN_TYPE_ADMIN) {
            exit;
        }
    }

    /**
     * 編集画面
     *
     * @param integer $id ID
     */
    public function index()
    {
        $this->title .= '設定編集';

        // メニュー番号
        $this->load->vars('menu_id', ADMIN_MENU_SYSTEM);

        // 戻るURL初期化
        $this->unset_back_url();
        // 戻るURLセット
        $this->set_back_url();

        // 編集画面処理
        if (true !== $this->general_edit(1)) {
            return;
        }

        // 前画面にリダイレクト
        redirect($this->get_back_url());
    }

    public function index_hook_before_validation(&$data, &$validation_rules, &$post)
    {
        // 締め切り時間に秒を追加
        if ($post['deadline_hour']) {
            $post['deadline_hour'] = date('H:i:00', strtotime($post['deadline_hour']));
        }
    }

    /**
     * システム情報
     *
     * @param void
     */
    public function info()
    {
        // タイトル
        $this->title .= '情報';

        // メニュー番号
        $this->load->vars('menu_id', ADMIN_MENU_SYSTEM_INFO);

        // 戻るURL初期化
        $this->unset_back_url();
        // 戻るURLセット
        $this->set_back_url();

        // MySQL変数アサイン
        $this->load->vars('db_variables', array_column($this->db->query("SHOW VARIABLES")->result_array(), null, 'Variable_name'));
    }

}

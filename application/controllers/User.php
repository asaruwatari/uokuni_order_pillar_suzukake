<?php
/**
 * 利用者
 *
 * @package    Default
 * @subpackage Controller
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class User extends Default_controller
{
    public $title  = '利用者';
    public $layout = 'loggedin';

    /**
     * 登録情報
     *
     * @param void
     */
    public function index()
    {
        // タイトル
        $this->title = '登録情報';

        // ユーザー情報
        $login_user = $this->load->get_var('login_user');

        // 戻るURL初期化
        $this->unset_back_url();
        // 戻るURLセット
        $this->set_back_url();

        // 編集画面処理
        if (true !== $this->general_edit($login_user['id'])) {
            return;
        }

        // 前画面にリダイレクト
        redirect($this->get_back_url());
    }

    protected function index_hook_before_assign(&$data, &$validation_rules)
    {
        // バリデーションを配達先だけにする
        $validation_rules = [
            'id'          => $validation_rules['id'],
            'delivery_id' => $validation_rules['delivery_id'],
        ];
    }

    /**
     * パスワード変更画面
     *
     * @param void
     */
    public function password()
    {
        // タイトル
        $this->title = 'パスワード変更';

        // 戻るURL初期化
        $this->unset_back_url();
        // 戻るURLセット
        $this->set_back_url();

        // ユーザー情報
        $login_user = $this->load->get_var('login_user');

        // パスワード変更処理
        if (true !== $this->general_change_password($login_user['id'])) {
            return;
        }

        // 初めての変更（＝強制変更）なら注文画面へ
        redirect($this->router->directory.'order');
    }

}

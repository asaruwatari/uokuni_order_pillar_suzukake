<?php
/**
 * 管理トップページ
 *
 * @package    Admin
 * @subpackage Controller
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class Top extends Admin_controller
{
    public $title  = "管理サイト";
    public $layout = 'default';

    /**
     * ログインページ
     *
     * @param void
     */
    public function index()
    {
        // ログイン済みならdashboardへ
        if (true === $this->auth->is_login()) {
            redirect(base_url($this->router->directory.'order'));
        }

        // 編集画面から戻るURL初期化
        $this->unset_back_url();

        // タイトル設定
        $this->title = SYSTEM_NAME.' '.$this->title;

        // POST確認
        if (!$this->input->post()) {
            return;
        }

        $data = [];

        // バリデート設定
        $this->load->library('form_validation');
        $fields = [
            [
                'field' => 'code',
                'label' => 'ログインID',
                'rules' => 'required'
            ],
            [
                'field' => 'password',
                'label' => 'パスワード',
                'rules' => 'required'
            ],
        ];
        $this->form_validation->set_rules($fields);

        // POST＆バリデート
        if (false === $this->form_validation->run()) {
            return;
        }

        // IDとパスワードが一致するレコードを確認
        $this->load->model($this->router->directory.'Admin_model');
        $code     = $this->input->post('code');
        $password = $this->input->post('password');
        $user     = $this->Admin_model->auth($code, $password);
        if (!$user) {
            // 見つからない
            $this->set_error('アカウントが存在しないかログインID・パスワードが違います');
            return;
        }

        // ログイン
        $this->auth->set($user['id']);

        // リダイレクト
        redirect(base_url($this->router->directory.'order'));
    }

    /**
     * ログアウト
     *
     * @param void
     */
    public function logout()
    {
        $this->auth->clear();
        redirect(base_url($this->router->directory));
    }

}

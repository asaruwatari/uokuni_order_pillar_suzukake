<?php
/**
 * 管理者モデル
 *
 * @package	   Admin
 * @subpackage Model
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class Admin_model extends MY_Model
{
    /**
     * 一覧クエリ設定(オーバーライド)
     *
     * @param void
     * @return void
     */
    protected function set_list_query()
    {
        $this->db
            ->select("`{$this->table}`.*, admin_type.name AS `admin_type.name`", false)
            ->from($this->table)
            ->join("admin_type", "admin_type.id = admin_type_id", "left")
            ->order_by("admin.deleted_flag")
            ->order_by("admin_type.order")
            ->order_by("admin_type.id")
            ->order_by("{$this->table}.id");
    }

    /**
     * 編集用データ取得(オーバーライド)
     *
     * @param array $conditions 条件
     * @return array
     */
    public function get_edit_data($conditions)
    {
        $data = parent::get_edit_data($conditions);

        // パスワードを削除
        $data['password'] = '';
        return $data;
    }

    /**
     * 認証
     *
     * IDとパスワードが一致するレコードを確認
     *
     * @param integer $username ログインID
     * @param integer $password パスワード
     */
    public function auth($username, $password)
    {
        // パスワードをハッシュ化する
        $password = $this->get_hash($password);

        $this->db
            ->from($this->table)
            ->where('code', $username)
            ->where('password', $password)
            ->where('deleted_flag', 0);
        return $this->db->get()->row_array();
    }

    /**
     * 保存（オーバーライド）
     *
     * パスワードハッシュ処理を追加
     *
     * @param mixed $id 主キー
     * @param array $data 保存情報
     * @return bool
     *
     * @see MY_Model::set()
     */
    public function set($id, $data)
    {
        // パスワードハッシュ化
        if (!empty($data['password'])) {
            // パスワードが存在していればハッシュ化
            $data['password'] = $this->get_hash($data['password']);
        } else {
            // 入力なければ無変更
            unset($data['password']);
        }
        return parent::set($id, $data);
    }

    /**
     * idをキー、name値とする配列を得る（オーバーライド）
     *
     * @param void
     * @return array
     */
    public function get_options()
    {
        $this->db
            ->select('id, name')
            ->from($this->table)
            ->where('deleted_flag', 0)
            ->order_by("id");
        $results = $this->db->get()->result_array();
        return $this->get_option($results);
    }

}

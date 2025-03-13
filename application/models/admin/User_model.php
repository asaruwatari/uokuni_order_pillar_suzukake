<?php
/**
 * 利用者モデル
 *
 * @package	   Admin
 * @subpackage Model
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class User_model extends MY_Model
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
            ->select("`{$this->table}`.*, user_type.name AS `user_type.name`", false)
            ->from($this->table)
            ->join("user_type", "user_type.id = user_type_id", "left")
            ->order_by("user.deleted_flag")
            ->order_by("user.code")
            //->order_by("user_type.order")
            //->order_by("user_type.id")
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
     * 絞込設定
     *
     * @param	void
     * @return	void
     */
    protected function set_conditions($conditions)
    {
        // 社員番号
        if (isset($conditions['user_type_id']) && strlen($conditions['user_type_id'])) {
            $this->db->where("{$this->table}.user_type_id", $conditions['user_type_id']);
        }
        // 社員番号
        if (isset($conditions['code']) && strlen($conditions['code'])) {
            $this->db->where("{$this->table}.code", $conditions['code']);
        }
        // 氏名
        if (isset($conditions['name']) && strlen($conditions['name'])) {
            $this->db->like("{$this->table}.name", $conditions['name']);
        }
        // 無効
        if (isset($conditions['deleted_flag']) && strlen($conditions['deleted_flag'])) {
            $this->db->where("{$this->table}.deleted_flag", $conditions['deleted_flag']);
        }
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
     * 職番で取得
     *
     * @param string $code 職番
     * @return array
     */
    public function get_by_code($code)
    {
        $this->db
            ->select("{$this->table}.*")
            ->from($this->table)
            ->where("{$this->table}.code", $code);

        // 情報取得
        return $this->db->get()->row_array();
    }

    /**
     * インポート
     *
     * @param array $datas 保存情報
     * @return bool
     */
    public function import($datas)
    {
        // トランザクション開始
        $this->db->trans_start();

        // ループ
        foreach ($datas as $data) {

            // 社員番号なし＝新規追加（パスワード＝社員番号）
            // 社員番号あり＝更新
            if ($user = $this->db->get_where($this->table, ['code' => $data['code']])->row_array()) {
                // 更新
                $this->db->update($this->table, $data, ['id' => $user['id']]);
            } else {
                // 新規追加
                $this->db->insert($this->table, $data);
            }
        }

        // トランザクション終了
        return $this->db->trans_complete();
    }

}

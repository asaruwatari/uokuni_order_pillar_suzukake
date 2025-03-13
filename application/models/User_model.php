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
     * 認証
     *
     * IDとパスワードが一致するレコードを確認
     *
     * @param int $username ログインID
     * @param int $password パスワード
     */
    public function auth($username, $password)
    {
        // パスワードをハッシュ化する
        $this->db
            ->from($this->table)
            ->where('code', $username)
            ->where('password', $this->get_hash($password))
            ->where('deleted_flag', 0);
        return $this->db->get()->row_array();
    }

    /**
     * 社員番号から得る
     *
     * @param string $code
     * @return array
     */
    public function get_by_code($code)
    {
        // パスワードをハッシュ化する
        $this->db
            ->select("{$this->table}.*"
                .", company.name AS `company.name`,"
                , false)
            ->from($this->table)
            ->join("company", "company.id = {$this->table}.company_id", "left")
            ->where("{$this->table}.code", $code)
            ->where("{$this->table}.deleted_flag", 0);
        return $this->db->get()->row_array();
    }

    /**
     * IDから得る
     *
     * @param int $id
     * @return array
     */
    public function get($id)
    {
        // パスワードをハッシュ化する
        $this->db
            ->select("{$this->table}.*"
                .", company.name AS `company.name`,"
                , false)
            ->from($this->table)
            ->join("company", "company.id = {$this->table}.company_id", "left")
            ->where("{$this->table}.id", $id)
            ->where("{$this->table}.deleted_flag", 0);
        return $this->db->get()->row_array();
    }

    /**
     * データを保存する（オーバーライド）
     *
     * @param mixed $pk 主キー
     * @param array $data 保存情報
     * @return bool
     */
    public function set($pk, $data)
    {
        // パスワードハッシュ化
        if (!empty($data['password'])) {
            // パスワードが存在していればハッシュ化
            $data['password'] = $this->get_hash($data['password']);
        } else {
            // 入力なければ無変更
            unset($data['password']);
        }
        // 保存処理
        return parent::set($pk, $data);
    }

}

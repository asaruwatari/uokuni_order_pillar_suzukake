<?php
/**
 * 基底バリデータ
 *
 * @author ASaruwatari
 *
 * バリデーションを追加した場合は
 * /language/form_validation_lang.php
 * にエラーメッセージを追加する事
 *
 */
class MY_Form_validation extends CI_Form_validation
{
    /**
     * コンストラクタ
     */
    public function __construct($rules = array())
    {
        parent::__construct($rules);
    }

    /**
     * エラーメッセージを設定
     *
     * @param string $field
     * @param string $error
     */
    public function set_error($field, $error)
    {
        // エラーの有無判定用？
        $this->_error_array[$field] = $error;

        // 表示用？
        $this->_field_data[$field]['error'] = $error;
    }

    /**
     * postdataを書き換える
     *
     * @param string $field
     * @param string $value
     */
    public function set_postdata($field, $value)
    {
        $this->_field_data[$field]['postdata'] = $value;
    }

    /**
     * postdataを削除する
     *
     * @param string $field
     */
    public function unset_postdata($field)
    {
        unset($this->_field_data[$field]['postdata']);
    }

    /**
     * is_unique オーバーライド
     *
     * @param type $str
     * @param type $field
     * @return bool
     */
    public function is_unique($str, $field)
    {
        if (!is_object($this->CI->db)) {
            return false;
        }
        $table = '';

        // テーブル名とフィールド名に分ける
        sscanf($field, '%[^.].%[^.]', $table, $field);

        $this->CI->db
            ->select("id")
            ->from($table)
            ->where($field, $str);
        // POSTにidがあるか
        if (!empty($this->validation_data['id'])) {
            // 更新なら自分以外
            $this->CI->db->where('id !=', $this->validation_data['id']);
        }
        return $this->CI->db->get()->num_rows() === 0;
    }

    /**
     * 日付チェック
     *
     * @param string $str
     */
    public function date($str)
    {
        if ($str == '') {
            return TRUE;
        }
        return (!preg_match("/^\d{4}\-\d{2}\-\d{2}$/", $str)) ? FALSE : TRUE;
    }

    /**
     * 日付時間チェック
     *
     * @param string $str
     */
    public function datetime($str)
    {
        if (!preg_match("/^\d{4}\-\d{2}\-\d{2} \d{2}:\d{2}:\d{2}$/", $str)) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 時間チェック
     *
     * @param string $str
     */
    public function time($str)
    {
        if (!preg_match("/^\d{2}:\d{2}:\d{2}$/", $str)) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 全角かなチェック
     *
     * @param string $str
     */
    public function hiragana($str)
    {
        return (bool) !strlen($str) || preg_match("/^[ぁ-ん　]+$/u", $str);
    }

    /**
     * 全角カナチェック
     *
     * @param string $str
     */
    public function katakana($str)
    {
        return (bool) !strlen($str) || preg_match("/^[ァ-ヶー　]+$/u", $str);
    }

    /**
     * パスワード

     * 半角英文字,数字を含む8文字以上32文字以下
     *
     * @param string $str
     */
    public function password($str)
    {
        //return (bool) !strlen($str) || preg_match("/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/", $str);
        return (bool) !strlen($str) || preg_match("/\A(?=\d{0,99}+[a-z])(?=[a-z]{0,99}+\d)[a-z\d]{8,32}+\z/i", $str);
    }

    /**
     * 郵便番号
     *
     * @param string $str
     */
    public function zip($str)
    {
        return (bool) !strlen($str) || preg_match("/^\d{3}-\d{4}$/", $str);
    }

    /**
     * 電話番号
     *
     * @param string $str
     */
    public function tel($str)
    {
        return (bool) !strlen($str) || preg_match("/^0\d{1,4}-\d{1,4}-\d{1,4}$/", $str);
    }

}

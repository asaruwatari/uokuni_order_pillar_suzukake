<?php
/**
 * 拡張メールライブラリ
 *
 * @author ASaruwatari
 */
class MY_Email extends CI_Email
{
    /**
     * コンストラクタ
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    /**
     * メールアドレスのハッシュを得る
     *
     * @access protected
     * @param  string メールアドレス
     * @return string ハッシュ文字列
     */
    public function get_mail_key($string)
    {
        return md5($string.'a0kl39ss');
    }

    /**
     * 暗号化したメールアドレスを得る
     *
     * @access protected
     * @param  string メールアドレス
     * @return string 暗号化文字列
     */
    public function get_angou($string)
    {
        return openssl_encrypt($string, 'AES-128-ECB', 'skgnw490y34qejaf');
    }

    /**
     * 複合化したメールアドレスを得る
     *
     * @access protected
     * @param  string メールアドレス
     * @return string 複合化文字列
     */
    public function get_hukugou($string)
    {
        return openssl_decrypt($string, 'AES-128-ECB', 'skgnw490y34qejaf');
    }

    /**
     * 置き換え
     *
     * @param array $field
     * @param string $text
     * @return string
     */
    public function replace($field, $text)
    {
        return @str_replace(array_map([$this, 'tag'], array_keys($field)), array_values($field), $text);
    }

    /**
     * 置き換えタグ
     *
     * @param unknown_type $value
     * @return unknown
     */
    public function tag($value)
    {
        return '{'.$value.'}';
    }

}

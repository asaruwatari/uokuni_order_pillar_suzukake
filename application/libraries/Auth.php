<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 認証ライブラリ
 *
 * @package Library
 * @subpackage Library
 * @category
 * @author Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class Auth
{
    /**
     * ユーザID
     *
     * @var type
     */
    public $id;

    /**
     * コンストラクタ
     *
     * @param array $params
     */
    public function __construct($params = array())
    {
        $name = @$params['name'] ?: 'default';

        // セッション初期化
        if (!isset($_SESSION['auth'][$name])) {
            $_SESSION['auth'][$name] = null;
        }

        // プロパティとセッションを参照渡しで接続
        $this->id = &$_SESSION['auth'][$name];
    }

    /**
     * ユーザIDをセット
     *
     * @param $id ユーザID
     * @return boolean
     */
    public function set($id)
    {
        $this->id = $id;
        return true;
    }

    /**
     * ユーザIDを得る
     *
     * @param void
     * @return array
     */
    public function get()
    {
        return $this->id;
    }

    /**
     * ユーザIDを削除
     *
     * @param void
     * @return void
     */
    public function clear()
    {
        $this->id = null;
    }

    /**
     * ログイン中か確認
     *
     * @param void
     * @return boolean
     */
    public function is_login()
    {
        return (bool) $this->id;
    }

}

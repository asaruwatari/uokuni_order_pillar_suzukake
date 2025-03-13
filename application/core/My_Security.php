<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Security Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Security
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/userguide3/libraries/security.html
 */
class MY_Security extends CI_Security
{
    // --------------------------------------------------------------------
    /**
     * CSRF Set Cookie
     *
     * @codeCoverageIgnore
     * @return	CI_Security
     */
    public function csrf_set_cookie()
    {
        //$expire        = time() + $this->_csrf_expire;
        $expire        = 0;
        $secure_cookie = (bool) config_item('cookie_secure');

        if ($secure_cookie && !is_https()) {
            return FALSE;
        }

        //PHP7.2対応
        setcookie($this->_csrf_cookie_name, $this->_csrf_hash, $expire, config_item('cookie_path'), config_item('cookie_domain'), $secure_cookie, config_item('cookie_httponly'));


        log_message('info', 'CSRF cookie sent');

        return $this;
    }

}

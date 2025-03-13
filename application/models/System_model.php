<?php
/**
 * 利用者モデル
 *
 * @package	   Default
 * @subpackage Model
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class System_model extends MY_Model
{
    /**
     * 設定を得る
     *
     * @param void
     * @return array
     */
    public function get()
    {
        $this->db
            ->select("{$this->table}.*"
                , false)
            ->from($this->table)
            ->where("{$this->table}.id", 1);
        return $this->db->get()->row_array();
    }

}

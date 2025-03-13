<?php
/**
 * メニュー区分モデル
 *
 * @package    Admin
 * @subpackage Model
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class Item_type_model extends MY_Model
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
            ->select("`{$this->table}`.*, "
                ."item_time.name AS `item_time.name`", false)
            ->from($this->table)
            ->join("item_time", "item_time.id = {$this->table}.item_time_id", "left")
            ->order_by("{$this->table}.id");
    }

    /**
     *
     *
     * @param void
     * @return array
     */
    public function gets()
    {
        $this->db
            ->select("{$this->table}.*"
                .",item_time.name AS `item_time.name`"
                , false)
            ->from($this->table)
            ->join("item_time", "item_time.id = {$this->table}.item_time_id")
            ->where("{$this->table}.deleted_flag", 0)
            ->order_by("{$this->table}.order")
            ->order_by("{$this->table}.id");
        return $this->db->get()->result_array();
    }

}

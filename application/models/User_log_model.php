<?php
/**
 * 利用者履歴モデル
 *
 * @package    Admin
 * @subpackage Model
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class User_log_model extends MY_Model
{
    /**
     * 追加
     *
     * @param void
     * @return void
     */
    public function add($user_id, $text)
    {
        $data['id']      = null;
        $data['user_id'] = $user_id;
        $data['text']    = $text;
        $data['ip']      = $this->input->ip_address();
        $data['ua']      = $this->input->user_agent();
        $this->db->insert($this->table, $data);
        return;
    }

    /**
     * 注文追加
     *
     * @param void
     * @return void
     */
    public function add_order($user_id, $text, $datas = [])
    {
        // トランザクション開始
        $this->db->trans_start();

        foreach ($datas as $data) {
            $data['id']      = null;
            $data['user_id'] = $user_id;
            $data['text']    = $text;
            $data['ip']      = $this->input->ip_address();
            $data['ua']      = $this->input->user_agent();
            $this->db->insert($this->table, $data);
        }

        // トランザクション終了
        return $this->db->trans_complete();
    }

    /**
     * 一覧
     *
     * @param $user_id
     * @return void
     */
    public function gets($user_id)
    {
        $this->db
            ->select("created_at")
            ->from($this->table)
            ->where("user_id", $user_id)
            ->where("created_at > (NOW() - INTERVAL ".ORDER_LOG_DAY." DAY)", false, false)
            ->group_by("created_at")
            ->order_by("created_at DESC");
        $list = $this->db->get()->result_array();

        $date = [];
        foreach ($list as &$date) {
            $this->db
                ->select("{$this->table}.*, "
                    ."user.code AS `user.code`, "
                    ."user.name AS `user.name`, "
                    ."item.name AS `item.name`, "
                    ."item_type.name AS `item_type.name`, "
                    ."delivery.name AS `delivery.name`, "
                    , false)
                ->from($this->table)
                ->join("user", "user.id = {$this->table}.user_id", "left")
                ->join("item", "item.id = {$this->table}.item_id", "left")
                ->join("item_type", "item_type.id = item.item_type_id", "left")
                ->join("delivery", "delivery.id = {$this->table}.delivery_id", "left")
                ->where("user_id", $user_id)
                ->where("{$this->table}.created_at", $date['created_at'])
                ->order_by("{$this->table}.id");
            $date['orders'] = $this->db->get()->result_array();
        }
        return $list;
    }

}

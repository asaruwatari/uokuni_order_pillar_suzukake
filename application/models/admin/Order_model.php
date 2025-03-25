<?php
/**
 * 注文履歴モデル
 *
 * @package    Admin
 * @subpackage Model
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class Order_model extends MY_Model
{
    /**
     * 指定日から指定数の注文を得る
     *
     * @param date $date
     * @param int $day
     * @return array
     */
    public function list_by_date($date, $day)
    {
        // 開始日
        $start_date = date('Y-m-d', strtotime("{$date}"));
        // 終了日
        $day--;
        $end_date   = date('Y-m-d', strtotime("{$date} +{$day} day"));
        // 日付配列取得
        $datas      = array_column($this->get_dates($start_date, $end_date), null, 'date');

        // 日付毎のメニューと注文数を得る
        foreach ($datas as &$data) {
            $data['items'] = array_column($this->gets_by_date_total($data['date']), null, 'item_type_id');
        }

        return $datas;
    }

    /**
     * 指定日の注文集計を得る
     *
     * @param date $date
     * @param int $day
     * @return array
     */
    public function gets_by_date_total($date)
    {
        $this->db
            ->select("item.*, "
                . "item_time.name AS `item_time.name`, "
                . "item_type.name AS `item_type.name`, "
                . "(SELECT COUNT(id) FROM `order` WHERE `order`.item_id = item.id AND `order`.canceled_flag = 0) AS `order_qty`, "
                , false)
            ->from("item")
            ->join("item_type", "item_type.id = item.item_type_id", "left")
            ->join("item_time", "item_time.id = item_type.item_time_id", "left")
            ->where("item.date", $date)
            ->order_by("item_type.order")
            ->order_by("item_type.id")
            ->order_by("item_type.order")
            ->order_by("item_type.id");

        // 結果取得
        return $this->db->get()->result_array();
    }

    /**
     * 指定日の注文を得る
     *
     * @param date $date
     * @param int $day
     * @return array
     */
    public function gets_by_date($date)
    {
        $this->db
            ->select("`$this->table`.*,"
                . "user.code AS `user.code`,"
                . "user.name AS `user.name`,"
                . "item.name AS `item.name`,"
                . "item_type.name AS `item_type.name`,"
                . "item_time.name AS `item_time.name`,"
                , false)
            ->from($this->table)
            ->join("user", "user.id = `{$this->table}`.user_id", "left")
            ->join("item", "item.id = `{$this->table}`.item_id", "left")
            ->join("item_type", "item_type.id = item.item_type_id", "left")
            ->join("item_time", "item_time.id = item_type.item_time_id", "left")
            ->where("item.date", $date)
            ->order_by("item_time.order")
            ->order_by("user.code");

        // 結果取得
        return $this->db->get()->result_array();
    }

    /**
     * 指定範囲の注文集計を得る
     * キャンセルは除外
     *
     * @param type $from_date
     * @param type $to_date
     * @param int $company_id
     * @return array
     */
    public function get_total($from_date, $to_date)
    {
        $this->load->model($this->router->directory . 'Item_type_model');
        $item_types = $this->Item_type_model->gets();
        $select     = '';
        foreach ($item_types as $item_type) {
            $select .= "COUNT(CASE WHEN item_type.id = {$item_type['id']} THEN 1 END) AS `qty_{$item_type['id']}`,";
        }

        $this->db
            ->select("user.code AS `user.code`,"
                . "user.name AS `user.name`,"
                . "user_type.name AS `user_type.name`,"
                . $select
                , false)
            ->from($this->table)
            ->join("user", "user.id = `{$this->table}`.user_id", "left")
            ->join("user_type", "user_type.id = user.user_type_id", "left")
            ->join("item", "item.id = `{$this->table}`.item_id", "left")
            ->join("item_type", "item_type.id = item.item_type_id", "left")
            ->where("`order`.canceled_flag", 0)
            ->where("item.date >=", $from_date)
            ->where("item.date <=", $to_date)
            ->group_by("user.id")
            ->order_by("user.code");

        // 結果取得
        return $this->db->get()->result_array();
    }

    /**
     * 指定範囲の注文明細を得る
     * キャンセルは除外
     *
     * @param type $from_date
     * @param type $to_date
     * @param int $company_id
     * @return array
     */
    public function get_detail($from_date, $to_date, $company_id)
    {
        $this->db
            ->select("`{$this->table}`.created_at,"
                . "user.code AS `user.code`,"
                . "user.name AS `user.name`,"
                . "company.name AS `company.name`,"
                . "item.date as `item.date`,"
                . "item.name as `item.name`,"
                . "item.price as `item.price`,"
                . "item_type.name as `item_type.name`,"
                , false)
            ->from($this->table)
            ->join("user", "user.id = `{$this->table}`.user_id", "left")
            ->join("company", "company.id = user.company_id", "left")
            ->join("item", "item.id = `{$this->table}`.item_id", "left")
            ->join("item_type", "item_type.id = item.item_type_id", "left")
            ->where("`order`.canceled_flag", 0)
            ->where("item.date >=", $from_date)
            ->where("item.date <=", $to_date)
            ->order_by("item.date")
            ->order_by("item.item_type_id")
            ->order_by("company.order")
            ->order_by("user.code");

        // 会社条件あればセット
        if ($company_id) {
            $this->db->where('company_id', $company_id);
        }

        // 結果取得
        return $this->db->get()->result_array();
    }
}

<?php
/**
 * 受注モデル
 *
 * @package    Default
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
     * @param int $user_id
     * @return array
     */
    public function list_by_date($date, $day, $user_id)
    {
        // 開始日
        $start_date = date('Y-m-d', strtotime("{$date}"));
        // 終了日
        $day--;
        $end_date   = date('Y-m-d', strtotime("{$date} +{$day} day"));
        // 日付配列取得
        $datas      = array_column($this->get_dates($start_date, $end_date), null, 'date');

        // 献立時間取得
        $this->load->model('Item_time_model');
        $item_time_options = $this->Item_time_model->get_options();

        // 日付毎のメニューを得る
        foreach ($datas as &$data) {
            // 献立時間（昼・夜勤）ごとの献立と注文を得る
            foreach ($item_time_options as $item_time_id => $item_time_name) {
                $this->db
                    ->select("item.*,"
                        ."item_type.name AS `item_type.name`, "
                        ."item_time.name AS `item_time.name`, "
                        , false)
                    ->from("item")
                    ->join("item_type", "item_type.id = item.item_type_id", "left")
                    ->join("item_time", "item_time.id = item_type.item_time_id", "left")
                    ->where("item.date", $data['date'])
                    ->where("item.name <>", '')
                    ->where("item_type.item_time_id", $item_time_id)
                    ->order_by("item_type.order")
                    ->order_by("item_type.id");
                $data['times'][$item_time_id]['items'] = array_column($this->db->get()->result_array(), null, 'id');

                // 注文を得る
                $this->db
                    ->select("`order`.*"
                        , false)
                    ->from("order")
                    ->join("item", "item.id = `order`.item_id", "left")
                    ->join("item_type", "item_type.id = item.item_type_id", "left")
                    ->where("`order`.user_id", $user_id)
                    ->where("`order`.date", $data['date'])
                    ->where("item_type.item_time_id", $item_time_id);
                $data['times'][$item_time_id]['order'] = $this->db->get()->row_array();
            }
        }

        return $datas;
    }

    /**
     * 日毎の注文を保存する
     *
     * @param array $datas
     * @return bool
     */
    public function sets($datas)
    {
        // トランザクション開始
        $this->db->trans_start();

        // 注文情報の他の情報（キャンセルや備考）を維持するためループし存在確認し更新か挿入
        foreach ($datas as $data) {

            $data['ip'] = $this->input->ip_address();
            $data['ua'] = $this->input->user_agent();

            if ($data['id']) {
                // 既存注文あり
                // 注文有無で処理
                if ($data['item_id']) {
                    // 献立あり
                    // 注文を更新
                    $this->db->update($this->table, $data, ['id' => $data['id']]);
                } else {
                    // 献立なし（不要）
                    // 注文を削除
                    $this->db->delete($this->table, ['id' => $data['id']]);
                }
            } else {

                // 既存注文なし
                if ($data['item_id']) {
                    // 注文あり
                    // 注文を挿入
                    $this->db->insert($this->table, $data);
                }
            }
        }
        return $this->db->trans_complete();
    }

}

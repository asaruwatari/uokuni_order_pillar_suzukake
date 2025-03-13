<?php
/**
 * メニューモデル
 *
 * @package    Admin
 * @subpackage Model
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class Item_model extends MY_Model
{
    /**
     * 1月分のメニューを得る
     *
     * @param type $month
     */
    public function gets($year, $month)
    {
        // 開始日(1日)
        $start_date = date('Y-m-d', strtotime("{$year}-{$month}-01"));
        // 終了日(末日)
        $end_date   = date('Y-m-t', strtotime("{$year}-{$month}-01"));

        // 日付配列取得
        $datas = array_column($this->get_dates($start_date, $end_date), null, 'date');

        // 日付毎のメニューを得る
        foreach ($datas as &$data) {
            $this->db
                ->select("item.*, "
                    , false)
                ->from("item")
                ->where("date", $data['date'])
                ->order_by("item.item_type_id");
            $data['items'] = array_column($this->db->get()->result_array(), null, 'item_type_id');
        }

        // 結果取得
        return $datas;
    }

    /**
     * 1月分のメニューを保存する
     *
     * @param date $date
     * @param array $data
     */
    public function sets($datas)
    {
        // トランザクション開始
        $this->db->trans_start();

        // 商品ループ
        foreach ($datas as &$data) {
            // 商品区分ループ
            foreach ($data as &$item) {
                // 名称空白削除
                $item['name'] = trim($item['name']);
                // IDを維持するためID有無で挿入か更新を行う
                if (!$item['id']) {
                    // 挿入
                    $this->db->insert($this->table, $item);
                } else {
                    // 更新
                    $this->db->update($this->table, $item, ['id' => $item['id']]);
                }
            }
        }

        // トランザクション完了
        $this->db->trans_complete();

        // 結果返却
        return $this->db->trans_status();
    }

    /**
     * 日のメニューの選択肢を得る
     *
     * @param date $date
     * @return array
     */
    public function get_date_options($id)
    {
        $this->db
            ->select('id, name')
            ->from($this->table)
            ->where("date", "(SELECT date FROM item WHERE id={$id})", false)
            ->where("name <>", "")
            ->order_by("id");
        $results = $this->db->get()->result_array();
        return $this->get_option($results);
    }

    /**
     * インポート
     *
     * @param array $datas 保存情報
     * @return bool
     */
    public function import($datas)
    {
        // トランザクション開始
        $this->db->trans_start();

        // ループ
        foreach ($datas as $data) {

            // 日付とメニュー区分なし＝新規追加（パスワード＝社員番号）
            // 日付とメニュー区分あり＝更新
            if ($item = $this->db->get_where($this->table, ['date' => $data['date'], 'item_type_id' => $data['item_type_id']])->row_array()) {
                // 更新
                $this->db->update($this->table, $data, ['id' => $item['id']]);
            } else {
                // 新規追加
                $this->db->insert($this->table, $data);
            }
        }

        // トランザクション終了
        return $this->db->trans_complete();
    }

}

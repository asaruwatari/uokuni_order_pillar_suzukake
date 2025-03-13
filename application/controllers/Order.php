<?php
/**
 * 注文画面
 *
 * @package    Default
 * @subpackage Controller
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class Order extends Default_controller
{
    public $title  = '注文';
    public $layout = 'loggedin';

    /**
     * 注文画面
     *
     * @param void
     */
    public function index()
    {
        // タイトル
        $this->title .= '一覧';

        // ユーザー情報
        $login_user = $this->load->get_var('login_user');

        // 戻るURL初期化
        $this->unset_back_url();
        // 戻るURLセット
        $this->set_back_url();

        // 引数なければ今日
        $date     = $this->input->get('date') ?: date('Y-m-d');
        $tempDate = explode('-', $date);
        if (false === checkdate(@$tempDate[1], @$tempDate[2], @$tempDate[0])) {
            exit;
        }
        $this->load->vars('date', $date);

        // 一覧日数
        $day      = ORDER_VIEW_DAY;
        // 表示範囲日数
        $max_day  = ORDER_VIEW_MAX_DAY;
        $last_day = ORDER_VIEW_LAST_DAY;

        // 表示可能日付範囲外チェック

        if ($date < date('Y-m-d', strtotime("-{$last_day} day")) ||
            $date > date('Y-m-d', strtotime("+".($max_day - $day)." day"))) {
            // 範囲外
            exit;
        }

        // 前月・次月リンク用パラメータ
        $this->load->vars('prev', $date > date('Y-m-d', strtotime("-{$last_day} day")) ? '/?date='.date('Y-m-d', strtotime("$date -{$day} day")) : '');
        $this->load->vars('next', $date < date('Y-m-d', strtotime("+".($max_day - $day)." day")) ? '/?date='.date('Y-m-d', strtotime("$date +{$day} day")) : '');

        // 日付ごとの商品と注文情報取得
        $this->load->model($this->router->directory.'Order_model');
        $dates = $this->Order_model->list_by_date($date, $day, $login_user['id']);
        $this->load->vars('dates', $dates);

        // 提供時間
        $this->load->model($this->router->directory.'Item_time_model');
        $this->load->vars('item_time_options', $this->Item_time_model->get_options());

        // システム設定
        $this->load->model($this->router->directory.'System_model');
        $system = $this->System_model->get_by_id(1);
        $this->load->vars('system', $system);

        // POST確認
        if (!$post = $this->input->post()) {
            // POSTしていない
            return;
        }

        // バリデーション
        $this->load->library('form_validation');

        $error_flag = false;
        $datas      = [];
        foreach ($post['orders'] as $item_date => $orders) {

            // 商品ループ（2商品）
            foreach ($orders as $item_time_id => $order) {

                // 保存データ作成
                // 一度注文したメニューを不要にする必要があるためIDが無くてもデータ作成する
                $data = [
                    'id'      => $order['id'],
                    'user_id' => $login_user['id'],
                    'date'    => $item_date,
                    'item_id' => $order['item_id'],
                ];

                // 締め切り時間チェック
                $deadline = strtotime("{$item_date} {$system['deadline_hour']} -{$system['deadline_day']} day");
                if ($deadline < now()) {
                    $this->set_error('締切時間を超えているため変更できませんでした');
                    redirect('order/?date='.$date);
                }
                // 保存データ
                $datas[] = $data;
            }
        }

        // エラーあり
        if ($error_flag) {
            $this->set_error("注文内容にエラーがあります");
            return;
        }

        // 保存情報が無ければ終了
        if (!$datas) {
            return;
        }

        // 注文保存
        if (false === $this->Order_model->sets($datas)) {
            // 保存失敗
            $this->set_error(lang('message_save_error'));
            return;
        }

        // ログ保存
        $this->load->model($this->router->directory.'User_log_model');
        $this->User_log_model->add_order($login_user['id'], '注文', $datas);

        // 完了
        //$this->set_message('注文が完了しました');
        // 前画面にリダイレクト
        redirect('order/finish/?date='.$date);
    }

    /**
     * 注文画面
     *
     * @param void
     */
    public function finish()
    {
        // タイトル
        $this->title .= '完了';

        // ユーザー情報
        $login_user = $this->load->get_var('login_user');

        // 引数なければ今日
        $date = $this->input->get('date') ?: date('Y-m-d');
        $this->load->vars('date', $date);

        // 一覧日数
        $day     = ORDER_VIEW_DAY;
        // 表示範囲日数
        $max_day = ORDER_VIEW_MAX_DAY;

        // 表示可能日付範囲外チェック
        if ($date < date('Y-m-d', strtotime("-{$max_day} day")) ||
            $date > date('Y-m-d', strtotime("+{$max_day} day"))) {
            // 範囲外
            exit;
        }

        // 日付と商品と注文情報
        $this->load->model($this->router->directory.'Order_model');
        $dates = $this->Order_model->list_by_date($date, $day, $login_user['id']);
        $this->load->vars('dates', $dates);

        // 提供時間
        $this->load->model($this->router->directory.'Item_time_model');
        $this->load->vars('item_time_options', $this->Item_time_model->get_options());
    }

}

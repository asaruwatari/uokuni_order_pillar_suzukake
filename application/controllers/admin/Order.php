<?php
/**
 * 受注管理
 *
 * @package    Admin
 * @subpackage Controller
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class Order extends Admin_controller
{
    public $title  = '受注';
    public $layout = 'loggedin';

    /**
     * コンストラクタ
     *
     * @param void
     */
    public function __construct()
    {
        parent::__construct();

        // メニュー番号
        $this->load->vars('menu_id', ADMIN_MENU_ORDER);
    }

    /**
     * 一覧画面
     *
     * @param void
     */
    public function index()
    {
        // タイトル
        $this->title .= '一覧';

        // 戻るURL初期化
        $this->unset_back_url();
        // 戻るURLセット
        $this->set_back_url();

        // 引数なければ今日から
        $date = $this->input->get('date') ?: date('Y-m-d');
        $this->load->vars('date', $date);

        // 前月・次月リンク用パラメータ
        $day = 7;
        $this->load->vars('prev', '/?date='.date('Y-m-d', strtotime("$date -{$day} day")));
        $this->load->vars('next', '/?date='.date('Y-m-d', strtotime("$date +{$day} day")));

        // メニュー枠情報取得
        $this->load->model($this->router->directory.'Item_type_model');
        $this->load->vars('item_types', $this->Item_type_model->get_list_data());

        // 注文情報取得
        $this->load->model($this->router->directory.'Order_model');
        $this->load->vars('datas', $this->Order_model->list_by_date($date, $day));
    }

    /**
     * 日の一覧画面
     *
     * @param void
     */
    public function date()
    {
        // タイトル
        $this->title .= '一覧';

        // 戻るURLセット
        $this->set_back_url();

        // 引数なければ終了
        $date = $this->input->get('date');
        if (!$date) {
            exit;
        }

        // 日の注文情報取得
        $this->load->model($this->router->directory.'Order_model');
        $this->load->vars('list', $this->Order_model->gets_by_date($date));
    }

    /**
     * 日別出力(Excel)
     *
     * @param void
     */
    public function date_sheet()
    {
        $this->layout = 'excel';

        // タイトル
        $this->title .= '日別出力';

        // 引数なければ終了
        $date = $this->input->get('date');
        if (!$date) {
            exit;
        }

        // 日付
        $this->load->vars('date', $date);

        // 日の注文情報取得
        $this->load->model($this->router->directory.'Order_model');
        $this->load->vars('list', $this->Order_model->gets_by_date($date));

        // ファイル名
        $this->load->vars('filename', "date_sheet_{$date}.xlsx");
    }

    /**
     * 受取チェック表(PDF)
     *
     * @param void
     */
    public function date_check_sheet()
    {
        $this->layout = 'pdf';

        // タイトル
        $this->title = '受取チェック表';

        // 引数なければ終了
        $date = $this->input->get('date');
        if (!$date) {
            exit;
        }
        $this->load->vars('date', $date);

        // 日の注文情報取得
        $this->load->model($this->router->directory.'Order_model');
        $this->load->vars('list', $this->Order_model->gets_by_date($date));

        // ファイル名
        $this->load->vars('filename', "date_check_sheet_{$date}.pdf");
    }

    /**
     * 編集画面
     *
     * @param integer $id ID
     */
    public function edit($id = null)
    {
        // タイトル
        $this->title .= '編集';

        // 戻るURLセット
        $this->set_back_url();

        // 利用者選択肢
        $this->load->model($this->router->directory.'User_model');
        $this->load->vars('user_options', $this->User_model->get_options());

        // 編集画面処理
        if (true !== $this->general_edit($id)) {
            return;
        }

        // 前画面にリダイレクト
        redirect($this->get_back_url());
    }

    protected function edit_hook_before_assign(&$data, &$validation_rules)
    {
        // 商品択肢
        $this->load->model($this->router->directory.'Item_model');
        $this->load->vars('item_options', $this->Item_model->get_date_options($data['item_id']));
    }

    /**
     * 削除処理
     *
     * @param int $id ID
     */
    public function delete($id = null)
    {
        // 戻るURLセット
        $this->set_back_url();

        // 引数確認
        if (!$id) {
            redirect($this->get_back_url());
        }

        // 削除処理
        $this->general_delete($id);

        // 前画面にリダイレクト
        redirect($this->get_back_url());
    }

    /**
     * 集計画面
     *
     * @param void
     */
    public function total()
    {
        // メニュー番号
        $this->load->vars('menu_id', ADMIN_MENU_ORDER_TOTAL);

        // タイトル
        $this->title .= '集計';

        // 戻るURL初期化
        $this->unset_back_url();
        // 戻るURLセット
        $this->set_back_url();

        // 締め日から基準日決定
        if (MONTH_START_DAY <= date('n')) {
            // 今月度 3/21なら3月度
            $base_time = strtotime(date('Y-m-01'));
        } else {
            // 先月度 3/20なら先月度
            $base_time = strtotime(date('Y-m-01')." -1 month");
        }

        // 引数なければ今月の年と月
        $year  = $this->input->get('year') ?: date('Y', $base_time);
        $month = $this->input->get('month') ?: date('n', $base_time);
        $this->load->vars('year', $year);
        $this->load->vars('month', $month);
        $this->load->vars('weeks', ['日', '月', '火', '水', '木', '金', '土']);

        // 期間
        $from_date = date('Y-m-21', strtotime("{$year}-{$month}-01"));
        $to_date   = date('Y-m-20', strtotime("{$year}-{$month}-01 +1 month"));
        $this->load->vars('from_date', $from_date);
        $this->load->vars('to_date', $to_date);

        // 前月・次月リンク用パラメータ
        $this->load->vars('prev', vsprintf('/?year=%s&month=%s', explode('-', date('Y-m', strtotime("{$year}-{$month}-01 -1 month")))));
        $this->load->vars('next', vsprintf('/?year=%s&month=%s', explode('-', date('Y-m', strtotime("{$year}-{$month}-01 +1 month")))));

        // メニュー枠情報取得
        $this->load->model($this->router->directory.'Item_type_model');
        $this->load->vars('item_types', $this->Item_type_model->get_list_data());

        // 注文情報取得
        $this->load->model($this->router->directory.'Order_model');
        $this->load->vars('list', $this->Order_model->get_total($from_date, $to_date));

        // システム設定
        $this->load->model($this->router->directory.'System_model');
        $this->load->vars('system', $this->System_model->get_by_id(1));
    }

    /**
     * 集計出力(Excel)
     *
     * @param void
     */
    public function total_sheet()
    {
        $this->layout = 'excel';

        // メニュー番号
        $this->load->vars('menu_id', ADMIN_MENU_ORDER_TOTAL);

        // タイトル
        $this->title .= '集計';

        // 引数
        $year  = $this->input->get('year');
        $month = $this->input->get('month');
        if (!$year || !$month) {
            exit;
        }
        $this->load->vars('year', $year);
        $this->load->vars('month', $month);
        $this->load->vars('weeks', ['日', '月', '火', '水', '木', '金', '土']);

        // 期間
        $from_date = date('Y-m-21', strtotime("{$year}-{$month}-01"));
        $to_date   = date('Y-m-20', strtotime("{$year}-{$month}-01 +1 month"));
        $this->load->vars('from_date', $from_date);
        $this->load->vars('to_date', $to_date);

        // 前月・次月リンク用パラメータ
        $this->load->vars('prev', vsprintf('/?year=%s&month=%s', explode('-', date('Y-m', strtotime("{$year}-{$month}-01 -1 month")))));
        $this->load->vars('next', vsprintf('/?year=%s&month=%s', explode('-', date('Y-m', strtotime("{$year}-{$month}-01 +1 month")))));

        // 注文情報取得
        $this->load->model($this->router->directory.'Order_model');
        $this->load->vars('list', $this->Order_model->get_total($from_date, $to_date));

        // システム設定
        $this->load->model($this->router->directory.'System_model');
        $this->load->vars('system', $this->System_model->get_by_id(1));

        // ファイル名
        $this->load->vars('filename', "total_sheet_{$year}-{$month}.xlsx");
    }

}

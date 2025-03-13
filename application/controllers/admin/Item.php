<?php
/**
 * 商品管理
 *
 * @package    Admin
 * @subpackage Controller
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class Item extends Admin_controller
{
    public $title  = '商品';
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
        $this->load->vars('menu_id', ADMIN_MENU_ITEM);
    }

    /**
     * 編集画面
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

        // 引数なければ今月
        $year  = $this->input->get('year') ?: date('Y');
        $month = $this->input->get('month') ?: date('m');

        $this->load->vars('year', $year);
        $this->load->vars('month', $month);
        $this->load->vars('weeks', ['日', '月', '火', '水', '木', '金', '土']);

        // 前月・次月リンク用パラメータ
        $this->load->vars('prev', vsprintf('?year=%s&month=%s', explode('-', date('Y-m', strtotime("{$year}-{$month}-01 -1 month")))));
        $this->load->vars('next', vsprintf('?year=%s&month=%s', explode('-', date('Y-m', strtotime("{$year}-{$month}-01 +1 month")))));

        // メニュー枠情報取得
        $this->load->model($this->router->directory.'Item_type_model');
        $item_types = $this->Item_type_model->gets();
        $this->load->vars('item_types', $item_types);

        // メニュー情報取得
        $this->load->model($this->router->directory.'Item_model');
        $datas = $this->Item_model->gets($year, $month);
        $this->load->vars('datas', $datas);

        // POST確認
        if (!$post = $this->input->post()) {
            // POSTしていない
            return;
        }

        // バリデーション
        $this->load->library('form_validation');
        // バリデーションルール作成
        $validation_rules      = [];
        $item_validation_rules = $this->get_validation_rules('item');
        // 日付ループ
        foreach ($datas as $data) {
            // 商品区分ループ
            foreach ($item_types as $item_type) {
                // ルールループ
                foreach ($item_validation_rules as $rules) {
                    // ルールのフィールド名加工
                    $validation_rules[] = [
                        'field' => "datas[{$data['date']}][{$item_type['id']}][{$rules['field']}]",
                        'label' => $rules['label'].'_'.$data['date'].'_'.$item_type['id'],
                        'rules' => $rules['rules'],
                    ];
                }
            }
        }
        $this->form_validation->set_rules($validation_rules);

        // バリデーション実行
        $this->form_validation->set_data($post);
        if (false === $this->form_validation->run()) {
            $this->set_error(lang('message_validation_error'));
            return false;
        }

        // 保存
        if (false === $this->Item_model->sets($post['datas'])) {
            // 保存失敗
            $this->set_error(lang('message_save_error'));
            return false;
        }

        // 完了
        $this->set_message(lang('message_saved'));

        // 前画面にリダイレクト
        redirect($this->get_back_url());
    }

}

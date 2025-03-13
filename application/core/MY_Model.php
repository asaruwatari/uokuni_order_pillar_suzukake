<?php
/**
 * 基底モデル
 * DBクラスのラッパ
 *
 * @package    Common
 * @subpackage Model
 * @category
 * @author     Saruwatari <saruwatari@sncj.co.jp>
 * @link
 */
class MY_Model extends CI_Model
{
    /**
     * @var string テーブル名(コンストラクタでクラス名から自動作成)
     */
    public $table;

    /**
     * @var integer 全件数（ページング用）
     */
    public $total_rows = 0;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        // テーブル名の設定が無ければクラス名をテーブル名とする
        if (empty($this->table)) {
            $class       = get_class($this);
            $tablename   = strtolower(substr($class, 0, strrpos($class, '_')));
            $this->table = $tablename;
        }
    }

    /*
     * パスワード
     *
     */
    /**
     * パスワードハッシュ作成
     *
     * @param unknown $password
     * @return string
     */
    public function get_hash($password)
    {
        return sha1($password.$this->config->item('salt'));
    }

    /*
     * 共通処理
     *
     */
    /**
     * IDからレコードを1行得る
     *
     * @param integer $id
     * @return array
     */
    public function get_by_id($id)
    {
        return $this->db->where(array(
                'id' => $id
            ))->get($this->table)->row_array();
    }

    /**
     * 指定カラムの値を得る
     *
     * @param string $column
     * @param integer $id
     * @return array
     */
    public function get_column($column, $id)
    {
        $this->db
            ->select($column)
            ->from($this->table)
            ->where('id', $id);
        $result = $this->db->get()->row_array();
        return $result[$column];
    }

    /**
     * idをキー、name値とする配列を得る
     *
     * @param void
     * @return array
     */
    public function get_options()
    {
        $this->db
            ->select('id, name')
            ->from($this->table)
            ->where('deleted_flag', 0)
            ->order_by("order, id");
        $results = $this->db->get()->result_array();
        return $this->get_option($results);
    }

    protected function get_option($results)
    {
        $data = array();
        foreach ($results as $result) {
            $data[array_shift($result)] = array_shift($result);
        }
        return $data;
    }

    /**
     * データを保存する
     * 主キー全てが存在し値があればUPDATE,なければINSERT
     *
     * @param mixed $pk 主キー
     * @param array $data 保存情報
     * @return bool
     */
    public function set($pk, $data)
    {
        if ($pk) {
            // UPDATE
            $result = $this->update(['id' => $pk], $data);
        } else {
            // INSERT
            $result = $this->insert($data);
        }
        return $result;
    }

    /**
     * INSERT
     *
     * @param array $data 保存情報
     * @return bool
     */
    public function insert($data)
    {
        unset($data['updated_at']);

        // 作成日時セット
        $data['created_at'] = $this->now();

        // 挿入実行
        return $this->db->insert($this->table, $data);
    }

    /**
     * 挿入したIDを得る
     *
     * @param void
     * @return integer 挿入したID
     */
    public function get_insert_id()
    {
        return $this->db->insert_id();
    }

    /**
     * UPDATE
     *
     * @param array $conditions 条件
     * @param array $data 保存情報
     * @return bool
     */
    public function update($conditions, $data = null)
    {
        unset($data['updated_at']);
        unset($data['created_at']);

        // 条件設定
        if (is_array($conditions)) {
            // $conditionsが配列ならループ処理
            foreach ($conditions as $key => $condition) {
                if (is_array($condition)) {
                    // 値が配列ならWHERE IN
                    $this->db->where_in($key, $condition);
                } else {
                    // 値が配列でないならWHERE
                    $this->db->where($key, $condition);
                }
            }
        } else {
            // $conditionsが配列でないならID指定
            $this->db->where('id', $conditions);
        }

        // 更新実行
        return $this->db->update($this->table, $data);
    }

    /**
     * REPLACE
     *
     * @param array $data 保存情報
     * @return bool
     */
    public function replace($data = null)
    {
        unset($data['updated_at']);

        // 置き換え実行
        return $this->db->replace($this->table, $data);
    }

    /**
     * DELETE
     *
     * @param array $conditions
     */
    public function delete($conditions)
    {
        // 条件設定
        if (is_array($conditions)) {
            // $conditionsが配列ならループ処理
            foreach ($conditions as $key => $condition) {
                if (is_array($condition)) {
                    // 値が配列ならWHERE IN
                    $this->db->where_in($key, $condition);
                } else {
                    // 値が配列でないならWHERE
                    $this->db->where($key, $condition);
                }
            }
        } else {
            // $conditionsが配列でないならID指定
            $this->db->where('id', $conditions);
        }
        return $this->db->delete($this->table);
    }

    /**
     * レコードの結果配列から
     * 指定カラムをキーとする配列を得る
     *
     * @param  array $rows レコードの配列
     * @param  array $column_name カラム名
     * @return array
     */
    public function get_column_array($rows, $column_name = 'id')
    {
        $data = array();
        foreach ($rows as $row) {
            $data[$row[$column_name]] = $row;
        }
        return $data;
    }

    /**
     * 現在日時を得る
     *
     * @return string
     */
    protected function now()
    {
        return date('Y-m-d H:i:s');
    }

    /*
     * 汎用メソッド
     *
     */
    /**
     * 一覧用データ取得
     *
     * @param integer $per_page 取得行数
     * @param integer $offset 読み飛ばし行数
     * @param array $conditions 条件連想配列
     * @return array
     * @see set_list_query()
     */
    public function get_list_data($per_page = 0, $offset = 0, $conditions = [])
    {
        // 一覧用クエリ設定(継承先で用意)
        $this->set_list_query();

        // 抽出条件設定(継承先で用意)
        if (is_callable([$this, 'set_conditions'])) {
            $this->set_conditions($conditions);
        }

        // ページング処理
        if ($per_page) {
            // ページングあり
            // 全件数取得
            $this->total_rows = $this->db->count_all_results('', false);
            // 表示分の情報に限定
            $this->db->limit($per_page, $offset);
        }
        // 結果取得
        $data = $this->db->get()->result_array();

        //$query = $this->db->last_query();
        //$error = $this->db->error();
        // 結果返却
        return $data;
    }

    /**
     * 一覧クエリ設定
     * get_list_dataから呼び出される
     * 各モデルでオーバーライドする
     *
     * @param void
     * @return void
     */
    protected function set_list_query()
    {
        $this->db
            ->select("{$this->table}.*")
            ->from($this->table)
            ->order_by("{$this->table}.id");
    }

    /**
     * ファイル出力用データ取得
     *
     * @param array $conditions 条件連想配列
     * @return array
     */
    public function get_export_data($conditions = [])
    {
        // 一覧用クエリ設定(継承先で用意)
        $this->set_list_query();

        // 抽出条件設定(継承先で用意)
        if ($conditions && true === is_callable([$this, 'set_conditions'])) {
            $this->set_conditions($conditions);
        }

        // 結果取得
        return $this->db->get()->result_array();
    }

    /**
     * 編集用データ取得
     *
     * @param array $conditions 条件
     * @return array
     */
    public function get_edit_data($conditions)
    {
        $this->db
            ->select("{$this->table}.*")
            ->from($this->table);

        // 条件設定
        if (is_array($conditions)) {
            // $conditionsが配列ならループ処理
            foreach ($conditions as $key => $condition) {
                if (is_array($condition)) {
                    // 値が配列ならWHERE IN
                    $this->db->where_in($key, $condition);
                } else {
                    // 値が配列でないならWHERE
                    $this->db->where($key, $condition);
                }
            }
        } else {
            // $conditionsが配列でないならID指定
            $this->db->where('id', $conditions);
        }

        // 情報取得
        return $this->db->get()->row_array();
    }

    /**
     * 連続した日の配列を取得
     *
     * @param date $start_date 開始日
     * @param date $end_date 終了日
     * @return array
     */
    public function get_dates($start_date, $end_date)
    {
        // 開始日
        $this->db->query("SET @START_DATE = '{$start_date}';");
        // 終了日
        $this->db->query("SET @END_DATE = '{$end_date}';");
        $sql = "SELECT days.date
            FROM (SELECT DATE_FORMAT(DATE_ADD(@START_DATE, INTERVAL tmp.series DAY), '%Y-%m-%d') AS date
                FROM
                (
                    SELECT 0 series FROM DUAL WHERE (@num:=-1)*0 UNION ALL
                    SELECT @num:=@num+1 FROM `information_schema`.COLUMNS
                ) AS tmp
                HAVING DATE_FORMAT(date, '%Y-%m-%d') <= DATE_FORMAT(@END_DATE, '%Y-%m-%d')
            ) AS days ";

        // 結果取得
        return $this->db->query($sql)->result_array();
    }

    /**
     * インポート（総入替）
     *
     * @param array $data
     * @return bool
     */
    public function import($data)
    {
        // 削除
        $this->db->truncate($this->table);

        // トランザクション開始
        $this->db->trans_start();

        // 挿入
        $this->db->insert_batch($this->table, $data);

        // トランザクション終了
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * インポート（置換）
     *
     * @param array $list
     * @return bool
     */
    public function replace_import($list)
    {
        // トランザクション開始
        $this->db->trans_start();

        // 置き換え
        foreach ($list as $data) {
            $data['created_at'] = $this->now();
            $this->db->replace($this->table, $data);
        }

        // トランザクション終了
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

}

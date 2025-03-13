<?php
/* $Id: CSV.class.php,v 1.2 2007/05/25 00:29:25 ASaruwatari Exp $ */
/**
 * CSVクラス
 *
 * PHP5.2.6以上
 * デフォルト設定でRFC4180基準
 * メモリ使用量を減らすためCSVファイルを一括で処理しない様作成している
 *
 * @category   CSV
 * @package    common
 * @author     猿渡彰 <saruwatari@sncj.co.jp>
 * @copyright  2005-2011 SNC Co.,ltd.
 * @version    1.5.0 ($Revision: 1.2 $)
 */
class Csv
{
    /**
     * 内部文字コード
     * @var string
     */
    public $scriptEncode = 'UTF-8';

    /**
     * CSV文字コード
     * @var string
     */
    public $csvEncode = 'sjis-win';

    /**
     * 区切り文字
     * @var string
     */
    public $delimiter = ',';

    /**
     * 引用符
     * @var string
     */
    public $enclosure = '"';

    /**
     * 改行コード
     * @var string
     */
    public $linebreak = "\r\n";

    /**
     * ファイルパス
     * @var string
     */
    public $file = '';

    /**
     * ファイルハンドル
     * @var resource
     */
    public $handle = null;

    /**
     * CSVファイルを開く
     *
     * @param  string ファイルパス
     * @return bool
     */
    public function open($file = null)
    {
        if ($file) {
            $this->file = $file;
        }
        return $this->file && $this->handle = fopen($this->file, 'c+b');
    }

    /**
     * CSVファイルを閉じる
     *
     * @param  void
     * @return bool
     */
    public function close()
    {
        return $this->handle && fclose($this->handle);
    }

    /**
     * CSVファイル1行を配列で得る
     *
     * @param  void
     * @return array データ配列
     */
    public function get()
    {
        $d     = preg_quote($this->delimiter);
        $e     = preg_quote($this->enclosure);
        $eof   = null;
        $_line = '';
        // ファイルから1行取得
        while ($eof != true) {
            $_line     .= fgets($this->handle, 65535);
            // スクリプトのエンコードに変換(やらないと区切り文字などが検出できない)
            //$_line = mb_convert_encoding($_line, $this->scriptEncode, $this->csvEncode);
            $itemCount = preg_match_all('/'.$e.'/', $_line, $dummy);
            if ($itemCount % 2 == 0) $eof       = true;
        }
        $_line        = mb_convert_encoding($_line, $this->scriptEncode, $this->csvEncode);
        // 区切り文字で分割し配列を作成
        $_csv_line    = preg_replace('/(?:\r\n|[\r\n])?$/', $d, trim($_line));
        $_csv_pattern = '/('.$e.'[^'.$e.']*(?:'.$e.$e.'[^'.$e.']*)*'.$e.'|[^'.$d.']*)'.$d.'/';
        preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
        $_csv_data    = $_csv_matches[1];
        for ($_csv_i = 0; $_csv_i < count($_csv_data); $_csv_i++) {
            $_csv_data[$_csv_i] = preg_replace('/^'.$e.'(.*)'.$e.'$/s', '$1', $_csv_data[$_csv_i]);
            $_csv_data[$_csv_i] = str_replace($e.$e, $e, $_csv_data[$_csv_i]);
        }
        return empty($_line) ? false : $_csv_data;
        //return array_walk(fgetcsv($this->handle, 65535, $this->delimiter, $this->enclosure), array($this, '_convert'));
        //return stream_get_line($this->handle, 65535, $this->linebreak);
    }

    /**
     * 配列からCSVファイルに1行追記する
     *
     * @param  array データ配列
     * @return bool
     */
    public function set($data)
    {
        $line = array();
        foreach ($data as $value) {
            // 引用符処理
            if ($this->enclosure) {
                // 引用符付加
                $value = $this->enclosure.str_replace($this->enclosure, $this->enclosure.$this->enclosure, $value).$this->enclosure;
            } else {
                // 引用符をつけない場合データ内から区切り文字、改行文字を排除する
                $value = str_replace(array($this->delimiter, $this->linebreak), '', $value);
            }
            $line[] = $value;
        }
        // 区切り文字と改行文字
        $line = implode($this->delimiter, $line).$this->linebreak;
        // エンコード変更
        $line = mb_convert_encoding($line, $this->csvEncode, $this->scriptEncode);
        // 書き込み
        return $this->handle && fwrite($this->handle, $line);
    }

}

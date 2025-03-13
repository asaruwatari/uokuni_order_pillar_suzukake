<?php
// ブック生成
$this->load->library("PHPExcel");
$book = new PHPExcel();

$book->setActiveSheetIndex(0);
$sheet = $book->getActiveSheet();

// タイトル
$sheet->setTitle(jp_date($date).' 注文一覧');
// 標準フォント
$sheet->getDefaultStyle()->getFont()->setName('Meiryo UI')->setSize(11);
// 倍率
$sheet->getSheetView()->setZoomScale(100);

$x = 0;
$y = 1;

// タイトル行
$sheet->setCellValueByColumnAndRow($x, $y++, jp_date($date)." 注文一覧　[出力日時 ".date('Y-m-d H:i:s').']');

// ヘッダ行
$sheet->setCellValueByColumnAndRow($x++, $y, '提供時間');
$sheet->setCellValueByColumnAndRow($x++, $y, '職番');
$sheet->setCellValueByColumnAndRow($x++, $y, '氏名');
$sheet->setCellValueByColumnAndRow($x++, $y, '区分');
$sheet->setCellValueByColumnAndRow($x++, $y, '献立');
$sheet->setCellValueByColumnAndRow($x++, $y, '注文日時');
$sheet->setCellValueByColumnAndRow($x++, $y, '注文IP');
$sheet->setCellValueByColumnAndRow($x++, $y, 'キャンセル');
$sheet->setCellValueByColumnAndRow($x++, $y, '備考');
$sheet->setCellValueByColumnAndRow($x++, $y++, '更新日時');

// 集計行
foreach ($list as $i => &$data) {
    $x = 0;
    $sheet->setCellValueExplicitByColumnAndRow($x++, $y, $data['item_time.name'], PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicitByColumnAndRow($x++, $y, $data['user.code'], PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicitByColumnAndRow($x++, $y, $data['user.name'], PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicitByColumnAndRow($x++, $y, $data['item_type.name'], PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicitByColumnAndRow($x++, $y, $data['item.name'], PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicitByColumnAndRow($x++, $y, $data['created_at'], PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicitByColumnAndRow($x++, $y, $data['ip'], PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicitByColumnAndRow($x++, $y, $data['canceled_flag'], PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicitByColumnAndRow($x++, $y, $data['remarks'], PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicitByColumnAndRow($x++, $y++, $data['updated_at'], PHPExcel_Cell_DataType::TYPE_STRING);
}

// 幅調整
for ($col = 0; $col < PHPExcel_Cell::columnIndexFromString($sheet->getHighestDataColumn()); $col++) {
    $coldim = PHPExcel_Cell::stringFromColumnIndex($col);
    $sheet->getColumnDimension($coldim)->setAutoSize(true);
    $sheet->calculateColumnWidths();
    $sheet->getColumnDimension($coldim)->setAutoSize(false);
    $sheet->getColumnDimension($coldim)->setWidth($sheet->getColumnDimension($coldim)->getWidth() * 1.4);
}
// A列の幅だけ手動指定
$sheet->getColumnDimension('A')->setWidth(15);

// A1を選択
$sheet->setSelectedCell('A1');

// 最初のシートをアクティブに
$book->setActiveSheetIndex(0);
// 生成
$writer = PHPExcel_IOFactory::createWriter($book, 'Excel2007');
// 数式の事前計算無効化
$writer->setPreCalculateFormulas(false);
// 出力
$writer->save('php://output');

// メモリの解放
$book->disconnectWorksheets();
unset($book);

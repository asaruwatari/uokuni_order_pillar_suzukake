<?php
// ブック生成
$this->load->library("PHPExcel");
$book = new PHPExcel();

$book->setActiveSheetIndex(0);
$sheet = $book->getActiveSheet();

// タイトル
$sheet->setTitle($title);
// 標準フォント
$sheet->getDefaultStyle()->getFont()->setName('Meiryo UI')->setSize(11);
// 倍率
$sheet->getSheetView()->setZoomScale(100);

$x = 0;
$y = 1;

// ヘッダ行
$sheet->setCellValueByColumnAndRow($x++, $y, '職番');
$sheet->setCellValueByColumnAndRow($x++, $y, '氏名');
$sheet->setCellValueByColumnAndRow($x++, $y, '区分');
$sheet->setCellValueByColumnAndRow($x++, $y, 'パスワード');
$sheet->setCellValueByColumnAndRow($x++, $y, '無効');
$sheet->setCellValueByColumnAndRow($x++, $y++, '更新日時');

// 集計行
foreach ($list as $i => &$data) {
    $x = 0;
    $sheet->setCellValueExplicitByColumnAndRow($x++, $y, $data['code'], PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicitByColumnAndRow($x++, $y, $data['name'], PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicitByColumnAndRow($x++, $y, $data['user_type.name'], PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicitByColumnAndRow($x++, $y, '', PHPExcel_Cell_DataType::TYPE_STRING);
    $sheet->setCellValueExplicitByColumnAndRow($x++, $y, $data['deleted_flag'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
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
//$sheet->getColumnDimension('A')->setWidth(15);
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

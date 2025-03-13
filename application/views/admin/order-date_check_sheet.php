<?php
$this->load->library('pdf');
class MYPDF extends Pdf
{
    public $data = [];

    // フッタのカスタマイズ(ページ番号を出力する)
    public function Header()
    {
        $cell_height = 6;

        $this->SetY(10);
        $this->SetFont('migmix1p', '', 16);

        $this->SetFontSize(16);
        //$this->Write(0, ' 受取チェックシート (', null, null, 'L', true);
        $this->Write(0, jp_date_week($this->data['date']).' 受取チェック表 ('.$this->data['item_time'].')', null, null, 'L', true);
        $this->Ln(1);

        $this->SetY(10);

        $this->SetFontSize(6);
        $this->Write(0, '印刷日時: '.date('Y-m-d H:i:s'), null, null, 'R', true);
        $this->Ln(10);

        // ヘッダ行
        $this->SetFontSize(12);
        //$pdf->SetTextColor(255, 255, 255);
        //$pdf->SetFillColor(79, 129, 189);
        $this->Cell(10, $cell_height, '受取', 1, 0, 'C', 0, null, 1);
        $this->Cell(30, $cell_height, '職番', 1, 0, 'C', 0, null, 1);
        $this->Cell(30, $cell_height, '氏名', 1, 0, 'C', 0, null, 1);
        $this->Cell(40, $cell_height, '区分', 1, 0, 'C', 0, null, 1);
        $this->Cell(70, $cell_height, '献立', 1, 1, 'C', 0, null, 1);
    }

}

$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('');
$pdf->SetTitle($title);
#$tcpdf->SetSubject('');
#$tcpdf->SetKeywords('');
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(false);
$pdf->SetMargins(PDF_MARGIN_LEFT, 30);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(true, 10);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//$pdf->AliasNbPages();

$pdf->SetDisplayMode('fullpage');

$pdf->SetFont('migmix1p', '', 10);

$cell_height = 6;

$pdf->data = [
    'date'      => $date,
    'item_time' => '',
];

$pdf->SetTextColor(0, 0, 0);

// 注文ループ
foreach ($list as $i => $order) {

    // キャンセルは飛ばす
    if ($order['canceled_flag']) {
        continue;
    }

    // 提供時間が変わったらページ追加
    if ($pdf->data['item_time'] != $order['item_time.name']) {
        $pdf->data['item_time'] = $order['item_time.name'];
        $pdf->AddPage();
    }

    // 注文一覧
    $pdf->Cell(10, $cell_height, '', 1, 0, 'L', 0, null, 1);
    $pdf->Cell(30, $cell_height, $order['user.code'], 1, 0, 'L', 0, null, 1);
    $pdf->Cell(30, $cell_height, $order['user.name'], 1, 0, 'L', 0, null, 1);
    $pdf->Cell(40, $cell_height, $order['item_type.name'], 1, 0, 'L', 0, null, 1);
    $pdf->Cell(70, $cell_height, $order['item.name'], 1, 1, 'L', 0, null, 1);
}

//出力
$pdf->lastPage();
$pdf->Output($filename, 'I');



<?php
//require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'tcpdf/config/lang/eng.php');
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'tcpdf/config/tcpdf_config.php');
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'tcpdf/tcpdf.php');
/**
 * PDFクラス
 *
 * TCPDFラッパー
 *
 */
class Pdf extends TCPDF
{
    public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false, $pdfa = false)
    {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
    }

}

<?php
require '../pdf/fpdf.php';
$con = mysqli_connect('localhost', 'root', '');
mysqli_select_db($con, 'pcm_project');

$pdf = new FPDF('P', 'mm', 'A4');
// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวธรรมดา กำหนด ชื่อ เป็น angsana
$pdf->AddFont('angsa', '', 'angsa.php');
// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวหนา  กำหนด ชื่อ เป็น angsana
$pdf->AddFont('angsa', 'B', 'angsab.php');
// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวหนา  กำหนด ชื่อ เป็น angsana
$pdf->AddFont('angsa', 'I', 'angsab.php');
// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวหนา  กำหนด ชื่อ เป็น angsana
$pdf->AddFont('angsa', 'BI', 'angsab.php');

//สร้างหน้าเอกสาร
$pdf->AddPage();
$pdf->Ln();
$pdf->Image('../pdf/logo4.jpg', 15, 11, 50, 15, '', 'http://www.pcm-pro-concept.com/');
$pdf->SetFont('angsa', '', 12);

$pdf->Cell(190, 18, '', 1, 1);
$pdf->Cell(190, 51, '', 1, 1);

function DateThai($strDate)
{
    $strYear = date('Y', strtotime($strDate));
    $strMonth = date('n', strtotime($strDate));
    $strDay = date('j', strtotime($strDate));
    $strMonthCut = ['', ' Jan.', 'Feb.', 'Mar.', 'Apr.', 'May', 'Jun.', 'Jul.', 'Aug.', 'Sep.', 'Oct.', 'Nov.', 'Dec.'];
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}

$strDate = '2008-08-14';
//echo "ThaiCreate.Com Time now : ".DateThai($strDate);

function convert($number)
{
    $txtnum1 = ['ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า', 'สิบ'];
    $txtnum2 = ['', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน'];
    $number = str_replace(',', '', $number);
    $number = str_replace(' ', '', $number);
    $number = str_replace('บาท', '', $number);
    $number = explode('.', $number);
    if (sizeof($number) > 2) {
        return 'ทศนิยมหลายตัวนะจ๊ะ';
        exit();
    }
    $strlen = strlen($number[0]);
    $convert = '';
    for ($i = 0; $i < $strlen; $i++) {
        $n = substr($number[0], $i, 1);
        if ($n != 0) {
            if ($i == $strlen - 1 and $n == 1) {
                $convert .= 'เอ็ด';
            } elseif ($i == $strlen - 2 and $n == 2) {
                $convert .= 'ยี่';
            } elseif ($i == $strlen - 2 and $n == 1) {
                $convert .= '';
            } else {
                $convert .= $txtnum1[$n];
            }
            $convert .= $txtnum2[$strlen - $i - 1];
        }
    }

    $convert .= 'บาท';
    if ($number[1] == '0' or $number[1] == '00' or $number[1] == '') {
        $convert .= 'ถ้วน';
    } else {
        $strlen = strlen($number[1]);
        for ($i = 0; $i < $strlen; $i++) {
            $n = substr($number[1], $i, 1);
            if ($n != 0) {
                if ($i == $strlen - 1 and $n == 1) {
                    $convert .= 'เอ็ด';
                } elseif ($i == $strlen - 2 and $n == 2) {
                    $convert .= 'ยี่';
                } elseif ($i == $strlen - 2 and $n == 1) {
                    $convert .= '';
                } else {
                    $convert .= $txtnum1[$n];
                }
                $convert .= $txtnum2[$strlen - $i - 1];
            }
        }
        $convert .= 'สตางค์';
    }
    return $convert;
}
## วิธีใช้งาน
//$x = '9123568543241.25';
//echo  $x  . "=>" .convert($x);

$pdf->SetFont('angsa', 'B', 25);
$pdf->setXY(90, 17);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'ใบสั่งซื้อ'));

$pdf->setXY(75, 22);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'PURCHASE ORDER'));

$pdf->SetFont('angsa', '', 12);

$query = mysqli_query($con, 'select * from po_details');
$c = 0;
$page = 0;
while ($data = mysqli_fetch_array($query)) {
    if ($po == $data['PO_NO']) {
        $pdf->setXY(172, 13);
        $pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $data['Doc_NO']));
        $pdf->setXY(172, 17);
        $pdf->Cell(0, 0, DateThai($data['date']));
        $page++;
        $pdf->setXY(180, 25.5);
        $pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $page));
        $pdf->SetFont('angsa', '', 14);
        $pdf->setXY(33, 32);
        $pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $data['attn']));
        $pdf->setXY(44, 42);
        $pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $data['company_name']));
        $pdf->setXY(145, 42);
        $pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $data['PO_NO']));
        $pdf->setXY(160, 53);
        $pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $data['teams_of_payment']));
        $pdf->setXY(140, 32);
        $pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', DateThai($data['date'])));
        $pdf->setXY(155, 63);
        $pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $data['delivery_date']));
        $pdf->setXY(30, 70);
        $pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $data['reason_to_buy']));
        $c++;
    }
}
$pdf->setXY(160, 13);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'Doc No :'));
$pdf->setXY(160, 17);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'Date :')); //. date('d') . '/' . date('m') . '/' . (date('Y') + 543) . '')
$pdf->setXY(160, 21);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'Issue No :'));
$pdf->setXY(180, 21);
$pdf->Cell(0, 1, 'Rev:', 0, 1, 'L');
$pdf->setXY(150, 25);
$pdf->Cell(0, 1, 'Page', 0, 1, 'C');

$pdf->SetFont('angsa', '', 14);
$pdf->setXY(20, 32);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'Attn :'));
$pdf->setXY(20, 42);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'Company name :'));
$pdf->setXY(20, 70);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'For : '));

$pdf->setXY(130, 32);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'Date :')); //. date('d') . '/' . date('m') . '/' . (date('Y') + 543) . ''
$pdf->setXY(130, 42);
$pdf->Cell(0, 1, 'PO No :', 0, 1, 'L');
$pdf->setXY(130, 52);
$pdf->Cell(0, 1, 'Terms of Payment :', 0, 1, 'L');
$pdf->setXY(130, 62);
$pdf->Cell(0, 1, 'Delivery Date :', 0, 1, 'L');
$pdf->Ln(15);

$pdf->Ln();
#$pdf->setXY( 155, 200 );
#$pdf->MultiCell( 0 , 0 , iconv( 'UTF-8','cp874' , 'รวมเงิน' ) );
#$pdf->setXY( 172, 195 );
#$pdf->cell(30,10," ",1,0);

/*Heading Of the table*/
$pdf->Cell(10, 6, 'No.', 1, 0, 'C');
$pdf->Cell(20, 6, 'Part Code', 1, 0, 'C');
$pdf->Cell(85, 6, 'Description', 1, 0, 'C');
$pdf->Cell(25, 6, 'Quantity/Psc', 1, 0, 'C');
$pdf->Cell(25, 6, 'Unit/Price', 1, 0, 'C');
$pdf->Cell(25, 6, 'Amount Baht', 1, 1, 'C'); /*end of line*/
/*Heading Of the table end*/

$query = mysqli_query($con, 'select * from po');
$pdf->SetFont('angsa', '', 12);
$id = 0;
$unitiy_price = 0;
$vat = 0;
$no = 1;
$pdf->SetFont('angsa', '', 14);
while ($data = mysqli_fetch_array($query)) {
    if ($po == $data['PO_NO']) {
        $pdf->Cell(10, 8, $no, 0, 0, 'C');
        $pdf->Cell(20, 8, '', 0, 0, 'R');
        $pdf->MultiCell(85, 8, iconv('UTF-8', 'TIS-620', $data['product']), 0);
        
        //$pdf->line(20, 160,0,160);
        $pdf->Cell(135, -12, iconv('UTF-8', 'TIS-620', $data['pcs']) . ' Pcs.', 'T', 0, 'R');
        $pdf->Cell(25, -12, iconv('UTF-8', 'TIS-620', number_format($data['price_pcs'], 2)), 'T', 0, 'R');
        $pdf->Cell(25, -12, iconv('UTF-8', 'TIS-620', number_format($data['total_price'], 2)), 'T', 0, 'R');
        if ($no == 5) {
            $pdf->AddPage();
			//break;
        }
		$unitiy_price += $data['total_price'];
        $vat = ($unitiy_price * 7) / 100;
		$pdf->Ln(0);
		$no++;
    }
}

$pdf->SetFont('angsa', '', 14);
$pdf->Cell(140, 5, '', 0, 0);
$pdf->Cell(25, 5, 'TOTAL', 1, 0);
$pdf->Cell(25, 5, number_format($unitiy_price, 2), 1, 1, 'R');
//$pdf->Cell(30, 5, number_format($id), 1, 1,'R');

$pdf->Cell(140, 5, '', 0, 0);
$pdf->Cell(25, 5, 'VAT 7%', 1, 0);
$pdf->Cell(25, 5, number_format($vat, 2), 1, 1, 'R');

$sum = $unitiy_price + $vat;
$sum = sprintf('%.2f', $sum);
$pdf->Cell(140, 5, '', 0, 0);
$pdf->Cell(25, 5, 'GRAND TOTAL', 1, 0);
$pdf->Cell(25, 5, number_format($sum, 2), 1, 1, 'R');

$pdf->Cell(0.1, 20, '', 0, 0);
$pdf->Cell(25, -7, iconv('UTF-8', 'TIS-620', 'ตัวหนังสือ(บาท)'), 1, 0);
$pdf->Cell(115, -7, iconv('UTF-8', 'TIS-620', convert($sum)), 1, 1, 'C');

$pdf->SetFont('angsa', '', 14);
$pdf->setXY(10, 210);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'หมายเหตุ : เปิดบิลในนาม'));
$pdf->setXY(25, 215);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'บริษัท โปร คอนเซ็พท์ แมนูแฟคเจอเรอ จำกัด'));
$pdf->setXY(25, 220);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', '88/1 หมู่ 12 ซ.เพชรเกษม 120 ถ.เพชรเกษม ต.อ้อมน้อย อ.กระทุ่มแบน จ.สมุทรสาคร 74130'));
$pdf->setXY(25, 225);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'โทร 0-2431 1862-3 Fax 0-2023 4882'));
$pdf->setXY(25, 230);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'เลขประจำตัวผู้เสียภาษีอากร : 0745550002535'));
$pdf->setXY(25, 235);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'สถานประกอบการที่ต้องระบุ : สำนักงานใหญ่'));

$query = mysqli_query($con, 'select * from po_details');
while ($data = mysqli_fetch_array($query)) {
    if ($po == $data['PO_NO']) {
        $pdf->setXY(20, 258);
        $pdf->MultiCell(0, 0, DateThai($data['date']));
        $pdf->setXY(70, 258);
        $pdf->MultiCell(0, 0, DateThai($data['date']));
        $pdf->setXY(120, 258);
        $pdf->MultiCell(0, 0, DateThai($data['date']));
        $pdf->setXY(170, 258);
        $pdf->MultiCell(0, 0, DateThai($data['date']));
    }
}
$pdf->setXY(10, 253);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', '_______________________'));
$pdf->setXY(22, 263);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'Purchase'));

$pdf->setXY(60, 253);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', '_______________________'));
$pdf->setXY(72, 263);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'Inspector'));

$pdf->setXY(110, 253);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', '_______________________'));
$pdf->setXY(122, 263);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'Review'));

$pdf->setXY(160, 253);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', '_______________________'));
$pdf->setXY(165, 263);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'Authorized/Approved'));

$pdf->SetFont('angsa', '', 12);
$pdf->Cell(190, 0, '', 2, 2);
$pdf->setXY(10, 266);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', '_____________________________________________________________________________________________________________________________________________________'));
$pdf->setXY(20, 271);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', '88/1 หมู่ 12 ซ.เพชรเกษม 120 ถ.เพชรเกษม ต.อ้อมน้อย อ.กระทุ่มแบน จ.สมุทรสาคร 74130 โทร:+66 (0)2431-1862-3 แฟ็กซ์:+66 (0) 2813-4872'));
$pdf->setXY(20, 275);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', '88/1 Mu 12 Soi PhetKasem 120 PhetKasem Road Om-noi Krathum Baen Samut Sakhon 74130 Tel:+66 (0) 2431-1862-3 Fax:+66 (0) 2813-4872'));
$pdf->Output();
exit();
?>
PDF Created Click <a href="./MyPDF/MyPDF.pdf">here</a> to Download

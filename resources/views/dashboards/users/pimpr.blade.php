<?php
require '../pdf/fpdf.php';
$con = mysqli_connect('localhost', 'root', '');
mysqli_select_db($con, 'pcm_project');
//require('../pdf/fpdf.php');

$pdf = new FPDF('P', 'mm', 'A4');
// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวธรรมดา กำหนด ชื่อ เป็น angsana
$pdf->AddFont('angsa', '', 'angsa.php');
// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวหนา  กำหนด ชื่อ เป็น angsana
$pdf->AddFont('angsa', 'B', 'angsab.php');
// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวหนา  กำหนด ชื่อ เป็น angsana
$pdf->AddFont('angsa', 'I', 'angsab.php');
// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวหนา  กำหนด ชื่อ เป็น angsana
$pdf->AddFont('angsa', 'BI', 'angsab.php');
$pdf->AliasNbPages();
//สร้างหน้าเอกสาร
$pdf->AddPage();
$pdf->Ln();
$pdf->Image('../pdf/logo4.jpg', 15, 11, 50, 15, '', 'http://www.pcm-pro-concept.com/');
$pdf->SetFont('angsa', '', 12);

$pdf->Cell(190, 18, '', 1, 1);
$pdf->Cell(190, 41, '', 1, 1);

$pdf->SetFont('angsa', 'B', 25);
$pdf->setXY(80, 17);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'ใบร้องขออนุมัติการจัดซื้อ'));

$pdf->setXY(80, 22);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'Purchasing Requestion '));

$pdf->SetFont('angsa', '', 12);

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

$query = mysqli_query($con, 'select * from pr');
$c = 0;
$page = 0;
while ($data = mysqli_fetch_array($query)) {
    if ($pr == $data['Doc_NO']) {
        $pdf->setXY(172, 13);
        $pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $data['Doc_NO']));
        $pdf->setXY(172, 17);
        $pdf->Cell(0, 0, DateThai($data['date']));
        $page++;
        $pdf->setXY(175, 25.5);
        $pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $page));
        $pdf->SetFont('angsa', '', 14);
        $pdf->setXY(33, 34);
        $pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $data['company_name']));
        $pdf->setXY(33, 44);
        $pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $data['department']));
        $pdf->setXY(120, 44);
        $pdf->Cell(0, 0, DateThai($data['date']));
        $pdf->setXY(60, 54);
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
$pdf->setXY(140, 25);
$pdf->Cell(0, 1, 'Page ', 0, 1, 'C');

$pdf->SetFont('angsa', '', 14);
$pdf->setXY(20, 34);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'ชื่อ :'));
$pdf->setXY(20, 44);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'แผนก :'));
$pdf->setXY(100, 44);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'วันที่ :')); //. date('d') . '/' . date('m') . '/' . (date('Y') + 543) . ''
$pdf->setXY(20, 54);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'เหตุผลในการขออนุมัติซื้อ :'));

$pdf->Ln(15);

$pdf->Ln();

#$pdf->setXY( 155, 200 );
#$pdf->MultiCell( 0 , 0 , iconv( 'UTF-8','cp874' , 'รวมเงิน' ) );
#$pdf->setXY( 172, 195 );
#$pdf->cell(30,10," ",1,0);

/*Heading Of the table*/
$pdf->Cell(10, 6, 'No.', 1, 0, 'C');
$pdf->Cell(75, 6, 'List', 1, 0, 'C');
$pdf->Cell(25, 6, 'Quantity/Psc', 1, 0, 'C');
$pdf->Cell(25, 6, 'Unit/Price', 1, 0, 'C');
$pdf->Cell(25, 6, 'Amount Bant', 1, 0, 'C');
$pdf->Cell(30, 6, 'Note', 1, 1, 'C'); /*end of line*/
/*Heading Of the table end*/
$pdf->SetFont('angsa', '', 14);
$query = mysqli_query($con, 'select * from prmultis');
$query2 = mysqli_query($con, 'select * from pr');
$no = 1;
$b = 0;
$price_pcs = 0;

while ($data = mysqli_fetch_array($query)) {
    if ($pr == $data['Doc_NO']) {
        $pdf->Cell(10, 8, $no, 0);
        $pdf->MultiCell(75, 8, iconv('UTF-8', 'TIS-620', $data['product']), 1, 0);
        $pdf->Cell(100, -8, iconv('UTF-8', 'TIS-620', $data['pcs']), 'T', 0, 'R');
        $pdf->Cell(25, -8, iconv('UTF-8', 'TIS-620', number_format($data['price_pcs'], 2)), 'T', 0, 'R');
        $pdf->Cell(30, -8, iconv('UTF-8', 'TIS-620', number_format($data['total_price'], 2)), 'T', 0, 'R');
        $pdf->Cell(40, -8, iconv('UTF-8', 'TIS-620', $data['note']), 'T', 0, 'C');
        if ($no == 7) {
            $pdf->AddPage();
            //break;
        }
        $price_pcs += $data['total_price'];
        $vat = ($price_pcs * 7) / 107;
        $pdf->Ln(0);
        $no++;
    }
}

$pdf->SetFont('angsa', '', 14);
$pdf->Cell(130, 8, '', 0, 0);
$pdf->Cell(30, 8, 'TOTAL', 0, 0);
$pdf->Cell(30, 8, number_format($price_pcs, 2), 1, 1, 'R');

$query = mysqli_query($con, 'select * from pr');
while ($data = mysqli_fetch_array($query)) {
    if ($pr == $data['Doc_NO']) {
        $pdf->setXY(20, 260);
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
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', '_____________________'));
$pdf->setXY(22, 263);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'Purchase'));

$pdf->setXY(60, 253);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', '_____________________'));
$pdf->setXY(72, 263);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'Inspector'));

$pdf->setXY(110, 253);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', '_____________________'));
$pdf->setXY(122, 263);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'Review'));

$pdf->setXY(160, 253);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', '_____________________'));
$pdf->setXY(165, 263);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'Authorized/Approved'));

$pdf->SetFont('angsa', '', 12);
$pdf->Cell(190, 0, '', 2, 2);
$pdf->setXY(10, 266);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', '___________________________________________________________________________________________________________________________________________________'));
$pdf->setXY(20, 271);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', '88/1 หมู่ 12 ซ.เพชรเกษม 120 ถ.เพชรเกษม ต.อ้อมน้อย อ.กระทุ่มแบน จ.สมุทรสาคร 74130 โทร:+66 (0)2431-1862-3 แฟ็กซ์:+66 (0) 2813-4872'));
$pdf->setXY(20, 275);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', '88/1 Mu 12 Soi PhetKasem 120 PhetKasem Road Om-noi Krathum Baen Samut Sakhon 74130 Tel:+66 (0) 2431-1862-3 Fax:+66 (0) 2813-4872'));
$pdf->Output();
exit();
?>
PDF Created Click <a href="./MyPDF/MyPDF.pdf">here</a> to Download

<?php
// Include the FPDF library
require('../FPDF/fpdf.php');
include '../dbconfig.php';


// Get the donor ID from the AJAX request
$patient_id = $_GET['patient_id'];

$patientname = $_GET['patient_name'];
$today = new DateTime();

// Create a new PDF document
$pdf = new FPDF();

// Add a new page
$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
    
$logo = "../dist/img/Obbs logo.png";
$stamp = "../dist/img/stamp.png";
$pdf->Image($logo, 90, $pdf->GetY()+1 ,30);
$pdf->Ln(32);
$pdf->SetFont('Times','B',15);
$pdf->cell(200,5,'ONLINE BLOOD BANK SYSTEM',0,1,'C');
$pdf->SetFont('Times', 'i', 14); // set font for subtitle
$pdf->Cell(0, 10, 'Donate Life-Save Lives: Give Blood at Your Local Blood Bank!', 0, 1, 'C'); // subtitle
$pdf->Ln(5);


$pdf->SetFont('Times', 'B', 12);

// Set font and font size
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20, 10, "Patient:", 0, 0, 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40, 10, strtoupper($patientname), 0, 0);
$pdf->Cell(100, 10, "Generation Date:", 0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(20, 10, $today->format('Y-m-d') , 0, 1,'R');
$pdf->Ln(1.5);

if($_GET['action'] == 'patient-history'){
    // Build the SQL query
    $sql = "SELECT patient_appeal.id, patient_appeal.`app_date`, patient_appeal.`units`, patient_appeal.`app_status`, patient_appeal.`comment`,
            blood_bank.`bank_name`, blood_bank.`address`, blood_bank.`email`, blood_bank.`phone`,
            blood_type.`b_name`
            FROM patient_appeal LEFT OUTER JOIN blood_bank ON patient_appeal.`bank_id` = blood_bank.`id`
            JOIN blood_type ON patient_appeal.`blood_id` = blood_type.`id`
            WHERE patient_appeal.`patient_id` = $patient_id
            ORDER BY patient_appeal.`app_date` DESC";
    
    // Prepare a select statement
    $stmt = mysqli_prepare($conn, $sql);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Bind the result variables
    mysqli_stmt_bind_result($stmt, $id, $appdate, $units, $appstatus, $comment, $bankname,$bankaddress, $bankmail, $bankphone, $bloodname);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 10, 'PATIENT APPLICATION HISTORY', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(10,10,'#',1,0);
$pdf->Cell(30,10,'Date',1,0);
$pdf->Cell(40,10,'Bank Name',1,0);
$pdf->Cell(30,10,'Blood Type',1,0);
$pdf->Cell(30,10,'Quantity',1,0);
$pdf->Cell(50,10,'status',1,1);
$pdf->SetFont('Arial','',9);
    
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(10,10,$count,1,0);
  $pdf->Cell(30,10,$appdate,1,0);
  $pdf->Cell(40,10,$bankname,1,0);
  $pdf->Cell(30,10,$bloodname,1,0);
  $pdf->Cell(30,10,$units,1,0);
  $pdf->Cell(50,10,getStatus($appstatus),1,1);
  $count++;
  // Close the statement and database connection
//   mysqli_stmt_close($stmt);
}
$pdf->Ln(10);
    // Build the SQL query
    $sql = "   SELECT transfusion.`pouch_id`, transfusion.`trans_date`, patient_appeal.`units`,blood_bank.`bank_name`,blood_type.`b_name`, pouch.`units`   
                FROM transfusion LEFT OUTER JOIN patient_appeal ON patient_appeal.`id` = transfusion.`app_id`
                JOIN pouch ON pouch.id = transfusion.`pouch_id`
                JOIN blood_type ON blood_type.`id` = pouch.`blood_id`
                JOIN blood_bank ON blood_bank.id = transfusion.`bank_id`
                WHERE patient_appeal.`patient_id` = $patient_id
                ORDER BY transfusion.`trans_date` DESC";
    
    // Prepare a select statement
    $stmt = mysqli_prepare($conn, $sql);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Bind the result variables
    mysqli_stmt_bind_result($stmt, $pouch_id, $transferdate, $requnits, $bank_name, $blood_name, $deliveredunits);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 10, 'PATIENT TRANSFUSION HISTORY', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(10,10,'#',1,0);
$pdf->Cell(30,10,'Transfer Date',1,0);
$pdf->Cell(40,10,'Bank Name',1,0);
$pdf->Cell(25,10,'Blood Type',1,0);
$pdf->Cell(30,10,'Requested Units',1,0);
$pdf->Cell(30,10,'Delivered units',1,0);
$pdf->Cell(25,10,'Pouch Code',1,1);
$pdf->SetFont('Arial','',9);
    
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(10,10,$count,1,0);
  $pdf->Cell(30,10,$transferdate,1,0);
  $pdf->Cell(40,10,$bank_name,1,0);
  $pdf->Cell(25,10,$blood_name,1,0);
  $pdf->Cell(30,10,$requnits,1,0);
  $pdf->Cell(30,10,$deliveredunits,1,0);
  $pdf->Cell(25,10,$pouch_id,1,1);
  $count++;
  // Close the statement and database connection
//   mysqli_stmt_close($stmt);
}
$pdf->Ln(30);
$pdf->Image($stamp, 70, $pdf->GetY()-10 ,60);
$pdf->Cell(100, 10, '-------------------------------------------------------', 0, 0,'C');
$pdf->Cell(50, 10, '--------------------------------------------------------', 0, 1,'C');
$pdf->SetFont('Times','BI',12);
$pdf->Cell(100, 10, 'Signature', 0, 0,'C');
$pdf->Cell(50, 10, 'Date', 0, 1,'C');
}
function getStatus($appstatus) {
    if($appstatus == 0){ 
        return "Pending";
      }else if($appstatus == 1){
        return "Approved Pending Transfer";
      }else if($appstatus == 2){
        return "Rejected";
      }else if($appstatus == 3){
        return "Cancelled";
      }else{
        return "Transfer Completed";
      }   
  }
// Output the PDF document
$pdf->Output();
?>
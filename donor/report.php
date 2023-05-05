
<?php
// Include the FPDF library
require('../FPDF/fpdf.php');
include '../dbconfig.php';

if(isset($_GET['action'])){
// Get the donor ID from the AJAX request
$donor_id = $_GET['donor_id'];

$donorname = $_GET['donor_name'];
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
$pdf->Cell(20, 10, "Donor:", 0, 0, 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40, 10, $donorname, 0, 0);
$pdf->Cell(100, 10, "Generation Date:", 0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(20, 10, $today->format('Y-m-d') , 0, 1,'R');
$pdf->Ln(1.5);


if( $_GET['action'] == 'donor-application'){
    // Build the SQL query
    $sql = "SELECT donor_donation.`id`, donor_donation.`req_date`, donor_donation.`don_status`, donor_donation.`comment`,
              blood_bank.`bank_name`, blood_bank.`email`, blood_bank.`phone`
              FROM donor_donation
              LEFT OUTER JOIN blood_bank ON donor_donation.`bank_id` = blood_bank.`id`
              JOIN donor ON donor_donation.`donor_id` = donor.`id`
              WHERE donor_donation.`donor_id` = $donor_id
              ORDER BY req_date DESC";
    
    // Prepare a select statement
    $stmt = mysqli_prepare($conn, $sql);
    
    // Execute the statement
    mysqli_stmt_execute($stmt);
    
    
    // Bind the result variables
    mysqli_stmt_bind_result($stmt, $id, $reqdate, $donationstatus, $comment, $bankname, $bankmail, $bankphone);

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Donation Applications', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(20,10,'#',1,0);
$pdf->Cell(40,10,'Bank Name',1,0);
$pdf->Cell(40,10,'Request Date',1,0);
$pdf->Cell(40,10,'Contact Info',1,0);
$pdf->Cell(50,10,'Donation Status',1,1);
$pdf->SetFont('Arial','',9);
    
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(20,10,$count,1,0);
  $pdf->Cell(40,10,$bankname,1,0);
  $pdf->Cell(40,10,$reqdate,1,0);
  $pdf->Cell(40,10,$bankmail,1,0);
  $pdf->Cell(50,10,getStatus($donationstatus),1,1);
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

else if($_GET['action'] == 'donor-donations'){
    // Build the SQL query
    $sql = " SELECT donor_donation.`id`, donor_donation.`don_date`,donor_donation.`quantity`,
    blood_bank.`bank_name`, blood_bank.`email`, blood_bank.`phone`, blood_type.`b_name`, pouch.`id`
    FROM donor_donation LEFT OUTER JOIN blood_bank ON donor_donation.`bank_id` = blood_bank.`id`
    JOIN donor ON donor_donation.`donor_id` = donor.`id`
    JOIN pouch ON pouch.`donation_id` = donor_donation.`id` 
    JOIN blood_type ON blood_type.`id` = donor.`blood_id`
    WHERE donor_donation.`donor_id` = $donor_id AND don_status = 4 ";
    
    // Prepare a select statement
    $stmt = mysqli_prepare($conn, $sql);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Bind the result variables
    mysqli_stmt_bind_result($stmt, $id, $dondate, $quantity, $bankname, $bankmail, $bankphone, $bloodname, $pouch);

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Donation History', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(10,10,'#',1,0);
$pdf->Cell(40,10,'Donation Date',1,0);
$pdf->Cell(40,10,'Bank Name',1,0);
$pdf->Cell(30,10,'Blood Type',1,0);
$pdf->Cell(30,10,'Quantity',1,0);
$pdf->Cell(40,10,'Pouch Code',1,1);
$pdf->SetFont('Arial','',9);
    
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(10,10,$count,1,0);
  $pdf->Cell(40,10,$dondate,1,0);
  $pdf->Cell(40,10,$bankname,1,0);
  $pdf->Cell(30,10,$bloodname,1,0);
  $pdf->Cell(30,10,$quantity,1,0);
  $pdf->Cell(40,10,"#$pouch",1,1);
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

}
function getStatus($donationstatus) {
    if($donationstatus == 0){ 
      return "Pending Approval";
    } else if($donationstatus == 1){
      return "Pending Donation";
    } else if($donationstatus == 2){
      return "Donation Denied";
    } else if($donationstatus == 3){
      return "Donation Cancelled";
    } else{
      return "Donation Completed";
    }
  }
// Output the PDF document
$pdf->Output();
?>
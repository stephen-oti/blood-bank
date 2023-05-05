
<?php
// Include the FPDF library
require('../FPDF/fpdf.php');
include '../dbconfig.php';
session_start();
// Create a new PDF document
$pdf = new FPDF();

if(isset($_GET['action']) && isset($_SESSION['bank_id'])){
    // Get the donor ID from the AJAX request
    $bank_id = $_SESSION['bank_id'];
    $today = new DateTime();
    // Retrieve the patient details from the database using prepared statements
    $sql = "SELECT * FROM blood_bank WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $bank_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the results and store the patient details in a variable
    if ($row = mysqli_fetch_assoc($result)) {
    $bank_details = $row;
    }

// Close the statement and database connection
mysqli_stmt_close($stmt);
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
$pdf->SetFont('Times','B',12);
$pdf->cell(200,10,'BLOOD BANK REPORTS',0,1,'C');
$pdf->Ln(5);


$pdf->SetFont('Times', 'B', 12);

// Set font and font size
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20, 10, "Blood Bank: ". strtoupper($bank_details['bank_name']), 0, 0, 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(140, 10, "Generated on:", 0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(20, 10, $today->format('Y-m-d') , 0, 1,'R');

$pdf->SetFont('Times','B',9);
$pdf->Cell(20, 5, "Address: ". trim($bank_details['address']), 0, 0, 'L');
$pdf->Cell(160, 5, "Mail: ". $bank_details['email'], 0, 1, 'R');
$pdf->Cell(20, 5, "County: ". $bank_details['county'], 0, 0, 'L');
$pdf->Cell(160, 5, "Phone:  ". $bank_details['phone'], 0, 1, 'R');

$pdf->Ln(1.5);


if( $_GET['action'] == 'bank-donations'){
    // Build the SQL query
    $sql = "SELECT donor_donation.`don_date`, donor.`fname`, donor.`lname`, donor.`email`, donor.`phone`, blood_type.`b_name`, pouch.`id`
            FROM donor_donation LEFT OUTER JOIN donor ON donor_donation.`donor_id` = donor.`id`
            JOIN blood_type ON donor.`blood_id` = blood_type.`id`
            JOIN pouch ON pouch.`donation_id` = donor_donation.`id`
            WHERE donor_donation.`don_status` = 4 AND donor_donation.`bank_id`= $bank_id";

    // Prepare a select statement
    $stmt = mysqli_prepare($conn, $sql);
          
    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Bind the result variables
    mysqli_stmt_bind_result($stmt, $don_date, $don_fname, $don_lname, $don_mail, $don_phone, $don_blood, $don_pouch);

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Donations', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(10,10,'#',1,0);
$pdf->Cell(30,10,'Donation Date',1,0);
$pdf->Cell(50,10,'Donor Name',1,0);
$pdf->Cell(40,10,'Contact Info',1,0);
$pdf->Cell(30,10,'Blood Type',1,0);
$pdf->Cell(30,10,'Blood Pouch',1,1);
$pdf->SetFont('Arial','',9);
    
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(10,10,$count,1,0);
  $pdf->Cell(30,10,$don_date,1,0);
  $pdf->Cell(50,10,$don_fname." ".$don_lname,1,0);
  $pdf->Cell(40,10,$don_mail,1,0);
  $pdf->Cell(30,10,$don_blood,1,0);
  $pdf->Cell(30,10,"#".$don_pouch,1,1);
  $count++;
  // Close the statement and database connection
//   mysqli_stmt_close($stmt);
}
}

else if($_GET['action'] == 'patient-transfusions'){
    // Build the SQL query
    $sql = "SELECT transfusion.`trans_date`, transfusion.`pouch_id`, 
            patient.`fname`, patient.lname, patient.`email`, patient.`phone`,
            blood_type.`b_name`
            FROM transfusion LEFT OUTER JOIN patient_appeal ON patient_appeal.`id` = transfusion.`app_id`
            JOIN patient ON patient.`id` = patient_appeal.`patient_id`
            JOIN blood_type ON blood_type.`id` = patient_appeal.`blood_id`
            WHERE patient_appeal.`app_status` = 4 AND transfusion.`bank_id` = $bank_id";
  
    // Prepare a select statement
    $stmt = mysqli_prepare($conn, $sql);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Bind the result variables
    mysqli_stmt_bind_result($stmt, $app_date, $pat_pouch, $pat_fname, $pat_lname, $pat_mail, $pat_phone, $pat_blood);

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Patient Transfusions', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(10,10,'#',1,0);
$pdf->Cell(30,10,'Transfusion Date',1,0);
$pdf->Cell(50,10,'Patient Name',1,0);
$pdf->Cell(40,10,'Contact Info',1,0);
$pdf->Cell(30,10,'Blood Type',1,0);
$pdf->Cell(30,10,'Blood Pouch',1,1);
$pdf->SetFont('Arial','',9);
    
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(10,10,$count,1,0);
  $pdf->Cell(30,10,$app_date,1,0);
  $pdf->Cell(50,10,$pat_fname." ".$pat_lname,1,0);
  $pdf->Cell(40,10,$pat_mail,1,0);
  $pdf->Cell(30,10,$pat_blood,1,0);
  $pdf->Cell(30,10,"#".$pat_pouch,1,1);
  $count++;
  // Close the statement and database connection
//   mysqli_stmt_close($stmt);
  }
}else if($_GET['action'] == 'bank-transfers'){
  // Build the SQL query
  $sql = "SELECT transfer.trans_date, transfer.appr_bank, transfer.req_bank, transfer.pouch_id ,pouch.units, inter_bank.quantity, blood_type.b_name,
          (SELECT bank_name FROM blood_bank WHERE id = transfer.appr_bank),
          (SELECT email FROM blood_bank WHERE id = transfer.appr_bank),
          (SELECT phone FROM blood_bank WHERE id = transfer.appr_bank),
          blood_bank.bank_name AS req_bank_name, blood_bank.email AS req_bank_mail, blood_bank.phone AS req_bank_phone
          FROM transfer
          LEFT OUTER JOIN inter_bank ON inter_bank.id = transfer.`inter_bank_id`
          JOIN pouch ON pouch.id = transfer.`pouch_id`
          JOIN blood_type ON blood_type.id = pouch.blood_id
          JOIN blood_bank ON blood_bank.id = transfer.`req_bank`
          WHERE (transfer.appr_bank = $bank_id OR transfer.req_bank = $bank_id) AND inter_bank.req_status = 1";

  // Prepare a select statement
  $stmt = mysqli_prepare($conn, $sql);
            
  // Execute the statement
  mysqli_stmt_execute($stmt);

  // Bind the result variables
  mysqli_stmt_bind_result($stmt, $trans_date, $appr_bank, $req_bank, $pouch_id, $units, $requested_qty, $blood_name,$appr_bank_name, $appr_bank_mail, $appr_bank_phone, $bank_name,$bank_mail, $bank_phone);

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Bank Transfers', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(10,10,'#',1,0);
$pdf->Cell(20,10,'Date',1,0);
$pdf->Cell(20,10,'Type',1,0);
$pdf->Cell(50,10,'Bank Name',1,0);
$pdf->Cell(40,10,'Contact',1,0);
$pdf->Cell(30,10,'Blood Type',1,0);
$pdf->Cell(20,10,'Pouch',1,1);
$pdf->SetFont('Arial','',9);
  
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(10,10,$count,1,0);
  $pdf->Cell(20,10,$trans_date,1,0);
  $pdf->Cell(20,10,($req_bank == $bank_id)?"Incoming":"Outgoing",1,0);
  $pdf->Cell(50,10,($req_bank == $bank_id)?"$appr_bank_name":"$bank_name",1,0);
  $pdf->Cell(40,10,($req_bank == $bank_id)?"$appr_bank_mail":"$bank_mail",1,0);
  $pdf->Cell(30,10,$blood_name,1,0);
  $pdf->Cell(20,10,$pouch_id,1,1);
$count++;
// Close the statement and database connection
//   mysqli_stmt_close($stmt);
}
}else if($_GET['action'] == 'patient-appeals'){
  // Build the SQL query
  $sql = "SELECT patient_appeal.`app_date`, patient_appeal.`units`, patient_appeal.`app_status`,
          patient.`fname`, patient.`lname`,patient.`email`, blood_type.`b_name`
          FROM patient_appeal LEFT OUTER JOIN patient ON patient_appeal.`patient_id` = patient.`id`
          JOIN blood_type ON blood_type.`id` = patient_appeal.`blood_id`
          WHERE patient_appeal.`bank_id` = $bank_id
          ORDER BY patient_appeal.`app_date` DESC";

  // Prepare a select statement
  $stmt = mysqli_prepare($conn, $sql);
            
  // Execute the statement
  mysqli_stmt_execute($stmt);

  // Bind the result variables
  mysqli_stmt_bind_result($stmt, $appeal_date,$appeal_units, $appeal_status, $patient_fname, $patient_lname, $patient_mail, $pat_blood_name);

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Patient Requests', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(10,10,'#',1,0);
$pdf->Cell(20,10,'Date',1,0);
$pdf->Cell(50,10,'Patient Name',1,0);
$pdf->Cell(40,10,'Contact',1,0);
$pdf->Cell(30,10,'Blood Type',1,0);
$pdf->Cell(20,10,'Quantity',1,0);
$pdf->Cell(20,10,'Status',1,1);
$pdf->SetFont('Arial','',9);
  
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(10,10,$count,1,0);
  $pdf->Cell(20,10,$appeal_date,1,0);
  $pdf->Cell(50,10,$patient_fname." ".$patient_lname,1,0);
  $pdf->Cell(40,10,$patient_mail,1,0);
  $pdf->Cell(30,10,$pat_blood_name,1,0);
  $pdf->Cell(20,10,$appeal_units,1,0);
  $pdf->Cell(20,10,getStatus($appeal_status),1,1);
$count++;
// Close the statement and database connection
//   mysqli_stmt_close($stmt);
}
}else if($_GET['action'] == 'donor-donations'){
  // Build the SQL query
  $sql = "SELECT donor_donation.`req_date`,  donor_donation.`don_type`,donor_donation.`don_status`,
          donor.`fname`, donor.`lname`, donor.`email`, blood_type.`b_name`
          FROM donor_donation 
          LEFT OUTER JOIN donor ON donor_donation.`donor_id` = donor.`id`
          JOIN blood_type ON donor.`blood_id` = blood_type.`id`
          WHERE donor_donation.`bank_id` = $bank_id";

  // Prepare a select statement
  $stmt = mysqli_prepare($conn, $sql);
            
  // Execute the statement
  mysqli_stmt_execute($stmt);

  // Bind the result variables
  mysqli_stmt_bind_result($stmt, $req_date, $don_type, $don_status, $don_fname, $don_lname, $don_mail, $don_blood_name);

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Donation Requests', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(10,10,'#',1,0);
$pdf->Cell(20,10,'Date',1,0);
$pdf->Cell(27,10,'Donation Type',1,0);
$pdf->Cell(50,10,'Donor Name',1,0);
$pdf->Cell(40,10,'Contact',1,0);
$pdf->Cell(20,10,'Blood',1,0);
$pdf->Cell(23,10,'Status',1,1);
$pdf->SetFont('Arial','',9);
  
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(10,10,$count,1,0);
  $pdf->Cell(20,10,$req_date,1,0);
  $pdf->Cell(27,10,($don_type == 0)? "Bank Appeal":"Nearby Bank",1,0);
  $pdf->Cell(50,10,$don_fname." ".$don_lname,1,0);
  $pdf->Cell(40,10,$don_mail,1,0);
  $pdf->Cell(20,10,$don_blood_name,1,0);
  $pdf->Cell(23,10,getStatus($don_status),1,1);
$count++;
// Close the statement and database connection
//   mysqli_stmt_close($stmt);
}
}

else if($_GET['action'] == 'bank-blood'){
  // Build the SQL query
  $sql = "SELECT pouch.`id`, pouch.`fill_date`, (35 - (DATEDIFF(NOW(), fill_date))) AS rem_days, pouch.`units`, pouch.`pouch_status`, donor.`fname`, donor.`lname`, blood_type.`b_name` 
          FROM  pouch
          LEFT OUTER JOIN donor ON pouch.`donor_id` = donor.`id`
          JOIN blood_type ON pouch.`blood_id` = blood_type.`id`
          WHERE pouch.`bank_id` = $bank_id
          ORDER BY fill_date ASC";

  // Prepare a select statement
  $stmt = mysqli_prepare($conn, $sql);
            
  // Execute the statement
  mysqli_stmt_execute($stmt);

  // Bind the result variables
  mysqli_stmt_bind_result($stmt, $pouch_code, $fill_date, $rem_days, $pouch_units, $pouch_status, $don_fname, $don_lname, $blood_name);

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, 'Blood Inventory', 0, 1, 'C');
$pdf->Ln(1.5);
$pdf->SetFont('Arial','B',10);

// Add table headers to the PDF
$pdf->Cell(10,10,'#',1,0);
$pdf->Cell(20,10,'Fill Date',1,0);
$pdf->Cell(20,10,'Code',1,0);
$pdf->Cell(50,10,'Donor',1,0);
$pdf->Cell(40,10,'Blood',1,0);
$pdf->Cell(20,10,'Units',1,0);
$pdf->Cell(30,10,'Status',1,1);
$pdf->SetFont('Arial','',9);
  
// Loop through the results and add table rows to the PDF
$count = 1;
while (mysqli_stmt_fetch($stmt)) {
  $pdf->Cell(10,10,$count,1,0);
  $pdf->Cell(20,10,$fill_date,1,0);
  $pdf->Cell(20,10,$pouch_code,1,0);
  $pdf->Cell(50,10,$don_fname." ".$don_lname,1,0);
  $pdf->Cell(40,10,$blood_name,1,0);
  $pdf->Cell(20,10,$pouch_units,1,0);
  $pdf->Cell(30,10,($rem_days <= 0 && $pouch_status == 1)?"Expired":bloodStatus($pouch_status),1,1);
$count++;
// Close the statement and database connection
//   mysqli_stmt_close($stmt);
}
}

$pdf->Ln(30);
$pdf->Image($stamp, 70, $pdf->GetY()-10 ,60);
$pdf->Cell(100, 10, '-------------------------------------------------------', 0, 0,'C');
$pdf->Cell(50, 10, '--------------------------------------------------------', 0, 1,'C');
$pdf->SetFont('Times','BI',12);

$pdf->Cell(100, 10, 'Signature', 0, 0,'C');


$pdf->Cell(50, 10, 'Date', 0, 1,'C');

}
function getStatus($status) {
    if($status == 0){ 
      return "Pending";
    } else if($status == 1){
      return "Approved";
    } else if($status == 2){
      return "Dissapproved";
    } else if($status == 3){
      return "Cancelled";
    } else{
      return "Completed";
    }
  }
  function bloodStatus($status) {
    if($status == 1){
      return "Active";
    } else if($status == 2){
      return "Removed";
    } else if($status == 3){
      return "Transfused";
    } else{
      return "Transfered";
    }
  }
// Output the PDF document
$pdf->Output();
?>